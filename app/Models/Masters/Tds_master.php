<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Tds_master extends Model
{
    public $timestamps= false;
    protected $fillable = ['tds_section', 'tds_percentage'];
}
