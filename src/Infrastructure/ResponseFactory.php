<?php

namespace Shortl\Shortl\Infrastructure;

use Shortl\Shortl\Contracts\Response;

/**
 * Class ResponseFactory
 * @package Shortl\Shortl\Infrastructure
 */
final class ResponseFactory implements Response
{

    /**
     * @param string $data
     * @param array $headers
     * @return string
     */
    public function __invoke(string $data, array $headers)
    {
        $this->setHeaders($headers);
        return $data;
    }


    /**
     * @param array $headers
     */
    private function setHeaders(array $headers)
    {
        foreach ($headers + ['Handled-By' => 'Shor.tl', 'HTTP/1.1' => '200 OK'] as $header => $value) {
            header(implode(': ', [$header, $value]));
        }
    }
}