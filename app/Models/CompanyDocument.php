<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyDocument extends Model
{
    protected $fillable = [
        'type',
        'user_id',
        'name',
        'description',
        'date',
        'renewal_date'
    ];

    public function files()
    {
        return $this->hasMany(CompanyDocumentFile::class);
    }
}
