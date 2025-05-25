<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Account_master extends Model
{
    public $timestamps= false;
    protected $fillable = ['account_code', 'account_type','account_name','account_desc','created_at'];
}
