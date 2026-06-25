<?php

namespace App\Services;

use App\Models\Kecamatan;
use Illuminate\Database\Eloquent\Collection;

class ServisKecamatan
{
    public function getAll(): Collection
    {
        return Kecamatan::orderBy('nama_kecamatan')->get();
    }
}
