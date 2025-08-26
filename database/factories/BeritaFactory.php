<?php

namespace Database\Factories;

use App\Models\Berita;
use App\Models\Desa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Berita>
 */
class BeritaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Berita>
     */
    protected $model = Berita::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $judul = fake()->sentence(6, true);
        
        return [
            'desa_id' => Desa::factory(),
            'user_id' => User::factory(),
            'judul' => $judul,
            'slug' => Str::slug($judul) . '-' . fake()->unique()->numerify('###'),
            'ringkasan' => fake()->paragraph(),
            'konten' => fake()->paragraphs(5, true),
            'gambar_utama' => fake()->optional()->imageUrl(),
            'galeri' => fake()->optional()->randomElements([
                fake()->imageUrl(),
                fake()->imageUrl(),
                fake()->imageUrl(),
            ], fake()->numberBetween(0, 3)),
            'kategori' => fake()->randomElement(['pengumuman', 'kegiatan', 'berita', 'informasi']),
            'status' => fake()->randomElement(['draft', 'published', 'archived']),
            'is_pinned' => fake()->boolean(10),
            'views_count' => fake()->numberBetween(0, 500),
            'published_at' => fake()->optional(0.8)->dateTimeThisYear(),
        ];
    }
}