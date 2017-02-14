<?php
/**
 * Storage controller
 *
 * @package service\api
 * @author Yura Tovt <yura.tovt@ffflabel.com>
 */

namespace service\modules\api\v1\controllers;

use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;

/**
 * Handles storage
 */
class StorageController extends Controller
{
    /**
     * @inheritdoc
     * @ignore
     */
    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML,
                ],
            ],
            'compositeAuth' => [
                'class' => '\yii\filters\auth\CompositeAuth',
                'authMethods' => [
                    'service\components\filters\auth\HttpBasicAuth',
                    'service\components\filters\auth\HttpBearerAuth',
                ],
            ],
            'accessControl' => [
                'class' => '\yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            $user = Yii::$app->user->identity;
                            return (($user !== null) && ($user->isAdmin()));
                        }
                    ]
                ]
            ],
            'verbFilter' => [
                'class' => VerbFilter::className(),
                'actions' => $this->verbs(),
            ],
        ];
    }

    /**
     * @inheritdoc
     * @ignore
     */
    public function verbs()
    {
        return [
            'index' => ['get'],
            'list' => ['get'],
            'get-size' => ['get'],
            'get-file-size' => ['get'],
            'create-file' => ['post'],
            'remove-file' => ['delete'],
            'test-speed' => ['get']
        ];
    }

    /**
     * Returns basic storage info
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/storage/index
     *
     * Example of response:
     * ```json
     * {
     *  "root": "local_storage",
     *  "size": 70359713,
     *  "class": "service\\components\\storages\\LocalStorage"
     * }
     *```
     *
     * @return mixed
     * @api
     */
    public function actionIndex()
    {
        $response = Yii::$app->response;

        try {
            $storage = Yii::$app->storage;

            return $storage;
        } catch (\Exception $e) {
            $response->setStatusCode(500);
            return [
                'message' => 'Storage is unavaliable.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Lists storage
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/storage/list
     *
     * Example of response:
     * ```json
     * {
     *  "list": [...]
     * }
     * ```
     *
     * @return mixed
     * @api
     */
    public function actionList()
    {
        $response = Yii::$app->response;

        try {
            $storage = Yii::$app->storage;
            if (false !== ($list = $storage->ls())) {
                return [
                    'list' => $list
                ];
            } else {
                $response->setStatusCode(400);
                return [
                    'message' => 'Error during listing storage contents.',
                ];
            }
        } catch (\Exception $e) {
            $response->setStatusCode(500);
            return [
                'message' => 'Storage is unavaliable or other error occured.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Returns storage size
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/storage/get-size
     *
     * Example of response:
     * ```json
     * {
     *  "size": 123456
     * }
     * ```
     *
     * @return mixed
     * @api
     */
    public function actionGetSize()
    {
        $response = Yii::$app->response;

        try {
            $storage = Yii::$app->storage;
            if (false !== ($size = $storage->getSize())) {
                return [
                    'size' => $size
                ];
            } else {
                $response->setStatusCode(400);
                return [
                    'message' => 'Error during getting storage size.',
                ];
            }
        } catch (\Exception $e) {
            $response->setStatusCode(500);
            return [
                'message' => 'Storage is unavaliable or other error occured.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Returns file size
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/storage/get-file-size?file=file_name
     *
     * Example of response:
     * ```json
     * {
     *  "size": 123456
     * }
     * ```
     *
     * @param  string $file
     * @return mixed
     * @api
     */
    public function actionGetFileSize($file)
    {
        $response = Yii::$app->response;

        try {
            $storage = Yii::$app->storage;
            if (false !== ($size = $storage->getFileSize($file))) {
                return [
                    'size' => $size
                ];
            } else {
                $response->setStatusCode(400);
                return [
                    'message' => 'Error during getting file size.',
                ];
            }
        } catch (\Exception $e) {
            $response->setStatusCode(500);
            return [
                'message' => 'Storage is unavaliable or other error occured.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Create file
     *
     * Method: POST
     *
     * Call example: http://svc.plg.com/api/storage/create-file
     *
     * Data: file
     *
     * Example of response:
     * ```json
     * {
     *  "message": "File successfully created."
     * }
     * ```
     *
     * @return mixed
     * @api
     */
    public function actionCreateFile()
    {
        $response = Yii::$app->response;
        $file = Yii::$app->request->post('file', null);

        try {
            $storage = Yii::$app->storage;
            if ($storage->createFile($file)) {
                return [
                    'message' => 'File successfully created.'
                ];
            } else {
                $response->setStatusCode(400);
                return [
                    'message' => 'Failed to create file.',
                ];
            }
        } catch (\Exception $e) {
            $response->setStatusCode(500);
            return [
                'message' => 'Storage is unavaliable or other error occured.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Remove file
     *
     * Method: DELETE
     *
     * Call example: http://svc.plg.com/api/storage/remove-file?file=file_name
     *
     * Example of response:
     * ```json
     * {
     *  "message": "File successfully removed."
     * }
     * ```
     *
     * @param  string $file
     * @return mixed
     * @api
     */
    public function actionRemoveFile($file)
    {
        $response = Yii::$app->response;

        try {
            $storage = Yii::$app->storage;
            if ($storage->removeFile($file)) {
                return [
                    'message' => 'File successfully removed.'
                ];
            } else {
                $response->setStatusCode(400);
                return [
                    'message' => 'Failed to remove file.',
                ];
            }
        } catch (\Exception $e) {
            $response->setStatusCode(500);
            return [
                'message' => 'Storage is unavaliable or other error occured.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Test Storege read/write speed
     *
     * Method: GET
     *
     * Call example: http://svc.plg.com/api/storage/test-speed
     *
     * Example of response:
     * ```json
     * {
     *  "dataSize": "1048576 bytes",
     *  "dataChunks": 128,
     *  "dataChunksSize": "8192 bytes",
     *  "bytesWritten": "1048576 bytes",
     *  "writeTime": "0.0046591758728027 s",
     *  "writeSpeed": "219781.36 kB/s",
     *  "bytesRead": "1048576 bytes",
     *  "readTime": "0.0021078586578369 s",
     *  "readSpeed": "485801.07 kB/s"
     * }
     *
     * @return mixed
     * @api
     */
    public function actionTestSpeed()
    {
        $response = Yii::$app->response;

        $dataSize = (int)Yii::$app->request->get('dataSize', 1048576);
        $dataChunks = (int)Yii::$app->request->get('dataChunks', 128);

        if ($dataSize <= 0 || $dataChunks <= 0) {
            $response->setStatusCode(500);
            return [
                'message' => 'Invalid data size or data chunks count.',
            ];
        }

        $dataChunkSize = (int)($dataSize / $dataChunks);

        $dataGenerator = function ($len) {
            $res = '';
            $abc = 'abcdefghijklmnop0123456789';
            $pow = strlen($abc);
            for ($i = 1; $i <= $len; $i++) {
                $res .= $abc[rand(0, $pow - 1)];
            }
            return $res;
        };

        try {
            $storage = Yii::$app->storage;

            $file = $storage->createFile('speed_test.dat');

            $content = $storage->getFileContent($file);
            $context = $content->createStreamContext();

            //Generate random data
            $data = [];
            for ($i = 1; $i <= $dataChunks; $i++) {
                $data[] = $dataGenerator($dataChunkSize);
            }

            //Test writing
            $stream = $content->createStream($context, 'w');

            $startTime = microtime(true);
            $bytesWritten = 0;
            for ($i = 0; $i < $dataChunks; $i++) {
                $bytesWritten += $stream->write($data[$i]);
            }
            $writeTime = microtime(true) - $startTime;
            $writeSpeed = round(($bytesWritten / 1024) / $writeTime, 2);
            $stream->close();

            //Test Reading
            $stream = $content->createStream($context, 'r');

            $startTime = microtime(true);
            $bytesRead = 0;
            while (($data = $stream->read($dataChunkSize)) !== false) {
                $bytesRead += strlen($data);
            }
            $readTime = microtime(true) - $startTime;
            $readSpeed = round(($bytesRead / 1024) / $readTime, 2);
            $stream->close();

            $storage->removeFile($file);

            return [
                'dataSize' => $dataSize.' bytes',
                'dataChunks' => $dataChunks,
                'dataChunksSize' => $dataChunkSize.' bytes',
                'bytesWritten' => $bytesWritten.' bytes',
                'writeTime' => $writeTime.' s',
                'writeSpeed' => $writeSpeed.' kB/s',
                'bytesRead' => $bytesRead.' bytes',
                'readTime' => $readTime.' s',
                'readSpeed' => $readSpeed.' kB/s'
            ];
        } catch (\Exception $e) {
            if (isset($stream)) {
                $stream->close();
            }

            $response->setStatusCode(500);
            return [
                'message' => 'Storage is unavaliable or other error occured.',
                'error' => $e->getMessage()
            ];
        }
    }
}
