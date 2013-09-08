<?php

namespace Wookieb\Map\Exception;

/**
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
class InvalidValueTypeException extends MapException
{
    private $value;

    /**
     * @param string $message
     * @param mixed $value
     * @param \Exception $previous
     */
    public function __construct($message, $value, \Exception $previous = null)
    {
        parent::__construct($message, null, $previous);
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
} 
