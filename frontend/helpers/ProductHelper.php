<?php

namespace frontend\helpers;

use Yii;
use yii\db\Query;
use yii\db\Expression;
use common\models\User;
use common\models\Product;
use common\models\UserProductJournal;

/**
 * Product helper
 */
class ProductHelper
{
    /**
     * Returns most used product
     *
     * @param  string $productType
     * @return Product
     */
    public static function getMostPopularProduct($productType = null)
    {
        $query = new Query();
        $query->select('product_id');
        $query->from(UserProductJournal::tableName());
        if ($productType != null) {
            $query->leftJoin(Product::tableName(), UserProductJournal::tableName().'.`product_id` ='.Product::tableName().'.`id`');
            $query->where(['=', Product::tableName().'.type', $productType]);
        }
        $query->groupBy('product_id');
        $query->orderBy(['COUNT(`product_id`)' => SORT_DESC]);

        if (($id = $query->scalar()) != null) {
            return Product::findOne($id);
        } else {
            return null;
        }
    }

    /**
     * Returns percentage usage of product
     *
     * @param  Product $product
     * @return integer
     */
    public static function getProductUsage(Product $product)
    {
        $total = UserProductJournal::find()->count();
        $product = UserProductJournal::find()->where(['product_id' => $product->id])->count();

        return floor(($product / $total) * 100);
    }
}
