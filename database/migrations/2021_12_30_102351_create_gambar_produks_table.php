<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGambarProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gambar_produk', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_produk')->unsigned();

            $table->string('path');

            $table->timestamps();
            $table->foreign('id_produk')->references('id')->on('produk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gambar_produk');
    }
}
