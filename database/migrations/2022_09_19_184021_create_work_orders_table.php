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
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->dateTime('tgl_work_order');
            $table->dateTime('tgl_work_order_response')->nullable();
            $table->dateTime('tgl_work_order_done')->nullable();
            $table->string('type_id');
            $table->string('document_id')->nullable();
            $table->string('staff_id');
            $table->string('client_id')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('google_maps')->nullable();
            $table->string('keterangan_work_order')->nullable();
            $table->string('keterangan_petugas')->nullable();
            $table->string('keterangan_selesai')->nullable();
            $table->string('status_work_order')->default('pending');
            $table->string('image')->nullable();
            $table->string('created_by');
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('work_orders');
    }
};
