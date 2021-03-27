<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use App\Models\Belanja;
use App\Models\Gudang;
use App\Models\Jamaah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BelanjaControll extends Controller{
    public function add(Request $request){
        $item = '';
        if ($request->belanja == null)
            return $this->respondFailure(1,"item field is not found!");
        $item = $request->belanja;
        for ($i=0; $i < count($item); $i++) {
            if (array_key_exists('nama',$item[$i])){
                $gudang = Gudang::where('nama',$item[$i]['nama'])->first();
                if ($gudang != null && ($gudang->harga == $item[$i]['harga'] || $gudang->harga == 0))
                    $item[$i]['gudang_id'] = $gudang->id;
                else
                    $item[$i]['gudang_id'] = Gudang::create($item[$i])->id;
            }
            unset($item[$i]['nama']);
        }
        $request['total'] = count($item);

        $belanja = Belanja::create($request->toArray());
        $bitem = $belanja->item()->createMany($item);
        foreach($item as $i){
            Gudang::find($i['gudang_id'])->update([
                'stok'=> DB::raw('stok+'.$i['total']),
                $i
              ]);
        }
        return $this->responseData([$belanja,$bitem]);
    }

    public function cancel(Request $request){
        try{
            if ($request->id == null)
                return $this->responseFailure(1,'need belanja id field!');
            else {
                $belanja = Belanja::find($request->id);
                if ($belanja == null)
                    return $this->responseFailure(1,"belanja id not found!");

                $item = $belanja->item;
                foreach($item as $i){
                    Gudang::find($i['gudang_id'])->update([
                        'stok'=> DB::raw('stok-'.$i['total']),
                        $i
                    ]);
                }
                $belanja->delete();
                return $this->responseText('belanja have been canceled!');
            }
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }

    public function show(Request $request){
        try{
            if ($request->id == null){
                $belanja = Belanja::all();
                foreach($belanja as $b)
                    $this->item_detail($b);
            }
            else{
                $belanja = Belanja::find($request->id);
                if ($belanja == null)
                    return $this->responseFailure(1,"belanja id not found!");
                $this->item_detail($belanja);
            }
            return $this->responseData($belanja);
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }

    function item_detail($belanja){
        foreach($belanja->item as $i){
            $i->my_item;
            $i->name = $i->my_item->nama;
            $i->harga = $i->my_item->harga;
        }
    }

    public function item(Request $request){
        $data = Belanja::find($request->id);
        $item = $data->my_belanja;
        $list = array();
        foreach($item as $e){
            array_push($list,$e->my_item);
        }

        return $this->responseSuccess($list);
    }
}
