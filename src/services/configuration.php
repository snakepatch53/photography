<?php
$migration = new Migration(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    $_ENV['DB_NAME'],
    $_ENV['DB_PORT']
);

$migration->migrateFromSqlFile("./src/assets/db.sql");
