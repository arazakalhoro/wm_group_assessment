<?php

use yii\db\Migration;

/**
 * Class m240709_102613_create_roles_seeder
 */
class m240709_102613_create_roles_seeder extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->truncateTable('roles');
        $this->insert('roles', [
            'name' => 'Administrator',
            'description' => 'Administrator user with full access',
        ]);

        $this->insert('roles', [
            'name' => 'User',
            'description' => 'Normal user with limited access',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('roles', ['name' => 'Administrator']);
        $this->delete('roles', ['name' => 'User']);
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240709_102613_create_roles_seeder cannot be reverted.\n";

        return false;
    }
    */
}
