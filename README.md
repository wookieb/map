# Map
[![Build Status](https://travis-ci.org/wookieb/map.png?branch=master)](https://travis-ci.org/wookieb/map)
Implementation of map data type for PHP. Allows to use non-scalar keys like objects, arrays.

## Install

Via composer

```json
    "require": {
        "wookieb/map": "0.1"
    }
```

## Example

```php
use Wookieb\Map\Map;

$map = new Map();

$object = new stdClass();

$map->add(true, 'that\'s true');
$map->add($object, 'some object');
$map->add('key', 'value');

$map->get(true); // that's true
$map->get($object); // some object
$map->get('key'); // value
```

## Iteration

Since map may contains some non-scalar keys so iteration is different.
For php < 5.5 you will receive a MapEntry object instead of value of current element in iteration.
For php >= 5.5 iteration works normally.

```php

use Wookieb\Map\Map;

$map = new Map();
$map->add('yearly', 'ketchup');


// for php < 5.5
foreach ($map as $entry) {
    list($key, $value) = $entry->get();
    $key; // yearly
    $value; // ketchup
    // or
    $entry->getKey(); // yearly
    $entry->getValue(); // ketchup
}

// for php >= 5.5
foreach ($map as $key => $value) {
    $key; // yearly
    $value; // ketchup
}

// forcing map to use MapEntry objects
$map = new Map(true);
$map->add('yearly', 'ketchup');

// for every php version
foreach ($map as $entry) {
    list($key, $value) = $entry->get();
}
```

# Changelog
## 0.1.1
* added StrictMapTypeCheck
