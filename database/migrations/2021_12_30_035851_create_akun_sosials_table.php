<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkunSosialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akun_sosial', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user')->unsigned();

            $table->enum('provider', [ 'google', 'facebook' ]);
            $table->string('provider_id_user');

            $table->timestamps();
            $table->foreign('id_user')->references('id')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akun_sosial');
    }
}
