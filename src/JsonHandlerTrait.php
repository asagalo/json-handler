<?php

namespace Asagalo\JsonHandler;

trait JsonHandlerTrait
{
    /**
     * @param array $array
     *
     * @return string
     **/
    public function arrayToJson(array $array) : string
    {
        return json_encode($array);
    }

    /**
     * @param string $json
     *
     * @throws InvalidArgumentException
     *
     * @return array
     **/
    public function jsonToArray(string $json) : array
    {
        return (array) self::jsonToObject($json);
    }

    /**
     * @param string $json
     *
     * @throws InvalidArgumentException
     *
     * @return stdClass
     **/
    public function jsonToObject(string $json) : \stdClass
    {
        $object = json_decode($json);

        if(empty($object))
            throw new \InvalidArgumentException(json_last_error_msg(), json_last_error());

        return $object;
    }
}
