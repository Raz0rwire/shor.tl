<?php

namespace Shortl\Shortl\Repositories;

use Shortl\Shortl\Infrastructure\Repository;

/**
 * Class ShortenedUrl
 * @package Shortl\Shortl\Repositories
 */
class ShortenedUrl extends Repository
{
    protected $primary_key = 'slug';
    protected $table       = 'urls';
}