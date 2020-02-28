<?php

namespace App\Core\Data;

use App\Core\Exceptions\AppException;

use function App\Core\Utils\startsWith;

define("SPACE", " ");

class QueryBuilder
{
    private $table;
    private $sentence;
    private $values;
    private $conditions;
    private $limit;
    private $offset;
    private $groupCol;
    private $orderCol;
    private $orderDir;
    private $fetchMode;
    private $fetchParam;

    function __construct($table)
    {
        $this->table = $table;
        $this->values = array();
        $this->conditions = array();
        $this->limit = -1;
        $this->offset = 0;
    }

    private function data()
    {
        return DataAccess::getInstance();
    }

    function select($selection = "*")
    {
        $this->sentence = ("SELECT" . SPACE . $selection . SPACE . "FROM" . SPACE . $this->table);

        return $this;
    }

    function insert($data)
    {
        $vars = array_filter(get_object_vars((object) $data), function ($value) {
            return $value != null;
        }, ARRAY_FILTER_USE_BOTH);

        $keys = array_keys($vars);
        $values = array_values($vars);

        $tokens = implode(", ", array_map(function () {
            return "?";
        }, $keys));

        $queryString = "INSERT INTO" . SPACE . $this->table . SPACE . "(" . implode(", ", array_map(function ($key) {
            return "`" . $key . "`";
        }, $keys)) . ") VALUES (" . $tokens . ")";

        foreach ($values as $value) {
            array_push($this->values, $value);
        }

        $this->sentence = $queryString;

        return $this;
    }

    function update($data)
    {
        $vars = array_filter(get_object_vars((object) $data), function ($value) {
            return $value != null;
        }, ARRAY_FILTER_USE_BOTH);

        $keys = array_keys($vars);
        $values = array_values($vars);
        $tokens = implode(", ", array_map(function ($key) {
            return "`" . $key . "`" . SPACE . "=" . SPACE . "?";
        }, $keys));

        $queryString = "UPDATE" . SPACE . $this->table . SPACE . "SET" . SPACE . $tokens;

        foreach ($values as $value) {
            array_push($this->values, $value);
        }

        $this->sentence = $queryString;

        return $this;
    }

    function delete()
    {
        $this->sentence = "DELETE FROM" . SPACE . $this->table;

        return $this;
    }

    function where($prop, $operator = "=", $value = null)
    {
        if (is_array($value)) {
            $tokens = implode(", ", array_map(function ($item) {
                return "?";
            }, $value));
            $condition = "`$prop`" . SPACE . ($operator == false ? "NOT IN" : "IN") . SPACE . "(" . $tokens . ")";
            foreach ($value as $v) {
                array_push($this->values, $v);
            }
        } else if (is_string($value)) {
            $condition = "`$prop`" . SPACE . ($operator == false ? "NOT LIKE" : "LIKE") . SPACE . "?";
            array_push($this->values, "%" .  $value . "%");
        } else if ($value == null) {
            $condition = "`$prop`" . SPACE . ($operator == false ? "IS NOT" : "IS") . SPACE . "NULL";
        } else {
            if (in_array($operator, ["=", "!=", "<>", "<", ">", "<=", ">="])) {
                $condition = "`$prop`" . SPACE . $operator . SPACE . "?";
                array_push($this->values, $value);
            } else {
                throw new AppException("Invalid operator in 'where' static method");
            }
        }

        array_push($this->conditions, $condition);

        return $this;
    }

