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
                        <a class="btn btn-sm btn-primary btn-icon-text" href="#" data-bs-toggle="modal"
                            data-bs-target="#modal-tbh-item">
                            <i class="mdi mdi-plus-box"></i>
                        </a>
                    </div>

                </div>

                <table class="table table-hover">
                    @if ($pemakaians->isNotEmpty())
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center">Jenis Pemakaian</th>
                            <th class="text-center">Tanggal Pemakaian</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pemakaians as $key => $item)
                        <tr class="align-middle">
                            <td class="text-center">{{ $pemakaians->firstItem() + $key }}</td>
                            <td class="text-center">{{ $item->barang->nama_barang }}</td>
                            <td class="text-center">{{ $item->jenis_pemakaian }}</td>
                            <td class="text-center">{{ $item->tgl_pemakaian }}</td>
                            <td class="text-center">{{ $item->jumlah }}</td>
                            <td class="d-flex justify-content-center">
                                <a class="badge badge-warning link-warning" title="Edit" href="#" data-bs-toggle="modal"
                                    data-bs-target="#modal-ubh-item{{ $item->id }}">
                                    <i class="mdi mdi-pencil-box"></i>
                                </a>
                                <a class="badge badge-danger link-danger ms-3" title="Hapus" href="" onclick="if(confirm('Apakah anda yakin?')) {
                                event.preventDefault(); document.getElementById('delete-form').submit()};">
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
                    {{ $pemakaians->links() }}
                </div>
            </div>
        </div>
    </div>
</div>



{{-- Modal Tambah Data --}}
<div class="modal fade" id="modal-tbh-item" role="dialog" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('pemakaian.store') }}" method="POST">
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
                                <label for="jenis_pemakaian">Jenis Pemakaian</label>
                                <input type="text" class="form-control" id="jenis_pemakaian" name="jenis_pemakaian"
                                    placeholder="Jenis Pemakaian" required value="{{ old('jenis_pemakaian') }}">
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex gap-2">
                            <div class="form-group col-lg-6">
                                <label for="tgl_pemakaian">Tanggal Pemakaian</label>
                                <input type="date" class="form-control" id="tgl_pemakaian" name="tgl_pemakaian"
                                    placeholder="Tanggal Pemakaian" required value="{{ old('tgl_pemakaian') }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="jumlah">Jumlah</label>
                                <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah"
                                    required value="{{ old('jumlah') }}">
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
@foreach ($pemakaians as $item)
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
                                <label for="jenis_pemakaian">Jenis Pemakaian</label>
                                <input type="text" class="form-control" id="jenis_pemakaian" name="jenis_pemakaian"
                                    placeholder="Jenis Pemakaian" required
                                    value="{{ old('jenis_pemakaian', $item->jenis_pemakaian) }}">
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex gap-2">
                            <div class="form-group col-lg-6">
                                <label for="tgl_pemakaian">Tanggal Pemakaian</label>
                                <input type="date" class="form-control" id="tgl_pemakaian" name="tgl_pemakaian"
                                    placeholder="Tanggal Pemakaian" required
                                    value="{{ old('tgl_pemakaian', $item->tgl_pemakaian) }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="jumlah">Jumlah</label>
                                <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah"
                                    required value="{{ old('jumlah', $item->jumlah) }}">
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