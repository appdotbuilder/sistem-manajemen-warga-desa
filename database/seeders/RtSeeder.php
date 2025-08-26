<?php

namespace Database\Seeders;

use App\Models\Rt;
use Illuminate\Database\Seeder;

class RtSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $desa_id = 1; // Assuming first desa
        
        // Create RT/RW combinations
        for ($rw = 1; $rw <= 3; $rw++) {
            for ($rt = 1; $rt <= 4; $rt++) {
                Rt::create([
                    'desa_id' => $desa_id,
                    'nomor_rt' => str_pad((string)$rt, 2, '0', STR_PAD_LEFT),
                    'nomor_rw' => str_pad((string)$rw, 2, '0', STR_PAD_LEFT),
                    'nama_rt' => 'Bapak RT ' . $rt,
                    'nama_rw' => 'Bapak RW ' . $rw,
                    'wilayah' => 'Kampung Sukamaju ' . $rw,
                    'jumlah_kk' => random_int(15, 25),
                    'jumlah_warga' => random_int(50, 100),
                ]);
            }
        }
    }
}