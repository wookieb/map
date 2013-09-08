<?php

namespace Wookieb\Map\TypeGuard;

/**
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
interface TypeGuardInterface
{
    function isValid($value);

    function getTypeName();

    function getTypeClass();
} 
