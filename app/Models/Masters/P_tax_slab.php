<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class P_tax_slab extends Model
{

    protected $fillable = ['id', 'salary_from', 'salary_to', 'p_tax_amount', 'created_at', 'updated_at'];
}
