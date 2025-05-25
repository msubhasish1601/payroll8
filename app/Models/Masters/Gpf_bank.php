<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Gpf_bank extends Model
{
    public $timestamps= false;
    protected $fillable = ['bank_name', 'branch_name','ifsc_code','micr_code','opening_balance','financial_year','bank_status'];
}
