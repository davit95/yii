<?php

namespace tests\codeception\service\unit\components;

use Yii;
use tests\codeception\service\unit\TestCase;
use tests\codeception\service\fixtures\InstanceFixture;
use tests\codeception\service\fixtures\LinkFixture;
use tests\codeception\service\fixtures\CredentialFixture;
use tests\codeception\service\fixtures\ContentProviderFixture;
use tests\codeception\service\fixtures\ContentProviderCredentialFixture;
use service\components\storages\FtpStorage;

class FtpStorageTest extends TestCase
{
    public function testStorage()
    {
        $storage = new FtpStorage();
        $storage->setHost(FTP_STORAGE_HOST);
        $storage->setPort(FTP_STORAGE_PORT);
        $storage->setUsername(FTP_STORAGE_USERNAME);
        $storage->setPassword(FTP_STORAGE_PASSWORD);
        $storage->setRoot(FTP_STORAGE_ROOT);
        //Test storage info
        $this->assertNotEmpty((array)$storage);
        //Test create new file
        $fileName = $storage->createFile('file.bin');
        $this->assertTrue((bool)strpos($fileName, 'file.bin'));
        //Test file exists
        $this->assertTrue($storage->exists($fileName));
        $this->assertFalse($storage->exists('invalid.file.bin'));
        //Test list storage
        $dirList = $storage->ls();
        $this->assertNotEmpty($dirList);
        //Test create content
        $content = $storage->getFileContent($fileName);
        $this->assertInstanceOf('service\components\contents\FtpContent', $content);
        //Test write to file
        $context = $content->createStreamContext();
        $stream = $content->createStream($context, 'w');
        $this->assertNotFalse($stream->write('test'));
        $stream->close();
        //Test read from file
        $context = $content->createStreamContext();
        $stream = $content->createStream($context, 'r');
        $this->assertEquals('test', $stream->read(4));
        $stream->close();
        //Test partial content
        $context = $content->createStreamContext();
        $stream = $content->createStream($context, 'r', ['rangeStart' => 1, 'rangeEnd' => 2]);
        $this->assertEquals('es', $stream->read());
        $stream->close();
        //Test storage size
        $this->assertGreaterThan(0, $storage->getSize());
        //Remove file
        $this->assertTrue($storage->removeFile($fileName));
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
        ];
    }
}
