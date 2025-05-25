<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $primarykey='id';
	
	protected $fillable=['id', 'company_name', 'company_address', 'company_pan','company_phone','company_fax', 'company_web', 'company_mail', 'company_cin', 'company_gstin', 'company_cgst','company_sgst', 'company_igst', 'company_logo','updated_at', 'created_at','company_status'];
}