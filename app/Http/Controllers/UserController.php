<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class UserController extends Controller
{
    private const PAGES = [
        'dashboard',
        'history',
        'account',
        'materi',
        'submateri',
        'detail',
    ];

    public function spa(): View
    {
        return view('spa.user', [
            'title' => 'Dashboard — User',
            'viteEntry' => 'resources/js/SPA_user.js',
            'pageBaseUrl' => url('/app/page'),
            'initialPage' => 'dashboard',
        ]);
    }

    public function page(string $page): View
    {
        if (! in_array($page, self::PAGES, true)) {
            abort(404);
        }

        return view('spa.fragments.user', ['page' => $page]);
    }
}
