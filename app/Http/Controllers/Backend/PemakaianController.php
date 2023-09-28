<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pemakaian;
use App\Models\PemakaianDetail;
use Illuminate\Http\Request;

class PemakaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemakaian_details = PemakaianDetail::latest()->paginate(10)->withQueryString();
        $barangs = Barang::all();
        return view('backend.pemakaian.index', compact('pemakaian_details', 'barangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cartPemakaian = session('cartPemakaian', []);
        $grandTotal = 0;
        if (!empty($cartPemakaian)) {
            foreach ($cartPemakaian as $item) {
                $grandTotal += $item['sub_total_harga'];
            }
        }
        $barangs = Barang::all();
        return view('backend.pemakaian.create', compact('barangs', 'cartPemakaian', 'grandTotal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cartPemakaian = session('cartPemakaian');
        $request->validate([
            'jenis_pemakaian' => 'required',
            'tgl_pemakaian' => 'required',
            'grand_total_harga' => 'required',
            'keterangan_pemakaian' => 'nullable',
        ]);

        $pemakaian = new Pemakaian();
        $pemakaian->jenis_pemakaian = $request->jenis_pemakaian;
        $pemakaian->tgl_pemakaian = $request->tgl_pemakaian;
        // Menghapus "Rp. " dan tanda koma (",") dari grand_total_harga jika diperlukan
        $grand_total_harga = $request->grand_total_harga;
        if (strpos($grand_total_harga, 'Rp. ') !== false) {
            $grand_total_harga = str_replace('Rp. ', '', $grand_total_harga);
        }
        if (strpos($grand_total_harga, ',') !== false) {
            $grand_total_harga = str_replace(',', '', $grand_total_harga);
        }
        //
        $pemakaian->grand_total_harga = $grand_total_harga;
        $pemakaian->keterangan_pemakaian = $request->keterangan_pemakaian;
        $pemakaian->save();

        foreach ($cartPemakaian as $val) {
            PemakaianDetail::create([
                'pemakaian_id' => $pemakaian->id,
                'barang_id' => $val['barang_id'],
                'jumlah' => $val['jumlah'],
                'sub_total_harga' => $val['sub_total_harga'],
            ]);
            // Membuat instance model Barang berdasarkan ID
            $barang = Barang::findOrFail($val['barang_id']);

            // Memanggil metode update pada instance Barang
            $barang->update([
                'stok' => max(0, $barang->stok - $val['jumlah']),
            ]);
        }

        // Hapus session cartPemakaian atau keranjang belanja
        $request->session()->forget('cartPemakaian');

        return redirect()->route('pemakaian.index')->with('success', 'Sukses, 1 Data berhasil ditambahkan!');
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
            'sub_total_harga' => 'required',
            'keterangan_pemakaian' => 'nullable',
        ]);

        // ambil data pemakaian detail
        $pemakaian_detail = PemakaianDetail::findOrFail($id);
        // cari data pemakaian berdasarkan pemakaian_id dari data pemakaian detail
        $pemakaian_id = $pemakaian_detail->pemakaian_id;

        // update data pemakaian
        $pemakaian = Pemakaian::findOrFail($pemakaian_id);
        $pemakaian->jenis_pemakaian = $request->jenis_pemakaian;
        $pemakaian->tgl_pemakaian = $request->tgl_pemakaian;
        $pemakaian->keterangan_pemakaian = $request->keterangan_pemakaian;
        $pemakaian->update();

        // Simpan jumlah lama dari pemakaian detail sebelum diperbarui
        $jumlahLama = $pemakaian_detail->jumlah;
        // Menghitung perubahan jumlah pemakaian
        $perubahanJumlah = $request->jumlah - $jumlahLama;

        // update data pemakaian detail
        $pemakaian_detail->jumlah = $request->jumlah;
        $pemakaian_detail->sub_total_harga = $request->sub_total_harga;
        $pemakaian_detail->update();

        // ambil seluruh data pemakaian detail yang memiliki pemakaian_id sama
        $grand_total_harga = PemakaianDetail::where('pemakaian_id', $pemakaian_id)->sum('sub_total_harga');
        // update grand total harga dari tabel pemakaians
        $pemakaian->grand_total_harga = $grand_total_harga;
        $pemakaian->update();

        // ambil barang_id dari data pemakaian detail
        $barang_id = $pemakaian_detail->barang_id;
        // cari barang berdasarkan barang_id pemakaian detail
        $barang = Barang::findOrFail($barang_id);
        $stokBaru = max(0, $barang->stok - $perubahanJumlah);
        $barang->stok = $stokBaru;
        $barang->update();

        return back()->with('success', 'Sukses, 1 Data berhasil diperbaharui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pemakaian_detail = PemakaianDetail::findOrFail($id);

        // ambil pemakaian_id dari data pemakaian detail
        $pemakaian_id = $pemakaian_detail->pemakaian_id;
        // Menghitung perubahan jumlah pemakaian
        $perubahanJumlah = -$pemakaian_detail->jumlah;

        // Mengupdate stok barang
        $barang = Barang::find($pemakaian_detail->barang_id);
        if ($barang) {
            $stokBaru = max(0, $barang->stok + $perubahanJumlah);
            $barang->update([
                'stok' => $stokBaru,
            ]);
        }

        // cari data pemakaian berdasarkan pemakaian_id
        $pemakaian = Pemakaian::findOrFail($pemakaian_id);
        // ambil seluruh data pemakaian detail yang memiliki pemakaian_id sama
        $grand_total_harga = PemakaianDetail::where('pemakaian_id', $pemakaian_id)->sum('sub_total_harga');

        // update grand total harga dari tabel pemakaians
        $pemakaian->grand_total_harga = $grand_total_harga;
        $pemakaian->update();

        // hapus data pemakaian detail
        $pemakaian_detail->delete();

        return back()->with('success', 'Sukses, 1 Data berhasil dihapus!');
    }

    public function cariPemakaian(Request $request)
    {
        $keyword = $request->input('keyword');
        $pemakaian_details = PemakaianDetail::join('barangs', 'pemakaian_details.barang_id', '=', 'barangs.id')
            ->join('pemakaians', 'pemakaian_details.pemakaian_id', '=', 'pemakaians.id')
            ->where(function ($query) use ($keyword) {
                $query->where('barangs.nama_barang', 'like', '%' . $keyword . '%')
                    ->orWhere('pemakaians.jenis_pemakaian', 'like', '%' . $keyword . '%')
                    ->orWhere('pemakaians.tgl_pemakaian', 'like', '%' . $keyword . '%')
                    ->orWhere('pemakaians.keterangan_pemakaian', 'like', '%' . $keyword . '%');
            })
            ->orWhere('pemakaian_details.jumlah', 'like', '%' . $keyword . '%')
            ->select('pemakaian_details.*')
            ->paginate(10)
            ->withQueryString();
        $barangs = Barang::all();

        return view('backend.pemakaian.index', compact('pemakaian_details', 'barangs'));
    }
}
