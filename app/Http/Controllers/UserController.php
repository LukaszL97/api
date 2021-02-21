<?php

namespace App\Http\Controllers;
use App\Models\User;
use DB;

use Illuminate\Http\Request;

class UserController extends Controller
{
    function getUsers()
    {
        return DB::table('users')
            ->Join('roles','roles.id_role','=','users.role')
            ->select('users.id_user','users.firstname','users.lastname','users.username','users.email','users.created_at','users.updated_at','roles.role_name')
            ->get();
    }

    function getUser($id)
    {
        return DB::table('users')
            ->Join('roles','roles.id_role','=','users.role')
            ->where('users.id_user', $id)
            ->select('users.id_user','users.firstname','users.lastname','users.username','users.email','users.created_at','users.updated_at','roles.role_name')
            ->get();
    }

    function storeUser(Request $req)
    {
        $req->validate([
            'firstname'=>'required',
            'lastname'=>'required',
            'username'=>'required|unique:users',
            'email'=>'required|email|unique:users',
            'role'=>'required',
        ]);

            $user = new User;
            $user->firstname = $req->firstname;
            $user->lastname = $req->lastname;
            $user->username = $req->username;
            $user->email = $req->email;
            $user->password = bcrypt($req->password);
            $user->role = $req->role;
            $user->save();
    }

    function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
    }

    function editUser(Request $req, $id)
    {
        $req->validate([
            'firstname'=>'required',
            'lastname'=>'required',
            'username'=>'required',
            'email'=>'required',
            'role'=>'required',
        ]);

        $user = User::find($id);
        $user->firstname = $req->firstname;
        $user->lastname = $req->lastname;
        $user->username = $req->username;
        $user->email = $req->email;
        $user->role = $req->role;
        $user->save();
    }


}
