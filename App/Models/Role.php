<?php

namespace App\Models;

use App\Core\Data\Model;

class Role extends Model
{
    public $id;
    public $name;

    const ADMIN = 1;
    const MANAGER = 2;
    const FLOOR = 3;
    const BAR = 4;
    const KITCHEN = 5;
    const BREWERY = 6;
}
