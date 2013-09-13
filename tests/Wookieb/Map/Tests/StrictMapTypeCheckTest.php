<?php

namespace Wookieb\Map\Tests;

use Wookieb\Map\StrictMap;
use Wookieb\Map\StrictMapTypeCheck;
use Wookieb\TypeCheck\TypeCheck;

class StrictMapTypeCheckTest extends MapUnit
{
    /**
     * @var StrictMapTypeCheck
     */
    private $object;

    protected function setUp()
    {
        $this->object = new StrictMapTypeCheck(TypeCheck::strings(), TypeCheck::integers());
    }

    public function isValidTypeProvider()
    {
        $string = TypeCheck::strings();
        $integer = TypeCheck::integers();

        $fakeMap = new \stdClass();
        $fakeMap->key = 1;
        return array(
            'not a map' => array($fakeMap, false),
            'array' => array(array('foo' => 1), false),
            'map string -> string' => array(new StrictMap($string, $string), false),
            'map integer -> integer' => array(new StrictMap($integer, $integer), false),
            'map string -> integer' => array(new StrictMap($string, $integer), true)
        );
    }

    /**
     * @dataProvider isValidTypeProvider
     */
    public function testIsValidType($map, $result)
    {
        $this->assertSame($result, $this->object->isValidType($map));
    }

    public function testGetTypeDescription()
    {
        $this->assertSame('strict maps of strings -> integers', $this->object->getTypeDescription());
    }
}
