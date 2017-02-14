<?php

namespace common\components\clients\service;

use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\base\InvalidParamException;

/**
 * Class is used to interact with services
 */
class Client extends Component
{
    private $baseUrl;
    private $options;

    /**
     * Constructs client object
     *
     * [[options]] is array of options. Avaliable options are:
     * - format defines desired response format (JSON|XML). JSON is default.
     * - auth is array of auth data. Format is :
     * [
     *     'type' => 'basic',
     *     'username' => 'user',
     *     'password' => 'pass'
     * ]
     * or
     * [
     *     'type' => 'bearer',
     *     'accessToken' => 'user's access token',
     * ]
     *
     * @param string $baseUrl base API URL
     * @param array $options  options passed to request
     */
    public function __construct ($baseUrl, $options = [])
    {
        $this->baseUrl = $baseUrl;
        $this->setOptions($options);

        $this->init();
    }

    /**
     * Sets request options
     *
     * @param void
     */
    private function setOptions($options)
    {
        if (is_array($options)) {
            $this->options = $options;
        } else {
            throw new InvalidParamException('Invalid options.');
        }
    }

    /**
     * Returns option value
     *
     * @return mixed
     */
    private function getOption($option, $default = null)
    {
        return (isset($this->options[$option])) ? $this->options[$option] : $default;
    }

    /**
     * Returns list of unrestrained links
     *
     * @param  integer $user user id
     * @return common\components\clients\service\Response
     */
    public function getLinks($user = null)
    {
        $params = ($user != null) ? ['user' => $user] : [];
        $request = new Request('GET',
            $this->baseUrl.'/link/',
            $params,
            $this->options
        );
        return $request->send();
    }

    /**
     * Create new unrestrained link
     *
     * @param  string $url link
     * @param  int $user user id
     * @param  string $password password
     * @return common\components\clients\service\Response
     */
    public function createLink($url, $userId, $password = null)
    {
        $params = ['link' => $url, 'user_id' => $userId];
        if ($password !== null) {
            $params['password'] = $password;
        }

        $request = new Request('POST',
            $this->baseUrl.'/link/create/',
            $params,
            $this->options
        );
        return $request->send();
    }

    /**
     * Deltete existing link
     *
     * @param  int $id link id
     * @return common\components\clients\service\Response
     */
    public function deleteLink($id)
    {
        $request = new Request('DELETE',
            $this->baseUrl."/link/delete/$id",
            [],
            $this->options
        );
        return $request->send();
    }

    /**
     * Returns list of content providers
     *
     * @param  int $offset
     * @param  int $limit
     * @return common\components\clients\service\Response
     */
    public function getContentProviders($offset = 0, $limit = 0)
    {
        $params = ['offset' => $offset, 'limit' => $limit];

        $request = new Request('GET',
            $this->baseUrl.'/content-provider/',
            $params,
            $this->options
        );
        return $request->send();
    }

    /**
     * Returns content provider
     *
     * @param  int $id content provider id
     * @return common\components\clients\service\Response
     */
    public function getContentProvider($id)
    {
        $request = new Request('GET',
            $this->baseUrl."/content-provider/get/$id",
            [],
            $this->options
        );
        return $request->send();
    }

    /**
     * Returns content provider credentials
     *
     * @param  int $id content provider id
     * @return common\components\clients\service\Response
     */
    public function getContentProviderCredentials($id)
    {
        $request = new Request('GET',
            $this->baseUrl."/content-provider/get-credentials/$id",
            [],
            $this->options
        );
        return $request->send();
    }

    /**
     * Checks if content provider is alive
     *
     * @param  int $id content provider id
     * @return common\components\clients\service\Response
     */
    public function isContentProviderAlive($id)
    {
        $request = new Request('GET',
            $this->baseUrl."/content-provider/is-alive/$id",
            [],
            $this->options
        );
        return $request->send();
    }

    /**
     * Create new content provider
     *
     * Creates new content provider using given data.
     * [[data]] array example:
     * ```php
     * [
     *     'name' => 'Content provider',
     *     'class' => 'service\components\ContentProvider',
     *     'url_tpl' => 'http://.*\..*',
     *     'auth_url' => 'http://some.host/login',
     *     'downloadable' => 1,
     *     'streamable' => 1,
     *     'storable' => 0,
     *     'status' => 'ACTIVE'
     * ]
     * ```
     *
     * @param  array $data content provider attributes
     * @return common\components\clients\service\Response
     */
    public function createContentProvider($data)
    {
        $request = new Request('POST',
            $this->baseUrl.'/content-provider/create/',
            $data,
            $this->options
        );
        return $request->send();
    }

