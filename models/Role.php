<?php

namespace app\models;

use yii\db\ActiveRecord;
class Role extends ActiveRecord
{
    public $id;
    public $name;
    public $description;
    public $created_at;
    public $updated_at;
    public $permissions;
    public $users;
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return '{{roles}}';
    }
    //Write relation role has users
    public function getUsers(){
        return $this->hasMany(User::class, ['role_id' => 'id']);
    }

}