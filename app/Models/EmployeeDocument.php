<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDocument extends Model
{
    protected $fillable = [
        'employee_id',
        'document_type',
        'original_name',
        'stored_path',
        'mime_type',
        'file_size',
        'uploaded_by',
    ];

    /* ── Document type labels ─────────────────────────────────── */
    public static array $types = [
        'offer_letter' => 'Offer Letter',
        'pan_card'     => 'PAN Card',
        'aadhar_card'  => 'Aadhar Card',
        'other'        => 'Other',
    ];

    public static array $icons = [
        'offer_letter' => '📄',
        'pan_card'     => '🪪',
        'aadhar_card'  => '🪪',
        'other'        => '📎',
    ];

    /* ── Helpers ─────────────────────────────────────────────── */
    public function humanSize(): string
    {
        $bytes = $this->file_size ?? 0;
        if ($bytes < 1024) return $bytes . ' B';
        if ($bytes < 1048576) return round($bytes / 1024, 1) . ' KB';
        return round($bytes / 1048576, 1) . ' MB';
    }

    public function typeLabel(): string
    {
        return static::$types[$this->document_type] ?? 'Document';
    }

    /* ── Relationships ─────────────────────────────────────────── */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