    /**
     * Update content provider
     *
     * Update content provider using given data.
     * For [[data]] array example @see Client::createContentProvider()
     *
     * @param  array $data content provider attributes
     * @return common\components\clients\service\Response
     */
    public function updateContentProvider($id, $data)
    {
        $request = new Request('PUT',
            $this->baseUrl."/content-provider/update/$id",
            $data,
            $this->options
        );
        return $request->send();
    }

    /**
     * Get credentilas list
     *
     * @param  int $offset
     * @param  int $limit
     * @return common\components\clients\service\Response
     */
    public function getCredentials($offset = 0, $limit = 0)
    {
        $params = ['offset' => $offset, 'limit' => $limit];
        $request = new Request('GET',
            $this->baseUrl.'/credential/',
            $params,
            $this->options
        );
        return $request->send();
    }

    /**
     * Returns credential with given id
     *
     * @param  int $id credential id
     * @return common\components\clients\service\Response
     */
    public function getCredential($id)
    {
        $request = new Request('GET',
            $this->baseUrl."/credential/get/$id",
            [],
            $this->options
        );
        return $request->send();
    }

    /**
     * Create new credential
     *
     * Creates new credential using given data.
     * [[data]] array example:
     * ```php
     * [
     *    'user' => 'login',
     *    'pass' => 'password123',
     *    'status' => 'ACTIVE'
     * ]
     * ```
     *
     * @param  array $data credential attributes
     * @return common\components\clients\service\Response
     */
    public function createCredential($data)
    {
        $request = new Request('POST',
            $this->baseUrl.'/credential/create/',
            $data,
            $this->options
        );
        return $request->send();
    }

    /**
     * Update credential
     *
     * Update credential using given data.
     * For [[data]] array example @see Client::createCredential()
     *
     * @param  array $data credential attributes
     * @return common\components\clients\service\Response
     */
    public function updateCredential($id, $data)
    {
        $request = new Request('PUT',
            $this->baseUrl."/credential/update/$id",
            $data,
            $this->options
        );
        return $request->send();
    }

    /**
     * Delete exeisting credential
     *
     * @param  int $id credential id
     * @return common\components\clients\service\Response
     */
    public function deleteCredential($id)
    {
        $request = new Request('DELETE',
            $this->baseUrl."/credential/delete/$id",
            [],
            $this->options
        );
        return $request->send();
    }

    /**
     * Bind existing credential to content provider
     *
     * @param  int $id credential id
     * @param  int $provider content provider id
     * @return common\components\clients\service\Response
     */
    public function bindCredential($id, $provider)
    {
        $data = ['provider' => $provider];
        $request = new Request('POST',
            $this->baseUrl."/credential/bind/$id",
            $data,
            $this->options
        );
        return $request->send();
    }

    /**
     * Unbind existing credential to content provider
     *
     * @param  int $id credential id
     * @param  int $provider content provider id
     * @return common\components\clients\service\Response
     */
    public function unbindCredential($id, $provider)
    {
        $data = ['provider' => $provider];
        $request = new Request('POST',
            $this->baseUrl."/credential/unbind/$id",
            $data,
            $this->options
        );
        return $request->send();
    }

    /**
     * Ping service and return service info
     *
     * @return common\components\clients\service\Response
     */
    public function pingService()
    {
        $request = new Request('GET',
            $this->baseUrl.'/service/ping/',
            [],
            $this->options
        );
        return $request->send();
    }

    /**
     * Returns number of active connections to service
     *
     * @return common\components\clients\service\Response
     */
    public function getSeviceConnectionsNumber()
    {
        $request = new Request('GET',
            $this->baseUrl.'/service/get-connections-number/',
            [],
            $this->options
        );
        return $request->send();
    }

    /**
     * Update service status
     *
     * @param common\components\clients\service\Response
     */
    public function setServiceSatus($status)
    {
        $data = ['status' => $status];
        $request = new Request('PUT',
            $this->baseUrl.'/service/set-status/',
            $data,
            $this->options
        );
        return $request->send();
    }

