@extends('backend.layouts.main')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">

            <div class="button mb-3">
                <a class="btn btn-sm btn-danger btn-icon-text" href="{{ route('pemakaian.index') }}">
                    <i class="mdi mdi-arrow-left-bold-circle-outline align-middle"></i>
                    <span class="ms-1 menu-title align-middle">Kembali</span>
                </a>
            </div>

            <h4 class="card-title">Form Tambah Pemakaian</h4>

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

            <p class="card-description">
                Daftar Barang:
            </p>

            <form action="{{ route('cartPemakaian.store') }}" method="post" class="col-lg-12 mb-3 d-flex">
                @csrf
                <div class="form-group col-lg-5">
                    <label for="barang_id">Barang</label>
                    <select class="form-control" id="barang_id" name="barang_id" style="width: 100%" required>
                        <option value="" selected>-- PILIH --</option>
                        @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}" @if (old('barang_id')===$barang->id)
                            selected @endif>{{ $barang->nama_barang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-5">
                    <label for="jumlah">Jumlah</label>
                    <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah" required
                        value="{{ old('jumlah') }}">
                </div>
                <button type="submit" class="btn btn-primary d-flex align-items-center">
                    <i class="menu-icon mdi mdi-cart-outline"></i>&nbsp;
                    <span class="ms-1 menu-title">Tambah Ke keranjang</span>
                </button>
            </form>
        </div>
    </div>
</div>
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <p class="card-description">
                    Tambah Pemakaian
                </p>

                <table class="table table-hover">
                    <form action="{{ route('pemakaian.store') }}" method="post" class="d-none">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-primary d-flex align-items-center float-end mb-3">
                            <i class="menu-icon mdi mdi-credit-card"></i>&nbsp;
                            <span class="ms-1 menu-title">Checkout</span>
                        </button>
                        <input type="hidden" name="">

                        <thead class="bg-info">
                            <tr>
                                <th class="text-center" colspan="2">Jenis Pemakaian</th>
                                <th class="text-center" colspan="2">Tanggal</th>
                                <th class="text-center" colspan="2">KET</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="jenis_pemakaian"
                                            name="jenis_pemakaian" placeholder="Jenis pemakaian" required>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-group">
                                        <input type="date" class="form-control" id="tgl_pemakaian" name="tgl_pemakaian"
                                            placeholder="Tanggal pemakaian" required>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="form-group">
                                        <textarea class="form-control" id="keterangan_pemakaian"
                                            name="keterangan_pemakaian" placeholder="Keterangan pemakaian"
                                            rows="20"></textarea>
                                    </div>
                                </td>
                            </tr>
                        </tbody>

                        <thead class="bg-info">
                            <tr>
                                <th class="text-center" colspan="6">Grand Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="grand_total_harga"
                                            name="grand_total_harga" placeholder="Grand Total" required readonly
                                            value="{{'Rp. ' .  number_format($grandTotal) }}">
                                    </div>
                                </td>
                            </tr>
                        </tbody>

                        <thead class="bg-info">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Barang</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Harga Per-item</th>
                                <th class="text-center">Sub Total</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($cartPemakaian))
                            @foreach ($cartPemakaian as $val)
                            <tr class="align-middle">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ \App\Models\Barang::find($val['barang_id'])->nama_barang }}
                                </td>
                                <td class="text-center">{{ number_format($val['jumlah']) }}</td>
                                <td class="text-center">{{ 'Rp. ' . number_format( $val['harga_jual_peritem']) }}</td>
                                <td class="text-center">{{ 'Rp. ' . number_format($val['sub_total_harga']) }}</td>
                    </form>

                    <td class="d-flex justify-content-center">
                        <a class="badge badge-danger link-danger ms-3" title="Hapus" href=""
                            onclick="if(confirm('Apakah anda yakin?')) {
                                event.preventDefault(); document.getElementById('delete-form{{ $val['id'] }}').submit()};">
                            <i class="mdi mdi-minus-box"></i>
                            <form action="{{ route('cartPemakaian.destroy', $val['id']) }}" method="post"
                                id="delete-form{{ $val['id'] }}" class="d-none">
                                @csrf
                                @method('delete')
                            </form>
                        </a>
                    </td>
                    </tr>
                    @endforeach
                    @else
                    <div class="alert alert-primary text-center" role="alert">
                        Data kosong!!
                    </div>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@push('custom-script')
<script>
    $(document).ready(function() {
    $('#barang_id').select2({
        placeholder: "Pilih barang",
    });
});
</script>
@endpush