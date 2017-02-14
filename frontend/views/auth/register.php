<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    $this->params['bodyClass'] = 'signup-page';
    $this->title = $title;

    foreach ($meta as $key) {
        $this->registerMetaTag(['name' => $key->name, 'content' => $key->content]);
    }
?>

<main class="ta-center container">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'login-sign-up']]);?>
        <h2 style = "margin-top: -2px;" class="lthin tx-white"><?=Yii::t('auth',"Create Account") ?>
            
        </h2>
        <div class="img">
        <?php echo Html::img('@web/images/logo.png');?>
        </div>
        <div class="tx-white title thin"> <?=Yii::t('auth',"Just enter your email address below, which will also be your login name for Premium {tag}  Link Generator, and choose your password!",['tag'=>Html::tag('br')]) ?></div>
        <!-- <h2 class="lthin tx-white"><?= Html::encode($this->title) ?></h2> -->
        <div class="input email">
            <?=$form->field($model, 'email')->textInput(['autofocus' => true, 'class' => '', 'placeholder' => 'E-mail'])->label(false)?>
        </div>
        <div class="input password">
            <?=$form->field($model, 'password')->passwordInput(['class' => '', 'placeholder' => 'Password'])->label(false)?>
        </div>
        <div class="form-group field-signupform-terms required has-error"></div>
        <?=$form->field($model,'expiration_date')->hiddenInput(['class' => ''])->label(false)?>
        <div class="form-group field-signupform-terms required has-error">
            <div class="input checkbox tx-white">
                <label>
                    <input type="hidden" name="SignupForm[terms]" value="0">
                    <input type="checkbox" id="signupform-terms" name="SignupForm[terms]" value="1">
                    <span></span>
                    <!-- <a href = "/<?= $lang_path ?>/terms"></a> -->
                    <span class="tx-white thin login-font-weight"><?=Yii::t('auth',"I agree to Premium Link Generator Terms") ?></span>
                </label>
            </div>
        </div>
        <?= $form->field($model, 'terms', [
        'template' => "<div class=\"input checkbox tx-white\">{input}</div>\n<div class=\"\">{error}</div>",
        ])->checkbox([],false) ?>
        <button class="yellow-btn full-width uppercase">Register</button>
        <div class="tx-white register-here thin"><?=Yii::t('auth',"If you already have an account {link_login}",['link_login'=>Html::a(' click here to login', ['/auth/login'], $options = ['class'=>'link tx-yellow'] )])?> </div>
    <?php ActiveForm::end();?>
</main>
