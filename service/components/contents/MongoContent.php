<?php

namespace service\components\contents;

use yii\base\Exception;
use \MongoDB\GridFS\Bucket;
use \MongoDB\Driver\Manager;
use \MongoDB\Collection;
use \MongoDB\GridFS\CollectionWrapper;

class MongoContent extends Content
{
    private $dsn;
    private $username;
    private $password;
    private $host;
    private $port;
    private $database;
    private $bucketName;
    private $fileName;
    private $manager;
    private $bucket;
    private $collection;
    private $file;

    /**
     * @inheritdoc
     */
    public function __construct($url)
    {
        $this->setUrl($url);

        parent::__construct($url);
    }

    /**
     * @inheritdoc
     */
    public function setUrl($url)
    {
        if (!preg_match('/^gridfs:\/\/(.+):(.+)@([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}):(\d+)\/(.+)\/(.+)\/(.+)$/', $url, $matches)) {
            throw new Exception('Invalid URL.');
        }

        $this->username = $matches[1];
        $this->password = $matches[2];
        $this->host = $matches[3];
        $this->port = $matches[4];
        $this->database = $matches[5];
        $this->dsn = sprintf(
            '%s://%s:%s@%s:%s/%s',
            'mongodb',
            $this->username,
            $this->password,
            $this->host,
            $this->port,
            $this->database
        );
        $this->bucketName = $matches[6];
        $this->fileName = $matches[7];

        $bucket = $this->getBucket();
        $file = $this->getCollection()->findFileByFilenameAndRevision($this->fileName, -1);

        if ($file === null) {
            throw new Exception('File not found.');
        }

        $fileId = (string)$file->_id;

        $this->url = sprintf(
            '%s://%s/%s.files/%s',
            'gridfs',
            urlencode($this->database),
            urlencode($this->bucketName),
            urlencode($fileId)
        );
    }

    /**
     * Returns Mongo DB manager
     *
     * @return MongoDB\Driver\Manager
     */
    private function getManager()
    {
        if ($this->manager === null) {
            $this->manager = new Manager($this->dsn, ['connectTimeoutMS' => 10000]);
        }

        return $this->manager;
    }

    /**
     * Returns GridFs bucket
     *
     * @return \MongoDB\GridFS\Bucket
     */
    private function getBucket()
    {
        if ($this->bucket == null) {
            $this->bucket = new Bucket($this->getManager(), $this->database, ['bucketName' => $this->bucketName]);
        }

        return $this->bucket;
    }

    /**
     * Returns collection
     *
     * @return \MongoDB\GridFS\CollectionWrapper
     */
    private function getCollection()
    {
        if ($this->collection == null) {
            $this->collection = new CollectionWrapper($this->getManager(), $this->database, $this->bucketName);
        }

        return $this->collection;
    }

    /**
     * Returns chunks collection
     *
     * @return \MongoDB\GridFS\Collection
     */
    private function getChunksCollection()
    {
        if ($this->chunksCollection == null) {
            $this->chunksCollection = new Collection($this->getManager(), $this->database, sprintf('%s.chunks', $this->bucketName));
        }

        return $this->chunksCollection;
    }

    /**
     * @inheritdoc
     */
    public function createStreamContext()
    {
        $context = new MongoContentStreamContext();
        return $context;
    }

    /**
     * @inheritdoc
     */
    public function createStream(ContentStreamContext $context = null, $mode = 'r', $params = [])
    {
        if ($context === null) {
            $context = $this->createStreamContext();
        }

        $file = $this->getCollection()->findFileByFilenameAndRevision($this->fileName, -1);

        if ($mode === 'r') {
            $context->setOption('gridfs', 'collectionWrapper', $this->getCollection());
            $context->setOption('gridfs', 'file', $file);
        } else if ($mode === 'w') {
            $options = [
                '_id' => $file->_id,
                'readPreference' => 1,
                'writeConcern' => 1,
                'metadata' => [
                    'originalname' => $file->metadata->originalname
                ]
            ];

            $context->setOption('gridfs', 'collectionWrapper', $this->getCollection());
            $context->setOption('gridfs', 'filename', $this->fileName);
            $context->setOption('gridfs', 'options', $options);

            //Remove existing file and it's chunks due mongodb lib will not do this.
            $this->getBucket()->delete($file->_id);
        }

        return new MongoContentStream($this->url, $context, $mode, $params);
    }

}
