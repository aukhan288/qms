<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CompanyDocumentFile extends Model
{
     protected $fillable = [
        'company_document_id',
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
