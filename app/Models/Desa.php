<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Desa
 *
 * @property int $id
 * @property string $nama_desa
 * @property string $kode_desa
 * @property string $kecamatan
 * @property string $kabupaten
 * @property string $provinsi
 * @property string|null $alamat
 * @property string|null $kode_pos
 * @property string|null $telepon
 * @property string|null $email
 * @property string|null $visi
 * @property string|null $misi
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rt> $rts
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Warga> $wargas
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Berita> $beritas
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Surat> $surats
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Desa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Desa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Desa query()
 * @method static \Illuminate\Database\Eloquent\Builder|Desa aktif()
 * @method static \Database\Factories\DesaFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Desa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_desa',
        'kode_desa',
        'kecamatan',
        'kabupaten',
        'provinsi',
        'alamat',
        'kode_pos',
        'telepon',
        'email',
        'visi',
        'misi',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the RTs that belong to the desa.
     *
     * @return HasMany
     */
    public function rts(): HasMany
    {
        return $this->hasMany(Rt::class);
    }

    /**
     * Get the wargas that belong to the desa.
     *
     * @return HasMany
     */
    public function wargas(): HasMany
    {
        return $this->hasMany(Warga::class);
    }

    /**
     * Get the users that belong to the desa.
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the beritas that belong to the desa.
     *
     * @return HasMany
     */
    public function beritas(): HasMany
    {
        return $this->hasMany(Berita::class);
    }

    /**
     * Get the surats that belong to the desa.
     *
     * @return HasMany
     */
    public function surats(): HasMany
    {
        return $this->hasMany(Surat::class);
    }

    /**
     * Scope a query to only include active desas.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}