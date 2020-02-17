<?php

namespace App\Core\Data;

use \App\Core\Exceptions\ModelException;
use \App\Core\Data\QueryBuilder;

abstract class Model
{
    static protected $_name;
    static protected $_plurify = true;
    static protected $_lowercase = true;
    static protected $_kebabize = true;

    private static function table()
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

    private static function pk()
    {
        return get_called_class()::$_pk ?? 'id';
    }

    static function __callStatic($name, $args)
    {
        $words = array_map('strtolower', splitByUpperCase($name));

        if (count($words) >= 1) {
            $action = $words[0];
            if ($action == "find" && $words[1] == "by") {
                $value = $args[0] ?? null;
                $prop = $words[2] ?? "id";
                return self::find($prop, $value);
            } else if ($action == "where") {
                $prop = $words[1];
                $operator = isset($words[2]) && $words[2] == "not" ? false : true;
                $value = $args[0];
                return self::where($prop, $operator, $value);
            } else if ($action == "edit") {
                $pk = $args[0];
                $prop = $words[1];
                $value = $args[1];
                return self::edit($pk, [$prop => $value]);
            } else {
                throw new ModelException("Call to undefined method");
            }
        }
    }

    static function find($prop, $value = null)
    {
        $table = self::table();

        if ($value == null) {
            $value = $prop;
            $prop = self::pk();
        }

        $qb = new QueryBuilder($table);

        $result = $qb->select()
            ->where($prop, "=", $value)
            ->take(1)
            ->setFetchMode(\PDO::FETCH_CLASS, get_called_class())
            ->fetch() ?? null;

        return $result != null ? $result[0] : null;
    }

    static function all()
    {
        $table = self::table();

        $qb = new QueryBuilder($table);

        $result = $qb->select()
            ->setFetchMode(\PDO::FETCH_CLASS, get_called_class());

        return $result;
    }

    static function where($prop, $operator = "=", $value = null)
    {
        $table = self::table();

        $qb = new QueryBuilder($table);

        $result = $qb->select()
            ->setFetchMode(\PDO::FETCH_CLASS, get_called_class())
            ->where($prop, $operator, $value);

        return $result;
    }

    function create()
    {
        $table = get_class($this)::table();

        $qb = new QueryBuilder($table);

        $result = $qb->insert($this)->run();

        return $result;
    }

    function edit()
    {
        $pk = get_class($this)::pk();
        $table = get_class($this)::table();

        $qb = new QueryBuilder($table);

        $result = $qb->update($this)
            ->where($pk, "=", $this->$pk)
            ->run();

        return $result;
    }

    function delete()
    {
        $pk = get_class($this)::pk();
        $table = get_class($this)::table();

        $qb = new QueryBuilder($table);

        $result = $qb->delete()
            ->where($pk, "=", $this->$pk)
            ->run();

        return $result;
    }
}

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
