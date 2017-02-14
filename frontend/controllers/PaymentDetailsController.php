<?php

namespace frontend\controllers;

class PaymentDetailsController extends \yii\web\Controller
{
	//Controller in progress
	
    public function actionIndex()
    {
    	$this->layout = 'site';
        return $this->render('index');
    }

    public function actionAffiliateTerms()
    {
    	$this->layout = 'site';
        return $this->render('affiliate');
    }

}
