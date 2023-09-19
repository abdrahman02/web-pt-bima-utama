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
                        <a class="btn btn-sm btn-primary btn-icon-text" href="#" data-bs-toggle="modal"
                            data-bs-target="#modal-tbh-item">
                            <i class="mdi mdi-plus-box"></i>
                        </a>
                    </div>

                </div>

                <table class="table table-hover">
                    @if ($pembelians->isNotEmpty())
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center">Suplier</th>
                            <th class="text-center">Tanggal Pembelian</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Jumlah Bayar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembelians as $key => $item)
                        <tr class="align-middle">
                            <td class="text-center">{{ $pembelians->firstItem() + $key }}</td>
                            <td class="text-center">{{ $item->barang->nama_barang }}</td>
                            <td class="text-center">{{ $item->suplier->nama_suplier }}</td>
                            <td class="text-center">{{ $item->tgl_pembelian }}</td>
                            <td class="text-center">{{ $item->jumlah }}</td>
                            <td class="text-center">{{ $item->harga }}</td>
                            <td class="text-center">{{ $item->jumlah_bayar }}</td>
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
                    {{ $pembelians->links() }}
                </div>
            </div>
        </div>
    </div>
</div>



{{-- Modal Tambah Data --}}
<div class="modal fade" id="modal-tbh-item" role="dialog" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('pembelian.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="p-3">
                        <div class="col-lg-12 d-flex gap-2">
                            <div class="form-group col-lg-6">
                                <label for="barang_id" class="d-flex">Barang</label>
                                <select class="form-control" id="barang_id" name="barang_id" style="width: 100%"
                                    required>
                                    <option value="" selected>-- PILIH --</option>
                                    @foreach ($barangs as $barang)
                                    <option value="{{ $barang->id }}" @if (old('barang_id')===$barang->id)
                                        selected @endif>{{ $barang->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="suplier_id" class="d-flex">Suplier</label>
                                <select class="form-control" id="suplier_id" name="suplier_id" style="width: 100%"
                                    required>
                                    <option value="" selected>-- PILIH --</option>
                                    @foreach ($supliers as $suplier)
                                    <option value="{{ $suplier->id }}" @if (old('suplier_id')===$suplier->id)
                                        selected @endif>{{ $suplier->nama_suplier }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex gap-2">
                            <div class="form-group col-lg-6">
                                <label for="no_fakt_pembelian">No Faktur</label>
                                <input type="text" class="form-control" id="no_fakt_pembelian" name="no_fakt_pembelian"
                                    placeholder="No Faktur" required value="{{ old('no_fakt_pembelian') }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="tgl_pembelian">Tanggal Pembelian</label>
                                <input type="date" class="form-control" id="tgl_pembelian" name="tgl_pembelian"
                                    placeholder="Tanggal pembelian" required value="{{ old('tgl_pembelian') }}">
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex gap-2">
                            <div class="form-group col-lg-6">
                                <label for="jumlah">Jumlah</label>
                                <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah"
                                    required value="{{ old('jumlah') }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="status">Status</label>
                                <input type="text" class="form-control" id="status" name="status" placeholder="Status"
                                    required value="{{ old('status') }}">
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex gap-2">
                            <div class="form-group col-lg-6">
                                <label for="harga">Harga</label>
                                <input type="text" class="form-control" id="harga" name="harga" placeholder="Harga"
                                    required value="{{ old('harga') }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="jumlah_bayar">Jumlah Bayar</label>
                                <input type="text" class="form-control" id="jumlah_bayar" name="jumlah_bayar"
                                    placeholder="Jumlah bayar" required value="{{ old('jumlah_bayar') }}">
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





{{-- Modal Ubah Data --}}
@foreach ($pembelians as $item)
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
                                <select class="form-control" id="barang_id" name="barang_id" style="width: 100%"
                                    required disabled>
                                    @if (empty($item->barang->nama_barang))
                                    <option value="" selected>-- PILIH --</option>
                                    @endif
                                    @foreach ($barangs as $barang)
                                    <option value="{{ $barang->id }}" @if(old('barang_id', $item->barang_id) ===
                                        $barang->id)
                                        selected
                                        @endif>
                                        {{ $barang->nama_barang }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="suplier_id" class="d-flex">Suplier</label>
                                <select class="form-control" id="suplier_id" name="suplier_id" style="width: 100%"
                                    required>
                                    @if (empty($item->suplier->nama_suplier))
                                    <option value="" selected>-- PILIH --</option>
                                    @endif
                                    @foreach ($supliers as $suplier)
                                    <option value="{{ $suplier->id }}" @if(old('suplier_id', $item->suplier_id) ===
                                        $suplier->id)
                                        selected
                                        @endif>
                                        {{ $suplier->nama_suplier }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex gap-2">
                            <div class="form-group col-lg-6">
                                <label for="no_fakt_pembelian">No Faktur</label>
                                <input type="text" class="form-control" id="no_fakt_pembelian" name="no_fakt_pembelian"
                                    placeholder="No Faktur" required
                                    value="{{ old('no_fakt_pembelian', $item->no_fakt_pembelian) }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="tgl_pembelian">Tanggal Pembelian</label>
                                <input type="date" class="form-control" id="tgl_pembelian" name="tgl_pembelian"
                                    placeholder="Tanggal pembelian" required
                                    value="{{ old('tgl_pembelian', $item->tgl_pembelian) }}">
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex gap-2">
                            <div class="form-group col-lg-6">
                                <label for="jumlah">Jumlah</label>
                                <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah"
                                    required value="{{ old('jumlah', $item->jumlah) }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="status">Status</label>
                                <input type="text" class="form-control" id="status" name="status" placeholder="Status"
                                    required value="{{ old('status', $item->status) }}">
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex gap-2">
                            <div class="form-group col-lg-6">
                                <label for="harga">Harga</label>
                                <input type="text" class="form-control" id="harga" name="harga" placeholder="Harga"
                                    required value="{{ old('harga', $item->harga) }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="jumlah_bayar">Jumlah Bayar</label>
                                <input type="text" class="form-control" id="jumlah_bayar" name="jumlah_bayar"
                                    placeholder="Jumlah bayar" required
                                    value="{{ old('jumlah_bayar', $item->jumlah_bayar) }}">
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
<script>
    // In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('#suplier_id').select2({
        dropdownParent: $('#modal-tbh-item'),
        placeholder: "Pilih suplier",
    });
    $('#barang_id').select2({
        dropdownParent: $('#modal-tbh-item'),
        placeholder: "Pilih barang",
    });
});
</script>
@endpush