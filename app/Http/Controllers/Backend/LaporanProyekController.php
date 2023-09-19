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
        $ttl_harga = $proyeks->sum('harga');
        $judul = 'Bulanan';
        return view('backend.templates.proyek.index', compact('proyeks', 'judul', 'tahun', 'bulan', 'ttl_harga'));
    }

    public function tahunan()
    {
        return view('backend.reports.proyek.pertahun');
    }

    public function cetakTahunan($thn_proyek)
    {
        list($tahun, $bulan) = explode("-", $thn_proyek);
        $proyeks = Proyek::whereYear('tgl_proyek', $tahun)->get();
        $ttl_harga = $proyeks->sum('harga');
        $judul = 'Tahunan';
        return view('backend.templates.proyek.index', compact('proyeks', 'judul', 'tahun', 'ttl_harga'));
    }
}
