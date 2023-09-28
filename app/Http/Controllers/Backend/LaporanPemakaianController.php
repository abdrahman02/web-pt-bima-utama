<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Pemakaian;
use Illuminate\Http\Request;

class LaporanPemakaianController extends Controller
{
    public function index()
    {
        return view('backend.reports.pemakaian.index');
    }

    public function harian()
    {
        return view('backend.reports.pemakaian.perhari');
    }

    public function cetakHarian($tgl_pemakaian)
    {
        // Mengambil data pemakaian berdasarkan tanggal yang dipilih
        $pemakaians = Pemakaian::whereDate('tgl_pemakaian', $tgl_pemakaian)->get();

        // Menghitung total harga pemakaian
        $ttl_harga = Pemakaian::whereDate('tgl_pemakaian', $tgl_pemakaian)->sum('grand_total_harga');

        // tambahkan judul
        $judul = 'Harian';

        return view('backend.templates.pemakaian.index', compact('pemakaians', 'judul', 'tgl_pemakaian', 'ttl_harga'));
    }

    public function mingguan()
    {
        return view('backend.reports.pemakaian.perminggu');
    }

    public function cetakMingguan($tgl_pemakaian_awal, $tgl_pemakaian_akhir)
    {
        // Mengambil data pemakaian berdasarkan range tanggal yang dipilih
        $pemakaians = Pemakaian::whereBetween('tgl_pemakaian', [$tgl_pemakaian_awal, $tgl_pemakaian_akhir])->get();

        // Menghitung total harga pemakaian
        $ttl_harga = Pemakaian::whereBetween('tgl_pemakaian', [$tgl_pemakaian_awal, $tgl_pemakaian_akhir])->sum('grand_total_harga');

        // tambahkan judul
        $judul = 'Mingguan';

        return view('backend.templates.pemakaian.index', compact('pemakaians', 'judul', 'tgl_pemakaian_awal', 'tgl_pemakaian_akhir', 'ttl_harga'));
    }

    public function bulanan()
    {
        return view('backend.reports.pemakaian.perbulan');
    }

    public function cetakBulanan($bln_pemakaian)
    {
        // buat variabel bulan dan tahun
        list($tahun, $bulan) = explode("-", $bln_pemakaian);

        // Mengambil data pemakaian berdasarkan range tanggal yang dipilih
        $pemakaians = Pemakaian::whereYear('tgl_pemakaian', $tahun)->whereMonth('tgl_pemakaian', $bulan)->get();

        // Menghitung total harga pemakaian
        $ttl_harga = Pemakaian::whereYear('tgl_pemakaian', $tahun)->whereMonth('tgl_pemakaian', $bulan)->sum('grand_total_harga');

        // tambahkan judul
        $judul = 'Bulanan';

        return view('backend.templates.pemakaian.index', compact('pemakaians', 'judul', 'tahun', 'bulan', 'ttl_harga'));
    }

    public function tahunan()
    {
        // Menggunakan model Pemakaian untuk mengambil tahun pemakaian unik
        $tahun_pemakaian = Pemakaian::selectRaw('YEAR(tgl_pemakaian) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();
        return view('backend.reports.pemakaian.pertahun', compact('tahun_pemakaian'));
    }

    public function cetakTahunan($thn_pemakaian)
    {
        // Mengambil data pemakaian berdasarkan range tanggal yang dipilih
        $pemakaians = Pemakaian::whereYear('tgl_pemakaian', $thn_pemakaian)->get();

        // Menghitung total harga pemakaian
        $ttl_harga = Pemakaian::whereYear('tgl_pemakaian', $thn_pemakaian)->sum('grand_total_harga');

        // buat variable tahun
        $tahun = $thn_pemakaian;

        // tambahkan judul
        $judul = 'Tahunan';

        return view('backend.templates.pemakaian.index', compact('pemakaians', 'judul', 'tahun', 'ttl_harga'));
    }
}
