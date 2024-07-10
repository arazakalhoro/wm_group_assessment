<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{
    public $currentPassword;
    public $newPassword;
    public $newPasswordRepeat;

    public function rules(){
        return [
            [['currentPassword', 'newPassword', 'newPasswordRepeat'], 'required'],
            ['currentPassword', 'validateCurrentPassword'],
            ['newPassword', 'string','min' => 8],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword'],
        ];
    }

    public function attributeLabels(){
        return [
            'currentPassword' => 'Current Password',
            'newPassword' => 'New Password',
            'newPasswordRepeat' => 'Repeat New Password',
        ];
    }

    public function validateCurrentPassword($attribute, $params){
        if (!$this->hasErrors()) {
            $user = Yii::$app->user->identity;
            if (!$user ||!$user->validatePassword($this->currentPassword)) {
                $this->addError($attribute, 'Incorrect current password.');
            }
        }
    }
}