<?php

namespace App\Http\Controllers;

use App\Models\BukuM;
use Illuminate\Http\Request;
use App\Http\Resources\BukuR;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BukuC extends Controller
{
    public function index()
    {
        $buku = BukuM::latest()->paginate(5);

        return new BukuR(true, 'List Data Buku', $buku);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all() , [
            'cover'             => 'required|image|mimes:jpeg,png,jpg,gif,svg,webm',
            'nama_buku'         => 'required',
            'penerbit'          => 'required',
            'jumlah_halaman'    => 'required',
            'summary'           => 'required',
            'qty'               => 'required',
            'tahun_rilis'       => 'required'
        ]); 

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $cover = $request->file('cover');
        $cover->storeAs('public/buku', $cover->hashName());

        $buku = BukuM::create([
            'cover'         => $cover->hashname(),
            'nama_buku'     => $request->nama_buku,
            'penerbit'      => $request->penerbit,
            'jumlah_halaman'=> $request->jumlah_halaman,
            'summary'       => $request->summary,
            'qty'           => $request->qty,
            'tahun_rilis'   => $request->tahun_rilis,
        ]);

        return new BukuR(true, 'Data Buku Berhasil Ditambahkan', $buku);
    }

    public function show(BukuM $buku){
        return new BukuR(true, 'Data Buku Ditemukan', $buku);
    }

    public function update(Request $request, BukuM $buku){
        $validator = Validator::make($request->all() , [
            'nama_buku'         => 'required',
            'penerbit'          => 'required',
            'jumlah_halaman'    => 'required',
            'summary'           => 'required',
            'qty'               => 'required',
            'tahun_rilis'       => 'required'
        ]);

        if ($validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('cover')){
            
            $cover = $request->file('cover');
            $cover->storeAs('public/buku', $cover->hashName());

            Storage::delete('public/buku/'.$buku->cover);

            $buku->update([
                'cover'         => $cover->hashname(),
                'nama_buku'     => $request->nama_buku,
                'penerbit'      => $request->penerbit,
                'jumlah_halaman'      => $request->jumlah_halaman,
                'summary'       => $request->summary,
                'qty'           => $request->qty,
                'tahun_rilis'   => $request->tahun_rilis,
            ]);

        } else {
            $buku->update([
                'nama_buku'     => $request->nama_buku,
                'penerbit'      => $request->penerbit,
                'jumlah_halaman'      => $request->jumlah_halaman,
                'summary'       => $request->summary,
                'qty'           => $request->qty,
                'tahun_rilis'   => $request->tahun_rilis,
            ]);
        }

        return new BukuR(true, 'Data Buku Berhasil Diubah', $buku);

    }

    public function destroy(BukuM $buku){
        Storage::delete('public/buku/'.$buku->civer);

        $buku->delete();

        return new BukuR(true, 'Data Buku Berhasil Dihapus', null);
    }
}
