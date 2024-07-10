<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProfileForm */

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">

            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success">
                    <?= Yii::$app->session->getFlash('success') ?>
                </div>
            <?php endif; ?>

            <?php $form = ActiveForm::begin([
                'id' => 'change-password',
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'labelOptions' => ['class' => 'col-lg-5 col-form-label mr-lg-4'],
                    'inputOptions' => ['class' => 'col-lg-3 form-control'],
                    'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                ],
            ]);
            ?>


            <?= $form->field($model, 'currentPassword')->passwordInput([
                    'required' => true,
                    'minlength' => 8,
            ]) ?>

            <?= $form->field($model, 'newPassword')->passwordInput([
                    'required' => true,
                    'minlength' => 8,
            ]) ?>

            <?= $form->field($model, 'newPasswordRepeat')->passwordInput([
                    'required' => true,
                    'compareAttribute' => 'newPassword',
                    'message' => 'Passwords do not match.'
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Change', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
