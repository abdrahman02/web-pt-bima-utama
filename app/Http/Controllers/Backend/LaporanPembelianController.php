<?php

namespace App\Http\Controllers\Backend;

use App\Models\Pembelian;
use Illuminate\Http\Request;
use App\Models\PembelianDetail;
use App\Http\Controllers\Controller;

class LaporanPembelianController extends Controller
{
    public function index()
    {
        return view('backend.reports.pembelian.index');
    }

    public function harian()
    {
        return view('backend.reports.pembelian.perhari');
    }

    public function cetakHarian($tgl_pembelian)
    {
        // Mengambil data pembelian berdasarkan tanggal yang dipilih
        $pembelians = Pembelian::whereDate('tgl_pembelian', $tgl_pembelian)->get();

        // Menghitung total harga pembelian
        $ttl_harga = Pembelian::whereDate('tgl_pembelian', $tgl_pembelian)->sum('grand_total_harga');

        // tambahkan judul
        $judul = 'Harian';
        return view('backend.templates.pembelian.index', compact('pembelians', 'judul', 'tgl_pembelian', 'ttl_harga'));
    }

    public function mingguan()
    {
        return view('backend.reports.pembelian.perminggu');
    }

    public function cetakMingguan($tgl_pembelian_awal, $tgl_pembelian_akhir)
    {
        // Mengambil data pembelian berdasarkan range tanggal yang dipilih
        $pembelians = Pembelian::whereBetween('tgl_pembelian', [$tgl_pembelian_awal, $tgl_pembelian_akhir])->get();

        // Menghitung total harga pembelian
        $ttl_harga = Pembelian::whereBetween('tgl_pembelian', [$tgl_pembelian_awal, $tgl_pembelian_akhir])->sum('grand_total_harga');

        // tambahkan judul
        $judul = 'Mingguan';

        return view('backend.templates.pembelian.index', compact('pembelians', 'judul', 'tgl_pembelian_awal', 'tgl_pembelian_akhir', 'ttl_harga'));
    }

    public function bulanan()
    {
        return view('backend.reports.pembelian.perbulan');
    }

    public function cetakBulanan($bln_pembelian)
    {
        // buat variabel bulan dan tahun
        list($tahun, $bulan) = explode("-", $bln_pembelian);

        // Mengambil data pembelian berdasarkan range tanggal yang dipilih
        $pembelians = Pembelian::whereYear('tgl_pembelian', $tahun)->whereMonth('tgl_pembelian', $bulan)->get();

        // Menghitung total harga pembelian
        $ttl_harga = Pembelian::whereYear('tgl_pembelian', $tahun)->whereMonth('tgl_pembelian', $bulan)->sum('grand_total_harga');

        // tambahkan judul
        $judul = 'Bulanan';
        return view('backend.templates.pembelian.index', compact('pembelians', 'judul', 'tahun', 'bulan', 'ttl_harga'));
    }

    public function tahunan()
    {
        // Menggunakan model Pembelian untuk mengambil tahun pembelian unik
        $tahun_pembelian = Pembelian::selectRaw('YEAR(tgl_pembelian) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();
        return view('backend.reports.pembelian.pertahun', compact('tahun_pembelian'));
    }

    public function cetakTahunan($thn_pembelian)
    {
        // Mengambil data pembelian berdasarkan range tanggal yang dipilih
        $pembelians = Pembelian::whereYear('tgl_pembelian', $thn_pembelian)->get();

        // Menghitung total harga pembelian
        $ttl_harga = Pembelian::whereYear('tgl_pembelian', $thn_pembelian)->sum('grand_total_harga');

        // buat variable tahun
        $tahun = $thn_pembelian;

        // tambahkan judul
        $judul = 'Tahunan';

        return view('backend.templates.pembelian.index', compact('pembelians', 'judul', 'tahun', 'ttl_harga'));
    }
}
