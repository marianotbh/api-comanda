<?php

namespace App\Core\Utils;

function getLastItem($array)
{
    return array_values(array_slice($array, -1))[0];
}

function splitByUpperCase($camelCaseString)
{
    return preg_split('/(?<=[a-z])(?=[A-Z])/x', $camelCaseString);
}

function startsWith($haystack, $needle)
{
    return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
}

function endsWith($haystack, $needle)
{
    return substr_compare($haystack, $needle, -strlen($needle)) === 0;
}

function kebabize($string)
{
    return strtolower(implode("_", splitByUpperCase($string)));
}

function plurify($string)
{
    if (endsWith($string, "s")) {
        return $string . "es";
    } else if (endsWith($string, "y")) {
        return substr($string, 0, strlen($string) - 2) . "ies";
    } else {
        return $string . "s";
    }
}
