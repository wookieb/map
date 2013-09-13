<?php

namespace Wookieb\Map;
use Wookieb\TypeCheck\TypeCheckInterface;

/**
 * Accepts only strict maps that have same key and value type checks
 *
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
class StrictMapTypeCheck implements TypeCheckInterface
{
    private $keyTypeCheck;
    private $valueTypeCheck;

    public function __construct(TypeCheckInterface $keyTypeCheck, TypeCheckInterface $valueTypeCheck)
    {
        $this->keyTypeCheck = $keyTypeCheck;
        $this->valueTypeCheck = $valueTypeCheck;
    }

    /**
     * {@inheritDoc}
     */
    public function isValidType($data)
    {
        return $data instanceof StrictMap &&
        $data->getKeyTypeCheck() == $this->keyTypeCheck &&
        $data->getValueTypeCheck() == $this->valueTypeCheck;
    }

    /**
     * {@inheritDoc}
     */
    public function getTypeDescription()
    {
        return vsprintf('strict maps of %s -> %s', array(
            $this->keyTypeCheck->getTypeDescription(),
            $this->valueTypeCheck->getTypeDescription()
        ));
    }
} 
