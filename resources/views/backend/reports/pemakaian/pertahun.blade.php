@extends('backend.layouts.main')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Tabel Cetak Pemakaian Tahunan</h4>
            <p class="card-description text-danger">
                Pilih tahun untuk mencetak!
            </p>

            <div class="form-group">

                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text mdi mdi-calendar"></span>
                        </div>
                        <select class="form-control" id="thn_pemakaian" name="thn_pemakaian">
                            <option value="">Pilih Tahun</option>
                            @foreach($tahun_pemakaian as $tahun)
                            <option value="{{ $tahun->year }}">{{ $tahun->year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <a href="" onclick="this.href='/laporan/use/tahunan/' + document.getElementById('thn_pemakaian').value"
                    target="_blank" class="btn btn-primary col-12">
                    <span class="mdi mdi-printer me-1"></span>
                    Cetak
                </a>

            </div>
        </div>
    </div>
</div>
@endsection