<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use http\Env\Response;
use DB;
use App\Models\User;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $req)
    {


    $user = User::where('email', $req->email)->first();

    $user->update(['password'=>bcrypt($req->password)]);

    $this->getTableResetRow($req)->delete();

    }

    public function getTableResetRow($req)
    {
        return DB::table('password_resets')->where(['email' => $req->email, 'token'=>$req->resetToken]);
    }
}
