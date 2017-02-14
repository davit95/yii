<?php

namespace service\components\statistics;

use Yii;
use yii\base\Event;
use yii\base\Component;
use yii\base\Exception;
use service\models\StatisticalData;
use service\models\StatisticalIndex;
use service\models\StatisticalDataSet;

class Statistic extends Component
{
    const DATA_LIMIT = 1000;

    public $data = [];
    private $events = [];
    private $dataSets = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $handler = function ($event) {
            $dataSet = isset($event->data['dataSet']) ? $event->data['dataSet'] : null;

            if ($dataSet !== null) {
                Yii::$app->statistic->add($dataSet, $event);
            }
        };

        //Bind events to geather statistics
        foreach ($this->events as $dataSet => $events) {
            if (!is_array($events)) {
                $events = [$events];
            }

            foreach ($events as $event) {
                Event::on(Component::className(), $event, $handler, ['dataSet' => $dataSet]);
            }
        }
        //Register shutdown function to flush statistics
        register_shutdown_function(function () {
            Yii::$app->statistic->flush();
        });
    }

    /**
     * Returns statistical dataset model instance by name
     *
     * @param  string $name
     * @return service\models\StatisticalDataSet|null
     */
    private function getDataSet($name)
    {
        foreach ($this->dataSets as $dataSet) {
            if ($dataSet->name == $name) {
                return $dataSet;
            }
        }
        $dataSet = StatisticalDataSet::findByName($name);
        if ($dataSet != null) {
            $this->dataSets[] = $dataSet;
        }
        return $dataSet;
    }

    /**
     * Sets events on which statistical data will be collected
     *
     * @param array $events
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }

    /**
     * Returns data for given statistical index
     *
     * @param StatisticalIndex $index statistical index
     * @param string $dateFrom start date
     * @param string $dateTo end date
     * @param array $filter additional filters
     * @return array
     */
    public function get($index, $dateFrom = null, $dateTo = null, $filter = [], $offset = 0, $limit = 0)
    {
        if (is_string($index)) {
            $index = StatisticalIndex::findByName($index);
        }

        if ($index instanceof StatisticalIndex) {
            return StatisticalData::getStatistic($index, $dateFrom, $dateTo, $filter, $offset, $limit);
        } else {
            throw new Exception('Invalid statistical index.');
        }
    }

    /**
     * Adds statistic data.
     *
     * Adds statistic data.
     * This method does not save data to database.
     * To save data call flush method.
     *
     * @param mixed $dataSet
     * @param mixed $data  array of statistics data [attribute => value]
     */
    public function add($dataSet, $data)
    {
        //Flush statistics if data array is too large
        if (count($this->data) >= self::DATA_LIMIT) {
            $this->flush();
        }

        $statData = [];

        if ($dataSet instanceof StatisticalDataSet) {
            $this->dataSets[] = $dataSet;
        } else {
            $dataSet = $this->getDataSet((string)$dataSet);
        }

        if ($dataSet == null) {
            return false;
        }

        $statData['_data_set'] = $dataSet->id;

        $attrs = $dataSet->getAttributesAsArray();
        $attrsMap = array_flip($attrs);

        if (!is_object($data)) {
            $data = (object)$data;
        }

        foreach ($attrs as $attr) {
            if (isset($data->{$attr})) {
                $index = $attrsMap[$attr] + 1;
                $statData["attr_{$index}_val"] = (string)$data->{$attr};
            }
        }

        $statData['_timestamp'] = time();

        $this->data[] = $statData;

        return true;
    }

    /**
     * Saves statistic to database
     *
     * @return void
     */
    public function flush()
    {
        if (StatisticalData::batchAdd($this->data)) {
            $this->data = null;
            $this->data = [];
            return true;
        } else {
            return false;
        }
    }
}
