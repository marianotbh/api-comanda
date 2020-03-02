<?php

use App\Core\Exceptions\ValidatorException;

function validateRequired($value)
{
    return !isset($value) ? "The field is required" : true;
}

function validateMin($value, $param)
{
    if (is_numeric($value)) {
        return $value < $param ? "The field must be greater than $param" : true;
    } else if (is_string($value)) {
        return strlen($value) < $param ? "The field must be longer than $param" : true;
    } else if (is_array($value)) {
        return count($value) < $param ? "The field must contain at least $param item(s)" : true;
    } else {
        return true;
    }
}

function validateMax($value, $param)
{
    if (is_numeric($value)) {
        return $value > $param ? "The field must be smaller than $param" : true;
    } else if (is_string($value)) {
        return strlen($value) > $param ? "The field must be shorter than $param" : true;
    } else if (is_array($value)) {
        return count($value) > $param ? "The field must contain at most $param item(s)" : true;
    } else {
        return true;
    }
}

function validateLength($value, $param)
{
    if (is_numeric($value)) {
        return $value != $param ? "The field has to be a $param digits number" : true;
    } else if (is_string($value)) {
        return strlen($value) != $param ? "The field's length must be $param" : true;
    } else if (is_array($value)) {
        return count($value) != $param ? "The field must contain $param item(s)" : true;
    } else {
        return true;
    }
}

function validateEmail($value)
{
    if (is_string($value)) {
        return !filter_var($value, FILTER_VALIDATE_EMAIL) ? "The field does not match a valid email format" : true;
    }

    return true;
}

function validatePattern($value, $param)
{
    if (is_string($value) && @preg_match($param, '') !== false) {
        return preg_match($param, $value) ? "The field contains invalid characters" : true;
    }

    return true;
}

function validateIn($value, $param)
{
    if (is_array($param)) {
        return $value ? in_array($value, $param) ? "The field does not accept $param" : true : true;
    }

    return true;
}

function validateCollection($value, $param)
{
    if (!is_array($value)) {
        return "The field is not a collection";
    }

    if (!is_callable($param)) {
        return "Validation parameter is not a valid callback";
    }

    $errors = [];

    foreach ($value as $key => $val) {
        $result = $param($val, $key);
        if ($result !== true) {
            $errors[$key] = $result;
        }
    }

    return count($errors) > 0 ? $errors : true;
}

function validate($rules, $obj)
{
    $errors = [];
    $defaultValidators = array(
        "required" => "validateRequired",
        "min" => "validateMin",
        "max" => "validateMax",
        "length" => "validateLength",
        "email" => "validateEmail",
        "pattern" => "validatePattern",
        "in" => "validateIn",
        "collection" => "validateCollection"
    );

    foreach ($rules as $prop => $rule) {
        $value = isset($obj[$prop]) ? $obj[$prop] : null;

        if (is_array($rule)) {
            foreach ($rule as $key => $param) {
                if (is_int($key)) {
                    if (is_callable($param)) {
                        $result = $param($value);
                    } else {
                        $validator = $defaultValidators[$param];
                        if ($validator !== null) {
                            $result = $validator($value);
                        } else {
                            throw new ValidatorException("Unknown requested validator: '$param'");
                        }
                    }
                } else {
                    $validator = $defaultValidators[$key];
                    if ($validator !== null) {
                        $result = $validator($value, $param);
                    } else {
                        throw new ValidatorException("Unknown requested validator: '$key'");
                    }
                }
                if ($result !== true) {
                    if (isset($errors[$prop]) && is_array($errors[$prop])) {
                        $errors[$prop][] = $result;
                    } else {
                        $errors[$prop] = array($result);
                    }
                }
            }
        } else {
            if (is_callable($rule)) {
                $result = $rule($value);
            } else if (is_string($rule)) {
                $validator = $defaultValidators[$rule];
                if ($validator !== null) {
                    $result = $validator($value);
                } else {
                    throw new ValidatorException("Unknown requested validator: '$rule'");
                }
            }

            if ($result !== true) {
                if (isset($errors[$prop]) && is_array($errors[$prop])) {
                    $errors[$prop][] = $result;
                } else {
                    $errors[$prop] = array($result);
                }
            }
        }
    }

    return $errors;
}
