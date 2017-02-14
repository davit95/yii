<?php

namespace service\components\storages;

use Yii;
use yii\base\Component;
use yii\base\Arrayable;
use yii\base\ArrayableTrait;

/**
 * Abstract class to handle content storing
 */
abstract class Storage extends Component implements Arrayable
{
    use ArrayableTrait;

    protected $root;

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'root' => [$this, 'getRoot'],
            'size' => [$this, 'getSize'],
            'class' => ['\service\components\storages\Storage', 'className'],
        ];
    }

    /**
     * Ensures that file or directory lays within root directory
     *
     * @return string
     */
    abstract protected function prepareEntity($entity);

    /**
     * Returns storage root
     *
     * @return string
     */
    abstract public function getRoot();

    /**
     * Sets storage root
     *
     * @return string
     */
    abstract public function setRoot($root);

    /**
     * Lists storage contents
     *
     * @return array|boolean
     */
    abstract public function ls();

    /**
     * Returns starage size in bytes or false on error
     *
     * @return integer|boolean
     */
    abstract public function getSize();

    /**
     * Creates empty file
     *
     * @param  string $file
     * @return string|bool internal file name or false on failure
     */
    abstract public function createFile($file);

    /**
     * Removes existing file
     *
     * @param  string $file
     * @return boolean
     */
    abstract public function removeFile($file);

    /**
     * Returns content for given file
     *
     * @param string $file
     * @return Content|boolean
     */
    abstract public function getFileContent($file);

    /**
     * Returns file size in bytes or false if file not exists
     *
     * @param  string $file
     * @return integer|boolean
     */
    abstract public function getFileSize($file);

    /**
     * Checks if file or directory exists
     *
     * @param  string $entity
     * @return boolean
     */
    abstract public function exists($entity);

    /**
     * Checks if file or directory is readable
     *
     * @param  string $entity
     * @return boolean
     */
    abstract public function isReadable($entity);

    /**
     * Checks if file or directory is writable
     *
     * @param  string $entity
     * @return boolean
     */
    abstract public function isWritable($entity);

    /**
     * Return absolute path to file or directory
     *
     * @param  string $entity
     * @return boolean
     */
    abstract public function getAbsolutePath($entity);
}
