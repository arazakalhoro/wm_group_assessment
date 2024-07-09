<?php

use yii\db\Migration;
use app\models\Role;

/**
 * Class m240709_104740_create_administrator_seeder
 */
class m240709_104740_create_administrator_seeder extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $adminExist = \app\models\User::find()->where([
            'email' => 'admin@example.com',
        ])->one();
        if ($adminExist){
            echo "Admin user already exists.\n";
            return false;
        }
        $administratorRole = Role::findOne(1);
        if (!empty($administratorRole)) {
            $this->insert('users', [
                'role_id' => $administratorRole->getAttribute('id'),
                'name' => 'admin',
                'email' => 'admin@example.com',
                'password' => Yii::$app->security->generatePasswordHash('admin'),
                'status' => true,
            ]);
        } else {
            echo "Role 'Administrator' not found.\n";  // or handle this case as you prefer.
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('users', ['email' => 'admin@example.com']);
    }
}
