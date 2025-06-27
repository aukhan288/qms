<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcontractor extends Model
{
    protected $fillable = [
    'user_id',
    'company_name',
    'contact_name',
    'address_1',
    'address_2',
    'address_3',
    'address_4',
    'postcode',
    'telephone',
    'fax',
    'email',
    'approved_works',
    'active',
];
 public function files()
    {
        return $this->hasMany(SubcontractorDocument::class);
    }

    public function documents()
    {
        return $this->belongsTo(SubcontractorDocument::class);
    }
}
