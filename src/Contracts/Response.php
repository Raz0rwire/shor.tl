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
     * @param int $status
     * @return mixed
     */
    public function __invoke(string $content, array $headers, int $status);

}