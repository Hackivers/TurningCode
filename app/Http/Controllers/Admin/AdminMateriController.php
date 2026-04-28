<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainMateri;
use App\Models\Materi;
use App\Models\SubMateri;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Shuchkin\SimpleXLSX;
use Shuchkin\SimpleXLSXGen;

class AdminMateriController extends Controller
{
    public function storeMainMateri(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:publish,coming_soon,draft'],
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

    // ── Update / Delete Main Materi ──────────────────────

    public function updateMainMateri(Request $request, MainMateri $mainMateri): JsonResponse
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:publish,coming_soon,draft'],
        ]);

        $mainMateri->update($validated);

        return response()->json(['success' => true, 'message' => 'Main materi berhasil diperbarui.']);
    }

    public function deleteMainMateri(MainMateri $mainMateri): JsonResponse
    {
        $title = $mainMateri->title;
        $mainMateri->delete();

        return response()->json(['success' => true, 'message' => "Main materi \"{$title}\" berhasil dihapus."]);
    }

    // ── Update / Delete Materi ───────────────────────────

    public function updateMateri(Request $request, Materi $materi): JsonResponse
    {
        $validated = $request->validate([
            'title'          => ['required', 'string', 'max:255'],
            'description'    => ['nullable', 'string'],
            'main_materi_id' => ['required', 'exists:main_materis,id'],
        ]);

        $materi->update($validated);

        return response()->json(['success' => true, 'message' => 'Materi berhasil diperbarui.']);
    }

    public function deleteMateri(Materi $materi): JsonResponse
    {
        $title = $materi->title;
        $materi->delete();

        return response()->json(['success' => true, 'message' => "Materi \"{$title}\" berhasil dihapus."]);
    }

    // ── Main Materi Excel Import / Template ─────────────────────────────

    public function downloadMainMateriTemplate()
    {
        $data = [
            ['Main Materi (Judul)', 'Deskripsi Main Materi'],
            ['Web Development', 'Belajar membangun website'],
            ['Mobile Development', 'Membuat aplikasi mobile'],
        ];

        $xlsx = SimpleXLSXGen::fromArray($data)
            ->setColWidth(1, 30)
            ->setColWidth(2, 40);

        $xlsx->downloadAs('Template_Import_Main_Materi.xlsx');
        exit;
    }

    public function importMainMateriExcel(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'excel_file' => ['required', 'file', 'max:5120'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.spa')
                ->withErrors($validator)
                ->with('admin_open_page', 'main-materi');
        }

        $file = $request->file('excel_file');

        if ($xlsx = SimpleXLSX::parse($file->getRealPath())) {
            $rows = $xlsx->rows();
            if (count($rows) <= 1) {
                return redirect()->route('admin.spa')
                    ->withErrors(['excel_file' => 'File Excel kosong atau tidak memiliki data.'])
                    ->with('admin_open_page', 'main-materi');
            }

            $mainCount = 0;

            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];

                $mainTitle = trim((string) ($row[0] ?? ''));
                if ($mainTitle === '') continue;

                $mainDesc = trim((string) ($row[1] ?? ''));

                $mainMateri = MainMateri::firstOrCreate(
                    ['title' => $mainTitle],
                    ['description' => $mainDesc !== '' ? $mainDesc : null]
                );
                
                if ($mainMateri->wasRecentlyCreated) {
                    $mainCount++;
                }
            }

            $summary = $mainCount > 0
                ? "$mainCount Main Materi berhasil diimport dari Excel! 🎉"
                : 'Tidak ada data baru yang diimport (semua sudah ada).';

            return redirect()->route('admin.spa')
                ->with('success', $summary)
                ->with('admin_open_page', 'main-materi');
        } else {
            return redirect()->route('admin.spa')
                ->withErrors(['excel_file' => 'Gagal membaca file Excel. ' . SimpleXLSX::parseError()])
                ->with('admin_open_page', 'main-materi');
        }
    }

    // ── Materi Excel Import / Template ─────────────────────────────

    public function downloadMateriTemplate()
    {
        $data = [
            ['Main Materi Induk (Judul)', 'Materi (Judul)', 'Deskripsi Materi'],
            ['Web Development', 'HTML', 'Dasar-dasar HTML'],
            ['Web Development', 'CSS', 'Styling halaman web'],
            ['Mobile Development', 'Flutter', 'Framework UI dari Google'],
        ];

        $xlsx = SimpleXLSXGen::fromArray($data)
            ->setColWidth(1, 30)
            ->setColWidth(2, 30)
            ->setColWidth(3, 40);

        $xlsx->downloadAs('Template_Import_Materi.xlsx');
        exit;
    }

    public function importMateriExcel(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'excel_file' => ['required', 'file', 'max:5120'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.spa')
                ->withErrors($validator)
                ->with('admin_open_page', 'materi');
        }

        $file = $request->file('excel_file');

        if ($xlsx = SimpleXLSX::parse($file->getRealPath())) {
            $rows = $xlsx->rows();
            if (count($rows) <= 1) {
                return redirect()->route('admin.spa')
                    ->withErrors(['excel_file' => 'File Excel kosong atau tidak memiliki data.'])
                    ->with('admin_open_page', 'materi');
            }

            $materiCount = 0;
            $missingMainCount = 0;

            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];

                $mainTitle = trim((string) ($row[0] ?? ''));
                $materiTitle = trim((string) ($row[1] ?? ''));
                if ($mainTitle === '' || $materiTitle === '') continue;

                $materiDesc = trim((string) ($row[2] ?? ''));

                $mainMateri = MainMateri::where('title', $mainTitle)->first();
                if (!$mainMateri) {
                    $missingMainCount++;
                    continue;
                }

                $materi = Materi::firstOrCreate(
                    ['title' => $materiTitle, 'main_materi_id' => $mainMateri->id],
                    ['description' => $materiDesc !== '' ? $materiDesc : null]
                );
                
                if ($materi->wasRecentlyCreated) {
                    $materiCount++;
                }
            }

            $parts = [];
            if ($materiCount > 0) $parts[] = "$materiCount materi berhasil diimport 🎉";
            if ($missingMainCount > 0) $parts[] = "$missingMainCount dilewati (Main Materi induk tidak ditemukan)";

            $summary = count($parts) > 0
                ? implode(', ', $parts)
                : 'Tidak ada data baru yang diimport (semua sudah ada).';

            return redirect()->route('admin.spa')
                ->with('success', $summary)
                ->with('admin_open_page', 'materi');
        } else {
            return redirect()->route('admin.spa')
                ->withErrors(['excel_file' => 'Gagal membaca file Excel. ' . SimpleXLSX::parseError()])
                ->with('admin_open_page', 'materi');
        }
    }
}
