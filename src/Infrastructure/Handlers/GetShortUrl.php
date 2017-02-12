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
        $repository = new ShortenedUrl($this->config);
        $dto = Url::findShortenedUrlBySlug($repository, $request->action);

        Url::incrementClicks($repository, $request->action, $dto);

        return $response('', [
            'Location' => $dto->url,
            'HTTP/1.1' => 302
        ]);
    }

}