<?php

namespace App\Models;

use \App\Core\Data\Model;
use JsonSerializable;

class OrderDetail extends Model implements JsonSerializable
{
    public $id;
    public $user;
    public $order;
    public $menu;
    public $amount;
    public $state;
    public $estimated_at;
    public $created_at;
    public $updated_at;
    public $removed_at;

    function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "order" => $this->order,
            "user" => $this->user,
            "menu" => $this->menu,
            "amount" => $this->amount,
            "state" => $this->state,
            "estimatedAt" => $this->estimated_at,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "removedAt" => $this->removed_at,
        ];
    }
}
