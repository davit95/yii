<?php

namespace tests\codeception\service\unit\models;

use Yii;
use tests\codeception\service\unit\DbTestCase;
use tests\codeception\service\fixtures\InstanceFixture;
use tests\codeception\service\fixtures\LinkFixture;
use tests\codeception\service\fixtures\CredentialFixture;
use tests\codeception\service\fixtures\ContentProviderFixture;
use tests\codeception\service\fixtures\ContentProviderCredentialFixture;
use yii\db\Query;
use service\models\Link;

class LinkModelTest extends DbTestCase
{
    public function testCreate()
    {
        $data = [
            'user_id' => 1,
            'link' => CONTENTS_URL.'/bin_file.bin'
        ];

        $link = new Link();
        $link->setScenario(Link::SCENARIO_CREATE);
        $link->load($data, '');

        $this->assertTrue($link->save());

        $link->refresh();

        $this->linkHash = $link->hash;

        $query = new Query();
        $query->from(Link::tableName());
        $query->where(['link' => $data['link']]);

        $this->assertGreaterThan(1, $query->count());

        $this->assertEquals('bin_file.bin', $link->getContentName());
        $this->assertEquals(10485760, $link->getContentSize());
        $this->assertNotEmpty($link->hash);
        $this->assertNotEmpty($link->getDownloadLink());
        $this->assertNotEmpty($link->getStreamLink());
        $this->assertFalse($link->hasPassword());
    }

    public function testCreateWithPassword()
    {
        $data = [
            'user_id' => 1,
            'link' => CONTENTS_URL.'/bin_file.bin',
            'password' => 'p@ssword'
        ];

        $link = new Link();
        $link->setScenario(Link::SCENARIO_CREATE);
        $link->load($data, '');

        $this->assertTrue($link->save());

        $link->refresh();

        $query = new Query();
        $query->from(Link::tableName());
        $query->where(['link' => $data['link']]);

        $this->assertGreaterThan(1, $query->count());

        $this->assertEquals('bin_file.bin', $link->getContentName());
        $this->assertEquals(10485760, $link->getContentSize());
        $this->assertNotEmpty($link->hash);
        $this->assertNotEmpty($link->getDownloadLink());
        $this->assertNotEmpty($link->getStreamLink());
        $this->assertTrue($link->hasPassword());
        $this->assertEquals('p@ssword', $link->getPassword());
    }

    public function testCreateWithInvalidLink()
    {
        $data = [
            'user_id' => 1,
            'link' => CONTENTS_URL.'/invalid_file.bin'
        ];

        $link = new Link();
        $link->setScenario(Link::SCENARIO_CREATE);
        $link->load($data, '');

        $this->assertFalse($link->save());

        $query = new Query();
        $query->from(Link::tableName());
        $query->where(['link' => $data['link']]);

        $this->assertEquals(0, $query->count());
    }

    public function testCreateWithInactiveProvider()
    {
        $data = [
            'user_id' => 1,
            'link' => 'http://some,server/file.bin'
        ];

        $link = new Link();
        $link->setScenario(Link::SCENARIO_CREATE);
        $link->load($data, '');

        $this->assertFalse($link->save());

        $query = new Query();
        $query->from(Link::tableName());
        $query->where(['link' => 'http://some,server/file.bin']);

        $this->assertEquals(0, $query->count());
    }

    public function testFindByHash()
    {
        $hash = '5f76ce4d55fae4f5049a583a69ca40bc3e85b6f8';

        $this->assertInstanceOf('service\models\Link', Link::findByHash($hash)->one());
    }

    public function testDelete()
    {
        $link = Link::findOne(1);
        $link->setScenario(Link::SCENARIO_DELETE);

        $this->assertEquals(1, $link->delete());
    }

    public function fixtures()
    {
        return [
            'instance' => [
                'class' => InstanceFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/instances.php',
            ],
            'content_provider' => [
                'class' => ContentProviderFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/content_providers.php',
            ],
            'credential' => [
                'class' => CredentialFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/credentials.php',
            ],
            'content_provider_credential' => [
                'class' => ContentProviderCredentialFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/content_providers_credentials.php',
            ],
            'link' => [
                'class' => LinkFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/links.php',
            ],
        ];
    }
}
