<?php

namespace Database\Factories;

use App\Models\Desa;
use App\Models\Rt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rt>
 */
class RtFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Rt>
     */
    protected $model = Rt::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'desa_id' => Desa::factory(),
            'nomor_rt' => str_pad((string)fake()->numberBetween(1, 20), 2, '0', STR_PAD_LEFT),
            'nomor_rw' => str_pad((string)fake()->numberBetween(1, 10), 2, '0', STR_PAD_LEFT),
            'nama_rt' => fake()->name(),
            'nama_rw' => fake()->name(),
            'wilayah' => fake()->streetName(),
            'jumlah_kk' => fake()->numberBetween(10, 50),
            'jumlah_warga' => fake()->numberBetween(30, 200),
        ];
    }
}