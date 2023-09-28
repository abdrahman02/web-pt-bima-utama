@extends('backend.templates.layouts.main')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="container mb-5 mt-3">
            <div class="row d-flex align-items-baseline">
                <div class="col-xl-9">
                    <p style="color: #7e8d9f;font-size: 20px;">Invoice >> <strong>ID PROYEK: {{ $proyek->id }}</strong>
                        /// <strong>NO FAKTUR: {{ $proyek->no_fakt_proyek }}</strong>
                    </p>
                </div>
                <hr>
            </div>

            <div class="container">
                <div class="col-md-12">
                    <div class="text-center">
                        <i class="fab fa-mdb fa-4x ms-0" style="color:#5d9fc5 ;"></i>
                        <p class="pt-0">PT. DAHLIA BINA UTAMA</p>
                    </div>

                </div>


                <div class="row">
                    <div class="col-xl-8">
                        <ul class="list-unstyled">
                            <li class="text-muted">Kepada: <span style="color:#5d9fc5 ;">{{
                                    $proyek->pelanggan->nama_pelanggan }}</span></li>
                            <li class="text-muted">Alamat: <span style="color:#5d9fc5 ;">{{
                                    $proyek->pelanggan->alamat }}</span></li>
                            <li class="text-muted">No Telp: <span style="color:#5d9fc5 ;">{{
                                    $proyek->pelanggan->no_telp }}</span></li>
                        </ul>
                    </div>
                    <div class="col-xl-4">
                        <p class="text-muted">Invoice</p>
                        <ul class="list-unstyled">
                            <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span
                                    class="fw-bold">Id Proyek:</span>{{ $proyek->id }}</li>
                            <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span
                                    class="fw-bold">Tanggal Cetak: </span>{{ date('d M Y') }}</li>
                            <li class="text-muted"><i class="fas fa-circle" style="color:#84B0CA ;"></i> <span
                                    class="me-1 fw-bold">Status:</span><span
                                    class="badge bg-warning text-black fw-bold">
                                    Panjar</span></li>
                        </ul>
                    </div>
                </div>

                <div class="row my-2 mx-1 justify-content-center">
                    <table class="table table-striped table-borderless">
                        <thead style="background-color:#84B0CA ;" class="text-white">
                            <tr>
                                <th class="text-center" scope="col">No</th>
                                <th class="text-center" scope="col">Nama Barang</th>
                                <th class="text-center" scope="col">Qty</th>
                                <th class="text-center" scope="col">Harga Per-item</th>
                                <th class="text-center" scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proyek_details as $detail)
                            <tr>
                                <th class="text-center" scope="row">{{ $loop->iteration }}</th>
                                <td class="text-center">{{ $detail->barang->nama_barang }}</td>
                                <td class="text-center">{{ $detail->jumlah }}</td>
                                <td class="text-center">{{ 'Rp. ' . number_format($detail->barang->harga_jual) }}</td>
                                <td class="text-center">{{ 'Rp. ' . number_format($detail->sub_total_harga) }}</td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                <div class="row justify-content-end">
                    <div class="col-xl-4">
                        <ul class="list-unstyled">
                            <li class="text-muted ms-3">
                                <span class="text-black me-4">
                                    Total yang harus dibayar:
                                </span>
                                <span>
                                    {{ 'Rp. ' . number_format($proyek->grand_total_harga) }}
                                </span>
                            </li>
                            <li class="text-muted ms-3 mt-2">
                                <span class="text-black me-4">
                                    Panjar:
                                </span>
                                <span>
                                    {{ 'Rp. ' . number_format($proyek->panjar) }}
                                </span>
                            </li>
                        </ul>
                        <p class="text-black ms-3 mt-2">
                            <span class="text-black me-3">
                                Sisa:
                            </span>
                            <span style="font-size: 25px;">
                                {{ 'Rp. ' . number_format($proyek->grand_total_harga - $proyek->panjar ) }}
                            </span>
                        </p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xl-9">
                        <p>PT. DAHLIA BINA UTAMA</p>
                    </div>
                    <div class="col-xl-3">
                        <div class="d-flex flex-column text-center justify-content-center">
                            <h5>Medan, {{ now()->format('d M Y') }}</h5>
                            <h5 class="fw-bold">Kasir</h5>
                            <br>
                            <br>
                            <br>
                            <span>(_____________)</span>
                        </div>
                    </div>
                </div>

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