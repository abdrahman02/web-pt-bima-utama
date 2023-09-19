<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Suplier;
use Illuminate\Http\Request;

class SuplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $supliers = Suplier::latest()->paginate(10)->withQueryString();
        return view('backend.suplier.index', compact('supliers'));
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
            'nama_suplier' => 'required|string',
            'no_telp' => 'required',
            'alamat' => 'required'
        ]);

        $item = new Suplier();
        $item->nama_suplier = $request->nama_suplier;
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
            'nama_suplier' => 'required|string',
            'no_telp' => 'required',
            'alamat' => 'required'
        ]);

        $item = Suplier::findOrFail($id);
        $item->nama_suplier = $request->nama_suplier;
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
        $item = Suplier::findorFail($id);
        $item->delete();

        return back()->with('success', 'Sukses, 1 Data berhasil dihapus!');
    }

    public function cetak()
    {
        $supliers = Suplier::all();
        return view('backend.templates.suplier.index', compact('supliers'));
    }
}
