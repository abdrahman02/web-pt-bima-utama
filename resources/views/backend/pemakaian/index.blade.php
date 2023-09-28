@extends('backend.layouts.main')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tabel Pemakaian</h4>
            <p class="card-description">
                Daftar Pemakaian
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
                        <form action="{{ route('pemakaian.cari') }}" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Masukkan kata kunci..."
                                    name="keyword">
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-primary" type="button">Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="button">
                        <a class="btn btn-sm btn-primary btn-icon-text" href="{{ route('pemakaian.create') }}">
                            <i class="mdi mdi-plus-box"></i>
                        </a>
                    </div>

                </div>

                <table class="table table-hover">
                    @if ($pemakaian_details->isNotEmpty())
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Id Pemakaian</th>
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center">Jenis Pemakaian</th>
                            <th class="text-center">Tanggal Pemakaian</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Harga Jual Per-item</th>
                            <th class="text-center">Sub Total Harga</th>
                            <th class="text-center">Grand Total Harga</th>
                            <th class="text-center col-1 text-wrap">KET</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemakaian_details as $key => $item)
                        <tr class="align-middle">
                            <td class="text-center">{{ $pemakaian_details->firstItem() + $key }}</td>
                            <td class="text-center">{{ $item->pemakaian_id }}</td>
                            <td class="text-center">{{ $item->barang->nama_barang }}</td>
                            <td class="text-center">{{ $item->pemakaian->jenis_pemakaian }}</td>
                            <td class="text-center">{{ $item->pemakaian->tgl_pemakaian }}</td>
                            <td class="text-center">{{ number_format($item->jumlah) }}</td>
                            <td class="text-center">{{ 'Rp. ' . number_format($item->barang->harga_jual) }}</td>
                            <td class="text-center">{{ 'Rp. ' . number_format($item->sub_total_harga) }}</td>
                            <td class="text-center">{{ 'Rp. ' . number_format($item->pemakaian->grand_total_harga) }}
                            </td>
                            <td class="text-center col-1 text-wrap">{{ $item->pemakaian->keterangan_pemakaian }}</td>
                            <td class="d-flex justify-content-center">
                                <a class="badge badge-warning link-warning" title="Edit" href="#" data-bs-toggle="modal"
                                    data-bs-target="#modal-ubh-item{{ $item->id }}">
                                    <i class="mdi mdi-pencil-box"></i>
                                </a>
                                <a class="badge badge-danger link-danger ms-3" title="Hapus" href=""
                                    onclick="if(confirm('Apakah anda yakin?')) {event.preventDefault(); document.getElementById('delete-form').submit()};">
                                    <i class="mdi mdi-minus-box"></i>
                                    <form action="{{ route('pemakaian.destroy', $item->id) }}" method="post"
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
                    {{ $pemakaian_details->links() }}
                </div>
            </div>
        </div>
    </div>
</div>





{{-- Modal Ubah Data --}}
@foreach ($pemakaian_details as $item)
<div class="modal fade" id="modal-ubh-item{{ $item->id }}" role="dialog" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('pemakaian.update', $item->id) }}" method="POST">
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
                                <label for="jenis_pemakaian">Jenis Pemakaian</label>
                                <input type="text" class="form-control" id="jenis_pemakaian" name="jenis_pemakaian"
                                    placeholder="Jenis Pemakaian" required
                                    value="{{ old('jenis_pemakaian', $item->pemakaian->jenis_pemakaian) }}">
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex gap-2">
                            <div class="form-group col-lg-6">
                                <label for="tgl_pemakaian">Tanggal Pemakaian</label>
                                <input type="date" class="form-control" id="tgl_pemakaian" name="tgl_pemakaian"
                                    placeholder="Tanggal Pemakaian" required
                                    value="{{ old('tgl_pemakaian', $item->pemakaian->tgl_pemakaian) }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="jumlah{{ $item->id }}">Jumlah</label>
                                <input type="text" class="form-control" id="jumlah{{ $item->id }}" name="jumlah"
                                    placeholder="Jumlah" required value="{{ old('jumlah', $item->jumlah) }}">
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
                        <div class="form-group col-lg-12">
                            <label for="keterangan_pemakaian">Keterangan Pemakaian</label>
                            <textarea class="form-control" id="keterangan_pemakaian" name="keterangan_pemakaian"
                                rows="20">{{ old('keterangan_pemakaian', $item->pemakaian->keterangan_pemakaian) }}</textarea>
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
@foreach ($pemakaian_details as $item)
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