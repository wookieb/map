<?php

namespace Wookieb\Map\Exception;

/**
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
abstract class KeyAwareException extends MapException
{
    private $key;

    /**
     * @param string $message
     * @param mixed $key
     * @param \Exception $previous
     */
    public function __construct($message, $key, \Exception $previous = null)
    {
        parent::__construct($message, null, $previous);
        $this->key = $key;
    }

    public function getKey()
    {
        return $this->key;
    }
} 
