<?php

namespace frontend\helpers;

use Yii;
use common\models\Transaction;

/**
 * Invoice helper
 */
class InvoiceHelper
{
    /**
     * Returns PDF generation date
     *
     * @return string
     */
    public static function getGenerationDate()
    {
        return Yii::$app->formatter->asDate(time(), 'php:d.m.Y');
    }

    /**
     * Returns formatted address
     *
     * @return string
     */
    public static function getFormattedAddress($asList = false)
    {
        $config = Yii::$app->config;

        $companyName = $config->get('App.AddressCompanyName', null);
        $city = $config->get('App.AddressCity', null);
        $street = $config->get('App.AddressStreet', null);
        $phone = $config->get('App.AddressPhone', null);

        $tag = ($asList) ? 'li' : 'p';

        return "<{$tag}>{$companyName}</{$tag}><{$tag}>{$city}</{$tag}><{$tag}>{$street}</{$tag}><{$tag}>Tel:{$phone}</{$tag}>";
    }

    /**
     * Returns formatted customer info from transaction
     *
     * @return string
     */
    public static function getFormattedCustomerInfo(Transaction $transaction, $asListt = false)
    {
        $firstName = $transaction->getTransactionData('first_name');
        $lastName = $transaction->getTransactionData('last_name');
        $name = ($firstName == null && $lastName == null) ? '-' : $firstName.' '.$lastName;
        $country = $transaction->getTransactionData('country', '-');

        $tag = ($asList) ? 'li' : 'p';

        return "<{$tag}>{$name}</{$tag}><{$tag}>{$country}</{$tag}>";
    }
}
