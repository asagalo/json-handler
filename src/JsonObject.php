<?php

namespace Asagalo\JsonHandler;

class JsonObject implements \IteratorAggregate, \ArrayAccess
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

    public function __construct($data = [])
    {
        if(is_array($data) || is_object($data)) {
            $this->buildData((array) $data);
            return ;
        }

        try {
            $this->buildData($this->jsonToArray($data));
        } catch (\InvalidArgumentException $e) {
            $this->valid        = false;
            $this->errorMessage = $e->getMessage();
            $this->errorCode    = $e->getCode();
        }
    }

    /**
     * @param mixed $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        if(false === key_exists($property, $this->data))
            throw new \OutOfRangeException('The ' . $property . ' doesn\'t exists!');

        return $this->data[$property];
    }

    /**
     * @param string $property
     * @param mixed  $value
     */
    public function __set($property, $value)
    {
        $this->data[$property] = $value;
    }

    /**
     * @return array
     **/
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @return boolean
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    /**
     * @param mixed
     */
    private function buildData($data)
    {
        foreach ($data as $key => $value) {

            if(is_object($value)) {
                $this->data[$key] = new self($value);
                continue;
            }

            if(is_array($value)) {
                $this->data[$key] = new self($value);
                continue;
            }

            $this->data[$key] = $value;
        }
    }

    /**
     * @param mixed $offset
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * @param mixed $offset
     */
    public function offsetGet($offset)
    {
        if($this->offsetExists($offset))
            return $this->data[$offset];

        return null;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}
