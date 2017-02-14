<?php

namespace service\models;

use Yii;
use yii\db\Query;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\base\Exception;

/**
 * Model for statistic index
 */
class StatisticalIndex extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%statistical_indexes}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Statistical index id',
            'statistic_data_set_id' => 'Statistical data set id',
            'name' => 'Name',
            'attributes' => 'Attributes',
            'description' => 'Description'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'required'],
            ['id', 'exist', 'targetClass' => static::className(), 'targetAttribute' => 'id'],
            ['statistic_data_set_id', 'required'],
            ['statistic_data_set_id', 'exist', 'targetClass' => StatisticalDataSet::className(), 'targetAttribute' => 'id'],
            ['name', 'required'],
            ['name', 'string', 'min' => 1, 'max' => 100],
            ['attributes', 'required'],
            ['attributes', 'string', 'min' => 1, 'max' => 500],
            ['description', 'required'],
            ['description', 'string', 'min' => 1, 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id' => 'id',
            'statisticalDataSetId' => 'statistical_data_set_id',
            'name' => 'name',
            'attributes' => [$this, 'getAttributesAsArray'],
            'description' => 'description'
        ];
    }

    /**
     * Returns statistic data set
     *
     * @return service\models\StatisticDataSet
     */
    public function getStatisticalDataSet()
    {
        return $this->hasOne(StatisticalDataSet::className(), ['id' => 'statistical_data_set_id']);
    }

    /**
     * Returns attributes as array
     *
     * @return array
     */
    public function getAttributesAsArray()
    {
        $attributes = @unserialize($this->attributes);

        if ($attributes === false) {
            return [];
        }

        return $attributes;
    }

    /**
     * Returns SQL statement which is used to get data.
     *
     * Attributes example:
     *
     * ```php
     * [
     * 		[
     * 			'name' => 'attribute1',
     * 			'aggr' => 'AVG'
     * 		],
     * 		...
     * 		[
     * 			'name' => 'attribute2',
     * 			'aggr' => 'SUM',
     * 		],
     * 		...
     * 		[
     * 			'name' => 'attribute3',
     * 			'group' => true,
     * 			'alias' => 'attr3'
     * 		]
     * ]
     * ```
     *
     * @return array
     */
    public function getQuery()
    {
        $attrs = $this->getAttributesAsArray();

        $dataSetAttrs = $this->statisticalDataSet->getAttributesAsArray();
        $dataSetAttrsMap = array_flip($dataSetAttrs);

        $select = array();
        $group = array();

        //Prepare attributes
        foreach ($attrs as $attr) {
             if (!isset($attr['name'])) {
                 continue;
             }

             $name = $attr['name'];
             $alias = (isset($attr['alias'])) ? $attr['alias'] : $attr['name'];
             $alias = Yii::$app->db->quoteColumnName($alias);

             if (in_array($name, $dataSetAttrs)) {
                 $index = $dataSetAttrsMap[$name] + 1;
                 $name = "attr_{$index}_val";

                 if (isset($attr['aggr'])) {
                     $select[] = new Expression("{$attr['aggr']}({$name}) AS {$alias}");
                 } else {
                     $select[] = "{$name} AS {$alias}";
                 }

                 if (isset($attr['group']) && $attr['group']) {
                     $group[] = $name;
                 }
             } else if ($name == 'timestamp') {
                 if (isset($attr['aggr'])) {
                     $select[] = new Expression("FROM_UNIXTIME({$attr['aggr']}({$name})) AS {$alias}");
                 } else {
                     $select[] = new Expression("FROM_UNIXTIME({$name}) AS {$alias}");
                 }
             }
        }

        $query = new Query();
        $query->select($select);
        $query->from(StatisticalData::tableName());
        $query->where(['statistical_data_set_id' => $this->statistical_data_set_id]);
        $query->groupBy($group);

        return $query;
    }

    /**
     * Returns statistical index by name
     *
     * @return service\models\StatisticalIndex|null
     */
    public static function findByName($name)
    {
        return static::find()->where(['name' => $name])->one();
    }
}
