<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ComplaintDocument extends Model
{
    protected $fillable = [
        'complaint_record_id',
        'filename',
        'path',
        'mime_type',
        'size',
    ];

    public function document()
    {
        return $this->belongsTo(CompanyDocument::class);
    }

    public function url()
    {
        return Storage::url($this->path);
    }
}
