<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Question;
use App\Models\SubMateri;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Shuchkin\SimpleXLSX;
use Shuchkin\SimpleXLSXGen;

class AdminQuestionController extends Controller
{
    /**
     * API: Ambil daftar sub-materi berdasarkan materi.
     */
    public function subMaterisByMateri(Materi $materi): JsonResponse
    {
        $rows = $materi->subMateris()
            ->where('is_published', true)
            ->orderBy('title')
            ->get(['id', 'title']);

        return response()->json($rows);
    }

    /**
     * Simpan question baru (bisa batch/multiple).
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'sub_materi_id'              => ['required', 'exists:sub_materis,id'],
            'sync_mode'                  => ['nullable', 'string'],
            'questions'                  => ['required', 'array', 'min:1'],
            'questions.*.id'             => ['nullable', 'integer'],
            'questions.*.question'       => ['required', 'string', 'max:2000'],
            'questions.*.code_snippet'   => ['nullable', 'string', 'max:5000'],
            'questions.*.code_language'  => ['nullable', 'string', 'max:50'],
            'questions.*.option_a'       => ['required', 'string', 'max:500'],
            'questions.*.option_b'       => ['required', 'string', 'max:500'],
            'questions.*.option_c'       => ['required', 'string', 'max:500'],
            'questions.*.option_d'       => ['required', 'string', 'max:500'],
            'questions.*.correct_option' => ['required', 'integer', 'min:0', 'max:3'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.spa')
                ->withErrors($validator)
                ->withInput()
                ->with('admin_open_page', 'questions');
        }

        $validated = $validator->validated();
        $subMateriId = (int) $validated['sub_materi_id'];
        $isSyncMode = !empty($validated['sync_mode']);

        if ($isSyncMode) {
            $submittedIds = collect($validated['questions'])
                                ->filter(fn($q) => !empty($q['id']))
                                ->pluck('id')
                                ->toArray();
                                
            Question::where('sub_materi_id', $subMateriId)
                ->whereNotIn('id', $submittedIds)
                ->delete();
                
            $currentMax = -1; // Reset order in sync mode
        } else {
            $currentMax = Question::where('sub_materi_id', $subMateriId)->max('order') ?? -1;
        }

        foreach ($validated['questions'] as $i => $q) {
            $codeSnippet = trim($q['code_snippet'] ?? '');
            $codeLang    = trim($q['code_language'] ?? '');

            $data = [
                'sub_materi_id'  => $subMateriId,
                'question'       => $q['question'],
                'code_snippet'   => $codeSnippet !== '' ? $codeSnippet : null,
                'code_language'  => $codeLang !== '' ? $codeLang : null,
                'options'        => [
                    $q['option_a'],
                    $q['option_b'],
                    $q['option_c'],
                    $q['option_d'],
                ],
                'correct_option' => (int) $q['correct_option'],
                'order'          => $isSyncMode ? ($i + 1) : ($currentMax + $i + 1),
            ];

            if (!empty($q['id'])) {
                Question::where('id', $q['id'])->update($data);
            } else {
                Question::create($data);
            }
        }

        $count = count($validated['questions']);

        return redirect()
            ->route('admin.spa')
            ->with('success', "$count soal berhasil disimpan! 🎉")
            ->with('admin_open_page', 'questions');
    }

    /**
     * Update single question via JSON API.
     */
    public function update(Request $request, Question $question): JsonResponse
    {
        $validated = $request->validate([
            'question'       => ['required', 'string', 'max:2000'],
            'code_snippet'   => ['nullable', 'string', 'max:5000'],
            'code_language'  => ['nullable', 'string', 'max:50'],
            'option_a'       => ['required', 'string', 'max:500'],
            'option_b'       => ['required', 'string', 'max:500'],
            'option_c'       => ['required', 'string', 'max:500'],
            'option_d'       => ['required', 'string', 'max:500'],
            'correct_option' => ['required', 'integer', 'min:0', 'max:3'],
        ]);

        $codeSnippet = trim($validated['code_snippet'] ?? '');
        $codeLang    = trim($validated['code_language'] ?? '');

        $question->update([
            'question'       => $validated['question'],
            'code_snippet'   => $codeSnippet !== '' ? $codeSnippet : null,
            'code_language'  => $codeLang !== '' ? $codeLang : null,
            'options'        => [
                $validated['option_a'],
                $validated['option_b'],
                $validated['option_c'],
                $validated['option_d'],
            ],
            'correct_option' => (int) $validated['correct_option'],
        ]);

        return response()->json(['success' => true, 'message' => 'Soal berhasil diperbarui.']);
    }

