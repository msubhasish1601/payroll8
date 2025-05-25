<?php 
namespace App\Imports;

use App\Models\LeaveAllocation;
use Maatwebsite\Excel\Concerns\ToModel;

class LeaveAllocationImport implements ToModel
{
    public function model(array $row)
    {
        // Map the data to the LeaveAllocation model
        return new LeaveAllocation([
            'leave_type'        => $row[1], // Assuming column 1 is "Leave Type"
            'employee_name'     => $row[2], // Assuming column 2 is "Employee Name"
            'employee_code'     => $row[3], // Assuming column 3 is "Employee Code"
            'max_no_of_leave'   => $row[4], // Assuming column 4 is "Max No. Of Leave"
            'opening_balance'   => $row[5], // Assuming column 5 is "Opening Balance"
            'leave_in_hand'     => $row[6], // Assuming column 6 is "Leave in Hand"
            'month_year'        => $row[7], // Assuming column 7 is "Month/Year"
        ]);
    }
}
