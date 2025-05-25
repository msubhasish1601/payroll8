<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Loan_master extends Model
{
    public $timestamps = false;

    protected $fillable = ['loan_id', 'loan_type', 'remarks', 'loan_status', 'created_at'];
}
