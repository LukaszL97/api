<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Carbon;
use Mail;
use Illuminate\Support\Str;
use DB;

class ResetPasswordController extends Controller
{
    public function sendPasswordEmail(Request $request)
    {
        if(!$this->checkEmail($request->email))
        {
            return $this->failedResponse();
        }

        $this->sendemail($request->email);
    }

    public function sendemail($email)
    {
        $token = $this->createToken($email);
        Mail::to($email)->send(new ResetPasswordMail($token));
    }

    public function CreateToken($email)
    {
        $oldToken = DB::table('password_resets')->where('email', $email)->first();
        if($oldToken)
        {
            return $oldToken;
        }

        $token = Str::random(60);
        $this->saveToken($token, $email);
        return $token;
    }

    public function saveToken($token, $email)
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
            ]);
    }

    public function checkEmail($email)
    {
        return !!User::where('email', $email)->first();
    }

    public function failedResponse()
    {
        return response()->json([
            'error' => 'Podany email nie jest przypisany do żadnego z użytkowników'
        ], Response::HTTP_NOT_FOUND);
    }
}
