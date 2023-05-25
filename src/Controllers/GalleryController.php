<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GalleryController
{
    public function index(Request $request, Response $response, $args): Response
    {
        $response->getBody()->write("Hello world!");
        return $response;
    }
}