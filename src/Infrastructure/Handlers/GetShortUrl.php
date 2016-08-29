<?php

namespace Shortl\Shortl\Infrastructure\Handlers;

use Shortl\Shortl\Contracts\Action;
use Shortl\Shortl\Contracts\Request;
use Shortl\Shortl\Contracts\Response;

use Shortl\Shortl\Domain\Url;
use Shortl\Shortl\Repositories\ShortenedUrl;


/**
 * Class GetShortUrl
 * @package Shortl\Shortl\Infrastructure\Handlers
 */
class GetShortUrl implements Action
{


    /**
     * @param Request $request
     * @param Response $response
     * @param array $config
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, array $config)
    {
        $dto = Url::findShortenedUrlBySlug(new ShortenedUrl($config), $request->action);

        return $response('', [
            'Location' => $dto->url
        ], 301);
    }

}