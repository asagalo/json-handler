<?php

namespace Asagalo\JsonHandler;

use Asagalo\JsonHandler\JsonObject;

class JsonObjectTest extends \PHPUnit_Framework_TestCase
{
    public function assertPreConditions()
    {
        $jsonObject = new JsonObject();
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

    public function testRecursiveInstancesOfJsonObjectAndArrayTypes()
    {
        $json = new JsonObject('
        {
            "property": 1,
            "array": [2, 3],
        	"object": {
        		"property": 2,
        		"object": {
        			"property": 3
        		}
        	}
        }
        ');

        $this->assertInstanceOf('Asagalo\JsonHandler\JsonObject', $json->array);
        $this->assertEquals(2, $json->array[0]);
        $this->assertEquals(3, $json->array[1]);
        $this->assertInstanceOf('Asagalo\JsonHandler\JsonObject', $json->object);
        $this->assertInstanceOf('Asagalo\JsonHandler\JsonObject', $json->object->object);
    }

    public function testCreateJsonOnlyArray()
    {
        $json = new JsonObject('["a","b"]');

        $this->assertSame('a', $json[0]);
        $this->assertSame('b', $json[1]);

        $this->assertSame(['a','b'], $json->toArray());
    }

    public function testCreateJsonOnlyInt()
    {
        $json1 = new JsonObject(1);
        $json2 = new JsonObject(2);
        $json3 = new JsonObject(3);

        $this->assertSame(1, $json1[0]);
        $this->assertSame(2, $json2[0]);
        $this->assertSame(3, $json3[0]);

        $this->assertSame([1], $json1->toArray());
        $this->assertSame([2], $json2->toArray());
        $this->assertSame([3], $json3->toArray());
    }

    public function testCreateJsonOnlyString()
    {
        $json1 = new JsonObject('"string"');
        $json2 = new JsonObject('"john"');

        $this->assertSame('string', $json1[0]);
        $this->assertSame('john', $json2[0]);
        $this->assertSame(["string"], $json1->toArray());
        $this->assertSame(["john"], $json2->toArray());
    }
}
