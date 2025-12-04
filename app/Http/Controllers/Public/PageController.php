<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * Home page: route '/'
     */
public function home()
{
    $latestNotices = \App\Models\Notice::active()
        ->orderBy('is_urgent', 'desc')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    return view('public.home', compact('latestNotices'));
}
    /**
     * Show a static page by slug: route '/page/{slug}'
     */
    public function show(string $slug)
    {
        $page = Page::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('public.page', compact('page'));
    }
}
