<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainMateri;
use App\Models\Materi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminMateriController extends Controller
{
    public function storeMainMateri(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.spa')
                ->withErrors($validator)
                ->withInput()
                ->with('admin_open_page', 'main-materi');
        }

        MainMateri::create($validator->validated());

        return redirect()
            ->route('admin.spa')
            ->with('success', 'Main materi berhasil disimpan.')
            ->with('admin_open_page', 'main-materi');
    }

    public function storeMateri(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'main_materi_id' => ['required', 'exists:main_materis,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.title' => ['nullable', 'string', 'max:255'],
            'items.*.description' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.spa')
                ->withErrors($validator)
                ->withInput()
                ->with('admin_open_page', 'materi');
        }

        $validated = $validator->validated();
        $count = 0;

        foreach ($validated['items'] as $row) {
            if (trim((string) ($row['title'] ?? '')) === '') {
                continue;
            }
            Materi::create([
                'main_materi_id' => (int) $validated['main_materi_id'],
                'title' => trim($row['title']),
                'description' => isset($row['description']) && $row['description'] !== '' ? $row['description'] : null,
            ]);
            $count++;
        }

        if ($count === 0) {
            return redirect()->route('admin.spa')
                ->withErrors(['items' => 'Minimal satu materi dengan judul yang diisi.'])
                ->withInput()
                ->with('admin_open_page', 'materi');
        }

        return redirect()
            ->route('admin.spa')
            ->with('success', $count.' materi berhasil disimpan.')
            ->with('admin_open_page', 'materi');
    }
}
