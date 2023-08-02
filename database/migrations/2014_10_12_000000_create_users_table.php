<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('email')->unique();
            $table->bigInteger('nik',16);
            $table->enum('user_type',['Student','Instructor','Admin'])->nullable(); //this is identify user type
            //1=Admin,2=Instructor,3=Student
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('verified')->default(false);
            $table->string('password')->nullable();
            $table->boolean('banned')->default(false); // User cannot login if banned
            $table->string('provider_id')->nullable(); // this is for login fb,g+ etc
            $table->string('image')->nullable()->default('uploads/user/user.png');
            $table->string('remember_token',100)->default();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->longText('zoom_email')->nullable(); // for Zoom
            $table->longText('jwt_token')->nullable(); // for Zoom
            $table->rememberToken();     
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
