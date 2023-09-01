<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKursusJadwalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kursus_jadwal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kursus')->nullable();
            $table->string('nama_jadwal')->nullable();
            $table->bigInteger('jumlah_sesi_perhari')->nullable();
            $table->bigInteger('durasi_persesi')->nullable();
            $table->bigInteger('jumlah_peserta_persesi')->nullable();
            $table->date('tanggal_mulai');
            $table->time('jam_mulai');
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
        Schema::dropIfExists('kursus_jadwal');
    }
}
