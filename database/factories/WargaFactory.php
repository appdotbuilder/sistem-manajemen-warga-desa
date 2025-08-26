<?php

namespace Database\Factories;

use App\Models\Desa;
use App\Models\Rt;
use App\Models\Warga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Warga>
 */
class WargaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Warga>
     */
    protected $model = Warga::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenis_kelamin = fake()->randomElement(['laki-laki', 'perempuan']);
        
        return [
            'desa_id' => Desa::factory(),
            'rt_id' => Rt::factory(),
            'nama_lengkap' => fake()->name(),
            'nik' => fake()->numerify('################'),
            'alamat' => fake()->address(),
            'tanggal_lahir' => fake()->dateTimeBetween('-70 years', '-17 years')->format('Y-m-d'),
            'jenis_kelamin' => $jenis_kelamin,
            'pekerjaan' => fake()->jobTitle(),
            'status_pernikahan' => fake()->randomElement(['belum_menikah', 'menikah', 'cerai_hidup', 'cerai_mati']),
            'agama' => fake()->randomElement(['Islam', 'Kristen', 'Katholik', 'Hindu', 'Buddha', 'Konghucu']),
            'pendidikan' => fake()->randomElement(['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3']),
            'telepon' => fake()->phoneNumber(),
            'email' => fake()->optional()->safeEmail(),
            'nomor_kk' => fake()->numerify('################'),
            'status_dalam_keluarga' => fake()->randomElement(['kepala_keluarga', 'istri', 'anak', 'menantu', 'cucu', 'orangtua']),
            'status' => fake()->randomElement(['aktif', 'pindah', 'meninggal']),
        ];
    }
}