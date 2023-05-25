<?php

namespace App\Models;

use App\Services\CacheService;

class ArtModel
{
    public $id;
    public $imageId;
    public $apiLink;
    public $title;
    public $artistTitle;
    public $imageUrl;

    public function __construct(array $artwork)
    {
        $this->id = $artwork['id'];
        $this->imageId = $artwork['image_id'];
        $this->apiLink = $artwork['api_link'];
        $this->title = $artwork['title'];
        $this->artistTitle = $artwork['artist_title'];
        $this->imageUrl = $artwork['image_url'];
    }
}