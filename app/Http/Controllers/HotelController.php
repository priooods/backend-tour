<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Kamar;

class HotelController extends Controller{
    public function add(Request $request){
        try {
            if ($request->image != null)
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $filename = $request->name . '_' . $file->getClientOriginalName();
                    $file->move(public_path('images'), $filename);
                    $request['highlight'] = $filename;
                }
            $hotel = Hotel::create($request->toArray());
            return $this->responseData($hotel);
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }

    // protected function update_kamar(Request $request){
    //     try{
    //         $kamar = Kamar::find($request->id)->update($request->toArray());
    //         return $this->responseData($kamar->all());
    //     } catch (\Throwable $th) {
    //         return $this->responseTryFail();
    //     }
    // }
    // protected function delete_kamar(Request $request){
    //     try{
    //         Kamar::find($request->id)->delete();
    //         return $this->responseText('kamar have been deleted!');
    //     } catch (\Throwable $th) {
    //         return $this->responseTryFail();
    //     }
    // }

    protected function update(Request $request){
        try {
            $hotel = Hotel::find($request->id);
            if ($request->image != null)
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $filename = $request->name . '_' . $file->getClientOriginalName();
                    try {
                        if ($hotel->highlight) {
                            $file_loc = public_path('images/') . $hotel->highlight;
                            unlink($file_loc);
                        }
                    } catch (\Throwable $th) {}
                    $file->move(public_path('images'), $filename);
                    $request['highlight'] = $filename;
                }
            $hotel->update($request->toArray());
            // $kamar = '';
            // if ($request->kamar != null)
            //     $kamar = $hotel->kamar()->createMany($request->kamar);
            return $this->responseData([$hotel]);
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }

    protected function show(Request $request){
        try {
            if ($request->id == null)
                return $this->responseData(Hotel::all());
            $hotel = Hotel::find($request->id);
            if (empty($hotel))
                return $this->responseFailure(1,'Data hotel tidak ditemukan. Periksa kembali id yang anda masukan !');
            // $hotel->kamar;
            return $this->responseData($hotel);
        } catch (\Throwable) {
            return $this->responseTryFail();
        }
    }

    protected function delete(Request $request){
        try {
            $hotel = Hotel::find($request->id);
            if (is_null($hotel))
                return $this->responseFailure(1,'Hotel not found!');
            try {
                if ($hotel->highlight!=null){
                    $file_loc = public_path('images/') . $hotel->highlight;
                    unlink($file_loc);
                }
            } catch (\Throwable $th) {}
            $hotel->delete();
            return $this->responseText('Successfully delete hotel!');
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }
}
