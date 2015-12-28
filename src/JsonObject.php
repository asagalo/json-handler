<?php

namespace Asagalo\JsonHandler;

class JsonObject implements \IteratorAggregate
{
    use JsonHandlerTrait;

    /**
     * @var array json data
     */
    protected $data;

    /**
     * @var boolean
     **/
    protected $valid = true;

    /**
     * @var string
     **/
    protected $errorMessage = '';

    /**
     * @var int
     **/
    protected $errorCode = 0;

    public function __construct($data)
    {
        if(is_array($data)) {
            $this->data = $data;
            return ;
        }

        try {
            $this->data = $this->jsonToArray($data);
        } catch (\InvalidArgumentException $e) {
            $this->valid        = false;
            $this->errorMessage = $e->getMessage();
            $this->errorCode    = $e->getCode();
        }
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

    /**
     * @return array
     **/
    public function toArray() : array
    {
        return $this->data;
    }

    /**
     * @return boolean
     */
    public function isValid() : bool
    {
        return $this->valid;
    }

    /**
     * @return string
     */
    public function getErrorMessage() : string
    {
        return $this->errorMessage;
    }

    /**
     * @return int
     */
    public function getErrorCode() : int
    {
        return $this->errorCode;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator() : \ArrayIterator
    {
        return new ArrayIterator($this->data);
    }
}
