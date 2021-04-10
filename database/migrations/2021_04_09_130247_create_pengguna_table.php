<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenggunaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id('pengguna_id')->comment('Milik table Pengguna');
            $table->string('pengguna_name');
            $table->string('pengguna_username')->unique();
            $table->string('pengguna_password');
            $table->string('pengguna_status')->comment('Nilai adalah "active" atau "inactive"');
            $table->string('pengguna_posisi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengguna');
    }
}
