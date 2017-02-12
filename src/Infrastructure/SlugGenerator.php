<?php

namespace Shortl\Shortl\Infrastructure;

/**
 * Class SlugGenerator
 * @package Shortl\Shortl\Infrastructure
 */
final class SlugGenerator
{
    const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    /**
     * @param int $chars
     * @return string
     */
    public function __invoke(int $chars) : string
    {
        return $this->generate($chars);
    }


    /**
     * @param $chars
     * @return string
     */
    private function generate($chars) : string
    {
        $seed = str_split(self::chars);
        shuffle($seed);

        return implode('', iterator_to_array($this->generator($seed, $chars)));
    }


    /**
     * @param array $array
     * @param int $chars
     * @return \Traversable
     */
    private function generator(array $array, int $chars) : \Traversable
    {
        foreach (array_rand($array, $chars) as $k) yield $array[$k];
    }
}