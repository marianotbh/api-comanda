<?php

namespace App\Core\Utils;

class HashHelper
{
    static function generate($length)
    {
        $hash = "";
        $alphabet = "abcdefghijklmnopqrstuvwxyz0123456789";
        $max = strlen($alphabet);
        for ($i = 0; $i < $length; $i++) {
            $hash .= $alphabet[rand(0, $max - 1)];
        }
        return $hash;
    }
}
