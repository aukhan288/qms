<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorrectivePreventiveDocument extends Model
{
    protected $fillable = [
        'corrective_preventive_id',
        'filename',
        'path',
        'mime_type',
        'size',
    ];
}
