<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('diagnosis_histories', function (Blueprint $table) {
        $table->string('nama_user')->nullable(); // Sesuaikan tipe data
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('diagnosis_histories', function (Blueprint $table) {
        $table->dropColumn('nama_user');
    });
}
};
