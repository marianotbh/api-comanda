<?php

namespace App\Core\Utils;

use App\Core\Exceptions\AppException;
use \Firebase\JWT\JWT;
use \Exception;

class JWTHelper
{
    private static $key = "thisisasupersecretkeytoencodemyjwttokens";

    static function encode($payload, $expires = true)
    {
        $now = new \Datetime("now", new \DateTimeZone('America/Buenos_Aires'));

        $token = array(
            "iss" => "Mariano Burgos", //issuer
            "aud" => "Api Comanda", //audience
            "iat" => $now->getTimestamp(), //issued at
            "nbf" => $now->getTimestamp(), //not before
            "payload" => $payload // payload
        );

        if ($expires) {
            $token["exp"] = $now->add(new \DateInterval('PT500M'))->getTimestamp(); //expiration
        }

        return JWT::encode($token, self::$key);
    }

    static function decode($token)
    {
        try {
            return JWT::decode($token, self::$key, array('HS256'));
        } catch (\Firebase\JWT\BeforeValidException $e) {
            throw new AppException("Token is not valid yet");
        } catch (\Firebase\JWT\ExpiredException $e) {
            throw new AppException("Token expired");
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            throw new AppException("Invalid token signature");
        } catch (Exception $e) {
            throw $e;
        }
    }
}
