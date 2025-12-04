<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\FinancialReport;

class FinancialController extends Controller
{
    /**
     * Show list of all public financial reports.
     * GET /financial-reports
     */
    public function index()
    {
        $reports = FinancialReport::where('is_active', true)
            ->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('public.financial.index', compact('reports'));
    }

    /**
     * Show a single financial report (only if it is public).
     * GET /financial-reports/{report}
     */
    public function show(FinancialReport $report)
    {
        // If report is not active, do not show it to public
        if (! $report->is_active) {
            abort(404);
        }

        return view('public.financial.show', compact('report'));
    }
}
