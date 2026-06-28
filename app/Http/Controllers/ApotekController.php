<?php

namespace App\Http\Controllers;

use App\Services\ServisApotek;
use App\Services\ServisKecamatan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApotekController extends Controller
{
    public function __construct(
        private ServisApotek $servisApotek,
        private ServisKecamatan $servisKecamatan,
    ) {}

    /**
     * Halaman daftar apotek dengan filter kecamatan.
     */
    public function index(Request $request): View
    {
        $kecamatanId   = $request->integer('kecamatan_id') ?: null;
        $search        = $request->string('search')->trim()->toString() ?: null;
        $apotek        = $this->servisApotek->markOpenStatus(
            $this->servisApotek->getApotekList($kecamatanId, $search)
        );
        $kecamatanList = $this->servisKecamatan->getAll();

        return view('user.apotek.index', compact('apotek', 'kecamatanList', 'kecamatanId', 'search'));
    }

    /**
     * Halaman search apotek dengan peta.
     */
    public function search(): View
    {
        $jalanList = $this->servisApotek->getAllJalan();

        return view('user.apotek.search', compact('jalanList'));
    }

    /**
     * Endpoint AJAX untuk Select2 — cari apotek berdasarkan nama.
     */
    public function searchJson(Request $request): JsonResponse
    {
        $query   = $request->string('q')->toString();
        $results = $this->servisApotek->searchApotek($query);

        return response()->json([
            'results' => $results->map(fn ($a) => [
                'id'   => $a->id,
                'text' => $a->nama_apotek . ' — ' . ($a->kecamatan->nama_kecamatan ?? ''),
                'lat'  => $a->latitude,
                'lng'  => $a->longitude,
            ]),
        ]);
    }

    /**
     * Endpoint AJAX untuk detail apotek (modal & peta).
     */
    public function detail(int $id): JsonResponse
    {
        $apotek = $this->servisApotek->getById($id);

        if (! $apotek) {
            return response()->json(['error' => 'Apotek tidak ditemukan.'], 404);
        }

        return response()->json([
            'id'              => $apotek->id,
            'nama_apotek'     => $apotek->nama_apotek,
            'kecamatan'       => $apotek->kecamatan->nama_kecamatan ?? '-',
            'jalan_apotek'    => $apotek->jalan_apotek,
            'alamat_lengkap'  => $apotek->alamat_lengkap,
            'no_telp'         => $apotek->no_telp ?? '-',
            'latitude'        => $apotek->latitude,
            'longitude'       => $apotek->longitude,
            'is_open'         => $this->servisApotek->isOpenNow($apotek),
            'jam_operasional' => $apotek->jamOperasional->map(fn ($j) => [
                'hari'        => $j->hari,
                'status_buka' => $j->status_buka,
                'jam_buka'    => $j->jam_buka  ? substr($j->jam_buka, 0, 5)  : null,
                'jam_tutup'   => $j->jam_tutup ? substr($j->jam_tutup, 0, 5) : null,
            ]),
        ]);
    }
}
