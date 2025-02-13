<?php

namespace App\Config;

class Config
{
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