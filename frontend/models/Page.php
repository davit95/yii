<?php

namespace frontend\models;
use frontend\models\Meta;
use Yii;

class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pages}}';
    }

    public function getMeta()
    {
        return $this->hasMany(Meta::className(), ['page_id' => 'id']);
    }

}
