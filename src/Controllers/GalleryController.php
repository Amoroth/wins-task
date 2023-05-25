<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use App\Services\ArtService;

class GalleryController
{
    public function index(Request $request, Response $response, $args): Response
    {
        $artworks = (new ArtService())->getArtworks();

        $view = Twig::fromRequest($request);
        return $view->render($response, 'gallery.html', [
            'artworks' => $artworks
        ]);
    }
}