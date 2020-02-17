<?php

namespace App\Services;

use App\Models\Table;
use App\Core\Exceptions\AppException;

class TableService
{
    function list()
    {
        /** @var Table[] */
        $tables = Table::whereRemoved_at(null)
            ->orderBy("name")
            ->take(10)
            ->fetch();

        return $tables;
    }

    function read($id)
    {
        /** @var Table */
        $table = Table::findById($id);

        return $table;
    }

    function create($model)
    {
        $table = new Table();

        $table->name = $model->name;
        $table->description = $model->description;

        return $table->create();
    }

    function update($id, $model)
    {
        /** @var Table */
        $table = Table::findById($id);

        if ($table == null) throw new AppException("Table not found");

        $table->name = $model->name;
        $table->description = $model->description;
        $table->updated_at = date('Y-m-d H:i:s');

        return $table->edit();
    }

    function remove($id)
    {
        /** @var Table */
        $table = Table::findById($id);

        if ($table == null) throw new AppException("Table not found");

        $table->removed_at = date('Y-m-d H:i:s');

        return $table->edit();
    }

    function delete($id)
    {
        /** @var Table */
        $table = Table::findById($id);

        if ($table == null) throw new AppException("Table not found");

        return $table->delete();
    }
}
