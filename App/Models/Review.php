<?php

namespace App\Models;

use \App\Core\Data\Model;
use JsonSerializable;

class Review extends Model implements JsonSerializable
{
    public $id;
    public $order;
    public $name;
    public $email;
    public $description;
    public $created_at;
    public $updated_at;
    public $removed_at;

    function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "order" => $this->order,
            "name" => $this->name,
            "email" => $this->email,
            "description" => $this->description,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "removedAt" => $this->removed_at,
        ];
    }
}
