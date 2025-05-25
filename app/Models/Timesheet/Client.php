<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $primarykey='id';
	
	protected $fillable=['id', 'emid', 'name', 'poc_phone_no','poc_name','poc_email', 'type','status'];
}