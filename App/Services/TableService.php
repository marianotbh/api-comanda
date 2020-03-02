<?php

namespace App\Services;

use App\Models\Table;
use App\Models\TableState;
use App\Core\Exceptions\AppException;

class TableService
{
    function list()
    {
        /** @var Table[] */
        $tables = Table::whereRemoved_at(null)
            ->orderBy("updated_at")
            ->take(10)
            ->fetch();

        return $tables;
    }

    function read($code)
    {
        /** @var Table */
        $table = Table::findByCode($code);

        return $table;
    }

    function create($model)
    {
        if (Table::find($model->code) != null) throw new AppException("Table code already exists");

        $table = new Table();

        $table->code = $model->code;
        $table->capacity = $model->capacity;
        $table->state = 0; // Available

        if (!$table->create()) throw new AppException("Table could not be created");

        return $table->code;
    }

    function update($code, $model)
    {
        /** @var Table */
        $table = Table::findByCode($code);

        if ($table == null) throw new AppException("Table not found");

        $table->capacity = $model->capacity;
        $table->state = $model->state;
        $table->updated_at = date('Y-m-d H:i:s');

        return $table->edit();
    }

    function remove($code)
    {
        /** @var Table */
        $table = Table::findByCode($code);

        if ($table == null) throw new AppException("Table not found");

        $table->removed_at = date('Y-m-d H:i:s');

        return $table->edit();
    }

    function delete($code)
    {
        /** @var Table */
        $table = Table::findByCode($code);

        if ($table == null) throw new AppException("Table not found");

        return $table->delete();
    }

    function states()
    {
        return TableState::all()->fetch();
    }

    function changeState($code)
    {
        /** @var Table */
        $table = Table::find($code);

        if ($table == null) throw new AppException("Table not found");

        if ($table->removed_at == null) {
            $table->removed_at = date('Y-m-d H:i:s');
        } else {
            $table->removed_at = null;
        }

        return $table->edit();
    }
}
