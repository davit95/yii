<?php

namespace common\repositories;

use common\models\User;
use InvalidArgumentException;
use RuntimeException;
use Carbon\Carbon;

/**
 * Class StatisticRepository
 *
 * @package common\repositories
 */
class StatisticRepository
{
    /**
    * Get all Statistic data resources from Service.
    * @return Statistic with per_day range
    */
    public function getStatisticBytesPerDay()
    {
        $to_array = [];
        $stat_per_day = [];
        $stat = \Yii::$app->serviceStatistic;
        //array_push($to_array, Carbon::now());
        for($i = 1 ; $i < 7 ;$i++){
            $to = Carbon::now();
            $from = $to->subHours($i * 24);
            array_push($to_array, $from);
        }
        foreach ($to_array as $timestamp) {
            $now = Carbon::now();
            $statistic = $stat->get('sended_content_attrs',$timestamp,$timestamp)->sum('content_size');
            array_push($stat_per_day, $statistic / 1024 / 1024);
        }
        return $stat_per_day;
    }

    /**
    * Get Downloads failed and succes counts
    * @return Number
    */
    public function getStatisticCount(){
        $stat = \Yii::$app->serviceStatistic;
        $statistic = $stat->get('sended_content_attrs')->get('content_size');
        $failed_downloads = 0;
        $success_downloads = 0;
        foreach ($statistic as $data) {
            if($data->content_size == 0){
                $failed_downloads ++;
            }elseif($data->content_size != 0){
                $success_downloads++;
            }
        }
        return ['failed'=>$failed_downloads,'success'=>$success_downloads];
    }

    /**
    * Get Statistic with content_provider_name and count(content_size)
    * @return statistic Array
    */
    public function getStatisticCountProviders($startDate,$endDate){
        $stat = \Yii::$app->serviceStatistic;
        $sended_content_attrs = $stat->get('sended_content_amount_per_provider_by_user',$startDate,$endDate)->get('content_size');
        $stat_array = [];
        foreach ($sended_content_attrs as $stat) {
            $stat_array[$stat->provider_name] = [
                'bytes_sended'=> isset($stat_array[$stat->provider_name]) ? $stat_array[$stat->provider_name]['bytes_sended'] + ($stat->bytes_sended / 1024 / 1024) : $stat->bytes_sended / 1024 / 1024 ,
            ];
        }
        return $stat_array;
    }
}
