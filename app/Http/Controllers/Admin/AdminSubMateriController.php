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
    /**
     * API: Ambil daftar materi berdasarkan main materi.
     */
    public function materisByMain(MainMateri $mainMateri): JsonResponse
    {
        $rows = $mainMateri->materis()
            ->orderBy('title')
            ->get(['id', 'title']);

        return response()->json($rows);
    }

    /**
     * Simpan sub-materi baru.
     *
     * Form mengirim metadata (title, subtitle, author, dll.)
     * dan sections[] array — tiap section punya: type, content, order,
     * dan data tambahan tergantung tipe (language, source, list_type, file).
     */
    public function store(Request $request): RedirectResponse
    {
        // ── Validasi ────────────────────────────────────────
        $validator = Validator::make($request->all(), [
            // Metadata
            'materi_id'        => ['required', 'exists:materis,id'],
            'title'            => ['required', 'string', 'max:255'],
            'subtitle'         => ['nullable', 'string', 'max:255'],
            'author'           => ['nullable', 'string', 'max:255'],
            'thumbnail'        => ['nullable', 'file', 'image', 'max:5120'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'is_published'     => ['nullable'],

            // Sections (dynamic array)
            'sections'              => ['required', 'array', 'min:1'],
            'sections.*.type'       => ['required', 'string', 'in:heading,subheading,paragraph,code,image,quote,list,divider'],
            'sections.*.content'    => ['nullable', 'string'],
            'sections.*.order'      => ['nullable', 'integer'],
            'sections.*.language'   => ['nullable', 'string', 'max:50'],
            'sections.*.source'     => ['nullable', 'string', 'max:255'],
            'sections.*.list_type'  => ['nullable', 'string', 'in:ordered,unordered'],
            'sections.*.file'       => ['nullable', 'file', 'image', 'max:5120'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.spa')
                ->withErrors($validator)
                ->withInput()
                ->with('admin_open_page', 'addsubmateri');
        }

        $validated = $validator->validated();

        // ── Upload thumbnail utama ──────────────────────────
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('sub_materi_thumbnails', 'public');
        }

        // ── Bangun array sections ───────────────────────────
        $built = [];
        $hasContent = false;

        // Urutkan sections berdasarkan order
        $sections = collect($validated['sections'])->sortBy('order')->values();

        foreach ($sections as $i => $row) {
            $type    = $row['type'];
            $content = trim((string) ($row['content'] ?? ''));

            if ($content !== '' || $type === 'divider') {
                $hasContent = true;
            }

            $section = [
                'type'    => $type,
                'content' => $content,
                'order'   => (int) ($row['order'] ?? $i),
            ];

            // Data tambahan berdasarkan tipe
            if ($type === 'code' && isset($row['language'])) {
                $section['language'] = trim($row['language']);
            }

            if ($type === 'quote' && isset($row['source'])) {
                $section['source'] = trim($row['source']);
            }

            if ($type === 'list' && isset($row['list_type'])) {
                $section['list_type'] = $row['list_type'];
            }

            // Upload gambar section
            if ($type === 'image' && $request->hasFile("sections.$i.file")) {
                $section['image_path'] = $request->file("sections.$i.file")
                    ->store('sub_materi_images', 'public');
            }

            $built[] = $section;
        }

        if (! $hasContent) {
            return redirect()->route('admin.spa')
                ->withErrors(['sections' => 'Minimal satu section harus punya konten.'])
                ->withInput()
                ->with('admin_open_page', 'addsubmateri');
        }

        // ── Simpan ke database ──────────────────────────────
        $jsonString = json_encode($built, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        SubMateri::create([
            'materi_id'        => (int) $validated['materi_id'],
            'title'            => $validated['title'],
            'subtitle'         => $validated['subtitle'] ?? null,
            'author'           => $validated['author'] ?? null,
            'thumbnail'        => $thumbnailPath,
            'meta_title'       => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'is_published'     => $request->has('is_published'),
            'sections'         => $built,
            'sections_json'    => $jsonString,
        ]);

        return redirect()
            ->route('admin.spa')
            ->with('success', 'Sub materi berhasil disimpan! 🎉')
            ->with('admin_open_page', 'addsubmateri');
    }
}
