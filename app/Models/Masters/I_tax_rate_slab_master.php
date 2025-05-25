<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class I_tax_rate_slab_master extends Model
{
    protected $fillable = ['id', 'amount_from', 'amount_to', 'percentage', 'gender', 'additional_amount', 'financial_year', 'created_at', 'updated_at'];
    
}
