<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Surat
 *
 * @property int $id
 * @property string $nomor_surat
 * @property int $jenis_surat_id
 * @property int $pemohon_id
 * @property int $desa_id
 * @property int $rt_id
 * @property string $keperluan
 * @property array|null $data_tambahan
 * @property string $status
 * @property string|null $catatan_rt
 * @property string|null $catatan_kades
 * @property string|null $alasan_penolakan
 * @property int|null $diverifikasi_oleh
 * @property \Illuminate\Support\Carbon|null $tanggal_verifikasi
 * @property int|null $disetujui_oleh
 * @property \Illuminate\Support\Carbon|null $tanggal_persetujuan
 * @property \Illuminate\Support\Carbon|null $tanggal_selesai
 * @property string|null $file_surat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\JenisSurat $jenisSurat
 * @property-read \App\Models\Warga $pemohon
 * @property-read \App\Models\Desa $desa
 * @property-read \App\Models\Rt $rt
 * @property-read \App\Models\User|null $verifikator
 * @property-read \App\Models\User|null $approver
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Surat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Surat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Surat query()
 * @method static \Illuminate\Database\Eloquent\Builder|Surat byStatus(string $status)
 * @method static \Database\Factories\SuratFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Surat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nomor_surat',
        'jenis_surat_id',
        'pemohon_id',
        'desa_id',
        'rt_id',
        'keperluan',
        'data_tambahan',
        'status',
        'catatan_rt',
        'catatan_kades',
        'alasan_penolakan',
        'diverifikasi_oleh',
        'tanggal_verifikasi',
        'disetujui_oleh',
        'tanggal_persetujuan',
        'tanggal_selesai',
        'file_surat',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data_tambahan' => 'array',
        'tanggal_verifikasi' => 'datetime',
        'tanggal_persetujuan' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the jenis surat for this surat.
     *
     * @return BelongsTo
     */
    public function jenisSurat(): BelongsTo
    {
        return $this->belongsTo(JenisSurat::class);
    }

    /**
     * Get the pemohon (warga) who requested this surat.
     *
     * @return BelongsTo
     */
    public function pemohon(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'pemohon_id');
    }

    /**
     * Get the desa for this surat.
     *
     * @return BelongsTo
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    /**
     * Get the RT for this surat.
     *
     * @return BelongsTo
     */
    public function rt(): BelongsTo
    {
        return $this->belongsTo(Rt::class);
    }

    /**
     * Get the user who verified this surat.
     *
     * @return BelongsTo
     */
    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    /**
     * Get the user who approved this surat.
     *
     * @return BelongsTo
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    /**
     * Scope a query to filter by status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}