<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->text('keterangan')->nullable()->change(); // ubah dari varchar ke text
        });
    }

    public function down()
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->string('keterangan', 100)->change(); // rollback ke semula
        });
    }
};
