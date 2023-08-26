<?php

require_once __DIR__.'/../vendor/autoload.php';

use \Doctrine\DBAL\Configuration;
use \Doctrine\DBAL\DriverManager;
use \Doctrine\DBAL\Schema\Schema;

// Connect to the database, expecting db.sqlite in the root directory.
$connectionParams = [
    'dbname'   => 'example',
    'path'     => __DIR__.'/../db.sqlite',
    'driver'   => 'pdo_sqlite',
];
$connection = DriverManager::getConnection($connectionParams, new Configuration);

// Create new Posts table, as per Doctrine Schema-Representation:
// http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/schema-representation.html
$schema = new Schema();
$posts = $schema->createTable('posts');
$posts->addColumn('id', 'integer', ['autoincrement' => true]);
$posts->addColumn('title', 'string');
$posts->addColumn('body', 'string');
$posts->addColumn('author', 'string');
$posts->setPrimaryKey(['id']);
$queries = $schema->toSql($connection->getDatabasePlatform());
foreach ($queries as $query) {
    $connection->executeQuery($query);
}