    /**
     * Delete single question via JSON API.
     */
    public function destroy(Question $question): JsonResponse
    {
        $question->delete();

        return response()->json(['success' => true, 'message' => 'Soal berhasil dihapus.']);
    }

    /**
     * Delete all questions for a specific SubMateri via JSON API.
     */
    public function destroyBySubMateri(SubMateri $subMateri): JsonResponse
    {
        $subMateri->questions()->delete();

        return response()->json(['success' => true, 'message' => 'Seluruh soal untuk sub-materi tersebut berhasil dihapus.']);
    }

    /**
     * Download Excel Template for Questions
     */
    public function downloadTemplate()
    {
        $data = [
            ['Pertanyaan', 'Opsi A', 'Opsi B', 'Opsi C', 'Opsi D', 'Jawaban Benar (A/B/C/D atau 0/1/2/3)', 'Kode Snippet (Opsional)', 'Bahasa Kode (Opsional)'],
            ['Ibukota negara Indonesia adalah?', 'Jakarta', 'Bandung', 'Surabaya', 'Medan', 'A', '', ''],
            ['Berapa hasil 5 + 5?', '8', '9', '10', '11', 'C', '', ''],
            ['Apa output kode di samping?', 'Hello', 'World', 'Hello World', 'Error', 'C', 'print("Hello World")', 'python'],
        ];

        $xlsx = SimpleXLSXGen::fromArray($data)
            ->setColWidth(1, 35)
            ->setColWidth(2, 15)
            ->setColWidth(3, 15)
            ->setColWidth(4, 15)
            ->setColWidth(5, 15)
            ->setColWidth(6, 25)
            ->setColWidth(7, 25)
            ->setColWidth(8, 20);

        $xlsx->downloadAs('Template_Import_Soal.xlsx');
        exit;
    }

    /**
     * Import questions from Excel
     */
    public function importExcel(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'sub_materi_id' => ['required', 'exists:sub_materis,id'],
            'excel_file'    => ['required', 'file', 'max:5120'], // max 5MB
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.spa')
                ->withErrors($validator)
                ->withInput()
                ->with('admin_open_page', 'questions');
        }

        $subMateriId = (int) $request->input('sub_materi_id');
        $file = $request->file('excel_file');
        
        if ($xlsx = SimpleXLSX::parse($file->getRealPath())) {
            $rows = $xlsx->rows();
            if (count($rows) <= 1) {
                return redirect()->route('admin.spa')
                    ->withErrors(['excel_file' => 'File Excel kosong atau tidak memiliki data soal.'])
                    ->with('admin_open_page', 'questions');
            }

            // Get max order
            $currentMax = Question::where('sub_materi_id', $subMateriId)->max('order') ?? -1;
            $importedCount = 0;

            // Skip header (index 0)
            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                // Pastikan baris memiliki setidaknya 6 kolom pertama (Pertanyaan s/d Jawaban Benar)
                if (count($row) < 6 || trim((string)$row[0]) === '') {
                    continue;
                }

                $questionText = trim((string)$row[0]);
                $optA = trim((string)$row[1]);
                $optB = trim((string)$row[2]);
                $optC = trim((string)$row[3]);
                $optD = trim((string)$row[4]);
                $correctInput = strtoupper(trim((string)$row[5]));

                // Parse correct option
                $correctOpt = 0;
                if ($correctInput === 'A' || $correctInput === '0') $correctOpt = 0;
                elseif ($correctInput === 'B' || $correctInput === '1') $correctOpt = 1;
                elseif ($correctInput === 'C' || $correctInput === '2') $correctOpt = 2;
                elseif ($correctInput === 'D' || $correctInput === '3') $correctOpt = 3;

                $codeSnippet = isset($row[6]) ? trim((string)$row[6]) : null;
                $codeLang = isset($row[7]) ? trim((string)$row[7]) : null;

                Question::create([
                    'sub_materi_id'  => $subMateriId,
                    'question'       => $questionText,
                    'options'        => [$optA, $optB, $optC, $optD],
                    'correct_option' => $correctOpt,
                    'code_snippet'   => $codeSnippet !== '' ? $codeSnippet : null,
                    'code_language'  => $codeLang !== '' ? $codeLang : null,
                    'order'          => ++$currentMax,
                ]);

                $importedCount++;
            }

            return redirect()->route('admin.spa')
                ->with('success', "$importedCount soal berhasil diimport dari Excel! 🎉")
                ->with('admin_open_page', 'questions');
        } else {
            return redirect()->route('admin.spa')
                ->withErrors(['excel_file' => 'Gagal membaca file Excel. ' . SimpleXLSX::parseError()])
                ->with('admin_open_page', 'questions');
        }
    }
}
