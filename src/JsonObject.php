<?php

namespace Asagalo\JsonHandler;

class JsonObject
{
    use JsonHandlerTrait;

    /**
     * @var array json data
     */
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $json
     */
    public static function createFromString($json)
    {
        return new self(self::jsonToArray($json));
    }

    /**
     * Method to access json data
     */
    public function __get($property)
    {
        if(false === key_exists($property, $this->data))
            throw new \OutOfRangeException('The ' . $property . ' doesn\'t exists!');

        return $this->data[$property];
    }
}
