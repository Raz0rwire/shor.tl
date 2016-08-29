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
     * @param array $array
     */
    private function setHeaders(array $array)
    {
        $headers = ['Handled-By' => 'Shortl Shortl', 'HTTP/1.1' => '200 OK'] + $array;

        foreach ($headers as $header => $value) {
            header(implode(': ', [$header, $value]));
        }
    }

}