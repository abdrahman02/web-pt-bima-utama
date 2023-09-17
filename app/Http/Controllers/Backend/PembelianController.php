<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\Suplier;
use Illuminate\Http\Request;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembelians = Pembelian::latest()->paginate(10)->withQueryString();
        $barangs = Barang::all();
        $supliers = Suplier::all();
        return view('backend.pembelian.index', compact('pembelians', 'barangs', 'supliers'));
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
            'suplier_id' => 'required',
            'no_fakt_pembelian' => 'required',
            'tgl_pembelian' => 'required',
            'jumlah' => 'required',
            'status' => 'required',
            'harga' => 'required',
            'jumlah_bayar' => 'required'
        ]);

        $item = new Pembelian();
        $item->barang_id = $request->barang_id;
        $item->suplier_id = $request->suplier_id;
        $item->no_fakt_pembelian = $request->no_fakt_pembelian;
        $item->tgl_pembelian = $request->tgl_pembelian;
        $item->jumlah = $request->jumlah;
        $item->status = $request->status;
        $item->harga = $request->harga;
        $item->jumlah_bayar = $request->jumlah_bayar;
        $item->save();

        $item = Barang::findOrFail($request->barang_id);
        // Konversi $request->jumlah ke tipe data integer
        $jumlah = intval($request->jumlah);
        // Perbarui stok dengan menambahkan jumlah pembelian
        if ($item && is_numeric($jumlah)) {
            $stok = intval($item->stok); // Konversi stok ke integer jika belum
            $item->update([
                'stok' => strval($stok + $jumlah) // Konversi kembali ke string setelah penambahan
            ]);
        }
        $item->harga_beli = $request->harga;
        $item->update();

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
            'barang_id' => 'required',
            'suplier_id' => 'required',
            'no_fakt_pembelian' => 'required',
            'tgl_pembelian' => 'required',
            'jumlah' => 'required',
            'status' => 'required',
            'harga' => 'required',
            'jumlah_bayar' => 'required'
        ]);

        $item = Pembelian::findOrFail($id);
        // Simpan jumlah lama pembelian sebelum diperbarui
        $jumlahLama = $item->jumlah;
        $item->barang_id = $request->barang_id;
        $item->suplier_id = $request->suplier_id;
        $item->no_fakt_pembelian = $request->no_fakt_pembelian;
        $item->tgl_pembelian = $request->tgl_pembelian;
        $item->jumlah = $request->jumlah;
        $item->status = $request->status;
        $item->harga = $request->harga;
        $item->jumlah_bayar = $request->jumlah_bayar;
        $item->update();

        // Menghitung perubahan jumlah pembelian
        $perubahanJumlah = $request->jumlah - $jumlahLama;
        // Mengupdate stok barang
        $barang = Barang::find($item->barang_id);
        if ($barang) {
            $stokBaru = $barang->stok + $perubahanJumlah;
            $barang->update([
                'stok' => $stokBaru,
                'harga_beli' => $request->harga_beli, // Memastikan harga_beli barang diupdate
            ]);
        }

        return back()->with('success', 'Sukses, 1 Data berhasil diperbaharui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pembelian = Pembelian::findOrFail($id);

        // Menghitung perubahan jumlah pembelian
        $perubahanJumlah = -$pembelian->jumlah;

        // Mengupdate stok barang
        $barang = Barang::find($pembelian->barang_id);

        if ($barang) {
            $stokBaru = $barang->stok + $perubahanJumlah;
            $barang->update([
                'stok' => $stokBaru,
            ]);
        }

        $pembelian->delete();

        return back()->with('success', 'Sukses, 1 Data berhasil dihapus!');
    }
}
