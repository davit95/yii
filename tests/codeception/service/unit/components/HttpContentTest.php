<?php

namespace tests\codeception\service\unit\components;

use Yii;
use tests\codeception\service\unit\TestCase;
use tests\codeception\service\fixtures\InstanceFixture;
use tests\codeception\service\fixtures\LinkFixture;
use tests\codeception\service\fixtures\CredentialFixture;
use tests\codeception\service\fixtures\ContentProviderFixture;
use tests\codeception\service\fixtures\ContentProviderCredentialFixture;
use yii\db\Query;
use service\models\Link;
use service\components\contents\HttpContent;

class HttpContentTest extends TestCase
{
    public function testCreateInstance()
    {
        $link = Link::findOne(1);
        $provider = $link->getContentProvider();

        $content = new HttpContent($link, $provider);

        $this->assertEquals($link->content_name, $content->name);
        $this->assertEquals($link->content_size, $content->length);
        $this->assertEquals('application/octet-stream', $content->mimeType);
    }

    public function testCreateContentStream()
    {
        $link = Link::findOne(1);
        $provider = $link->getContentProvider();

        $content = new HttpContent($link, $provider);
        $stream = $content->createStream();

        $this->assertInstanceOf('service\components\contents\HTTPContentStream', $stream);

        $stream->close();
    }

    public function testCreatePartialContentStream()
    {
        $link = Link::findOne(1);
        $provider = $link->getContentProvider();

        $content = new HttpContent($link, $provider);
        $context = $content->createStreamContext();
        $stream = $content->createStream($context, 'r', ['rangeStart' => 5, 'rangeEnd' => 10]);

        $this->assertInstanceOf('service\components\contents\HTTPContentStream', $stream);

        $stream->close();
    }

    public function testReadFromContentStream()
    {
        $link = Link::findOne(5);
        $provider = $link->getContentProvider();

        $content = new HttpContent($link, $provider);
        $stream = $content->createStream();

        $this->assertEquals('BEGIN', $stream->read(5));

        $stream->close();
    }

    public function testReadFromPartialContentStream()
    {
        $link = Link::findOne(5);
        $provider = $link->getContentProvider();

        $content = new HttpContent($link, $provider);
        $context = $content->createStreamContext();
        $stream = $content->createStream($context, 'r', ['rangeStart' => 7, 'rangeEnd' => 11]);

        $this->assertEquals('Lorem', $stream->read(5));

        $stream->close();
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
