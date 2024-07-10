<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class ProfileForm extends Model
{
    public $email;
    public $name; // Assuming you have a 'name' field

    public function rules()
    {
        return [
            [['email', 'name'], 'required'],
            [['name', 'email'], 'string', 'max' => 255],
            ['email', 'email'],
            ['email', 'validateUniqueEmail'],
        ];
    }

    public function validateUniqueEmail($attribute, $params)
    {
        $user = User::find()
            ->where(['email' => $this->email])
            ->andWhere(['not', ['id' => Yii::$app->user->id]])
            ->one();
        if ($user !== null) {
            $this->addError($attribute, 'This email address is already taken.');
        }
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'name' => 'Name',
        ];
    }

    public function loadData($user)
    {
        $this->email = $user->email;
        $this->name = $user->name;
    }

    public function save($user)
    {
        if ($this->validate()) {
            $user = Yii::$app->user->identity;
            $user->setAttribute('name', $this->name);
            $user->setAttribute('email', $this->email);
            return $user->save();
        }
        return false;
    }
}