<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Providing a formatted response for all controllers
     *
     * @param mixed $data - Data to be passed as a response
     * @param string $message - Response message 
     * @param string $status - Response status code 
     */
    public function formatResponse(string $message, int $status, $data = null)
    {
        $response = [
            'message' => $message,
            'status' => $status,
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }
        return response()->json($response);
    }
}
