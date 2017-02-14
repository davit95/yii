<?php

namespace service\controllers;

use Yii;
use yii\web\Controller;

/**
 * Handles service errors
 * TODO: Design for error views
 */
class ErrorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => 'yii\web\ErrorAction'
        ];
    }
}
