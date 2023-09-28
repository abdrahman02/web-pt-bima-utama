@extends('backend.layouts.main')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tabel Proyek</h4>
            <p class="card-description">
                Daftar Proyek
            </p>

            {{-- Alert Success --}}
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-regular fa-circle-check"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            {{-- Error --}}
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span>
                </button>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="table-responsive">
                <div class="d-flex justify-content-between">

                    <div class="form-group col-6">
                        <form action="{{ route('proyek.cari') }}" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Masukkan kata kunci..."
                                    name="keyword">
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-primary" type="submit">Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="button">
                        <a class="btn btn-sm btn-primary btn-icon-text" href="{{ route('proyek.create') }}">
                            <i class="mdi mdi-plus-box"></i>
                        </a>
                    </div>

                </div>

                <table class="table table-hover">
                    @if ($proyek_details->isNotEmpty())
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">No Faktur</th>
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center">Pelanggan</th>
                            <th class="text-center">Tanggal Proyek</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Harga Jual Per-item</th>
                            <th class="text-center">Sub Total Harga</th>
                            <th class="text-center">Grand Total Harga</th>
                            <th class="text-center">Panjar</th>
                            <th class="text-center">Sisa</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proyek_details as $key => $item)
                        <tr class="align-middle">
                            <td class="text-center">{{ $proyek_details->firstItem() + $key }}</td>
                            <td class="text-center">{{ $item->proyek->no_fakt_proyek }}</td>
                            <td class="text-center">{{ $item->barang->nama_barang }}</td>
                            <td class="text-center">{{ $item->proyek->pelanggan->nama_pelanggan }}</td>
                            <td class="text-center">{{ $item->proyek->tgl_proyek }}</td>
                            <td class="text-center">{{ number_format($item->jumlah) }}</td>
                            <td class="text-center">{{ 'Rp. ' . number_format($item->barang->harga_jual) }}</td>
                            <td class="text-center">{{ 'Rp. ' . number_format($item->sub_total_harga) }}</td>
                            <td class="text-center">{{ 'Rp. ' . number_format($item->proyek->grand_total_harga) }}</td>
                            <td>
                                <div class="d-flex flex-column px-2 py-1">
                                    <span class="text-center text-success">{{ 'Rp. ' .
                                        number_format($item->proyek->panjar) }}</span>
                                    <a href="{{ route('proyek.invoicePanjar', $item->proyeTk->id) }}" target="blank">
                                        <p class="badge badge-success rounded-pill fw-light mt-1">kwitansi</p>
                                    </a>
                                </div>
                            </td>
                            @if ($item->proyek->grand_total_harga == $item->proyek->panjar + $item->proyek->sisa)
                            <td>
                                <div class="d-flex flex-column px-2 py-1">
                                    <span class="text-center text-success">{{ 'Rp. ' .
                                        number_format($item->proyek->sisa) }}</span>
                                    <a href="{{ route('proyek.invoiceSisa', $item->proyek->id) }}" target="blank">
                                        <p class="badge badge-success rounded-pill fw-light mt-1">kwitansi</p>
                                    </a>
                                </div>
                            </td>
                            @else
                            <td class="text-center text-danger">belum pelunasan</td>
                            @endif
                            <td class="d-flex justify-content-center">
                                <a class="badge badge-warning link-warning" title="Edit" href="#" data-bs-toggle="modal"
                                    data-bs-target="#modal-ubh-item{{ $item->id }}">
                                    <i class="mdi mdi-pencil-box"></i>
                                </a>
                                <a class="badge badge-danger link-danger ms-3" title="Hapus" href="" onclick="if(confirm('Apakah anda yakin?')) {
                                event.preventDefault(); document.getElementById('delete-form').submit()};">
                                    <i class="mdi mdi-minus-box"></i>
                                    <form action="{{ route('proyek.destroy', $item->proyek->id) }}" method="post"
                                        id="delete-form" class="d-none">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @else
                    <div class="alert alert-primary text-center" role="alert">
                        Data kosong!!
                    </div>
                    @endif
                </table>
                <div class="d-flex justify-content-center">
                    {{ $proyek_details->links() }}
                </div>
            </div>
        </div>
    </div>
