<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderState;
use App\Core\Exceptions\AppException;
use App\Core\Utils\HashHelper;
use App\Models\Menu;
use App\Models\OrderDetail;
use App\Models\Table;
use App\Models\TableState;

use function App\Core\Utils\kebabize;

class OrderService
{
    function list($filters = [], $page = 1, $length = 100, $field = "createdAt", $order = "ASC")
    {
        /** @var Order[] */
        $orders = Order::whereRemoved_at(null)
            ->skip(($page - 1) * $length)
            ->take($length)
            ->orderBy(kebabize($field), $order);

        foreach ($filters as $key => [$operator, $value]) {
            $orders->where(kebabize($key), $operator, $value);
        }

        // foreach ($orders as $order) {
        //     $order->detail = OrderDetail::where("order", "=", $order->code)->fetch();
        // }

        return [
            "data" => $orders->fetch(),
            "total" => Order::count()
        ];
    }

    function read($code)
    {
        /** @var Order */
        $order = Order::findByCode($code);

        if ($order != null) {
            $order->detail = OrderDetail::whereOrder($order->code)->fetch();
        }

        return $order;
    }

    function create($model)
    {
        $order = new Order();

        $code = HashHelper::generate(5);

        /** @var Table */
        $table = Table::find($model->table);

        if ($table == null) throw new AppException("Table not found");
        if ($table->state != TableState::AVAILABLE) throw new AppException("Table is unavailable");

        $order->code = $code;
        $order->user = $model->user;
        $order->table = $model->table;
        $order->state = 0;

        if (!$order->create()) throw new AppException("Order could not be created, please try again later");

        foreach ($model->detail as $d) {
            /** @var Menu */
            $menu = Menu::find($d->menu);

            if ($menu == null) throw new AppException("Menu item not found");
            if ($menu->stock < $d->amount) throw new AppException("There is not enough " . $menu->name . " for this order");

            $detail = new OrderDetail();

            $detail->order = $code;
            $detail->menu = $d->menu;
            $detail->amount = $d->amount;
            $detail->state = 0;

            if (!$detail->create()) throw new AppException("Could not add detail to order $code, please try again");

            $menu->stock = $menu->stock - $detail->amount;
            $menu->edit();
        }

        $table->state = TableState::WAITING;
        $table->edit();

        return $code;
    }

    function update($code, $model)
    {
        /** @var Order */
        $order = Order::findByCode($code);

        if ($order == null) throw new AppException("Order not found");

        /** @var Table */
        $table = Table::find($model->table);

        if ($table == null) throw new AppException("Table not found");
        if ($table->state != TableState::AVAILABLE) throw new AppException("Table is unavailable");

        $order->user = $model->user;
        $order->table = $model->table;
        $order->state = $model->state;
        $order->updated_at = date('Y-m-d H:i:s');

        if (!$order->edit()) throw new AppException("Could not update the order, please try again");

        foreach ($model->detail as $d) {

            $detail = OrderDetail::find($d->id);


            if ($detail != null) {
                /** @var Menu */
                $menu = Menu::find($d->menu);

                if ($menu == null) throw new AppException("Menu item not found");
                if ($menu->stock < $d->amount) throw new AppException("There is not enough " . $menu->name . " for this order");

                $detail->menu = $d->menu;
                $detail->amount = $d->amount;
                $detail->state = 0;

                $detail->edit();
            } else {
                $detail = new OrderDetail();

                $detail->order = $code;
                $detail->menu = $d->menu;
                $detail->amount = $d->amount;
                $detail->state = 0;

                $detail->create();
            }
        }

        return $order->code;
    }

    function remove($code)
    {
        /** @var Order */
        $order = Order::findByCode($code);

        if ($order == null) throw new AppException("Order not found");

        $order->removed_at = date('Y-m-d H:i:s');

        return $order->edit();
    }

    function delete($code)
    {
        /** @var Order */
        $order = Order::findByCode($code);

        if ($order == null) throw new AppException("Order not found");

        return $order->delete();
    }

    function states()
    {
        return OrderState::all()->fetch();
    }

    function changeState($code)
    {
        /** @var Order */
        $order = Order::find($code);

        if ($order == null) throw new AppException("Order not found");

        if ($order->removed_at == null) {
            $order->removed_at = date('Y-m-d H:i:s');
        } else {
            $order->removed_at = null;
        }

        return $order->edit();
    }
}
