<?php

namespace Wookieb\Map;
use Wookieb\Map\Exception\InvalidKeyTypeException;
use Wookieb\Map\Exception\InvalidValueTypeException;
use Wookieb\Map\TypeGuard\TypeGuardInterface;
use Wookieb\Map\TypeGuard\TypeGuard;

/**
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
class StrictMap extends Map
{
    /**
     * @var TypeGuardInterface
     */
    private $keyType;
    /**
     * @var TypeGuardInterface
     */
    private $valueType;

    public function __construct(TypeGuardInterface $keyType, TypeGuardInterface $valueType, $useMapEntries = null)
    {
        $this->keyType = $keyType;
        $this->valueType = $valueType;
        parent::__construct($useMapEntries);
    }

    public function add($key, $value)
    {
        if (!$this->keyType->isValid($key)) {
            $msg = $this->createExceptionMessage('Invalid key type. ', $this->keyType);
            throw new InvalidKeyTypeException($msg, $key);
        }
        if (!$this->valueType->isValid($value)) {
            $msg = $this->createExceptionMessage('Invalid value type. ', $this->valueType);
            throw new InvalidValueTypeException($msg, $value);
        }
        parent::add($key, $value);
    }

    private function createExceptionMessage($prefix, TypeGuardInterface $guard)
    {
        return $prefix.'Allowed types of data: '.$guard->getAllowedTypeString();
    }

    /**
     * Checks whether given value is a valid map key
     *
     * @param mixed $key
     * @return boolean
     */
    public function isValidKey($key)
    {
        return $this->keyType->isValid($key);
    }

    /**
     * Checks whether given value is a valid map value
     *
     * @param mixed $value
     * @return boolean
     */
    public function isValidValue($value)
    {
        return $this->valueType->isValid($value);
    }

    /**
     * @return TypeGuardInterface
     */
    public function getKeyType()
    {
        return $this->keyType;
    }

    /**
     * @return TypeGuardInterface
     */
    public function getValueType()
    {
        return $this->valueType;
    }
} 
