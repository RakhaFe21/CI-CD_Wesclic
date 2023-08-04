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
            $table->string('nik')->collation('utf8mb4_unicode_ci ')->default();
            $table->date('tgl_lahir')->default();
            $table->string('dtks')->collation('utf8mb4_unicode_ci ')->default();
            $table->boolean('is_disable')->default(0);
            $table->bigInteger('id_provinsi')->unsigned();
            $table->string('nama_provinsi')->collation('utf8mb4_unicode_ci ')->default();
            $table->bigInteger('id_kota')->unsigned();
            $table->string('nama_kota')->collation('utf8mb4_unicode_ci ')->default();
            $table->bigInteger('id_kecamatan')->default();
            $table->string('nama_kecamatan')->collation('utf8mb4_unicode_ci')->default();
            $table->bigInteger('id_kelurahan')->default();
            $table->string('nama_kelurahan')->collation('utf8mb4_unicode_ci')->default();
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
