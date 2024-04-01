<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use Illuminate\Http\Request;

class ApiController extends Controller
{
     /**
     * @param array $data
     * @param int   $status
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiException
     */
    public function json($data = [], $status = 200)
    {
        try {
            return response()->json($data, $status);
        } catch (ApiException $e) {
            report($e);
            $code = $this->getCode();
            $msg = $this->getMessage();
            $results = [
                "message" => $msg,
                "code" => $code
            ];
            return response()->json([
                'errors' => $results
            ]);
        }
    }
}
