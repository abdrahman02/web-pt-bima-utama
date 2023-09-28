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
        Schema::create('pemakaian_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pemakaian_id');
            $table->foreign('pemakaian_id')->references('id')->on('pemakaians')->onDelete('cascade');
            $table->unsignedBigInteger('barang_id');
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
            $table->string('jumlah');
            $table->string('sub_total_harga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemakaian_details');
    }
};
