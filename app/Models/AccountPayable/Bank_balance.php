<?php

namespace App\Models\AccountPayable;

use Illuminate\Database\Eloquent\Model;

class Bank_balance extends Model
{
    protected $primarykey='id';
	//protected $timestapms='false';
	
	protected $fillable=['id', 'voucher_no', 'bank_id', 'bank_branch_id', 'opening_balance', 'income', 'expense', 'balance_amt', 'bank_clearance_date', 'created_at'];
}
