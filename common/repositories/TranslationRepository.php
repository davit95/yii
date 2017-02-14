<?php

namespace common\repositories;

use common\models\SourceMessage;
use common\models\Message;
use InvalidArgumentException;
use RuntimeException;

/**
 * Class TranslationRepository
 *
 * @package common\repositories
 */
class TranslationRepository
{
    /**
    * Create a new TranslationRepository instance.
    * @param SourceMessage Model,Message Model
    */
    public function __construct(SourceMessage $source_message,Message $message)
    {
        $this->message = $message;
        $this->source_message = $source_message;
    }

    /**
    * @return SourceMessage from storage
    */
    public function getSourceMessageWithMessage(){
        $source_message_data = $this->source_message->find()->with('messages')->asArray()->all();
        return ['status'=>200,'resource'=>$this->source_message->find()->with('messages')->asArray()->all()];
    }

    /**
    * @param id
    * @return Get specific message by Id from storage.
    */
    public function getSourceBySlug($id){
        return $this->message->find()->where(['id'=>$id])->asArray()->all();
    }

    /**
    * @param id,slug
    * @return Get specific message by Id and slug from storage.
    */
    public function getMessageByIdAndLang($id,$lang){
        return $this->message->find()->where(['id'=>$id])->where(['language'=>$lang])->one();
    }

    /**
    * @param id
    * @return delete specific message from storage.
    */
    public function deleteCategory($id){
        return $this->source_message->findOne($id)->delete();
    }

    /**
    * @param data Object
    * @return Create new CategoryMessage,if true => create new message for translation
    */
    public function createCategory($data){
        $this->source_message->category = $data['category'];
        $this->source_message->message= $data['message'];
        if($this->source_message->save()){
            $this->message->id = \Yii::$app->db->getLastInsertId();
            $this->message->language = $data['language'];
            $this->message->translation = $data['translation'];
            if($this->message->save()){
                return true;
            }
        }else{
            return false;
        }
    }
}