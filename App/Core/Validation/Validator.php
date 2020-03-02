<?php

namespace App\Core\Validation;

use App\Core\Exceptions\ValidatorException;

require_once 'Validators.php';

class Validator
{
    static function check($rules, $object)
    {
        $errors = validate($rules, $object);

        if (count($errors) > 0) {
            throw new ValidatorException($errors);
        }

        return json_decode(json_encode($object));
    }
}
