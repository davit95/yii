<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Model for earnings filter form
 */
class EarningsFilterForm extends Model
{
    const ONE_MONTH = 2628000;
    const ONE_YEAR = 31536000;

    public $refLinkId;
    public $startDate;
    public $endDate;

    /**
     * @inheritdoc
     */
    public function attributrLabels ()
    {
        return [
            'refLinkId' => 'Referral link',
            'startDate' => 'Start date',
            'endDate' => 'End date'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [
            ['refLinkId', 'required'],
            ['refLinkId', 'exist', 'targetClass' => 'common\models\ReferralLink', 'targetAttribute' => 'id'],
            ['startDate', 'required'],
            ['startDate', 'date',
                'format' => 'php:Y-m-d',
                'min' => Yii::$app->formatter->asDate(time() - self::ONE_YEAR, 'php:Y-m-d'),
                'max' => Yii::$app->formatter->asDate(time() + self::ONE_YEAR, 'php:Y-m-d')
            ],
            ['endDate', 'required'],
            ['endDate', 'date',
                'format' => 'php:Y-m-d',
                'min' => Yii::$app->formatter->asDate(time() - self::ONE_YEAR, 'php:Y-m-d'),
                'max' => Yii::$app->formatter->asDate(time() + self::ONE_YEAR, 'php:Y-m-d')
            ],
            ['endDate', 'validateEndDate']
        ];
    }

    /**
     * Prepares and returns form data
     *
     * @return array|boolean
     */
    public function prepareData ()
    {
        if ($this->validate()) {
            return [
                $this->refLinkId,
                Yii::$app->formatter->asTimestamp($this->startDate),
                Yii::$app->formatter->asTimestamp($this->endDate),
            ];
        } else {
            return false;
        }
    }

    /**
     * Validates end date
     *
     * @return void
     */
    public function validateEndDate ()
    {
        if (!$this->hasErrors()) {
            $startDate = Yii::$app->formatter->asTimestamp($this->startDate);
            $endDate = Yii::$app->formatter->asTimestamp($this->endDate);
            if ($startDate >= $endDate) {
                $this->addError('endDate', $this->getAttributeLabel('endDate').' must be greater than '.$this->getAttributeLabel('startDate'));
            }
        }
    }
}
