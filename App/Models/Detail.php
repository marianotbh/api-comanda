<?php

namespace App\Models;

use \App\Core\Data\Model;
use JsonSerializable;

class Detail extends Model implements JsonSerializable
{
    public $id;
    public $user;
    public $order;
    public $menu;
    public $amount;
    public $state;
    public $created_at;
    public $updated_at;
    public $removed_at;

    function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "user" => $this->user,
            "order" => $this->order,
            "menu" => $this->menu,
            "amount" => $this->amount,
            "state" => $this->state,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "removedAt" => $this->removed_at,
        ];
    }
}
