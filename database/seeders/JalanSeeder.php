<?php

namespace Database\Seeders;

use App\Models\Jalan;
use Illuminate\Database\Seeder;

class JalanSeeder extends Seeder
{
    public function run(): void
    {
        // Jalan utama di KLU — koordinat center untuk fitur "Tempat Awal" di halaman Search
        $jalan = [
            [
                'nama_jalan'       => 'Jl. Ahmad Yani, Tanjung',
                'latitude_center'  => -8.35720,
                'longitude_center' => 116.10820,
            ],
            [
                'nama_jalan'       => 'Jl. Raya Tanjung - Pemenang',
                'latitude_center'  => -8.36500,
                'longitude_center' => 116.08900,
            ],
            [
                'nama_jalan'       => 'Jl. Raya Pemenang',
                'latitude_center'  => -8.37400,
                'longitude_center' => 116.07200,
            ],
            [
                'nama_jalan'       => 'Jl. Raya Gangga',
                'latitude_center'  => -8.33000,
                'longitude_center' => 116.14900,
            ],
            [
                'nama_jalan'       => 'Jl. Raya Kayangan',
                'latitude_center'  => -8.27600,
                'longitude_center' => 116.21400,
            ],
            [
                'nama_jalan'       => 'Jl. Raya Bayan',
                'latitude_center'  => -8.21800,
                'longitude_center' => 116.31000,
            ],
            [
                'nama_jalan'       => 'Jl. Pantai Senggigi (KLU)',
                'latitude_center'  => -8.38000,
                'longitude_center' => 116.06500,
            ],
            [
                'nama_jalan'       => 'Jl. Raya Anyar - Bayan',
                'latitude_center'  => -8.24000,
                'longitude_center' => 116.27000,
            ],

            // ---------------------------------------------------------------------------
            // 1. KECAMATAN PEMENANG (Jalan Lokal & Gang Desa)
            // ---------------------------------------------------------------------------
            ['nama_jalan' => 'Jalan Nelayan (Kec. Pemenang)',            'latitude_center' => -8.36050000, 'longitude_center' => 116.09650000],
            ['nama_jalan' => 'Jalan Pasar Pemenang (Kec. Pemenang)',     'latitude_center' => -8.40350000, 'longitude_center' => 116.09550000],
            ['nama_jalan' => 'Gang Manggis Bangsal (Kec. Pemenang)',     'latitude_center' => -8.36550000, 'longitude_center' => 116.09700000],
            ['nama_jalan' => 'Gang Melati Teluk Nare (Kec. Pemenang)',   'latitude_center' => -8.39050000, 'longitude_center' => 116.05200000],
            ['nama_jalan' => 'Gang Masjid Trawangan (Kec. Pemenang)',    'latitude_center' => -8.35150000, 'longitude_center' => 116.03550000],
            ['nama_jalan' => 'Jalan Pesisir Gili Meno (Kec. Pemenang)',  'latitude_center' => -8.35100000, 'longitude_center' => 116.05900000],
            ['nama_jalan' => 'Jalan Desa Gili Air (Kec. Pemenang)',      'latitude_center' => -8.35950000, 'longitude_center' => 116.08150000],
            ['nama_jalan' => 'Jalan Dusun Menggala Utara (Kec. Pemenang)',  'latitude_center' => -8.40900000, 'longitude_center' => 116.10400000],
            ['nama_jalan' => 'Jalan Dusun Menggala Selatan (Kec. Pemenang)', 'latitude_center' => -8.41100000, 'longitude_center' => 116.10600000],
            ['nama_jalan' => 'Jalan Bukit Malimbu (Kec. Pemenang)',      'latitude_center' => -8.43200000, 'longitude_center' => 116.03800000],
            ['nama_jalan' => 'Jalan Tembus Nipah (Kec. Pemenang)',       'latitude_center' => -8.42600000, 'longitude_center' => 116.04100000],
            ['nama_jalan' => 'Jalan Karang Pangsor Dalam (Kec. Pemenang)', 'latitude_center' => -8.39100000, 'longitude_center' => 116.09100000],
            ['nama_jalan' => 'Jalan Muara Putih Barat (Kec. Pemenang)',  'latitude_center' => -8.38050000, 'longitude_center' => 116.09400000],
            ['nama_jalan' => 'Jalan Muara Putih Timur (Kec. Pemenang)',  'latitude_center' => -8.37950000, 'longitude_center' => 116.09600000],
            ['nama_jalan' => 'Jalan Akses TPA Pemenang (Kec. Pemenang)', 'latitude_center' => -8.40600000, 'longitude_center' => 116.09000000],
            ['nama_jalan' => 'Jalan Pertanian Pemenang (Kec. Pemenang)', 'latitude_center' => -8.40100000, 'longitude_center' => 116.10000000],
            ['nama_jalan' => 'Gang Kenanga Pemenang (Kec. Pemenang)',    'latitude_center' => -8.40400000, 'longitude_center' => 116.09600000],
            ['nama_jalan' => 'Gang Anggrek Senggigi (Kec. Pemenang)',    'latitude_center' => -8.43400000, 'longitude_center' => 116.04100000],
            ['nama_jalan' => 'Jalan Dusun Pandanan Dalam (Kec. Pemenang)', 'latitude_center' => -8.42100000, 'longitude_center' => 116.04500000],
            ['nama_jalan' => 'Jalan Tembus Pusuk (Kec. Pemenang)',       'latitude_center' => -8.42150000, 'longitude_center' => 116.10200000],

            // ---------------------------------------------------------------------------
            // 2. KECAMATAN TANJUNG (Jalan Perumahan & Gang Kota)
            // ---------------------------------------------------------------------------
            ['nama_jalan' => 'Jalan Dusun Karang Pendem (Kec. Tanjung)',   'latitude_center' => -8.34850000, 'longitude_center' => 116.14900000],
            ['nama_jalan' => 'Jalan Dusun Karang Kates (Kec. Tanjung)',    'latitude_center' => -8.35600000, 'longitude_center' => 116.14600000],
            ['nama_jalan' => 'Jalan Dusun Karang Nangka (Kec. Tanjung)',   'latitude_center' => -8.35850000, 'longitude_center' => 116.15900000],
            ['nama_jalan' => 'Gang Masjid Agung Tanjung (Kec. Tanjung)',   'latitude_center' => -8.35650000, 'longitude_center' => 116.15600000],
            ['nama_jalan' => 'Jalan RSUD Belakang (Kec. Tanjung)',         'latitude_center' => -8.34150000, 'longitude_center' => 116.24100000],
            ['nama_jalan' => 'Jalan Komplek Pemda (Kec. Tanjung)',         'latitude_center' => -8.35900000, 'longitude_center' => 116.19600000],
            ['nama_jalan' => 'Jalan Pantai Sire Timur (Kec. Tanjung)',     'latitude_center' => -8.34550000, 'longitude_center' => 116.11600000],
            ['nama_jalan' => 'Jalan Pantai Sire Barat (Kec. Tanjung)',     'latitude_center' => -8.34450000, 'longitude_center' => 116.11400000],
            ['nama_jalan' => 'Jalan Tembus Jenggala (Kec. Tanjung)',       'latitude_center' => -8.35300000, 'longitude_center' => 116.17100000],
            ['nama_jalan' => 'Jalan Sokong Dalam (Kec. Tanjung)',          'latitude_center' => -8.36100000, 'longitude_center' => 116.14600000],
            ['nama_jalan' => 'Jalan Teniga Dalam (Kec. Tanjung)',          'latitude_center' => -8.37600000, 'longitude_center' => 116.16100000],
            ['nama_jalan' => 'Gang Buntu Tegal Maja (Kec. Tanjung)',       'latitude_center' => -8.38600000, 'longitude_center' => 116.17600000],
            ['nama_jalan' => 'Jalan Pertanian Kerta Raharja (Kec. Tanjung)', 'latitude_center' => -8.36600000, 'longitude_center' => 116.15600000],
            ['nama_jalan' => 'Jalan Dusun Gubug Rubuh (Kec. Tanjung)',     'latitude_center' => -8.37100000, 'longitude_center' => 116.15100000],
            ['nama_jalan' => 'Jalan Dusun Majeluk (Kec. Tanjung)',         'latitude_center' => -8.36300000, 'longitude_center' => 116.16600000],
            ['nama_jalan' => 'Gang Mawar Sorong Jukung (Kec. Tanjung)',    'latitude_center' => -8.35000000, 'longitude_center' => 116.14700000],
            ['nama_jalan' => 'Jalan Sira Indah Utara (Kec. Tanjung)',      'latitude_center' => -8.34500000, 'longitude_center' => 116.11900000],
            ['nama_jalan' => 'Jalan Sira Indah Selatan (Kec. Tanjung)',    'latitude_center' => -8.34700000, 'longitude_center' => 116.11700000],
            ['nama_jalan' => 'Jalan Pasar Tanjung Barat (Kec. Tanjung)',   'latitude_center' => -8.35600000, 'longitude_center' => 116.15300000],
            ['nama_jalan' => 'Jalan Lapangan Tanjung (Kec. Tanjung)',      'latitude_center' => -8.35500000, 'longitude_center' => 116.15100000],

            // ---------------------------------------------------------------------------
            // 3. KECAMATAN GANGGA (Jalan Desa & Jalur Perkebunan)
            // ---------------------------------------------------------------------------
            ['nama_jalan' => 'Jalan Desa Gondang Utara (Kec. Gangga)',    'latitude_center' => -8.34200000, 'longitude_center' => 116.26600000],
            ['nama_jalan' => 'Jalan Desa Gondang Selatan (Kec. Gangga)',  'latitude_center' => -8.34400000, 'longitude_center' => 116.26800000],
            ['nama_jalan' => 'Jalan Dusun Luk Dalam (Kec. Gangga)',       'latitude_center' => -8.35100000, 'longitude_center' => 116.28100000],
            ['nama_jalan' => 'Jalan Perkebunan Rempek (Kec. Gangga)',     'latitude_center' => -8.36100000, 'longitude_center' => 116.30100000],
            ['nama_jalan' => 'Jalan Perkebunan Genggelang (Kec. Gangga)', 'latitude_center' => -8.37100000, 'longitude_center' => 116.29600000],
            ['nama_jalan' => 'Jalan Tembus Bentek (Kec. Gangga)',         'latitude_center' => -8.36600000, 'longitude_center' => 116.25100000],
            ['nama_jalan' => 'Gang Masjid Gangga (Kec. Gangga)',          'latitude_center' => -8.34350000, 'longitude_center' => 116.26550000],
            ['nama_jalan' => 'Jalan Pantai Tebing Dalam (Kec. Gangga)',   'latitude_center' => -8.33600000, 'longitude_center' => 116.27600000],
            ['nama_jalan' => 'Jalan Segara Katon Dalam (Kec. Gangga)',    'latitude_center' => -8.34100000, 'longitude_center' => 116.26100000],
            ['nama_jalan' => 'Jalan Kerta Gangga Timur (Kec. Gangga)',    'latitude_center' => -8.35600000, 'longitude_center' => 116.27100000],
            ['nama_jalan' => 'Jalan Kerta Gangga Barat (Kec. Gangga)',    'latitude_center' => -8.35400000, 'longitude_center' => 116.26900000],
            ['nama_jalan' => 'Jalan Selelos Utara (Kec. Gangga)',         'latitude_center' => -8.36400000, 'longitude_center' => 116.28600000],
            ['nama_jalan' => 'Jalan Selelos Selatan (Kec. Gangga)',       'latitude_center' => -8.36600000, 'longitude_center' => 116.28400000],
            ['nama_jalan' => 'Gang Buntu Karang Anyar (Kec. Gangga)',     'latitude_center' => -8.34600000, 'longitude_center' => 116.26900000],
            ['nama_jalan' => 'Jalan Karang Bedil Dalam (Kec. Gangga)',    'latitude_center' => -8.34700000, 'longitude_center' => 116.26300000],
            ['nama_jalan' => 'Jalan Karang Bucu Dalam (Kec. Gangga)',     'latitude_center' => -8.34900000, 'longitude_center' => 116.26600000],
            ['nama_jalan' => 'Jalan Kakong Dalam (Kec. Gangga)',          'latitude_center' => -8.37600000, 'longitude_center' => 116.28100000],
            ['nama_jalan' => 'Jalan Penida Dalam (Kec. Gangga)',          'latitude_center' => -8.35900000, 'longitude_center' => 116.26100000],
            ['nama_jalan' => 'Jalan Tembus Gondang Timur (Kec. Gangga)',  'latitude_center' => -8.34450000, 'longitude_center' => 116.27100000],
            ['nama_jalan' => 'Jalan Tembus Gondang Barat (Kec. Gangga)',  'latitude_center' => -8.34150000, 'longitude_center' => 116.26300000],

            // ---------------------------------------------------------------------------
            // 4. KECAMATAN KAYANGAN (Jalan Setapak & Akses Pertanian)
            // ---------------------------------------------------------------------------
            ['nama_jalan' => 'Jalan Desa Kayangan Utama (Kec. Kayangan)',    'latitude_center' => -8.29900000, 'longitude_center' => 116.35600000],
            ['nama_jalan' => 'Jalan Desa Santong Utama (Kec. Kayangan)',     'latitude_center' => -8.34100000, 'longitude_center' => 116.36100000],
            ['nama_jalan' => 'Jalan Gumantar Utara (Kec. Kayangan)',         'latitude_center' => -8.30900000, 'longitude_center' => 116.32900000],
            ['nama_jalan' => 'Jalan Gumantar Selatan (Kec. Kayangan)',       'latitude_center' => -8.31100000, 'longitude_center' => 116.33100000],
            ['nama_jalan' => 'Jalan Dangiang Timur (Kec. Kayangan)',         'latitude_center' => -8.28900000, 'longitude_center' => 116.36600000],
            ['nama_jalan' => 'Jalan Dangiang Barat (Kec. Kayangan)',         'latitude_center' => -8.29100000, 'longitude_center' => 116.36400000],
            ['nama_jalan' => 'Jalan Sesait Utama (Kec. Kayangan)',           'latitude_center' => -8.30600000, 'longitude_center' => 116.34600000],
            ['nama_jalan' => 'Jalan Salut Utama (Kec. Kayangan)',            'latitude_center' => -8.27600000, 'longitude_center' => 116.38100000],
            ['nama_jalan' => 'Jalan Pantai Kayangan Dalam (Kec. Kayangan)', 'latitude_center' => -8.28600000, 'longitude_center' => 116.35100000],
            ['nama_jalan' => 'Jalan Pansor Dalam (Kec. Kayangan)',           'latitude_center' => -8.32100000, 'longitude_center' => 116.35600000],
            ['nama_jalan' => 'Jalan Dusun Karang Lande (Kec. Kayangan)',     'latitude_center' => -8.30100000, 'longitude_center' => 116.35100000],
            ['nama_jalan' => 'Jalan Dusun Karang Bunga (Kec. Kayangan)',     'latitude_center' => -8.30600000, 'longitude_center' => 116.35900000],
            ['nama_jalan' => 'Jalan Sidutan Dalam (Kec. Kayangan)',          'latitude_center' => -8.31600000, 'longitude_center' => 116.34100000],
            ['nama_jalan' => 'Jalan Lokok Rangan Dalam (Kec. Kayangan)',     'latitude_center' => -8.32600000, 'longitude_center' => 116.36100000],
            ['nama_jalan' => 'Jalan Lokok Sutrang Dalam (Kec. Kayangan)',    'latitude_center' => -8.33100000, 'longitude_center' => 116.36600000],
            ['nama_jalan' => 'Gang Masjid Kayangan (Kec. Kayangan)',         'latitude_center' => -8.29700000, 'longitude_center' => 116.35400000],
            ['nama_jalan' => 'Jalan Pertanian Kayangan (Kec. Kayangan)',     'latitude_center' => -8.29500000, 'longitude_center' => 116.35800000],
            ['nama_jalan' => 'Jalan Akses Tiu Saung (Kec. Kayangan)',        'latitude_center' => -8.36300000, 'longitude_center' => 116.37200000],
            ['nama_jalan' => 'Jalan Perkebunan Santong (Kec. Kayangan)',     'latitude_center' => -8.34200000, 'longitude_center' => 116.36200000],
            ['nama_jalan' => 'Jalan Lingkar Pasar Kayangan (Kec. Kayangan)', 'latitude_center' => -8.30000000, 'longitude_center' => 116.35700000],

            // ---------------------------------------------------------------------------
            // 5. KECAMATAN BAYAN (Jalan Akses Adat & Jalur Pegunungan Rinjani)
            // ---------------------------------------------------------------------------
            ['nama_jalan' => 'Jalan Desa Bayan Utama (Kec. Bayan)',       'latitude_center' => -8.26900000, 'longitude_center' => 116.42600000],
            ['nama_jalan' => 'Jalan Desa Anyar Dalam (Kec. Bayan)',       'latitude_center' => -8.26600000, 'longitude_center' => 116.40100000],
            ['nama_jalan' => 'Jalan Akses Pos Senaru (Kec. Bayan)',       'latitude_center' => -8.30600000, 'longitude_center' => 116.40300000],
            ['nama_jalan' => 'Jalan Karang Bajo Dalam (Kec. Bayan)',      'latitude_center' => -8.27000000, 'longitude_center' => 116.42800000],
            ['nama_jalan' => 'Jalan Loloan Dalam (Kec. Bayan)',           'latitude_center' => -8.25600000, 'longitude_center' => 116.44100000],
            ['nama_jalan' => 'Jalan Sukadana Dalam (Kec. Bayan)',         'latitude_center' => -8.25100000, 'longitude_center' => 116.41100000],
            ['nama_jalan' => 'Jalan Batu Koq Dalam (Kec. Bayan)',         'latitude_center' => -8.30100000, 'longitude_center' => 116.40400000],
            ['nama_jalan' => 'Jalan Tembus Sembalun (Kec. Bayan)',        'latitude_center' => -8.31100000, 'longitude_center' => 116.48100000],
            ['nama_jalan' => 'Jalan Sambik Elen Dalam (Kec. Bayan)',      'latitude_center' => -8.24600000, 'longitude_center' => 116.47100000],
            ['nama_jalan' => 'Jalan Desa Adat Seganter (Kec. Bayan)',     'latitude_center' => -8.26100000, 'longitude_center' => 116.46600000],
            ['nama_jalan' => 'Jalan Setapak Tiu Kelep (Kec. Bayan)',      'latitude_center' => -8.31000000, 'longitude_center' => 116.40300000],
            ['nama_jalan' => 'Jalan Setapak Sendang Gile (Kec. Bayan)',   'latitude_center' => -8.30100000, 'longitude_center' => 116.40600000],
            ['nama_jalan' => 'Gang Masjid Kuno Bayan (Kec. Bayan)',       'latitude_center' => -8.26850000, 'longitude_center' => 116.42700000],
            ['nama_jalan' => 'Jalan Pertanian Bayan (Kec. Bayan)',        'latitude_center' => -8.26500000, 'longitude_center' => 116.43000000],
            ['nama_jalan' => 'Jalan Lintas Torean Utara (Kec. Bayan)',    'latitude_center' => -8.28400000, 'longitude_center' => 116.40900000],
            ['nama_jalan' => 'Jalan Lintas Torean Selatan (Kec. Bayan)',  'latitude_center' => -8.28600000, 'longitude_center' => 116.41100000],
            ['nama_jalan' => 'Jalan Hutan Adat Bayan (Kec. Bayan)',       'latitude_center' => -8.27500000, 'longitude_center' => 116.42000000],
            ['nama_jalan' => 'Jalan Batu Koq Utara (Kec. Bayan)',         'latitude_center' => -8.29900000, 'longitude_center' => 116.40200000],
            ['nama_jalan' => 'Jalan Karang Bajo Utara (Kec. Bayan)',      'latitude_center' => -8.26800000, 'longitude_center' => 116.42600000],
            ['nama_jalan' => 'Jalan Sambik Elen Timur (Kec. Bayan)',      'latitude_center' => -8.24400000, 'longitude_center' => 116.47200000],
        ];

        foreach ($jalan as $data) {
            Jalan::firstOrCreate(['nama_jalan' => $data['nama_jalan']], $data);
        }

        $this->command->info('  ✓ JalanSeeder: ' . count($jalan) . ' jalan dibuat.');
    }
}
