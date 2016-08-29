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
        $headers = $array + ['Handled-By' => 'Shor.tl', 'HTTP/1.1' => '200'];

        foreach ($headers as $header => $value) {
            if ($header === 'HTTP/1.1') {
                http_response_code($value);
            }

            header(implode(': ', [$header, $value]));
        }
    }
}