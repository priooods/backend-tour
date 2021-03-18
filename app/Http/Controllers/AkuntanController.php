<?php

namespace App\Http\Controllers;

use App\Models\Akuntan;
use Illuminate\Http\Request;

class AkuntanController extends Controller
{
    public function Add(Request $request){
        try {
            $akuntan = Akuntan::create($request->toArray());
            return $this->responseSuccess($akuntan);
        } catch (\Throwable $th) {
            return $this->respondFailure();
        }
    }

    public function Update(Request $request){
        $akuntan = Akuntan::where('id', 1)->first();
        if (!is_null($request->kas)) $akuntan->kas = $akuntan->kas + $request->kas;
        $akuntan->update();
        return $this->responseSuccess($akuntan);
    }

    public function all(){
        return $this->responseSuccess(Akuntan::all());
    }

    public function respondFailure()
    {
        return response()->json([
            'error_code' => 1,
            'error_data' => 'Harap periksa kembali koneksi internet anda !',
        ]);
    }

    public function responseSuccess($data)
    {
        return response()->json([
            'error_code' => 0,
            'error_data' => '',
            'data' => $data
        ], 200, [], JSON_NUMERIC_CHECK);
    }
}
