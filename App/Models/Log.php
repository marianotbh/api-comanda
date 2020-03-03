<?php

namespace App\Models;

use \App\Core\Data\Model;
use JsonSerializable;

class Log extends Model implements JsonSerializable
{
    public $id;
    public $user;
    public $role;
    public $action;
    public $resource;
    public $created_at;

    function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "user" => $this->user,
            "role" => $this->role,
            "action" => $this->action,
            "resource" =>  $this->resource,
            "createdAt" => $this->created_at
        ];
    }
}
