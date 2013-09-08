<?php


namespace Wookieb\Map\Tests\TypeGuard;


use Wookieb\Map\TypeGuard\AnyTypeGuard;

class AnyTypeGuardTest extends \PHPUnit_Framework_TestCase
{
    public function provider()
    {
        return array(
            'string' => array('string'),
            'integer' => array(1),
            'boolean' => array(true),
            'double' => array(1.1),
            'object' => array(new \stdClass()),
            'null' => array(null)
        );
    }

    /**
     * @dataProvider provider
     */
    public function testIsValidAcceptsAnyValue($value)
    {
        $object = new AnyTypeGuard();
        $this->assertTrue($object->isValid($value));
    }

    public function testTypesNames()
    {
        $object = new AnyTypeGuard();
        $this->assertSame('any', $object->getTypeName());
        $this->assertSame('any', $object->getTypeClass());
    }
}
