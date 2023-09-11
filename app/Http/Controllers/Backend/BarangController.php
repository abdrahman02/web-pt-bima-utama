<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang::latest()->paginate(10)->withQueryString();
        return view('backend.barang.index', compact('barangs'));
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
            'nama_barang' => 'required',
            'jenis' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required'
        ]);

        $item = new Barang();
        $item->nama_barang = $request->nama_barang;
        $item->jenis = $request->jenis;
        $item->harga_beli = $request->harga_beli;
        $item->harga_jual = $request->harga_jual;
        $item->save();

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
        $request->validate([
            'nama_barang' => 'required|string',
            'jenis' => 'required',
            'harga_beli' => 'required',
            'harga_jual' => 'required'
        ]);

        $item = Barang::findOrFail($id);
        $item->nama_barang = $request->nama_barang;
        $item->jenis = $request->jenis;
        $item->harga_beli = $request->harga_beli;
        $item->harga_jual = $request->harga_jual;
        $item->save();

        return back()->with('success', 'Sukses, 1 Data berhasil perbaharui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Barang::findorFail($id);
        $item->delete();

        return back()->with('success', 'Sukses, 1 Data berhasil dihapus!');
    }
}
