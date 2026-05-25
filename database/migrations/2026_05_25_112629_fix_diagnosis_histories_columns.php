<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('diagnosis_histories', function (Blueprint $table) {
            $columns = [
                'selected_symptoms', 'symptom_details', 'kerusakan_id', 
                'kerusakan_name', 'certainty_factor', 'confidence_level', 
                'cf_calculation_steps', 'ip_address', 'user_agent'
            ];

            foreach ($columns as $column) {
                if (!Schema::hasColumn('diagnosis_histories', $column)) {
                    $table->text($column)->nullable();
                }
            }
        });
    }

    public function down(): void
    {
        // Tidak perlu diisi
    }
};