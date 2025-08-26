<?php

namespace Database\Factories;

use App\Models\JenisSurat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JenisSurat>
 */
class JenisSuratFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\JenisSurat>
     */
    protected $model = JenisSurat::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_surat' => 'Surat ' . fake()->words(2, true),
            'kode_surat' => fake()->lexify('???'),
            'deskripsi' => fake()->sentence(),
            'template_surat' => fake()->paragraph(),
            'field_required' => ['keperluan'],
            'perlu_verifikasi_rt' => fake()->boolean(80),
            'perlu_approval_kades' => fake()->boolean(90),
            'estimasi_hari' => fake()->numberBetween(1, 7),
            'biaya' => fake()->randomFloat(2, 0, 50000),
            'is_active' => fake()->boolean(90),
        ];
    }
}