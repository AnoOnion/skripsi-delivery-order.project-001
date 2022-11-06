<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id();

            $table->string('nama_depan');
            $table->string('nama_belakang')->nullable();

            $table->string('email')->unique();
            $table->string('password');

            $table->enum('level', ['admin', 'kurir']);

            $table->string('avatar')->default('https://www.gravatar.com/avatar/1667f76cd188f63e4c39792bb4357838?d=mm&s=40');
            $table->string('no_telpon')->nullable();
            $table->enum('jenis_kelamin', ['l', 'p'])->nullable();
            $table->timestamp('tanggal_lahir')->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
}
