<?php

namespace Wookieb\Map\Tests\TypeGuard;


use Wookieb\Map\TypeGuard\TypeGuard;

class TypeGuardTest extends \PHPUnit_Framework_TestCase
{
    public function testGetTypeName()
    {
        $object = new TypeGuard('string');
        $this->assertSame('string', $object->getTypeName());
    }

    public function testSomeTypeNamesCouldBeAliased()
    {
        $object = new TypeGuard('int');
        $this->assertSame('integer', $object->getTypeName());

        $object = new TypeGuard('bool');
        $this->assertSame('boolean', $object->getTypeName());
    }

    public function testTypeNamesAreCaseInsensitive()
    {
        $object = new TypeGuard('StRiNg');
        $this->assertSame('string', $object->getTypeName());
    }

    public function testGetTypeClass()
    {
        $object = new TypeGuard('object', 'stdClass');
        $this->assertSame('object', $object->getTypeName());
        $this->assertSame('stdClass', $object->getTypeClass());

        $object = new TypeGuard('string');
        $this->assertNull($object->getTypeClass());
    }

    public function testCannotLeaveClassNameEmptyForObjectTypes()
    {
        $this->setExpectedException('\InvalidArgumentException', 'Class name cannot be empty');
        new TypeGuard('object');
    }

    public function testCannotLeaveClassNameBlankForObjectTypes()
    {
        $this->setExpectedException('\InvalidArgumentException', 'Class name cannot be empty');
        new TypeGuard('object', '');
    }

    public function testExceptionWhenTypeIsUnsupported()
    {
        $this->setExpectedException('\InvalidArgumentException', 'Unsupported type "duck"');
        new TypeGuard('duck');
    }

    public function commonProvider()
    {
        return array(
            'string' => array('string', new TypeGuard('string'), 1),
            'null' => array(null, new TypeGuard('null'), 'string'),
            'integer' => array(10, new TypeGuard('integer'), false),
            'boolean' => array(true, new TypeGuard('boolean'), 'string'),
            'double' => array(102.2, new TypeGuard('double'), 'int'),
            'object' => array(new \stdClass(), new TypeGuard('object', 'stdClass'), 123),
            'array' => array(range(1, 5), new TypeGuard('array'), 'string')
        );
    }

    /**
     * @dataProvider commonProvider
     */
    public function testCreateFromExampleValue($exampleValue, $expected)
    {
        $this->assertEquals($expected, TypeGuard::createFromExampleValue($exampleValue));
    }

    /**
     * @dataProvider commonProvider
     */
    public function testIsValid($validValue, TypeGuard $typeGuard, $invalidValue)
    {
        $this->assertTrue($typeGuard->isValid($validValue));
        $this->assertFalse($typeGuard->isValid($invalidValue));
    }
}
