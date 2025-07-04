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
        Schema::create('arsip_ng', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supply_id')->nullable();
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->date('tanggal_masuk');
            $table->time('jam_masuk');
            $table->string('nama_driver');
            $table->string('nopol');
            $table->string('nama_perusahaan');
            $table->string('nama_barang');
            $table->string('jumlah_barang');
            $table->text('keterangan')->nullable();
            $table->timestamp('tanggal_update_qc')->nullable();
            $table->timestamps();
        });
        Schema::create('arsip_hold', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supply_id')->nullable();
            $table->unsignedBigInteger('barang_id')->nullable();
            $table->date('tanggal_masuk');
            $table->time('jam_masuk');
            $table->string('nama_driver');
            $table->string('nopol');
            $table->string('nama_perusahaan');
            $table->string('nama_barang');
            $table->string('jumlah_barang');
            $table->text('keterangan')->nullable();
            $table->timestamp('tanggal_update_qc')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_ng');
        Schema::dropIfExists('arsip_hold');
    }
};
