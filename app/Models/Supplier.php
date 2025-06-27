<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'user_id',
        'supplier_name',
        'contact_name',
        'address_1',
        'address_2',
        'address_3',
        'address_4',
        'postcode',
        'telephone',
        'fax',
        'email',
        'product',
        'is_active'
    ];
}
