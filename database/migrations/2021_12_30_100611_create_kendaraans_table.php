<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKendaraansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_admin')->unsigned();

            $table->string('plat_nomer');
            $table->string('nama_merk');
            $table->string('gambar')->default('not-found.png');
            $table->float('volume_bensin')->nullable();
            $table->timestamp('tanggal_berlaku')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_admin')->references('id')->on('admin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kendaraan');
    }
}
