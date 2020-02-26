<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderState;
use App\Core\Exceptions\AppException;

class OrderService
{
    function list()
    {
        /** @var Order[] */
        $orders = Order::whereRemoved_at(null)
            ->orderBy("created_at")
            ->take(10)
            ->fetch();

        return $orders;
    }

    function read($code)
    {
        /** @var Order */
        $order = Order::findByCode($code);

        return $order;
    }

    function create($model)
    {
        $order = new Order();

        $order->name = $model->name;
        $order->description = $model->description;

        return $order->create();
    }

    function update($code, $model)
    {
        /** @var Order */
        $order = Order::findByCode($code);

        if ($order == null) throw new AppException("Order not found");

        $order->name = $model->name;
        $order->description = $model->description;
        $order->updated_at = date('Y-m-d H:i:s');

        return $order->edit();
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
