<?php

namespace tests\codeception\service\unit\models;

use Yii;
use tests\codeception\service\unit\DbTestCase;
use tests\codeception\service\fixtures\InstanceFixture;
use service\models\Instance;

class InstanceModelTest extends DbTestCase
{
    public function testUpdate()
    {
        $instance = Instance::find()->one();
        $instance->storing_enabled = 0;
        $instance->proxy_enabled = 1;
        $instance->status = Instance::STATUS_INACTIVE;
        $this->assertTrue($instance->save());

        $instance->refresh();

        $this->assertFalse($instance->isStoringEnabled());
        $this->assertTrue($instance->isProxyEnabled());
        $this->assertEquals(Instance::STATUS_INACTIVE, $instance->status);
    }

    public function fixtures()
    {
        return [
            'instance' => [
                'class' => InstanceFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/instances.php',
            ],
        ];
    }
}
