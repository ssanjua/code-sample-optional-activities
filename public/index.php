<?php

error_reporting(-1);
require_once __DIR__.'/../vendor/autoload.php';


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
Model::setDefaultConnection(DriverManager::getConnection($connectionParams, new Configuration));

// Create new application with reference to superglobals.
$app = new Application($_SERVER, $_POST, $_GET);

// Route application to different controller actions.
$app
    ->route('/',              'App\Controllers\PostsController::index')
    ->route('/add',           'App\Controllers\PostsController::add')
    ->route('/edit/{id:\d+}', 'App\Controllers\PostsController::edit')
    ->route('/delete/{id:\d+}', 'App\Controllers\PostsController::delete')
    ->run();
