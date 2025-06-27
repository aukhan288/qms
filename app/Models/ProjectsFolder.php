<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectsFolder extends Model
{
    protected $table = 'projects_folders';
    protected $fillable = [
        'user_id',
        'project_reference',
        'customer_name',
        'address_line_1',
        'address_line_2',
        'city',
        'county',
        'postcode',
        'email',
        'land_line_number',
        'mobile_number',
        'retrofit_coordinator_name',
        'retrofit_coordinator_contact_number',
        'retrofit_coordinator_email',
        'eem_specifier',
        'eem_specifier_contact_name',
        'eem_specifier_office_phone',
        'eem_specifier_email',
        'start_date',
        'contract_completed_date',
        'measures_to_be_installed' 
    ];
    protected $casts = [
        'measures_to_be_installed' => 'array',
    ];
    public function measures_to_be_installed() {
         return ProjectMeasures::whereIn('id', $this->measures_to_be_installed ?? [])->get();
    }
   
}
