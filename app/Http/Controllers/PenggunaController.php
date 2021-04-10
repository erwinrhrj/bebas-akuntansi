<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengguna;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PenggunaController extends Controller
{
    public function index(Request $request){

        $cmd      = $request->cmd;
        $pengguna = Pengguna::where('pengguna_status', 'active')->get();

        if($cmd == 'get_pengguna'){
            return response()->json([
                'state' => true,
                'data' => $pengguna,
                'message' => 'Data Berhasil Ditampilkan'
            ]);
        }else{
            return response()->json([
                'state' => false,
                'message' => 'Gagal Menampilkan Data'
            ]);
        }
    }
    
    public function store(Request $request){
        $cmd = $request->cmd;
        
        if($cmd == 'store_pengguna'){

            $validator = Validator::make($request->all(), [
                'pengguna_name' => 'required',
                'pengguna_username' => 'required|unique:pengguna',
                'pengguna_password' => 'required',
                'pengguna_posisi' => 'required',
    
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'state' => false,
                    'message' => $validator->errors()
                ]);
            }
    
            $pengguna = Pengguna::create([
                'pengguna_name' => $request->pengguna_name,
                'pengguna_username' => $request->pengguna_username,
                'pengguna_password' => Hash::make($request->pengguna_password),
                'pengguna_status' => 'active',
                'pengguna_posisi' => $request->pengguna_posisi,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
    
            if($pengguna){
                return response()->json([
                    'state' => true,
                    'data' => $pengguna,
                    'message' => 'Data Berhasil Dibuat'
                ]);
            }else{
                return response()->json([
                    'state' => false,
                    'message' => 'Gagal Membuat Data'
                ]);
            }
        }else{
            return response()->json([
                'state' => false,
                'message' => 'Gagal Command'
            ]);
        }

    }

    public function update(Request $request){
        $cmd = $request->cmd;

        if($cmd == 'update_pengguna'){

            $validator = Validator::make($request->all(), [
                'pengguna_name' => 'required',
                'pengguna_posisi' => 'required',
    
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'state' => false,
                    'message' => $validator->errors()
                ]);
            }

            $pengguna = Pengguna::where('pengguna_id', $request->pengguna_id)
                                ->where('pengguna_username', $request->pengguna_username)
                                ->update([
                                    'pengguna_name' => $request->pengguna_name,
                                    'pengguna_posisi' => $request->pengguna_posisi,
                                    'updated_at' => Carbon::now(),
                                ]);

            if($pengguna){
                return response()->json([
                    'state' => true,
                    'data' => $pengguna,
                    'message' => 'Data Berhasil Diupdate'
                ]);
            }else{
                return response()->json([
                    'state' => false,
                    'message' => 'Gagal Update Data/Request Data Salah'
                ]);
            }
        }else{
            return response()->json([
                'state' => false,
                'message' => 'Gagal Command'
            ]);
        }

        
    }

    public function delete(Request $request){
        $cmd = $request->cmd;

        if($cmd == 'delete_pengguna'){

            $pengguna = Pengguna::where('pengguna_id', $request->pengguna_id)
                                ->update([
                                    'pengguna_status' => 'inactive',
                                    'updated_at' => Carbon::now(),
                                ]);

            if($pengguna){
                return response()->json([
                    'state' => true,
                    'data' => $pengguna,
                    'message' => 'Data Berhasil Dinonactive'
                ]);
            }else{
                return response()->json([
                    'state' => false,
                    'message' => 'Gagal NonActive Data/Request Data Salah'
                ]);
            }
        }else{
            return response()->json([
                'state' => false,
                'message' => 'Gagal Command'
            ]);
        }

        
    }


}
