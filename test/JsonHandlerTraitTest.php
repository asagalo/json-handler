<?php

namespace Asagalo\JsonHandler;

class JsonHandlerTraitTest extends \PHPUnit_Framework_TestCase
{
    private $jsonHandler;

    public function setUp()
    {
        $this->jsonHandler = $this->getMockForTrait('Asagalo\JsonHandler\JsonHandlerTrait');
    }

    public function testEncodeAnArrayToJsonString()
    {
        $array = ['a' => 'b'];

        $json = $this->jsonHandler->arrayToJson($array);

        $this->assertEquals($json, '{"a":"b"}');
    }

    public function testDecodeJsonStringToAnArray()
    {
        $json   = '{"a":"b"}';
        $array  = $this->jsonHandler->jsonToArray($json);
        $this->assertSame($array, ['a' => 'b']);
    }

    public function testDecodeJsonStringToAnObject()
    {
        $json        = '{"a":"b"}';
        $object      = $this->jsonHandler->jsonToObject($json);
        $expected    = new \stdClass;
        $expected->a = 'b';
        
        $this->assertEquals($expected, $object);
    }

    public function testThrowInvalidArgumentException()
    {
        $json = '{a":b}';

        $this->setExpectedException('InvalidArgumentException');
        $this->jsonHandler->jsonToArray($json);
    }
}
