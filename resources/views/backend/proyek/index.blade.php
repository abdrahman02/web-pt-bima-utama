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
                    @if ($proyeks->isNotEmpty())
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Barang</th>
                            <th class="text-center">Pelanggan</th>
                            <th class="text-center">Tanggal Proyek</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Jumlah Bayar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proyeks as $key => $item)
                        <tr class="align-middle">
                            <td class="text-center">{{ $proyeks->firstItem() + $key }}</td>
                            <td class="text-center">{{ $item->barang->nama_barang }}</td>
                            <td class="text-center">{{ $item->pelanggan->nama_pelanggan }}</td>
                            <td class="text-center">{{ $item->tgl_proyek }}</td>
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
                                    <form action="{{ route('proyek.destroy', $item->id) }}" method="post"
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
                    {{ $proyeks->links() }}
                </div>
            </div>
        </div>
    </div>
</div>



{{-- Modal Tambah Data --}}
<div class="modal fade" id="modal-tbh-item" role="dialog" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('proyek.store') }}" method="POST">
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
                                        selected @endif>{{
                                        $barang->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="pelanggan_id" class="d-flex">Pelanggan</label>
                                <select class="form-control" id="pelanggan_id" name="pelanggan_id" style="width: 100%"
                                    required>
                                    <option value="" selected>-- PILIH --</option>
                                    @foreach ($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->id }}" @if (old('pelanggan_id')===$pelanggan->id)
                                        selected @endif>{{ $pelanggan->nama_pelanggan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex gap-2">
                            <div class="form-group col-lg-6">
                                <label for="no_fakt_proyek">No Faktur</label>
                                <input type="text" class="form-control" id="no_fakt_proyek" name="no_fakt_proyek"
                                    placeholder="No Faktur" required value="{{ old('no_fakt_proyek') }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="tgl_proyek">Tanggal Proyek</label>
                                <input type="date" class="form-control" id="tgl_proyek" name="tgl_proyek"
                                    placeholder="Tanggal proyek" required value="{{ old('tgl_proyek') }}">
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
                                    required value="{{ old('harga') }}" readonly>
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
@foreach ($proyeks as $item)
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
                                <select class="form-control" id="barang_id" name="barang_id" style="width: 100%"
                                    required readonly>
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
                                <label for="pelanggan_id" class="d-flex">Pelanggan</label>
                                <select class="form-control" id="pelanggan_id" name="pelanggan_id" style="width: 100%"
                                    required>
                                    @if (empty($item->pelanggan->nama_pelanggan))
                                    <option value="" selected>-- PILIH --</option>
                                    @endif
                                    @foreach ($pelanggans as $pelanggan)
                                    <option value="{{ $pelanggan->id }}" @if(old('pelanggan_id', $item->pelanggan_id)
                                        ===
                                        $pelanggan->id)
                                        selected
                                        @endif>
                                        {{ $pelanggan->nama_pelanggan }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex gap-2">
                            <div class="form-group col-lg-6">
                                <label for="no_fakt_proyek">No Faktur</label>
                                <input type="text" class="form-control" id="no_fakt_proyek" name="no_fakt_proyek"
                                    placeholder="No Faktur" required
                                    value="{{ old('no_fakt_proyek', $item->no_fakt_proyek) }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="tgl_proyek">Tanggal Proyek</label>
                                <input type="date" class="form-control" id="tgl_proyek" name="tgl_proyek"
                                    placeholder="Tanggal proyek" required
                                    value="{{ old('tgl_proyek', $item->tgl_proyek) }}">
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
    $('#pelanggan_id').select2({
        dropdownParent: $('#modal-tbh-item'),
        placeholder: "Pilih pelanggan",
    });
    $('#barang_id').select2({
        dropdownParent: $('#modal-tbh-item'),
        placeholder: "Pilih barang",
    });
});
</script>

<script>
    var barangs = @json($barangs);
</script>

<script>
    $(document).ready(function() {
        // Dapatkan referensi ke elemen yang dibutuhkan
        var barangSelect = $("#barang_id");
        var jumlahInput = $("#jumlah");
        var hargaInput = $("#harga");

        // Tambahkan event listener ke elemen barang_id dan jumlah
        barangSelect.change(updateHarga);
        jumlahInput.keyup(updateHarga);

        function updateHarga() {
            var selectedBarangId = barangSelect.val();
            var jumlah = parseInt(jumlahInput.val());
            
            if (!isNaN(jumlah)) {
                // Temukan harga satuan berdasarkan ID barang dalam data yang sudah ada
                var hargaSatuan = null;
                $.each(barangs, function(index, barang) {
                    if (barang.id == selectedBarangId) {
                        hargaSatuan = barang.harga_jual;
                        return false; // Keluar dari loop
                    }
                });

                if (hargaSatuan !== null) {
                    // Hitung harga total
                    var totalHarga = hargaSatuan * jumlah;

                    // Masukkan harga total ke dalam input harga
                    hargaInput.val(totalHarga);
                } else {
                    hargaInput.val(""); // Kosongkan input harga jika harga satuan tidak ditemukan
                }
            } else {
                hargaInput.val(""); // Kosongkan input harga jika jumlah tidak valid
            }
        }
    });
</script>
@endpush