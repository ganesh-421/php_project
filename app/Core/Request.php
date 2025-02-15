<?php

namespace App\Core;

use App\Core\Jwt\Jwt;
use App\Core\Jwt\Key;
use Exception;

class Request
{

    /**
     * check if incoming request expects json
     */
    public static function expectJson()
    {
        if (!empty($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
            return true;
        }

        if (!empty($_SERVER['CONTENT_TYPE']) && str_contains($_SERVER['CONTENT_TYPE'], 'application/json')) {
            return true;
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            return true;
        }

        return false;
    }

    /**
     * get auth header from request
     */
    public static function getAuthHeader()
    {
        $headers = null;
        if(isset($_SERVER['Authorization']))
            $headers = trim($_SERVER['Authorization']);
        else if(isset($_SERVER['HTTP_AUTHORIZATION']))
            $headers = trim($_SERVER['HTTP_AUTHORIZATION']);
        else if(function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if(isset($requestHeaders['Authorization']))
                $headers = trim($requestHeaders['Authorization']);
        }
        return $headers;
    }

    /**
     * get auth token from auth header
     */
    public static function getAuthToken()
    {
        $headers = self::getAuthHeader();
        if(!empty($headers))
        {
            if(preg_match('/Bearer\s(\S+)/', $headers, $matches))
                return $matches[1];
            else
                throw new Exception("Auth Token Not Found");
        }
        else 
            throw new Exception("Auth Header Not Found");
    }

    /**
     * get authenticated session for api 
     */
    public static function getAuthSession()
    {
        $jwt_token = self::getAuthToken();
        $payload = Jwt::decode($jwt_token, new Key(Config::jwt('secret'), Config::jwt('algorithm')));
        return $payload->session;
    }
}