    /**
     * Update service "storing enabled" attribute
     *
     * @param boolean $enabled
     * @return common\components\clients\service\Response
     */
    public function setServiceStoring($enabled)
    {
        $data = ['enabled' => (int)$enabled];
        $request = new Request('PUT',
            $this->baseUrl.'/service/set-storing/',
            $data,
            $this->options
        );
        return $request->send();
    }

    /**
     * Update service "proxy enabled" attribute
     *
     * @param boolean $enabled
     * @return common\components\clients\service\Response
     */
    public function setServiceUseProxy($enabled)
    {
        $data = ['enabled' => (int)$enabled];
        $request = new Request('PUT',
            $this->baseUrl.'/service/set-use-proxy/',
            $data,
            $this->options
        );
        return $request->send();
    }

    /**
     * Returns list of avaliable statistical indexes
     *
     * @param  integer $offset
     * @param  integer $limit
     * @return common\components\clients\service\Response
     */
    public function getStatisticalIndexes($offset = 0, $limit = 0)
    {
        $params = ['offset' => $offset, 'limit' => $limit];
        $request = new Request('GET',
            $this->baseUrl.'/statistic/list-indexes/',
            $params,
            $this->options
        );
        return $request->send();
    }

    /**
     * Returns list of avaliable statistical data sets
     *
     * @param  integer $offset
     * @param  integer $limit
     * @return common\components\clients\service\Response
     */
    public function getStatisticalDataSets($offset = 0, $limit = 0)
    {
        $params = ['offset' => $offset, 'limit' => $limit];
        $request = new Request('GET',
            $this->baseUrl.'/statistic/list-data-sets/',
            $params,
            $this->options
        );
        return $request->send();
    }

    /**
     * Returns statistics for given index
     *
     * @param  string  $index    statistical index
     * @param  string  $dateFrom date range start
     * @param  string  $dateTo   date range end
     * @param  array   $filter   filters
     * @param  integer $offset
     * @param  integer $limit
     * @return common\components\clients\service\Response
     */
    public function getStatistics($index, $dateFrom = null, $dateTo = null, $filter = [], $offset = 0, $limit = 0)
    {
        $params = [];
        if ($dateFrom != null) {
            $params['dateFrom'] = $dateFrom;
        }
        if ($dateTo != null) {
            $params['dateTo'] = $dateTo;
        }
        if ($offset > 0) {
            $params['offset'] = $offset;
        }
        if ($limit > 0) {
            $params['limit'] = $limit;
        }
        $params = ArrayHelper::merge($params, $filter);

        $request = new Request('GET',
            $this->baseUrl."/statistic/get/$index",
            $params,
            $this->options
        );
        return $request->send();
    }

    /**
     * Returns service storage data
     *
     * @return common\components\clients\service\Response
     */
    public function getStorageInfo()
    {
        $request = new Request('GET',
            $this->baseUrl.'/storage/',
            [],
            $this->options
        );
        return $request->send();
    }

    /**
     * Returns list of files in storage
     *
     * @return common\components\clients\service\Response
     */
    public function listStorage()
    {
        $request = new Request('GET',
            $this->baseUrl.'/storage/list/',
            [],
            $this->options
        );
        return $request->send();
    }

    /**
     * Returns size of storage in bytes
     *
     * @return common\components\clients\service\Response
     */
    public function getStorageSize()
    {
        $request = new Request('GET',
            $this->baseUrl.'/storage/get-size/',
            [],
            $this->options
        );
        return $request->send();
    }

    /**
     * Returns stored file size in bytes
     *
     * @param  string $file file name
     * @return common\components\clients\service\Response
     */
    public function getStorageFileSize($file)
    {
        $params = ['file' => $file];
        $request = new Request('GET',
            $this->baseUrl.'/storage/get-file-size/',
            $params,
            $this->options
        );
        return $request->send();
    }

    /**
     * Creates empty file with given name
     *
     * @param  string $file file name
     * @return common\components\clients\service\Response
     */
    public function createFileOnStorage($file)
    {
        $data = ['file' => $file];
        $request = new Request('POST',
            $this->baseUrl.'/storage/create-file/',
            $data,
            $this->options
        );
        return $request->send();
    }

    /**
     * Removes existing file from storage
     *
     * @param  string $file file name
     * @return common\components\clients\service\Response
     */
    public function removeFileFromStorage($file)
    {
        $request = new Request('DELETE',
            $this->baseUrl."/storage/remove-file/$file",
            [],
            $this->options
        );
        return $request->send();
    }

