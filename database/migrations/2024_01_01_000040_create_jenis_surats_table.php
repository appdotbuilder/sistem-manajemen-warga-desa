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
        Schema::create('jenis_surats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_surat');
            $table->string('kode_surat')->unique();
            $table->text('deskripsi')->nullable();
            $table->text('template_surat');
            $table->json('field_required')->nullable();
            $table->boolean('perlu_verifikasi_rt')->default(true);
            $table->boolean('perlu_approval_kades')->default(true);
            $table->integer('estimasi_hari')->default(3);
            $table->decimal('biaya', 10, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('nama_surat');
            $table->index('kode_surat');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_surats');
    }
};