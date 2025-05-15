<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\TemplateCategory;
use App\Enums\DocumentType;

class Template extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'category',
        'document_type',
        'html_content'
    ];
    protected $casts = [
     'category' => TemplateCategory::class,
     'document_type' => DocumentType::class,
    ];

    
}
