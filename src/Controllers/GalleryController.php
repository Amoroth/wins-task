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
        $artworksPage = $request->getQueryParams()['page'] ?? 0;
        $artworks = (new ArtService())->getArtworks($artworksPage);

        if ($request->getHeaderLine('X-Requested-With') === 'XMLHttpRequest') {
            $response->getBody()->write(json_encode($artworks));
            return $response->withHeader('Content-Type', 'application/json');
        }

        $view = Twig::fromRequest($request);
        return $view->render($response, 'gallery.html', [
            'artworks' => $artworks
        ]);
    }
}