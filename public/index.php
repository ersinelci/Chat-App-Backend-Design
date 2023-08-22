<?php

require __DIR__ . '/../vendor/autoload.php';

use DI\Container;
use Slim\Factory\AppFactory;
use Selective\BasePath\BasePathMiddleware;

// Create Container using PHP-DI
$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

$app->setBasePath("/chat-app/public/index.php");

// Add slim routing and body parsing middleware
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

// Set the base path to run the app in a subdirectory.

$app->add(new BasePathMiddleware($app));

$app->addErrorMiddleware(true, true, true);

// Set up the database connection (SQLite)
$container->set('db', function () {
    $dsn = 'sqlite:../chat.db';
    $username = null;
    $password = null;
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    try {
        return new PDO($dsn, $username, $password, $options);
    } catch (PDOException $e) {
        // Handle database connection error here
        exit('Failed to connect to database.');
    }
});

// Load routes
$routes = require(dirname(__FILE__) . '/../routes/chatRoutes.php');
$routes($app);

$app->run();
