@extends('backend.templates.layouts.main')
@section('content')
<div class="container">
    <div class="heading d-flex justify-content-center align-items-center flex-column">
        <h3 class=" fw-bold">PT. DAHLIA BINA UTAMA</h3>
        <h5 class=" fw-bold">Daftar Suplier</h5>
        <h4 class=" fw-bold">Jln. M. Yakup Kel. Sei Kera Hilir No 166 A Telp (061) 457950</h4>
    </div>
    <div class="tabel">
        <table class="table table-bordered">
            @if ($supliers->isNotEmpty())
            <thead>
                <tr>
                    <th class="text-center col-1 text-wrap">No</th>
                    <th class="text-center col-1 text-wrap">Id Suplier</th>
                    <th class="text-center col-1 text-wrap">Nama Suplier</th>
                    <th class="text-center col-1 text-wrap">Alamat</th>
                    <th class="text-center col-1 text-wrap">Telpon Suplier</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($supliers as $key => $item)
                <tr class="align-middle">
                    <td class="text-center col-1 text-wrap">{{ $key + 1 }}</td>
                    <td class="text-center col-1 text-wrap">{{ $item->id }}</td>
                    <td class="text-center col-1 text-wrap">{{ $item->nama_suplier }}</td>
                    <td class="text-center col-1 text-wrap">{{ $item->alamat }}</td>
                    <td class="text-center col-1 text-wrap">{{ $item->no_telp }}</td>
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