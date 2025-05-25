<?php

namespace App\Models\IncomeTax;

use Illuminate\Database\Eloquent\Model;

class ItaxDeposit extends Model
{
    protected $fillable = ['id', 'amount', 'payment_date', 'challan_no', 'bsr_code','bank', 'created_at', 'updated_at'];
    
}
