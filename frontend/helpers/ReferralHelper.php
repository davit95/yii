<?php

namespace frontend\helpers;

use Yii;
use common\models\Host;

/**
 * Referral helper class
 */
class ReferralHelper
{
    private static $hosts;

    /**
     * Returns hosts
     *
     * @return Host[]
     */
    private static function getHosts ()
    {
        if (self::$hosts == null) {
            self::$hosts = Host::find()->all();
        }
        return self::$hosts;
    }

    /**
     * Returns referral presentation text
     *
     * @return string
     */
    public static function getPresentationText ()
    {
        return Yii::$app->config->get('App.ReferralPresentationText');
    }

    /**
     * Returns bbcodes for hosts logos
     *
     * @param  boolean $asArray true to return array
     * @return array|string
     */
    public static function getBbCodeHostsLogos ($asArray = false)
    {
        $hosts = array();
        foreach (self::getHosts() as $host) {
            $hosts[] = '[IMG]'.$host->getLogoUrl(Host::LOGO_NORMAL, true).'[/IMG]';
        }

        if ($asArray) {
            return $hosts;
        } else {
            return implode(",\n", $hosts);
        }
    }

    /**
     * Returns bbcodes for hosts logos as list
     *
     * @return string
     */
    public static function getBbCodeHostsLogosList ()
    {
        $hosts = array();

        $hosts[] = '[LIST]';
        foreach (self::getHosts() as $host) {
            $hosts[] = '[*][IMG]'.substr($host->getLogoUrl(Host::LOGO_SMALL), 3).'[/IMG]';
        }
        $hosts[] = '[/LIST]';

        return implode("\n", $hosts);
    }

    /**
     * Converts referral points to preium days
     *
     * @param  integer $points
     * @return integer
     */
    public static function referralPointsToPremiumDays ($points)
    {
        $rate = (float)Yii::$app->config->get('App.ReferralPointsRate');
        return floor($points * $rate);
    }

    /**
     * Returns bbcode hosts logos preview
     *
     * @return array
     */
    public static function getBbCodeHostsLogosPreview ()
    {
        $hosts = array();
        foreach (self::getHosts() as $host) {
            $hosts[] = '<img src="'.substr($host->getLogoUrl(Host::LOGO_SMALL), 3).'" style="max-width: 75px;"/>';
        }

        return $hosts;
    }
}
