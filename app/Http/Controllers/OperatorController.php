<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class OperatorController extends Controller{
    public function register(Request $request){
        try {
            $request['password'] = Crypt::encrypt($request['password']);
            $request['log'] = 0;

            $check = User::where('username', $request->username)->first();
            if ($check) {
                return $this->responseFailure(1,"Pengguna dengan username tersebut sudah terdaftar. Harap ganti dengan username lain !");
            }

            $operator = User::create($request->toArray());
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = $operator->id . $operator->username . '_' . $file->getClientOriginalName();
                $file->move(public_path('images'), $filename);
                $operator->update(['avatar' => $filename]);
            }

            return $this->responUserSuccess($operator);
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }

    public function login(Request $request){
        try {
            $user = User::where('username', $request->username)->first();
            $user->log = 1;
            $user->update();
            return $this->responUserSuccess($user);
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }

    protected function logout(Request $request){
        try {
            $user = User::where('username', $request->username)->first();
            if (!$user) {
                return $this->responseFailure(1,'Account anda tidak ditemukan. Harap lengkapi informasi account anda dengan benar !');
            }
            $user->log = 0;
            $user->update();
            return $this->responseText('Anda berhasil keluar applikasi. Terimakasih dan sampai jumpa lagi !');
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }

    protected function update(Request $request){
        try {
            $user = User::where('username', $request->username)->first();
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
            if (!is_null($request->password)) $user->password = Crypt::encrypt($request->password);
            if (!is_null($request->fullname)) $user->fullname = $request->fullname;
            if (!is_null($request->jabatan)) $user->jabatan = $request->jabatan;
            if (!is_null($request->type)) $user->type = $request->type;
            if (!is_null($request->username)) $user->username = $request->username;
            $user->update();
            return $this->responUserSuccess($user);
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }

    protected function show(Request $request){
        try {
            if ($request->id == null)
                return $this->responseData(User::all());
            $user = User::where('username', $request->username)->first();
            if (empty($user)) {
                return $this->responseFailure(1,'Data pengguna tidak ditemukan. Periksa kembali username yang anda masukan !');
            }
            return $this->responUserSuccess($user);
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }

    protected function delete(Request $request){
        try {
            $user = User::where('username',$request->username)->first();
            if (is_null($user))
                return $this->responseFailure(1,'User not found!');
            try {
                if ($user->avatar!=null){
                    $file_loc = public_path('images/') . $user->avatar;
                    unlink($file_loc);
                }
            } catch (\Throwable $th) {}
            $user->delete();
            return $this->responseText('Successfully delete operator!');
        } catch (\Throwable $th) {
            return $this->responseTryFail();
        }
    }
}
