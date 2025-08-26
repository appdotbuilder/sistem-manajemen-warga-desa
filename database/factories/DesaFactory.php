<?php

namespace Database\Factories;

use App\Models\Desa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Desa>
 */
class DesaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Desa>
     */
    protected $model = Desa::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_desa' => fake()->words(2, true) . ' Village',
            'kode_desa' => fake()->lexify('???'),
            'kecamatan' => 'Kecamatan ' . fake()->city(),
            'kabupaten' => 'Kabupaten ' . fake()->city(),
            'provinsi' => fake()->randomElement(['Jawa Barat', 'Jawa Tengah', 'Jawa Timur', 'DKI Jakarta', 'Banten']),
            'alamat' => fake()->address(),
            'kode_pos' => fake()->postcode(),
            'telepon' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'visi' => fake()->sentence(10),
            'misi' => fake()->paragraph(),
            'status' => fake()->randomElement(['aktif', 'nonaktif']),
        ];
    }
}