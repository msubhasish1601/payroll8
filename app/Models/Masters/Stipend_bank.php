<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Stipend_bank extends Model
{
    protected $primaryKey='id';
	protected $fillable=['id', 'bank_name', 'branch_name', 'ifsc_code', 'swift_code', 'updated_at', 'created_at','bank_status','opening_balance','financial_year'];
    
    public static function getMastersBank(){
        $bankMasters=Bank_master::get();
       // print_r($bankMasters); exit;
         if($bankMasters){
             return $bankMasters;
         }
 
     }
 
 
     public static function getMasterAndBank(){
     $bankMasters=Stipend_bank::leftJoin('bank_masters','stipend_banks.bank_name','=','bank_masters.id')
                  ->select('bank_masters.master_bank_name','stipend_banks.*')
                  ->get();
 
                //  print_r($bankMasters);die;
 
        return $bankMasters;
     }
}
