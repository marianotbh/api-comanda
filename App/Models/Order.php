<?php

namespace App\Models;

use \App\Core\Data\Model;
use JsonSerializable;

class Order extends Model implements JsonSerializable
{
    static protected $pk = "code";

    public $code;
    public $state;
    public $user;
    public $table;
    public $created_at;
    public $updated_at;
    public $removed_at;

    function jsonSerialize()
    {
        return [
            "code" => $this->code,
            "state" => $this->state,
            "user" => $this->user,
            "table" => $this->table,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "removedAt" => $this->removed_at,
        ];
    }
}
