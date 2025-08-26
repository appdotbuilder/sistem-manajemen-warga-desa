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
        Schema::create('wargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('desa_id')->constrained('desas')->onDelete('cascade');
            $table->foreignId('rt_id')->constrained('rts')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('nik', 16)->unique();
            $table->text('alamat');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('pekerjaan');
            $table->enum('status_pernikahan', ['belum_menikah', 'menikah', 'cerai_hidup', 'cerai_mati']);
            $table->string('agama')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('nomor_kk')->nullable();
            $table->enum('status_dalam_keluarga', ['kepala_keluarga', 'istri', 'anak', 'menantu', 'cucu', 'orangtua', 'mertua', 'famili_lain', 'pembantu', 'lainnya'])->nullable();
            $table->enum('status', ['aktif', 'pindah', 'meninggal'])->default('aktif');
            $table->timestamps();
            
            $table->index('nama_lengkap');
            $table->index('nik');
            $table->index(['desa_id', 'rt_id']);
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wargas');
    }
};