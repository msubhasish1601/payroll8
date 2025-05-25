<?php

namespace App\Models\Role;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $primarykey='id';
	public $timestamps = false;
	
	protected $fillable=['id', 'company_id', 'branch_id', 'employee_id', 'emp_code', 'old_emp_code', 'first_name', 'middle_name', 'last_name', 'reporting_person', 'grade_id', 'employee_type_id', 'confirmation_date', 'department_id', 'designation_id', 'ccr', 'dob', 'mobile', 'father_name', 'experience', 'home_ph', 'qualification', 'sex', 'marital_status', 'permanent_street_no', 'permanent_city', 'permanent_state', 'permanent_country', 'permanent_pin', 'present_street_no', 'present_city', 'present_state', 'present_country', 'present_pin', 'joining_date', 'pan_no', 'adhar_no', 'pf_no', 'pf_join_date', 'esic_no', 'ot_applicable', 'nominee', 'basic_salary', 'transcation_mode', 'emp_bank_name','bank_branch_id','emp_ifsc_code', 'account_number', 'account_type', 'created_at', 'updated_at', 'employee_status','emp_viii_qualification','emp_viii_dicipline', 'emp_viii_inst_name', 'emp_viii_board_name', 'emp_viii_pass_year','emp_viii_percentage','emp_viii_rank','emp_per_post_office','emp_per_village','emp_per_policestation','emp_per_dist','emp_other_qualification','emp_other_dicipline','emp_other_inst_name','emp_other_board_name','emp_other_pass_year','emp_other_percentage','emp_other_rank','emp_nomination_name_three','emp_nomination_relation_three','emp_nomination_age_three','emp_nomination_name_four','emp_nomination_relation_four','emp_nomination_name_four','emp_ps_village','emp_ps_post_office','emp_ps_dist','emp_ps_policestation','emp_nomination_share_one','emp_nomination_share_two','emp_nomination_share_three','emp_nomination_share_four'];
}
