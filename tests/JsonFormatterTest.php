<?php

class JsonFormatterTest extends PHPUnit_Framework_TestCase
{
    public function testJsonableValue()
    {
        $formatter = new \Shortl\Shortl\Infrastructure\JsonFormatter(['test' => 'should pass']);
        $this->assertEquals('{"test":"should pass"}', $formatter->getOutput());
    }

    /**
     * @expectedException \Shortl\Shortl\Infrastructure\UnserializableContent
     */
    public function testNonJsonableValue()
    {
        new \Shortl\Shortl\Infrastructure\JsonFormatter(null);
        $this->expectException(\Shortl\Shortl\Infrastructure\UnserializableContent::class);
    }
}