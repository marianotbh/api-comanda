<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderState;
use App\Core\Exceptions\AppException;
use App\Core\Utils\HashHelper;
use App\Models\OrderDetail;

use function App\Core\Utils\kebabize;

class OrderService
{
    function list($page = 1, $length = 100, $field = "createdAt", $order = "ASC")
    {
        /** @var Order[] */
        $orders = Order::whereRemoved_at(null)
            ->skip(($page - 1) * $length)
            ->take($length)
            ->orderBy(kebabize($field), $order)
            ->fetch();

        foreach ($orders as $order) {
            $order->detail = OrderDetail::whereOrder($order->code)->fetch();
        }

        return [
            "data" => $orders,
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

        $order->code = $code;
        $order->user = $model->user;
        $order->table = $model->table;

        if (!$order->create()) throw new AppException("Order could not be created, please try again later");

        foreach ($model->detail as $d) {
            $detail = new OrderDetail();

            $detail->order = $code;
            $detail->menu = $d->menu;
            $detail->amount = $d->amount;
            $detail->state = 0;

            $detail->create();
        }

        return $code;
    }

    function update($code, $model)
    {
        /** @var Order */
        $order = Order::findByCode($code);

        if ($order == null) throw new AppException("Order not found");

        $order->user = $model->user;
        $order->table = $model->table;
        $order->state = $model->state;

        $order->edit();

        foreach ($model->detail as $d) {

            $detail = OrderDetail::findByCode($d->id);

            if ($detail != null) {
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
                $order->updated_at = date('Y-m-d H:i:s');

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
}
