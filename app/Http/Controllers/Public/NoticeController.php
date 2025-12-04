<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Notice;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::active()
            ->orderBy('is_urgent', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('public.notices.index', compact('notices'));
    }

    public function show($id)
    {
        $notice = Notice::active()->findOrFail($id);
        return view('public.notices.show', compact('notice'));
    }
}
