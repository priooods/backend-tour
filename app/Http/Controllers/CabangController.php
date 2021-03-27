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
            $request['code'] = date("Y")."CBG".str_pad($nextId,6-floor(log10($nextId)),"0",STR_PAD_LEFT);

            $check = cabang::where('name', $request->name)->first();
            if ($check)
                return $this->responseFailure(1,'Nama Cabang tersebut sudah terdaftar. Harap ganti dengan nama lain !');
            $user = cabang::create($request->toArray());
            return $this->responseData($user);
        } catch (Exception $th) {
            return $this->responseTryFail();
        }
    }

    protected function show(Request $request){
        try {
            if ($request->name == null)
                return $this->responseData(Cabang::all());

            $user = cabang::where('name', $request->name)->first();
            // $mitra = DB::table('mitras')->where('cabang_id', $user->id)->get();
            if (empty($user))
                return $this->responseFailure(1,'Data Cabang tidak ditemukan. Periksa kembali code yang anda masukan !');

            $user->mitra;
            return $this->responseData($user);
        } catch (Exception $th) {
            return $this->responseTryFail();
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
            return $this->responseData($user);
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }

    protected function delete(Request $request){
        try {
            $user = cabang::where('name',$request->name)->first();
            if (is_null($user))
                return $this->responseFailure(1,'Data Cabang tidak ditemukan. Periksa kembali code yang anda masukan !',);
            $user->delete();
            return $this->responseText('Berhasil menghapus data cabang. Semua data tentang cabang telah dihapus !');
        } catch (Exception $th) {
            return $this->respondFailure();
        }
    }
}
