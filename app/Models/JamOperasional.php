<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JamOperasional extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_jam_operasional';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'apotek_id',
        'hari',
        'status_buka',
        'jam_buka',
        'jam_tutup',
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
     * Get the apotek that owns this jam operasional.
     */
    public function apotek(): BelongsTo
    {
        return $this->belongsTo(Apotek::class, 'apotek_id');
    }
}
