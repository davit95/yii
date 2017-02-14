<?php

namespace service\components\storages;

use yii\base\exception;
use \MongoDB\Collection;
use \MongoDB\GridFS\Bucket;
use \MongoDB\Driver\Manager;
use \MongoDB\GridFS\CollectionWrapper;
use service\components\contents\MongoContent;

/**
 * Class implements content storage on server using MongoDB+GridFS
 */
class MongoStorage extends Storage
{
    protected $dsn;
    protected $root;
    protected $username;
    protected $password;
    protected $host;
    protected $port;
    protected $database;
    protected $manager;
    protected $gridFsBucket;

    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        if (!in_array('mongodb', get_loaded_extensions())) {
            throw new Exception('MongoDb extension is required to use MongoDb storage.');
        }

        parent::__construct($config);
    }

    /**
     * Returns DSN
     *
     * @return string
     */
    private function getDsn()
    {
        return $this->dsn;
    }

    /**
     * Sets DSN
     *
     * @param string $host
     */
    public function setDsn($dsn)
    {
        if (!preg_match('/^mongodb:\/\/(.+):(.+)@([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}):(\d+)\/(.+)$/', $dsn)) {
            throw new Exception('Invalid DSN.');
        }

        $this->dsn = $dsn;
    }

    /**
     * Parses DSN to fetch connection data
     *
     * @return void
     */
    protected function parseDsn()
    {
        preg_match('/^mongodb:\/\/(.+):(.+)@([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}):(\d+)\/(.+)$/', $this->getDsn(), $matches);
        $this->username = isset($matches[1]) ? $matches[1] : null;
        $this->password = isset($matches[2]) ? $matches[2] : null;
        $this->host = isset($matches[3]) ? $matches[3] : null;
        $this->port = isset($matches[4]) ? $matches[4] : null;
        $this->database = isset($matches[5]) ? $matches[5] : null;
    }

    /**
     * Returns database
     *
     * @return string
     */
    protected function getDatabase()
    {
        if ($this->database === null) {
            $this->parseDsn();
        }

        return $this->database;
    }

    /**
     * Returns username
     *
     * @return string
     */
    protected function getUsername()
    {
        if ($this->username === null) {
            $this->parseDsn();
        }

        return $this->username;
    }

    /**
     * Returns password
     *
     * @return string
     */
    protected function getPassword()
    {
        if ($this->password === null) {
            $this->parseDsn();
        }

        return $this->password;
    }

    /**
     * Returns host
     *
     * @return string
     */
    protected function getHost()
    {
        if ($this->host === null) {
            $this->parseDsn();
        }

        return $this->host;
    }

    /**
     * Returns port
     *
     * @return string
     */
    protected function getPort()
    {
        if ($this->port === null) {
            $this->parseDsn();
        }

        return $this->port;
    }

    /**
     * Returns Mongo DB manager
     *
     * @return MongoDB\Driver\Manager
     */
    protected function getManager()
    {
        if ($this->manager === null) {
            $this->manager = new Manager($this->getDsn(), ['connectTimeoutMS' => 10000]);
        }

        return $this->manager;
    }

    /**
     * Returns GridFs bucket
     *
     * @return string
     */
    protected function getGridFsBucket()
    {
        if ($this->gridFsBucket == null) {
            $this->gridFsBucket = new Bucket($this->getManager(), $this->getDatabase(), ['bucketName' => $this->getRoot()]);
        }

        return $this->gridFsBucket;
    }

    /**
     * @inheritdoc
     */
    protected function prepareEntity($entity)
    {
        return $entity;
    }

    /**
     * @inheritdoc
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @inheritdoc
     */
    public function setRoot($root)
    {
        //You may consider root as GridFs bucket
        $this->root = $root;
    }

    /**
     * @inheritdoc
     */
    public function ls()
    {
        $list = array();

        $coll = new CollectionWrapper($this->getManager(), $this->getDatabase(), $this->getRoot());
        $files = $coll->findFiles([]);
        if (!empty($files)) {
            $files = $files->toArray();
            foreach ($files as $file) {
                $list[] = $file['filename'];
            }
        }

        return $list;
    }

    /**
     * @inheritdoc
     */
    public function getSize()
    {
        $stage = json_decode('{"$group": {"_id": "null", "size": {"$sum": "$length"}}}', true);

        $coll = new Collection($this->getManager(), $this->getDatabase(), 'fs.files');
        $docs = $coll->aggregate([$stage])->toArray();
        if (empty($docs)) {
            return 0;
        }
        return (int)$docs[0]['size'];
    }

    /**
     * @inheritdoc
     */
    public function createFile($file)
    {
        if (preg_match('/[:\\/]+/', $file)) {
            return false;
        }

        $options = [
            'metadata' => [
                'originalname' => $file
            ]
        ];

        $uid = uniqid('plg-', true);
        $file = $uid.'\\'.$file;
        $this->prepareEntity($file);

        $gridFsBucket = $this->getGridFsBucket();

        if (($fh = @$gridFsBucket->openUploadStream($file, $options)) !== false) {
            fclose($fh);
        } else {
            return false;
        }

        return $file;
    }

    /**
     * @inheritdoc
     */
     public function removeFile($file)
     {
         $coll = new CollectionWrapper($this->getManager(), $this->getDatabase(), $this->getRoot());
         $file = $coll->findFileByFilenameAndRevision($file, -1);
         if ($file === null) {
             return false;
         }
         $gridFsBucket = $this->getGridFsBucket();
         try {
             $gridFsBucket->delete($file->_id);
         } catch (\Exception $e) {
             return false;
         }

         return true;
     }

    /**
     * @inheritdoc
     */
    public function getFileContent($file)
    {
        $path = $this->getAbsolutePath($file);
        if ($path) {
            return new MongoContent($path);
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getFileSize($file)
    {
        $coll = new CollectionWrapper($this->getManager(), $this->getDatabase(), $this->getRoot());
        $file = $coll->findFileByFilenameAndRevision($file, -1);
        if ($file === null) {
            return false;
        }

        return $file->length;
    }

    /**
     * @inheritdoc
     */
    public function exists($entity)
    {
        $coll = new CollectionWrapper($this->getManager(), $this->getDatabase(), $this->getRoot());
        $file = $coll->findFileByFilenameAndRevision($entity, -1);

        return ($file !== null);
    }

    /**
     * @inheritdoc
     */
    public function isReadable($entity)
    {
        $filter = json_decode('{"user": "'.$this->getUsername().'"}', true);

        $coll = new Collection($this->getManager(), $this->getDatabase(), 'system.users');
        $doc = $coll->findOne($filter);
        if ($doc === null) {
            return false;
        }

        return !empty(array_intersect(['read', 'readWrite'], (array)$doc['roles']));
    }

    /**
     * @inheritdoc
     */
    public function isWritable($entity)
    {
        $filter = json_decode('{"user": "'.$this->getUsername().'"}', true);

        $coll = new Collection($this->getManager(), $this->getDatabase(), 'system.users');
        $doc = $coll->findOne($filter);
        if ($doc === null) {
            return false;
        }

        return !empty(array_intersect(['readWrite'], (array)$doc['roles']));
    }

    /**
     * @inheritdoc
     */
     public function getAbsolutePath($entity)
     {
         if (!$this->exists($entity)) {
             return false;
         }

         return sprintf(
             '%s://%s:%s@%s:%s/%s/%s/%s',
             'gridfs',
             $this->getUsername(),
             $this->getPassword(),
             $this->getHost(),
             $this->getPort(),
             $this->getDatabase(),
             $this->getRoot(),
             $entity
         );
     }
}
