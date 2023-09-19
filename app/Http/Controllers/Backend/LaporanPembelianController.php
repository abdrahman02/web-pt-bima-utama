<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use Illuminate\Http\Request;

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
        $pembelians = Pembelian::where('tgl_pembelian', $tgl_pembelian)->get();
        $ttl_harga = $pembelians->sum('harga');
        $judul = 'Harian';
        $tgl_pembelian = $tgl_pembelian;
        return view('backend.templates.pembelian.index', compact('pembelians', 'judul', 'tgl_pembelian', 'ttl_harga'));
    }

    public function mingguan()
    {
        return view('backend.reports.pembelian.perminggu');
    }

    public function cetakMingguan($tgl_pembelian_awal, $tgl_pembelian_akhir)
    {
        $pembelians = Pembelian::whereBetween('tgl_pembelian', [$tgl_pembelian_awal, $tgl_pembelian_akhir])->get();
        $ttl_harga = $pembelians->sum('harga');
        $judul = 'Mingguan';
        $tgl_pembelian_awal = $tgl_pembelian_awal;
        $tgl_pembelian_akhir = $tgl_pembelian_akhir;
        return view('backend.templates.pembelian.index', compact('pembelians', 'judul', 'tgl_pembelian_awal', 'tgl_pembelian_akhir', 'ttl_harga'));
    }

    public function bulanan()
    {
        return view('backend.reports.pembelian.perbulan');
    }

    public function cetakBulanan($bln_pembelian)
    {
        list($tahun, $bulan) = explode("-", $bln_pembelian);
        $pembelians = Pembelian::whereYear('tgl_pembelian', $tahun)->whereMonth('tgl_pembelian', $bulan)->get();
        $ttl_harga = $pembelians->sum('harga');
        $judul = 'Bulanan';
        return view('backend.templates.pembelian.index', compact('pembelians', 'judul', 'tahun', 'bulan', 'ttl_harga'));
    }

    public function tahunan()
    {
        return view('backend.reports.pembelian.pertahun');
    }

    public function cetakTahunan($thn_pembelian)
    {
        list($tahun, $bulan) = explode("-", $thn_pembelian);
        $pembelians = Pembelian::whereYear('tgl_pembelian', $tahun)->get();
        $ttl_harga = $pembelians->sum('harga');
        $judul = 'Tahunan';
        return view('backend.templates.pembelian.index', compact('pembelians', 'judul', 'tahun', 'ttl_harga'));
    }
}
