<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('diagnosis_histories', function (Blueprint $table) {
        if (!Schema::hasColumn('diagnosis_histories', 'nama_user')) {
            $table->string('nama_user')->nullable();
        }
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
