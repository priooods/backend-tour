<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Gudang;
use App\Models\Jamaah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsetController extends Controller
{
    public function addAset(Request $request){
        $jamaah = DB::table('jamaahs')->where('id', $request->id)->first();
        $request['code_jamaah'] = $jamaah->code;
        $aset = Aset::create($request->toArray());

        $gudang = DB::table('gudangs')->where('id', 1)->first();

        $gudang->mukena = $gudang->mukena - $aset->mukena;
        $gudang->syal = $gudang->syal - $aset->syal;
        $gudang->peci = $gudang->peci - $aset->peci;
        $gudang->kain = $gudang->kain - $aset->kain;
        $gudang->sabuk = $gudang->sabuk - $aset->sabuk;
        $gudang->koper = $gudang->koper - $aset->koper;
        $gudang->batik = $gudang->batik - $aset->batik;
        $gudang->jaket = $gudang->jaket - $aset->jaket;
        $gudang->tas_ransel = $gudang->tas_ransel - $aset->jaket;
        $gudang->update();

        return response()->json([
            'error_code' => 0,
            'error_data' => 'Jammah Berhasil diberikan fasilitas ! Segera kirimkan aset supaya tidak terlupakan',
        ], 200, [], JSON_NUMERIC_CHECK);

    }

    public function UpdateAset(Request $request){
        $jamaah = DB::table('jamaahs')->where('id', $request->id)->first();
        $aset = Aset::where('code_jamaah', $jamaah->code)->first();
        $gudang = DB::table('gudangs')->where('id', 1)->first();

        if(!is_null($request->koper)) 
            $aset->koper = $request->koper;
            $gudang->koper = $gudang->koper + $jamaah->koper;
            $gudang->koper = $gudang->koper - $request->koper;
        if(!is_null($request->mukena)) 
            $aset->mukena = $request->mukena;
            $gudang->mukena = $gudang->mukena + $jamaah->mukena;
            $gudang->mukena = $gudang->mukena - $request->mukena;
        if(!is_null($request->peci)) 
            $aset->peci = $request->peci;
            $gudang->peci = $gudang->peci + $jamaah->peci;
            $gudang->peci = $gudang->peci - $request->peci;
        if(!is_null($request->kain)) 
            $aset->kain = $request->kain;
            $gudang->kain = $gudang->kain + $jamaah->kain;
            $gudang->kain = $gudang->kain - $request->kain;
        if(!is_null($request->batik)) 
            $aset->batik = $request->batik;
            $gudang->batik = $gudang->batik + $jamaah->batik;
            $gudang->batik = $gudang->batik - $request->batik;
        if(!is_null($request->sabuk)) 
            $aset->sabuk = $request->sabuk;
            $gudang->sabuk = $gudang->sabuk + $jamaah->sabuk;
            $gudang->sabuk = $gudang->sabuk - $request->sabuk;
        if(!is_null($request->jaket)) 
            $aset->jaket = $request->jaket;
            $gudang->jaket = $gudang->jaket + $jamaah->jaket;
            $gudang->jaket = $gudang->jaket - $request->jaket;
        if(!is_null($request->tas_ransel)) 
            $aset->tas_ransel = $request->tas_ransel;
            $gudang->tas_ransel = $gudang->tas_ransel + $jamaah->tas_ransel;
            $gudang->tas_ransel = $gudang->tas_ransel - $request->tas_ransel;
        if(!is_null($request->syal)) 
            $aset->syal = $request->syal;
            $gudang->syal = $gudang->syal + $jamaah->syal;
            $gudang->syal = $gudang->syal - $request->syal;

        $aset->update();
        $gudang->update();

        return response()->json([
            'error_code' => 0,
            'error_data' => 'Aset Jammah Berhasil diberikan diupdate ! Refresh halaman untuk melihat data terbaru',
        ], 200, [], JSON_NUMERIC_CHECK);
        
    }

    public function beli(Request $request){
        $barang = $request->bid;
        $total = $request->total;
        
        Aset::create(['jamaah_id'=>$request->jid, 'gudang_id'=>$barang, 'jumlah'=>$total]);
        
        return Gudang::find($barang)->decrement('stok',$total);
    }
}
