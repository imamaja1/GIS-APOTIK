<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apotek extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_apotek';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kecamatan_id',
        'nama_apotek',
        'jalan_apotek',
        'alamat_lengkap',
        'no_telp',
        'latitude',
        'longitude',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the kecamatan that owns this apotek.
     */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    /**
     * Get all jam operasional for this apotek.
     */
    public function jamOperasional(): HasMany
    {
        return $this->hasMany(JamOperasional::class, 'apotek_id');
    }
}
