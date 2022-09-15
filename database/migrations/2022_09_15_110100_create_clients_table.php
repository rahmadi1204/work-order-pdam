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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->dateTime('tgl_masuk')->nullable();
            $table->string('name')->nullable();
            $table->string('no_sambungan')->unique();
            $table->string('id_pelanggan')->unique();
            $table->string('no_telpon')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('no_urut')->nullable();
            $table->text('alamat');
            $table->string('id_wilayah')->nullable();
            $table->string('id_kelurahan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
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
        Schema::dropIfExists('clients');
    }
};
