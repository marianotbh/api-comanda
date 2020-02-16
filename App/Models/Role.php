<?php

namespace App\Models;

use App\Core\Data\Model;
use JsonSerializable;

class Role extends Model implements JsonSerializable
{
    public $id;
    public $name;
    public $description;
    public $created_at;
    public $updated_at;
    public $removed_at;

    function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "removedAt" => $this->removed_at
        ];
    }
}
