<?php

namespace App\Http\Controllers;

use App\Models\userM;
use Illuminate\Http\Request;
use App\Http\Resources\userR;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class userC extends Controller
{
    public function index()
    {
        $user = userM::latest()->paginate(5);

        return new userR(true, 'List User', $user);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all() , [
            'username'         => 'required',
            'password'          => 'required',
            'nama_user'    => 'required',
            'role'    => 'required',
            'no_hp'               => 'required'
        ]); 

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $user = userM::create([
            'username'     => $request->username,
            'password'      => Hash::make($request->password) ,
            'nama_user'=> $request->nama_user,
            'role'       => $request->role,
            'no_hp'           => $request->no_hp,
        ]);

        return new UserR(true, 'Data user Berhasil Ditambahkan', $user);
    }

    public function show(UserM $user){
        return new UserR(true, 'Data user Ditemukan', $user);
    }

    public function update(Request $request, UserM $user){
        $validator = Validator::make($request->all() , [
            'username'         => 'required',
            'password'          => 'required',
            'nama_user'    => 'required',
            'role'    => 'required',
            'no_hp'               => 'required'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

            Storage::delete('public/users/'.$user->username);

            $user->update([
                'username'     => $request->username,
            'password'      => Hash::make($request->password) ,
            'nama_user'=> $request->nama_user,
            'role'       => $request->role,
            'no_hp'           => $request->no_hp,
            ]);

        return new userR(true, 'Data user Berhasil Diubah', $user);

    }

    public function destroy(UserM $user){
        Storage::delete('public/users/'.$user->id_buku);

        $user->delete();

        return new UserR(true, 'Data user Berhasil Dihapus', null);
    }
}
