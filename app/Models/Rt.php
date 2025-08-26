<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Rt
 *
 * @property int $id
 * @property int $desa_id
 * @property string $nomor_rt
 * @property string $nomor_rw
 * @property string|null $nama_rt
 * @property string|null $nama_rw
 * @property string|null $wilayah
 * @property int $jumlah_kk
 * @property int $jumlah_warga
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Desa $desa
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Warga> $wargas
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Surat> $surats
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Rt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rt query()
 * @method static \Database\Factories\RtFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Rt extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'desa_id',
        'nomor_rt',
        'nomor_rw',
        'nama_rt',
        'nama_rw',
        'wilayah',
        'jumlah_kk',
        'jumlah_warga',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'jumlah_kk' => 'integer',
        'jumlah_warga' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the desa that owns the RT.
     *
     * @return BelongsTo
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    /**
     * Get the wargas that belong to the RT.
     *
     * @return HasMany
     */
    public function wargas(): HasMany
    {
        return $this->hasMany(Warga::class);
    }

    /**
     * Get the users that belong to the RT.
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the surats that belong to the RT.
     *
     * @return HasMany
     */
    public function surats(): HasMany
    {
        return $this->hasMany(Surat::class);
    }
}