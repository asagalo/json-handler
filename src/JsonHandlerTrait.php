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
        $array = self::decodeJson($json, true);

        return $array;
    }

    /**
     * @param string $json
     *
     * @throws InvalidArgumentException
     *
     * @return stdClass
     **/
    public function jsonToObject(string $json) : object
    {
        $object = self::decodeJson($json);

        return $object;
    }

    /**
     * @param string  $json
     * @param boolean $toArray
     *
     * @return array|object
     */
    private function decodeJson(string $json, boolean $toArray) : array
    {
        $data = json_decode($json, $toArray ?? false);

        if(empty($data))
            throw new \InvalidArgumentException(json_last_error_msg(), json_last_error());

        return $data;
    }
}
