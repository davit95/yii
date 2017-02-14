<?php

namespace common\repositories;

use yii\base\Exception;
use common\models\Host;
use common\models\Service;
use common\models\User;
use service\models\ContentProvider;
use common\models\UnrestrainedLink;
use InvalidArgumentException;
use RuntimeException;

/**
 * Class HostRepository
 *
 * @package common\repositories
 */
class HostRepository
{
    /**
    * Create a new host repository instance.
    * @param Host,ContentProvider,Service Models
    */
    public function __construct(User $user ,Host $host,ContentProvider $contentProvider,Service $service)
    {
        $this->user = $user;
        $this->contentProvider = $contentProvider;
        $this->host = $host;
        $this->service = $service;
    }

    /**
    * @return  all Hosts from storage.
    */
    public function getAllHosts()
    {
        return $this->host->find()->orderBy(['name'=>SORT_ASC]);
    }

    /**
    * @return  Popular resources from storage.
    */
    public function getPopularHosts($limit)
    {
        //TODO: Determinate host popularity
        return $this->host->find()->orderBy(['name'=>SORT_ASC])->limit($limit)->all();
    }

    /**
    * @return all hosts for Api call.
    */
    public function getAllHostsApi()
    {
        return $this->host->find()->all();
    }

    /**
    * @return Host Content Provider by id
    */
    public function getProviderById($id){
        return $this->contentProvider->find()->where(['id'=>$id])->one();
    }

    /**
    * @param User identity Object
    * @return UnrestrainedLink Last Download date
    */
    public function getLastDownloadDate($user){
        $last_unrestLinks = UnrestrainedLink::find()->where(['user_id' => $user->id])->orderBy(['id' => SORT_DESC])->one();
        if(null!=$last_unrestLinks){
            return  \Yii::$app->formatter->asDatetime($last_unrestLinks->created, "php:Y-m-d H:i:s");
        }else{
            return $last_unrestLinks = "No Downloads";
        }
    }

    /**
    * @return All Content Providers from storage.
    */
    public function getAllContentProviders(){
        return $this->contentProvider->find()->where(['>', 'id', 1])->all();
    }

    /**
    * @param Host $id
    */
    public function getHostById($id){
        return $this->host->find()->where(['id'=>$id])->one();
    }

    /**
    * @return Service
    */
    public function getService(){
        return $this->service->find()->one();
    }

    /**
    * Update Content Provider Status By Service Api Call
    * @param ContentProvider $id,Service $url string,Host $status string
    * @return Http Guzzle response GetBody
    */
    public function updateContentProviderByApiCall($id,$url,$status){
        $authManager = \Yii::$app->authManager;
        $admin = User::find()->where(['in', 'id', $authManager->getUserIdsByRole('admin')])->one();

        if ($admin == null) {
            throw new Exception('No user with \'admin\' role found.');
        }

        $client = new \GuzzleHttp\Client();
        $res = $client->put($url.'/content-provider/update/'.$id,[
            'body' => ['status' => $status],
            'headers' => ['Authorization' => 'Bearer '.$admin->access_token],
        ]);
        return $res->getBody();
    }

    /**
    * @return specific host
    */
    public function getHostByName($name){
        return $this->host->find()->where(['LIKE','name',"$name%",false])->one();
    }

}
