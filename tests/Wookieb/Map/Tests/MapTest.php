<?php

namespace Wookieb\Map\Tests;

use Wookieb\Map\Exception\EntryNotFoundException;
use Wookieb\Map\Map;
use Wookieb\Map\MapEntry;

class MapTest extends CommonMapTests
{
    /**
     * @var Map
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new Map();
    }

    public function addProvider()
    {
        return array(
            'boolean true' => array(true),
            'boolean false' => array(false),
            'integer' => array(1),
            'float' => array(11.23),
            'object' => array(new \ArrayIterator(range(1, 2))),
            'string' => array('thing'),
            'arrays' => array(range(1, 4))
        );
    }

    /**
     * @dataProvider addProvider
     */
    public function testAdd($key)
    {
        $value = 'zigzag judge '.rand(1, 10000);
        $this->object->add($key, $value);
        $this->assertSame($value, $this->object->get($key));
    }

    /**
     * @depends testAdd
     */
    public function testDifferentKeyTypesCannotOverrideOtherOnes()
    {
        $this->object->add(1, 'integer');
        $this->object->add(true, 'boolean');
        $this->assertSame('boolean', $this->object->get(true));
        $this->assertSame('integer', $this->object->get(1));
    }

    public function testIterationWithoutMapEntries()
    {
        $this->skipIfNonScalarKeysNotSupported();

        $entries = array(
            array(new \ReflectionClass('Exception'), rand(1, 10)),
            array(true, rand(1, 10)),
            array(false, rand(1, 10)),
            array('string', rand(1, 10)),
            array(range(1, 10), rand(1, 10))
        );

        foreach ($entries as $entry) {
            $this->object->add($entry[0], $entry[1]);
        }

        $iterationCount = 0;
        reset($entries);
        foreach ($this->object as $key => $value) {
            $expectedPair = current($entries);
            $this->assertSame($expectedPair[0], $key, 'Invalid key');
            $this->assertSame($expectedPair[1], $value, 'Invalid value');
            next($entries);
            $iterationCount++;
        }

        $this->assertSame(5, $iterationCount, 'Map was not iterated');
    }

    public function testIterationWithMapEntries()
    {
        $entries = array(
            array(new \ReflectionClass('Exception'), rand(1, 10)),
            array(true, rand(1, 10)),
            array(false, rand(1, 10)),
            array('string', rand(1, 10)),
            array(range(1, 10), rand(1, 10))
        );

        $this->object = new Map(true);
        foreach ($entries as $entry) {
            $this->object->add($entry[0], $entry[1]);
        }

        $iterationCount = 0;
        reset($entries);
        foreach ($this->object as $key => $entry) {
            $expectedPair = current($entries);
            $this->assertSame($iterationCount, $key, 'Invalid key');
            $this->assertInstanceOf('Wookieb\Map\MapEntry', $entry);
            $this->assertSame($expectedPair[0], $entry->getKey(), 'Invalid entry key');
            $this->assertSame($expectedPair[1], $entry->getValue(), 'Invalid entry value');
            next($entries);
            $iterationCount++;
        }

        $this->assertSame(5, $iterationCount, 'Map was not iterated');
    }

    public function testMapEntriesCannotBeTurnedOffWhenNonScalarKeysAreNotSupported()
    {
        $this->skipIfNonScalarKeysSupported();
        $msg = 'You cannot iterate through the map without using map entries';
        $this->setExpectedException('\BadMethodCallException', $msg);
        new Map(false);
    }
}
