<?php

namespace App\Models;

use \App\Core\Data\Model;
use JsonSerializable;

class Order extends Model implements JsonSerializable
{
    static protected $pk = "code";
    static protected $ignore = ["detail"];

    public $code;
    public $state;
    public $user;
    public $table;
    public $detail;
    public $created_at;
    public $updated_at;
    public $removed_at;

    function jsonSerialize()
    {
        $serialize = [
            "code" => $this->code,
            "state" => $this->state,
            "user" => $this->user,
            "table" => $this->table,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "removedAt" => $this->removed_at,
        ];

        if (is_array($this->detail) && count($this->detail) > 0) {
            $serialize["detail"] = $this->detail;
        }

        return $serialize;
    }
}
