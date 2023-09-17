@extends('backend.layouts.main')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tabel Barang</h4>
            <p class="card-description">
                Daftar Barang
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
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Masukkan kata kunci..."
                                aria-label="Recipient's username">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-primary" type="button">Cari</button>
                            </div>
                        </div>
                    </div>

                    <div class="button">
                        <a class="btn btn-sm btn-primary btn-icon-text" href="#" data-bs-toggle="modal"
                            data-bs-target="#modal-tbh-item">
                            <i class="mdi mdi-plus-box"></i>
                        </a>
                    </div>

                </div>

                <table class="table table-hover">
                    @if ($barangs->isNotEmpty())
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Id Barang</th>
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center">Harga Jual</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barangs as $key => $item)
                        <tr class="align-middle">
                            <td class="text-center">{{ $barangs->firstItem() + $key }}</td>
                            <td class="text-center">{{ $item->id }}</td>
                            <td class="text-center">{{ $item->nama_barang }}</td>
                            <td class="text-center">{{ $item->stok }}</td>
                            <td class="text-center">{{ $item->jenis }}</td>
                            @if (empty($item->harga_jual))
                            <td class="text-center text-warning">Belum diatur</td>
                            @else
                            <td class="text-center">{{ $item->harga_jual }}</td>
                            @endif
                            <td class="d-flex justify-content-center">
                                <a class="badge badge-warning link-warning" title="Edit" href="#" data-bs-toggle="modal"
                                    data-bs-target="#modal-ubh-item{{ $item->id }}">
                                    <i class="mdi mdi-pencil-box"></i>
                                </a>
                                <a class="badge badge-danger link-danger ms-3" title="Hapus" href="" onclick="if(confirm('Apakah anda yakin?')) {
                                event.preventDefault(); document.getElementById('delete-form').submit()};">
                                    <i class="mdi mdi-minus-box"></i>
                                    <form action="{{ route('barang.destroy', $item->id) }}" method="post"
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
                    {{ $barangs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>



{{-- Modal Tambah Data --}}
<div class="modal fade" id="modal-tbh-item" role="dialog" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="p-3">
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                placeholder="Nama barang" autofocus required value="{{ old('nama_barang') }}">
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <input type="text" class="form-control" id="jenis" name="jenis" placeholder="Jenis" required
                                value="{{ old('jenis') }}">
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
@foreach ($barangs as $item)
<div class="modal fade" id="modal-ubh-item{{ $item->id }}" role="dialog" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('barang.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="p-3">
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                placeholder="Nama barang" autofocus required
                                value="{{ old('nama_barang', $item->nama_barang) }}">
                        </div>
                        <div class="form-group">
                            <label for="jenis">Jenis</label>
                            <input type="text" class="form-control" id="jenis" name="jenis" placeholder="Jenis"
                                value="{{ old('jenis', $item->jenis) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="harga_jual">Harga Jual</label>
                            <input type="text" class="form-control" id="harga_jual" name="harga_jual"
                                placeholder="Harga jual" value="{{ old('harga_jual', $item->harga_jual) }}" required>
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