<?php

namespace Wookieb\Map\Tests;

use Wookieb\Map\Exception\InvalidValueTypeException;
use Wookieb\Map\StrictMap;
use Wookieb\Map\TypeGuard\TypeGuard;
use Wookieb\Map\Exception\InvalidKeyTypeException;

class StrictMapTest extends CommonMapTests
{
    /**
     * @var StrictMap
     */
    protected $object;

    protected function setUp()
    {
        $this->object = new StrictMap(new TypeGuard('string'), new TypeGuard('string'));
    }

    public function testIsValidKey()
    {
        $this->assertTrue($this->object->isValidKey('key'));
        $this->assertFalse($this->object->isValidKey(true));
    }

    public function testIsValidValue()
    {
        $this->assertTrue($this->object->isValidValue('string'));
        $this->assertFalse($this->object->isValidValue(true));
    }

    public function testAdd()
    {
        $this->object->add('knowledgeable', 'insurance');
        $this->object->add('vicious', 'doubt');

        $this->assertSame('insurance', $this->object->get('knowledgeable'));
        $this->assertSame('doubt', $this->object->get('vicious'));
    }

    public function testExceptionWhenAttemptToAddEntryWithInvalidKeyType()
    {
        $msg = 'Invalid key type. Allowed types of data: strings';
        $this->setExpectedException('Wookieb\Map\Exception\InvalidKeyTypeException', $msg);
        try {
            $this->object->add(1, 'tip');
        } catch (InvalidKeyTypeException $e) {
            $this->assertSame(1, $e->getKey());
            throw $e;
        }
    }

    public function testExceptionWhenAttemptToAddEntryWithInvalidValueType()
    {
        $msg = 'Invalid value type. Allowed types of data: strings';
        $this->setExpectedException('Wookieb\Map\Exception\InvalidValueTypeException', $msg);
        try {
            $this->object->add('tip', 1);
        } catch (InvalidValueTypeException $e) {
            $this->assertSame(1, $e->getValue());
            throw $e;
        }
    }

    public function testStrictSearch()
    {
        $this->object = new StrictMap(new TypeGuard('string'), new TypeGuard('object', 'stdClass'));
        parent::testStrictSearch();
    }

    public function testGetKeyType()
    {
        $expected = new TypeGuard('string');
        $this->assertEquals($expected, $this->object->getKeyType());
    }

    public function testGetValueType()
    {
        $expected = new TypeGuard('string');
        $this->assertEquals($expected, $this->object->getValueType());
    }
}
