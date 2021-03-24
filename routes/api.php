<?php

use App\Http\Controllers\AkuntanController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\BelanjaControll;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\UmrahController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\MaskapaiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('test', function () {
    echo 'Testing';
});
Route::post('mitra/add', [MitraController::class, 'register']);
Route::get('mitra/show', [MitraController::class, 'show']);
Route::post('mitra/login', [MitraController::class, 'login']);
Route::post('mitra/trackagent', [MitraController::class, 'trackAgent']);
Route::post('mitra/trackmitra', [MitraController::class, 'trackMitra']);
Route::post('mitra/delete', [MitraController::class, 'delete']);
Route::post('mitra/logout', [MitraController::class, 'logout']);
Route::post('mitra/update', [MitraController::class, 'update']);

Route::post('operator/login', [OperatorController::class, 'login']);
Route::post('operator/add', [OperatorController::class, 'register']);
Route::get('operator/show', [OperatorController::class, 'show']);
Route::post('operator/logout', [OperatorController::class, 'logout']);
Route::post('operator/delete', [OperatorController::class, 'delete']);
Route::post('operator/update', [OperatorController::class, 'update']);

Route::post('cabang/add', [CabangController::class, 'Add']);
Route::post('cabang/update', [CabangController::class, 'update']);
Route::get('cabang/show', [CabangController::class, 'show']);
Route::post('cabang/delete', [CabangController::class, 'delete']);

//Akuntan
Route::post('akuntan/add', [AkuntanController::class, 'Add']);
Route::post('akuntan/update', [AkuntanController::class, 'Update']);
Route::get('akuntan/all', [AkuntanController::class, 'all']);

//Hotel
Route::post('hotel/add',[HotelController::class,'add']);
Route::post('hotel/update',[HotelController::class,'update']);
Route::get('hotel/show',[HotelController::class,'show']);
Route::post('hotel/delete',[HotelController::class,'delete']);
Route::post('kamar/update',[HotelController::class,'update_kamar']);
Route::post('kamar/delete',[HotelController::class,'delete_kamar']);

//umrah
Route::post('umrah/add', [UmrahController::class, 'add']);
Route::get('umrah/show', [UmrahController::class, 'show']);
Route::post('umrah/update', [UmrahController::class, 'update']);
Route::post('umrah/del_maskapai', [UmrahController::class, 'delete_maskapai']);
Route::post('umrah/del_hotel', [UmrahController::class, 'delete_hotel']);
//Maskapai
Route::post('maskapai/add',[MaskapaiController::class,'add']);
Route::post('maskapai/update',[MaskapaiController::class,'update']);
Route::get('maskapai/show',[MaskapaiController::class,'show']);
Route::post('maskapai/delete',[MaskapaiController::class,'delete']);

//Gudang
Route::post('aset/add', [AsetController::class, 'addAset']);
Route::post('aset/update', [AsetController::class, 'UpdateAset']);

//Belanja
Route::post('belanja/add', [BelanjaControll::class, 'Add']);
Route::post('belanja/find', [BelanjaControll::class, 'find']);
Route::get('belanja/all', [BelanjaControll::class, 'all']);
Route::get('belanja/test', [BelanjaControll::class, 'show']);
Route::get('belanja/item',[BelanjaControll::class, 'item']);

Route::post('aset/beli',[AsetController::class,'beli']);


//Akuntan
// Route::post('akuntan/add', [AkuntanController::class, 'Add']);
