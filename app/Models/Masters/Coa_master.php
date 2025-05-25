<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Coa_master extends Model
{
    public $timestamps= false;
    protected $fillable = ['coa_code', 'head_name','account_tool','account_type','account_name','account_reflect_on','coa_remarks'];
}
