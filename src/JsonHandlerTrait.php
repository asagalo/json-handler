<?php

namespace Asagalo\JsonHandler;

trait JsonHandlerTrait
{
    /**
     * @param array $array
     *
     * @return string
     **/
    public function arrayToJson(array $array)
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
    public function jsonToArray($json)
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
    public function jsonToObject($json)
    {
        $object = json_decode($json);

        if(empty($object))
            throw new \InvalidArgumentException(json_last_error_msg(), json_last_error());

        return $object;
    }
}
