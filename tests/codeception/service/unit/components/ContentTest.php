<?php

namespace tests\codeception\service\unit\components;

use Yii;
use tests\codeception\service\unit\TestCase;
use tests\codeception\service\fixtures\InstanceFixture;
use tests\codeception\service\fixtures\CredentialFixture;
use tests\codeception\service\fixtures\ContentProviderFixture;
use tests\codeception\service\fixtures\ContentProviderCredentialFixture;
use tests\codeception\service\fixtures\LinkFixture;
use tests\codeception\service\fixtures\StoredContentFixture;
use tests\codeception\service\fixtures\StoredContentChunkFixture;
use service\models\Link;
use service\models\StoredContent;

class ContentTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $storageDir = Yii::$app->storage->getRoot();
        \Codeception\Util\FileSystem::copyDir(CHUNKS_SAMPLES_DIR, $storageDir);
    }

    public function tearDown()
    {
        $storageDir = Yii::$app->storage->getRoot();
        \Codeception\Util\FileSystem::doEmptyDir($storageDir);

        parent::tearDown();
    }

    public function testDownloadContent()
    {
        $link = Link::findOne(5);

        $ch = curl_init($link->getDownloadLink());
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($ch);

        $this->assertEquals('38ec7986c124622db943bc85fa27e419', md5($resp));

        curl_close($ch);
    }

    public function testPartialContentDownload()
    {
        $link = Link::findOne(5);

        $ch = curl_init($link->getDownloadLink());
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Range: bytes=0-4']);
        $resp = curl_exec($ch);

        $this->assertEquals('BEGIN', $resp);

        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Range: bytes=3027-3027']);
        $resp = curl_exec($ch);

        $this->assertEquals('D', $resp);

        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Range: bytes=0-']);
        $resp = curl_exec($ch);

        $this->assertEquals('38ec7986c124622db943bc85fa27e419', md5($resp));

        curl_close($ch);
    }

    public function testStoring()
    {
        $link = Link::findOne(5);

        $ch = curl_init($link->getDownloadLink());
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($ch);

        $storedContent = StoredContent::findByLink($link);

        $this->assertInstanceOf(StoredContent::className(), $storedContent);
        $this->assertTrue($storedContent->isComplete());
        $this->assertTrue(!empty($storedContent->chunks));

        curl_close($ch);
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
            'stored_content' => [
                'class' => StoredContentFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/stored_contents.php',
            ],
            'stored_content_chunk' => [
                'class' => StoredContentChunkFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/stored_content_chunks.php',
            ]
        ];
    }
}
