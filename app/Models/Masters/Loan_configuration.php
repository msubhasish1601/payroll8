<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Loan_configuration extends Model
{
    protected $primarykey = 'id';
    protected $fillable = ['id', 'loan_config_id', 'loan_type', 'max_sanction_amt', 'max_time', 'rate_of_interest', 'loan_config_status', 'updated_at', 'created_at'];
}
