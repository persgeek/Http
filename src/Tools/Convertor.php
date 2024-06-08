<?php

namespace PG\Http\Tools;

use Exception;

class Convertor
{
    protected $algos;

    public function __construct($algos)
    {
        $this->algos = $algos;
    }

    public function convert($name, $value)
    {
        $algo = $this->findAlgo($name);

        if ($algo) {
            return $this->algo($algo, $value);
        }

        return $value;
    }

    public function findAlgo($name)
    {
        $algo = array_get($this->algos, $name);

        return $algo;
    }

    public function algo($algo, $value)
    {
        $exists = $this->hasAlgo($algo);

        if ($exists) {
            return hash($algo, $value);
        }

        $exists = $this->hasCustomAlgo($algo);

        if ($exists) {
            return $this->$algo($value);
        }

        throw new Exception('Could not find algo');
    }

    public function base64($value)
    {
        return base64_encode($value);
    }

    public function boolean($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public function hasAlgo($algo)
    {
        $algos = $this->getAlgos();

        $exists = in_array($algo, $algos);

        return $exists;
    }

    public function hasCustomAlgo($algo)
    {
        $algos = $this->getCustomAlgos();

        $exists = in_array($algo, $algos);

        return $exists;
    }

    public function getAlgos()
    {
        return ['md5', 'sha1', 'sha256', 'sha512'];
    }

    public function getCustomAlgos()
    {
        return ['base64', 'boolean'];
    }
}