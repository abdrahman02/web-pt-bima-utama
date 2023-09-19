@extends('backend.templates.layouts.main')
@section('content')
<div class="container">
    <div class="heading d-flex justify-content-center align-items-center flex-column">
        <h3 class=" fw-bold">PT. DAHLIA BINA UTAMA</h3>
        <h5 class=" fw-bold">Daftar Barang</h5>
        <h4 class=" fw-bold">Jln. M. Yakup Kel. Sei Kera Hilir No 166 A Telp (061) 457950</h4>
    </div>
    <div class="tabel">
        <table class="table table-bordered">
            @if ($barangs->isNotEmpty())
            <thead>
                <tr>
                    <th class="text-center col-1 text-wrap">No</th>
                    <th class="text-center col-1 text-wrap">Id Barang</th>
                    <th class="text-center col-1 text-wrap">Nama Barang</th>
                    <th class="text-center col-1 text-wrap">Jenis</th>
                    <th class="text-center col-1 text-wrap">Harga Beli</th>
                    <th class="text-center col-1 text-wrap">Harga Jual</th>
                    <th class="text-center col-1 text-wrap">Stok</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barangs as $key => $item)
                <tr class="align-middle">
                    <td class="text-center col-1 text-wrap">{{ $key + 1 }}</td>
                    <td class="text-center col-1 text-wrap">{{ $item->id }}</td>
                    <td class="text-center col-1 text-wrap">{{ $item->nama_barang }}</td>
                    <td class="text-center col-1 text-wrap">{{ $item->jenis }}</td>
                    <td class="text-center col-1 text-wrap">{{ $item->harga_beli }}</td>
                    <td class="text-center col-1 text-wrap">{{ $item->harga_jual }}/{{ $item->jenis }}</td>
                    <td class="text-center col-1 text-wrap">{{ $item->stok }}</td>
                </tr>
                @endforeach
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