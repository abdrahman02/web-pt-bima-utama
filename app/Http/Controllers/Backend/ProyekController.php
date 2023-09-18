<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Proyek;
use Illuminate\Http\Request;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proyeks = Proyek::latest()->paginate(10)->withQueryString();
        $barangs = Barang::all();
        $pelanggans = Pelanggan::all();
        return view('backend.proyek.index', compact('proyeks', 'barangs', 'pelanggans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'pelanggan_id' => 'required',
            'no_fakt_proyek' => 'required',
            'tgl_proyek' => 'required',
            'jumlah' => 'required',
            'status' => 'required',
            'harga' => 'required',
            'jumlah_bayar' => 'required'
        ]);

        $item = new Proyek();
        $item->barang_id = $request->barang_id;
        $item->pelanggan_id = $request->pelanggan_id;
        $item->no_fakt_proyek = $request->no_fakt_proyek;
        $item->tgl_proyek = $request->tgl_proyek;
        $item->jumlah = $request->jumlah;
        $item->status = $request->status;
        $item->harga = $request->harga;
        $item->jumlah_bayar = $request->jumlah_bayar;
        $item->save();

        $item = Barang::findOrFail($request->barang_id);
        if ($item) {
            $item->update([
                'stok' => max(0, $item->stok - $request->jumlah),
            ]);
        }
        return back()->with('success', 'Sukses, 1 Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
