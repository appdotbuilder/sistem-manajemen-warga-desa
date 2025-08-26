<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\JenisSurat
 *
 * @property int $id
 * @property string $nama_surat
 * @property string $kode_surat
 * @property string|null $deskripsi
 * @property string $template_surat
 * @property array|null $field_required
 * @property bool $perlu_verifikasi_rt
 * @property bool $perlu_approval_kades
 * @property int $estimasi_hari
 * @property float $biaya
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Surat> $surats
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSurat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSurat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSurat query()
 * @method static \Illuminate\Database\Eloquent\Builder|JenisSurat active()
 * @method static \Database\Factories\JenisSuratFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class JenisSurat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_surat',
        'kode_surat',
        'deskripsi',
        'template_surat',
        'field_required',
        'perlu_verifikasi_rt',
        'perlu_approval_kades',
        'estimasi_hari',
        'biaya',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'field_required' => 'array',
        'perlu_verifikasi_rt' => 'boolean',
        'perlu_approval_kades' => 'boolean',
        'estimasi_hari' => 'integer',
        'biaya' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the surats for this jenis surat.
     *
     * @return HasMany
     */
    public function surats(): HasMany
    {
        return $this->hasMany(Surat::class);
    }

    /**
     * Scope a query to only include active jenis surats.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}