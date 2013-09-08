<?php

namespace Wookieb\Map\Tests;

use Wookieb\Map\MapEntry;

class MapEntryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MapEntry
     */
    private $object;

    protected function setUp()
    {
        $this->object = new MapEntry('key', 'value');
    }

    public function testGetKey()
    {
        $this->assertEquals('key', $this->object->getKey());
    }

    public function testGetValue()
    {
        $this->assertEquals('value', $this->object->getValue());
    }

    public function testGet()
    {
        $this->assertEquals(array('key', 'value'), $this->object->get());
    }
}
