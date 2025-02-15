<?php

namespace App\Core\Exceptions;

use App\Core\Request;
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
         if(!Request::expectJson()) {
             return $message;
         }
        else {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'line' => $line,
                'file' => $file,
                'trace' => $message
            ]);
        }
        exit;
     }
}