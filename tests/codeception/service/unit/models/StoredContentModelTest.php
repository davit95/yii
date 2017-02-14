<?php

namespace tests\codeception\service\unit\models;

use Yii;
use tests\codeception\service\unit\DbTestCase;
use tests\codeception\service\fixtures\InstanceFixture;
use tests\codeception\service\fixtures\StoredContentFixture;
use tests\codeception\service\fixtures\StoredContentChunkFixture;
use yii\db\Query;
use service\models\StoredContent;
use service\models\StoredContentChunk;

class StoredContentModelTest extends DbTestCase
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

    public function testCreate()
    {
        $data = [
            'name' => 'file.dat',
            'size' => 100,
            'ext_url' => 'http://server.name/file.dat',
            'complete' => 0
        ];

        $storedContent = new StoredContent();
        $storedContent->setScenario(StoredContent::SCENARIO_CREATE);
        $storedContent->load($data, '');

        $this->assertTrue($storedContent->save());

        $storedContent->refresh();

        $query = new Query();
        $query->from(StoredContent::tableName());
        $query->where(['name' => 'file.dat']);

        $this->assertEquals(1, $query->count());

        $this->assertEquals('file.dat', $storedContent->name);
        $this->assertEquals(100, $storedContent->size);
        $this->assertEquals('http://server.name/file.dat', $storedContent->ext_url);
        $this->assertEquals(0, $storedContent->complete);
    }

    public function testCreateWithInvalidData()
    {
        $data = [
            'name' => '',
            'size' => -1,
            'ext_url' => '',
            'complete' => 2
        ];

        $storedContent = new StoredContent();
        $storedContent->setScenario(StoredContent::SCENARIO_CREATE);
        $storedContent->load($data, '');

        $this->assertFalse($storedContent->save());
    }

    public function testUpdate()
    {
        $data = [
            'name' => 'another_file.dat',
            'size' => 200,
            'ext_url' => 'http://another.server.name/file.dat',
            'complete' => 1
        ];

        $storedContent = StoredContent::findOne(1);
        $storedContent->setScenario(StoredContent::SCENARIO_UPDATE);
        $storedContent->load($data, '');

        $this->assertTrue($storedContent->save());

        $storedContent->refresh();

        $query = new Query();
        $query->from(StoredContent::tableName());
        $query->where(['name' => 'another_file.dat']);

        $this->assertEquals(1, $query->count());

        $this->assertEquals('another_file.dat', $storedContent->name);
        $this->assertEquals(200, $storedContent->size);
        $this->assertEquals('http://another.server.name/file.dat', $storedContent->ext_url);
        $this->assertEquals(1, $storedContent->complete);
    }

    public function testUpdateWithInvalidaData()
    {
        $data = [
            'name' => '',
            'size' => -1,
            'ext_url' => '',
            'complete' => 2
        ];

        $storedContent = StoredContent::findOne(1);
        $storedContent->setScenario(StoredContent::SCENARIO_UPDATE);
        $storedContent->load($data, '');

        $this->assertFalse($storedContent->save());
    }

    public function testDelete()
    {
        $storedContent = StoredContent::findOne(1);
        $storedContent->setScenario(StoredContent::SCENARIO_DELETE);

        $this->assertEquals(1, $storedContent->delete());

        $query = new Query();
        $query->from(StoredContentChunk::tableName());
        $query->where(['stored_content_id' => 1]);

        $this->assertEquals(0, $query->count());

        $storageDir = Yii::$app->storage->getRoot();
        $this->assertFalse(file_exists($storageDir.'/plg-test-1/stored_file_1.dat.chunk'));
        $this->assertFalse(file_exists($storageDir.'/plg-test-2/stored_file_1.dat.chunk'));
        $this->assertFalse(file_exists($storageDir.'/plg-test-3/stored_file_1.dat.chunk'));
        $this->assertFalse(file_exists($storageDir.'/plg-test-4/stored_file_1.dat.chunk'));
    }

    public function testComplete()
    {
        $storedContent = StoredContent::findOne(1);
        $this->assertTrue($storedContent->isRangeStored(0, 99));
    }

    public function testNotComplete()
    {
        $storedContent = StoredContent::findOne(2);
        $this->assertFalse($storedContent->isRangeStored(0, 49));
    }

    public function fixtures()
    {
        return [
            'instance' => [
                'class' => InstanceFixture::className(),
                'dataFile' => '@tests/codeception/service/unit/fixtures/data/models/instances.php',
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
