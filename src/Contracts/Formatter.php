<?php

namespace Shortl\Shortl\Contracts;

/**
 * Interface Formatter
 * @package Shortl\Shortl\Contracts
 */
interface Formatter
{
    /**
     * @return string
     */
    public function getOutput() : string;

}