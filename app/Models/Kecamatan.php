<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_kecamatan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_kecamatan',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get all apotek in this kecamatan.
     */
    public function apotek(): HasMany
    {
        return $this->hasMany(Apotek::class, 'kecamatan_id');
    }
}
