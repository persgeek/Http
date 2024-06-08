<?php

namespace PG\Http\Tools;

use Exception;

class Translator
{
    protected $fields;

    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    public function translate($content)
    {
        $this->ensureItsNotArray($content);

        foreach ($this->fields as $name => $value) {

            $this->ensureItsNotArray($value);

            $content = $this->replace($name, $value, $content);
        }

        return $content;
    }

    public function ensureItsNotArray($value)
    {
        $isArray = is_array($value);

        if ($isArray) {
            throw new Exception('The value could not be array');
        }
    }

    public function replace($name, $value, $content)
    {
        $pattern = "/@{$name}/is";

        $content = preg_replace($pattern, $value, $content);

        return $content;
    }
}