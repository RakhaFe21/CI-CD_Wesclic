<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTesFieldToCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->boolean('has_tes_tulis')->default(false);
            $table->json('tes_tulis_data')->nullable();
            $table->boolean('has_tes_wawancara')->default(false);
            $table->json('tes_wawancara_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['has_tes_tulis', 'tes_tulis_data', 'has_tes_wawancara', 'tes_wawancara_data']);
        });
    }
}
