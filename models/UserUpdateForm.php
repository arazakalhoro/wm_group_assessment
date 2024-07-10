<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class UserUpdateForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $password_repeat;
    public $status;
    public $role_id;

    private $_user;

    public function __construct($user, $config = [])
    {
        $this->_user = $user;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'email', 'status', 'role_id'], 'required'],
            ['name', 'string', 'min' => 3, 'max' => 255],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id], 'message' => 'This email address has already been taken.'],
            ['status', 'in', 'range' => [0, 1]],
            ['role_id', 'integer'],
            ['role_id', 'exist', 'targetClass' => Role::class, 'targetAttribute' => 'id'],

            // Password validation rules
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match.'],

            // Ensure that passwords are required only if one of them is set
            [['password', 'password_repeat'], 'required', 'when' => function ($model) {
                return !empty($model->password) || !empty($model->password_repeat);
            }, 'whenClient' => "function (attribute, value) {
                return $('#userupdateform-password').val() != '' || $('#userupdateform-password_repeat').val() != '';
            }"],
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
