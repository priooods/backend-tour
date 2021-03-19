<?php

namespace App\Http\Controllers;

use App\Models\Jamaah;
use App\Models\Mitra;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MitraController extends Controller
{
    public function register (Request $request){

        try {
            $request['password'] = Crypt::encrypt($request['password']);
            $request['log'] = 0;

            $statement = DB::select("SHOW TABLE STATUS LIKE 'mitras'");
            $nextId = $statement[0]->Auto_increment;
            $request['code'] = date("Y")."MTR".str_pad($nextId,6-floor(log10($nextId)),"0",STR_PAD_LEFT);
            
            $check = Mitra::where('username', $request->username)->first();
            if ($check) {
                return response()->json([
                    'error_code' => 1,
                    'error_data' => "Pengguna dengan username tersebut sudah terdaftar. Harap ganti dengan username lain !",
                ]);
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
            return $this->responseSuccess($user);
        } catch (\Throwable $th) {
            return $this->respondFailure();
        }
    }

    protected function login(Request $request){
        try {
            $user = Mitra::where('username', $request->username)->first();
            if (!$user) {
                return response()->json([
                    'error_code' => 1,
                    'error_data' => 'Account anda tidak ditemukan. Harap lengkapi informasi account anda dengan benar !'
                ]);
            }
            $user->log = 1;
            $user->update();
            return $this->responseSuccess($user);
        } catch (\Throwable $th) {
            return $this->respondFailure();
        }
    }

    protected function all(){
        return response()->json([
            'error_code' => 0,
            'error_data' => '',
            'data' => Mitra::all()
        ]);
    }

    protected function find(Request $request){
        try {
            $request->validate([
                'username' => 'required'
            ]);

            $user = Mitra::where('username', $request->username)->first();
            $jamaah = DB::table('jamaahs')->where('nama_mitra', $user->id)->get();
            if (empty($user)) {
                return response([
                    'error_code' => 1,
                    'error_data' => 'Data mitra tidak ditemukan. Periksa kembali code yang anda masukan !'
                ]);
            }
            return response()->json([
                'error_code' => 0,
                'error_data' => '',
                'data' => [
                    'mitra' => $user,
                    'jamaah' => $jamaah
                ]
            ]);
        } catch (Exception $th) {
            return $this->respondFailure();
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
            return $this->responseSuccess($user);
        } catch (\Throwable $th) {
            return $this->respondFailure();
        }
    }

    protected function delete(Request $request)
    {
        try {
            $user = Mitra::find($request->username);
            if (is_null($user))
                return response()->json([
                    'error_code' => '1',
                    'error_data' => 'Data mitra tidak ditemukan. Periksa kembali code yang anda masukan !',
                ]);
            
            $file_loc = public_path('images/') . $user->avatar;
            unlink($file_loc);
            $user->delete();
            return response()->json([
                'error_code' => '0',
                'error_data' => 'Berhasil menghapus data account mitra. Semua data tentang mitra telah dihapus !',
            ]);
        } catch (Exception $th) {
            return $this->respondFailure();
        }
    }

    protected function logout(Request $request){
        try {
            $user = Mitra::where('username', $request->username)->first();
            if (!$user) {
                return response()->json([
                    'error_code' => 1,
                    'error_data' => 'Account anda tidak ditemukan. Harap lengkapi informasi account anda dengan benar !'
                ]);
            }
            $user->log = 0;
            $user->update();
            return response()->json([
                'error_code' => 1,
                'error_data' => 'Anda berhasil keluar applikasi. Terimakasih dan sampai jumpa lagi !'
            ]);
        } catch (\Throwable $th) {
            return $this->respondFailure();
        }
    }

    protected function trackAgent(Request $request){
        $user = DB::table('mitras')->where('code_agent', $request->code_agent)->first();
        return response()->json([
            'error_code' => 0,
            'error_data' => '',
            'data' => $user
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    protected function trackMitra(Request $request){
        $user = DB::table('mitras')->where('code', $request->code)->get();
        return response()->json([
            'error_code' => 0,
            'error_data' => '',
            'data' => $user
        ], 200, [], JSON_NUMERIC_CHECK);
    }

    protected function respondFailure()
    {
        return response()->json([
            'error_code' => 1,
            'error_data' => 'Harap periksa kembali koneksi internet anda !',
        ]);
    }

    protected function responseSuccess($data)
    {
        return response()->json([
            'error_code' => 0,
            'error_data' => '',
            'data' => [
                'id' => $data->id,
                'fullname' => $data->fullname,
                'code_agent' => $data->code_agent,
                'password' => Crypt::decrypt($data->password),
                'code' => $data->code,
                'username' => $data->username,
                'alamat' => $data->alamat,
                'cabang' => $data->cabang,
                'no_tlp' => $data->no_tlp,
                'log' => $data->log
            ],
        ], 200, [], JSON_NUMERIC_CHECK);
    }
}
