<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallationAuditRecord extends Model
{
    protected $fillable = [
        'user_id',
        'audit_date',
        'completed_date',
        'installation_reference_number',
        'installation_type',
        'installation_date',
        'transferred_to_GDR_02',
        'supervisor',
        'auditor',
        'project_folder_comments',
        'summary',
        'corrective_preventive_actions'
    ];

    public function measure()
    {
        return $this->belongsTo(ProjectMeasures::class, 'installation_type','id');
    }

    public function files(){
        return $this->hasMany(InstallationAuditRecordDocument::class,'installation_audit_id','id');
    }
}
