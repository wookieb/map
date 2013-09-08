<?php

namespace Wookieb\Map\TypeGuard;

/**
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
class AnyTypeGuard implements TypeGuardInterface
{
    public function isValid($value)
    {
        return true;
    }

    function getTypeName()
    {
        return 'any';
    }

    function getTypeClass()
    {
        return 'any';
    }
} 
