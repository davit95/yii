<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\UserPlan;
use common\models\Product;
use common\models\DownloadJournal;

/**
 * Handles user's plans related CLI tasks
 */
class UserPlanController extends Controller
{
    /**
     * Marks expired user plans as expired
     *
     * @return integer
     */
    public function actionMarkPlansAsExpired()
    {
        foreach (UserPlan::find()->where(['status' => UserPlan::STATUS_ACTIVE])->each() as $userPlan) {
            if ($userPlan->product_type == Product::TYPE_DAILY) {
                if ($userPlan->expire <= time()) {
                    $userPlan->status = UserPlan::STATUS_EXPIRED;
                }
            } elseif ($userPlan->product_type == Product::TYPE_LIMITED) {
                $bytesSended = DownloadJournal::getBytesSendedToUser($userPlan->user, $userPlan->start);
                if ($userPlan->limit <= $bytesSended) {
                    $userPlan->status = UserPlan::STATUS_EXPIRED;
                }
            }

            if (!empty($userPlan->getDirtyAttributes())) {
                $userPlan->setScenario(UserPlan::SCENARIO_UPDATE);
                $userPlan->save();
            }
        }

        return 0;
    }
}
