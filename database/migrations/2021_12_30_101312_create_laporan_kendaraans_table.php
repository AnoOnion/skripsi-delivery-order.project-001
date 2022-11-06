<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanKendaraansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_kendaraan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_admin')->unsigned()->nullable();
            $table->bigInteger('id_kendaraan')->unsigned()->nullable();

            $table->string('kode_laporan');
            $table->enum('status', [ 'ada', 'pakai', 'masalah', 'perbaikan' ]);
            $table->text('catatan')->nullable();

            $table->timestamps();
            $table->foreign('id_admin')->references('id')->on('admin');
            $table->foreign('id_kendaraan')->references('id')->on('kendaraan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_kendaraan');
    }
}
