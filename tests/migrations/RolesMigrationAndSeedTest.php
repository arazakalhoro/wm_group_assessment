<?php


namespace Migrations;

use app\models\Role;
use PHPUnit\Exception;
use Yii;
use \MigrationsTester;
use yii\console\Application;

class RolesMigrationAndSeedTest extends \Codeception\Test\Unit
{
    protected MigrationsTester $tester;
    protected function _before()
    {
    }

    public function testRoles()
    {
        $admin = Role::find()
            ->where(['name' => 'Administrator'])
            ->one();
        $this->assertNotNull($admin);
        $this->assertEquals('Administrator', $admin->getAttribute('name'));

        $user = Role::find()
            ->where(['name' => 'User'])
            ->one();
        $this->assertNotNull($user);
        $this->assertEquals('User', $user->getAttribute('name'));
    }
}
