<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Throwable;

class ForgotPasswordController extends ApiController
{
    
    public function forgot(ForgotPasswordRequest $request)
    {
        try{
            $user = User::where('email', $request->email)->firstOrFail();
            $passwordReset = PasswordReset::updateOrCreate([
                'email' => $user->email,
            ], [
                'token' => Str::random(30),
            ]);
            if ($passwordReset) {
                $user->notify(new ResetPasswordNotification($passwordReset->token));
            }
      
            return response()->json([
                'status' => 'success',
                'message'=>__('Send mail successfully')
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
