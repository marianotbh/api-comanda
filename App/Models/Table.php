<?php

namespace App\Models;

use \App\Core\Data\Model;
use JsonSerializable;

class Table extends Model implements JsonSerializable
{
    static protected $pk = "code";

    public $code;
    public $capacity;
    public $state;
    public $created_at;
    public $updated_at;
    public $removed_at;

    function jsonSerialize()
    {
        $serialized = [
            "code" => $this->code,
            "capacity" => $this->capacity,
            "state" => $this->state,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "removedAt" => $this->removed_at
        ];

        if ($this->state != TableState::AVAILABLE) {
            $serialized["currentOrder"] = Order::find(["table" => $this->code, "removed_at" => null]);
        }

        return $serialized;
    }
}
