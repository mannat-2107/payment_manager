<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployeeDocumentController extends Controller
{
    /* ── Admin: list documents for an employee ───────────────── */
    public function index(Employee $employee)
    {
        $employee->load('user', 'department');
        $documents = EmployeeDocument::where('employee_id', $employee->id)
            ->with('uploader')
            ->latest()
            ->get();

        return view('employees.documents', compact('employee', 'documents'));
    }

    /* ── Admin: upload ───────────────────────────────────────── */
    public function store(Request $request, Employee $employee)
    {
        $request->validate([
            'document_type' => 'required|in:offer_letter,pan_card,aadhar_card,other',
            'document_file' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx',
        ]);

        $file      = $request->file('document_file');
        $dir       = "employee-docs/{$employee->id}";
        $path      = $file->store($dir, 'local');

        EmployeeDocument::create([
            'employee_id'   => $employee->id,
            'document_type' => $request->document_type,
            'original_name' => $file->getClientOriginalName(),
            'stored_path'   => $path,
            'mime_type'     => $file->getMimeType(),
            'file_size'     => $file->getSize(),
            'uploaded_by'   => Auth::id(),
        ]);

        return back()->with('success', 'Document uploaded successfully.');
    }

    /* ── Admin + owner: download ──────────────────────────────── */
    public function download(EmployeeDocument $document)
    {
        // Employees can only download their own documents
        if (Auth::user()->hasRole('employee')) {
            $employee = Auth::user()->employee;
            abort_if(!$employee || $document->employee_id !== $employee->id, 403);
        }

        if (!Storage::disk('local')->exists($document->stored_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('local')->download(
            $document->stored_path,
            $document->original_name
        );
    }

    /* ── Admin: delete ───────────────────────────────────────── */
    public function destroy(EmployeeDocument $document)
    {
        Storage::disk('local')->delete($document->stored_path);
        $document->delete();

        return back()->with('success', 'Document deleted.');
    }
}
