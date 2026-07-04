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

        $message = 'Kecamatan berhasil ditambahkan.';
        session()->flash('success', $message);

        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->route('admin.kecamatan.index')->with('success', $message);
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

        $message = 'Kecamatan berhasil diperbarui.';
        session()->flash('success', $message);

        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->route('admin.kecamatan.index')->with('success', $message);
    }

    public function destroy(Request $request, Kecamatan $kecamatan): JsonResponse|RedirectResponse
    {
        $count = $kecamatan->apotek()->count();

        if ($count > 0) {
            $message = 'Kecamatan memiliki ' . $count . ' apotek dan tidak dapat dihapus.';
            session()->flash('error', $message);

            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 422);
            }

            return redirect()->route('admin.kecamatan.index')->with('error', $message);
        }

        $kecamatan->delete();

        $message = 'Kecamatan berhasil dihapus.';
        session()->flash('success', $message);

        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->route('admin.kecamatan.index')->with('success', $message);
    }
}
