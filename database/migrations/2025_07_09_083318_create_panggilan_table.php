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
        Schema::create('panggilan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id');
            $table->enum('dari', ['QC', 'PPIC']);
            $table->text('pesan'); // berisi pesan seperti "No antrian 1, PT A menuju QC ..."
            $table->boolean('sudah_ditampilkan')->default(false);
            $table->timestamps();
        });
            }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panggilan');
    }
};
