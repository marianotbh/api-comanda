<?php

namespace App\Models;

use \App\Core\Data\Model;
use JsonSerializable;

class Log extends Model implements JsonSerializable
{
    public $id;
    public $user;
    public $ip;
    public $action;
    public $resource;
    public $request;
    public $response;
    public $created_at;
    public $updated_at;
    public $removed_at;

    function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "user" => $this->user,
            "ip" => $this->ip,
            "action" => $this->action,
            "resource" =>  $this->resource,
            "request" => $this->request,
            "response" => $this->response,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "removedAt" => $this->removed_at,
        ];
    }
}
