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
     * @param int $status
     * @return string
     */
    public function __invoke(string $data, array $headers, int $status = 200)
    {
        http_response_code($status);
        $this->setHeaders($headers);

        return $data;
    }


    /**
     * @param array $array
     */
    private function setHeaders(array $array)
    {
        $headers = array_merge($array, ['Handled-By' => 'Shortl Shortl']);

        foreach ($headers as $header => $value) {
            header(implode(': ', [$header, $value]));
        }
    }

}