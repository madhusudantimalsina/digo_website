<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormSubmission;
use Illuminate\Http\Request;

class FormSubmissionController extends Controller
{
    /**
     * List all submitted forms (contact, membership, etc.)
     */
    public function index()
    {
        $submissions = FormSubmission::with('form')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.forms.index', compact('submissions'));
    }

    /**
     * Show details of a single submission.
     */
    public function show($id)
    {
        $submission = FormSubmission::with('form')->findOrFail($id);

        return view('admin.forms.show', compact('submission'));
    }

    /**
     * Update status of a submission (new / seen / processed).
     */
    public function updateStatus(Request $request, $id)
    {
        $submission = FormSubmission::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:new,seen,processed',
        ]);

        $submission->status = $validated['status'];
        $submission->save();

        return redirect()
            ->route('admin.form-submissions.show', $submission->id)
            ->with('success', 'Status updated successfully.');
    }
}
