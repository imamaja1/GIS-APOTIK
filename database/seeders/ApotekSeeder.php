<?php

namespace Database\Seeders;

use App\Models\Apotek;
use App\Models\JamOperasional;
use App\Models\Kecamatan;
use Illuminate\Database\Seeder;

class ApotekSeeder extends Seeder
{
    // Hari-hari dalam seminggu sesuai format di tb_jam_operasional
    private array $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

    public function run(): void
    {
        $kecamatan = Kecamatan::pluck('id', 'nama_kecamatan');

        $apotek = [

            // ── Tanjung (Ibukota KLU) ─────────────────────────────────────────
            [
                'kecamatan'     => 'Tanjung',
                'nama_apotek'   => 'Apotek Tanjung Sehat',
                'jalan_apotek'  => 'Jl. Ahmad Yani No. 12',
                'alamat_lengkap'=> 'Jl. Ahmad Yani No. 12, Tanjung, Lombok Utara',
                'no_telp'       => '0370-612001',
                'latitude'      => -8.35600,
                'longitude'     => 116.15500,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00', ['Minggu']),
            ],
            [
                'kecamatan'     => 'Tanjung',
                'nama_apotek'   => 'Apotek Farma Mulia',
                'jalan_apotek'  => 'Jl. Pahlawan No. 5',
                'alamat_lengkap'=> 'Jl. Pahlawan No. 5, Tanjung, Lombok Utara',
                'no_telp'       => '0370-612045',
                'latitude'      => -8.35800,
                'longitude'     => 116.15700,
                'jadwal'        => $this->jadwalHarian('07:30:00', '22:00:00'),
            ],
            [
                'kecamatan'     => 'Tanjung',
                'nama_apotek'   => 'Apotek Medikal Utama',
                'jalan_apotek'  => 'Jl. Raya Tanjung No. 88',
                'alamat_lengkap'=> 'Jl. Raya Tanjung No. 88, Tanjung, Lombok Utara',
                'no_telp'       => '0370-613000',
                'latitude'      => -8.35900,
                'longitude'     => 116.15300,
                'jadwal'        => $this->jadwalHarian('08:00:00', '20:00:00', ['Minggu']),
            ],

            // ── Pemenang ──────────────────────────────────────────────────────
            [
                'kecamatan'     => 'Pemenang',
                'nama_apotek'   => 'Apotek Gili Sehat',
                'jalan_apotek'  => 'Jl. Raya Pemenang No. 3',
                'alamat_lengkap'=> 'Jl. Raya Pemenang No. 3, Pemenang, Lombok Utara',
                'no_telp'       => '0370-692001',
                'latitude'      => -8.40500,
                'longitude'     => 116.09300,
                'jadwal'        => $this->jadwalHarian('08:00:00', '20:00:00'),
            ],
            [
                'kecamatan'     => 'Pemenang',
                'nama_apotek'   => 'Apotek Pantai Indah',
                'jalan_apotek'  => 'Jl. Pantai Pemenang No. 17',
                'alamat_lengkap'=> 'Jl. Pantai Pemenang No. 17, Pemenang, Lombok Utara',
                'no_telp'       => '0370-692100',
                'latitude'      => -8.40200,
                'longitude'     => 116.09600,
                'jadwal'        => $this->jadwalHarian('09:00:00', '21:00:00', ['Minggu']),
            ],
            [
                'kecamatan'     => 'Pemenang',
                'nama_apotek'   => 'Apotek Lombok Barat',
                'jalan_apotek'  => 'Jl. Senggigi KM 5',
                'alamat_lengkap'=> 'Jl. Senggigi KM 5, Pemenang, Lombok Utara',
                'no_telp'       => null,
                'latitude'      => -8.40800,
                'longitude'     => 116.09000,
                'jadwal'        => $this->jadwalHarian('08:30:00', '20:30:00', ['Minggu']),
            ],

            // ── Gangga ────────────────────────────────────────────────────────
            [
                'kecamatan'     => 'Gangga',
                'nama_apotek'   => 'Apotek Gangga Maju',
                'jalan_apotek'  => 'Jl. Raya Gangga No. 10',
                'alamat_lengkap'=> 'Jl. Raya Gangga No. 10, Gangga, Lombok Utara',
                'no_telp'       => '0370-621500',
                'latitude'      => -8.34200,
                'longitude'     => 116.26500,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Gangga',
                'nama_apotek'   => 'Apotek Sumber Waras',
                'jalan_apotek'  => 'Jl. Pemuda No. 22',
                'alamat_lengkap'=> 'Jl. Pemuda No. 22, Gangga, Lombok Utara',
                'no_telp'       => '0370-621600',
                'latitude'      => -8.34300,
                'longitude'     => 116.26800,
                'jadwal'        => $this->jadwalHarian('07:00:00', '21:30:00', ['Minggu']),
            ],
            [
                'kecamatan'     => 'Gangga',
                'nama_apotek'   => 'Apotek Kesehatan Bersama',
                'jalan_apotek'  => 'Jl. Raya Gangga - Kayangan No. 5',
                'alamat_lengkap'=> 'Jl. Raya Gangga - Kayangan No. 5, Gangga, Lombok Utara',
                'no_telp'       => null,
                'latitude'      => -8.34600,
                'longitude'     => 116.27200,
                'jadwal'        => $this->jadwalHarian('08:00:00', '20:00:00', ['Sabtu', 'Minggu']),
            ],

            // ── Kayangan ──────────────────────────────────────────────────────
            [
                'kecamatan'     => 'Kayangan',
                'nama_apotek'   => 'Apotek Kayangan Sehat',
                'jalan_apotek'  => 'Jl. Raya Kayangan No. 14',
                'alamat_lengkap'=> 'Jl. Raya Kayangan No. 14, Kayangan, Lombok Utara',
                'no_telp'       => '0370-631200',
                'latitude'      => -8.29900,
                'longitude'     => 116.35600,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Kayangan',
                'nama_apotek'   => 'Apotek Rinjani Farma',
                'jalan_apotek'  => 'Jl. Menuju Rinjani No. 2',
                'alamat_lengkap'=> 'Jl. Menuju Rinjani No. 2, Kayangan, Lombok Utara',
                'no_telp'       => '0370-631300',
                'latitude'      => -8.30100,
                'longitude'     => 116.35800,
                'jadwal'        => $this->jadwalHarian('08:00:00', '20:00:00', ['Minggu']),
            ],
            [
                'kecamatan'     => 'Kayangan',
                'nama_apotek'   => 'Apotek Panca Bhakti',
                'jalan_apotek'  => 'Jl. Pasar Kayangan',
                'alamat_lengkap'=> 'Jl. Pasar Kayangan, Kayangan, Lombok Utara',
                'no_telp'       => null,
                'latitude'      => -8.29700,
                'longitude'     => 116.35400,
                'jadwal'        => $this->jadwalHarian('09:00:00', '20:30:00', ['Sabtu', 'Minggu']),
            ],

            // ── Bayan ─────────────────────────────────────────────────────────
            [
                'kecamatan'     => 'Bayan',
                'nama_apotek'   => 'Apotek Bayan Husada',
                'jalan_apotek'  => 'Jl. Raya Bayan No. 7',
                'alamat_lengkap'=> 'Jl. Raya Bayan No. 7, Bayan, Lombok Utara',
                'no_telp'       => '0370-641100',
                'latitude'      => -8.26800,
                'longitude'     => 116.42500,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Bayan',
                'nama_apotek'   => 'Apotek Senaru Farma',
                'jalan_apotek'  => 'Jl. Raya Senaru No. 1',
                'alamat_lengkap'=> 'Jl. Raya Senaru No. 1, Bayan, Lombok Utara',
                'no_telp'       => '0370-641200',
                'latitude'      => -8.30500,
                'longitude'     => 116.40200,
                'jadwal'        => $this->jadwalHarian('08:00:00', '20:00:00', ['Minggu']),
            ],
            [
                'kecamatan'     => 'Bayan',
                'nama_apotek'   => 'Apotek Timur Rinjani',
                'jalan_apotek'  => 'Jl. Raya Anyar No. 20',
                'alamat_lengkap'=> 'Jl. Raya Anyar No. 20, Bayan, Lombok Utara',
                'no_telp'       => null,
                'latitude'      => -8.26500,
                'longitude'     => 116.40000,
                'jadwal'        => $this->jadwalHarian('08:30:00', '21:00:00', ['Sabtu', 'Minggu']),
            ],

            // ==========================================
            // KECAMATAN BAYAN (ID: 5)
            // ==========================================
            [
                'kecamatan'     => 'Bayan',
                'nama_apotek'   => 'Apotek Rinjani',
                'jalan_apotek'  => 'Jalan Pariwisata Senaru',
                'alamat_lengkap'=> 'Senaru, Kec. Bayan, Kabupaten Lombok Utara',
                'no_telp'       => '081200000001',
                'latitude'      => -8.30500000,
                'longitude'     => 116.40200000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Bayan',
                'nama_apotek'   => 'Apotek Bayan',
                'jalan_apotek'  => 'Jalan Raya Bayan',
                'alamat_lengkap'=> 'Bayan, Kec. Bayan, Kabupaten Lombok Utara',
                'no_telp'       => '081200000002',
                'latitude'      => -8.26800000,
                'longitude'     => 116.42500000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Bayan',
                'nama_apotek'   => 'Apotek Galang',
                'jalan_apotek'  => 'Jalan Raya Karang Bajo',
                'alamat_lengkap'=> 'Bayan, Kec. Bayan, Kabupaten Lombok Utara',
                'no_telp'       => '081200000003',
                'latitude'      => -8.26900000,
                'longitude'     => 116.42700000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Bayan',
                'nama_apotek'   => 'Apotek Pranatha',
                'jalan_apotek'  => 'Jalan Raya Anyar',
                'alamat_lengkap'=> 'Bayan, Kec. Bayan, Kabupaten Lombok Utara',
                'no_telp'       => '081200000004',
                'latitude'      => -8.26500000,
                'longitude'     => 116.40000000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Bayan',
                'nama_apotek'   => 'Apotek Syiba',
                'jalan_apotek'  => 'Jalan Raya Loloan',
                'alamat_lengkap'=> 'Bayan, Kec. Bayan, Kabupaten Lombok Utara',
                'no_telp'       => '081200000005',
                'latitude'      => -8.25500000,
                'longitude'     => 116.44000000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],

            // ==========================================
            // KECAMATAN KAYANGAN (ID: 4)
            // ==========================================
            [
                'kecamatan'     => 'Kayangan',
                'nama_apotek'   => 'Apotek Kayangan',
                'jalan_apotek'  => 'Jalan Raya Kayangan',
                'alamat_lengkap'=> 'Kayangan, Kec. Kayangan, Kabupaten Lombok Utara',
                'no_telp'       => '081200000006',
                'latitude'      => -8.29800000,
                'longitude'     => 116.35500000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Kayangan',
                'nama_apotek'   => 'Apotek Sinta 2',
                'jalan_apotek'  => 'Jalan Raya Santong',
                'alamat_lengkap'=> 'Santong, Kec. Kayangan, Kabupaten Lombok Utara',
                'no_telp'       => '081200000007',
                'latitude'      => -8.34000000,
                'longitude'     => 116.36000000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Kayangan',
                'nama_apotek'   => 'Apotek Sahabat',
                'jalan_apotek'  => 'Jalan Lintas Santong - Pansor',
                'alamat_lengkap'=> 'Santong, Kec. Kayangan, Kabupaten Lombok Utara',
                'no_telp'       => '081200000008',
                'latitude'      => -8.33000000,
                'longitude'     => 116.35800000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],

            // ==========================================
            // KECAMATAN GANGGA (ID: 3)
            // ==========================================
            [
                'kecamatan'     => 'Gangga',
                'nama_apotek'   => 'Apotek Hamzanwadi',
                'jalan_apotek'  => 'Jalan Raya Gondang',
                'alamat_lengkap'=> 'Gondang, Kec. Gangga, Kabupaten Lombok Utara',
                'no_telp'       => '081200000009',
                'latitude'      => -8.34300000,
                'longitude'     => 116.26700000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Gangga',
                'nama_apotek'   => 'Apotek Zifa 2',
                'jalan_apotek'  => 'Jalan Lapangan Gondang',
                'alamat_lengkap'=> 'Gondang, Kec. Gangga, Kabupaten Lombok Utara',
                'no_telp'       => '081200000010',
                'latitude'      => -8.34450000,
                'longitude'     => 116.26600000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Gangga',
                'nama_apotek'   => 'Apotek Gondang',
                'jalan_apotek'  => 'Jalan Raya Gangga',
                'alamat_lengkap'=> 'Gondang, Kec. Gangga, Kabupaten Lombok Utara',
                'no_telp'       => '081200000011',
                'latitude'      => -8.34400000,
                'longitude'     => 116.26500000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],

            // ==========================================
            // KECAMATAN TANJUNG (ID: 2)
            // ==========================================
            [
                'kecamatan'     => 'Tanjung',
                'nama_apotek'   => 'Apotek Rania',
                'jalan_apotek'  => 'Jalan Raya Tanjung',
                'alamat_lengkap'=> 'Tanjung, Kec. Tanjung, Kabupaten Lombok Utara',
                'no_telp'       => '081200000012',
                'latitude'      => -8.35500000,
                'longitude'     => 116.15500000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Tanjung',
                'nama_apotek'   => 'Apotek Paramadina',
                'jalan_apotek'  => 'Jalan Raya Sokong',
                'alamat_lengkap'=> 'Tanjung, Kec. Tanjung, Kabupaten Lombok Utara',
                'no_telp'       => '081200000013',
                'latitude'      => -8.36000000,
                'longitude'     => 116.14500000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Tanjung',
                'nama_apotek'   => 'Apotek Husada',
                'jalan_apotek'  => 'Jalan TGH Muhsin',
                'alamat_lengkap'=> 'Tanjung, Kec. Tanjung, Kabupaten Lombok Utara',
                'no_telp'       => '081200000014',
                'latitude'      => -8.34200000,
                'longitude'     => 116.24000000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Tanjung',
                'nama_apotek'   => 'Apotek Rama',
                'jalan_apotek'  => 'Jalan Lapangan Supersemar',
                'alamat_lengkap'=> 'Tanjung, Kec. Tanjung, Kabupaten Lombok Utara',
                'no_telp'       => '081200000015',
                'latitude'      => -8.35400000,
                'longitude'     => 116.15200000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Tanjung',
                'nama_apotek'   => 'Apotek RJ',
                'jalan_apotek'  => 'Jalan Karang Pendem',
                'alamat_lengkap'=> 'Tanjung, Kec. Tanjung, Kabupaten Lombok Utara',
                'no_telp'       => '081200000016',
                'latitude'      => -8.34800000,
                'longitude'     => 116.15000000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Tanjung',
                'nama_apotek'   => 'Apotek Medana',
                'jalan_apotek'  => 'Jalan Raya Medana',
                'alamat_lengkap'=> 'Medana, Tanjung, Kabupaten Lombok Utara',
                'no_telp'       => '081200000017',
                'latitude'      => -8.35000000,
                'longitude'     => 116.13000000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Tanjung',
                'nama_apotek'   => 'Apotek Denta',
                'jalan_apotek'  => 'Jalan Raya Teniga',
                'alamat_lengkap'=> 'Tanjung, Kec. Tanjung, Kabupaten Lombok Utara (TUTUP)',
                'no_telp'       => '081200000018',
                'latitude'      => -8.37500000,
                'longitude'     => 116.16000000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],

            // ==========================================
            // KECAMATAN PEMENANG (ID: 1)
            // ==========================================
            [
                'kecamatan'     => 'Pemenang',
                'nama_apotek'   => 'Apotek Waringin',
                'jalan_apotek'  => 'Jalan Raya Pemenang',
                'alamat_lengkap'=> 'Pemenang, Kec. Pemenang, Kabupaten Lombok Utara',
                'no_telp'       => '081200000019',
                'latitude'      => -8.40200000,
                'longitude'     => 116.09500000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Pemenang',
                'nama_apotek'   => 'Apotek Zifa 1',
                'jalan_apotek'  => 'Jalan Pemenang Barat',
                'alamat_lengkap'=> 'Pemenang, Kec. Pemenang, Kabupaten Lombok Utara',
                'no_telp'       => '081200000020',
                'latitude'      => -8.40500000,
                'longitude'     => 116.09200000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Pemenang',
                'nama_apotek'   => 'Apotek Sinta 1',
                'jalan_apotek'  => 'Jalan Pemenang Timur',
                'alamat_lengkap'=> 'Pemenang, Kec. Pemenang, Kabupaten Lombok Utara',
                'no_telp'       => '081200000021',
                'latitude'      => -8.40000000,
                'longitude'     => 116.09900000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Pemenang',
                'nama_apotek'   => 'Apotek 65',
                'jalan_apotek'  => 'Jalan Raya Bangsal',
                'alamat_lengkap'=> 'Pemenang, Kec. Pemenang, Kabupaten Lombok Utara',
                'no_telp'       => '081200000022',
                'latitude'      => -8.36500000,
                'longitude'     => 116.09800000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Pemenang',
                'nama_apotek'   => 'Apotek Faya',
                'jalan_apotek'  => 'Jalan Muara Putih',
                'alamat_lengkap'=> 'Pemenang, Kec. Pemenang, Kabupaten Lombok Utara',
                'no_telp'       => '081200000023',
                'latitude'      => -8.38000000,
                'longitude'     => 116.09500000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Pemenang',
                'nama_apotek'   => 'Apotek Pemenang',
                'jalan_apotek'  => 'Jalan Karang Pangsor',
                'alamat_lengkap'=> 'Pemenang, Kec. Pemenang, Kabupaten Lombok Utara',
                'no_telp'       => '081200000024',
                'latitude'      => -8.39000000,
                'longitude'     => 116.09000000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Pemenang',
                'nama_apotek'   => 'Apotek Dara',
                'jalan_apotek'  => 'Jalan Desa Menggala',
                'alamat_lengkap'=> 'Pemenang, Kec. Pemenang, Kabupaten Lombok Utara',
                'no_telp'       => '081200000025',
                'latitude'      => -8.41000000,
                'longitude'     => 116.10500000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
            [
                'kecamatan'     => 'Pemenang',
                'nama_apotek'   => 'Apotek Dina',
                'jalan_apotek'  => 'Jalan Raya Pusuk Pemenang',
                'alamat_lengkap'=> 'Pemenang, Kec. Pemenang, Kabupaten Lombok Utara (TUTUP)',
                'no_telp'       => '081200000026',
                'latitude'      => -8.42010000,
                'longitude'     => 116.10100000,
                'jadwal'        => $this->jadwalHarian('08:00:00', '21:00:00'),
            ],
        ];

        $totalApotek  = 0;
        $totalJadwal  = 0;

        foreach ($apotek as $data) {
            $kecId = $kecamatan[$data['kecamatan']] ?? null;

            if (! $kecId) {
                $this->command->warn("  ⚠ Kecamatan '{$data['kecamatan']}' tidak ditemukan, lewati.");
                continue;
            }

            $a = Apotek::firstOrCreate(
                ['nama_apotek' => $data['nama_apotek']],
                [
                    'kecamatan_id'   => $kecId,
                    'jalan_apotek'   => $data['jalan_apotek'],
                    'alamat_lengkap' => $data['alamat_lengkap'],
                    'no_telp'        => $data['no_telp'],
                    'latitude'       => $data['latitude'],
                    'longitude'      => $data['longitude'],
                ]
            );

            // Seed jam operasional jika belum ada
            if ($a->jamOperasional()->count() === 0) {
                foreach ($data['jadwal'] as $jadwal) {
                    JamOperasional::create([
                        'apotek_id'   => $a->id,
                        'hari'        => $jadwal['hari'],
                        'status_buka' => $jadwal['status_buka'],
                        'jam_buka'    => $jadwal['jam_buka'],
                        'jam_tutup'   => $jadwal['jam_tutup'],
                    ]);
                    $totalJadwal++;
                }
            }

            $totalApotek++;
        }

        $this->command->info("  ✓ ApotekSeeder: {$totalApotek} apotek + {$totalJadwal} jadwal operasional dibuat.");
    }

    /**
     * Buat array jadwal 7 hari.
     *
     * @param  string   $buka    Format "HH:MM:SS"
     * @param  string   $tutup   Format "HH:MM:SS"
     * @param  string[] $liburHari  Hari-hari yang ditandai Tutup
     */
    private function jadwalHarian(string $buka, string $tutup, array $liburHari = []): array
    {
        $jadwal = [];

        foreach ($this->hariList as $hari) {
            $libur = in_array($hari, $liburHari);

            $jadwal[] = [
                'hari'        => $hari,
                'status_buka' => $libur ? 'Tutup' : 'Buka',
                'jam_buka'    => $libur ? null : $buka,
                'jam_tutup'   => $libur ? null : $tutup,
            ];
        }

        return $jadwal;
    }
}
