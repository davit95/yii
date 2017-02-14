<?php

namespace frontend\components\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\Cookie;
use yii\base\InvalidParamException;
use common\models\ReferralAction;
use common\models\ReferralJournal;

/**
 * Referral behavior. "Catches" visitors which came to service via referal link
 *
 * Works in following way:
 * User visits page using referral link. Application calls (directly or in event handler) catch method.
 * Catch method checks if URL contains uid (referral link owner id) and lid (referal link id) params.
 * If params are set new tracking number is generated and new referral journal record (with corresponding action) is created
 * and tracking number is saved to cookies (so we can keep traking user when he visit other website pages).
 * To be able to "catch" referrals controller should use ReferralBehavior.
 * You can use methods like catchActionName() where action_name is action name from referral_actions table.
 * Usage examples:
 * ``` php
 * 'referralBehavior' => [
 *      'class' => 'frontend\components\behaviors\ReferralBehavior',
 *      'events' => [
 *          'someEvent' => 'catchRegister'
 *      ],
 *      'actions' => [
 *          'some-action' => 'catchBuyPremium'
 *      ]
 * ]
 * ```
 *
 * ``` php
 * ...
 * $referral = $this->getBehavior('referralBehavior');
 * $referral->catchVisitPage();
 * ...
 * ```
 */
class ReferralBehavior extends Behavior
{
    const COOKIE_EXPIRATION = 3600;

    public $events;
    public $actions;

    private $trk;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $uid = Yii::$app->request->get('uid', null);
        $lid = Yii::$app->request->get('lid', null);

        if ($uid != null && $lid != null) {
            //Set tracking cookie
            $trk = $this->generateTrackingNum($uid, $lid);

            try {
                $this->setTrackingNum($trk);
            } catch (\Exception $e) {
                Yii::error($e);
                return;
            }

            $cookies = Yii::$app->response->cookies;

            $expires = time() + self::COOKIE_EXPIRATION;
            $cookie = new Cookie([
                'name' => '_trk',
                'value' => $trk,
                'expire' => $expires,
                'httpOnly' => true
            ]);

            $cookies->add($cookie);
        }
    }

    /**
     * @inheritdoc
     */
    public function attach($owner)
    {
        if (!empty($this->actions)) {
            $behavior = $this;

            $handler = function ($event) use ($behavior) {
                foreach ($behavior->actions as $action => $method) {
                    if ($event->action->id == $action) {
                        $behavior->$method();
                    }
                }
            };
            //Since this behavior is ment to be used with controllers we attach handler to EVENT_BEFORE_ACTION event
            $owner->on(\yii\base\Controller::EVENT_BEFORE_ACTION, $handler);
        }

        parent::attach($owner);
    }

    /**
     * @inheritdoc
     */
    public function events ()
    {
        if (is_array($this->events)) {
            return $this->events;
        } else {
            return parent::events();
        }
    }

    /**
     * Generates tracking number
     *
     * @param  integer $uid
     * @param  integer $lid
     * @return string
     */
    private function generateTrackingNum($uid, $lid)
    {
        $unq = uniqid();

        return "uid{$uid}lid{$lid}unq{$unq}";
    }

    /**
     * Returns current tracking number
     *
     * @return string
     */
    private function getTrackingNum()
    {
        if ($this->trk == null) {
            $cookies = Yii::$app->request->cookies;
            $this->trk = $cookies->getValue('_trk', null);
        }

        return $this->trk;
    }

    /**
     * Sets tracking number
     *
     * @param string $trk
     */
    private function setTrackingNum($trk)
    {
        if ($this->parseTrackingNum($trk) !== false) {
            throw new InvalidParamException('Invalid tracking number.');
        }

        $this->trk = $trk;
    }

    /**
     * Parses tracking number and returns info.
     *
     * Parses tracking number and returns info.
     * Info is returned as array:
     * [
     *   'uid',//Owner of referral link
     *   'lid',//Referral link id
     *   'unq'//Unique id
     * ]
     *
     * @param  string $trk
     * @return
     */
    private function parseTrackingNum($trk)
    {
        $trk = $this->getTrackingNum();

        if (preg_match('/^uid(\d+)lid(\d+)unq(.+)$/', $trk, $matches)) {
            array_shift($matches);
            return $matches;
        }

        return false;
    }

    /**
     * "Catches" referral and creates record in referral journal
     *
     * @param  common\models\ReferralAction $action referal journal action
     * @return boolean                              true when referral journal record is created
     */
    private function catchReferral(ReferralAction $action)
    {
         $trk = $this->getTrackingNum();

         if ($trk !== null) {
             if ((list($uid, $lid, $unq) = $this->parseTrackingNum($trk)) === false) {
                 Yii::error("Can\'t parse tracking number {$trk}");
                 return false;
             }

             $rec = new ReferralJournal();
             $rec->setScenario(ReferralJournal::SCENARIO_CREATE);
             $rec->user_id = $uid;
             $rec->referral_link_id = $lid;
             $rec->action_id = $action->id;
             $rec->tracking_num = $trk;

             if ($rec->save()) {
                 $rec->owner->grantReferralPoints($action->points);
                 if (!$rec->owner->save()) {
                    Yii::error('referral', 'Failed to grant referral points to user. Referral journal rec id - '.$rec->id);
                 }
             }
         }
    }

    /**
     * @inheritdoc
     */
    public function __call($name, $params)
    {
        if (strpos($name, 'catch') === 0) {
            $action = trim(mb_strtolower(preg_replace('/([A-Z])/', '_$1', str_replace('catch', '', $name))), " \t\n\r\0\x0B_");
            $action = ReferralAction::findByName($action);

            if ($action != null && $action->isActive()) {
                return $this->catchReferral($action);
            }
        }

        return parent::__call($name, $params);
    }

}
