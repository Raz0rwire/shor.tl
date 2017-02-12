<?php

namespace Shortl\Shortl\Dto;

use Shortl\Shortl\Contracts\Dto;
use Shortl\Shortl\Traits\FillsDto;

/**
 * Class ShortenedUrl
 * @package Shortl\Shortl\Dto
 */
final class ShortUrl implements Dto
{
    use FillsDto;

    private $properties = [
        'slug',
        'url',
        'created_at',
        'clicks'
    ];

    private $slug, $url, $created_at, $clicks;
}