<?php

namespace App\Core;

function kebabize($input)
{
    preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
    $ret = $matches[0];
    foreach ($ret as &$match) {
        $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
    }
    return implode('_', $ret);
}

class Mapper
{
    static function map($source, $target)
    {
        $instance = new $target;

        foreach (array_keys((array) $instance) as $key) {
            $instance->$key = $source[kebabize($key)] ?? null;
        }

        return $instance;
    }
}
