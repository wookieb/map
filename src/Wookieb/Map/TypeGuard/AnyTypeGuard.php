<?php

namespace Wookieb\Map\TypeGuard;

/**
 * Type guard that accepts every type of data
 *
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
class AnyTypeGuard implements TypeGuardInterface
{
    /**
     * {@inheritDoc}
     */
    public function isValid($value)
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function getAllowedTypeString()
    {
        return 'every type';
    }
} 
