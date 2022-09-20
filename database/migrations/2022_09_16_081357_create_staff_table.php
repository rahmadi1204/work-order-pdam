<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('user_id')->nullable();
            $table->string('nama');
            $table->string('image')->nullable();
            $table->string('kode_jabatan')->unique();
            $table->string('kategori_jabatan')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('nip')->nullable();
            $table->string('ruang')->nullable();
            $table->string('golongan')->nullable();
            $table->string('jenjang')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('staff');
    }
};
