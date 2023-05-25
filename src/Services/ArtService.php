<?php

namespace App\Services;

use GuzzleHttp\Client as HttpClient;
use App\Models\ArtModel;

class ArtService
{
    const API_URL = 'https://api.artic.edu/api/v1';
    const ARTWORKS_PER_PAGE = 10;

    /**
     * Get artworks from api
     * 
     * @param int $page Page number
     * @return ArtModel[]
     */
    public function get_artworks(int $page = 0)
    {
        // fetch artworks from api using guzzle
        $client = new HttpClient();
        $res = $client->request('GET', self::API_URL . '/artworks', [
            'query' => [
                'limit' => self::ARTWORKS_PER_PAGE,
                'page' => $page,
                'fields' => 'id,image_id,api_link,title,artist_title'
            ]
        ]);

        if ($res->getStatusCode() !== 200) {
            throw new \Exception('Error fetching artworks');
        }

        $artworks = json_decode($res->getBody()->getContents(), true);

        // map artworks to ArtModel
        $artworks = array_map(function ($artwork) {
            return new ArtModel($artwork);
        }, $artworks['data']);

        return $artworks;
    }
}