<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorrectivePreventive extends Model
{
    protected $table = 'corrective_preventive_actions';
    protected $fillable = [
        'user_id',
        'date',
        'ncr_no',
        'measure_id',
        'source',
        'preventive_or_Corrective',
        'issued_to',
        'no_of_days',
        'date_closed',
        'closed_by',
        'status',
        'details_of_issue',
        'summary_of_action_taken',
        'root_cause',
        'prevent_recurrence'
    ];

    public function files(){
        return $this->hasMany(CorrectivePreventiveDocument::class,'corrective_preventive_id','id');
    }
}
