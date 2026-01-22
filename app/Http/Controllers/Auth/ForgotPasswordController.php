<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    // Step 1: Forgot Password - send reset link
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = Str::random(64);

        // token save in password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        // custom mail
        Mail::send('emails.forgotPassword', ['token' => $token,'email'=>$request->email], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password Link');
        });

        return response()->json(['data'=>[
            'email' => $request->email,
            'token' => $token
        ],'message' => 'Reset link sent to your email.'], 200);
    }

    // Step 2: Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|min:6',
            'token'    => 'required'
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])->first();

        if(!$reset){
            return response()->json(['message' => 'Invalid token!'], 400);
        }

        // update password
        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        // delete reset token
        DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();

        return response()->json(['message' => 'Password has been reset successfully.'], 200);
    }
}

