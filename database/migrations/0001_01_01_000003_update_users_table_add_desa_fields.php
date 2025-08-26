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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['super_admin', 'admin_desa', 'kepala_desa', 'ketua_rt', 'warga'])->default('warga')->after('password');
            $table->unsignedBigInteger('desa_id')->nullable()->after('role');
            $table->unsignedBigInteger('rt_id')->nullable()->after('desa_id');
            $table->unsignedBigInteger('warga_id')->nullable()->after('rt_id');
            $table->string('telepon')->nullable()->after('warga_id');
            $table->text('alamat')->nullable()->after('telepon');
            $table->boolean('is_active')->default(true)->after('alamat');
            
            $table->index(['role', 'desa_id']);
            $table->index(['role', 'rt_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role', 'desa_id']);
            $table->dropIndex(['role', 'rt_id']);
            $table->dropColumn([
                'role', 'desa_id', 'rt_id', 'warga_id', 
                'telepon', 'alamat', 'is_active'
            ]);
        });
    }
};