<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class UserRegisterForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $password_repeat;
    public $status;
    public $role_id;

    public function rules()
    {
        return [
            [['name', 'email', 'password', 'password_repeat', 'status', 'role_id'], 'required'],
            ['name', 'string', 'min' => 3, 'max' => 255],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'This email address has already been taken.'],
            ['status', 'in', 'range' => [0, 1]],
            ['role_id', 'integer'],
            ['role_id', 'exist', 'targetClass' => Role::class, 'targetAttribute' => 'id'],
            ['password', 'string', 'min' => 8],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Repeat Password',
            'status' => 'Status',
            'role_id' => 'Role',
        ];
    }
}
