<?php

namespace Shortl\Shortl\Infrastructure;

use Shortl\Shortl\Contracts\Action;
use Shortl\Shortl\Domain\Url;

/**
 * Class ActionMapper
 * @package Shortl\Shortl\Infrastructure
 */
final class ActionMapper
{

    const routeMap = [
        'get' => \Shortl\Shortl\Infrastructure\Handlers\GetShortUrl::class,
        'new' => \Shortl\Shortl\Infrastructure\Handlers\CreateShortUrl::class
    ];

    const getRegex = "/^[a-zA-Z0-9]{" . Url::slugLength . "}$/";


    /**
     * @param RequestParser $request
     * @return Action
     * @throws ActionNotFound
     */
    public function __invoke(RequestParser $request)  : Action
    {
        return $this->getAction($request);
    }


    /**
     * @param RequestParser $request
     * @return Action
     * @throws ActionNotFound
     */
    private function getAction(RequestParser $request) : Action
    {
        $action = null;

        if ($this->checkGetRegex($request->action)) {
            $action = self::routeMap['get'];
        }

        if (!$action && array_key_exists($request->action, self::routeMap)) {
            $action = self::routeMap[$request->action];
        }

        if (!$action) {
            throw new ActionNotFound($request->action . ' not found');
        }

        return new $action();
    }


    /**
     * @param string $action
     * @return bool
     */
    private function checkGetRegex(string $action) : bool
    {
        return preg_match(self::getRegex, $action, $matches);
    }
}

class ActionNotFound extends \Exception
{
}