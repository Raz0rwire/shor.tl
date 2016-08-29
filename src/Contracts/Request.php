<?php

namespace Shortl\Shortl\Contracts;

/**
 * Interface Request
 * @package Shortl\Shortl\Contracts
 */
interface Request
{
    /**
     * @param array $server
     * @return Request
     */
    public function __invoke(array $server) : Request;

}