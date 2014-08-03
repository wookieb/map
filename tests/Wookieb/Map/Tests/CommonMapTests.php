<?php

namespace Wookieb\Map\Tests;
use Wookieb\Map\Exception\EntryNotFoundException;
use Wookieb\Map\MapInterface;

/**
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
abstract class CommonMapTests extends MapUnit
{
    /**
     * @var MapInterface
     */
    protected $object;

    public function entryNotFoundProvider()
    {
        return array(
            'for static keys' => array(
                'some key', 'Entry not found for key "(string) \'some key\'"'
            ),
            'for object keys' => array(
                new \ArrayIterator(range(1, 100)), 'Entry not found'
            )
        );
    }

    /**
     * @dataProvider entryNotFoundProvider
     */
    public function testGetThrowsExceptionWhenEntryForGivenKeyDoesNotExists($key, $msg)
    {
        $this->setExpectedException('Wookieb\Map\Exception\EntryNotFoundException', $msg);
        try {
            $this->object->get($key);
        } catch (EntryNotFoundException $e) {
            $this->assertSame($key, $e->getKey());
            throw $e;
        }
    }

    /**
     * @depends testAdd
     */
    public function testIsEmpty()
    {
        $this->assertTrue($this->object->isEmpty());
        $this->object->add('some', 'value');
        $this->assertFalse($this->object->isEmpty());
    }

    /**
     * @depends testAdd
     */
    public function testHas()
    {
        $key = 'mum';
        $this->assertFalse($this->object->has($key));
        $this->object->add($key, 'dad');
        $this->assertTrue($this->object->has($key));
    }

    /**
     * @depends testAdd
     * @depends testHas
     */
    public function testRemove()
    {
        $key = 'key';
        $this->object->add($key, 'value');
        $this->object->remove($key);
        $this->assertFalse($this->object->has($key));
    }

    public function testRemoveThrowsExceptionWhenEntryForGivenKeyDoesNotExists()
    {
        $this->setExpectedException('Wookieb\Map\Exception\EntryNotFoundException');
        $this->object->remove('key');
    }

    /**
     * @depends testAdd
     * @depends testRemove
     */
    public function testCount()
    {
        $this->assertCount(0, $this->object);

        $this->object->add('someKey', 'value');
        $this->assertCount(1, $this->object);

        $this->object->add('anotherKey', 'value');
        $this->assertCount(2, $this->object);

        $this->object->remove('someKey');
        $this->assertCount(1, $this->object);

        $this->object->remove('anotherKey');
        $this->assertCount(0, $this->object);
    }

    /**
     * @depends testAdd
     * @depends testRemove
     */
    public function testSearch()
    {
        $key = 'someKey';
        $value = 'someValue';
        $this->assertNull($this->object->search($value));
        $this->object->add($key, $value);
        $this->assertSame($key, $this->object->search($value));
    }

    /**
     * @depends testSearch
     */
    public function testStrictSearch()
    {
        $value = new \stdClass();
        $key = 'someKey';
        $this->object->add($key, $value);

        $this->assertNull($this->object->search(clone $value, true));
        $this->assertSame($key, $this->object->search($value, true));
    }
}
