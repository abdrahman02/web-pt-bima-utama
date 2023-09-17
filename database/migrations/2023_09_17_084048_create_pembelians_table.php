<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id');
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
            $table->unsignedBigInteger('suplier_id');
            $table->foreign('suplier_id')->references('id')->on('supliers')->onDelete('cascade');
            $table->string('no_fakt_pembelian');
            $table->string('tgl_pembelian');
            $table->string('jumlah');
            $table->string('status');
            $table->string('harga');
            $table->string('jumlah_bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
