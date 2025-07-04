<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorrectivePreventive extends Model
{
    protected $table = 'corrective_preventive_actions';
    protected $fillable = [
        'user_id',
        'date',
        'measure_id',
        'source',
        'type',
        'issued_to',
        'no_of_days',
        'date_closed',
        'status',
        'details_of_issue',
        'summary_of_action_taken',
        'root_cause',
        'prevent_recurrence'
    ];
}
