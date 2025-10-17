<?php

namespace App\Http\Controllers;

use function Pest\Laravel\json;

abstract class Controller
{
    public function __construct() {}

    protected function sendResponse($object = [], $message= '', $code = 1, $status = 'ng')
    {
        if ($object && count($object)) {
            $code = 0;
            $status = 'ok';
        }

        $response = [
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'object' => $object
        ];

            echo json_encode($response);
        }
}
