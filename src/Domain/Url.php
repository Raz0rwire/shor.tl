<?php

namespace Shortl\Shortl\Domain;

use Shortl\Shortl\Contracts\Dto;
use Shortl\Shortl\Dto\ShortUrl;
use Shortl\Shortl\Infrastructure\EntityNotFound;
use Shortl\Shortl\Infrastructure\Repository;
use Shortl\Shortl\Infrastructure\SlugGenerator;

/**
 * Class Url
 * @package Shortl\Shortl\Domain
 */
class Url
{

    const slugLength       = 4;
    const solidUrlRegex = '_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$_iuS';

    /**
     * @param Repository $repository
     * @param $slug
     * @return Dto
     */
    public static function findShortenedUrlBySlug(Repository $repository, $slug) : Dto
    {
        return $repository(new ShortUrl(), 'get', $slug);
    }


    /**
     * @param Repository $repository
     * @param $url
     * @return Dto
     * @throws UnreachableUrl
     */
    public static function createShortenedUrlFromUrl(Repository $repository, $url) : Dto
    {
        $self = new self();

        try {
            $dto = $repository(new ShortUrl(), 'find', $url, ['column' => 'url']);
        } catch (EntityNotFound $e) {

            if (!$self->validateUrl($url)) {
                throw new UnreachableUrl();
            }

            $generator = new SlugGenerator();
            $dto = new ShortUrl(
                [
                    'slug' => $self->getUniqueSlug($generator, $repository),
                    'created_at' => date('Y-m-d H:i:s'),
                    'url' => $url
                ]
            );

            $repository($dto, 'add');
        }

        return $dto;
    }


    /**
     * @param SlugGenerator $generator
     * @param Repository $repository
     * @return string
     */
    private function getUniqueSlug(SlugGenerator $generator, Repository $repository) : string
    {
        $unique = false;
        $slug = '';

        while (!$unique) {
            try {
                $slug = $generator(self::slugLength);
                $repository(new ShortUrl(), 'get', $slug);
            } catch (EntityNotFound $e) {
                $unique = true;
            }
        }

        return $slug;
    }


    /**
     * @param string $string
     * @return bool
     */
    private function validateUrl(string $string) : bool
    {
        return preg_match(self::solidUrlRegex, $string);
    }
}

/**
 * Class UnreachableUrl
 * @package Shortl\Shortl\Domain
 */
class UnreachableUrl extends \Exception
{
}