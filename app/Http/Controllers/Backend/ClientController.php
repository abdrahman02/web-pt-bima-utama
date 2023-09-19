<?php

namespace App\Http\Controllers\Backend;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggans = Pelanggan::latest()->paginate(10)->withQueryString();
        return view('backend.client.index', compact('pelanggans'));
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
            'nama_pelanggan' => 'required|string',
            'no_telp' => 'required',
            'alamat' => 'required'
        ]);

        $item = new Pelanggan();
        $item->nama_pelanggan = $request->nama_pelanggan;
        $item->no_telp = $request->no_telp;
        $item->alamat = $request->alamat;
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
            'nama_pelanggan' => 'required|string',
            'no_telp' => 'required',
            'alamat' => 'required'
        ]);

        $item = Pelanggan::findOrFail($id);
        $item->nama_pelanggan = $request->nama_pelanggan;
        $item->no_telp = $request->no_telp;
        $item->alamat = $request->alamat;
        $item->save();

        return back()->with('success', 'Sukses, 1 Data berhasil perbaharui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Pelanggan::findorFail($id);
        $item->delete();

        return back()->with('success', 'Sukses, 1 Data berhasil dihapus!');
    }

    public function cariPelanggan(Request $request)
    {
        $keyword = $request->input('keyword');
        $pelanggans = Pelanggan::where('id', 'like', '%' . $keyword . '%')
            ->orWhere('nama_pelanggan', 'like', '%' . $keyword . '%')
            ->orWhere('no_telp', 'like', '%' . $keyword . '%')
            ->orWhere('alamat', 'like', '%' . $keyword . '%')
            ->paginate(10)->withQueryString();

        return view('backend.client.index', compact('pelanggans'));
    }
}
