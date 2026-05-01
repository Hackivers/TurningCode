<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainMateri;
use App\Models\SubMateri;
use App\Models\Materi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Shuchkin\SimpleXLSX;
use Shuchkin\SimpleXLSXGen;

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
            'sections.*.type'       => ['required', 'string', 'in:heading,subheading,paragraph,code,image,quote,list,divider,table,bab'],
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

        // Iterate using ORIGINAL array keys (to match form field names for file uploads)
        // then sort the final result by 'order'
        $rawSections = $request->input('sections', []);
        $sortedKeys = collect($rawSections)->sortBy('order')->keys();

        $finalOrder = 0;
        foreach ($sortedKeys as $origKey) {
            $row = $rawSections[$origKey];
            $type    = $row['type'] ?? 'paragraph';
            $content = trim((string) ($row['content'] ?? ''));

            if ($content !== '' || $type === 'divider' || $type === 'image') {
                $hasContent = true;
            }

            $section = [
                'type'    => $type,
                'content' => $content,
                'order'   => $finalOrder++,
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

            // Upload gambar section — use ORIGINAL key to find the file
            if ($type === 'image' && $request->hasFile("sections.{$origKey}.file")) {
                $section['image_path'] = $request->file("sections.{$origKey}.file")
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

    /**
     * Update full (Metadata & Sections)
     */
    public function updateFull(Request $request, SubMateri $subMateri): RedirectResponse
    {
        // ── Validasi ────────────────────────────────────────
        $validator = Validator::make($request->all(), [
            // Metadata
            'materi_id'             => ['required', 'exists:materis,id'],
            'title'                 => ['required', 'string', 'max:255'],
            'subtitle'              => ['nullable', 'string', 'max:255'],
            'author'                => ['nullable', 'string', 'max:255'],
            'thumbnail'             => ['nullable', 'file', 'image', 'max:5120'],
            'meta_title'            => ['nullable', 'string', 'max:255'],
            'meta_description'      => ['nullable', 'string'],
            'is_published'          => ['nullable'],

            // Sections (dynamic array)
            'sections'              => ['required', 'array', 'min:1'],
            'sections.*.type'       => ['required', 'string', 'in:heading,subheading,paragraph,code,image,quote,list,divider,table,bab'],
            'sections.*.content'    => ['nullable', 'string'],
            'sections.*.order'      => ['nullable', 'integer'],
            'sections.*.language'   => ['nullable', 'string', 'max:50'],
            'sections.*.source'     => ['nullable', 'string', 'max:255'],
            'sections.*.list_type'  => ['nullable', 'string', 'in:ordered,unordered'],
            'sections.*.file'       => ['nullable', 'file', 'image', 'max:5120'],
            'sections.*.image_path' => ['nullable', 'string'], // Untuk existing image
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.spa')
                ->withErrors($validator)
                ->withInput()
                // Gunakan URL untuk return ke halaman edit
                ->with('admin_open_page', 'editsubmateri?id=' . $subMateri->id);
        }

        $validated = $validator->validated();

        // ── Upload thumbnail utama ──────────────────────────
        $thumbnailPath = $subMateri->thumbnail;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('sub_materi_thumbnails', 'public');
        }

        // ── Bangun array sections ───────────────────────────
        $built = [];
        $hasContent = false;

        // Iterate using ORIGINAL array keys (to match form field names for file uploads)
        $rawSections = $request->input('sections', []);
        $sortedKeys = collect($rawSections)->sortBy('order')->keys();

        $finalOrder = 0;
        foreach ($sortedKeys as $origKey) {
            $row = $rawSections[$origKey];
            $type    = $row['type'] ?? 'paragraph';
            $content = trim((string) ($row['content'] ?? ''));

            if ($content !== '' || $type === 'divider' || $type === 'image') {
                $hasContent = true;
            }

            $section = [
                'type'    => $type,
                'content' => $content,
                'order'   => $finalOrder++,
            ];

            if ($type === 'code' && isset($row['language'])) {
                $section['language'] = trim($row['language']);
            }

            if ($type === 'quote' && isset($row['source'])) {
                $section['source'] = trim($row['source']);
            }

            if ($type === 'list' && isset($row['list_type'])) {
                $section['list_type'] = $row['list_type'];
            }

            // Upload gambar section — use ORIGINAL key to find the file
            if ($type === 'image') {
                if ($request->hasFile("sections.{$origKey}.file")) {
                    $section['image_path'] = $request->file("sections.{$origKey}.file")->store('sub_materi_images', 'public');
                } elseif (isset($row['image_path'])) {
                    $section['image_path'] = $row['image_path'];
                }
            }

            $built[] = $section;
        }

        if (! $hasContent) {
            return redirect()->route('admin.spa')
                ->withErrors(['sections' => 'Minimal satu section harus punya konten.'])
                ->withInput()
                ->with('admin_open_page', 'editsubmateri?id=' . $subMateri->id);
        }

        // ── Perbarui ke database ──────────────────────────────
        $jsonString = json_encode($built, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        $subMateri->update([
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
            ->with('success', 'Sub materi "' . $subMateri->title . '" berhasil diperbarui! 🎉')
            // Opsi: kembali ke addsubmateri atau tetap di editsubmateri
            ->with('admin_open_page', 'addsubmateri');
    }

    /**
     * Update metadata sub-materi (tanpa sections — hanya judul, subtitle, author, publish).
     */
    public function update(Request $request, SubMateri $subMateri): JsonResponse
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'subtitle'         => ['nullable', 'string', 'max:255'],
            'author'           => ['nullable', 'string', 'max:255'],
            'is_published'     => ['nullable', 'boolean'],
        ]);

        $subMateri->update([
            'title'        => $validated['title'],
            'subtitle'     => $validated['subtitle'] ?? $subMateri->subtitle,
            'author'       => $validated['author'] ?? $subMateri->author,
            'is_published' => $validated['is_published'] ?? $subMateri->is_published,
        ]);

        return response()->json(['success' => true, 'message' => 'Sub materi berhasil diperbarui.']);
    }

    /**
     * Hapus sub-materi beserta relasi (questions, quiz_attempts).
     */
    public function destroy(SubMateri $subMateri): JsonResponse
    {
        $title = $subMateri->title;
        $subMateri->delete();

        return response()->json(['success' => true, 'message' => "Sub materi \"{$title}\" berhasil dihapus."]);
    }

    // ── Sub Materi Excel Import / Template ─────────────────────────────

    public function downloadSubMateriTemplate()
    {
        $data = [
            ['Materi Induk (Judul)', 'Sub Materi (Judul)', 'Subtitle', 'Author', 'Published (Y/N)'],
            ['HTML', 'Pengenalan HTML', 'Apa itu HTML?', 'Admin', 'Y'],
            ['HTML', 'Tag & Elemen HTML', 'Struktur tag HTML', 'Admin', 'Y'],
            ['CSS', 'Pengenalan CSS', 'Dasar-dasar CSS', 'Admin', 'N'],
            ['Flutter', 'Setup Flutter', 'Instalasi dan konfigurasi', 'Admin', 'Y'],
        ];

        $xlsx = SimpleXLSXGen::fromArray($data)
            ->setColWidth(1, 30)
            ->setColWidth(2, 30)
            ->setColWidth(3, 30)
            ->setColWidth(4, 20)
            ->setColWidth(5, 15);

        $xlsx->downloadAs('Template_Import_Sub_Materi.xlsx');
        exit;
    }

    public function importSubMateriExcel(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'excel_file' => ['required', 'file', 'max:5120'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.spa')
                ->withErrors($validator)
                ->with('admin_open_page', 'addsubmateri');
        }

        $file = $request->file('excel_file');

        if ($xlsx = SimpleXLSX::parse($file->getRealPath())) {
            $rows = $xlsx->rows();
            if (count($rows) <= 1) {
                return redirect()->route('admin.spa')
                    ->withErrors(['excel_file' => 'File Excel kosong atau tidak memiliki data.'])
                    ->with('admin_open_page', 'addsubmateri');
            }

            $subCount = 0;
            $missingMateriCount = 0;

            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];

                $materiTitle = trim((string) ($row[0] ?? ''));
                $subTitle = trim((string) ($row[1] ?? ''));
                if ($materiTitle === '' || $subTitle === '') continue;

                $materi = Materi::where('title', $materiTitle)->first();
                if (!$materi) {
                    $missingMateriCount++;
                    continue;
                }

                $subSubtitle = trim((string) ($row[2] ?? ''));
                $subAuthor = trim((string) ($row[3] ?? ''));
                $publishedRaw = strtoupper(trim((string) ($row[4] ?? 'N')));
                $isPublished = in_array($publishedRaw, ['Y', 'YES', '1', 'TRUE']);

                SubMateri::create([
                    'materi_id'        => $materi->id,
                    'title'            => $subTitle,
                    'subtitle'         => $subSubtitle !== '' ? $subSubtitle : null,
                    'author'           => $subAuthor !== '' ? $subAuthor : null,
                    'is_published'     => $isPublished,
                    'sections'         => [],
                    'sections_json'    => '[]',
                ]);
                $subCount++;
            }

            $parts = [];
            if ($subCount > 0) $parts[] = "$subCount sub materi berhasil diimport 🎉";
            if ($missingMateriCount > 0) $parts[] = "$missingMateriCount dilewati (Materi induk tidak ditemukan)";

            $summary = count($parts) > 0
                ? implode(', ', $parts)
                : 'Tidak ada data baru yang diimport.';

            return redirect()->route('admin.spa')
                ->with('success', $summary)
                ->with('admin_open_page', 'addsubmateri');
        } else {
            return redirect()->route('admin.spa')
                ->withErrors(['excel_file' => 'Gagal membaca file Excel. ' . SimpleXLSX::parseError()])
                ->with('admin_open_page', 'addsubmateri');
        }
    }
}
