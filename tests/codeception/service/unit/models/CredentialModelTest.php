<?php

namespace tests\codeception\service\unit\models;

use Yii;
use tests\codeception\service\unit\DbTestCase;
use tests\codeception\service\fixtures\InstanceFixture;
use tests\codeception\service\fixtures\CredentialFixture;
use tests\codeception\service\fixtures\ContentProviderFixture;
use tests\codeception\service\fixtures\ContentProviderCredentialFixture;
use yii\db\Query;
use service\models\Credential;

class CredentialModelTest extends DbTestCase
{
    public function testCreate()
    {
        $data = [
            'user' => 'user',
            'pass' => 'pass',
            'status' => 'ACTIVE'
        ];

        $cred = new Credential();
        $cred->setScenario(Credential::SCENARIO_CREATE);
        $cred->load($data, '');

        $this->assertTrue($cred->save());

        $cred->refresh();

        $this->assertEquals('user', $cred->getDecryptedUser());
        $this->assertEquals('pass', $cred->getDecryptedPass());
        $this->assertEquals('ACTIVE', $cred->status);
    }

    public function testUpdate()
    {
        $data = [
            'user' => 'another_user',
            'pass' => 'another_pass',
            'status' => 'ACTIVE'
        ];

        $cred = Credential::findOne(1);
        $cred->setScenario(Credential::SCENARIO_UPDATE);
        $cred->load($data, '');

        $this->assertTrue($cred->save());

        $cred->refresh();

        $this->assertEquals('another_user', $cred->getDecryptedUser());
        $this->assertEquals('another_pass', $cred->getDecryptedPass());
        $this->assertEquals('ACTIVE', $cred->status);
    }

    public function testDelete()
    {
        $cred = Credential::findOne(1);
        $cred->setScenario(Credential::SCENARIO_DELETE);

        $this->assertEquals(1, $cred->delete());
    }

    public function fixtures()
    {
        return [
            'instance' => [
                'class' => InstanceFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/instances.php',
            ],
            'credential' => [
                'class' => CredentialFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/credentials.php',
            ],
            'content_provider' => [
                'class' => ContentProviderFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/content_providers.php',
            ],
            'content_provider_credential' => [
                'class' => ContentProviderCredentialFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/content_providers_credentials.php',
            ],
        ];
    }
}
