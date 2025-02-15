<?php

namespace App\Models;

use App\Core\Config;
use App\Core\Jwt\Jwt;
use Exception;

class User extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = "user";
    }

    public function createToken()
    {
        if(!$_SESSION['token'])
        {
            throw new Exception("No Session Present");
        }
        $payload = [
            'iat' => time(),
            'iss' => 'localhost',
            'exp' => time() + (60*60),
            'session' => $_SESSION['token']
        ];
        return Jwt::encode($payload, Config::jwt('secret'), Config::jwt('algorithm'));
    }
}