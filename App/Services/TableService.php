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
        $table = new Table();

        $table->name = $model->name;
        $table->description = $model->description;

        return $table->create();
    }

    function update($code, $model)
    {
        /** @var Table */
        $table = Table::findByCode($code);

        if ($table == null) throw new AppException("Table not found");

        $table->name = $model->name;
        $table->description = $model->description;
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
}
