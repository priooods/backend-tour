<?php

use App\Http\Controllers\AkuntanController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\BelanjaControll;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\UmrahController;
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
Route::post('mitra/add', [MitraController::class, 'register']);
Route::get('mitra/all', [MitraController::class, 'all']);
Route::post('mitra/login', [MitraController::class, 'login']);
Route::post('mitra/find', [MitraController::class, 'find']);
Route::post('mitra/trackagent', [MitraController::class, 'trackAgent']);
Route::post('mitra/trackmitra', [MitraController::class, 'trackMitra']);
Route::post('mitra/delete', [MitraController::class, 'delete']);
Route::post('mitra/logout', [MitraController::class, 'logout']);
Route::post('mitra/update', [MitraController::class, 'update']);
Route::get('test', function () {
    dd('Testing');
});
Route::post('operator/login', [OperatorController::class, 'login']);
Route::post('operator/add', [OperatorController::class, 'register']);
Route::get('operator/all', [OperatorController::class, 'all']);
Route::post('operator/find', [OperatorController::class, 'find']);
Route::post('operator/logout', [OperatorController::class, 'logout']);
Route::post('operator/delete', [OperatorController::class, 'delete']);
Route::post('operator/update', [OperatorController::class, 'update']);

Route::post('cabang/add', [CabangController::class, 'Add']);
Route::post('cabang/update', [CabangController::class, 'update']);
Route::post('cabang/find', [CabangController::class, 'find']);
Route::get('cabang/all', [CabangController::class, 'findall']);
Route::post('cabang/delete', [CabangController::class, 'delete']);

//Akuntan
Route::post('akuntan/add', [AkuntanController::class, 'Add']);
Route::post('akuntan/update', [AkuntanController::class, 'Update']);
Route::get('akuntan/all', [AkuntanController::class, 'all']);

//umrah
Route::post('umrah/add', [UmrahController::class, 'Add']);
Route::get('umrah/all', [UmrahController::class, 'getAll']);
Route::post('umrah/update', [UmrahController::class, 'Update']);

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