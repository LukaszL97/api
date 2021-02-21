<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;

class PasswordController extends Controller
{
    function editPassword(Request $req, $id)
    {
        $req->validate([
            'password'=>'required|min:4'
        ]);

        $user = User::find($id);
        $user->password = bcrypt($req->password);
        $user->save();
    }
}
