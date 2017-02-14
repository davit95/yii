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

class StoredContentChunkModelTest extends DbTestCase
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
            'stored_content_id' => 3,
            'start' => 0,
            'end' => 9,
            'length' => 10,
            'locked' => 1
        ];

        $storedContentChunk = new StoredContentChunk();
        $storedContentChunk->setScenario(StoredContentChunk::SCENARIO_CREATE);
        $storedContentChunk->load($data, '');

        $this->assertTrue($storedContentChunk->save());

        $storedContentChunk->refresh();

        $query = new Query();
        $query->from(StoredContentChunk::tableName());
        $query->where(['stored_content_id' => '3']);

        $this->assertEquals(1, $query->count());

        $this->assertEquals(3, $storedContentChunk->stored_content_id);
        $this->assertEquals(0, $storedContentChunk->start);
        $this->assertEquals(9, $storedContentChunk->end);
        $this->assertEquals(10, $storedContentChunk->length);
        $this->assertEquals(1, $storedContentChunk->locked);

        $storageDir = Yii::$app->storage->getRoot();
        $this->assertTrue(file_exists($storageDir.'/'.$storedContentChunk->file));
    }

    public function testCreateWithInvalidData()
    {
        $data = [
            'stored_content_id' => 0,
            'start' => -1,
            'end' => -1,
            'length' => -1
        ];

        $storedContentChunk = new StoredContentChunk();
        $storedContentChunk->setScenario(StoredContentChunk::SCENARIO_CREATE);
        $storedContentChunk->load($data, '');

        $this->assertFalse($storedContentChunk->save());
    }

    public function testUpdate()
    {
        $data = [
            'stored_content_id' => 4,
            'start' => 1,
            'end' => 8,
            'length' => 8,
            'locked' => 1
        ];

        $storedContentChunk = StoredContentChunk::findOne(1);
        $storedContentChunk->setScenario(StoredContentChunk::SCENARIO_UPDATE);
        $storedContentChunk->load($data, '');

        $this->assertTrue($storedContentChunk->save());

        $storedContentChunk->refresh();

        $query = new Query();
        $query->from(StoredContentChunk::tableName());
        $query->where(['stored_content_id' => 4]);

        $this->assertEquals(1, $query->count());

        $this->assertEquals(4, $storedContentChunk->stored_content_id);
        $this->assertEquals(1, $storedContentChunk->start);
        $this->assertEquals(8, $storedContentChunk->end);
        $this->assertEquals(8, $storedContentChunk->length);
        $this->assertEquals(1, $storedContentChunk->locked);

        $storageDir = Yii::$app->storage->getRoot();
        $this->assertTrue(file_exists($storageDir.'/'.$storedContentChunk->file));
    }

    public function testUpdateWithInvalidaData()
    {
        $data = [
            'stored_content_id' => 0,
            'start' => -1,
            'end' => -1,
            'length' => -1
        ];

        $storedContentChunk = StoredContentChunk::findOne(1);
        $storedContentChunk->setScenario(StoredContentChunk::SCENARIO_UPDATE);
        $storedContentChunk->load($data, '');

        $this->assertFalse($storedContentChunk->save());
    }

    public function testDelete()
    {
        $storedContentChunk = StoredContentChunk::findOne(1);
        $storedContentChunk->setScenario(StoredContent::SCENARIO_DELETE);

        $this->assertEquals(1, $storedContentChunk->delete());

        $storageDir = Yii::$app->storage->getRoot();
        $this->assertFalse(file_exists($storageDir.'/'.$storedContentChunk->file));
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
