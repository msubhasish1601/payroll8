<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Account_opening_balance extends Model
{
    protected $primaryKey='id';
    protected $fillable=['id', 'group_code', 'group_name', 'account_code', 'account_name', 'opening_balance', 'month_yr','financial_year',
    'cr_amount','dr_amount','closing_balance'];
}
