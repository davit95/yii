<?php

namespace common\repositories;

use frontend\models\Page;
use frontend\models\Meta;
use InvalidArgumentException;
use RuntimeException;

/**
 * Class PagesRepository
 *
 * @package common\repositories
 */
class PagesRepository
{
    /**
    * Create a new page repository instance.
    * @param Page,Meta Models
    */
    public function __construct(Page $page,Meta $meta)
    {
        $this->meta = $meta;
        $this->page = $page;
    }

    /**
    * @param pagename string
    * @return Page details by Page Name
    */
    public function getPageDetailsByPageName($pagename)
    {
        $delimetr = explode("?", $pagename);
        if(NULL!=$delimetr[0]){
            return json_decode($this->page->find()->where(['page_name'=>$delimetr[0]])->one()->content);
        }
    }

    /**
    * @param pagename string
    * @return Page details by Page Name for AdminPanel apiCall
    */
    public function getPageDetailsByPageNameApi($pagename)
    {
        return $this->page->find()->where(['page_name'=>$pagename])->all();
    }

    /**
    * @return All Web Pages Urls
    */
    public function getAllPageUrls(){
        return $this->page->find()->all();
    }

    /**
    * @param Page Context object Json
    */
    public function UpdatePageDetails($object){
        $update = $this->page->find()->where(['id'=>$object['id']])->one();
        $update->content = urldecode($object['content']);
        return $update->save(false);
    }

    /**
    * @param $data MetaData Array 
    * Store a newly created resource in storage.
    */
    public function saveMetadata($data){
        if(count($data)>2){
            $this->meta->page_id = $data['page_id'];
            $this->meta->name = $data['name'];
            $this->meta->content = $data['content'];
            if($this->meta->save($data)){
                return ['status'=>'success'];
            }else{
                return ['status'=>'error','message'=>'error in save data'];
            }
        }else{
            return false;
        }
    }

    /**
    * @param $param string
    */
    public function getPageMetaData($param){
        $delimetr = explode("?", $param);
        $data = $this->page->find()->where(['page_name'=>$delimetr[0]])->with('meta')->one();
        return $data->meta;
    }

    /**
    * @param $param string
    */
    public function getPageMetaDataApi($param){
        $data = $this->page->find()->where(['page_name'=>$param['page_name']])->with('meta')->one();
        return $data->meta;
    }

    /**
    * @param $data titleData Array 
    * Store a newly created resource in storage.
    */
    public function UpdateMeta($queryParam){
        foreach ($queryParam as $key) {
            $data = json_decode($key,true);
            $meta_data = $this->meta->find()->where(['id'=>$data['id']])->one();
            $meta_data->content =$data['content'];
            $meta_data->page_id =$data['page_id'];
            $meta_data->name =$data['name'];
            $meta_data->update(); 
        }
        return $meta_data;
    }

    /**
    * @param $queryParam Json
    * Store a newly created resource in storage.
    */
    public function savePageTitle($data){
        $page = $this->page->find()->where(['page_name'=>$data['slug']])->one();
        if(null == $page->title){
            $page->title = $data['title'];
            if($page->save()){
                return true;
            }else{
                return false;
            }
        }else{
            return null;
        }
    }

    /**
    * get Title by Page Name for api
    */
    public function getPageTitleApi($slug){
        $data = $this->page->find()->where(['page_name'=>$slug['page_name']])->one();
        return $data->title;
    }

    /**
    * get Title by Page Name for frontend
    */
    public function getPageTitle($slug){
        $data = $this->page->find()->where(['page_name'=>$slug])->one();
        return $data->title;
    }

    /**
    * Update Page title
    */
    public function UpdatePageTitle($request){
        $data = $this->page->find()->where(['page_name'=>$request['slug']])->one();
        $data->title = $request['title'];
        if($data->save()){
            return true;
        }else{
            return false;
        }
    }
}