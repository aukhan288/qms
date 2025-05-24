<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\TemplateCategory;
use App\Enums\DocumentType;

class Template extends Model
{
    protected $fillable = [
        'name',
        'published',
        'ref',
        'revision',
        'pages',
        'revision_date',
        'user_id',
        'category',
        'document_type',
        'content'
    ];

    protected $casts = [
     'category' => TemplateCategory::class,
     'document_type' => DocumentType::class,
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
