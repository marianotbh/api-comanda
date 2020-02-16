<?php

namespace App\Core;

use App\Core\Exceptions\ValidatorException;

class Validator
{
    static function check($rules, $object)
    {
        $arr = (array) $object;
        $errors = [];

        foreach ($rules as $prop => $rule) {

            $value = isset($arr[$prop]) ?? null;

            if (is_array($rule)) {
                foreach ($rule as $subrule) {
                    $error = check($subrule, $prop, $value);
                    if ($error) {
                        array_push($errors, $error);
                    }
                }
            } else {
                $error = check($rule, $prop, $value);
                if ($error) {
                    array_push($errors, $error);
                }
            }
        }

        if (count($errors) > 0) {
            throw new ValidatorException("The passed object contains the following errors: " . implode(", ", $errors));
        }

        return $object;
    }
}

function check($rule, $prop, $value)
{
    $segments = strpos($rule, ':') !== false ? explode(":", $rule) : [$rule];
    $rule = $segments[0];
    $param = count($segments) > 0 && isset($segments[1]) ? $segments[1] : null;

    if ($rule == "required") {
        return isset($value) ? false : sprintf("The field '%s' is required", $prop);

        if ($rule == "min") {
            return $value >= $param ? false : sprintf("The field '%s' must be greater than %s", $prop, $param);
        } else if ($rule == "max") {
            return $value <= $param ? false : sprintf("The field '%s' must be lesser than %s", $prop, $param);
        } else if ($rule == "minLength") {
            return strlen($value) >= $param ? false : sprintf("The field '%s' must be longer than %s", $prop, $param);
        } else if ($rule == "maxLength") {
            return strlen($value) <= $param ? false : sprintf("The field '%s' must be shorter than %s", $prop, $param);
        } else if ($rule == "length") {
            return strlen($value) == $param ? false : sprintf("The field '%s'´s length must be %s", $prop, $param);
        } else if ($rule == "pattern") {
            return preg_match($param, $value) ? false : sprintf("The field '%s' contains invalid characters", $prop, $param);
        } else if ($rule == "in") {
            $values = array_map(function ($val) {
                return trim($val);
            }, explode(";", $param));
            return in_array((is_string($value) ? $value : strval($value)), $values, true) != false ? false : sprintf("The field '%s'´s value must be one of %s", $prop, implode(", ", $values));
        } else if ($rule == "email") {
            return filter_var($value, FILTER_VALIDATE_EMAIL) ? false : sprintf("The field %s format is incorrect", $prop, $param);
        } else {
            return false;
        }
    } else {
        return false;
    }
}
