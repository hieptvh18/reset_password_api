<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Throwable;

class ResetPasswordController extends ApiController
{
    public function reset(ResetPasswordRequest $request)
    {
        $token = $request->token;

        try{
            $passwordReset = PasswordReset::where('token', $token)->firstOrFail();
            if (Carbon::parse($passwordReset->updated_at)->addMinutes(30)->isPast()) { // token expire > 30 minutes
                $passwordReset->delete();

                return response()->json([
                    'statusCode'=> 422,
                    'errors'=>[
                        'code'=>'',
                        'message' => __('This password reset token is invalid.'),
                    ]
                ], 422);
            }
            $user = User::where('email', $passwordReset->email)->firstOrFail();
            $updatePasswordUser = $user->update($request->only('password'));
            $passwordReset->delete();

            return response()->json([
                'status' => 'success',
                'message'=>__('Change password successfully')
            ]);
        }catch(Throwable $th){
            return response()->json([
                'statusCode'=> $th->getCode(),
                'errors'=>[
                    'code'=>'',
                    'message' => $th->getMessage(),
                ]
            ]);
        }
    }
}
