<?php

namespace common\components\statistics\service;

use Yii;
use yii\base\Object;
use yii\base\ArrayAccessTrait;

class StatisticalData extends Object
{
    use ArrayAccessTrait;

    private $data;

    /**
     * Constructs object
     */
    public function __construct()
    {
        $this->data = [];
    }

    /**
     * Adds new data
     *
     * @param stdClass $data
     */
    public function addData(\stdClass $data)
    {
        array_push($this->data, $data);
        return true;
    }

    /**
     * Returns summary attribute value
     *
     * @param  string $attr
     * @return integer|float
     */
    public function sum($attr)
    {
        $sum = 0;
        foreach ($this->data as $data) {
            $sum += isset($data->$attr) ? $data->$attr : 0;
        }

        return $sum;
    }

    /**
     * Returns min attribute value
     *
     * @param  string $attr
     * @return integer|float
     */
    public function min($attr)
    {
        $min = INF;
        foreach ($this->data as $data) {
            if (isset($data->$attr) && ($data->$attr < $min)) {
                $min = $data;
            }
        }

        return $min;
    }

    /**
     * Returns max attribute value
     *
     * @param  string $attr
     * @return integer|float
     */
    public function max($attr)
    {
        $max = -INF;
        foreach ($this->data as $data) {
            if (isset($data->$attr) && ($data->$attr > $max)) {
                $max = $data;
            }
        }

        return $max;
    }

    /**
     * Returns avg attribute value
     *
     * @param  string $attr
     * @return integer|float
     */
    public function avg($attr)
    {
        $sum = 0;
        $cnt = 0;
        foreach ($this->data as $data) {
            $sum += isset($data->$attr) ? $data->$attr : 0;
            $cnt++;
        }

        return $sum / $cnt;
    }

    /**
     * Returns attribute data
     *
     * @param  string $attr
     * @return array
     */
    public function get($attr){
        return isset($this->data) ? $this->data : 0;
    }
}
