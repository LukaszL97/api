<?php

namespace App\Http\Controllers;

use App\Models\Carmodel;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\File;
use DB;

class CarController extends Controller
{
    function storeCar(Request $req)
    {
        $req->validate([
            'id_carbrand'=>'required',
            'id_carmodel'=>'required',
            'production_year'=>'',
            'plate_number'=>'unique:cars',
            'vin'=>'unique:cars',
            'colour'=>'',
            'description'=>'',
            'color'=>'',
        ]);

        if($req->color==null)
        {
            $color='#000000';
        }
        else
        {
            $color=$req->color;
        }

        $car = new Car;
        $car->id_carbrand = $req->id_carbrand;
        $car->id_carmodel = $req->id_carmodel;
        $car->production_year = $req->production_year;
        $car->plate_number = $req->plate_number;
        $car->vin = $req->vin;
        $car->colour = $req->colour;
        $car->description = $req->description;
        $car->color = $color;
        $car->save();
    }

    function getCars()
    {
        return DB::table('cars')
            ->select('carbrands.carbrand_name', 'carmodels.carmodel_name', 'cars.*')
            ->join('carbrands', 'cars.id_carbrand', 'carbrands.id_carbrand')
            ->join('carmodels', 'cars.id_carmodel', 'carmodels.id_carmodel')
            ->get();
    }

    function deleteCar($id)
    {
        $car = Car::find($id);
        $car->delete();
    }

    function getCar($id)
    {
        return DB::table('cars')
            ->select('carbrands.carbrand_name', 'carmodels.carmodel_name', 'cars.*')
            ->join('carbrands', 'cars.id_carbrand', 'carbrands.id_carbrand')
            ->join('carmodels', 'cars.id_carmodel', 'carmodels.id_carmodel')
            ->where('id_car', $id)
            ->get();
    }

    function editCar(Request $req, $id)
    {
        $req->validate([
            'id_carbrand'=>'required',
            'id_carmodel'=>'required',
            'production_year'=>'',
            'plate_number'=>'',
            'vin'=>'',
            'colour'=>'',
            'description'=>'',
            'color'=>'',
        ]);


        $car = Car::find($id);
        $car->id_carbrand = $req->id_carbrand;
        $car->id_carmodel = $req->id_carmodel;
        $car->production_year = $req->production_year;
        $car->plate_number = $req->plate_number;
        $car->vin = $req->vin;
        $car->colour = $req->colour;
        $car->description = $req->description;
        $car->color = $req->color;
        $car->save();

        DB::table('events')
            ->where('id_car', $id)
            ->update(['color'=> $req->color]);
    }

    function getPhotos($id)
    {
        return DB::table('files')->where('id_car', $id)->get();
    }

    function deletePhoto($id)
    {
        $file = File::find($id);
        $file->delete();
    }

}
