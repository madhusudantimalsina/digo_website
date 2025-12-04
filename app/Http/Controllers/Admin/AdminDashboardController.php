<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormSubmission;
use App\Models\FinancialReport;
use App\Models\Notice;
use App\Models\GalleryImage;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalForms       = FormSubmission::count();
        $pendingApprovals = FormSubmission::where('status', 'pending')->count();
        $financialUpdates = FinancialReport::latest()->take(5)->get();
        $activeNotices    = Notice::where('status', 'published')->count();
        $galleryCount     = GalleryImage::count();

        return view('admin.dashboard', compact(
            'totalForms',
            'pendingApprovals',
            'financialUpdates',
            'activeNotices',
            'galleryCount'
        ));
    }
}
