<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.notices.index', compact('notices'));
    }

    public function create()
    {
        return view('admin.notices.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'body'        => 'nullable|string',
            'is_urgent'   => 'nullable|boolean',
            'expires_at'  => 'nullable|date',
            'status'      => 'required|in:draft,published',
            'attachment'  => 'nullable|file|max:5120', // 5 MB
            // You can restrict types further with:
            // 'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,txt|max:5120',
        ]);

        $notice = new Notice();
        $notice->title      = $data['title'];
        $notice->body       = $data['body'] ?? null;
        $notice->is_urgent  = $request->boolean('is_urgent');
        $notice->expires_at = $data['expires_at'] ?? null;
        $notice->status     = $data['status'];

        // Handle attachment
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            $path = $file->store('notices', 'public');

            $notice->attachment_path           = $path;
            $notice->attachment_original_name  = $file->getClientOriginalName();
            $notice->attachment_mime           = $file->getClientMimeType();
        }

        $notice->save();

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice created successfully.');
    }

    public function edit(Notice $notice)
    {
        return view('admin.notices.edit', compact('notice'));
    }

    public function update(Request $request, Notice $notice)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'body'        => 'nullable|string',
            'is_urgent'   => 'nullable|boolean',
            'expires_at'  => 'nullable|date',
            'status'      => 'required|in:draft,published',
            'attachment'  => 'nullable|file|max:5120',
        ]);

        $notice->title      = $data['title'];
        $notice->body       = $data['body'] ?? null;
        $notice->is_urgent  = $request->boolean('is_urgent');
        $notice->expires_at = $data['expires_at'] ?? null;
        $notice->status     = $data['status'];

        if ($request->hasFile('attachment')) {
            // delete old file if exists
            if ($notice->attachment_path) {
                Storage::disk('public')->delete($notice->attachment_path);
            }

            $file = $request->file('attachment');
            $path = $file->store('notices', 'public');

            $notice->attachment_path           = $path;
            $notice->attachment_original_name  = $file->getClientOriginalName();
            $notice->attachment_mime           = $file->getClientMimeType();
        }

        $notice->save();

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice updated successfully.');
    }

    public function destroy(Notice $notice)
    {
        if ($notice->attachment_path) {
            Storage::disk('public')->delete($notice->attachment_path);
        }

        $notice->delete();

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice deleted successfully.');
    }
}
