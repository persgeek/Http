<?php

namespace PG\Http;

use PG\Http\Tools\Translator;
use PG\Http\Tools\Convertor;

class Request
{
    protected $translator;

    protected $convertor;

    protected $address;

    protected $method;

    protected $isJson;

    protected $headers = [];

    protected $params = [];

    protected $username;

    protected $password;

    public function setTranslator(Translator $translator)
    {
        $this->translator = $translator;

        return $this;
    }

    public function getTranslator()
    {
        return $this->translator;
    }

    public function setConvertor(Convertor $convertor)
    {
        $this->convertor = $convertor;

        return $this;
    }

    public function getConvertor()
    {
        return $this->convertor;
    }

    public function setAddress($value)
    {
        $this->address = $value;

        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setMethod($value)
    {
        $this->method = $value;

        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setIsJson($value)
    {
        $this->isJson = $value;

        return $this;
    }

    public function getIsJson()
    {
        return $this->isJson;
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setUsername($value)
    {
        $this->username = $value;

        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($value)
    {
        $this->password = $value;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getBasicAuth()
    {
        $credentials = [$this->username, $this->password];

        return implode(':', $credentials);
    }

    public function getResponse()
    {
        $address = $this->getTranslator()
            ->translate($this->address);

        $headers = $this->mergeHeaders();

        $params = $this->mergeParams();

        if ($this->isJson) {
            $params = json_encode($params);
        } else {
            $params = http_build_query($params);
        }

        return $this->send($address, $this->method, $headers, $params);
    }

    public function mergeHeaders()
    {
        $headers = [];

        foreach ($this->headers as $name => $value) {

            $value = $this->getTranslator()
                ->translate($value);

            $headers[] = "{$name}:{$value}";
        }

        return $headers;
    }

    public function mergeParams()
    {
        $params = [];

        foreach ($this->params as $name => $value) {

            $value = $this->getTranslator()
                ->translate($value);

            $value = $this->getConvertor()
                ->convert($name, $value);

            $params[$name] = $value;
        }

        return $params;
    }

    public function send($address, $method, $headers, $params)
    {
        $curl = curl_init($address);

        $options = [CURLOPT_CUSTOMREQUEST => $method, CURLOPT_FOLLOWLOCATION => true, CURLOPT_RETURNTRANSFER => true, CURLOPT_SSL_VERIFYHOST => false, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_TIMEOUT => 15];

        if ($headers) {
            $options[CURLOPT_HTTPHEADER] = $headers;
        }

        if ($params) {
            $options[CURLOPT_POSTFIELDS] = $params;
        }

        $auth = $this->getBasicAuth();

        if ($this->username) {
            $options[CURLOPT_USERPWD] = $auth;
        }

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        return new Response($response, $status);
    }
}