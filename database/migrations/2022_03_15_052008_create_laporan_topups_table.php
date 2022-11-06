<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanTopupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_topup', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user')->unsigned();

            $table->string('kode_external')->nullable();
            $table->string('metode');
            $table->string('bank_kode')->nullable();
            $table->integer('jumlah');
            $table->text('deskripsi')->nullable();

            $table->timestamps();
            $table->foreign('id_user')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_topup');
    }
}
