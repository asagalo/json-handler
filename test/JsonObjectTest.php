<?php

namespace Asagalo\JsonHandler;

class JsonObjectTest extends \PHPUnit_Framework_TestCase
{
    public function assertPreConditions()
    {
        $jsonObject = JsonObject::createFromString('{"a":"b"}');
        $this->assertInstanceOf('Asagalo\JsonHandler\JsonObject', $jsonObject);
    }

    public function testAccessJsonData()
    {
        $jsonObject = JsonObject::createFromString('{"a":"b"}');
        $this->assertEquals($jsonObject->a, 'b');
    }

    public function testAccessUndefinedProperty()
    {
        $jsonObject = JsonObject::createFromString('{"a":"b"}');
        $this->setExpectedException('OutOfRangeException', 'The b doesn\'t exists!');
        $jsonObject->b;
    }

    public function testJsonObjectToArray()
    {
        $jsonObject = JsonObject::createFromString('{"a":"b"}');
        $this->assertSame($jsonObject->toArray(), ['a' => 'b']);
    }
}
