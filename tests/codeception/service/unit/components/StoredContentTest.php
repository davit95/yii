<?php

namespace tests\codeception\service\unit\components;

use Yii;
use tests\codeception\service\unit\TestCase;
use tests\codeception\service\fixtures\InstanceFixture;
use tests\codeception\service\fixtures\LinkFixture;
use tests\codeception\service\fixtures\StoredContentFixture;
use tests\codeception\service\fixtures\StoredContentChunkFixture;
use service\models\Link;
use service\components\StoredContent;

class StoredContentTest extends TestCase
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
        $link = Link::findOne(7);

        $ch = curl_init($link->getDownloadLink());
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($ch);

        $this->assertEquals('Integer id turpis tortor. Sed sodales imperdiet mollis. Nullam tellus lorem, blandit ac gravida sed.', $resp);

        curl_close($ch);
    }

    public function testPartialContentDownload()
    {
        $link = Link::findOne(7);

        $ch = curl_init($link->getDownloadLink());
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Range: bytes=0-6']);
        $resp = curl_exec($ch);

        $this->assertEquals('Integer', $resp);

        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Range: bytes=99-99']);
        $resp = curl_exec($ch);

        $this->assertEquals('.', $resp);

        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Range: bytes=0-']);
        $resp = curl_exec($ch);

        $this->assertEquals('Integer id turpis tortor. Sed sodales imperdiet mollis. Nullam tellus lorem, blandit ac gravida sed.', $resp);

        curl_close($ch);
    }

    public function fixtures()
    {
        return [
            'instance' => [
                'class' => InstanceFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/instances.php',
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
