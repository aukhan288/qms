<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubcontractorDocument extends Model
{
    protected $table = 'subcontractor_document_files';
    protected $fillable = [
        'subcontractor_id',
        'filename',
        'path',
        'mime_type',
        'size',
    ];

   
}
