<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Controllers\GalleryController;

require __DIR__ . '/../vendor/autoload.php';

// Instantiate App
$app = AppFactory::create();

// Add routing middleware
$app->addRoutingMiddleware();

// Add Error Handling Middleware
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Define app routes
$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});

// Run app
$app->run();