    /**
     * Returns read\write speed of storage
     *
     * @param  integer $dataSize
     * @param  integer $dataChunks
     * @return common\components\clients\service\Response
     */
    public function testStorageSpeed($dataSize, $dataChunks)
    {
        $params = ['dataSize' => $dataSize, 'dataChunks' => $dataChunks];
        $request = new Request('GET',
            $this->baseUrl.'/storage/test-speed/',
            $params,
            $this->options
        );
        return $request->send();
    }

    /**
     * Returns list of stored contents
     *
     * @return common\components\clients\service\Response
     */
    public function getStoredContents($offset = 0, $limit = 0)
    {
        $params = ['offset' => $offset, 'limit' => $limit];
        $request = new Request('GET',
            $this->baseUrl.'/stored-content/',
            $params,
            $this->options
        );
        return $request->send();
    }

    /**
     * Returns stored content by given id
     *
     * @return common\components\clients\service\Response
     */
    public function getStoredContent($id)
    {
        $request = new Request('GET',
            $this->baseUrl."/stored-content/get/$id",
            [],
            $this->options
        );
        return $request->send();
    }

    /**
     * Returns stored content chunks by given stored content id
     *
     * @param  integer $id stored content id
     * @return common\components\clients\service\Response
     */
    public function getStoredContentChunks($id)
    {
        $request = new Request('GET',
            $this->baseUrl."/stored-content/get-chunks/$id",
            [],
            $this->options
        );
        return $request->send();
    }

    /**
     * Creaes new stored content
     *
     * Creates new sored content using given data.
     * [[data]] array example:
     * ```php
     * [
     *    'name' => 'stored content 1',
     *    'size' => 1234567,
     *    'ext_url' => 'http://some.host/some.content',
     *    'complete' => 1
     * ]
     * ```
     *
     * @param array $data stored content attributes
     * @return common\components\clients\service\Response
     */
    public function createStoredContent($data)
    {
        $request = new Request('POST',
            $this->baseUrl.'/stored-content/create/',
            $data,
            $this->options
        );
        return $request->send();
    }

    /**
     * Update stored content
     *
     * Update stored content using given data.
     * For [[data]] array example @see Client::createStoredContent()
     *
     * @param  array $data stored content attributes
     * @return common\components\clients\service\Response
     */
    public function updateStoredContent($id, $data)
    {
        $request = new Request('PUT',
            $this->baseUrl."/stored-content/update/$id",
            $data,
            $this->options
        );
        return $request->send();
    }

    /**
     * Deletes stored content
     *
     * @param  integer $id stored content id
     * @return common\components\clients\service\Response
     */
    public function deleteStoredContent($id)
    {
        $request = new Request('DELETE',
            $this->baseUrl."/stored-content/delete/$id",
            [],
            $this->options
        );
        return $request->send();
    }

    /**
     * Performs debugging
     *
     * @param  string $link
     * @param  string $password password for link (if required)
     * @return common\components\clients\service\Response
     */
    public function debugContent($link, $password = null)
    {
        $params = ['link' => $link];
        if ($password != null) {
            $params['password'] = $password;
        }
        $request = new Request('GET',
            $this->baseUrl.'/dbg/content/',
            $params,
            $this->options
        );
        return $request->send();
    }

    /**
     * Returns list of log entries
     *
     * @param  integer $offset
     * @param  integer $limit
     * @return common\components\clients\service\Response
     */
    public function getLogEntriesList($offset = 0, $limit = 0)
    {
        $params = ['offset' => $offset, 'limit' => $limit];
        $request = new Request('GET',
            $this->baseUrl.'/log/list/',
            $params,
            $this->options
        );
        return $request->send();
    }

    /**
     * Returns log entrie
     *
     * @param  integer $id log entrie id
     * @return common\components\clients\service\Response
     */
    public function getLogEntrie($id)
    {
        $request = new Request('GET',
            $this->baseUrl."/log/view/$id",
            [],
            $this->options
        );
        return $request->send();
    }

    /**
     * Truncates log
     *
     * @param  string $date
     * @return common\components\clients\service\Response
     */
    public function truncateLog($date)
    {
        $params = ['date' => $date];
        $request = new Request('POST',
            $this->baseUrl.'/log/truncate/',
            $params,
            $this->options
        );
        return $request->send();
    }
}
