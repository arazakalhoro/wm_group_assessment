<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => ($_ENV['DB_DSN'] ?? 'mysql:host=localhost;dbname=mydatabase'),
    'username' => ($_ENV['DB_USERNAME'] ?? 'root'),
    'password' => ($_ENV['DB_PASSWORD'] ?? 'secret'),
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
