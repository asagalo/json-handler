<?php

namespace Asagalo\JsonHandler;

class JsonObject
{
    use JsonHandlerTrait;

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function createFromString($jsonString)
    {
        return new self(self::jsonToArray($jsonString));
    }

    public function __get($property)
    {
        if(false === key_exists($property, $this->data))
            throw new \OutOfRangeException('The ' . $property . ' doesn\'t exists!');

        return $this->data[$property];
    }
}