    function or($prop, $operator = "=", $value = null)
    {
        if (count($this->conditions) == 0) throw new AppException("There must exist a previous condition in order to add an OR clause");

        if (is_array($value)) {
            $tokens = implode(", ", array_map(function ($item) {
                return "?";
            }, $value));
            $condition = "`$prop`" . SPACE . ($operator == false ? "NOT IN" : "IN") . SPACE . "(" . $tokens . ")";
            foreach ($value as $v) {
                array_push($this->values, $v);
            }
        } else if (is_string($value)) {
            $condition = "`$prop`" . SPACE . ($operator == false ? "NOT LIKE" : "LIKE") . SPACE . "?";
            array_push($this->values, "%" .  $value . "%");
        } else if ($value == null) {
            $condition = "`$prop`" . SPACE . ($operator == false ? "IS NOT" : "IS") . SPACE . "NULL";
        } else {
            if (in_array($operator, ["=", "!=", "<>", "<", ">", "<=", ">="])) {
                $condition = "`$prop`" . SPACE . $operator . SPACE . "?";
                array_push($this->values, $value);
            } else {
                throw new AppException("Invalid operator in 'where' static method");
            }
        }

        $this->conditions[count($this->conditions) - 1] .= (SPACE . "OR" . SPACE . $condition);

        return $this;
    }

    function take(int $amount)
    {
        $this->limit = $amount;

        return $this;
    }

    function skip(int $amount)
    {
        $this->offset = $amount;

        return $this;
    }

    function groupBy(string $prop)
    {
        if (strpos($prop, ' ') !== false) {
            throw new AppException("Invalid order property");
        }

        $this->groupCol = "`$prop`";

        return $this;
    }

    function orderBy(string $prop, $direction = "ASC")
    {
        if (strpos($prop, ' ') !== false) {
            throw new AppException("Invalid order property");
        }

        $this->orderCol = "`$prop`";
        $this->orderDir = $direction;

        return $this;
    }

    function sum($col)
    {
        return $this->select("SUM(" . $col . ")");
    }

    function count($col = "*")
    {
        return $this->select("COUNT(" . $col . ")");
    }

    function setFetchMode($fetchMode, $fetchParam)
    {
        $this->fetchMode = $fetchMode;
        $this->fetchParam = $fetchParam;

        return $this;
    }

    function fetch()
    {
        $queryString = $this->buildQuery();
        $query = $this->data()->prepare($queryString);
        $query->execute($this->values);
        $this->reset();
        return $query->fetchAll($this->fetchMode, $this->fetchParam);
    }

    function run()
    {
        $queryString = $this->buildQuery();
        $query = $this->data()->prepare($queryString);
        $query->execute($this->values);
        $this->reset();

        return $query->rowCount() > 0 ? true : false;
    }

    private function buildQuery()
    {
        $queryString = empty($this->sentence) ? $this->select()->sentence : $this->sentence;

        if (count($this->conditions) > 0) {
            $queryString .= SPACE;
            $queryString .= "WHERE" . SPACE . implode(SPACE . "AND" . SPACE, $this->conditions);
        } else {
            if (startsWith($queryString, "UPDATE")) throw new AppException("You are running an UPDATE operation without a WHERE clause, please consider rechecking your code");
            if (startsWith($queryString, "DELETE")) throw new AppException("You are running a DELETE operation without a WHERE clause, please consider rechecking your code");
        }

        if (isset($this->groupCol)) {
            $queryString .= SPACE;
            $queryString .= "GROUP BY" . SPACE . $this->groupCol;
        }

        if (isset($this->orderCol)) {
            $queryString .= SPACE;
            $queryString .= "ORDER BY" . SPACE . $this->orderCol . ($this->orderDir == "DESC" ? SPACE . $this->orderDir : "");
        }

        if ($this->limit > -1) {
            $queryString .= SPACE;
            $queryString .= "LIMIT" . SPACE . $this->limit;
        }

        if ($this->offset > 0) {
            $queryString .= SPACE;
            $queryString .= "OFFSET" . SPACE . $this->offset;
        }

        return $queryString;
    }

    private function reset()
    {
        $this->sentence = "";
        $this->conditions = array();
        $this->values = array();
        $this->orderCol = "";
        $this->orderDir = "ASC";
        $this->limit = -1;
        $this->offset = 0;
    }
}
