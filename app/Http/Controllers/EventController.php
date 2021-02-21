<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Event;
use Illuminate\Http\Request;
use DB;

class EventController extends Controller
{
    function getEvents()
    {
        $query= "SELECT events.*, cars.plate_number, cars.vin, carbrands.carbrand_name, carmodels.carmodel_name, users.username FROM events, cars, carbrands, carmodels, users
        WHERE events.id_car=cars.id_car AND cars.id_carbrand=carbrands.id_carbrand AND cars.id_carmodel=carmodels.id_carmodel AND users.id_user=events.id_user";
        $result = DB::select($query);
        return $result;

    }
    function getEventsForCalendar()
    {
        $query= "SELECT events.start, DATE_ADD(events.end, INTERVAL 1 DAY) AS end, events.id_event, events.title, events.id_car, events.created_at, events.updated_at, events.color, events.url, events.id_user, cars.plate_number, cars.vin, carbrands.carbrand_name, carmodels.carmodel_name, users.username FROM events, cars, carbrands, carmodels, users
        WHERE events.id_car=cars.id_car AND cars.id_carbrand=carbrands.id_carbrand AND cars.id_carmodel=carmodels.id_carmodel AND users.id_user=events.id_user";
        $result = DB::select($query);
        return $result;
    }
    function getFreeCars()
    {
        return DB::table('cars')
            ->select('carbrands.carbrand_name', 'carmodels.carmodel_name', 'cars.*')
            ->join('carbrands', 'cars.id_carbrand', 'carbrands.id_carbrand')
            ->join('carmodels', 'cars.id_carmodel', 'carmodels.id_carmodel')
            ->get();
    }

    function storeEvent(Request $req)
    {
        $req->validate([
            'start'=>'required',
            'end'=>'required',
            'id_car'=>'required',
        ]);

        $color_query = DB::table('cars')
            ->select('cars.color')
            ->where('cars.id_car', '=', $req->id_car)
            ->get();
        $color = $color_query[0]->color;


        $car = DB::table('cars')
            ->select('carbrands.carbrand_name', 'carmodels.carmodel_name', 'cars.*')
            ->join('carbrands', 'cars.id_carbrand', 'carbrands.id_carbrand')
            ->join('carmodels', 'cars.id_carmodel', 'carmodels.id_carmodel')
            ->where('id_car', $req->id_car)
            ->get();

        $title = $car[0]->carbrand_name.' | '.$car[0]->carmodel_name.' | '.$car[0]->plate_number.' | '.$car[0]->vin;

        $event = new Event;
        $event->title = $title;
        $event->start = $req->start;
        $event->end = $req->end;
        $event->id_car = $req->id_car;
        $event->color = $color;
        $event->url = '/cars/viewcar/'.$car[0]->id_car;
        $event->id_user = $req->id_user;
        $event->save();
    }

    function freeCars(Request $req)
    {
    $start_date=$req->start_date;
    $end_date=$req->end_date;
    $query = "SELECT cars.id_car, cars.plate_number, cars.vin, cars.color, carbrands.carbrand_name, carmodels.carmodel_name FROM cars
    JOIN carbrands on cars.id_carbrand=carbrands.id_carbrand
    JOIN carmodels on cars.id_carmodel=carmodels.id_carmodel
    WHERE cars.id_car
    not in (SELECT cars.id_car FROM cars JOIN events on cars.id_car=events.id_car WHERE (events.end>='$start_date' AND events.start<='$end_date'))";
    $result = DB::select($query);
    return $result;
    }

    function deleteEvent($id)
    {
        $event = Event::find($id);
        $event->delete();
    }

    function eventsInDate(Request $req)
    {
        $start_date=$req->start;
        $end_date=$req->end;
        return DB::table('events')
            ->select('events.*', 'users.username')
            ->join('users', 'events.id_user', 'users.id_user')
            ->where('end','>=', $start_date)
            ->where('start','<=', $end_date)
            ->orderBy('start','DESC')
            ->get();
    }

    function EventsByCar(Request $req)
    {
        $id_car=$req->id_car;
        return DB::table('events')
            ->select('events.*', 'users.username')
            ->join('users', 'events.id_user', 'users.id_user')
            ->where('id_car','=', $id_car)
            ->orderBy('start','DESC')
            ->get();
    }

    function getReturnedCars(Request $req)
    {
        $return_date=$req->return_date;
        $query="SELECT events.start, events.end, events.id_car, cars.plate_number, cars.vin, cars.production_year, cars.colour, carmodels.carmodel_name, carbrands.carbrand_name FROM events, cars, carmodels, carbrands
WHERE events.id_car=cars.id_car AND cars.id_carbrand=carbrands.id_carbrand AND cars.id_carmodel=carmodels.id_carmodel AND events.end='$return_date'";
        $result = DB::select($query);
        return $result;
    }



}
