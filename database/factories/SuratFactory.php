<?php

namespace Database\Factories;

use App\Models\Desa;
use App\Models\JenisSurat;
use App\Models\Rt;
use App\Models\Surat;
use App\Models\Warga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Surat>
 */
class SuratFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Surat>
     */
    protected $model = Surat::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomor_surat' => fake()->numerify('###/SK/DESA/####'),
            'jenis_surat_id' => JenisSurat::factory(),
            'pemohon_id' => Warga::factory(),
            'desa_id' => Desa::factory(),
            'rt_id' => Rt::factory(),
            'keperluan' => fake()->sentence(),
            'data_tambahan' => [
                'tujuan' => fake()->sentence(),
                'keterangan' => fake()->paragraph(),
            ],
            'status' => fake()->randomElement(['draft', 'diajukan', 'verifikasi_rt', 'menunggu_approval', 'disetujui', 'ditolak', 'selesai']),
            'catatan_rt' => fake()->optional()->sentence(),
            'catatan_kades' => fake()->optional()->sentence(),
            'alasan_penolakan' => fake()->optional()->sentence(),
        ];
    }
}