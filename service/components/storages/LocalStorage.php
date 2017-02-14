<?php

namespace service\components\storages;

use yii\base\Exception;
use service\components\contents\FileContent;

/**
 * Class implements content storage on local server
 */
class LocalStorage extends Storage
{
    /**
     * @inheritdoc
     */
    protected function prepareEntity($entity)
    {
        if ($entity != '/') {
            $entity = trim($entity,'/');
        }

        if (strpos($entity, $this->getRoot()) === 0) {
            return $entity;
        }

        if ($entity == '/') {
            return $this->getRoot();
        } else if (strpos($entity, '/') === 0) {
            return $this->getRoot().$entity;
        } else {
            return $this->getRoot().'/'.$entity;
        }
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
        if (!@is_dir($root) || !@is_writable($root)) {
            throw new Exception('Storage root directory does not exists or is not writable.');
        }

        $this->root = ($root != '/') ? rtrim($root, '/') : $root;
    }

    /**
     * Returns directory size in bytes or false if directory not exists
     *
     * @param  string $directory
     * @return integer|boolean
     */
    protected function lsDirectory($directory)
    {
        $directory = $this->prepareEntity($directory);

        $list = array();

        if (($dh = @opendir($directory)) !== false) {
            while (($child = readdir($dh)) !== false) {
                if ($child != '.' && $child != '..') {
                    if (@is_dir($directory.'/'.$child)) {
                        $list = array_merge($list, $this->lsDirectory($directory.'/'.$child));
                    } else {
                        $list[] = str_ireplace($this->getRoot().'/', '', $directory.'/'.$child);
                    }
                }
            }
            closedir($dh);
        }

        return $list;
    }

    /**
     * @inheritdoc
     */
    public function ls()
    {
        if (!$this->exists('/')) {
            return false;
        }

        return $this->lsDirectory('/');
    }

    /**
     * Returns directory size in bytes or false if directory not exists
     *
     * @param  string $directory
     * @return integer|boolean
     */
    protected function getDirectorySize($directory)
    {
        $directory = $this->prepareEntity($directory);

        $size = 0;

        if (($dh = @opendir($directory)) !== false) {
            while (($child = readdir($dh)) !== false) {
                if ($child != '.' && $child != '..') {
                    if (@is_dir($directory.'/'.$child)) {
                        $size += (int)$this->getDirectorySize($directory.'/'.$child);
                    } else {
                        $size += (int)$this->getFileSize($directory.'/'.$child);
                    }
                }
            }
            closedir($dh);
        }

        return $size;
    }

    /**
     * @inheritdoc
     */
    public function getSize()
    {
        if (!$this->exists('/')) {
            return false;
        }

        return $this->getDirectorySize('/');
    }

    /**
     * @inheritdoc
     */
    public function createFile($file)
    {
        if (preg_match('/[:\\/]+/', $file)) {
            return false;
        }

        $dir = uniqid('plg-', true);
        $pDir = $this->prepareEntity($dir);
        if ($this->exists($pDir)) {
            return false;
        }

        if (!@mkdir($pDir, 0775)) {
            return false;
        }

        $file = $dir.'/'.$file;

        $pFile = $this->prepareEntity($file);

        if (($fh = @fopen($pFile, 'w')) !== false) {
            fclose($fh);
            @chmod($pFile, 0775);
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
        $file = $this->prepareEntity($file);
        $dir = dirname($file);

        if (@unlink($file) !== false) {
            @rmdir($dir);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function getFileContent($file)
    {
        $path = $this->getAbsolutePath($file);
        if ($path) {
            return new FileContent($path);
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getFileSize($file)
    {
        $file = $this->prepareEntity($file);

        if (!$this->exists($file)) {
            return false;
        }

        return filesize($file);
    }

    /**
     * @inheritdoc
     */
    public function exists($entity)
    {
        $entity = $this->prepareEntity($entity);
        return @file_exists($entity);
    }

    /**
     * @inheritdoc
     */
    public function isReadable($entity)
    {
        $entity = $this->prepareEntity($entity);
        return @is_readable($entity);
    }

    /**
     * @inheritdoc
     */
    public function isWritable($entity)
    {
        $entity = $this->prepareEntity($entity);
        return @is_writable($entity);
    }

    /**
     * @inheritdoc
     */
    public function getAbsolutePath($entity)
    {
        $entity = $this->prepareEntity($entity);
        return realpath($entity);
    }
}
