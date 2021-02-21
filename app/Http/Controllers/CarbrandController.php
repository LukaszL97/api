<?php

namespace App\Http\Controllers;

use App\Models\Carbrand;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class CarbrandController extends Controller
{

    function storeCarbrand(Request $req)
    {
        $req->validate([
            'carbrand_name'=>'required',
        ]);

        $carbrand = new Carbrand();
        $carbrand->carbrand_name = $req->carbrand_name;
        $carbrand->save();
    }

    function getCarbrands()
    {
        return Carbrand::all();
    }
    function getCarbrand($id)
    {
        return DB::table('carbrands')->where('id_carbrand', $id)->get();
    }

    function deleteCarbrand($id)
    {
        $carbrand = Carbrand::find($id);
        $carbrand->delete();
    }

    function editCarbrand(Request $req, $id)
    {

        $carbrand = Carbrand::find($id);
        $carbrand->carbrand_name = $req->carbrand_name;
        $carbrand->save();
    }

}
