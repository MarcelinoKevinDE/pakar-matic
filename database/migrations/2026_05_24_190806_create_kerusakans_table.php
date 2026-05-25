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
    Schema::create('kerusakans', function (Blueprint $table) {
        $table->id();
        $table->string('kode_kerusakan'); // HARUS ADA
        $table->string('nama_kerusakan'); // HARUS ADA
        $table->text('solusi');           // HARUS ADA
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kerusakans');
    }
};
