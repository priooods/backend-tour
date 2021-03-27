<?php

namespace App\Http\Controllers;

use App\Models\MaskapaiUmrah;
use App\Models\Umrah;
use App\Models\Gudang;
// use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UmrahController extends Controller{
    public function add(Request $request){
        $statement = DB::select("SHOW TABLE STATUS LIKE 'umrahs'");
        $nextId = $statement[0]->Auto_increment;
        $request['code'] = $request->tahun."UMH".str_pad($nextId,6-floor(log10($nextId)),"0",STR_PAD_LEFT);

        if ($request->tanggal == null)
            return $this->responseFailure(1,'need tanggal field!');

        if ($request->hotel == null)
            return $this->responseFailure(1,'need hotel array field!');

        if ($request->maskapai == null)
            return $this->responseFailure(1,'need maskapai array field!');

            // return $this->responseFailure(1,'need aset array field!');

        $umrah = Umrah::create($request->toArray());
        $tanggal = $umrah->jadwal()->create($request->tanggal);
        $hotel = $umrah->hotels()->createMany($request->hotel);
        $maskapai = $umrah->maskapais()->createMany($request->maskapai);
        $aset = '';
        if ($request->aset != null){
            $aset = $request->aset;
            for ($i=0; $i < count($aset); $i++) {
                if (array_key_exists('nama',$aset[$i])){
                    $gudang = Gudang::where('nama',$aset[$i]['nama'])->first();
                    if ($gudang != null)
                        $aset[$i]['gudang_id'] = $gudang->id;
                    else
                        $aset[$i]['gudang_id'] = Gudang::create($aset[$i])->id;
                }
            }
            $aset = $umrah->asets()->createMany($aset);
        }
        return $this->responseData([$umrah,$tanggal,$hotel,$maskapai,$aset]);
    }

    public function show(Request $request){
        try {
            if ($request->id ==null)
               return $this->responseData(Umrah::all());
            $umrah = Umrah::find($request->id);

            $umrah->jadwal;
            $umrah->hotel;
            // foreach ($umrah->hotel as $hotel) {
            //      $hotel->kamar;
            // }
            // foreach ($umrah->hotel as $hotel) {
            //      $hotel->tanggal;
            // }
            $umrah->aset;
            $umrah->maskapai;
            // foreach($umrah->aset as $aset)
            //     $aset->aset;
            return $this->responseData($umrah);
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }

    protected function update(Request $request){
        try {
            $umrah = Umrah::find($request->id);
            $umrah->update($request->toArray());
            if ($request->tanggal != null)
                $umrah->jadwal()->update($request->tanggal);

            if ($request->hotel != null)
                foreach($request->hotel as $data){
                    $umrah->hotel()->firstOrCreate($data);
                }
                // $umrah->hotels()->createMany($request->hotel);

            if ($request->maskapai != null)
                foreach($request->maskapai as $data){
                    $umrah->maskapais()->firstOrCreate($data);
                }
                // $umrah->maskapais()->createMany($request->maskapai);

            return $this->responseText('update successfully!');
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }
    // protected function delete_maskapai(Request $request){
    //     try {
    //         MaskapaiUmrah::where('umrah_id',$request->umrah_id)->where('maskapai_id',$request->maskapai_id)->delete();
    //         return $this->responseText('delete successfully!');
    //     } catch (\Throwable $th) {
    //         return $this->responseTryFail();
    //     }
    // }
    // protected function delete_hotel(Request $request){
    //     try {
    //         MaskapaiUmrah::where('hotel_id',$request->umrah_id)->where('maskapai_id',$request->maskapai_id)->delete();
    //         return $this->responseText('delete successfully!');
    //     } catch (\Throwable $th) {
    //         return $this->responseTryFail();
    //     }
    // }
}
