<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Model for unrestrain download links
 */
class UnrestrainLinksForm extends Model
{
    public $links;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'links' => 'Links list',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['links', 'required'],
            ['links', 'string', 'min' => 1],
        ];
    }

    /**
     * Returns array of links to be unrestrained or false on error
     *
     * @return array|boolean
     */
    public function prepareData()
    {
        if ($this->validate()) {
            $links = explode("\n", $this->links);
            foreach ($links as $key => &$link) {
                $link = trim($link);
                if (empty($link)) {
                    unset($links[$key]);
                }
            }
            return $links;
        } else {
            return false;
        }
    }
}
