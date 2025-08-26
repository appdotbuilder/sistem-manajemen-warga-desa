<?php

namespace Database\Seeders;

use App\Models\Desa;
use Illuminate\Database\Seeder;

class DesaSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        Desa::create([
            'nama_desa' => 'Desa Sukamaju',
            'kode_desa' => 'SMJ',
            'kecamatan' => 'Kecamatan Sukamaju',
            'kabupaten' => 'Kabupaten Bandung',
            'provinsi' => 'Jawa Barat',
            'alamat' => 'Jl. Raya Sukamaju No. 123',
            'kode_pos' => '40123',
            'telepon' => '022-1234567',
            'email' => 'desa@sukamaju.go.id',
            'visi' => 'Mewujudkan Desa Sukamaju yang maju, sejahtera, dan berkarakter',
            'misi' => 'Meningkatkan pelayanan publik yang prima dan transparan',
            'status' => 'aktif',
        ]);
    }
}