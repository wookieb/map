<?php

namespace Wookieb\Map;
use Wookieb\Map\Exception\InvalidKeyTypeException;
use Wookieb\Map\Exception\InvalidValueTypeException;
use Wookieb\TypeCheck\TypeCheck;
use Wookieb\TypeCheck\TypeCheckInterface;

/**
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
class StrictMap extends Map
{
    /**
     * @var TypeCheckInterface
     */
    private $keyType;
    /**
     * @var TypeCheckInterface
     */
    private $valueType;

    public function __construct(TypeCheckInterface $keyType, TypeCheckInterface $valueType, $useMapEntries = null)
    {
        $this->keyType = $keyType;
        $this->valueType = $valueType;
        parent::__construct($useMapEntries);
    }

    public function add($key, $value)
    {
        if (!$this->keyType->isValidType($key)) {
            $msg = $this->createExceptionMessage('Invalid key type. ', $this->keyType);
            throw new InvalidKeyTypeException($msg, $key);
        }
        if (!$this->valueType->isValidType($value)) {
            $msg = $this->createExceptionMessage('Invalid value type. ', $this->valueType);
            throw new InvalidValueTypeException($msg, $value);
        }
        parent::add($key, $value);
    }

    private function createExceptionMessage($prefix, TypeCheckInterface $typeCheck)
    {
        return $prefix.'Allowed types of data: '.$typeCheck->getTypeDescription();
    }

    /**
     * Checks whether given value is a valid map key
     *
     * @param mixed $key
     * @return boolean
     */
    public function isValidKey($key)
    {
        return $this->keyType->isValidType($key);
    }

    /**
     * Checks whether given value is a valid map value
     *
     * @param mixed $value
     * @return boolean
     */
    public function isValidValue($value)
    {
        return $this->valueType->isValidType($value);
    }

    /**
     * @return TypeCheckInterface
     */
    public function getKeyType()
    {
        return $this->keyType;
    }

    /**
     * @return TypeCheckInterface
     */
    public function getValueType()
    {
        return $this->valueType;
    }
} 
