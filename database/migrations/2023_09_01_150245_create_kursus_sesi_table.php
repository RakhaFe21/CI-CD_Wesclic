<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKursusSesiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kursus_sesi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kursus_jadwal')->nullable();
            $table->string('nama_sesi')->nullable();
            $table->string('tanggal_sesi')->nullable();
            $table->string('jam_sesi')->nullable();
            $table->string('lokasi_sesi')->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            $table->foreign('id_kursus_jadwal')
            ->references('id')
            ->on('kursus_jadwal')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kursus_sesi');
    }
}
