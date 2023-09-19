@extends('backend.layouts.main')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tabel Suplier</h4>
            <p class="card-description">
                Daftar Suplier
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
                        <form action="{{ route('suplier.cari') }}" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Masukkan kata kunci..."
                                    name="keyword">
                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-primary" type="submit">Cari</button>
                                </div>
                            </div>
                        </form>
                    </div>


                    <div class="button d-flex gap-2">
                        <div class="cetak">
                            <a href="/input/suplier/cetak" target="_blank" class="btn btn-sm btn-primary btn-icon-text">
                                <span class="mdi mdi-printer me-1"></span>
                                Cetak
                            </a>
                        </div>
                        <div class="tambah">
                            <a class="btn btn-sm btn-primary btn-icon-text" href="#" data-bs-toggle="modal"
                                data-bs-target="#modal-tbh-item">
                                <i class="mdi mdi-plus-box"></i>
                            </a>
                        </div>
                    </div>

                </div>

                <table class="table table-hover">
                    @if ($supliers->isNotEmpty())
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Id Suplier</th>
                            <th class="text-center">Nama Suplier</th>
                            <th class="text-center">Nomor Telepon</th>
                            <th class="text-center">Alamat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($supliers as $key => $item)
                        <tr class="align-middle">
                            <td class="text-center">{{ $supliers->firstItem() + $key }}</td>
                            <td class="text-center">{{ $item->id }}</td>
                            <td class="text-center">{{ $item->nama_suplier }}</td>
                            <td class="text-center">{{ $item->no_telp }}</td>
                            <td class="text-center">{{ Str::words($item->alamat, 3) }}</td>
                            <td class="d-flex justify-content-center">
                                <a class="badge badge-warning link-warning" title="Edit" href="#" data-bs-toggle="modal"
                                    data-bs-target="#modal-ubh-item{{ $item->id }}">
                                    <i class="mdi mdi-pencil-box"></i>
                                </a>
                                <a class="badge badge-danger link-danger ms-3" title="Hapus" href="" onclick="if(confirm('Apakah anda yakin?')) {
                                event.preventDefault(); document.getElementById('delete-form').submit()};">
                                    <i class="mdi mdi-minus-box"></i>
                                    <form action="{{ route('suplier.destroy', $item->id) }}" method="post"
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
                    {{ $supliers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>



{{-- Modal Tambah Data --}}
<div class="modal fade" id="modal-tbh-item" role="dialog" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('suplier.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="p-3">
                        <div class="form-group">
                            <label for="nama_suplier">Nama Suplier</label>
                            <input type="text" class="form-control" id="nama_suplier" name="nama_suplier"
                                placeholder="Nama suplier" autofocus required value="{{ old('nama_suplier') }}">
                        </div>
                        <div class="form-group">
                            <label for="no_telp">Nomor Telepon</label>
                            <input type="text" class="form-control" id="no_telp" name="no_telp"
                                placeholder="Nomor telepon" required value="{{ old('no_telp') }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="5"
                                required>{{ old('alamat') }}</textarea>
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
@foreach ($supliers as $item)
<div class="modal fade" id="modal-ubh-item{{ $item->id }}" role="dialog" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('suplier.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="p-3">
                        <div class="form-group">
                            <label for="nama_suplier">Nama Suplier</label>
                            <input type="text" class="form-control" id="nama_suplier" name="nama_suplier"
                                placeholder="Nama suplier" autofocus required
                                value="{{ old('nama_suplier', $item->nama_suplier) }}">
                        </div>
                        <div class="form-group">
                            <label for="no_telp">Nomor Telepon</label>
                            <input type="text" class="form-control" id="no_telp" name="no_telp"
                                placeholder="Nomor telepon" value="{{ old('no_telp', $item->no_telp) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="5"
                                required>{{ old('alamat', $item->alamat) }}</textarea>
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