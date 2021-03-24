<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Crypt;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function responUserSuccess($data)
    {
        $data->password = Crypt::decrypt($data->password);
        return response()->json([
            'error_code' => 0,
            'data' => $data
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    protected function responseData($data){
        return response()->json([
            'error_code' => 0,
            'data' => $data,
        ], 200, [], JSON_NUMERIC_CHECK);
    }
    protected function responseText($message){
        return response()->json([
            'error_code' => 0,
            'message' => $message
        ]);
    }

    protected function responseFailure($code, $message){
        return response()->json([
            'error_code' => $code,
            'message' => $message,
        ]);
    }
    protected function responseTryFail(){
        return response()->json([
            'error_code' => 1,
            'message' => 'Gagal melakukan permintaan! Silahkan coba lagi!',
        ]);
    }
}
