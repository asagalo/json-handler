<?php

namespace Asagalo\JsonHandler;

class JsonObjectTest extends \PHPUnit_Framework_TestCase
{
    protected $jsonObject;

    public function setUp()
    {
        $this->jsonObject = JsonObject::createFromString('{"a":"b"}');
    }

    public function assertPreConditions()
    {
        $this->assertInstanceOf('Asagalo\JsonHandler\JsonObject', $this->jsonObject);
    }

    public function testAccessJsonData()
    {
        $this->assertEquals($this->jsonObject->a, 'b');
    }

    public function testAccessUndefinedProperty()
    {
        $this->setExpectedException('OutOfRangeException', 'The b doesn\'t exists!');
        $this->jsonObject->b;
    }
}
