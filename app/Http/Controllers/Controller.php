<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Providing a formatted response for all controllers
     *
     * @param string $message - Response message 
     * @param int $status - Response status code
     * @param mixed $data - Data to be added to the response if passed
     * @param mixed $errors - Errors to be added to the response if passed
     */
    public function formatResponse(string $message, int $status, $data = null, $errors = null)
    {
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }
        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response);
    }
}
