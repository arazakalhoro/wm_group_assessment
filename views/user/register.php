<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\UserRegisterForm $model */
/** @var array $roles */

$this->title = 'Register User';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-register">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>Please fill out the following fields to register a new user:</p>
    <div class="row">
        <div class="col-lg-5">
            <div class="user-register-form">

                <?php $form = ActiveForm::begin([
                    'id' => 'register-form',
                    'fieldConfig' => [
                        'template' => "{label}\n{input}\n{error}",
                        'labelOptions' => ['class' => 'col-lg-5 col-form-label mr-lg-3'],
                        'inputOptions' => ['class' => 'col-lg-5 form-control'],
                        'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                    ],
                ]);
                ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'status')->dropDownList([1 => 'Active', 0 => 'Disabled'], ['prompt' => 'Select Status']) ?>

                <?= $form->field($model, 'role_id')->dropDownList($roles, ['prompt' => 'Select Role']) ?>

                <div class="form-group">
                    <?= Html::submitButton('Register', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>


</div>
