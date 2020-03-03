<?php

namespace App\Services;

use App\Models\Table;
use App\Models\TableState;
use App\Core\Exceptions\AppException;
use App\Models\Order;
use App\Models\OrderState;
use Slim\Http\UploadedFile;

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

    function create($model, UploadedFile $image = null)
    {
        if (Table::find($model->code) != null) throw new AppException("Table code already exists");

        $table = new Table();

        $table->code = $model->code;
        $table->capacity = $model->capacity;
        $table->state = 0; // Available

        if (!$table->create()) throw new AppException("Table could not be created");

        if ($image != null && ImageHelper::validate($image)) {
            ImageHelper::saveTo("Tables", $image, "$table->code.png");
        }

        return $table->code;
    }

    function update($code, $model, UploadedFile $image = null)
    {
        /** @var Table */
        $table = Table::findByCode($code);

        if ($table == null) throw new AppException("Table not found");

        $table->capacity = $model->capacity;
        $table->state = $model->state;
        $table->updated_at = date('Y-m-d H:i:s');

        $table->edit();

        if ($image != null && ImageHelper::validate($image)) {
            ImageHelper::saveTo("Tables", $image, "$table->code.png");
        }
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
        return TableState::all()->orderBy("id", "ASC")->fetch();
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

    function close($code)
    {
        /** @var Table */
        $table = Table::find($code);

        if ($table == null || $table->removed_at != null) throw new AppException("Table not found");

        /** @var Order */
        $order = Order::find(["table" => $table->code, "removed_at" => null]);

        if ($order == null || $order->removed_at != null) throw new AppException("There is not an order active for this table");
        if ($order->state != OrderState::SERVED) throw new AppException("Cannot close a table with a pending order");

        $order->removed_at = date('Y-m-d H:i:s');
        $order->edit();

        $table->state = TableState::AVAILABLE;
        $table->edit();
    }
}
