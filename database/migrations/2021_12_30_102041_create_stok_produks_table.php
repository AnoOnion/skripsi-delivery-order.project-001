<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStokProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stok_produk', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_admin')->unsigned();
            $table->bigInteger('id_produk')->unsigned();

            $table->integer('stok_awal');
            $table->integer('stok_sementara')->default(0);
            $table->integer('stok_akhir')->default(0);
            $table->integer('harga_beli')->default(0);
            $table->integer('harga_jual');

            $table->timestamps();
            $table->foreign('id_admin')->references('id')->on('admin');
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
        Schema::dropIfExists('stok_produk');
    }
}
