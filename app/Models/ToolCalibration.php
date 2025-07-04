<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolCalibration extends Model
{
    protected $table = 'tool_calibration_records';
    protected $fillable = [
        'user_id',
        'item_of_equipment',
        'serial_number',
        'description',
        'calibration_checking_requirements',
        'measurement_ref_standard',
        'date_purchased',
        'date_calibrated',
        'serviced_or_checked',
        'next_calibration_date',
        'out_of_spec_reading_at_calibration',
    ];

    protected $casts = [
        'date_purchased' => 'date',
        'date_calibrated' => 'date',
        'serviced_or_checked' => 'date',
        'next_calibration_date' => 'date',
    ];



    public function files(){
        return $this->hasMany(ToolCalibrationDocument::class,'tool_calibration_id','id');
    }
}
