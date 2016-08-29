<?php

namespace Shortl\Shortl\Infrastructure;

use Shortl\Shortl\Contracts\Request;

/**
 * Class Request
 * @package Shortl\Shortl\Infrastructure
 */
final class RequestParser implements Request
{
    const requestUri = 'REQUEST_URI';

    private $action, $uri_parts;


    /**
     * @param $server
     * @return Request
     */
    public function __invoke(array $server) : Request
    {
        $this->uri_parts = $this->getRequestUriParts($server);
        $this->action = $this->parseAction($server);
        return $this;
    }


    /**
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->{$property} ?? null;
    }


    /**
     * @param array $server
     * @return string
     */
    private function parseAction(array $server) : string
    {
        $parts = $this->getRequestUriParts($server);
        $action = explode('/', $parts['path'])[1] ?? '';
        return $action;
    }


    /**
     * @param array $server
     * @return array
     */
    private function getRequestUriParts(array $server) : array
    {
        return parse_url($server[self::requestUri]);
    }
}