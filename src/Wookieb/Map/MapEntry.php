<?php

namespace Wookieb\Map;

/**
 * Map entry for iteration purposes
 *
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
class MapEntry
{
    private $key;
    private $value;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function get()
    {
        return array($this->key, $this->value);
    }
} 
