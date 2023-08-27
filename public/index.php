<?php

// Enable all PHP error reporting levels.
error_reporting(-1);

// Load all the necessary files from the vendor directory.
require_once __DIR__.'/../vendor/autoload.php';

// Namespace declarations.
use \Doctrine\DBAL\Configuration;
use \Doctrine\DBAL\DriverManager;
use \Bdt\Example\Model;
use \Bdt\Example\Application;

// Initialise database connection.
$connectionParams = [
    'user'     => '',
    'password' => '',
    'path'     => __DIR__.'/../db.sqlite',
    'driver'   => 'pdo_sqlite',
];

// Set up a default database connection using Doctrine DBAL.
Model::setDefaultConnection(DriverManager::getConnection($connectionParams, new Configuration));

// Create new application with reference to superglobals.
$app = new Application($_SERVER, $_POST, $_GET);

// Route application to different controller actions.

$app
    ->route('/',                'App\Controllers\PostsController::index')
    ->route('/add',             'App\Controllers\PostsController::add')
    ->route('/edit/{id:\d+}',   'App\Controllers\PostsController::edit')
    ->route('/delete/{id:\d+}', 'App\Controllers\PostsController::delete')
    ->run(); // Execute the application.
