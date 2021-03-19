<?php

namespace App\Http\Controllers;

use App\Models\Akuntan;
use App\Models\Belanja;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BelanjaControll extends Controller
{
    public function Add(Request $request){
        $belanja = Belanja::create($request->toArray());
        $kas = Akuntan::where('id', 1)->first();
        $kas->kas = $kas->kas - $request->total;
        $kas->update();
        return $this->responseSuccess($belanja);
    }

    public function all(){
        return response()->json([
            'error_code' => 0,
            'error_data' => '',
            'data' => Belanja::all()
        ]);
    }

    public function find(Request $request){
        $belanja = DB::table('belanjas')->where('id', $request->id)->first();
        return $this->responseSuccess($belanja);
    }

    public function respondFailure(){
        return response()->json([
            'error_code' => 1,
            'error_data' => 'Harap periksa kembali koneksi internet anda !',
        ]);
    }

    public function responseSuccess($data){
        return response()->json([
            'error_code' => 0,
            'error_data' => '',
            'data' => $data
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function show(Request $request){
        $data = Belanja::find($request->id);
        $item = $data->my_belanja;
        foreach($item as $e){
            $e->my_item;
        }
        return $this->responseSuccess($data);
    }
    public function item(Request $request){
        $data = Belanja::find($request->id);
        $item = $data->my_belanja;
        $list = array();
        foreach($item as $e){
            // ;
            array_push($list,$e->my_item);
        }

        return $this->responseSuccess($list);
    }
}
