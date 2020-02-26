<?php

namespace App\Models;

use \App\Core\Data\Model;
use JsonSerializable;

class User extends Model implements JsonSerializable
{
    public $id;
    public $name;
    public $password;
    public $email;
    public $first_name;
    public $last_name;
    public $created_at;
    public $updated_at;
    public $removed_at;
    public $last_login_at;
    public $role;

    function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "firstName" => $this->first_name,
            "lastName" => $this->last_name,
            "email" => $this->email,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "removedAt" => $this->removed_at,
            "lastLoginAt" => $this->last_login_at,
            "role" => $this->role
        ];
    }
}
