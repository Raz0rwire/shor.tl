<?php

namespace Shortl\Shortl\Contracts;

/**
 * Interface Action
 * @package Shortl\Shortl\Contracts
 */
interface Action
{

    /**
     * Action constructor.
     * @param $config
     */
    public function __construct(array $config);


    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function __invoke(Request $request, Response $response);

}