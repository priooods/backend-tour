<?php

namespace App\Http\Controllers;

use App\Models\Jamaah;
use App\Models\Umrah;
use App\Models\Pesanan;
use App\Models\Akuntan;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JamaahController extends Controller
{
    public function add(Request $request){
        try {
            $statement = DB::select("SHOW TABLE STATUS LIKE 'jamaahs'");
            $nextId = $statement[0]->Auto_increment;
            $array = $request->toArray();

            $array['code'] = date("Y")."JMH".str_pad($nextId,6-floor(log10($nextId)),"0",STR_PAD_LEFT);
            $umrah = Umrah::find($request->umrah_id);
            if ($umrah == null)
                return $this->responseFailure(1,'umrah id is not found!');

            $array['jadwal_id'] = $umrah->jadwal->id;
            $pesan = Pesanan::create($array);
            $jamaah = $pesan->jamaah()->create($array);
            $this->gudang_decrement($umrah->asets, $array);
            $jamaah->passport()->create($request->passport);
            return $this->responseText('create jamaah success!');
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }
    function gudang_decrement($asets, $array){
        foreach($asets as $i){
            if ($i->condition !=null){
                $cond = explode(",",$i->condition);
                if ($array[$cond[0]] != $cond[1]){
                    continue;
                }
            }
            Gudang::find($i['gudang_id'])->decrement('stok');
        }
    }
    function gudang_increment($asets, $array){
        foreach($asets as $i){
            if ($i->condition !=null){
                $cond = explode(",",$i->condition);
                if ($array[$cond[0]] != $cond[1]){
                    continue;
                }
            }
            Gudang::find($i['gudang_id'])->increment('stok');
        }
    }
    public function update(Request $request){
        try {
            $jamaah = Jamaah::find($request->id);
            if ($jamaah == null)
                return $this->responseFailure(1,'jamaah id is not found!');
            $array = $request->toArray();

            $jamaah->update($request->toArray());
            if ($request->passport !=null)
                $jamaah->passport()->update($request->passport);
            return $this->responseData($array);
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }
    public function update_pesanan(Request $request){
        $pesanan = Pesanan::find($request->id);

        if ($request->umrah_id != null){
            if ($request->umrah_id == $pesanan->umrah_id)
                return $this->responseFailure(1,"umrah_id is same as before!");

            $oldumrah = Umrah::find($pesanan->umrah_id);
            $umrah = Umrah::find($request->umrah_id);
            foreach($pesanan->jamaah as $jamaah){
                $this->gudang_increment($oldumrah->asets, $jamaah);
                $this->gudang_decrement($umrah->asets, $jamaah);
            }
            $pesanan->umrah_id = $umrah->id;
            $pesanan->jadwal_id = $umrah->jadwal->id;
        }
        $array = $request->toArray();
        unset($array['mitra_id']);
        $pesanan->update($array);
        return $this->responseData('pesanan updated successfully!');
    }

    public function bayar(Request $request){
        try {
            $pesanan = Pesanan::find($request->id);
            $pesanan->increment('bayar',$request->bayar);
            $saldo = 0;
            try {
                $saldo = Akuntan::all()->last()->saldo;
            } catch (\Throwable) {}
            $akuntan = Akuntan::create([
                'jamaah_id' => $pesanan->id,
                'keterangan' => 'Pembayaran Jamaah ('.$pesanan->jamaah->first()->nama_lengkap.'])',
                'masuk' => $request->bayar,
                'saldo' => $request->bayar + $saldo
            ]);
            return $this->responseData([$pesanan,$akuntan]);
        } catch (\Throwable) {
            return $this->responseTryFail();
        }
    }

    public function tagihan(){
        $pesanan = $this->check('>');
        return $this->responseData($pesanan);
    }

    public function lunas(){
        $pesanan = $this->check('<');
        return $this->responseData($pesanan);
    }

    function check($check){
        return Pesanan::select('id','umrah_id','bayar')->
        with([
            'umrah' => function($q){
                $q->select('nama','biaya','id');
            },
            'jamaah' => function($q){
                $q->select('code','id','nama_lengkap','pesanan_id');
            }
        ])->
        whereHas('umrah' , function($q) use ($check) {
            $q->where('biaya',$check,DB::raw('pesanans.bayar'));
        })
        ->get();
    }

    public function show(Request $request){
        if ($request->id == null)
            return $this->responseData(Jamaah::all());
        $jamaah = Jamaah::find($request->id);
        $jamaah->passport;
        $pesanan = $jamaah->pesanan;

        $asets = array();
        foreach($pesanan->aset as $i){
            if ($i->condition !=null){
                $cond = explode(",",$i->condition);
                if ($jamaah[$cond[0]] != $cond[1]){
                    continue;
                }
                array_push($asets, $i);
            }
            // unset($aset[$ind]);
        }
        $jamaah->aset = $asets;
        unset($pesanan->aset);
        $pesanan->umrah;
        $pesanan->jadwal;
        if (is_null($jamaah)) {
            $this->responseFailure(1,'Jamaah yang anda cari tidak ditemukan !');
        }
        return $this->responseData($jamaah);
    }

    public function delete(Request $request){
        try {
            Jamaah::find($request->id)->pesanan->delete();
            return $this->responseText('Jamaah berhasil dihapus!');
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }
}
