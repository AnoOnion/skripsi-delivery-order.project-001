<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuangPesansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruang_pesan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user')->unsigned();
            $table->bigInteger('id_admin')->unsigned();

            $table->enum('pengirim', ['user', 'admin']);
            $table->string('pesan');

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
        Schema::dropIfExists('ruang_pesan');
    }
}
