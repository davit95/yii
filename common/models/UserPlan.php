<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Model for user's plan
 */
class UserPlan extends ActiveRecord
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    const STATUS_EXPIRED = 'EXPIRED';

    const SCENARIO_CREATE = 'CREATE';
    const SCENARIO_UPDATE = 'UPDATE';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users_plans}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'required'],
            ['id', 'exist', 'targetClass' => static::className(), 'targetAttribute' =>  'id'],
            ['user_id', 'required'],
            ['user_id', 'exist', 'targetClass' => User::className(), 'targetAttribute' =>  'id'],
            ['product_type', 'required'],
            ['product_type', 'in', 'range' => [Product::TYPE_DAILY, Product::TYPE_LIMITED]],
            ['start', 'required'],
            ['start', 'number', 'min' => 0],
            ['expire', 'number', 'min' => 0],
            ['days', 'number', 'min' => 0],
            ['limit', 'number', 'min' => 0],
            ['status', 'required'],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_EXPIRED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['user_id', 'product_type', 'start_date', 'expire_date', 'days', 'limit', 'status'],
            self::SCENARIO_UPDATE => ['id', 'user_id', 'product_type', 'start_date', 'expire_date', 'days', 'limit', 'status'],
        ];
    }

    /**
     * Returns plan's user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'id']);
    }

    /**
     * Checks if plan is active
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    /**
     * Checks if product can be applied to current plan
     *
     * @param  Product $product
     * @return boolean
     */
    public function canApplyProduct(Product $product)
    {
        if ($this->isActive()) {
            return $this->product_type == $product->type;
        } else {
            return true;
        }
    }

    /**
     * Creates new plan for user
     *
     * @param  User    $user
     * @param  Product $product
     * @return boolean
     */
    public static function create(User $user, Product $product)
    {
        $plan = new static();
        $plan->setScenario(self::SCENARIO_CREATE);

        $plan->user_id = $user->id;
        $plan->product_type = $product->type;
        $plan->start = time();
        if ($product->type == Product::TYPE_DAILY) {
            $plan->expire = $plan->start + $product->days * 24 * 60 * 60;
            $plan->days = $product->days;
        } else {
            $plan->expire = null;
        }
        if ($product->type == Product::TYPE_LIMITED) {
            $plan->limit = $product->limit;
        } else {
            $plan->limit = null;
        }

        $plan->status = self::STATUS_ACTIVE;

        if ($plan->save()) {
            //Add record to produc journal
            $jrnl = new UserProductJournal();
            $jrnl->user_id = $user->id;
            $jrnl->product_id = $product->id;
            $jrnl->save();

            return true;
        } else {
            return false;
        }
    }

    /**
     * Updates current user's plan.
     *
     * @param  Product $product
     * @return boolean
     */
    public function applyProduct(Product $product)
    {
        if ($this->canApplyProduct($product)) {
            $this->setScenario(self::SCENARIO_UPDATE);

            //Plan is not active, clean up...
            if (!$this->isActive()) {
                $this->start = time();
                $this->expire = null;
                $this->days = null;
                $this->limit = null;
                $this->status = self::STATUS_INACTIVE;
            }

            $this->product_type = $product->type;

            if ($product->type == Product::TYPE_DAILY) {
                $this->expire = $this->start + $product->days * 24 * 60 * 60;
                $this->days += $product->days;
            } elseif ($product->type == Product::TYPE_LIMITED) {
                $this->limit += $product->limit;
            }

            $this->status = self::STATUS_ACTIVE;

            if ($this->save()) {
                //Add record to produc journal
                $jrnl = new UserProductJournal();
                $jrnl->user_id = $this->user_id;
                $jrnl->product_id = $product->id;
                $jrnl->save();

                return true;
            }
        }

        return false;
    }

    /**
     * Returns limit in bytes
     *
     * Returns  limit in bytes.
     * This will return null if product
     * type is not "LIMITED".
     *
     * @return
     */
    public function getLimitInBytes()
    {
        if ($this->product_type == Product::TYPE_LIMITED) {
            return $this->limit * 1024 * 1024 * 1024;
        }

        return null;
    }
}
