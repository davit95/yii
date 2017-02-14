<?php

namespace frontend\models;

use Yii;

class Meta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%meta}}';
    }

	public function getPage() {
		return $this->hasOne(Page::className(), ['page_id' => 'id']);
	}

}
