<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\models\Role;
class User extends ActiveRecord implements IdentityInterface
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $status;
    public $created_at;
    public $updated_at;
    public static function tableName()
    {
        return '{{users}}';
    }

    public function beforeSave($insert)
    {
        #Check if record is new set created_at date and password hashed
        if ($insert) {
            $this->setAttribute('password', Yii::$app->security->generatePasswordHash($this->password));
        }
        return parent::beforeSave($insert);
    }

    /**
     * This function will return User object
     *
     * @param integer $id
     *
     * @return User
     * */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * This function will return user record based on email
     *
     * @param string $email
     *
     * @return User
     * */
    public static function findByEmail(string $email): User
    {
        return self::findOne(['email' => $email]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
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
        return Role::find()
            ->where(['id' => $this->getAttribute('role_id')])
            ->one();
    }
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->getAttribute('password'));
    }
}
