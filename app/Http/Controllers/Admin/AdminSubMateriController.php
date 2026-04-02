<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainMateri;
use App\Models\SubMateri;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminSubMateriController extends Controller
{
    public function materisByMain(MainMateri $mainMateri): JsonResponse
    {
        $rows = $mainMateri->materis()
            ->orderBy('title')
            ->get(['id', 'title']);

        return response()->json($rows);
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'materi_id' => ['required', 'exists:materis,id'],
            'sections' => ['required', 'array', 'min:1'],
            'sections.*.judul' => ['nullable', 'string', 'max:255'],
            'sections.*.subjudul' => ['nullable', 'string', 'max:255'],
            'sections.*.meta' => ['nullable', 'string', 'max:255'],
            'sections.*.meta_desc' => ['nullable', 'string'],
            'sections.*.artikel' => ['nullable', 'string'],
            'sections.*.thumbnail' => ['nullable', 'file', 'image', 'max:5120'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.spa')
                ->withErrors($validator)
                ->withInput()
                ->with('admin_open_page', 'addsubmateri');
        }

        $validated = $validator->validated();
        $built = [];
        $hasJudul = false;

        foreach ($validated['sections'] as $i => $row) {
            $judul = trim((string) ($row['judul'] ?? ''));
            if ($judul !== '') {
                $hasJudul = true;
            }

            $thumbPath = null;
            if ($request->hasFile("sections.$i.thumbnail")) {
                $thumbPath = $request->file("sections.$i.thumbnail")->store('sub_materi_thumbnails', 'public');
            }

            $built[] = [
                'judul' => $judul,
                'subjudul' => isset($row['subjudul']) ? trim((string) $row['subjudul']) : '',
                'meta' => isset($row['meta']) ? trim((string) $row['meta']) : '',
                'meta_desc' => isset($row['meta_desc']) ? trim((string) $row['meta_desc']) : '',
                'artikel' => isset($row['artikel']) ? (string) $row['artikel'] : '',
                'thumbnail' => $thumbPath,
            ];
        }

        if (! $hasJudul) {
            return redirect()->route('admin.spa')
                ->withErrors(['sections' => 'Minimal satu section harus punya judul.'])
                ->withInput()
                ->with('admin_open_page', 'addsubmateri');
        }

        $jsonString = json_encode($built, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        SubMateri::create([
            'materi_id' => (int) $validated['materi_id'],
            'sections' => $built,
            'sections_json' => $jsonString,
        ]);

        return redirect()
            ->route('admin.spa')
            ->with('success', 'Sub materi berhasil disimpan.')
            ->with('admin_open_page', 'addsubmateri');
    }
}
