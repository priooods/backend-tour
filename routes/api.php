<?php

use App\Http\Controllers\AkuntanController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\BelanjaControll;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\UmrahController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\JamaahController;
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
//MITRA
Route::post('mitra/add', [MitraController::class, 'register']);
Route::get('mitra/show', [MitraController::class, 'show']);
Route::post('mitra/login', [MitraController::class, 'login']);
Route::post('mitra/trackagent', [MitraController::class, 'trackAgent']);
Route::post('mitra/trackmitra', [MitraController::class, 'trackMitra']);
Route::post('mitra/delete', [MitraController::class, 'delete']);
Route::post('mitra/logout', [MitraController::class, 'logout']);
Route::post('mitra/update', [MitraController::class, 'update']);
Route::post('mitra/fee', [MitraController::class, 'fee']);

Route::post('cabang/add', [CabangController::class, 'Add']);
Route::post('cabang/update', [CabangController::class, 'update']);
Route::get('cabang/show', [CabangController::class, 'show']);
Route::post('cabang/delete', [CabangController::class, 'delete']);

//OPERATOR
Route::post('operator/login', [OperatorController::class, 'login']);
Route::post('operator/add', [OperatorController::class, 'register']);
Route::get('operator/show', [OperatorController::class, 'show']);
Route::post('operator/logout', [OperatorController::class, 'logout']);
Route::post('operator/delete', [OperatorController::class, 'delete']);
Route::post('operator/update', [OperatorController::class, 'update']);

//Hotel
Route::post('hotel/add',[HotelController::class,'add']);
Route::post('hotel/update',[HotelController::class,'update']);
Route::get('hotel/show',[HotelController::class,'show']);
Route::post('hotel/delete',[HotelController::class,'delete']);
Route::post('kamar/update',[HotelController::class,'update_kamar']);
Route::post('kamar/delete',[HotelController::class,'delete_kamar']);

//Umrah
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

//Jamaah
Route::post('jamaah/add', [JamaahController::class, 'add']);
Route::post('jamaah/bayar', [JamaahController::class, 'bayar']);
Route::post('pesanan/update', [JamaahController::class, 'update_pesanan']);
Route::post('jamaah/update', [JamaahController::class, 'update']);
Route::get('jamaah/tagihan', [JamaahController::class, 'tagihan']);
Route::get('jamaah/lunas', [JamaahController::class, 'lunas']);
Route::get('jamaah/show', [JamaahController::class, 'show']);
Route::post('jamaah/delete', [JamaahController::class, 'delete']);

//Belanja
Route::post('belanja/add', [BelanjaControll::class, 'add']);
Route::get('belanja/show', [BelanjaControll::class, 'show']);
Route::post('belanja/cancel', [BelanjaControll::class, 'cancel']);
