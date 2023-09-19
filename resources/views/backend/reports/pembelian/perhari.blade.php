@extends('backend.layouts.main')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tabel Cetak Pembelian Perhari</h4>
            <p class="card-description text-danger">
                Silahkan masukkan tanggal untuk mencetak!
            </p>

            <div class="form-group">

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text mdi mdi-calendar"></span>
                        </div>
                        <input type="date" class="form-control" id="tgl_pembelian" name="tgl_pembelian">
                    </div>
                </div>

                <a href="" onclick="this.href='/laporan/buy/harian/' + document.getElementById('tgl_pembelian').value"
                    target="_blank" class="btn btn-primary col-12">
                    <span class="mdi mdi-printer me-1"></span>
                    Cetak
                </a>

            </div>
        </div>
    </div>
</div>
@endsection