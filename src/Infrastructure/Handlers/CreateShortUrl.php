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
    /**
     * @var array
     */
    private $config;


    /**
     * GetShortUrl constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }


    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function __invoke(Request $request, Response $response)
    {

        $parts = $request->uri_parts;
        parse_str($parts['query'] ?? null, $query);
        $url = $query['url'] ?? false;

        try {
            $dto = Url::createShortenedUrlFromUrl(new ShortenedUrl($this->config), $url);

            $content = (new JsonFormatter(
                [
                    'data' => [
                        'url' => $dto->url,
                        'short_url' => $this->config['base_url'] . $dto->slug
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
                'Content-Type' => 'application/json',
                'HTTP/1.1' => $status
            ],
            $status
        );

    }

}