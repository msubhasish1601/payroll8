<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Saving_type_master extends Model
{
    protected $fillable = ['id', 'financial_year', 'i_tax_type', 'saving_type_desc', 'max_amount', 'created_at', 'updated_at'];
    
}
