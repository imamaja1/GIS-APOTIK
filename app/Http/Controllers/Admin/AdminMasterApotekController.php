<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apotek;
use App\Models\Kecamatan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminMasterApotekController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        $apotek = Apotek::query()
            ->with('kecamatan:id,nama_kecamatan')
            ->when($search !== '', fn ($q) => $q->where('nama_apotek', 'like', '%' . $search . '%'))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        $kecamatanList = Kecamatan::query()->orderBy('nama_kecamatan')->get(['id', 'nama_kecamatan']);

        return view('admin.apotek.index', compact('apotek', 'search', 'kecamatanList'));
    }

    public function create(): View
    {
        $kecamatanList = Kecamatan::query()->orderBy('nama_kecamatan')->get(['id', 'nama_kecamatan']);

        return view('admin.apotek.create', compact('kecamatanList'));
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'kecamatan_id' => ['required', 'exists:tb_kecamatan,id'],
            'nama_apotek' => ['required', 'string', 'max:150'],
            'jalan_apotek' => ['required', 'string', 'max:150'],
            'alamat_lengkap' => ['required', 'string'],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'jam_operasional' => ['required', 'array', 'size:7'],
            'jam_operasional.*.status_buka' => ['required', 'in:Buka,Tutup'],
            'jam_operasional.*.jam_buka' => ['nullable', 'required_if:jam_operasional.*.status_buka,Buka', 'date_format:H:i'],
            'jam_operasional.*.jam_tutup' => ['nullable', 'required_if:jam_operasional.*.status_buka,Buka', 'date_format:H:i'],
        ]);

        $apotek = Apotek::create(
            collect($data)->only(['kecamatan_id', 'nama_apotek', 'jalan_apotek', 'alamat_lengkap', 'no_telp', 'latitude', 'longitude'])->toArray()
        );

        $apotek->jamOperasional()->createMany($this->formatJamOperasional($data['jam_operasional']));

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Data apotek berhasil ditambahkan.']);
        }

        return redirect()->route('admin.apotek.index')->with('success', 'Data apotik berhasil ditambahkan.');
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

    public function update(Request $request, Apotek $apotek): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'kecamatan_id' => ['required', 'exists:tb_kecamatan,id'],
            'nama_apotek' => ['required', 'string', 'max:150'],
            'jalan_apotek' => ['required', 'string', 'max:150'],
            'alamat_lengkap' => ['required', 'string'],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'jam_operasional' => ['required', 'array', 'size:7'],
            'jam_operasional.*.status_buka' => ['required', 'in:Buka,Tutup'],
            'jam_operasional.*.jam_buka' => ['nullable', 'required_if:jam_operasional.*.status_buka,Buka', 'date_format:H:i'],
            'jam_operasional.*.jam_tutup' => ['nullable', 'required_if:jam_operasional.*.status_buka,Buka', 'date_format:H:i'],
        ]);

        $apotek->update(
            collect($data)->only(['kecamatan_id', 'nama_apotek', 'jalan_apotek', 'alamat_lengkap', 'no_telp', 'latitude', 'longitude'])->toArray()
        );

        $apotek->jamOperasional()->delete();
        $apotek->jamOperasional()->createMany($this->formatJamOperasional($data['jam_operasional']));

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Data apotek berhasil diperbarui.']);
        }

        return redirect()->route('admin.apotek.index')->with('success', 'Data apotik berhasil diperbarui.');
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

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Data apotek berhasil dihapus.']);
        }

        return redirect()->route('admin.apotek.index')->with('success', 'Data apotik berhasil dihapus.');
    }
}
