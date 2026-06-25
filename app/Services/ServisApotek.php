<?php

namespace App\Services;

use App\Models\Apotek;
use App\Models\Jalan;
use App\Models\Kecamatan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ServisApotek
{
    /**
     * Mendapatkan nama hari ini dalam Bahasa Indonesia.
     */
    private function hariIni(): string
    {
        $days = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];

        return $days[date('l')] ?? date('l');
    }

    /**
     * Cek apakah apotek sedang buka berdasarkan jam sekarang.
     * Relasi jamOperasional harus sudah di-eager load.
     */
    public function isOpenNow(Apotek $apotek): bool
    {
        $hari  = $this->hariIni();
        $waktu = now()->format('H:i:s');

        $jadwal = $apotek->jamOperasional->firstWhere('hari', $hari);

        if (! $jadwal || $jadwal->status_buka !== 'Buka') {
            return false;
        }

        if (! $jadwal->jam_buka || ! $jadwal->jam_tutup) {
            return false;
        }

        return $waktu >= $jadwal->jam_buka && $waktu <= $jadwal->jam_tutup;
    }

    /**
     * Statistik untuk halaman dashboard.
     */
    public function getDashboardStats(): array
    {
        $hari  = $this->hariIni();
        $waktu = now()->format('H:i:s');

        $totalKecamatan = Kecamatan::count();
        $totalApotek    = Apotek::count();

        $apotekBuka = Apotek::whereHas('jamOperasional', function ($q) use ($hari, $waktu) {
            $q->where('hari', $hari)
              ->where('status_buka', 'Buka')
              ->where('jam_buka', '<=', $waktu)
              ->where('jam_tutup', '>=', $waktu);
        })->count();

        return [
            'total_kecamatan' => $totalKecamatan,
            'total_apotek'    => $totalApotek,
            'apotek_buka'     => $apotekBuka,
            'apotek_tutup'    => $totalApotek - $apotekBuka,
        ];
    }

    /**
     * Semua apotek untuk ditampilkan di peta (kolom minimal).
     */
    public function getAllForMap(): Collection
    {
        return Apotek::with('kecamatan:id,nama_kecamatan')
            ->select('id', 'kecamatan_id', 'nama_apotek', 'alamat_lengkap', 'no_telp', 'latitude', 'longitude')
            ->get();
    }

    /**
     * Daftar apotek dengan filter kecamatan dan pagination.
     */
    public function getApotekList(?int $kecamatanId = null, ?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return Apotek::with(['kecamatan:id,nama_kecamatan', 'jamOperasional'])
            ->when($kecamatanId, fn ($q) => $q->where('kecamatan_id', $kecamatanId))
            ->when($search, fn ($q) => $q->where('nama_apotek', 'like', '%' . $search . '%'))
            ->orderBy('nama_apotek')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Detail satu apotek beserta relasi kecamatan dan jam operasional.
     */
    public function getById(int $id): ?Apotek
    {
        return Apotek::with(['kecamatan:id,nama_kecamatan', 'jamOperasional'])
            ->find($id);
    }

    /**
     * Pencarian apotek berdasarkan nama (untuk Select2 AJAX).
     */
    public function searchApotek(string $query): Collection
    {
        return Apotek::with('kecamatan:id,nama_kecamatan')
            ->where('nama_apotek', 'like', '%' . $query . '%')
            ->select('id', 'kecamatan_id', 'nama_apotek', 'latitude', 'longitude')
            ->limit(20)
            ->get();
    }

    /**
     * Semua data jalan untuk dropdown titik awal di halaman search.
     */
    public function getAllJalan(): Collection
    {
        return Jalan::orderBy('nama_jalan')
            ->get(['id', 'nama_jalan', 'latitude_center', 'longitude_center']);
    }
}
