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
    { {
            Schema::create('supply', function (Blueprint $table) {
                $table->id();
                $table->date('tanggal');
                $table->string('nama_driver');
                $table->string('nopol');
                $table->string('nama_perusahaan');
                $table->string('no_surat_jalan')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supply');
    }
};
