<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('diagnosis_histories', function (Blueprint $table) {
            // Tambahkan kolom HANYA JIKA belum ada
            if (!Schema::hasColumn('diagnosis_histories', 'nama_user')) {
                $table->string('nama_user')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('diagnosis_histories', function (Blueprint $table) {
            if (Schema::hasColumn('diagnosis_histories', 'nama_user')) {
                $table->dropColumn('nama_user');
            }
        });
    }
};