<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diagnosis_histories', function (Blueprint $table) {
            $table->id();
            $table->string('nama_user')->nullable();
            $table->json('gejala_dipilih')->comment('Array of selected gejala IDs');
            $table->json('hasil_diagnosa')->comment('Ranked CF results array');
            $table->json('cf_calculation_steps')->nullable()->comment('Step-by-step CF audit per kerusakan');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnosis_histories');
    }
};