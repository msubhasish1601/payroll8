<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Gpf_rate_master extends Model
{
    public $timestamps= false;

	protected $fillable = ['rate_of_interest','from_date','to_date','created_at','effect_on','gpf_no'];
}
