<?php

namespace App\Models;

use \App\Core\Data\Model;

class TableState extends Model
{
    public $id;
    public $name;

    const AVAILABLE = 0;
    const PAYING = 1;
    const SERVED = 2;
    const WAITING = 3;
}
