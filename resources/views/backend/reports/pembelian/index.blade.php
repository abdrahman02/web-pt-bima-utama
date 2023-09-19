@extends('backend.layouts.main')

@section('content')
<div class="col-lg-12 d-flex flex-row gap-5 justify-content-center">
    <a href="/laporan/buy/harian" class="text-decoration-none">
        <div class="col-lg-12">
            <div class="card bg-primary">
                <div class="card-body d-flex justify-content-center align-items-center">
                    <h4 class="card-title card-title-dash text-white mb-4">Harian</h4>
                </div>
            </div>
        </div>
    </a>
    <a href="/laporan/buy/mingguan" class="text-decoration-none">
        <div class="col-lg-12">
            <div class="card bg-info">
                <div class="card-body d-flex justify-content-center align-items-center">
                    <h4 class="card-title card-title-dash text-white mb-4">Mingguan</h4>
                </div>
            </div>
        </div>
    </a>
    <a href="/laporan/buy/bulanan" class="text-decoration-none">
        <div class="col-lg-12">
            <div class="card bg-primary">
                <div class="card-body d-flex justify-content-center align-items-center">
                    <h4 class="card-title card-title-dash text-white mb-4">Bulanan</h4>
                </div>
            </div>
        </div>
    </a>
    <a href="/laporan/buy/tahunan" class="text-decoration-none">
        <div class="col-lg-12">
            <div class="card bg-info">
                <div class="card-body d-flex justify-content-center align-items-center">
                    <h4 class="card-title card-title-dash text-white mb-4">Tahunan</h4>
                </div>
            </div>
        </div>
    </a>
</div>

@endsection