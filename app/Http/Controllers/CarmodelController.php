<?php

namespace App\Http\Controllers;

use App\Models\Carbrand;
use App\Models\Carmodel;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class CarmodelController extends Controller
{
    function getCarmodels()
    {
        return DB::table('carbrands')
            ->select('carbrands.carbrand_name', 'carmodels.*')
            ->join('carmodels', 'carbrands.id_carbrand', 'carmodels.id_carbrand')
            ->get();

    }

    function getCarmodel($id)
    {
        return DB::table('carmodels')->where('id_carmodel', $id)->get();
    }

    function storeCarmodel(Request $req)
    {
        $req->validate([
            'carmodel_name'=>'required',
            'id_carbrand'=>'required',
        ]);

        $carmodel = new Carmodel;
        $carmodel->carmodel_name = $req->carmodel_name;
        $carmodel->id_carbrand = $req->id_carbrand;
        $carmodel->save();
    }

    function deleteCarmodel($id)
    {
        $carmodel = Carmodel::find($id);
        $carmodel->delete();
    }

    function editCarmodel(Request $req, $id)
    {
        $req->validate([
            'carmodel_name'=>'required',
            'id_carbrand'=>'required',
        ]);
        $carmodel = Carmodel::find($id);
        $carmodel->carmodel_name = $req->carmodel_name;
        $carmodel->id_carbrand = $req->id_carbrand;
        $carmodel->save();
    }

    function getCarbrandByID(Request $req)
    {
        $id_carbrand = $req->id_carbrand;
        return DB::table('carbrands')
            ->select('carbrands.carbrand_name', 'carmodels.*')
            ->join('carmodels', 'carbrands.id_carbrand', 'carmodels.id_carbrand')
            ->where('carmodels.id_carbrand', '=', $id_carbrand)
            ->get();
    }


}
