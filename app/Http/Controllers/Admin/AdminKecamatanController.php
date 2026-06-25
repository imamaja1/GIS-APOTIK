<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminKecamatanController extends Controller
{
    public function index(Request $request): View
    {
        $kecamatan = Kecamatan::query()
            ->withCount('apotek')
            ->latest('id')
            ->paginate(10);

        return view('admin.kecamatan.index', compact('kecamatan'));
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'nama_kecamatan' => ['required', 'string', 'max:100', 'unique:tb_kecamatan,nama_kecamatan'],
        ]);

        Kecamatan::create($data);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Kecamatan berhasil ditambahkan.']);
        }

        return redirect()->route('admin.kecamatan.index')->with('success', 'Kecamatan berhasil ditambahkan.');
    }

    public function edit(Kecamatan $kecamatan): JsonResponse
    {
        return response()->json($kecamatan);
    }

    public function update(Request $request, Kecamatan $kecamatan): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'nama_kecamatan' => ['required', 'string', 'max:100', 'unique:tb_kecamatan,nama_kecamatan,' . $kecamatan->id],
        ]);

        $kecamatan->update($data);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Kecamatan berhasil diperbarui.']);
        }

        return redirect()->route('admin.kecamatan.index')->with('success', 'Kecamatan berhasil diperbarui.');
    }

    public function destroy(Request $request, Kecamatan $kecamatan): JsonResponse|RedirectResponse
    {
        if ($kecamatan->apotek()->count() > 0) {
            $message = 'Kecamatan memiliki ' . $kecamatan->apotek()->count() . ' apotek dan tidak dapat dihapus.';
            
            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 422);
            }

            return redirect()->route('admin.kecamatan.index')->with('error', $message);
        }

        $kecamatan->delete();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Kecamatan berhasil dihapus.']);
        }

        return redirect()->route('admin.kecamatan.index')->with('success', 'Kecamatan berhasil dihapus.');
    }
}
