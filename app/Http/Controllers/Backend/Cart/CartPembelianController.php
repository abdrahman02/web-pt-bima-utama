<?php

namespace App\Http\Controllers\Backend\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartPembelianController extends Controller
{
    public function store(Request $request)
    {
        $cartPembelian = session('cartPembelian');

        // Generate unique ID for the cart item
        $uniqueId = uniqid();
        $newCartItem = [
            'id' => $uniqueId,
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'harga_peritem' => $request->harga_peritem,
            'sub_total_harga' => $request->jumlah * $request->harga_peritem,
        ];

        // Tambahkan item baru ke keranjang dengan ID unik (misalnya, menggunakan waktu saat ini sebagai ID)
        $cartPembelian[$uniqueId] = $newCartItem;

        // Perbarui sesi keranjang
        session(['cartPembelian' => $cartPembelian]);

        return back()->with('success', 'Sukses, Berhasil menambahkan 1 data ke keranjang!');
    }

    public function destroy(Request $request, String $id)
    {
        $request->session()->forget('cartPembelian.' . $id);
        return back()->with('success', 'Sukses, Berhasil menghapus 1 data dari keranjang!');
    }
}
