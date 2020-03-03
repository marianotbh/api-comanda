<?php

namespace App\Models;

use \App\Core\Data\Model;
use JsonSerializable;

class Receipt extends Model implements JsonSerializable
{
    public $id;
    public $user;
    public $table;
    public $order;
    public $total;
    public $created_at;

    function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "user" => $this->user,
            "table" => $this->table,
            "order" => $this->order,
            "total" => $this->total,
            "createdAt" => $this->created_at
        ];
    }
}
