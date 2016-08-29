<?php

namespace Shortl\Shortl\Contracts;

/**
 * Interface Action
 * @package Shortl\Shortl\Contracts
 */
interface Action{

    /**
     * @param Request $request
     * @param Response $response
     * @param array $config
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, array $config);

}