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
            $table->unsignedBigInteger('id_kursus');
            $table->string('nama_jadwal', 25);
            $table->integer('jumlah_sesi_perhari');
            $table->integer('durasi_persesi');
            $table->integer('jumlah_peserta_persesi');
            $table->date('tanggal_mulai');
            $table->time('jam_mulai');
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            // $table->foreign('id_kursus')->references('id')->on('kursus');
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