</div>





{{-- Modal Ubah Data --}}
@foreach ($proyek_details as $item)
<div class="modal fade" id="modal-ubh-item{{ $item->id }}" role="dialog" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('proyek.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="p-3">
                        <div class="col-lg-12 d-flex gap-2">

                            <div class="form-group col-lg-6">
                                <label for="barang_id" class="d-flex">Barang</label>
                                <input type="text" id="barang_id" class="form-control" disabled
                                    value="{{ old('barang_id', $item->barang->nama_barang) }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="pelanggan_id" class="d-flex">Pelanggan</label>
                                <input type="text" id="pelanggan_id" class="form-control" disabled
                                    value="{{ old('pelanggan_id', $item->proyek->pelanggan->nama_pelanggan) }}">
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex gap-2">
                            <div class="form-group col-lg-6">
                                <label for="no_fakt_proyek">No Faktur</label>
                                <input type="text" class="form-control" id="no_fakt_proyek" name="no_fakt_proyek"
                                    placeholder="No Faktur" required
                                    value="{{ old('no_fakt_proyek', $item->proyek->no_fakt_proyek) }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="tgl_proyek">Tanggal Proyek</label>
                                <input type="date" class="form-control" id="tgl_proyek" name="tgl_proyek"
                                    placeholder="Tanggal proyek" required
                                    value="{{ old('tgl_proyek', $item->proyek->tgl_proyek) }}">
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex gap-2">
                            <div class="form-group col-lg-6">
                                <label for="jumlah{{ $item->id }}">Jumlah</label>
                                <input type="text" class="form-control" id="jumlah{{ $item->id }}" name="jumlah"
                                    placeholder="Jumlah" required value="{{ old('jumlah', $item->jumlah) }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="status">Status</label>
                                <input type="text" class="form-control" id="status" name="status" placeholder="Status"
                                    required value="{{ old('status', $item->proyek->status) }}">
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex gap-2">
                            <div class="form-group col-lg-6">
                                <label for="harga_jual{{ $item->id }}">Harga Jual Per-item</label>
                                <input type="text" class="form-control" id="harga_jual{{ $item->id }}" name="harga_jual"
                                    placeholder="Harga per-item" required disabled
                                    value="{{ old('harga_jual', $item->barang->harga_jual) }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="sub_total_harga{{ $item->id }}">Sub Total Harga</label>
                                <input type="text" class="form-control" id="sub_total_harga{{ $item->id }}"
                                    name="sub_total_harga" placeholder="Total Pembayaran" required readonly
                                    value="{{ old('sub_total_harga', $item->sub_total_harga) }}">
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex gap-2">
                            <div class="form-group col-lg-6">
                                <label for="panjar">Panjar</label>
                                <input type="text" class="form-control" id="panjar" name="panjar" placeholder="Panjar"
                                    required value="{{ old('panjar', $item->proyek->panjar) }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="sisa">Bayar Sisa</label>
                                <input type="text" class="form-control" id="sisa" name="sisa" placeholder="Sisa"
                                    required value="{{ old('sisa', $item->proyek->sisa) }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection


@push('custom-js')
{{-- Ubah data --}}
@foreach ($proyek_details as $item)
<script>
    $(document).ready(function() {
        // Dapatkan referensi ke elemen yang dibutuhkan
        var jumlahInput = $("#jumlah{{ $item->id }}");
        var hargaPerItemInput = $("#harga_jual{{ $item->id }}");
        var totalHargaInput = $("#sub_total_harga{{ $item->id }}");

        // Tambahkan event listener ke elemen jumlah dan harga_jual
        jumlahInput.on('input', updateTotalHarga);
        hargaPerItemInput.on('input', updateTotalHarga);

        // Fungsi untuk menghitung total harga
        function updateTotalHarga() {
            var jumlah = parseFloat(jumlahInput.val()) || 0;
            var hargaPerItem = parseFloat(hargaPerItemInput.val()) || 0;
            var totalHarga = jumlah * hargaPerItem;
            
            // Mengisi nilai sub_total_harga dengan hasil perhitungan
            totalHargaInput.val(totalHarga);
        }
    });
</script>
@endforeach
@endpush