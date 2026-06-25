<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Seeder;

class KecamatanSeeder extends Seeder
{
    public function run(): void
    {
        // 5 Kecamatan resmi Kabupaten Lombok Utara (KLU)
        $kecamatan = [
            'Tanjung',    // Ibukota KLU
            'Pemenang',   // Paling barat, dekat Gili Islands
            'Gangga',     // Sebelah timur Tanjung
            'Kayangan',   // Tengah-utara
            'Bayan',      // Paling timur, dekat Rinjani
        ];

        foreach ($kecamatan as $nama) {
            Kecamatan::firstOrCreate(['nama_kecamatan' => $nama]);
        }

        $this->command->info('  ✓ KecamatanSeeder: ' . count($kecamatan) . ' kecamatan dibuat.');
    }
}
