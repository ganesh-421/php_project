<?php

namespace App\Core\Exceptions;

use Exception;

class RouteNotFoundException extends Exception
{
    /**
     * handles the exception
     */

     public function handle()
     {
         $line = $this->getLine();
         $file = $this->getFile();
         $message = !empty($this->getMessage()) ?: "Requested route couldn't be found on line " . $line . " on " . $file;
         return $message;
     }
}