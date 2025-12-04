<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FinancialReportController extends Controller
{
    // GET /admin/financial-reports
    public function index()
    {
        $reports = FinancialReport::orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.financial.index', compact('reports'));
    }

    // GET /admin/financial-reports/create
    public function create()
    {
        return view('admin.financial.create');
    }

    // POST /admin/financial-reports
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'file'         => 'required|file|mimes:pdf,jpg,jpeg,png,gif',
            'published_at' => 'nullable|date',
        ]);

        $file     = $request->file('file');
        $filePath = $file->store('financial_reports', 'public');

        FinancialReport::create([
            'title'              => $data['title'],
            'description'        => $data['description'] ?? null,
            'file_path'          => $filePath,
            'file_original_name' => $file->getClientOriginalName(),
            'file_mime'          => $file->getClientMimeType(),
            'file_size'          => $file->getSize(),
            'published_at'       => $data['published_at'] ?? now(),
            // ✅ true if checkbox ticked, false if not present
            'is_active'          => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.financial-reports.index')
            ->with('success', 'Financial report created successfully.');
    }

    // GET /admin/financial-reports/{financial_report}/edit
    public function edit(FinancialReport $financial_report)
    {
        $report = $financial_report;
        return view('admin.financial.edit', compact('report'));
    }

    // PUT /admin/financial-reports/{financial_report}
    public function update(Request $request, FinancialReport $financial_report)
    {
        $report = $financial_report;

        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'file'         => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif',
            'published_at' => 'nullable|date',
        ]);

        // If a new file is uploaded, replace the old one
        if ($request->hasFile('file')) {
            if ($report->file_path && Storage::disk('public')->exists($report->file_path)) {
                Storage::disk('public')->delete($report->file_path);
            }

            $file     = $request->file('file');
            $filePath = $file->store('financial_reports', 'public');

            $report->file_path          = $filePath;
            $report->file_original_name = $file->getClientOriginalName();
            $report->file_mime          = $file->getClientMimeType();
            $report->file_size          = $file->getSize();
        }

        $report->title        = $data['title'];
        $report->description  = $data['description'] ?? null;
        $report->published_at = $data['published_at'] ?? $report->published_at ?? now();

        // ✅ update visibility based on checkbox
        $report->is_active = $request->has('is_active');

        $report->save();

        return redirect()
            ->route('admin.financial-reports.index')
            ->with('success', 'Financial report updated successfully.');
    }

    // DELETE /admin/financial-reports/{financial_report}
    public function destroy(FinancialReport $financial_report)
    {
        if ($financial_report->file_path && Storage::disk('public')->exists($financial_report->file_path)) {
            Storage::disk('public')->delete($financial_report->file_path);
        }

        $financial_report->delete();

        return redirect()
            ->route('admin.financial-reports.index')
            ->with('success', 'Financial report deleted.');
    }
}
