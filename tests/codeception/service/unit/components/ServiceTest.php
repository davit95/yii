<?php

namespace tests\codeception\service\unit\components;

use Yii;
use tests\codeception\service\unit\TestCase;
use tests\codeception\service\fixtures\InstanceFixture;

class ServiceTest extends TestCase
{
    public function testGetParam()
    {
        $this->assertNotEmpty(\Yii::$app->service->getParam('serviceUid'));
        $this->assertNull(\Yii::$app->service->getParam('notExistingParam'));
    }

    public function testGet()
    {
        $this->assertInstanceOf('service\models\Instance', \Yii::$app->service->instance);
    }

    public function fixtures()
    {
        return [
            'instance' => [
                'class' => InstanceFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/instances.php',
            ]
        ];
    }
}
