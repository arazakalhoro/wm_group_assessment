<?php

namespace Helper;

use Codeception\Module;
use Yii;
use yii\console\Application;
class MigrationHelper extends Module
{
    public function _before(\Codeception\TestInterface $test)
    {
        Yii::error('Application called','Application');
        // Run migrations up before each test
        $this->runMigrations();
        parent::_before($test);
    }
//
//    public function _after(\Codeception\TestInterface $test)
//    {
//        // Roll back migrations after each test
//        $this->rollBackMigrations();
//        parent::_after($test);
//    }

    protected function runMigrations()
    {
        $config = require(Yii::getAlias('@app/config/console.php'));
        $config['components']['db'] = Yii::$app->db;

        $application = new Application($config);
        $params = ['migrationPath' => '@app/migrations'];

        $application->runAction('migrate/up', $params);
    }

    protected function rollBackMigrations()
    {
        $config = require(Yii::getAlias('@app/config/console.php'));
        $config['components']['db'] = Yii::$app->db;

        $application = new Application($config);
        $params = ['migrationPath' => '@app/migrations', 'interactive' => false];

        $application->runAction('migrate/down', $params);
    }
}