<?php

namespace tests\codeception\service\unit\models;

use Yii;
use tests\codeception\service\unit\DbTestCase;
use tests\codeception\service\fixtures\InstanceFixture;
use tests\codeception\service\fixtures\LinkFixture;
use tests\codeception\service\fixtures\CredentialFixture;
use tests\codeception\service\fixtures\ContentProviderFixture;
use tests\codeception\service\fixtures\ContentProviderCredentialFixture;
use tests\codeception\service\fixtures\StatisticalDataFixture;
use tests\codeception\service\fixtures\StatisticalDataSetFixture;
use tests\codeception\service\fixtures\StatisticalIndexFixture;
use yii\db\Query;
use service\models\ContentProvider;

class ContentProviderModelTest extends DbTestCase
{
    public function testCreate()
    {
        $data = [
            'name' => 'Test content',
            'class' => 'service\components\contents\TestContent',
            'url_tpl' => 'http:\/\/some\.server\/.+',
            'auth_url' => 'http://some.server/login',
            'downloadable' => 1,
            'streamable' => 1,
            'storable' => 1,
            'use_proxy' => 1,
            'status' => 'INACTIVE'
        ];

        $provider = new ContentProvider();
        $provider->setScenario(ContentProvider::SCENARIO_CREATE);
        $provider->load($data, '');

        $this->assertTrue($provider->save());

        $provider->refresh();

        $query = new Query();
        $query->from(ContentProvider::tableName());
        $query->where(['name' => $data['name']]);

        $this->assertEquals(1, $query->count());

        $this->assertEquals('Test content', $provider->name);
        $this->assertEquals('service\components\contents\TestContent', $provider->class);
        $this->assertEquals('http:\/\/some\.server\/.+', $provider->url_tpl);
        $this->assertEquals('http://some.server/login', $provider->auth_url);
        $this->assertTrue($provider->isDownloadable());
        $this->assertTrue($provider->isStorable());
        $this->assertTrue($provider->isStreamable());
        $this->assertTrue($provider->isUsingProxy());
        $this->assertEquals('INACTIVE', $provider->status);
    }

    public function testCreateWithInvalidData()
    {
        $data = [
            'name' => '',
            'class' => '',
            'url_tpl' => '',
            'auth_url' => '',
            'downloadable' => 2,
            'streamable' => 2,
            'storable' => 2,
            'use_proxy' => 1,
            'status' => 'INVALIDSTATE'
        ];

        $provider = new ContentProvider();
        $provider->setScenario(ContentProvider::SCENARIO_CREATE);
        $provider->load($data, '');

        $this->assertFalse($provider->save());
    }

    public function testUpdate()
    {
        $data = [
            'name' => 'Another test content',
            'class' => 'service\components\contents\TestContent',
            'url_tpl' => 'http:\/\/some\.server\/.+',
            'auth_url' => 'http://some.server/login',
            'downloadable' => 1,
            'streamable' => 1,
            'storable' => 1,
            'use_proxy' => 1,
            'status' => 'INACTIVE'
        ];

        $provider = ContentProvider::findOne(1);
        $provider->setScenario(ContentProvider::SCENARIO_UPDATE);
        $provider->load($data, '');

        $this->assertTrue($provider->save());

        $provider->refresh();

        $query = new Query();
        $query->from(ContentProvider::tableName());
        $query->where(['name' => $data['name']]);

        $this->assertEquals(1, $query->count());

        $this->assertEquals('Another test content', $provider->name);
        $this->assertEquals('service\components\contents\TestContent', $provider->class);
        $this->assertEquals('http:\/\/some\.server\/.+', $provider->url_tpl);
        $this->assertEquals('http://some.server/login', $provider->auth_url);
        $this->assertTrue($provider->isDownloadable());
        $this->assertTrue($provider->isStorable());
        $this->assertTrue($provider->isStreamable());
        $this->assertTrue($provider->isUsingProxy());
        $this->assertEquals('INACTIVE', $provider->status);
    }

    public function testUpdateWithInvalidData()
    {
        $data = [
            'name' => '',
            'class' => '',
            'url_tpl' => '',
            'auth_url' => '',
            'downloadable' => 2,
            'streamable' => 2,
            'storable' => 2,
            'use_proxy' => 1,
            'status' => 'INVALIDSTATE'
        ];

        $provider = ContentProvider::findOne(1);
        $provider->setScenario(ContentProvider::SCENARIO_UPDATE);
        $provider->load($data, '');

        $this->assertFalse($provider->save());
    }

    public function testDelete()
    {
        $provider = ContentProvider::findOne(1);
        $provider->setScenario(ContentProvider::SCENARIO_DELETE);

        $this->assertEquals(1, $provider->delete());
    }

    public function testGetCredential()
    {
        $provider = ContentProvider::findOne(3);
        $credential = $provider->getCredential();

        $this->assertEquals(4, $credential->id);

        $provider = ContentProvider::findOne(4);
        $credential = $provider->getCredential();

        $this->assertEquals(2, $credential->id);

        $provider = ContentProvider::findOne(5);
        $credential = $provider->getCredential();

        $this->assertEquals(null, $credential);
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
            'link' => [
                'class' => LinkFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/links.php',
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
