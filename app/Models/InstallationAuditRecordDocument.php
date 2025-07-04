<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallationAuditRecordDocument extends Model
{
    protected $fillable = [
        'installation_audit_id',
        'filename',
        'path',
        'mime_type',
        'size',
    ];
}
