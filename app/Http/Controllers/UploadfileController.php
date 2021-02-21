<?php

namespace App\Http\Controllers;

use App\Models\Carbrand;
use App\Models\File;
use Illuminate\Http\Request;
use DB;

class UploadfileController extends Controller
{
    function upload()
    {
        $folderPath = "/Users/lukasz/Desktop/angular/auta/src/assets/img/cars/";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        foreach ($request->fileSource as $key => $value) {

            $image_parts = explode(";base64,", $value);

            $image_type_aux = explode("image/", $image_parts[0]);

            $image_type = $image_type_aux[1];

            $image_base64 = base64_decode($image_parts[1]);

            $file_uniq_id = uniqid() . '.'.$image_type;

            $file = $folderPath . $file_uniq_id;

            file_put_contents($file, $image_base64);

            $statement = DB::select("SHOW TABLE STATUS LIKE 'cars'");
            $nextId = $statement[0]->Auto_increment;
            $file = new file();
            $file->file_name = $file_uniq_id;
            $file->id_car= $nextId;
            $file->save();

        }
    }


    function editUpload(Request $req)
    {
        $folderPath = "/Users/lukasz/Desktop/angular/auta/src/assets/img/cars/";
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);

        foreach ($request->fileSource as $key => $value) {

            $image_parts = explode(";base64,", $value);

            $image_type_aux = explode("image/", $image_parts[0]);

            $image_type = $image_type_aux[1];

            $image_base64 = base64_decode($image_parts[1]);

            $file_uniq_id = uniqid() . '.'.$image_type;

            $file = $folderPath . $file_uniq_id;

            file_put_contents($file, $image_base64);

            $statement = DB::select("SHOW TABLE STATUS LIKE 'cars'");
            $nextId = $statement[0]->Auto_increment;
            $file = new file();
            $file->file_name = $file_uniq_id;
            $file->id_car= $req->id_car;
            $file->save();

        }
    }
}
