<?php

namespace Shortl\Shortl\Infrastructure;
use Shortl\Shortl\Contracts\Formatter;

/**
 * Class JsonFormatter
 * @package Shortl\Shortl\Infrastructure
 */
final class JsonFormatter implements Formatter
{
    private $output;

    /**
     * JsonFormatter constructor.
     */
    public function __construct($data)
    {
        $formatted = json_encode($data);
        if (is_null($formatted) || $formatted === 'null') {
            throw new UnserializableContent();
        }

        $this->output = $formatted;
    }


    /**
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        switch ($property) {
            case 'output':
                return $this->{$property};
            default:
                return null;
        }
    }


    /**
     * @return string
     */
    public function getOutput() : string
    {
        return $this->output;
    }
}

/**
 * Class UnserializableContent
 * @package Shortl\Shortl\Infrastructure
 */
class UnserializableContent extends \Exception
{
}
