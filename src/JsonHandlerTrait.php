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
        $array = self::decodeJsonToObjectOrArray($json, true);

        return $array;
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
        $object = self::decodeJsonToObjectOrArray($json);

        return $object;
    }

    /**
     * @param string  $json
     * @param boolean $toArray
     *
     * @return array|object
     */
    private function decodeJsonToObjectOrArray($json, $toArray = false)
    {
        $data = json_decode($json, $toArray);

        if(empty($data))
            throw new \InvalidArgumentException(json_last_error_msg(), json_last_error());

        return $data;
    }
}
