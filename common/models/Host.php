<?php

namespace common\models;

use Yii;
use yii\helpers\Url;
use yii\db\ActiveRecord;

/**
 * Model for hosts
 */
class Host extends ActiveRecord
{
    const DATA_DIR = 'data/hosts';

    const LOGO_NORMAL = 'normal';
    const LOGO_SMALL = 'small';
    const LOGO_LARGE = 'large';
    const LOGO_MONOCHROME = 'mono';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hosts}}';
    }
    /**
    * @inheritdoc
    */
    
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at']
                ]
            ],
        ];
    }

    /**
     * Returns popular hosts
     *
     * @param  int $limit limit of hosts returned
     * @return Host[]
     */
    public static function getPopular($limit = 0)
    {
        //TODO: Determinate host popularity
        $hosts = static::find();
        if ($limit > 0) {
            $hosts->limit($limit);
        }
        return $hosts->all();
    }

    /**
     * Returns hosts which has set limit
     *
     * @return Host[]
     */
    public static function getLimited($limit = 0)
    {
        $hosts = static::find()->where(['>', 'limit', 0]);
        if ($limit > 0) {
            $hosts->limit($limit);
        }
        return $hosts->all();
    }

    /**
     * Return logo URL.
     *
     * @param string $logoSize logo image size (nprmal,small,large or monochrome)
     * @param boolean $absolute true to return absolute URL
     * @return string
     */
    public function getLogoUrl($logoSize = self::LOGO_NORMAL, $absolute = false)
    {
        switch ($logoSize) {
            case self::LOGO_NORMAL:
                return Url::to([self::DATA_DIR.'/'.$this->logo], $absolute);
            case self::LOGO_SMALL:
                return Url::to([self::DATA_DIR.'/'.$this->logo_small], $absolute);
            case self::LOGO_LARGE:
                return Url::to([self::DATA_DIR.'/'.$this->logo_large], $absolute);
            case self::LOGO_MONOCHROME:
                return Url::to([self::DATA_DIR.'/'.$this->logo_monochrome], $absolute);
            default:
                return Url::to([self::DATA_DIR.'/'.$this->logo], $absolute);
        }
    }

    /**
     * Checks if host has download limit
     *
     * @return boolean
     */
    public function isLimited()
    {
        return ($this->limit > 0);
    }
}
