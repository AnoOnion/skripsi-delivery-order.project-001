<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_admin')->unsigned();

            $table->string('kode_item')->unique();
            $table->string('nama_item');
            $table->text('deskripsi')->nullable();
            $table->float('berat')->nullable();
            $table->float('volume')->nullable();
            $table->enum('kupon', ['ya', 'tidak'])->default('tidak');
            $table->boolean('status')->default(1);

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
        Schema::dropIfExists('produk');
    }
}
