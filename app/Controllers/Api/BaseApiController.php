<?php

namespace App\Controllers\Api;

class BaseApiController
{
    /**
     * send success response
     * @param array 
     * @param string
     * @param int
     */
    public function sendSuccess(array $data = [], string $message = '', int $code = 200)
    {
        return $this->sendJsonResponse([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * sends failure response
     * @param string 
     * @param array
     * @param int
     */
    public function sendError(string $message = "Error", int $code = 400, array $errors = [])
    {
        if(!empty($errors))
            return $this->sendJsonResponse([
                'status' => 'failed',
                'message' => $message,
                'errors' => $errors
            ], $code);
        return $this->sendJsonResponse([
            'status' => 'failed',
            'message' => $message
        ], $code);
    }

    /**
     * sends json response
     * @param array 
     * @param int
     */
    private function sendJsonResponse(array $response, int $code)
    {
        header('Content-Type: application/json');
        http_response_code($code);
        echo json_encode($response);
        exit;
    }
}