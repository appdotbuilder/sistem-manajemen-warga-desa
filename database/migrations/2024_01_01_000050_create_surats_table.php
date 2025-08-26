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
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->foreignId('jenis_surat_id')->constrained('jenis_surats')->onDelete('cascade');
            $table->foreignId('pemohon_id')->constrained('wargas', 'id')->onDelete('cascade');
            $table->foreignId('desa_id')->constrained('desas')->onDelete('cascade');
            $table->foreignId('rt_id')->constrained('rts')->onDelete('cascade');
            $table->text('keperluan');
            $table->json('data_tambahan')->nullable();
            $table->enum('status', ['draft', 'diajukan', 'verifikasi_rt', 'menunggu_approval', 'disetujui', 'ditolak', 'selesai'])->default('draft');
            $table->text('catatan_rt')->nullable();
            $table->text('catatan_kades')->nullable();
            $table->text('alasan_penolakan')->nullable();
            $table->foreignId('diverifikasi_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('tanggal_verifikasi')->nullable();
            $table->foreignId('disetujui_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('tanggal_persetujuan')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->string('file_surat')->nullable();
            $table->timestamps();
            
            $table->index('nomor_surat');
            $table->index(['pemohon_id', 'status']);
            $table->index(['desa_id', 'rt_id', 'status']);
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};