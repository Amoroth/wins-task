<?php

namespace App\Models;

use App\Services\CacheService;

class ArtModel
{
    public $id;
    public $image_id;
    public $api_link;
    public $title;
    public $artist_title;

    public function __construct(array $artwork)
    {
        $this->id = $artwork['id'];
        $this->image_id = $artwork['image_id'];
        $this->api_link = $artwork['api_link'];
        $this->title = $artwork['title'];
        $this->artist_title = $artwork['artist_title'];
    }
}