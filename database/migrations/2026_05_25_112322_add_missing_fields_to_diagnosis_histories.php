<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('diagnosis_histories', function (Blueprint $table) {
            // Tambahkan kolom jika belum ada
            if (!Schema::hasColumn('diagnosis_histories', 'selected_symptoms')) {
                $table->text('selected_symptoms')->nullable();
            }
            if (!Schema::hasColumn('diagnosis_histories', 'symptom_details')) {
                $table->text('symptom_details')->nullable();
            }
            if (!Schema::hasColumn('diagnosis_histories', 'kerusakan_id')) {
                $table->string('kerusakan_id')->nullable();
            }
            if (!Schema::hasColumn('diagnosis_histories', 'kerusakan_name')) {
                $table->string('kerusakan_name')->nullable();
            }
            if (!Schema::hasColumn('diagnosis_histories', 'certainty_factor')) {
                $table->string('certainty_factor')->nullable();
            }
            if (!Schema::hasColumn('diagnosis_histories', 'confidence_level')) {
                $table->string('confidence_level')->nullable();
            }
            if (!Schema::hasColumn('diagnosis_histories', 'cf_calculation_steps')) {
                $table->text('cf_calculation_steps')->nullable();
            }
            if (!Schema::hasColumn('diagnosis_histories', 'ip_address')) {
                $table->string('ip_address')->nullable();
            }
            if (!Schema::hasColumn('diagnosis_entities', 'user_agent')) { // Perbaiki jika typo
                $table->text('user_agent')->nullable();
            }
        });
    }

    public function down(): void
    {
        // Tidak perlu diisi jika tidak ingin rollback
    }
};