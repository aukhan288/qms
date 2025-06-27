<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillsCourse extends Model
{

    protected $fillable = [
        'skill_id',
        'course_name',
        'course_date',
        'renewal_date',
        'course_description',
    ];

    
}
