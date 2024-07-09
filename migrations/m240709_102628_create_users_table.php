<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m240709_102628_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('DROP TABLE if EXISTS users;');
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'role_id' => $this->integer(),
            'name' => $this->string(255)->unique(),
            'email' => $this->string(255)->unique(),
            'password' => $this->string(255),
            'status' => $this->boolean()->defaultValue(true),
            'last_login_at' => $this->timestamp()->null(),
            'created_at' => $this->timestamp()
                ->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()
                ->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
        $this->createIndex('index_name','users',['name']);
        $this->createIndex('index_email','users',['email']);
        // add foreign key for table `role`
        $this->addForeignKey(
            'fk-user-role_id',
            'users',
            'role_id',
            'roles',
            'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
