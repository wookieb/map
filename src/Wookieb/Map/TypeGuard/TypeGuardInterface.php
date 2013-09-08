<?php

namespace Wookieb\Map\TypeGuard;

/**
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
interface TypeGuardInterface
{
    /**
     * Checks whether given value has correct type
     *
     * @param mixed $value
     * @return boolean
     */
    function isValid($value);

    /**
     * Returns string that describes what kind of types are allowed
     *
     * @return string
     */
    function getAllowedTypeString();
} 
