<?php

namespace Wookieb\Map\TypeGuard;
use Wookieb\Assert\Assert;

/**
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
class TypeGuard implements TypeGuardInterface
{
    private $type;
    private $typeClass;
    private static $typeAliases = array(
        'bool' => 'boolean',
        'obj' => 'object',
        'int' => 'integer',
        'float' => 'double',
        'null' => 'NULL'
    );

    private static $allowedTypes = array(
        'boolean', 'integer', 'double', 'string', 'array', 'object', 'resource', 'NULL'
    );

    public function __construct($typeName, $typeClass = null)
    {
        $this->setType($typeName);
        if ($this->type === 'object') {
            Assert::notBlank($typeClass, 'Class name cannot be empty');
            $this->typeClass = $typeClass;
        }
    }

    private function setType($type)
    {
        $type = strtolower($type);
        if (isset(self::$typeAliases[$type])) {
            $type = self::$typeAliases[$type];
        }
        if (!in_array($type, self::$allowedTypes)) {
            throw new \InvalidArgumentException('Unsupported type "'.$type.'"');
        }
        $this->type = $type;
    }

    public static function createFromExampleValue($exampleValue)
    {
        $type = gettype($exampleValue);
        return new TypeGuard($type, $type === 'object' ? get_class($exampleValue) : null);
    }

    /**
     * Checks whether the value has correct type
     *
     * @param mixed $value
     * @return boolean
     */
    public function isValid($value)
    {
        $type = gettype($value);
        return ($this->type !== 'object' && $this->type === $type) ||
        ($this->type === 'object' && is_object($value) && $value instanceof $this->typeClass);
    }

    /**
     * Returns string that describes what kind of types are allowed
     *
     * @return string
     */
    public function getAllowedTypeString()
    {
        if ($this->type !== 'object') {
            return $this->type.'s';
        }
        return 'objects of class '.$this->typeClass;
    }


}
