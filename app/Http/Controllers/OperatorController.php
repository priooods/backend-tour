<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class OperatorController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request['password'] = Crypt::encrypt($request['password']);
            $request['log'] = 0;

            $check = User::where('username', $request->username)->first();
            if ($check) {
                return response()->json([
                    'error_code' => 1,
                    'error_data' => "Pengguna dengan username tersebut sudah terdaftar. Harap ganti dengan username lain !",
                ]);
            }

            $operator = User::create($request->toArray());
            if ($request->hasFile('avatar')) {
                $file = $request->file('avatar');
                $filename = $operator->id . $operator->username . '_' . $file->getClientOriginalName();
                $path = $file->move(public_path('images'), $filename);
                $operator->update(['avatar' => $filename]);
            }

            return $this->responseSuccess($operator);
        } catch (\Throwable $th) {
            return $this->respondFailure();
        }
    }

    public function login(Request $request)
    {
        try {
            $validate = Validator::make($request->all(),[
                'username' => 'required',
                'password' => 'required'
            ]);

            $user = User::where('username', $request->username)->first();
            $user->log = 1;
            $user->update();
            return $this->responseSuccess($user);
        } catch (\Throwable $th) {
            return $this->respondFailure();
        }
    }

    protected function logout(Request $request){
        try {
            $user = User::where('username', $request->username)->first();
            if (!$user) {
                return response()->json([
                    'error_code' => 1,
                    'error_data' => 'Account anda tidak ditemukan. Harap lengkapi informasi account anda dengan benar !'
                ]);
            }
            $user->log = 0;
            $user->update();
            return response()->json([
                'error_code' => 0,
                'error_data' => 'Anda berhasil keluar applikasi. Terimakasih dan sampai jumpa lagi !'
            ]);
        } catch (\Throwable $th) {
            return $this->respondFailure();
        }
    }

    protected function all()
    {
        try {
            return response()->json([
                'error_code' => 1,
                'error_data' => '',
                'data' => User::all()
            ]);
        } catch (\Throwable $th) {
            return $this->respondFailure();
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
            return $this->responseSuccess($user);
        } catch (\Throwable $th) {
            return $this->respondFailure();
        }
    }

    protected function find(Request $request){
        try {
            $user = User::where('username', $request->username)->first();
            if (empty($user)) {
                return response([
                    'error_code' => 1,
                    'error_data' => 'Data pengguna tidak ditemukan. Periksa kembali username yang anda masukan !'
                ]);
            }
            return $this->responseSuccess($user);
        } catch (\Throwable $th) {
            return $this->respondFailure();
        }
    }

    protected function delete(Request $request)
    {
        try {
            $user = User::where('username',$request->username)->first();
            if (is_null($user))
                return response()->json([
                    'error_code' => 1,
                    'error_data' => 'User not found!',
                ]);
            // $file_loc = public_path('images/') . $user->avatar;
            // unlink($file_loc);
            $user->delete();
            return response()->json([
                'error_code' => 0,
                'error_message' => 'Successfully delete operator!',
            ]);
        } catch (\Throwable $th) {
            return $this->respondFailure();
        }
    }

    protected function responseSuccess($data)
    {
        return response()->json([
            'error_code' => 0,
            'error_data' => '',
            'data' => [
                'id' => $data->id,
                'username' => $data->username,
                'fullname' => $data->fullname,
                'password' => Crypt::decrypt($data->password),
                'jabatan' => $data->jabatan,
                'type' => $data->type,
                'avatar' => $data->avatar,
                'log' => $data->log
            ],
        ]);
    }

    protected function respondFailure()
    {
        return response()->json([
            'error_code' => 1,
            'error_data' => 'Harap periksa kembali koneksi internet anda !',
        ]);
    }
}
