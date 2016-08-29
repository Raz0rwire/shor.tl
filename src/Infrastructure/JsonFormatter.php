<?php

namespace Shortl\Shortl\Infrastructure;

/**
 * Class JsonFormatter
 * @package Shortl\Shortl\Infrastructure
 */
final class JsonFormatter
{

    private $output;


    /**
     * JsonFormatter constructor.
     */
    public function __construct($data)
    {
        $formatted = json_encode($data);
        if (is_null($formatted)) {
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
}

/**
 * Class UnserializableContent
 * @package Shortl\Shortl\Infrastructure
 */
class UnserializableContent extends \Exception
{
}
