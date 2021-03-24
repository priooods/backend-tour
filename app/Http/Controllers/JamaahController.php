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
        try {
            $statement = DB::select("SHOW TABLE STATUS LIKE 'jamaahs'");
            $nextId = $statement[0]->Auto_increment;
            $request['code'] = date("Y")."JMH".str_pad($nextId,6-floor(log10($nextId)),"0",STR_PAD_LEFT);
            $jamaah = Jamaah::create($request->toArray());
            return $this->responseData($jamaah);
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }

    public function show(Request $request){
        if ($request->id == null)
            return $this->responseData(Jamaah::all());
        $jamaah = DB::table('jamaahs')->find($request->id);
        if (is_null($jamaah)) {
            $this->responseFailure(1,'Jammah yang anda cari tidak ditemukan !');
        }

        // $alls = DB::table('jamaahs')->where('id', $request->id)
        //         ->join('umrahs', 'umrahs.nama', '=', $jamaah->paket_umrah)
        //         ->join('asets', 'asets.code_jamaah', '=', $jamaah->code)->get();

        return $this->responseData($jamaah);
    }

    public function delete(Request $request){
        try {
            Jamaah::find($request->id)->delete();
            return $this->responseText('Jamaah berhasil dihapus!');
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }
}
