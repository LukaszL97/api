<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarbrandController;
use App\Http\Controllers\CarmodelController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\UploadfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ChangePasswordController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', function (){
    return view('welcome');
});
//Route::view('add', 'addmember');
//Route::post('add',[MemberController::class, 'addData']);

Route::get('/user', [UserController::class, 'getUsers']);
Route::get('/user/{id}', [UserController::class, 'getUser']);
Route::post('/user', [UserController::class, 'storeUser']);
Route::delete('/user/{id}', [UserController::class, 'deleteUser']);
Route::put('/user/{id}', [UserController::class, 'editUser']);
Route::post('/login', [AuthController::class, 'login']);
Route::put('/password/{id}', [PasswordController::class, 'editPassword']);
Route::post('/sendpasswordreset', [ResetPasswordController::class, 'sendPasswordEmail']);
Route::post('/changepassword', [ChangePasswordController::class, 'changePassword']);


Route::post('/carbrand', [CarbrandController::class, 'storeCarbrand']);
Route::get('/carbrand', [CarbrandController::class, 'getCarbrands']);
Route::delete('/carbrand/{id}', [CarbrandController::class, 'deleteCarbrand']);
Route::put('/carbrand/{id}', [CarbrandController::class, 'editCarbrand']);
Route::get('/carbrand/{id}', [CarbrandController::class, 'getCarbrand']);

Route::get('/carmodel', [CarmodelController::class, 'getCarmodels']);
Route::get('/carmodel/{id}', [CarmodelController::class, 'getCarmodel']);
Route::post('/carmodel', [CarmodelController::class, 'storeCarmodel']);
Route::delete('/carmodel/{id}', [CarmodelController::class, 'deleteCarmodel']);
Route::put('/carmodel/{id}', [CarmodelController::class, 'editCarmodel']);
Route::post('/carbrandbyid', [CarmodelController::class, 'getCarbrandByID']);

Route::post('/car', [CarController::class, 'storeCar']);
Route::get('/car', [CarController::class, 'getCars']);
Route::delete('/car/{id}', [CarController::class, 'deleteCar']);
Route::get('/car/{id}', [CarController::class, 'getCar']);
Route::put('/car/{id}', [CarController::class, 'editCar']);
Route::post('/upload', [UploadfileController::class, 'upload']);
Route::post('/editupload', [UploadfileController::class, 'editUpload']);
Route::get('/photos/{id}', [CarController::class, 'getPhotos']);
Route::delete('/photo/{id}', [CarController::class, 'deletePhoto']);

Route::get('/event', [EventController::class, 'getEvents']);
Route::get('/eventsforcalendar', [EventController::class, 'getEventsForCalendar']);
Route::get('/eventcar', [EventController::class, 'getFreeCars']);
Route::post('/event', [EventController::class, 'storeEvent']);
Route::post('/getfreecars', [EventController::class, 'getFreeCars']);
Route::post('/freecars', [EventController::class, 'freeCars']);
Route::post('/freecars', [EventController::class, 'freeCars']);
Route::delete('/event/{id}', [EventController::class, 'deleteEvent']);
Route::post('/eventsindate', [EventController::class, 'eventsInDate']);
Route::post('/eventsbycar', [EventController::class, 'EventsByCar']);
Route::post('/colorbycar', [EventController::class, 'getColorByCar']);
Route::post('/getreturnedcars', [EventController::class, 'getReturnedCars']);
