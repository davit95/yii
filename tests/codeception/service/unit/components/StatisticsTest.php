<?php

namespace tests\codeception\service\unit\components;

use Yii;
use tests\codeception\service\unit\TestCase;
use tests\codeception\service\fixtures\InstanceFixture;
use tests\codeception\service\fixtures\StatisticalDataFixture;
use tests\codeception\service\fixtures\StatisticalDataSetFixture;
use tests\codeception\service\fixtures\StatisticalIndexFixture;
use service\models\StatisticalIndex;

class StatisticsTest extends TestCase
{
    public function testAddStatistics()
    {
        $statistics = Yii::$app->statistic;
        $this->assertTrue($statistics->add('test_data_set', ['attr1' => 'some_value', 'attr2' => 90, 'attr3' => 900]));
        $this->assertTrue($statistics->add('test_data_set_2', ['attr1' => 'some_value', 'attr2' => 1, 'attr3' => 2, 'attr4' => 3, 'attr5' => 4]));
        $this->assertTrue($statistics->flush());
    }

    public function testGetStatistics()
    {
        $statistics = Yii::$app->statistic;
        $index = StatisticalIndex::findByName('test_index');
        $data = $statistics->get($index);
        $this->assertTrue(is_array($data));
        $this->assertEquals('attr_value', $data[0]['attr1']);
        $this->assertEquals(60, $data[0]['attr2']);
        $this->assertEquals(300, $data[0]['attr3']);
    }

    public function testGetStatisticsWithFilter()
    {
        $statistics = Yii::$app->statistic;
        $index = StatisticalIndex::findByName('test_index');
        $data = $statistics->get($index, null, null, [['attr2' => 10]]);
        $this->assertTrue(is_array($data));
        $this->assertEquals('attr_value', $data[0]['attr1']);
        $this->assertEquals(10, $data[0]['attr2']);
        $this->assertEquals(100, $data[0]['attr3']);
    }

    public function testGetStatisticsInDateRange()
    {
        $statistics = Yii::$app->statistic;
        $index = StatisticalIndex::findByName('test_index');
        $data = $statistics->get($index, 0, 0);
        $this->assertTrue(empty($data));
        $data = $statistics->get($index, date('d.m.Y 00:00'), date('d.m.Y 23:59'));
        $this->assertEquals('attr_value', $data[0]['attr1']);
        $this->assertEquals(30, $data[0]['attr2']);
        $this->assertEquals(200, $data[0]['attr3']);
    }

    public function fixtures()
    {
        return [
            'instance' => [
                'class' => InstanceFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/instances.php',
            ],
            'statistical_data_set' => [
                'class' => StatisticalDataSetFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/statistical_data_sets.php',
            ],
            'statistical_index' => [
                'class' => StatisticalIndexFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/statistical_indexes.php',
            ],
            'statistical_data' => [
                'class' => StatisticalDataFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/statistical_data.php',
            ],
        ];
    }
}
