<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolCalibrationDocument extends Model
{
    protected $fillable = [
        'tool_calibration_id',
        'filename',
        'path',
        'mime_type',
        'size',
    ];
}
