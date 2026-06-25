<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Urutan penting:
    *   1. Admin     — tidak ada dependensi
    *   2. User      — tidak ada dependensi
    *   3. Kecamatan — harus ada sebelum Apotek
    *   4. Jalan     — berdiri sendiri (untuk fitur search titik awal)
    *   5. Apotek    — butuh Kecamatan; juga seed JamOperasional di dalamnya
     */
    public function run(): void
    {
        $this->command->info('Menjalankan seeder...');

        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            KecamatanSeeder::class,
            JalanSeeder::class,
            ApotekSeeder::class,
        ]);

        $this->command->newLine();
        $this->command->info('Seeder selesai.');
    }
}
