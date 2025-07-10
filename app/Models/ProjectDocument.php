<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDocument extends Model
{
    protected $table = 'project_documents';

    protected $fillable = [
        'project_folder_id',
        'filename',
        'upload_measure',
        'path',
        'mime_type',
        'size',
    ];

    public function projectFolder()
    {
        return $this->belongsTo(ProjectsFolder::class, 'project_folder_id');
    }
    public function measure()
    {
        return $this->belongsTo(ProjectMeasures::class, 'upload_measure');
    }
}
