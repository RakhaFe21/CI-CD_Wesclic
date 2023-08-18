<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->longtext('about')->nullable();
            $table->string('image')->nullable();
            $table->string('fb')->nullable();
            $table->string('tw')->nullable();
            $table->string('linked')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // Ubah nullable sesuai kebutuhan
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('nik')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('dtks')->nullable();
            $table->boolean('is_disable')->nullable();
            $table->unsignedBigInteger('id_provinsi')->nullable();
            $table->string('nama_provinsi')->nullable();
            $table->unsignedBigInteger('id_kota')->nullable();
            $table->string('nama_kota')->nullable();
            $table->unsignedBigInteger('id_kecamatan')->nullable();
            $table->string('nama_kecamatan')->nullable();
            $table->unsignedBigInteger('id_kelurahan')->nullable();
            $table->string('nama_kelurahan')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('students');
    }
}
