<?php

namespace App\Models;

use \App\Core\Data\Model;

class OrderState extends Model
{
    public $id;
    public $name;

    const PENDING = 0;
    const PREPARING = 1;
    const DONE = 2;
    const SERVED = 3;
}
