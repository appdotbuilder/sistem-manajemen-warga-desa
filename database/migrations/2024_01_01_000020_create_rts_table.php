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
        Schema::create('rts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')->constrained('desas')->onDelete('cascade');
            $table->string('nomor_rt');
            $table->string('nomor_rw');
            $table->string('nama_rt')->nullable();
            $table->string('nama_rw')->nullable();
            $table->text('wilayah')->nullable();
            $table->integer('jumlah_kk')->default(0);
            $table->integer('jumlah_warga')->default(0);
            $table->timestamps();
            
            $table->unique(['desa_id', 'nomor_rt', 'nomor_rw']);
            $table->index(['desa_id', 'nomor_rt']);
            $table->index('nomor_rw');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rts');
    }
};