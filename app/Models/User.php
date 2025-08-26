<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string $role
 * @property int|null $desa_id
 * @property int|null $rt_id
 * @property int|null $warga_id
 * @property string|null $telepon
 * @property string|null $alamat
 * @property bool $is_active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Desa|null $desa
 * @property-read \App\Models\Rt|null $rt
 * @property-read \App\Models\Warga|null $warga
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Berita> $beritas
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Surat> $verifiedSurats
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Surat> $approvedSurats
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User byRole(string $role)
 * @method static \Illuminate\Database\Eloquent\Builder|User active()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'desa_id',
        'rt_id',
        'warga_id',
        'telepon',
        'alamat',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the desa that the user belongs to.
     *
     * @return BelongsTo
     */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }

    /**
     * Get the RT that the user belongs to.
     *
     * @return BelongsTo
     */
    public function rt(): BelongsTo
    {
        return $this->belongsTo(Rt::class);
    }

    /**
     * Get the warga profile for the user.
     *
     * @return BelongsTo
     */
    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class);
    }

    /**
     * Get the beritas created by the user.
     *
     * @return HasMany
     */
    public function beritas(): HasMany
    {
        return $this->hasMany(Berita::class);
    }

    /**
     * Get the surats verified by the user.
     *
     * @return HasMany
     */
    public function verifiedSurats(): HasMany
    {
        return $this->hasMany(Surat::class, 'diverifikasi_oleh');
    }

    /**
     * Get the surats approved by the user.
     *
     * @return HasMany
     */
    public function approvedSurats(): HasMany
    {
        return $this->hasMany(Surat::class, 'disetujui_oleh');
    }

    /**
     * Scope a query to filter by role.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $role
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if user is super admin.
     *
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if user is admin desa.
     *
     * @return bool
     */
    public function isAdminDesa(): bool
    {
        return $this->role === 'admin_desa';
    }

    /**
     * Check if user is kepala desa.
     *
     * @return bool
     */
    public function isKepala(): bool
    {
        return $this->role === 'kepala_desa';
    }

    /**
     * Check if user is ketua RT.
     *
     * @return bool
     */
    public function isKetuaRt(): bool
    {
        return $this->role === 'ketua_rt';
    }

    /**
     * Check if user is warga.
     *
     * @return bool
     */
    public function isWarga(): bool
    {
        return $this->role === 'warga';
    }
}