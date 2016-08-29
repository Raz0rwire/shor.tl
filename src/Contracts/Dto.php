<?php

namespace Shortl\Shortl\Contracts;

/**
 * Interface Dto
 * @package Shortl\Shortl\Contracts
 */
interface Dto
{
    /**
     * @param array $data
     * @return mixed
     */
    public function __invoke(array $data);


    /**
     * @return array
     */
    public function export() : array;
}