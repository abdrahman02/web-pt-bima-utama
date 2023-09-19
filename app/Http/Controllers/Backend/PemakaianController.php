<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pemakaian;
use Illuminate\Http\Request;

class PemakaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemakaians = Pemakaian::latest()->paginate(10)->withQueryString();
        $barangs = Barang::all();
        return view('backend.pemakaian.index', compact('pemakaians', 'barangs'));
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
            'jenis_pemakaian' => 'required',
            'tgl_pemakaian' => 'required',
            'jumlah' => 'required',
        ]);

        $item = new Pemakaian();
        $item->barang_id = $request->barang_id;
        $item->jenis_pemakaian = $request->jenis_pemakaian;
        $item->tgl_pemakaian = $request->tgl_pemakaian;
        $item->jumlah = $request->jumlah;
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
        $request->validate([
            'jenis_pemakaian' => 'required',
            'tgl_pemakaian' => 'required',
            'jumlah' => 'required',
        ]);

        $item = Pemakaian::findOrFail($id);
        $jumlahLama = $item->jumlah;
        $item->barang_id = $item->barang_id;
        $item->jenis_pemakaian = $request->jenis_pemakaian;
        $item->tgl_pemakaian = $request->tgl_pemakaian;
        $item->jumlah = $request->jumlah;
        $item->update();
        $perubahanJumlah = $request->jumlah - $jumlahLama;

        $barang = Barang::findOrFail($item->barang_id);
        if ($barang) {
            $stok = $barang->stok - $perubahanJumlah;
            $barang->update([
                'stok' => max(0, $stok),
            ]);
        }

        return back()->with('success', 'Sukses, 1 Data berhasil diperbaharui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Pemakaian::findOrFail($id);
        $perubahanJumlah = $item->jumlah;
        $barang = Barang::findOrFail($item->barang_id);
        if ($barang) {
            $stok = $barang->stok + $perubahanJumlah;
            $barang->update([
                'stok' => max(0, $stok),
            ]);
        }

        $item->delete();

        return back()->with('success', 'Sukses, 1 Data berhasil dihapus!');
    }

    public function cariPemakaian(Request $request)
    {
        $keyword = $request->input('keyword');
        $pemakaians = Pemakaian::join('barangs', 'pemakaians.barang_id', '=', 'barangs.id')
            ->where(function ($query) use ($keyword) {
                $query->where('barangs.nama_barang', 'like', '%' . $keyword . '%');
            })
            ->orWhere('pemakaians.jenis_pemakaian', 'like', '%' . $keyword . '%')
            ->orWhere('pemakaians.tgl_pemakaian', 'like', '%' . $keyword . '%')
            ->orWhere('pemakaians.jumlah', 'like', '%' . $keyword . '%')
            ->select('pemakaians.*')
            ->paginate(10)
            ->withQueryString();
        $barangs = Barang::all();

        return view('backend.pemakaian.index', compact('pemakaians', 'barangs'));
    }
}
