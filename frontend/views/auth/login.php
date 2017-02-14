<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->params['bodyClass'] = 'login-page';
$this->title = $title;

foreach ($meta as $key) {
    $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
}
?>

<main class="ta-center">
    <div class="container">
        <?php $form = ActiveForm::begin(['options' => ['class' => 'login-sign-up']]);?>
            <h2 class="lthin tx-white"><?=Html::encode(Yii::t('auth',$this->title))?></h2>
            <div class="img"><img src="/images/logo.png"/></div>
            <div class="input email">
                <?=$form->field($model, 'email')->textInput(['autofocus' => true, 'class' => '', 'placeholder' => 'E-mail'])->label(false)?>
            </div>
            <div class="input password">
                <?=$form->field($model, 'password')->passwordInput(['class' => '', 'placeholder' => 'Password'])->label(false)?>
            </div>
            <div class="err_mess ta-left"></div>

                 <label>
                    <input type="hidden" name="LoginForm[rememberMe]" value="0">
                    <input type="checkbox" id="loginform-rememberme" name="LoginForm[rememberMe]" value="1" checked>
                    <span></span>
                    <span class="tx-white thin login-font-weight"><?=Yii::t('auth',"Remember Me next time") ?></span> 
                </label>

            <?=Html::submitButton('Login', ['class' => 'yellow-btn full-width uppercase', 'name' => 'login-button'])?>
            <div class="tx-white register-here thin"><?= Yii::t('auth',"You don`t have an account? {link_registr}",['link_registr'=>Html::a('Register here', ['/auth/register'], $options = ['class'=>'link tx-yellow'] )]) ?></div>
        <?php ActiveForm::end();?>
    </div>
</main>
