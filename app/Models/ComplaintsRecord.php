<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintsRecord extends Model
{
    protected $table = 'complaints_records';
    protected $fillable = [
        'user_id',
        'projects_folders_id',
        'measure_id',
        'source',
        'complainant_name',
        'date_of_complaint',
        'address',
        'contact_name',
        'contact_email',
        'contact_phone',
        'contact_mobile',
        'handled_by',
        'nature_of_complaint',
        'immediate_action_required',
        'outcome',
        'resolved_within_5_days',
        'correctiveActionRequired',
        'resolution_comments',
        'findings',
        'summary_of_findings',
        'attachment_path',
        'closed_out',
        'verified_by',
        'file_name',
        'validator_position'
    ];


    public function files(){
        return $this->hasMany(ComplaintDocument::class,'complaint_record_id','id');
    }
   public function measure()
{
    return $this->belongsTo(ProjectMeasures::class, 'measure_id');
}
        
}
