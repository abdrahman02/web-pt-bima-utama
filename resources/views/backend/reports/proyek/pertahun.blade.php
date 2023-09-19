@extends('backend.layouts.main')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tabel Cetak Proyek Tahunan</h4>
            <p class="card-description text-danger">
                Pilih bulan apa saja pada tahun yang diinginkan untuk dicetak!
            </p>

            <div class="form-group">

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text mdi mdi-calendar"></span>
                        </div>
                        <input type="month" class="form-control" id="thn_proyek" name="thn_proyek">
                    </div>
                </div>

                <a href="" onclick="this.href='/laporan/project/tahunan/' + document.getElementById('thn_proyek').value"
                    target="_blank" class="btn btn-primary col-12">
                    <span class="mdi mdi-printer me-1"></span>
                    Cetak
                </a>

            </div>
        </div>
    </div>
</div>
@endsection