<?php

namespace Shortl\Shortl\Infrastructure\Handlers;

use Shortl\Shortl\Contracts\Action;
use Shortl\Shortl\Contracts\Request;
use Shortl\Shortl\Contracts\Response;

use Shortl\Shortl\Domain\UnreachableUrl;
use Shortl\Shortl\Domain\Url;

use Shortl\Shortl\Infrastructure\JsonFormatter;
use Shortl\Shortl\Repositories\ShortenedUrl;

/**
 * Class CreateShortUrl
 * @package Shortl\Shortl\Infrastructure\Handlers
 */
class CreateShortUrl implements Action
{
    public function __invoke(Request $request, Response $response, array $config)
    {

        $parts = $request->uri_parts;
        parse_str($parts['query'] ?? null, $query);
        $url = $query['url'] ?? false;

        try {
            $dto = Url::createShortenedUrlFromUrl(new ShortenedUrl($config), $url);

            $content = (new JsonFormatter(
                [
                    'data' => [
                        'url' => $dto->url,
                        'short_url' => $config['base_url'] . $dto->slug
                    ]
                ]
            ))->output;

            $status = 201;

        } catch (UnreachableUrl $e) {

            $content = (new JsonFormatter(
                [
                    'errors' => [
                        'url' => 'Url is not formatted correctly',
                    ]
                ]
            ))->output;

            $status = 422;
        }

        return $response(
            $content,
            [
                'Content-Type' => 'application/json'
            ],
            $status
        );

    }

}