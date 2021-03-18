<?php

namespace App\Http\Controllers;

use App\Models\Umrah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UmrahController extends Controller
{
    public function Add(){
        $umrah = new Umrah();
        $umrah->nama = request('nama');
        $umrah->durasi = request('durasi');
        $umrah->jenis_paket = request('jenis_paket');
        $umrah->tahun = request('tahun');
        $umrah->kuota = request('kuota');
        $umrah->tgl_berangkat = request('tgl_berangkat');
        $umrah->tgl_pulang = request('tgl_pulang');
        $umrah->hotel_mekkah = request('hotel_mekkah');
        $umrah->hotel_madinah = request('hotel_madinah');
        $umrah->jenis_kamar = request('jenis_kamar');
        $umrah->biaya = request('biaya');
        $umrah->maskapai = request('maskapai');
        $statement = DB::select("SHOW TABLE STATUS LIKE 'umrahs'");
        $nextId = $statement[0]->Auto_increment;
        $umrah->code = date("Y")."UMH".str_pad($nextId,6-floor(log10($nextId)),"0",STR_PAD_LEFT);
        
        $umrah->save();
        return $this->responseSuccess($umrah);
    }

    public function getAll(){
        return $this->responseSuccess(Umrah::all());
    }

    public function Update(Request $request){

        $data = Umrah::where('id', $request->id)->first();
        if (is_null($data)) {
            return response()->json([
                'error_code' => 1,
                'error_data' => 'Mohon maaf data paket umrah yang anda cari tidak ditemukan !'
            ]);
        }

        if(!is_null($request->nama)) $data->nama = $request->nama;
        if(!is_null($request->durasi)) $data->durasi = $request->durasi;
        if(!is_null($request->jenis_paket)) $data->jenis_paket = $request->jenis_paket;
        if(!is_null($request->tahun)) $data->tahun = $request->tahun;
        if(!is_null($request->kuota)) $data->kuota = $request->kuota;
        if(!is_null($request->tgl_berangkat))$data->tgl_berangkat = $request->tgl_berangkat;
        if(!is_null($request->tgl_pulang))$data->tgl_pulang = $request->tgl_pulang;
        if(!is_null($request->hotel_mekkah))$data->hotel_mekkah = $request->hotel_mekkah;
        if(!is_null($request->hotel_madinah))$data->hotel_madinah = $request->hotel_madinah;
        if(!is_null($request->jenis_kamar))$data->jenis_kamar = $request->jenis_kamar;
        if(!is_null($request->biaya))$data->biaya = $request->biaya;
        if(!is_null($request->maskapai))$data->maskapai = $request->maskapai;
        $data->update();
        return $this->responseSuccess($data);
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
}
