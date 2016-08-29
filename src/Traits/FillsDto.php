<?php

namespace Shortl\Shortl\Traits;

use Shortl\Shortl\Contracts\Dto;

/**
 * Class FillsDto
 * @package Shortl\Shortl\Traits
 */
trait FillsDto
{
    private $filled = false;

    /**
     * Dto constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->fill($data);
    }


    /**
     * @param array $data
     * @return Dto
     */
    public function __invoke(array $data) : Dto
    {
        $this->fill($data);
        return $this;
    }


    /**
     * @param $property
     * @return null
     */
    public function __get($property)
    {
        return $this->{$property} ?? null;
    }


    /**
     * @param array $data
     * @throws DtoAlreadyFilled
     * @throws MissingDtoValue
     */
    protected function fill(array $data)
    {
        if (!empty($data)) {

            if ($this->filled) {
                throw new DtoAlreadyFilled('DTO\'s can only have their value set once, either create an empty DTO and invoke or pass the data into a constructor of a newly instantiated DTO');
            }

            $this->filled = true;

            foreach ($this->properties as $property) {
                $this->{$property} = $data[$property] ?? null;
                if (!$this->{$property}) {
                    throw new MissingDtoValue(sprintf('Property `%s` is not set in data array', $property));
                }
            }
        }
    }


    /**
     * @return array
     */
    public function export() : array
    {

        $array = [];

        foreach($this->properties as $prop){
            $array[':' . $prop] = $this->{$prop};
        }

        return $array;
    }
}

/**
 * Class MissingDtoValue
 * @package Shortl\Shortl\Traits
 */
class MissingDtoValue extends \Exception
{
}

/**
 * Class DtoAlreadyFilled
 * @package Shortl\Shortl\Traits
 */
class DtoAlreadyFilled extends \Exception
{
}