<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalSkillsAndTraining extends Model
{
    protected $table = 'personal_skills_and_training';
    protected $fillable = [
        'user_id',
        'employee_name',
        'route_to_further_competence'
    ];

    public function competencies()
    {
        return $this->hasMany(Competencies::class, 'skill_id', 'id');
    }
    public function courses()
    {
        return $this->hasMany(SkillsCourse::class, 'skill_id', 'id');
    }
}
