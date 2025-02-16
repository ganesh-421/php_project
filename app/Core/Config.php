<?php

namespace App\Core;

class Config
{
    /**
     * configs related to database
     * @param string key
     */
    public static function database($key)
    {
        switch($key)
        {
            case 'name':
                return static::getEnvValue('DB_DATABASE');
            case 'user':
                return static::getEnvValue('DB_USER');
            case 'password':
                return static::getEnvValue('DB_PASSWORD');
            case 'host':
                return static::getEnvValue('DB_HOST');
        }
    }

    /**
     * configs related to jwt 
     * @param string key
     */
    public static function jwt($key)
    {
        switch($key)
        {
            case 'secret':
                return static::getEnvValue('JWT_SECRET');
            case 'algorithm':
                return static::getEnvValue('JWT_ALGORITHM');
        }
    }

    /**
     * get value for provided key from .env
     * @param string key
     */
    private static function getEnvValue($key) {
        $envFile = __DIR__ . '/../../.env';
        if (!file_exists($envFile)) {
            return null;
        }
    
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) continue;
            list($envKey, $envValue) = explode('=', $line, 2);
            if (trim($envKey) === $key) {
                return trim($envValue);
            }
        }
        return null;
    }
}