@extends('backend.templates.layouts.main')
@section('content')
<div class="container">
    <div class="heading d-flex justify-content-center align-items-center flex-column">
        <h3 class=" fw-bold">PT. DAHLIA BINA UTAMA</h3>
        <h5 class=" fw-bold">Laporan Proyek {{ $judul }}</h5>
        <h4 class=" fw-bold">Jln. M. Yakup Kel. Sei Kera Hilir No 166 A Telp (061) 457950</h4>
    </div>
    <div class="tanggal">
        @if (isset($bulan))
        <h5 class=" fw-bold mt-3">Bulan : {{ $bulan }} <span class="ms-4">Tahun : {{ $tahun }}</span></h5>
        @elseif (isset($tahun))
        <h5 class=" fw-bold mt-3">Tahun : {{ $tahun }}</span></h5>
        @endif
    </div>
    <div class="tabel">
        <table class="table table-bordered">
            @if ($proyeks->isNotEmpty())
            <thead>
                <tr>
                    <th class="text-center col-1 text-wrap">No</th>
                    <th class="text-center col-1 text-wrap">No Faktur</th>
                    <th class="text-center col-1 text-wrap">Tanggal</th>
                    <th class="text-center col-1 text-wrap">Nama Barang</th>
                    <th class="text-center col-1 text-wrap">Jumlah</th>
                    <th class="text-center col-1 text-wrap">Sub Total Harga</th>
                    <th class="text-center col-1 text-wrap">Jlh Bayar</th>
                    <th class="text-center col-1 text-wrap">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proyeks as $key => $item)
                <tr class="align-middle">
                    <td class="text-center col-1 text-wrap">{{ $key + 1 }}</td>
                    <td class="text-center col-1 text-wrap">{{ $item->no_fakt_proyek }}</td>
                    <td class="text-center col-1 text-wrap">{{ $item->tgl_proyek }}</td>
                    <td class="text-center col-1 text-wrap">
                        <ul>
                            @foreach ($item->proyek_detail as $detail)
                            <li>
                                {{ $detail->barang->nama_barang }}
                            </li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="text-center col-1 text-wrap">
                        <ul>
                            @foreach ($item->proyek_detail as $detail)
                            <li>
                                {{ number_format($detail->jumlah) . ' ' . $detail->barang->jenis }}
                            </li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="text-center col-1 text-wrap">
                        <ul>
                            @foreach ($item->proyek_detail as $detail)
                            <li>
                                {{ 'Rp. ' . number_format($detail->sub_total_harga) }}
                            </li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="text-center col-1 text-wrap">
                        <p class="badge badge-success text-success rounded-pill fw-light mt-1">
                            Panjar : {{ 'Rp. ' . number_format($item->panjar) }}
                        </p>
                        @if ($item->grand_total_harga == $item->panjar + $item->sisa)
                        <p class="badge badge-success text-success rounded-pill fw-light mt-1">
                            Sisa : {{ 'Rp. ' . number_format($item->sisa) }}
                        </p>
                        @else
                        <p class="badge badge-danger text-danger rounded-pill fw-light mt-1">
                            Sisa : belum pelunasan
                        </p>
                        @endif
                    </td>
                    <td class="text-center col-1 text-wrap">{{ $item->status }}</td>
                </tr>
                @endforeach
                <tr class="align-middle">
                    <td class="text-center fw-bold" colspan="6">GRAND TOTAL</td>
                    <td class="text-center fw-bold">{{ 'Rp. ' . number_format($ttl_harga) }}</td>
                    <td class="text-center fw-bold"></td>
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