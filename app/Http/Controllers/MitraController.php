<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Mitra;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class MitraController extends Controller{
    public function register (Request $request){
        try {
            $request['password'] = Crypt::encrypt($request['password']);
            $request['log'] = 0;

            $statement = DB::select("SHOW TABLE STATUS LIKE 'mitras'");
            $nextId = $statement[0]->Auto_increment;
            $request['code'] = date("Y")."MTR".str_pad($nextId,5-floor(log10($nextId)),"0",STR_PAD_LEFT);

            $check = Mitra::where('username', $request->username)->first();
            if ($check) {
                return $this->responseFailure(1,"Pengguna dengan username tersebut sudah terdaftar. Harap ganti dengan username lain !");
            }

            $user = Mitra::create($request->toArray());
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = $user->id . $user->username . '_' . $file->getClientOriginalName();
                $path = $file->move(public_path('images'), $filename);
                $user->update([
                    'avatar' => $filename,
                ]);
            }
            return $this->responUserSuccess($user);
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }

    protected function login(Request $request){
        try {
            $user = Mitra::where('username', $request->username)->first();
            if (!$user)
                return $this->responseFailure(1,'Account anda tidak ditemukan. Harap lengkapi informasi account anda dengan benar !');
            $user->log = 1;
            $user->update();
            return $this->responUserSuccess($user);
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }

    function show(Request $request){
        try {
            if ($request->username == null)
                return $this->responseData(Mitra::all());
            $user = Mitra::where('username', $request->username)->first();
            // $user->mitra;
            // $user->jamaah;
            return $this->responseData($user);
        } catch (Exception $th) {
            return $this->responseTryFail();
        }
    }

    protected function update(Request $request){
        try {
            $user = Mitra::where('username',$request->username)->first();
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = $user->id . $user->username . '_' . $file->getClientOriginalName();

                if ($user->avatar) {
                    $file_loc = public_path('images/') . $user->avatar;
                    unlink($file_loc);
                }

                $path = $file->move(public_path('images'), $filename);
                $user->avatar = $request->avatar = $filename;
            }
            if (!is_null($request->username)) $user->username = $request->username;
            if (!is_null($request->fullname)) $user->fullname = $request->fullname;
            if (!is_null($request->password)) $user->password = Crypt::encrypt($request->password);
            if (!is_null($request->alamat)) $user->alamat = $request->alamat;
            if (!is_null($request->no_tlp)) $user->no_tlp = $request->no_tlp;
            if (!is_null($request->cabang)) $user->cabang = $request->cabang;
            $user->update();
            return $this->responseData($user);
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }

    protected function delete(Request $request){
        try {
            $user = Mitra::where('username',$request->username);
            if ($user == null)
                return $this->responseFailure(1,'Data mitra tidak ditemukan. Periksa kembali code yang anda masukan !');
            if ($request->avatar != null){
                $file_loc = public_path('images/') . $user->avatar;
                unlink($file_loc);
            }

            $user->delete();
            return $this->responseText('Berhasil menghapus data account mitra. Semua data tentang mitra telah dihapus !');
        } catch (Exception $th) {
            return $this->responseTryFail();
        }
    }

    protected function logout(Request $request){
        try {
            $user = Mitra::where('username', $request->username)->first();
            if (!$user)
                return $this->responseFailure(1, 'Account anda tidak ditemukan. Harap lengkapi informasi account anda dengan benar !');

            $user->log = 0;
            $user->update();
            return $this->responseText('Anda berhasil keluar applikasi. Terimakasih dan sampai jumpa lagi !');
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }

    public function fee(Request $request){
        $mitra = Mitra::all('id','code','code_agent');
        if ($request->umrah_id != null){
            foreach($mitra as $m){
                $m->jamaah = Pesanan::where('mitra_id',$m->id)->where('umrah_id',$request->umrah_id)->count();
            }
        }
        else{
            foreach($mitra as $m){
                $m->jamaah = Pesanan::where('mitra_id',$m->id)->count();
                // return $this->responseData($m->jamaah);
            }
        }
        // $mitra->save();
        foreach($mitra as $m){
            // $m->mjamaah = 0;
            $my_mitra = $mitra->where('code_agent',$m->id);
            foreach($my_mitra as $y){
                $m->mjamaah += $y->jamaah;
            }
            $m->jamaah *= $request->fee;
            $m->mjamaah *= $request->mitra_fee;
            $m->fee = $m->jamaah + $m->mjamaah;
        }
        return $this->responseData($mitra);
        // $mitra->save();
    }
}
