<?php

namespace Shortl\Shortl\Contracts;

/**
 * Interface Action
 * @package Shortl\Shortl\Contracts
 */
interface Action
{

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function __invoke($request,$response);

}