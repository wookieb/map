<?php

namespace Wookieb\Map;

use Wookieb\Map\Exception\EntryNotFoundException;

/**
 * @author Łukasz Kużyński "wookieb" <lukasz.kuzynski@gmail.com>
 */
interface MapInterface extends \Iterator, \Countable
{
    /**
     * Returns value of entry for given key
     *
     * @param mixed $key
     * @return mixed
     * @throws EntryNotFoundException when entry with given key does not exists
     */
    function get($key);

    /**
     * Checks whether map contains entry with given key
     *
     * @param mixed $key
     * @return boolean
     */
    function has($key);

    /**
     * Adds new entry
     * Overrides previous value for given key if exists
     *
     * @param mixed $key
     * @param mixed $value
     */
    function add($key, $value);

    /**
     * Removes the entry for given key from the map
     *
     * @param mixed $key
     * @throws EntryNotFoundException when entry with given key does not exists
     */
    function remove($key);

    /**
     * Searches the array for a given value and returns the corresponding key
     *
     * @param mixed $value
     * @param boolean $strict match only identical elements
     * @return mixed null if value not found
     */
    function search($value, $strict = false);

    /**
     * Checks whether map is empty
     *
     * @return boolean
     */
    function isEmpty();

    /**
     * Informs if map is using map entries for iteration
     *
     * @return boolean
     */
    function isUsingMapEntries();
} 
