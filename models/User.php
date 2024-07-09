<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
class User extends ActiveRecord implements IdentityInterface
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $status;
    public $role_id;
    public $last_login_at;
    public $created_at;
    public $updated_at;
    /**
     * This function will return User object
     *
     * @param integer $id
     *
     * @return User
     * */
    public static function findIdentity($id): User
    {
        return static::findOne($id);
    }

    /**
     * This function will return user record based on email
     *
     * @param string $email
     *
     * @return User
     * */
    public function findByEmail(string $email): User
    {
        return static::findOne(['username' => $email]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }
}
