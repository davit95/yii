<?php

namespace service\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Model for statistic data sets
 *
 * Model for statistic data sets.
 * Attributes property is list of attributes separated by comma (attr1,attr2,...).
 */
class StatisticalDataSet extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%statistical_data_sets}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Statistical index id',
            'name' => 'Name',
            'attributes' => 'Attributes',
            'description' => 'Description',
            'status' => 'Status'
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
            'name' => 'name',
            'attributes' => 'attributes',
            'description' => 'description'
        ];
    }

    /**
     * Returns statistical data set by id
     *
     * @param  string $name
     * @return service\models\StatisticalDataSet
     */
    public static function findByName($name)
    {
        return static::find()->where(['name' => $name])->one();
    }

    /**
     * Returns attributes as array
     *
     * @return array
     */
    public function getAttributesAsArray()
    {
        $attributes = explode(',', $this->attributes);

        if ($attributes === false) {
            return [];
        }

        return $attributes;
    }
}
