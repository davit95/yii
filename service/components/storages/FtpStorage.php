<?php

namespace service\components\storages;

use yii\base\Exception;
use service\components\contents\FtpContent;

/**
 * Class implements content storage on server via FTP
 */
class FtpStorage extends Storage
{
    protected $host;
    protected $port;
    protected $username;
    protected $password;
    protected $url;

    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        if (!in_array('ftp', stream_get_wrappers())) {
            throw new Exception('No stream wrapper found.');
        }

        parent::__construct($config);
    }

    /**
     * Returns FTP server host
     *
     * @return string
     */
    private function getHost()
    {
        return $this->host;
    }

    /**
     * Sets FTP server host
     *
     * @param string $host
     */
    public function setHost($host)
    {
        if (!preg_match('/^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$/', $host)) {
            throw new Exception('Invalid host.');
        }

        $this->host = $host;
    }

    /**
     * Returns FTP server port
     *
     * @return integer
     */
    private function getPort()
    {
        return $this->port;
    }

    /**
     * Set FTP server port
     *
     * @param integer $port
     */
    public function setPort($port)
    {
        if (!is_numeric($port) || $port < 0 || $port > 6565536) {
            throw new Exception('Invalid port.');
        }

        $this->port = $port;
    }

    /**
     * Returns FTP server username
     *
     * @return string
     */
    private function getUsername()
    {
        return $this->username;
    }

    /**
     * Sets FTP server username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Gets FTP server password
     *
     * @return string
     */
    private function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets FTP server password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Returns FTP server URL
     *
     * @return string
     */
    protected function getUrl()
    {
        if ($this->url == null) {
            if ($this->host && $this->port) {
                $this->url = $this->host.':'.$this->port;
            }
            if ($this->username && $this->password) {
                $this->url = $this->username.':'.$this->password.'@'.$this->url;
            }
            $this->url = 'ftp://'.$this->url;
        }

        return $this->url;
    }

    /**
     * @inheritdoc
     */
    protected function prepareEntity($entity)
    {
        $entity = str_ireplace($this->getUrl(), '', $entity);
        if ($entity != '/') {
            $entity = trim($entity,'/');
        }

        if ($entity == '/') {
            return $this->getUrl().'/'.$this->getRoot();
        } else if (strpos($entity, $this->getRoot()) === 0) {
            return $this->getUrl().'/'.$entity;
        } else {
            return $this->getUrl().'/'.$this->getRoot().'/'.$entity;
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
        if (!@is_dir($this->getUrl().'/'.$root) || !@is_writable($this->getUrl().'/'.$root)) {
            throw new Exception('Storage root directory does not exists or is not writable.');
        }

        $this->root = $this->root = ($root != '/') ? trim($root, '/') : $root;
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
                        $list[] = str_ireplace($this->getUrl().'/'.$this->getRoot().'/', '', $directory.'/'.$child);
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
            return new FtpContent($path);
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
         return $entity;
     }
}
