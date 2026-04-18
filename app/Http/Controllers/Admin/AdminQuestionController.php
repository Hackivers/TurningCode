<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            'questions'                  => ['required', 'array', 'min:1'],
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

        // Tentukan order awal dari jumlah question yang sudah ada
        $currentMax = Question::where('sub_materi_id', $subMateriId)->max('order') ?? -1;

        foreach ($validated['questions'] as $i => $q) {
            $codeSnippet = trim($q['code_snippet'] ?? '');
            $codeLang    = trim($q['code_language'] ?? '');

            Question::create([
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
                'order'          => $currentMax + $i + 1,
            ]);
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
}
