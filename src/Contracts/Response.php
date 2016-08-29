<?php

namespace Shortl\Shortl\Contracts;

/**
 * Interface Response
 * @package Shortl\Shortl\Contracts
 */
interface Response
{
    /**
     * @param string $content
     * @param array $headers
     * @return mixed
     */
    public function __invoke($content, array $headers);
}