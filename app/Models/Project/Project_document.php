<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class Project_document extends Model
{
    protected $primarykey='id';
	
	protected $fillable=['id', 'project_id', 'document_name', 'document_file'];
}