<?php

namespace PG\Http;

class Response
{
    protected $data;

    protected $status;

    public function __construct($data, $status)
    {
        $this->data = $data;
        $this->status = $status;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getValue($name, $defaultValue = null)
    {
        $this->ensureDataIsConverted();

        $exists = array_has($this->data, $name);

        if ($exists) {
            return array_get($this->data, $name);
        }

        return $defaultValue;
    }

    public function ensureDataIsConverted()
    {
        $isArray = is_array($this->data);

        if (!$isArray) {
            $this->data = json_decode($this->data, true);
        }

        return $this->data;
    }
}