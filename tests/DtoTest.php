<?php

class DtoTest extends PHPUnit_Framework_TestCase
{
    public function testFillsDtoInConstructor()
    {
        $short_url = new \Shortl\Shortl\Dto\ShortUrl(
            [
                'slug' => 'test',
                'url' => 'https://google.com',
                'created_at' => date('Y-m-d H:i:s')
            ]
        );
    }

    /**
     * @expectedException \Shortl\Shortl\Traits\DtoAlreadyFilled
     */
    public function testDoubleDtoFill()
    {
        $short_url = new \Shortl\Shortl\Dto\ShortUrl();
        $short_url(
            [
                'slug' => 'test',
                'url' => 'https://google.com',
                'created_at' => date('Y-m-d H:i:s')
            ]
        );

        $short_url(
            [
                'slug' => 'test',
                'url' => 'https://google.com',
                'created_at' => date('Y-m-d H:i:s')
            ]
        );

        $this->expectException(\Shortl\Shortl\Traits\DtoAlreadyFilled::class);
    }

}