<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsetUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aset_user', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user')->unsigned();

            $table->integer('saldo')->default(0);
            $table->integer('kupon')->default(0);

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
        Schema::dropIfExists('aset_user');
    }
}
