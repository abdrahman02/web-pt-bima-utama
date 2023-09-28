<?php

namespace App\Http\Controllers\Backend\Cart;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartProyekController extends Controller
{
    public function store(Request $request)
    {
        $cartProyek = session('cartProyek');
        $barang = Barang::findOrFail($request->barang_id);
        $harga_jual = $barang->harga_jual;

        // Generate unique ID for the cart item
        $uniqueId = uniqid();
        $newCartItem = [
            'id' => $uniqueId,
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'harga_jual_peritem' => $harga_jual,
            'sub_total_harga' => $request->jumlah * $harga_jual,
        ];

        // Tambahkan item baru ke keranjang dengan ID unik (misalnya, menggunakan waktu saat ini sebagai ID)
        $cartProyek[$uniqueId] = $newCartItem;

        // Perbarui sesi keranjang
        session(['cartProyek' => $cartProyek]);

        return back()->with('success', 'Sukses, Berhasil menambahkan 1 data ke keranjang!');
    }

    public function destroy(Request $request, String $id)
    {
        $request->session()->forget('cartProyek.' . $id);
        return back()->with('success', 'Sukses, Berhasil menghapus 1 data dari keranjang!');
    }
}
