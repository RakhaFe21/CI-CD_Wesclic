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
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users'); 
            $table->string('nik')->default();
            $table->date('tgl_lahir')->default(now());
            $table->string('dtks')->default();
            $table->boolean('is_disable')->default(0);
            $table->unsignedBigInteger('id_provinsi');
            $table->foreign('id_provinsi')
                ->references('id')->on('users');
            $table->string('nama_provinsi')->default();
            $table->unsignedBigInteger('id_kota');
            $table->foreign('id_kota')
                ->references('id')->on('users');
            $table->string('nama_kota')->default();
            $table->unsignedBigInteger('id_kecamatan');
            $table->foreign('id_kecamatan')
                ->references('id')->on('users');
            $table->string('nama_kecamatan')->default();
            $table->unsignedBigInteger('id_kelurahan');
            $table->foreign('id_kelurahan')
                ->references('id')->on('users');
            $table->string('nama_kelurahan')->default();
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
        Schema::dropIfExists('students');
    }
}
