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
        $table->string('nama_user')->nullable();
        $table->text('gejala_dipilih')->nullable();
        $table->text('hasil_diagnosa')->nullable();
        $table->text('cf_calculation_steps')->nullable();
        $table->string('ip_address')->nullable();
        $table->string('user_agent')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
