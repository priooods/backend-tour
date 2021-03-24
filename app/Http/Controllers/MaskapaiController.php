<?php

namespace App\Http\Controllers;

use App\Models\Maskapai;
use Illuminate\Http\Request;

class MaskapaiController extends Controller{
    public function add(Request $request){
        try {
            if ($request->image != null)
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $filename = $request->name . '_' . $file->getClientOriginalName();
                    $file->move(public_path('images'), $filename);
                    $request['logo'] = $filename;
                }
            $maskapai = Maskapai::create($request->toArray());
            return $this->responseData($maskapai);
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }

    protected function update(Request $request){
        try {
            $maskapai = Maskapai::find($request->id);
            if ($request->image != null)
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $filename = $request->name . '_' . $file->getClientOriginalName();
                    try {
                        if ($maskapai->highlight) {
                            $file_loc = public_path('images/') . $maskapai->highlight;
                            unlink($file_loc);
                        }
                    } catch (\Throwable $th) {}
                    $file->move(public_path('images'), $filename);
                    $request['logo'] = $filename;
                }
            $maskapai->update($request->toArray());
            return $this->responseData($maskapai);
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }

    protected function show(Request $request){
        try {
            if ($request->id == null)
                return $this->responseData(Maskapai::all());
            $maskapai = Maskapai::find($request->id);
            if (empty($maskapai))
                return $this->responseFailure(1,'Data maskapai tidak ditemukan. Periksa kembali id yang anda masukan !');

            return $this->responseData($maskapai);
        } catch (\Throwable) {
            return $this->responseTryFail();
        }
    }

    protected function delete(Request $request){
        try {
            $maskapai = Maskapai::find($request->id);
            if (is_null($maskapai))
                return $this->responseFailure(1,'Maskapai not found!');
            try {
                if ($maskapai->logo!=null){
                    $file_loc = public_path('images/') . $maskapai->logo;
                    unlink($file_loc);
                }
            } catch (\Throwable $th) {}
            $maskapai->delete();
            return $this->responseText('Successfully delete maskapai!');
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }
}
