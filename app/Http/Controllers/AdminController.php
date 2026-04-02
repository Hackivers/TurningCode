<?php

namespace App\Http\Controllers;

use App\Models\MainMateri;
use App\Models\SubMateri;
use Illuminate\View\View;

class AdminController extends Controller
{
    private const PAGES = [
        'dashboard',
        'addsubmateri',
        'main-materi',
        'materi',
    ];

    public function spa(): View
    {
        return view('spa.admin', [
            'title' => 'Dashboard — Admin',
            'viteEntry' => 'resources/js/SPA_admin.js',
            'pageBaseUrl' => url('/admin/page'),
            'initialPage' => session()->pull('admin_open_page', 'dashboard'),
        ]);
    }

    public function page(string $page): View
    {
        if (! in_array($page, self::PAGES, true)) {
            abort(404);
        }

        if ($page === 'main-materi') {
            return view('spa.fragments.admin-main-materi', [
                'page' => $page,
                'mainMateris' => MainMateri::query()->withCount('materis')->orderBy('title')->get(),
            ]);
        }

        if ($page === 'materi') {
            return view('spa.fragments.admin-materi', [
                'page' => $page,
                'mainMateris' => MainMateri::query()->orderBy('title')->get(),
            ]);
        }

        if ($page === 'addsubmateri') {
            return view('spa.fragments.admin-addsubmateri', [
                'page' => $page,
                'mainMateris' => MainMateri::query()->orderBy('title')->get(),
                'recentSubMateris' => SubMateri::query()
                    ->with('materi.mainMateri')
                    ->latest()
                    ->limit(8)
                    ->get(),
            ]);
        }

        return view('spa.fragments.admin', ['page' => $page]);
    }
}
