<?php

namespace Wookieb\Map\Tests\TypeGuard;


use Wookieb\Map\TypeGuard\TypeGuard;
use Wookieb\Map\TypeGuard\TypeGuardInterface;

class TypeGuardTest extends \PHPUnit_Framework_TestCase
{

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
    public function testIsValid($validValue, TypeGuardInterface $typeGuard, $invalidValue)
    {
        $this->assertTrue($typeGuard->isValid($validValue));
        $this->assertFalse($typeGuard->isValid($invalidValue));
    }

    public function getAllowedTypesStringProvider()
    {
        return array(
            'strings' => array(new TypeGuard('string'), 'strings'),
            'integers' => array(new TypeGuard('int'), 'integers'),
            'doubles' => array(new TypeGuard('double'), 'doubles'),
            'booleans' => array(new TypeGuard('boolean'), 'booleans'),
            'objects' => array(new TypeGuard('object', 'stdClass'), 'objects of class stdClass')
        );
    }

    /**
     * @dataProvider getAllowedTypesStringProvider
     */
    public function testGetAllowedTypesString(TypeGuardInterface $guard, $expected)
    {
        $this->assertSame($expected, $guard->getAllowedTypeString());
    }
}
