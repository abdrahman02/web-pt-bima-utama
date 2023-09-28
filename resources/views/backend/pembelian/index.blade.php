@extends('backend.layouts.main')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tabel Pembelian</h4>
            <p class="card-description">
                Daftar Pembelian
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
                        <form action="{{ route('pembelian.cari') }}" method="get">
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
                        <a class="btn btn-sm btn-primary btn-icon-text" href="{{ route('pembelian.create') }}">
                            <i class="mdi mdi-plus-box"></i>
                        </a>
                    </div>

                </div>

                <table class="table table-hover">
                    @if ($pembelian_details->isNotEmpty())
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Suplier</th>
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center">Tanggal Pembelian</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Harga Per-item</th>
                            <th class="text-center">Sub Total Harga Beli</th>
                            <th class="text-center">Grand Total Harga Beli</th>
                            <th class="text-center">Jumlah Bayar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembelian_details as $key => $item)
                        <tr class="align-middle">
                            <td class="text-center">{{ $pembelian_details->firstItem() + $key }}</td>
                            <td class="text-center">
                                {{ $item->pembelian->suplier->nama_suplier }}
                            </td>
                            <td class="text-center">
                                {{ $item->barang->nama_barang }}
                            </td>
                            <td class="text-center">{{ $item->pembelian->tgl_pembelian }}</td>
                            <td class="text-center">{{ number_format($item->jumlah) }}</td>
                            <td class="text-center">{{ 'Rp. ' . number_format($item->barang->harga_beli_peritem) }}</td>
                            <td class="text-center">{{ 'Rp. ' . number_format($item->sub_total_harga) }}</td>
                            <td class="text-center">{{ 'Rp. ' . number_format($item->pembelian->grand_total_harga) }}
                            </td>
                            <td class="text-center">{{ 'Rp. ' . number_format($item->pembelian->jumlah_bayar) }}</td>
                            <td class="d-flex justify-content-center">
                                <a class="badge badge-warning link-warning" title="Edit" href="#" data-bs-toggle="modal"
                                    data-bs-target="#modal-ubh-item{{ $item->id }}">
                                    <i class="mdi mdi-pencil-box"></i>
                                </a>
                                <a class="badge badge-danger link-danger ms-3" title="Hapus" href="" onclick="if(confirm('Apakah anda yakin?')) {
                                event.preventDefault(); document.getElementById('delete-form').submit()};">
                                    <i class="mdi mdi-minus-box"></i>
                                    <form action="{{ route('pembelian.destroy', $item->id) }}" method="post"
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
                    {{ $pembelian_details->links() }}
                </div>
            </div>
        </div>
    </div>
</div>





{{-- Modal Ubah Data --}}
@foreach ($pembelian_details as $item)
<div class="modal fade" id="modal-ubh-item{{ $item->id }}" role="dialog" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('pembelian.update', $item->id) }}" method="POST">
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
                                <label for="suplier_id" class="d-flex">Suplier</label>
                                <input type="text" id="suplier_id" class="form-control" disabled
                                    value="{{ old('suplier_id', $item->pembelian->suplier->nama_suplier) }}">
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex gap-2">
                            <div class="form-group col-lg-6">
                                <label for="no_fakt_pembelian">No Faktur</label>
                                <input type="text" class="form-control" id="no_fakt_pembelian" name="no_fakt_pembelian"
                                    placeholder="No Faktur" required
                                    value="{{ old('no_fakt_pembelian', $item->pembelian->no_fakt_pembelian) }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="tgl_pembelian">Tanggal Pembelian</label>
                                <input type="date" class="form-control" id="tgl_pembelian" name="tgl_pembelian"
                                    placeholder="Tanggal pembelian" required
                                    value="{{ old('tgl_pembelian', $item->pembelian->tgl_pembelian) }}">
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
                                    required value="{{ old('status', $item->pembelian->status) }}">
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex gap-2">
                            <div class="form-group col-lg-6">
                                <label for="harga_peritem{{ $item->id }}">Harga Per-item</label>
                                <input type="text" class="form-control" id="harga_peritem{{ $item->id }}"
                                    name="harga_peritem" placeholder="Harga per-item" required
                                    value="{{ old('harga_peritem', $item->barang->harga_beli_peritem) }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="sub_total_harga{{ $item->id }}">Sub Total Harga Pembelian</label>
                                <input type="text" class="form-control" id="sub_total_harga{{ $item->id }}"
                                    name="sub_total_harga" placeholder="Total harga" required readonly
                                    value="{{ old('sub_total_harga', $item->sub_total_harga) }}">
                            </div>

                        </div>
                        <div class="form-group col-lg-12">
                            <label for="jumlah_bayar">Jumlah Bayar</label>
                            <input type="text" class="form-control" id="jumlah_bayar" name="jumlah_bayar"
                                placeholder="Jumlah bayar" required
                                value="{{ old('jumlah_bayar', $item->pembelian->jumlah_bayar) }}">
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
@foreach ($pembelian_details as $item)
<script>
    $(document).ready(function() {
        // Dapatkan referensi ke elemen yang dibutuhkan
        var jumlahInput = $("#jumlah{{ $item->id }}");
        var hargaPerItemInput = $("#harga_peritem{{ $item->id }}");
        var totalHargaInput = $("#sub_total_harga{{ $item->id }}");

        // Tambahkan event listener ke elemen jumlah dan harga_peritem
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