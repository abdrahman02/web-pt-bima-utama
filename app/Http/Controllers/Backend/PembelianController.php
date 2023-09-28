<?php

namespace App\Http\Controllers\Backend;

use App\Models\Barang;
use App\Models\Suplier;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use App\Models\PembelianDetail;
use App\Http\Controllers\Controller;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barangs = Barang::all();
        $supliers = Suplier::all();
        $pembelian_details = PembelianDetail::latest()->paginate(10)->withQueryString();
        return view('backend.pembelian.index', compact('barangs', 'supliers', 'pembelian_details'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cartPembelian = session('cartPembelian', []);
        $grandTotal = 0;
        if (!empty($cartPembelian)) {
            foreach ($cartPembelian as $item) {
                $grandTotal += $item['sub_total_harga'];
            }
        }
        $supliers = Suplier::all();
        $barangs = Barang::all();
        return view('backend.pembelian.create', compact('supliers', 'barangs', 'cartPembelian', 'grandTotal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cartPembelian = session('cartPembelian');
        $request->validate([
            'suplier_id' => 'required',
            'no_fakt_pembelian' => 'required',
            'tgl_pembelian' => 'required',
            'status' => 'required',
            'grand_total_harga' => 'required',
            'jumlah_bayar' => 'required',
        ]);

        // Simpan data pembelian
        $pembelian = new Pembelian();
        $pembelian->suplier_id = $request->suplier_id;
        $pembelian->no_fakt_pembelian = $request->no_fakt_pembelian;
        $pembelian->tgl_pembelian = $request->tgl_pembelian;
        $pembelian->status = $request->status;
        // Menghapus "Rp. " dan tanda koma (",") dari grand_total_harga dan jumlah_bayar jika diperlukan
        $grand_total_harga = $request->grand_total_harga;
        $jumlah_bayar = $request->jumlah_bayar;
        if (strpos($grand_total_harga, 'Rp. ') !== false) {
            $grand_total_harga = str_replace('Rp. ', '', $grand_total_harga);
        }
        if (strpos($grand_total_harga, ',') !== false) {
            $grand_total_harga = str_replace(',', '', $grand_total_harga);
        }

        if (strpos($jumlah_bayar, 'Rp. ') !== false) {
            $jumlah_bayar = str_replace('Rp. ', '', $jumlah_bayar);
        }
        if (strpos($jumlah_bayar, ',') !== false) {
            $jumlah_bayar = str_replace(',', '', $jumlah_bayar);
        }
        //
        $pembelian->grand_total_harga = $grand_total_harga;
        $pembelian->jumlah_bayar = $jumlah_bayar;
        $pembelian->save();

        foreach ($cartPembelian as $val) {
            PembelianDetail::create([
                'pembelian_id' => $pembelian->id,
                'barang_id' => $val['barang_id'],
                'jumlah' => $val['jumlah'],
                'sub_total_harga' => $val['sub_total_harga'],
            ]);
            // Membuat instance model Barang berdasarkan ID
            $barang = Barang::findOrFail($val['barang_id']);

            // Memanggil metode update pada instance Barang
            $barang->update([
                'stok' => max(0, $barang->stok + $val['jumlah']),
                'harga_beli_peritem' => $val['harga_peritem'],
                'total_harga_beli' => $val['sub_total_harga'],
            ]);
        }

        // Hapus session cartPembelian atau keranjang belanja
        $request->session()->forget('cartPembelian');

        return redirect()->route('pembelian.index')->with('success', 'Sukses, 1 Data berhasil ditambahkan!');
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
            'no_fakt_pembelian' => 'required',
            'tgl_pembelian' => 'required',
            'jumlah' => 'required', //
            'status' => 'required',
            'harga_peritem' => 'required', //
            'jumlah_bayar' => 'required'
        ]);

        // ambil data pembelian detail
        $pembelian_detail = PembelianDetail::findOrFail($id);
        // cari data pembelian berdasarkan pembelian_id dari data pembelian detail
        $pembelian_id = $pembelian_detail->pembelian_id;

        // update data pembelian
        $pembelian = Pembelian::findOrFail($pembelian_id);
        $pembelian->no_fakt_pembelian = $request->no_fakt_pembelian;
        $pembelian->tgl_pembelian = $request->tgl_pembelian;
        $pembelian->status = $request->status;
        $pembelian->jumlah_bayar = $request->jumlah_bayar;
        $pembelian->update();

        // Simpan jumlah lama dari pembelian detail sebelum diperbarui
        $jumlahLama = $pembelian_detail->jumlah;
        // Menghitung perubahan jumlah pembelian
        $perubahanJumlah = $request->jumlah - $jumlahLama;
        // update data pembelian detail
        $pembelian_detail->jumlah = $request->jumlah;
        $pembelian_detail->sub_total_harga = $request->sub_total_harga;
        $pembelian_detail->update();

        // ambil seluruh data pembelian detail yang memiliki pembelian_id sama
        $grand_total_harga = PembelianDetail::where('pembelian_id', $pembelian_id)->sum('sub_total_harga');
        // update grand total harga dari tabel pembelians
        $pembelian->grand_total_harga = $grand_total_harga;
        $pembelian->update();

        // ambil barang_id dari data pembelian detail
        $barang_id = $pembelian_detail->barang_id;
        // cari barang berdasarkan barang_id pembelian detail
        $barang = Barang::findOrFail($barang_id);
        $stokBaru = max(0, $barang->stok + $perubahanJumlah);
        $barang->stok = $stokBaru;
        $barang->update();

        return back()->with('success', 'Sukses, 1 Data berhasil diperbaharui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pembelian_detail = PembelianDetail::findOrFail($id);

        // ambil pembelian_id dari data pembelian detail
        $pembelian_id = $pembelian_detail->pembelian_id;
        // Menghitung perubahan jumlah pembelian
        $perubahanJumlah = -$pembelian_detail->jumlah;

        // Mengupdate stok barang
        $barang = Barang::find($pembelian_detail->barang_id);
        if ($barang) {
            $stokBaru = max(0, $barang->stok + $perubahanJumlah);
            $barang->update([
                'stok' => $stokBaru,
            ]);
        }

        // cari data pembelian berdasarkan pembelian_id
        $pembelian = Pembelian::findOrFail($pembelian_id);
        // ambil seluruh data pembelian detail yang memiliki pembelian_id sama
        $grand_total_harga = PembelianDetail::where('pembelian_id', $pembelian_id)->sum('sub_total_harga');


        // update grand total harga dari tabel pembelians
        $pembelian->grand_total_harga = $grand_total_harga;
        $pembelian->update();

        // hapus data pembelian detail
        $pembelian_detail->delete();

        return back()->with('success', 'Sukses, 1 Data berhasil dihapus!');
    }

    public function cariPembelian(Request $request)
    {
        $keyword = $request->input('keyword');

        $pembelian_details = PembelianDetail::join('barangs', 'pembelian_details.barang_id', '=', 'barangs.id')
            ->join('pembelians', 'pembelian_details.pembelian_id', '=', 'pembelians.id')
            ->join('supliers', 'pembelians.suplier_id', '=', 'supliers.id') // Join juga dengan tabel Suplier
            ->where(function ($query) use ($keyword) {
                $query->where('barangs.nama_barang', 'like', '%' . $keyword . '%')
                    ->orWhere('barangs.harga_beli_peritem', 'like', '%' . $keyword . '%')
                    ->orWhere('pembelians.no_fakt_pembelian', 'like', '%' . $keyword . '%')
                    ->orWhere('pembelians.tgl_pembelian', 'like', '%' . $keyword . '%')
                    ->orWhere('pembelians.status', 'like', '%' . $keyword . '%')
                    ->orWhere('pembelians.jumlah_bayar', 'like', '%' . $keyword . '%')
                    ->orWhere('pembelians.grand_total_harga', 'like', '%' . $keyword . '%')
                    ->orWhere('supliers.nama_suplier', 'like', '%' . $keyword . '%'); // Cari juga berdasarkan nama suplier
            })
            ->orWhere('pembelian_details.jumlah', 'like', '%' . $keyword . '%')
            ->orWhere('pembelian_details.sub_total_harga', 'like', '%' . $keyword . '%')
            ->select('pembelian_details.*')
            ->paginate(10)
            ->withQueryString();

        $barangs = Barang::all();
        $supliers = Suplier::all();

        return view('backend.pembelian.index', compact('pembelian_details', 'barangs', 'supliers'));
    }
}
