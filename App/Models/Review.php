<?php

namespace App\Models;

use \App\Core\Data\Model;
use App\Core\Data\QueryBuilder;
use JsonSerializable;

class Review extends Model implements JsonSerializable
{
    public $id;
    public $order;
    public $name;
    public $email;
    public $description;
    public $menu_score;
    public $table_score;
    public $service_score;
    public $environment_score;
    public $created_at;
    public $updated_at;
    public $removed_at;

    static function avg($col)
    {
        $reviews = new QueryBuilder("reviews");
        return $reviews->select("AVG(`$col`)")->setFetchMode(\PDO::FETCH_COLUMN, null);
    }

    function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "order" => $this->order,
            "name" => $this->name,
            "email" => $this->email,
            "description" => $this->description,
            "menuScore" => $this->menu_score,
            "tableScore" => $this->table_score,
            "serviceScore" => $this->service_score,
            "environmentScore" => $this->environment_score,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "removedAt" => $this->removed_at,
        ];
    }
}
