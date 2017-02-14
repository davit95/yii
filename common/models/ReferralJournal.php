<?php

namespace common\models;

use Yii;
use yii\db\Query;
use yii\db\ActiveRecord;

/**
 * Model for referral journal
 */
class ReferralJournal extends ActiveRecord
{
    const SCENARIO_CREATE = 'CREATE';
    const SCENARIO_UPDATE = 'UPDATE';
    const SCENARIO_DELETE = 'DELETE';

    /**
     * @inheritdoc
     */
    public static function tableName ()
    {
        return '{{%referral_journals}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors ()
    {
        return [
            [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['timestamp']
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Referral journal rec id',
            'referral_link_id' => 'Referral link id',
            'user_id' => 'User id',
            'action_id' => 'Referral action id',
            'tracking_num' => 'Tracking number',
            'timestamp' => 'Timestamp'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules ()
    {
        return [
            ['referral_link_id', 'required'],
            ['referral_link_id', 'exist', 'targetClass' => 'common\models\ReferralLink', 'targetAttribute' => 'id'],
            ['user_id', 'required'],
            ['user_id', 'exist', 'targetClass' => 'common\models\User', 'targetAttribute' => 'id'],
            ['action_id', 'required'],
            ['action_id', 'exist', 'targetClass' => 'common\models\ReferralAction', 'targetAttribute' => 'id'],
            ['tracking_num', 'required'],
            ['tracking_num', 'string', 'min' => 1, 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['referral_link_id', 'user_id', 'action_id', 'tracking_num'],
            self::SCENARIO_UPDATE => ['id', 'referral_link_id', 'user_id', 'action_id', 'tracking_num'],
            self::SCENARIO_DELETE => ['id']
        ];
    }

    /**
     * Returns referal link realted to this record
     *
     * @return ReferralLink
     */
    public function getReferralLink ()
    {
        return $this->hasOne(ReferralLink::className(), ['id' => 'referral_link_id']);
    }

    /**
     * Get owner (user) of record
     *
     * @return User
     */
    public function getOwner ()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Returns referral action
     *
     * @return ReferralAction
     */
    public function getAction()
    {
        return $this->hasOne(ReferralAction::className(), ['id' => 'action_id']);
    }

    /**
     * Returns referral journal records by owner
     *
     * @param  User   $owner
     * @param  integer $refLinkId
     * @param  string $action
     * @param  timestamp $startDate
     * @param  timestamp $endDate
     * @param  boolean true to return ReferralJournal[]
     * @return yii\db\ActiveQueryInterface|ReferralJournal[]
     */
    public static function getRecordsByOwner (User $owner, $refLinkId = null, $action = null, $startDate = null, $endDate = null, $all = true)
    {
        $recs = static::find()->where(['user_id' => $owner->id]);
        if ($action != null) {
            $recs->joinWith('action', true)
                ->onCondition(['name' => $action]);
        }
        if ($refLinkId != null) {
            $refLinkId = (int)$refLinkId;
            $recs->andWhere(['referral_link_id' => $refLinkId]);
        }
        if ($startDate != null) {
            $recs->andWhere(['>=', 'timestamp', $startDate]);
        }
        if ($endDate != null) {
            $recs->andWhere(['<=', 'timestamp', $endDate]);
        }

        return ($all) ? $recs->all() : $recs;
    }

    /**
     * Returns number of actions occurance by days
     *
     * @param  User   $owner
     * @param  integer $startDate
     * @param  integer $endDate
     * @param  inteegr $refLinkId
     * @param  string $action
     * @param  boolean $allDays if true days where no action occures are also included
     * @return array
     */
    public static function getActionOccurancePerDayByOwner (User $owner, $startDate, $endDate, $refLinkId = null, $action = null, $allDays = false)
    {
        $statQuery = new Query();
        $statQuery->select('DATE(FROM_UNIXTIME(rj.timestamp)) AS date, COUNT(*) AS count');
        $statQuery->from(static::tableName().' rj');
        $statQuery->where(['rj.user_id' => $owner->id]);
        $statQuery->andWhere(['>=', 'rj.timestamp', $startDate]);
        $statQuery->andWhere(['<=', 'rj.timestamp', $endDate]);
        if ($action != null) {
            $statQuery->leftJoin(ReferralAction::tableName().' ra', 'rj.action_id = ra.id');
            $statQuery->andWhere(['ra.name' => $action]);
        }
        if ($refLinkId != null) {
            $refLinkId = (int)$refLinkId;
            $statQuery->andWhere(['rj.referral_link_id' => $refLinkId]);
        }
        $statQuery->groupBy(['DATE(FROM_UNIXTIME(rj.timestamp))']);
        $statQuery->orderBy(['DATE(FROM_UNIXTIME(rj.timestamp))' => SORT_ASC]);

        $stats = array();
        foreach ($statQuery->each() as $stat) {
            $stats[$stat['date']] = (int)$stat['count'];
        }

        if ($allDays) {
            $startDate = strtotime(date('Y-m-d',$startDate));
            $endDate = strtotime(date('Y-m-d',$endDate));
            $statsAll = array();
            $date = $startDate;
            while ($date <= $endDate) {
                $fmtDate = date('Y-m-d',$date);
                $statsAll[$fmtDate] = isset($stats[$fmtDate]) ? (int)$stats[$fmtDate] : 0;
                $date += 3600;
            }
            return $statsAll;
        } else {
            return $stats;
        }
    }

    /**
     * Returns avarage action occurance per day
     *
     * @param  User   $owner
     * @param  integer $startDate
     * @param  integer $endDate
     * @param  inteegr $refLinkId
     * @param  string $action
     * @return float
     */
    public static function getAvgActionOccuranceByOwner (User $owner, $startDate, $endDate, $refLinkId = null, $action = null)
    {
        $stats = static::getActionOccurancePerDayByOwner($owner, $startDate, $endDate, $refLinkId, $action, true);

        $avg = 0;
        foreach ($stats as $date => $value) {
            $avg += $value;
        }
        return round($avg / count($stats), 2);
    }
}
