<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Itax_type_master extends Model
{
    protected $fillable = ['id', 'tax_desc', 'tax_type', 'max_amount', 'financial_year', 'created_at', 'updated_at'];
    
}
