<?php

namespace App\Http\Controllers\Backend;

use App\Models\Barang;
use App\Models\Proyek;
use App\Models\Pelanggan;
use App\Models\ProyekDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proyek_details = ProyekDetail::latest()->paginate(10)->withQueryString();
        $barangs = Barang::all();
        $pelanggans = Pelanggan::all();
        return view('backend.proyek.index', compact('barangs', 'pelanggans', 'proyek_details'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cartProyek = session('cartProyek', []);
        $grandTotal = 0;
        if (!empty($cartProyek)) {
            foreach ($cartProyek as $item) {
                $grandTotal += $item['sub_total_harga'];
            }
        }
        $barangs = Barang::all();
        $pelanggans = Pelanggan::all();
        return view('backend.proyek.create', compact('pelanggans', 'barangs', 'cartProyek', 'grandTotal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cartProyek = session('cartProyek');
        $request->validate([
            'pelanggan_id' => 'required',
            'no_fakt_proyek' => 'required',
            'tgl_proyek' => 'required',
            'status' => 'required',
            'grand_total_harga' => 'required',
            'panjar' => 'required'
        ]);

        // Simpan data proyek
        $proyek = new Proyek();
        $proyek->pelanggan_id = $request->pelanggan_id;
        $proyek->no_fakt_proyek = $request->no_fakt_proyek;
        $proyek->tgl_proyek = $request->tgl_proyek;
        // Menghapus "Rp. " dan tanda koma (",") dari grand_total_harga dan panjar jika diperlukan
        $grand_total_harga = $request->grand_total_harga;
        $panjar = $request->panjar;
        if (strpos($grand_total_harga, 'Rp. ') !== false) {
            $grand_total_harga = str_replace('Rp. ', '', $grand_total_harga);
        }
        if (strpos($grand_total_harga, ',') !== false) {
            $grand_total_harga = str_replace(',', '', $grand_total_harga);
        }

        if (strpos($panjar, 'Rp. ') !== false) {
            $panjar = str_replace('Rp. ', '', $panjar);
        }
        if (strpos($panjar, ',') !== false) {
            $panjar = str_replace(',', '', $panjar);
        }
        //
        $proyek->grand_total_harga = $grand_total_harga;
        $proyek->panjar = $panjar;
        $proyek->status = $request->status;
        $proyek->save();

        foreach ($cartProyek as $val) {
            ProyekDetail::create([
                'proyek_id' => $proyek->id,
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

        // Hapus session cartProyek atau keranjang belanja
        $request->session()->forget('cartProyek');

        return redirect()->route('proyek.index')->with('success', 'Sukses, 1 Data berhasil ditambahkan!');
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
            'no_fakt_proyek' => 'required',
            'tgl_proyek' => 'required',
            'jumlah' => 'required',
            'status' => 'required',
            'sub_total_harga' => 'required',
            'panjar' => 'required',
        ]);
        // ambil data proyek detail
        $proyek_detail = ProyekDetail::findOrFail($id);
        // cari data proyek berdasarkan proyek_id dari data proyek detail
        $proyek_id = $proyek_detail->proyek_id;

        // update data proyek
        $proyek = Proyek::findOrFail($proyek_id);
        $proyek->no_fakt_proyek = $request->no_fakt_proyek;
        $proyek->tgl_proyek = $request->tgl_proyek;
        $proyek->status = $request->status;
        $proyek->panjar = $request->panjar;
        $proyek->sisa = $request->sisa;
        $proyek->update();

        // Simpan jumlah lama dari proyek detail sebelum diperbarui
        $jumlahLama = $proyek_detail->jumlah;
        // Menghitung perubahan jumlah proyek
        $perubahanJumlah = $request->jumlah - $jumlahLama;

        // update data proyek detail
        $proyek_detail->jumlah = $request->jumlah;
        $proyek_detail->sub_total_harga = $request->sub_total_harga;
        $proyek_detail->update();

        // ambil seluruh data proyek detail yang memiliki proyek_id sama
        $grand_total_harga = ProyekDetail::where('proyek_id', $proyek_id)->sum('sub_total_harga');
        // update grand total harga dari tabel proyeks
        $proyek->grand_total_harga = $grand_total_harga;
        $proyek->update();

        // ambil barang_id dari data proyek detail
        $barang_id = $proyek_detail->barang_id;
        // cari barang berdasarkan barang_id proyek detail
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
        $proyek_detail = ProyekDetail::findOrFail($id);

        // ambil proyek_id dari data proyek detail
        $proyek_id = $proyek_detail->proyek_id;
        // Menghitung perubahan jumlah proyek
        $perubahanJumlah = -$proyek_detail->jumlah;

        // Mengupdate stok barang
        $barang = Barang::find($proyek_detail->barang_id);
        if ($barang) {
            $stokBaru = max(0, $barang->stok + $perubahanJumlah);
            $barang->update([
                'stok' => $stokBaru,
            ]);
        }

        // cari data proyek berdasarkan proyek_id
        $proyek = Proyek::findOrFail($proyek_id);
        // ambil seluruh data proyek detail yang memiliki proyek_id sama
        $grand_total_harga = ProyekDetail::where('proyek_id', $proyek_id)->sum('sub_total_harga');


        // update grand total harga dari tabel proyeks
        $proyek->grand_total_harga = $grand_total_harga;
        $proyek->update();

        // hapus data proyek detail
        $proyek_detail->delete();

        return back()->with('success', 'Sukses, 1 Data berhasil dihapus!');
    }

    public function cariProyek(Request $request)
    {
        $keyword = $request->input('keyword');

        $proyek_details = ProyekDetail::join('barangs', 'proyek_details.barang_id', '=', 'barangs.id')
            ->join('proyeks', 'proyek_details.proyek_id', '=', 'proyeks.id')
            ->join('pelanggans', 'proyeks.pelanggan_id', '=', 'pelanggans.id') // Join juga dengan tabel pelanggan
            ->where(function ($query) use ($keyword) {
                $query->where('barangs.nama_barang', 'like', '%' . $keyword . '%')
                    ->orWhere('barangs.harga_jual', 'like', '%' . $keyword . '%')
                    ->orWhere('proyeks.no_fakt_proyek', 'like', '%' . $keyword . '%')
                    ->orWhere('proyeks.tgl_proyek', 'like', '%' . $keyword . '%')
                    ->orWhere('proyeks.status', 'like', '%' . $keyword . '%')
                    ->orWhere('proyeks.panjar', 'like', '%' . $keyword . '%')
                    ->orWhere('proyeks.sisa', 'like', '%' . $keyword . '%')
                    ->orWhere('proyeks.grand_total_harga', 'like', '%' . $keyword . '%')
                    ->orWhere('pelanggans.nama_pelanggan', 'like', '%' . $keyword . '%'); // Cari juga berdasarkan nama pelanggan
            })
            ->orWhere('proyek_details.jumlah', 'like', '%' . $keyword . '%')
            ->orWhere('proyek_details.sub_total_harga', 'like', '%' . $keyword . '%')
            ->select('proyek_details.*')
            ->paginate(10)
            ->withQueryString();

        $barangs = Barang::all();
        $pelanggans = Pelanggan::all();

        return view('backend.proyek.index', compact('proyek_details', 'barangs', 'pelanggans'));
    }

    public function invoicePanjar(String $id)
    {
        $proyek_details = ProyekDetail::where('proyek_id', $id)->get();
        $proyek = Proyek::findOrFail($id);
        return view('backend.templates.proyek.invoice-panjar', compact('proyek_details', 'proyek'));
    }

    public function invoiceSisa(String $id)
    {
        $proyek_details = ProyekDetail::where('proyek_id', $id)->get();
        $proyek = Proyek::findOrFail($id);
        return view('backend.templates.proyek.invoice-sisa', compact('proyek_details', 'proyek'));
    }
}
