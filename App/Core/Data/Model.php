<?php

namespace App\Core\Data;

use \App\Core\Exceptions\ModelException;
use \App\Core\Data\QueryBuilder;

use function App\Core\Utils\getLastItem;
use function App\Core\Utils\kebabize;
use function App\Core\Utils\plurify;
use function App\Core\Utils\splitByUpperCase;

abstract class Model
{
    private static function get_table()
    {
        $calledClass = get_called_class();

        if (isset($calledClass::$table))
            return $calledClass::$table;
        else {
            $name = getLastItem(explode("\\", $calledClass));

            $kebabize = $calledClass::$kebabize ?? true;
            $lowercase = $calledClass::$lowercase ?? true;
            $plurify = $calledClass::$plurify ?? true;

            if ($kebabize) $name = kebabize($name);
            if ($lowercase) $name = strtolower($name);
            if ($plurify) $name = plurify($name);

            return $name;
        }
    }

    private static function get_pk()
    {
        return get_called_class()::$pk ?? 'id';
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
        $table = self::get_table();

        if ($value == null) {
            $value = $prop;
            $prop = self::get_pk();
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
        $table = self::get_table();

        $qb = new QueryBuilder($table);

        $result = $qb->setFetchMode(\PDO::FETCH_CLASS, get_called_class());

        return $result;
    }

    static function count($col = "*")
    {
        $table = self::get_table();

        $qb = new QueryBuilder($table);

        $result = $qb->count($col)
            ->setFetchMode(\PDO::FETCH_COLUMN, null)
            ->fetch();

        return $result[0];
    }

    static function where($prop, $operator = "=", $value = null)
    {
        $result = self::all()->where($prop, $operator, $value);

        return $result;
    }

    function create()
    {
        $table = get_class($this)::get_table();

        $qb = new QueryBuilder($table);

        $result = $qb->insert($this)->run();

        return $result;
    }

    function edit()
    {
        $pk = get_class($this)::get_pk();
        $table = get_class($this)::get_table();

        $qb = new QueryBuilder($table);

        $result = $qb->update($this)
            ->where($pk, "=", $this->$pk)
            ->run();

        return $result;
    }

    function delete()
    {
        $pk = get_class($this)::get_pk();
        $table = get_class($this)::get_table();

        $qb = new QueryBuilder($table);

        $result = $qb->delete()
            ->where($pk, "=", $this->$pk)
            ->run();

        return $result;
    }
}
