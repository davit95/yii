<?php

namespace common\components\statistics\service;

use Yii;
use yii\base\Component;
use yii\base\InvalidParamException;
use common\models\Service;

class Statistic extends Component
{
    public $useCache = true;
    public $cacheDuration = 300;

    /**
     * Returns request hash
     *
     * @return string
     */
    private function getRequestHash()
    {
        $str = '';

        $args = func_get_args();
        foreach ($args as $arg) {
            if (is_array($arg) || is_object($arg)) {
                $str .= serialize($arg);
            } else {
                $str .= $arg;
            }
        }

        return md5($str);
    }

    /**
     * Gets and returns statistical data from cache
     *
     * @param  string $hash
     * @return StatisticalData|boolean
     */
    private function getFromCache($hash)
    {
        if ($this->useCache && Yii::$app->has('cache')) {
            $data = Yii::$app->cache->get($hash);
            if ($data instanceof StatisticalData) {
                return $data;
            }
        }
        return false;
    }

    /**
     * Stores statistical data in cache
     *
     * @param  string          $hash
     * @param  StatisticalData $data
     * @return boolean
     */
    private function storeInCache($hash, $data)
    {
        if (!($data instanceof StatisticalData)) {
            throw new InvalidParamException('Data should be instance of StatisticalData');
        }

        if ($this->useCache && Yii::$app->has('cache')) {
            return Yii::$app->cache->set($hash, $data, $this->cacheDuration);
        } else {
            return false;
        }
    }

    /**
     * Gathers and returns statistical data from all services
     *
     * @param  string  $index    statistical index
     * @param  string  $dateFrom date range start
     * @param  string  $dateTo   date range end
     * @param  array   $filter   filters
     * @param  integer $offset
     * @param  integer $limit
     * @param  array   $uids     services uids. if empty - gets from all services
     * @param  boolean $fresh    ignores cached value
     * @return StatisticalData
     */
    public function get($index, $dateFrom = null, $dateTo = null, $filter = [], $offset = 0, $limit = 0, $uids = [], $fresh = false)
    {
        $hash = $this->getRequestHash($index, $dateFrom, $dateTo, $filter, $offset, $limit, $uids);

        if (!$fresh && ($data = $this->getFromCache($hash)) !== false) {
            return $data;
        }

        $statData = new StatisticalData();

        $services = Service::find();
        if (!empty($uids)) {
            $services->where(['uid' => $uids]);
        }

        foreach ($services->each() as $service) {
            $client = $service->getClientAsAdmin();
            $resp = $client->getStatistics($index, $dateFrom, $dateTo, $filter, $offset, $limit);
            if ($resp->isSuccess()) {
                if (!empty($resp->body->statistic)) {
                    foreach ($resp->body->statistic as $data) {
                        $statData->addData($data);
                    }
                }
            }
            unset($resp);
            unset($client);
        }

        $this->storeInCache($hash, $statData);

        return $statData;
    }
}
