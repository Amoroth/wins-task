<?php

use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use App\Controllers\GalleryController;

require __DIR__ . '/../vendor/autoload.php';

// Instantiate App
$app = AppFactory::create();

$twig = Twig::create(__DIR__ . '/../src/Templates', [
    'cache' => false,
    'auto_reload' => true
]);

$app->add(TwigMiddleware::create($app, $twig));

// Add routing middleware
$app->addRoutingMiddleware();

// Add Error Handling Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Define app routes
$app->get('/', GalleryController::class . ':index');

// Run app
$app->run();