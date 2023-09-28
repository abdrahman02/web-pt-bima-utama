<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Proyek;
use Illuminate\Http\Request;

class LaporanProyekController extends Controller
{
    public function index()
    {
        return view('backend.reports.proyek.index');
    }

    public function bulanan()
    {
        return view('backend.reports.proyek.perbulan');
    }

    public function cetakBulanan($bln_proyek)
    {
        list($tahun, $bulan) = explode("-", $bln_proyek);
        $proyeks = Proyek::whereYear('tgl_proyek', $tahun)->whereMonth('tgl_proyek', $bulan)->get();
        $ttl_panjar = $proyeks->sum('panjar');
        $ttl_sisa = $proyeks->sum('sisa');
        $ttl_harga = $ttl_panjar + $ttl_sisa;
        $judul = 'Bulanan';
        return view('backend.templates.proyek.index', compact('proyeks', 'judul', 'tahun', 'bulan', 'ttl_harga'));
    }

    public function tahunan()
    {
        // Menggunakan model Proyek untuk mengambil tahun proyek unik
        $tahun_proyek = Proyek::selectRaw('YEAR(tgl_proyek) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->get();
        return view('backend.reports.proyek.pertahun', compact('tahun_proyek'));
    }

    public function cetakTahunan($thn_proyek)
    {
        $proyeks = Proyek::whereYear('tgl_proyek', $thn_proyek)->get();
        $tahun = $thn_proyek;
        $ttl_panjar = $proyeks->sum('panjar');
        $ttl_sisa = $proyeks->sum('sisa');
        $ttl_harga = $ttl_panjar + $ttl_sisa;
        $judul = 'Tahunan';
        return view('backend.templates.proyek.index', compact('proyeks', 'judul', 'tahun', 'ttl_harga'));
    }
}
