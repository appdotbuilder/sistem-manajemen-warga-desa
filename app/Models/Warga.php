<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Warga
 *
 * @property int $id
 * @property int $desa_id
 * @property int $rt_id
 * @property string $nama_lengkap
 * @property string $nik
 * @property string $alamat
 * @property \Illuminate\Support\Carbon $tanggal_lahir
 * @property string $jenis_kelamin
 * @property string $pekerjaan
 * @property string $status_pernikahan
 * @property string|null $agama
 * @property string|null $pendidikan
 * @property string|null $telepon
 * @property string|null $email
 * @property string|null $nomor_kk
 * @property string|null $status_dalam_keluarga
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Desa $desa
 * @property-read \App\Models\Rt $rt
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Surat> $surats
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Warga newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Warga newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Warga query()
 * @method static \Illuminate\Database\Eloquent\Builder|Warga aktif()
 * @method static \Database\Factories\WargaFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Warga extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'desa_id',
        'rt_id',
        'nama_lengkap',
        'nik',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'pekerjaan',
        'status_pernikahan',
        'agama',
        'pendidikan',
        'telepon',
        'email',
        'nomor_kk',
        'status_dalam_keluarga',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the desa that owns the warga.
     *
     * @return BelongsTo
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    /**
     * Get the RT that owns the warga.
     *
     * @return BelongsTo
     */
    public function rt(): BelongsTo
    {
        return $this->belongsTo(Rt::class);
    }

    /**
     * Get the user account for the warga.
     *
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get the surats created by the warga.
     *
     * @return HasMany
     */
    public function surats(): HasMany
    {
        return $this->hasMany(Surat::class, 'pemohon_id');
    }

    /**
     * Scope a query to only include active wargas.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}