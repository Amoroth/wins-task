<?php

namespace App\Services;

use GuzzleHttp\Client as HttpClient;
use App\Models\ArtModel;
use App\Helpers\ImageHelper;

class ArtService
{
    const API_URL = 'https://api.artic.edu/api/v1';
    const ARTWORKS_PER_PAGE = 10;

    private $imageUrl = '';

    /**
     * Get artworks from api
     * 
     * @param int $page Page number
     * @return ArtModel[]
     */
    public function getArtworks(int $page = 0)
    {
        // fetch artworks from api using guzzle
        $client = new HttpClient();
        $res = $client->request('GET', self::API_URL . '/artworks/search', [
            'query' => [
                'size' => self::ARTWORKS_PER_PAGE,
                'from' => $page * self::ARTWORKS_PER_PAGE,
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'exists' => [
                                    'field' => 'image_id'
                                ]
                            ],
                            [
                                'term' => [
                                    'api_model' => 'artworks'
                                ]
                            ]
                        ]
                    ]
                ],
                'fields' => 'id,image_id,api_link,title,artist_title'

            ]
        ]);

        if ($res->getStatusCode() !== 200) {
            throw new \Exception('Error fetching artworks');
        }

        $artworks = json_decode($res->getBody()->getContents(), true);

        // save image url from response config for later use
        $this->imageUrl = $artworks['config']['iiif_url'];

        // map artworks to ArtModel
        $artworks = array_map(function ($artwork) {
            return new ArtModel(array_merge($artwork, ['image_url' => $this->getArtworkImage($artwork['image_id'])]));
        }, $artworks['data']);

        return $artworks;
    }

    public function getArtworkImage(string $imageId)
    {
        if (CacheService::getImage($imageId)) {
            return CacheService::getImage($imageId);
        }

        $client = new HttpClient();
        $res = $client->request('GET', "$this->imageUrl/$imageId/full/843,/0/default.jpg");

        if ($res->getStatusCode() !== 200) {
            throw new \Exception('Error fetching image');
        }

        $image = $res->getBody()->getContents();

        $sepiaImage = ImageHelper::sepia($image);

        return CacheService::cacheImage($imageId, $sepiaImage);
    }
}