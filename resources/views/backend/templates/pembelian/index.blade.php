@extends('backend.templates.layouts.main')
@section('content')
<div class="container">
    <div class="heading d-flex justify-content-center align-items-center flex-column">
        <h3 class=" fw-bold">PT. DAHLIA BINA UTAMA</h3>
        <h5 class=" fw-bold">Laporan Pembelian Barang {{ $judul }}</h5>
        <h4 class=" fw-bold">Jln. M. Yakup Kel. Sei Kera Hilir No 166 A Telp (061) 457950</h4>
    </div>
    <div class="tanggal">
        @if (isset($tgl_pembelian))
        <h5 class=" fw-bold mt-3">Tanggal : {{ date('d m Y', strtotime($tgl_pembelian)) }}</h5>
        @elseif (isset($tgl_pembelian_awal))
        <h5 class=" fw-bold mt-3">Tanggal : {{ date('d m Y', strtotime($tgl_pembelian_awal)) }} - {{ date('d m Y',
            strtotime($tgl_pembelian_akhir)) }}</h5>
        @elseif (isset($bulan))
        <h5 class=" fw-bold mt-3">Bulan : {{ $bulan }} <span class="ms-4">Tahun : {{ $tahun }}</span></h5>
        @elseif (isset($tahun))
        <h5 class=" fw-bold mt-3">Tahun : {{ $tahun }}</span></h5>
        @endif
    </div>
    <div class="tabel">
        <table class="table table-bordered">
            @if ($pembelians->isNotEmpty())
            <thead>
                <tr>
                    <th class="text-center col-1 text-wrap">No</th>
                    <th class="text-center col-1 text-wrap">No Faktur</th>
                    <th class="text-center col-1 text-wrap">Tanggal</th>
                    <th class="text-center col-1 text-wrap">Nama Suplier</th>
                    <th class="text-center col-1 text-wrap">Nama Barang</th>
                    <th class="text-center col-1 text-wrap">Jumlah</th>
                    <th class="text-center col-1 text-wrap">Sub Total Harga</th>
                    <th class="text-center col-1 text-wrap">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembelians as $key => $item)
                <tr>
                    <td class="text-center col-1">{{ $key + 1 }}</td>
                    <td class="text-center col-1">{{ $item->no_fakt_pembelian }}</td>
                    <td class="text-center col-1">{{ $item->tgl_pembelian }}</td>
                    <td class="text-center col-1">{{ $item->suplier->nama_suplier }}</td>
                    <td class="text-center col-1">
                        <ul>
                            @foreach ($item->pembelian_detail as $detail)
                            <li>
                                {{ $detail->barang->nama_barang }}
                            </li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="text-center col-1">
                        <ul>
                            @foreach ($item->pembelian_detail as $detail)
                            <li>
                                {{ number_format($detail->jumlah) . ' ' . $detail->barang->jenis }}
                            </li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="text-center col-1">
                        <ul>
                            @foreach ($item->pembelian_detail as $detail)
                            <li>
                                {{ 'Rp. ' . number_format($detail->sub_total_harga) }}
                            </li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="text-center col-1">{{ $item->status }}</td>
                </tr>
                @endforeach
                <tr>
                    <td class="text-center fw-bold" colspan="6">GRAND TOTAL</td>
                    <td class="text-center fw-bold">{{ 'Rp. ' . number_format($ttl_harga) }}</td>
                    <td class="text-center fw-bold">&nbsp;</td>
                </tr>
            </tbody>
            @else
            <div class="alert alert-primary text-center" role="alert">
                Data kosong!!
            </div>
            @endif
        </table>
        <div class="ttd my-4 float-end">
            <div class="d-flex flex-column justify-content-center">
                <h5>Medan, {{ now()->format('d m Y') }}</h5>
                <h5 class="fw-bold mx-auto">Kasir</h5>
                <br>
                <br>
                <br>
                <span>(_____________)</span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-js')
<script>
    window.print();
</script>
@endpush