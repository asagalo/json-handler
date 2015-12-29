<?php

namespace Asagalo\JsonHandler;

class JsonObjectTest extends \PHPUnit_Framework_TestCase
{
    public function assertPreConditions()
    {
        $jsonObject = new JsonObject('{"a":"b"}');
        $this->assertInstanceOf('Asagalo\JsonHandler\JsonObject', $jsonObject);
    }

    public function testAccessJsonData()
    {
        $jsonObject = new JsonObject('{"a":"b"}');
        $this->assertEquals($jsonObject->a, 'b');
    }

    public function testSetJsonData()
    {
        $jsonObject    = new JsonObject('{"a":"b"}');
        $jsonObject->b = 'a';

        $this->assertEquals($jsonObject->b, 'a');
        $this->assertEquals($jsonObject->a, 'b');

        $jsonObject->a = 'c';
        $this->assertEquals($jsonObject->a, 'c');
    }

    public function testAccessUndefinedProperty()
    {
        $jsonObject = new JsonObject('{"a":"b"}');
        $this->setExpectedException('OutOfRangeException', 'The b doesn\'t exists!');
        $jsonObject->b;
    }

    public function testJsonObjectToArray()
    {
        $jsonObject = new JsonObject('{"a":"b"}');
        $this->assertSame($jsonObject->toArray(), ['a' => 'b']);
    }

    public function testIsValidMethodWithJsonErrorSyntax()
    {
        $jsonObject = new JsonObject('{a":b}');
        $this->assertFalse($jsonObject->isValid());
    }

    public function testIsValidMethodWithNoJsonErrorSyntax()
    {
        $jsonObject = new JsonObject('{"a":"b"}');
        $this->assertTrue($jsonObject->isValid());
    }

    public function testConstructJsonWithAnArray()
    {
        $jsonObject = new JsonObject(['a' => 'b']);

        $this->assertTrue($jsonObject->isValid());
        $this->assertSame($jsonObject->toArray(), ['a' => 'b']);
    }

    public function testGetLastJsonParseErrorMessage()
    {
        $jsonObject = new JsonObject('{a":b}');
        $this->assertNotNull($jsonObject->getErrorMessage());
    }

    public function testGetLastJsonParseErrorCode()
    {
        $jsonObject = new JsonObject('{a":b}');
        $this->assertEquals(JSON_ERROR_SYNTAX, $jsonObject->getErrorCode());
    }

    public function testJsonIteration()
    {
        $expected = [1,2,3];

        $jsonObject = new JsonObject('{"a":1,"b":2,"c":3}');

        $returned = [];

        foreach($jsonObject as $value)
            $returned[] = $value;

        $this->assertSame($expected, $returned);
    }
}
