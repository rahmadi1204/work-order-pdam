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
        Schema::create('type_work_orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('pts')->nullable();
            $table->string('jenis_work_order')->nullable();
            $table->string('keterangan')->nullable();
            $table->bigInteger('jumlah_pengorder')->default(0);
            $table->string('responder')->nullable();
            $table->string('nosal')->nullable();
            $table->string('bon')->nullable();
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
        Schema::dropIfExists('type_work_orders');
    }
};
