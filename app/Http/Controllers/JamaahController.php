<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Jamaah;
use App\Models\Mitra;
use App\Models\Umrah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JamaahController extends Controller
{
    public function Add(Request $request){

        //khusus method untuk jamaah table
        $statement = DB::select("SHOW TABLE STATUS LIKE 'jamaahs'");
        $nextId = $statement[0]->Auto_increment;
        $request['code'] = date("Y")."JMH".str_pad($nextId,6-floor(log10($nextId)),"0",STR_PAD_LEFT);
        
        $jamaah = Jamaah::create($request->toArray());

        //dicheck untuk update keuangan
        $akuntan = DB::table('akuntans')->where('id', 1)->first();
        $akuntan->pemasukan_jamaah = $akuntan->pemasukan_jamaah + $request->biaya_dibayar;

        $mitra = DB::table('mitras')->where('fullname', $request->nama_mitra)->first();
        if ($mitra->code_agent != null) {
            $akuntan->fee_mitra = $akuntan->fee_mitra + 2200000;
        } else {
            $akuntan->fee_mitra = $akuntan->fee_mitra + 2000000;
        }

        $akuntan->update();

        //Update kuota umrah yg tersedia
        if ($jamaah->paket_umrah != 0) {
            $umrah = DB::table('jamaahs')->where('nama', $jamaah->paket_umrah)->first();
            $umrah->kuota = $umrah->kuota - 1;   
            $umrah->update();
        }

        return $this->responseSuccess($jamaah);
    }

    public function detail(Request $request){
        $jamaah = DB::table('jamaahs')->where('id', $request->id)->first();
        if (is_null($jamaah)) {
            return response()->json([
                'error_code' => 1,
                'error_data' => 'Jammah yang anda cari tidak ditemukan !',
            ], 200, [], JSON_NUMERIC_CHECK);
        }

        $alls = DB::table('jamaahs')->where('id', $request->id)
                ->join('umrahs', 'umrahs.nama', '=', $jamaah->paket_umrah)
                ->join('asets', 'asets.code_jamaah', '=', $jamaah->code)->get();

        if ($jamaah->paket_umrah != null) {
            return response()->json([
                'error_code' => 0,
                'error_data' => '',
                'data' => $alls
            ], 200, [], JSON_NUMERIC_CHECK);
        }

        return $this->responseSuccess($jamaah);
    }

    public function all(){
        return response()->json([
            'error_code' => 0,
            'error_data' => '',
            'data' => Jamaah::all()
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    public function delete(Request $request){
        $jamaah = Jamaah::where('id', $request->id)->first();

        $aset = Aset::where('code_agent', $jamaah->code_agent)->first();
        $aset->delete();
    }

    public function responseSuccess($data){
        return response()->json([
            'error_code' => 0,
            'error_data' => '',
            'data' => $data
        ], 200, [], JSON_NUMERIC_CHECK);
    }
}
