<?php

namespace App\Models;

use \App\Core\Data\Model;
use JsonSerializable;

class Menu extends Model implements JsonSerializable
{
    static protected $table = "menu";

    /** @var int */
    public $id;
    /** @var string */
    public $name;
    /** @var string */
    public $description;
    /** @var float */
    public $price;
    /** @var int */
    public $stock;
    /** @var int */
    public $category;
    /** @var string */
    public $created_at;
    /** @var string */
    public $updated_at;
    /** @var string */
    public $removed_at;

    function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "price" => $this->price,
            "stock" => $this->stock,
            "category" => $this->category,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "removedAt" => $this->removed_at,
        ];
    }
}
