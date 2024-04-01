<?php

namespace App\Exceptions;

use Exception;

class ApiException extends Exception
{

    public function render()
    {
        $code = $this->getCode();
        $msg = $this->getMessage();
        if ($code == 400) {
            $msg = json_decode($msg) ? json_decode($msg) : $msg;
        }
        $results = [
            "message" => $msg,
            "code" => $code
        ];
        return response()->json([
            'errors' => $results
        ], 200);
    }
}