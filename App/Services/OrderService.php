<?php

namespace App\Services;

use App\Models\Order;
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

    function read($id)
    {
        /** @var Order */
        $order = Order::findById($id);

        return $order;
    }

    function create($model)
    {
        $order = new Order();

        $order->name = $model->name;
        $order->description = $model->description;

        return $order->create();
    }

    function update($id, $model)
    {
        /** @var Order */
        $order = Order::findById($id);

        if ($order == null) throw new AppException("Order not found");

        $order->name = $model->name;
        $order->description = $model->description;
        $order->updated_at = date('Y-m-d H:i:s');

        return $order->edit();
    }

    function remove($id)
    {
        /** @var Order */
        $order = Order::findById($id);

        if ($order == null) throw new AppException("Order not found");

        $order->removed_at = date('Y-m-d H:i:s');

        return $order->edit();
    }

    function delete($id)
    {
        /** @var Order */
        $order = Order::findById($id);

        if ($order == null) throw new AppException("Order not found");

        return $order->delete();
    }
}
