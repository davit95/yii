<?php

namespace service\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\base\Exception;

/**
 * Model for statistic data
 */
class StatisticalData extends ActiveRecord
{
    const SCENARIO_CREATE = 'CREATE';
    const SCENARIO_UPDATE = 'UPDATE';
    const SCENARIO_DELETE = 'DELETE';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%statistical_data}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Statistic id',
            'statistical_data_set_id' => 'Statistic data set id',
            'attr_1_val' => 'Attribute 1 value',
            'attr_2_val' => 'Attribute 1 value',
            'attr_3_val' => 'Attribute 1 value',
            'attr_4_val' => 'Attribute 1 value',
            'attr_5_val' => 'Attribute 1 value',
            'timestamp' => 'Timestamp'
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
            ['statistical_data_set_id', 'required'],
            ['statistical_data_set_id', 'exist', 'targetClass' => StatisticalDataSet::className(), 'targetAttribute' => 'id'],
            ['attr_1_val', 'string', 'min' => 1, 'max' => 500],
            ['attr_2_val', 'string', 'min' => 1, 'max' => 500],
            ['attr_3_val', 'string', 'min' => 1, 'max' => 500],
            ['attr_4_val', 'string', 'min' => 1, 'max' => 500],
            ['attr_5_val', 'string', 'min' => 1, 'max' => 500],
            ['timestamp', 'number', 'min' => 0],
            ['timestamp', 'default', 'value' => function ($model, $attribute) {
                return time();
            }],
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
            'attrVal1' => 'attr_1_val',
            'attrVal2' => 'attr_2_val',
            'attrVal3' => 'attr_3_val',
            'attrVal4' => 'attr_4_val',
            'attrVal5' => 'attr_5_val',
            'timestamp' => 'timestamp'
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['statistical_data_set_id', 'attr_1_val', 'attr_2_val', 'attr_3_val', 'attr_4_val', 'attr_5_val', 'timestamp'],
            self::SCENARIO_UPDATE => ['id', 'statistical_data_set_id', 'attr_1_val', 'attr_2_val', 'attr_3_val', 'attr_4_val', 'attr_5_val'],
            self::SCENARIO_DELETE => ['id'],
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
     * Returns data for given statistical index
     *
     * Returns data for given statistical index.
     * Allows to get statistical data for given period of time and applying filters.
     * IMPORTANT: [[filter]] should be an array containing conditions in format ['field' => 'value']
     * other formats are currently not supported.
     *
     * @param StatisticalIndex $index statistical index
     * @param string $dateFrom start date
     * @param string $dateTo end date
     * @param array $filter additional filters
     * @return array
     */
    public static function getStatistic(StatisticalIndex $index, $dateFrom = null, $dateTo = null, $filter = [], $offset = 0, $limit = 0)
    {
        $query = $index->getQuery();

        //Set date range
        $tmFrom = ($dateFrom !== null) ? Yii::$app->formatter->asTimestamp($dateFrom) : null;
        $tmTo = ($dateTo !== null) ? Yii::$app->formatter->asTimestamp($dateTo) : null;

        if (($tmFrom == $tmTo) && $tmFrom !== null && $tmTo !== null) {
            $tmTo += 86340;
        }

        if ($tmFrom !== null) {
            $query->andWhere(['>=', 'timestamp', $tmFrom]);
        }
        if ($tmTo !== null) {
            $query->andWhere(['<=', 'timestamp', $tmTo]);
        }

        if ($offset > 0) {
            $query->offset($offset);
        }
        if ($limit > 0) {
            $query->limit($limit);
        }

        //Apply filters
        if (is_array($filter) && !empty($filter)) {
            $dataSetAttrs = $index->statisticalDataSet->getAttributesAsArray();
            $dataSetAttrsMap = array_flip($dataSetAttrs);

            foreach ($filter as $cond) {
                if (is_array($cond) && !empty($cond)) {
                    $attr = array_keys($cond)[0];
                    $value = $cond[$attr];

                    if (in_array($attr, $dataSetAttrs)) {
                        $index = $dataSetAttrsMap[$attr] + 1;
                        $name = "attr_{$index}_val";

                        $query->andWhere([$name => $value]);
                    }
                }
            }
        }

        return $query->all();
    }

    /**
     * Batch add statistical data
     *
     * Allows to batch add statistical data.
     * [[$data]] elements should be an array.
     * [[$data]] element SHOULD contain element with index _data_set
     * which defines to which dataset this data belongs and _timestamp
     * which defines time when data was added.
     *
     * @param  array $data
     * @return boolean
     */
    public static function batchAdd($data)
    {
        if (empty($data)) {
            return false;
        }

        $command = Yii::$app->db->createCommand();

        $fields = ['statistical_data_set_id', 'attr_1_val', 'attr_2_val', 'attr_3_val', 'attr_4_val', 'attr_5_val', 'timestamp'];
        $values = [];

        $attrs = ['attr_1_val', 'attr_2_val', 'attr_3_val', 'attr_4_val', 'attr_5_val'];

        foreach ($data as $statData) {
            if (!isset($statData['_data_set']) || !isset($statData['_timestamp'])) {
                continue;
            }

            $value = [];
            $value[] = $statData['_data_set'];
            foreach ($attrs as $attr) {
                if (isset($statData[$attr])) {
                    $value[] = $statData[$attr];
                } else {
                    $value[] = null;
                }
            }
            $value[] = $statData['_timestamp'];
            $values[] = $value;
        }

        return $command->batchInsert(self::tableName(), $fields, $values)->execute();
    }
}
