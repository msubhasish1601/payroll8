<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Sub_category extends Model
{
   protected $primaryKey="id";
   public $timestamps = true;
   protected $fillable = ['id', 'sub_cat_code', 'cat_name', 'sub_cat_name', 'coa_code'];
}
