<?php

namespace Wookieb\Map\Tests;

/**
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
class MapUnit extends \PHPUnit_Framework_TestCase
{

    public function skipIfNonScalarKeysNotSupported()
    {
        if (!$this->isScalarKeysSupported()) {
            $this->markTestSkipped('Non-scalar keys not supported');
        }
    }

    public function skipIfNonScalarKeysSupported()
    {
        if ($this->isScalarKeysSupported()) {
            $this->markTestSkipped('Non-scalar keys supported');
        }
    }

    public function isScalarKeysSupported()
    {
        return version_compare(PHP_VERSION, '5.5', '>=');
    }
}
