<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Model;

class PfOpeningBalance extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'emp_code',
        'emp_name',
        'member_balance',
        'company_balance',
        'total_balance',
        'emp_financial_year',
    ];

}
