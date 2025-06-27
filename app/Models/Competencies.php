<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class competencies extends Model
{
    protected $fillable = [
        'skill_id',
        'competence_in',
        'competence_level',
        'experience_level',
    ];
    
    
}
