<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKursusSesiEnrollmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kursus_sesi_enrollment', function (Blueprint $table) {
            $table->id('id_kursus_sesi_enrollment');
            $table->unsignedBigInteger('id_kursus_sesi');
            $table->unsignedBigInteger('id_enrollment');
            $table->string('nama_jadwal', 255)->nullable();
            $table->string('nama_sesi', 255)->nullable();
            $table->string('tanggal_sesi', 255)->nullable();
            $table->string('jam_sesi', 255)->nullable();
            $table->string('lokasi_sesi', 255)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            // $table->primary('id_kursus_sesi_enrollment');
            // $table->index('id_kursus_sesi');
            // $table->index('id_enrollment');
            
            // $table->foreign('id_kursus_sesi')
            //       ->references('id')
            //       ->on('kursus_sesi')
            //       ->onDelete('cascade');
            
            // $table->foreign('id_enrollment')
            //       ->references('id')
            //       ->on('enrollment')
            //       ->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kursus_sesi_enrollment');
    }
}
