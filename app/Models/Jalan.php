<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jalan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_jalan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_jalan',
        'latitude_center',
        'longitude_center',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'latitude_center' => 'float',
            'longitude_center' => 'float',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
