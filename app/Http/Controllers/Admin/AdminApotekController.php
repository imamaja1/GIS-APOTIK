<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apotek;
use App\Services\ServisApotek;
use App\Services\ServisKecamatan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminApotekController extends Controller
{
    public function __construct(
        private ServisApotek $servisApotek,
        private ServisKecamatan $servisKecamatan,
    ) {}

    public function index(Request $request): View
    {
        $kecamatanId = $request->integer('kecamatan_id') ?: null;
        $search = $request->string('search')->trim()->toString() ?: null;

        $apotek = $this->servisApotek->getApotekList($kecamatanId, $search);
        $kecamatanList = $this->servisKecamatan->getAll();

        $apotek->getCollection()->transform(function ($item) {
            $item->is_open_now = $this->servisApotek->isOpenNow($item);

            return $item;
        });

        return view('admin.data-apotek.index', compact('apotek', 'kecamatanList', 'kecamatanId', 'search'));
    }

    public function detail(Apotek $apotek): JsonResponse
    {
        $apotek->load(['kecamatan', 'jamOperasional']);
        $apotek->is_open_now = $this->servisApotek->isOpenNow($apotek);

        return response()->json($apotek);
    }
}