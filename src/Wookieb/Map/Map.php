<?php

namespace Wookieb\Map;

use Wookieb\Map\Exception\EntryNotFoundException;

/**
 * Standard map implementation where you can store everything you want
 *
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
class Map implements MapInterface
{
    protected $lastStorageKey;
    protected $storage = array();
    protected $useMapEntries = true;
    private $keyIndex = 0;
    protected $counter = 0;

    public function __construct($useMapEntries = null)
    {
        $isPHP55 = version_compare(PHP_VERSION, '5.5', '>=');
        if ($useMapEntries === null) {
            $useMapEntries = $isPHP55 ? false : true;
        }
        if (!$useMapEntries && !$isPHP55) {
            $msg = 'You cannot iterate through the map without using map entries since current PHP version '.
                'does not support non-scalar keys for iterator.';
            throw new \BadMethodCallException($msg);
        }
        $this->useMapEntries = $useMapEntries;
    }

    protected function createEntryNotFoundException($key)
    {
        $msg = 'Entry not found';
        if (is_scalar($key)) {
            $msg .= vsprintf(' for key "(%s) %s"', array(
                gettype($key),
                var_export($key, true)
            ));
        }
        return new EntryNotFoundException($msg, $key);
    }

    /**
     * Returns current entry value
     *
     * @return mixed|MapEntry MapEntry will be used only for php >= 5.5
     */
    public function current()
    {
        $current = current($this->storage);
        if ($this->useMapEntries) {
            return new MapEntry($current[0], $current[1]);
        }
        return $current[1];
    }

    /**
     * {@inheritDoc}
     */
    public function next()
    {
        next($this->storage);
        $this->keyIndex++;
    }

    /**
     * @return mixed|void
     */
    public function key()
    {
        if ($this->useMapEntries) {
            return $this->keyIndex;
        }
        $current = current($this->storage);
        return $current[0];
    }

    /**
     * {@inheritDoc}
     */
    public function valid()
    {
        return current($this->storage) !== false;
    }

    /**
     * {@inheritDoc}
     */
    public function rewind()
    {
        reset($this->storage);
        $this->keyIndex = 0;
    }

    /**
     * {@inheritDoc}
     */
    public function search($value, $strict = false)
    {
        foreach ($this->storage as &$storageValue) {
            if ($strict) {
                if ($value === $storageValue[1]) {
                    return $storageValue[0];
                }
            } else if ($value == $storageValue[1]) {
                return $storageValue[0];
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function get($key)
    {
        if (!$this->has($key)) {
            throw $this->createEntryNotFoundException($key);
        }
        return $this->storage[$this->lastStorageKey][1];
    }

    /**
     * {@inheritDoc}
     */
    public function remove($key)
    {
        if (!$this->has($key)) {
            throw $this->createEntryNotFoundException($key);
        }
        unset($this->storage[$this->lastStorageKey]);
        $this->counter--;
    }

    /**
     * {@inheritDoc}
     */
    public function isEmpty()
    {
        return $this->counter === 0;
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return $this->counter;
    }

    /**
     * {@inheritDoc}
     */
    public function has($key)
    {
        $storageKey = $this->computeStorageKey($key);
        $this->lastStorageKey = $storageKey;
        return isset($this->storage[$storageKey]);
    }

    protected function computeStorageKey($key)
    {
        if (is_object($key)) {
            return spl_object_hash($key);
        } else if (is_array($key)) {
            return md5(serialize($key));
        }
        return gettype($key).$key;
    }

    /**
     * {@inheritDoc}
     */
    public function add($key, $value)
    {
        $storageKey = $this->computeStorageKey($key);
        $this->storage[$storageKey] = array($key, $value);
        $this->counter++;
    }

    /**
     * {@inheritDoc}
     */
    public function isUsingMapEntries()
    {
        return $this->useMapEntries;
    }
} 
