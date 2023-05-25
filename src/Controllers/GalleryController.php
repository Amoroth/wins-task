<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Services\ArtService;

class GalleryController
{
    public function index(Request $request, Response $response, $args): Response
    {
        $artworks = (new ArtService())->get_artworks();

        $response->getBody()->write("Hello world!");
        return $response;
    }
}