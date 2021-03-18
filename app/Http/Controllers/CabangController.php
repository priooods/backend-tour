<?php

namespace App\Http\Controllers;

use App\Models\cabang;
use App\Models\Mitra;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CabangController extends Controller
{
    protected function Add(Request $request){
        try {
            $statement = DB::select("SHOW TABLE STATUS LIKE 'cabangs'");
            $nextId = $statement[0]->Auto_increment;
            $request['code_cabang'] = date("Y")."CBG".str_pad($nextId,6-floor(log10($nextId)),"0",STR_PAD_LEFT);
            
            $check = cabang::where('name', $request->name)->first();
            if ($check) {
                return response()->json([
                    'error_code' => 1,
                    'error_data' => "Nama Cabang tersebut sudah terdaftar. Harap ganti dengan nama lain !",
                ]);
            }
            $user = cabang::create($request->toArray());
            return $this->responseSuccess($user);
        } catch (Exception $th) {
            return $this->respondFailure();
        }
    }

    protected function findall(){
        try {
            return $this->responseSuccess(cabang::all());
        } catch (\Throwable $th) {
            return $this->respondFailure();
        }
    }

    protected function find(Request $request){
        try {
            $request->validate([
                'name' => 'required'
            ]);

            $user = cabang::where('name', $request->name)->first();
            $mitra = DB::table('mitras')->where('cabang', $user->kota)->get();
            if (empty($user)) {
                return response([
                    'error_code' => 1,
                    'error_data' => 'Data Cabang tidak ditemukan. Periksa kembali code yang anda masukan !'
                ]);
            }
            return response()->json([
                'error_code' => 0,
                'error_data' => '',
                'data' => [
                    'cabang' => $user,
                    'mitra' => $mitra
                ]
            ]);
        } catch (Exception $th) {
            return $this->respondFailure();
        }
    }

    protected function update(Request $request){

        try {
            $user = cabang::where('name',$request->name)->first();
            if (!is_null($request->name)) $user->name = $request->name;
            if (!is_null($request->alamat)) $user->alamat = $request->alamat;
            if (!is_null($request->kota)) $user->kota = $request->kota;
            if (!is_null($request->provinsi)) $user->provinsi = $request->provinsi;
            if (!is_null($request->cabang)) $user->cabang = $request->cabang;
            $user->update();
            return $this->responseSuccess($user);
        } catch (\Throwable $th) {
            return $this->respondFailure();
        }
    }

    protected function delete(Request $request)
    {
        try {
            $user = cabang::find($request->name);
            if (is_null($user))
                return response()->json([
                    'error_code' => 1,
                    'error_data' => 'Data Cabang tidak ditemukan. Periksa kembali code yang anda masukan !',
                ]);
            $user->delete();
            return response()->json([
                'error_code' => 0,
                'error_data' => 'Berhasil menghapus data cabang. Semua data tentang cabang telah dihapus !',
            ]);
        } catch (Exception $th) {
            return $this->respondFailure();
        }
    }

    
    protected function respondFailure()
    {
        return response()->json([
            'error_code' => 1,
            'error_data' => 'Harap periksa kembali koneksi internet anda !',
        ]);
    }

    protected function responseSuccess($data)
    {
        return response()->json([
            'error_code' => 0,
            'error_data' => '',
            'data' => [
                'id' => $data->id,
                'code_cabang' => $data->code_cabang,
                'name' => $data->name,
                'alamat' => $data->alamat,
                'kota' => $data->kota,
                'provinsi' => $data->provinsi,
            ],
        ]);
    }
}
