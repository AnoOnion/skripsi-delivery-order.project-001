<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user')->unsigned();
            $table->bigInteger('id_admin')->unsigned()->nullable();

            $table->string('kode_pembayaran')->unique();
            $table->enum('status_order', ['belum', 'aktif', 'batal', 'berhasil'])->default('belum');
            $table->enum('status_kurir', ['belum', 'pending', 'process', 'canceled', 'delivered'])->default('belum');
            $table->enum('status_bayar', ['belum', 'lunas', 'gagal'])->default('belum');
            $table->enum('metode_bayar', ['tunai', 'saldo'])->nullable();

            $table->integer('jumlah')->default(0);
            $table->integer('jumlah_fee')->default(1000);
            $table->integer('jumlah_tunai')->default(0);
            $table->integer('jumlah_kembalian')->default(0);

            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('alamat_lengkap')->nullable();

            $table->timestamps();
            $table->foreign('id_user')->references('id')->on('user');
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
        Schema::dropIfExists('pembayaran');
    }
}
