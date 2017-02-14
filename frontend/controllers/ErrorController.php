<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

/**
 * Handles web app errors
 */
class ErrorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
