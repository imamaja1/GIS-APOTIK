<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApotekRequest;
use App\Http\Requests\UpdateApotekRequest;
use App\Models\Apotek;
use App\Models\Kecamatan;
use App\Services\ServisApotek;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminMasterApotekController extends Controller
{
    public function __construct(
        private ServisApotek $servisApotek,
    ) {}

    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        $apotek = $this->servisApotek->markOpenStatus(
            Apotek::query()
                ->with(['kecamatan:id,nama_kecamatan', 'jamOperasional'])
                ->when($search !== '', fn ($q) => $q->where('nama_apotek', 'like', '%' . $search . '%'))
                ->latest('id')
                ->paginate(10)
                ->withQueryString()
        );

        $kecamatanList = Kecamatan::query()->orderBy('nama_kecamatan')->get(['id', 'nama_kecamatan']);

        return view('admin.apotek.index', compact('apotek', 'search', 'kecamatanList'));
    }

    public function create(): View
    {
        $kecamatanList = Kecamatan::query()->orderBy('nama_kecamatan')->get(['id', 'nama_kecamatan']);

        return view('admin.apotek.create', compact('kecamatanList'));
    }

    public function store(StoreApotekRequest $request): JsonResponse|RedirectResponse
    {
        $data = $request->validated();

        $apotek = Apotek::create(
            collect($data)->only(['kecamatan_id', 'nama_apotek', 'jalan_apotek', 'alamat_lengkap', 'no_telp', 'latitude', 'longitude'])->toArray()
        );

        $apotek->jamOperasional()->createMany($this->formatJamOperasional($data['jam_operasional']));

        $message = 'Data apotek berhasil ditambahkan.';
        session()->flash('success', $message);

        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->route('admin.apotek.index')->with('success', $message);
    }

    public function edit(Apotek $apotek): View|JsonResponse
    {
        $apotek->load(['kecamatan:id,nama_kecamatan', 'jamOperasional']);

        if (request()->expectsJson()) {
            return response()->json($apotek);
        }

        $kecamatanList = Kecamatan::query()->orderBy('nama_kecamatan')->get(['id', 'nama_kecamatan']);

        return view('admin.apotek.edit', compact('apotek', 'kecamatanList'));
    }

    public function update(UpdateApotekRequest $request, Apotek $apotek): JsonResponse|RedirectResponse
    {
        $data = $request->validated();

        $apotek->update(
            collect($data)->only(['kecamatan_id', 'nama_apotek', 'jalan_apotek', 'alamat_lengkap', 'no_telp', 'latitude', 'longitude'])->toArray()
        );

        $apotek->jamOperasional()->delete();
        $apotek->jamOperasional()->createMany($this->formatJamOperasional($data['jam_operasional']));

        $message = 'Data apotek berhasil diperbarui.';
        session()->flash('success', $message);

        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->route('admin.apotek.index')->with('success', $message);
    }

    private function formatJamOperasional(array $jamOperasional): array
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        return array_map(fn($hari) => [
            'hari' => $hari,
            'status_buka' => $jamOperasional[$hari]['status_buka'] ?? 'Tutup',
            'jam_buka' => ($jamOperasional[$hari]['status_buka'] ?? '') === 'Buka' ? $jamOperasional[$hari]['jam_buka'] : null,
            'jam_tutup' => ($jamOperasional[$hari]['status_buka'] ?? '') === 'Buka' ? $jamOperasional[$hari]['jam_tutup'] : null,
        ], $days);
    }

    public function destroy(Request $request, Apotek $apotek): JsonResponse|RedirectResponse
    {
        $apotek->delete();

        $message = 'Data apotek berhasil dihapus.';
        session()->flash('success', $message);

        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->route('admin.apotek.index')->with('success', $message);
    }
}
