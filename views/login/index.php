<?php
/* @var $this yii\web\View */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<div class="row">
    <?php if (isset($time)) : ?>
        <p class="bg-danger blocked">Попробуйте еще раз через <?= $time ?></p>
    <?php endif; ?>
    <div class="col-md-4 col-xs-12 col-md-offset-4">
        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
            'action' => ['auth'],
            'method' => 'POST'
        ]); ?>

        <?= $form->field($model, 'username')->textInput([
                'autofocus' => true,
                'disabled' => $blocked
        ])->label('Имя пользователя') ?>

        <?= $form->field($model, 'password')->passwordInput([
            'disabled' => $blocked,
        ])->label('Пароль') ?>

        <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'register-button', 'disabled' => $blocked]) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>