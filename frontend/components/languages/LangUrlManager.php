<?php
namespace frontend\components\languages;

use yii\web\UrlManager;
use frontend\models\Languag;

class LangUrlManager extends UrlManager
{
    public function createUrl($params)
    {
        if( isset($params['lang_id']) ){
            //if isset identificator language,then search lang in db
            //else default language
            $lang = Languag::findOne($params['lang_id']);
            if( $lang === null ){
                $lang = Languag::getDefaultLang();
            }
            unset($params['lang_id']);
        } else {
            //if !isset identificator language then work with default language
            $lang = Languag::getCurrent();
        }

        //Get the generated URL (without the prefix language identifier)
        $url = parent::createUrl($params);

        //set url prefix 
        if( $url == '/' ){
            return '/'.$lang->url;
        }else{
            return '/'.$lang->url.$url;
        }
    }
}
