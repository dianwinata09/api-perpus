<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanM;
use Illuminate\Http\Request;
use App\Http\Resources\PeminjamanR;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PeminjamanC extends Controller
{
    public function index()
    {
        $pinjam = PeminjamanM::latest()->paginate(5);

        return new PeminjamanR(true, 'List Data Buku', $pinjam);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all() , [
            'id_buku'         => 'required',
            'id_user'          => 'required',
            'tanggal_pinjaman'    => 'required',
            'tanggal_kembali'    => 'required',
            'denda'               => 'required'
        ]); 

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $pinjaman = PeminjamanM::create([
            'id_buku'     => $request->id_buku,
            'id_user'      => $request->id_user,
            'tanggal_pinjaman'=> $request->tanggal_pinjaman,
            'tanggal_kembali'       => $request->tanggal_kembali,
            'denda'           => $request->denda,
        ]);

        return new PeminjamanR(true, 'Data pinjaman Berhasil Ditambahkan', $pinjaman);
    }

    public function show(PeminjamanM $pinjaman){
        return new PeminjamanR(true, 'Data pinjaman Ditemukan', $pinjaman);
    }

    public function update(Request $request, PeminjamanM $pinjaman){
        $validator = Validator::make($request->all() , [
            'id_buku'         => 'required',
            'id_user'          => 'required',
            'tanggal_pinjaman'    => 'required',
            'tanggal_kembali'    => 'required',
            'denda'               => 'required'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

            Storage::delete('public/peminjaman/'.$pinjaman->id_buku);

            $pinjaman->update([
                'id_buku'     => $request->id_buku,
                'id_user'      => $request->id_user,
                'tanggal_pinjaman'=> $request->tanggal_pinjaman,
                'tanggal_kembali'       => $request->tanggal_kembali,
                'denda'           => $request->denda,
            ]);

        return new PeminjamanR(true, 'Data Buku Berhasil Diubah', $pinjaman);

    }

    public function destroy(PeminjamanM $pinjaman){
        Storage::delete('public/buku/'.$pinjam->id_buku);

        $pinjaman->delete();

        return new PeminjamanR(true, 'Data Buku Berhasil Dihapus', null);
    }
}
