<?php

namespace App\Core\Data;

use \App\Core\Exceptions\ModelException;

define("SPACE", " ");

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
function endsWithAnyOf($haystack, $needles)
{
    foreach ($needles as $needle) {
        endsWith($haystack, $needle);
    }
}
function parseParameter($args)
{
    return is_string($args) ? "'%" . $args . "%'" : (is_array($args) ? "(" . implode(",", $args) . ")" : $args);
}
function getOperator($args)
{
    $operator = is_string($args) ? "LIKE" : (is_array($args) ? "IN" : "=");

    if (startsWith($args, "!")) {
        $operator = $operator == "=" ? "!=" : "NOT" . SPACE . $operator;
    }

    return $operator;
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

abstract class Model
{
    static protected $_name;
    static protected $_plurify = true;
    static protected $_lowercase = true;
    static protected $_kebabize = true;

    private static function access()
    {
        return DataAccess::getInstance();
    }

    private static function getTableName()
    {
        $calledClass = get_called_class();
        $name = $calledClass::$_table ?? getLastItem(explode("\\", $calledClass));
        $kebabize = $calledClass::$_kebabize ?? true;
        $lowercase = $calledClass::$_lowercase ?? true;
        $plurify = $calledClass::$_plurify ?? true;

        if ($lowercase) {
            $name = strtolower($name);
        }

        if ($plurify) {
            $name = plurify($name);
        }

        if ($kebabize) {
            $name = implode("_", splitByUpperCase($name));
        }

        return $name;
    }

    private static function getPrimaryKey()
    {
        return get_called_class()::$_pk ?? 'id';
    }

    static function __callStatic($name, $args)
    {
        $words = array_map('strtolower', splitByUpperCase($name));

        if (count($words) >= 1) {
            $action = $words[0];
            if ($action == "find" && $words[1] == "by") {
                return self::find($args[0], $words[2]);
            } else if ($action == "where") {
                return self::where($words[1], $args[0]);
            } else if ($action == "edit") {
                return self::edit($args[0], [$words[1] => $args[1]]);
            } else {
                throw new ModelException("Call to undefined method");
            }
        }
    }

    static function find($args, $prop = null)
    {
        $prop = $prop ?? self::getPrimaryKey();
        $operator = getOperator($args);
        $args = parseParameter($args);
        $queryString = "SELECT * FROM" . SPACE . self::getTableName() . SPACE . "WHERE" . SPACE . $prop . SPACE . $operator . SPACE . $args . SPACE . "LIMIT 1";
        $query = self::access()->prepare($queryString);
        $query->execute();
        $query->setFetchMode(\PDO::FETCH_CLASS, get_called_class());
        return $query->fetch();
    }

    static function all()
    {
        $queryString = "SELECT * FROM" . SPACE . self::getTableName();
        $query = self::access()->prepare($queryString);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    static function where($prop, $args)
    {
        $args = parseParameter($args);
        $operator = getOperator($args);
        $queryString = "SELECT * FROM" . SPACE . self::getTableName() . SPACE . "WHERE" . SPACE . $prop . SPACE . $operator . SPACE . $args;
        $query = self::access()->prepare($queryString);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    static function paginate($filters = [], $limit = 9999, $offset = 0)
    {
        $vars = get_object_vars((object) $filters);
        $keys = implode(", ", array_keys($vars));
        $values = array_values($vars);
    }

    static function create($object)
    {
        try {
            $vars = array_filter(get_object_vars((object) $object), function ($value) {
                return $value != null;
            }, ARRAY_FILTER_USE_BOTH);
            $keys = implode(", ", array_keys($vars));
            $values = array_values($vars);
            $placeholders = implode(", ", array_map(function () {
                return "?";
            }, $values));
            $queryString = "INSERT INTO" . SPACE . self::getTableName() . SPACE . "(" . $keys . ") VALUES (" . $placeholders . ")";
            $query = self::access()->prepare($queryString);
            return $query->execute($values);
        } catch (\Exception $e) {
            throw new ModelException("Invalid model object at method create.", 666, $e);
        }
    }

    static function edit($id, $object)
    {
        try {
            $pk = self::getPrimaryKey();
            $vars = array_filter(get_object_vars((object) $object), function ($value) {
                return $value != null;
            }, ARRAY_FILTER_USE_BOTH);
            $keys = array_keys($vars);
            $values = array_values($vars);
            $placeholders = implode(", ", array_map(function ($key) {
                return $key . SPACE . "= ?";
            }, $keys));
            $queryString = "UPDATE" . SPACE . self::getTableName() . SPACE . "SET" . SPACE . $placeholders . SPACE . "WHERE" . SPACE . $pk . "=" . $id;
            $query = self::access()->prepare($queryString);
            return $query->execute($values);
        } catch (\Exception $e) {
            //throw new ModelException("Invalid model object at method create.", 666, $e);
            throw $e;
        }
    }

    static function delete($id)
    {
        $pk = self::getPrimaryKey();
        $queryString = "DELETE FROM" . SPACE . self::getTableName() . SPACE . "WHERE" . SPACE . $pk . "=" . $id;
        $query = self::access()->prepare($queryString);
        return $query->execute();
    }
}
