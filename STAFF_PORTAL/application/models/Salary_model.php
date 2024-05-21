<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class salary_model extends CI_Model
{

    public function getAllSalaryInfo($filter, $page, $segment){
        $this->db->select('staff.staff_id,staff.name,salary.account_no,salary.basic,salary.con,salary.hr,salary.total_salary,salary.ot_amount,salary.da,
        salary.total_days,salary.working_day,salary.total_allowances,salary.basic_deduction,salary.allowance_deduction,salary.salary_paid,salary.esi,
        salary.gross_salary,salary.pf,salary.total_deduction,salary.net_amount,salary.year,salary.month,salary.date,salary.row_id');
        $this->db->from('tbl_staff_salary_slip as salary'); 
        $this->db->join('tbl_staff as staff', 'staff.staff_id = salary.staff_id','left');
        // $this->db->join('tbl_factory_name as factory', 'factory.row_id = staff.factory_id','left');
        if(!empty($filter['name'])){
            $likeCriteria = "(staff.name  LIKE '%" . $filter['name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['date'])){
            $this->db->where('salary.date', $filter['date']);
        }
        
        if(!empty($filter['staff_id'])){
            $likeCriteria = "(staff_id.staff_id  LIKE '%" . $filter['staff_id'] . "%')";
            $this->db->where($likeCriteria);
        }
         if(!empty($filter['gross_salary'])){
            $this->db->where('salary.gross_salary', $filter['gross_salary']);
        }
          if(!empty($filter['grade_pay'])){
            $this->db->where('salary.grade_pay', $filter['grade_pay']);
        }
         if(!empty($filter['net_amount'])){
            $this->db->where('salary.net_amount', $filter['net_amount']);
        }
        if(!empty($filter['working_day'])){
            $this->db->where('salary.working_day', $filter['working_day']);
        }
        if(!empty($filter['basic'])){
            $this->db->where('salary.basic', $filter['basic']);
        }
         if(!empty($filter['by_month'])){
            $this->db->where('salary.month', $filter['by_month']);
        }
         if(!empty($filter['by_year'])){
            $this->db->where('salary.year', $filter['by_year']);
        }
       
        $this->db->where('salary.is_deleted', 0);
        $this->db->order_by('salary.date', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllSalaryCount($filter=''){
        $this->db->from('tbl_staff_salary_slip as salary'); 
        $this->db->join('tbl_staff as staff', 'staff.staff_id = salary.staff_id','left');
        if(!empty($filter['name'])){
            $likeCriteria = "(staff.name  LIKE '%" . $filter['name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['date'])){
            $this->db->where('salary.date', $filter['date']);
        }
        
        if(!empty($filter['staff_id'])){
            $likeCriteria = "(staff_id.staff_id  LIKE '%" . $filter['staff_id'] . "%')";
            $this->db->where($likeCriteria);
        }
         if(!empty($filter['gross_salary'])){
            $this->db->where('salary.gross_salary', $filter['gross_salary']);
        }
         if(!empty($filter['working_day'])){
            $this->db->where('salary.working_day', $filter['working_day']);
        }
          if(!empty($filter['grade_pay'])){
            $this->db->where('salary.grade_pay', $filter['grade_pay']);
        }
         if(!empty($filter['net_amount'])){
            $this->db->where('salary.net_amount', $filter['net_amount']);
        }
         if(!empty($filter['basic'])){
            $this->db->where('salary.basic', $filter['basic']);
        }
         if(!empty($filter['by_month'])){
            $this->db->where('salary.month', $filter['by_month']);
        }
         if(!empty($filter['by_year'])){
            $this->db->where('salary.year', $filter['by_year']);
        }
        $this->db->where('salary.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function addSalarySlipInfo($info){
            $this->db->trans_start();
            $this->db->insert('tbl_staff_salary_slip', $info);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }

    public function getSalaryInfoById($row_id)
        {
            $this->db->select('staff.staff_id,staff.name,salary.account_no,salary.basic,salary.con,salary.hr,salary.gross_salary,salary.total_salary,
            salary.total_days,salary.working_day,salary.total_allowances,salary.basic_deduction,salary.allowance_deduction,salary.salary_paid,salary.esi,
            salary.pf,salary.pt,salary.total_deduction,salary.net_amounts,alary.year,salary.monthsalary.date');
             $this->db->from('tbl_staff_salary_slip as salary'); 
             $this->db->join('tbl_staff as staff', 'staff.staff_id = salary.staff_id','left');
            $this->db->where('salary.row_id', $row_id);
            $this->db->where('salary.is_deleted', 0);
            $query = $this->db->get();
            return $query->row();
        }

    function updateSalarySlipInfo($info,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_salary_slip', $info);
        return TRUE;
    }
    // get info for Salary Slip
    public function getStaffSalarySlipInfoById($filter=''){
        $this->db->select('staff.staff_id,staff.name,salary.service,salary.basic,salary.con,salary.total_salary,salary.da, salary.pt,
        salary.total_days,salary.working_day,salary.total_allowances,salary.basic_deduction,salary.allowance_deduction,salary.salary_paid,salary.esi,
        salary.hr,salary.gross_salary,shift.name as shift_name,salary.advance_salary,salary.ot_amount,
        salary.pf,staff.pan_no,staff.aadhar_no,staff.uan_no,staff.tax_regime,
        salary.total_deduction,salary.year,salary.month,salary.year,
        salary.month,salary.date,dept.name as dept_name,staff.dob,staff.doj,Role.role,salary.account_no,salary.net_amount,leave.lop_leave');
        $this->db->from('tbl_staff_salary_slip as salary');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = salary.staff_id','left');
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->join(' tbl_staff_leave_management as leave', 'staff.staff_id = leave.staff_id','left');
        $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
        $this->db->join('tbl_staff_bank_info as bank', 'bank.staff_id = staff.staff_id','left');
        if(!empty($filter['student_id'])){
            $this->db->where_in('salary.row_id', $filter['student_id']);
        }
        $this->db->where('salary.is_deleted', 0);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    } 

      function getStaffId($staff_id){
         // $this->db->select('stf.staff_id');
            $this->db->from('tbl_staff as stf');
            $this->db->where('stf.staff_id', $staff_id);
            $this->db->where('stf.is_deleted',0);
            $query = $this->db->get();
        return $query->row();
    }
    public function CheckSlarySlipGenerated($staff_id,$year,$month)
    {
        $this->db->from('tbl_staff_salary_slip as salary'); 
        $this->db->where('salary.staff_id', $staff_id);
        $this->db->where('salary.year', $year);
        $this->db->where('salary.month', $month);
        $this->db->where('salary.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    public function getStaffSalaryDetails($filter=''){
        $this->db->select('staff.staff_id,staff.name,salary.service,salary.account_no,salary.basic,salary.con,salary.total_salary,
        salary.total_days,salary.working_day,salary.total_allowances,salary.basic_deduction,salary.allowance_deduction,salary.salary_paid,salary.esi,
        salary.hr,salary.gross_salary,shift.name as shift_name,factory.factory_name,salary.advance_salary,salary.ot_amount,
        salary.pf,staff.pan_no,staff.aadhar_no,staff.uan_no,salary.tax_regime,
        salary.total_deduction,salary.year,salary.month,salary.year,
        salary.month,salary.date,dept.name as dept_name,staff.dob,staff.doj,Role.role,salary.account_no,salary.net_amount,leave.lop_leave');
        $this->db->from('tbl_staff_salary_slip as salary');
        $this->db->join('tbl_staff as staff', 'staff.staff_id = salary.staff_id','left');
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->join(' tbl_staff_leave_management as leave', 'staff.staff_id = leave.staff_id','left');
        $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
        $this->db->join('tbl_factory_name as factory', 'factory.row_id = staff.factory_id','left');
        if(!empty($filter['salary_month'])){
            $this->db->where('salary.month', $filter['salary_month']);
        }
        if(!empty($filter['salary_year'])){
            $this->db->where('salary.year', $filter['salary_year']);
        }
        if(!empty($filter['staff_factory'])) {
            $this->db->where('staff.factory_id', $filter['staff_factory']); 
        }
        $this->db->where('salary.is_deleted', 0);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }
    public function getStaffAdvanceSalaryInfo($staff_id)
    {
        $this->db->from('tbl_staff_advance_payment_info as staff'); 
        $this->db->where('staff.staff_id ', $staff_id);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    } 
    function addAdvanceSalaryInstallmentInfo($info){
        $this->db->trans_start();
        $this->db->insert('tbl_advance_salary_installment_info', $info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function getAdvanceSalaryPaidInfo($staff_id, $row_id)
    {
        $this->db->select('SUM(staff.installment_amount) as installment_amount');
        $this->db->from('tbl_advance_salary_installment_info as staff');
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where('staff.advance_id', $row_id);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->installment_amount;
    }
    public function getAdvanceInstallmentInfoByStaffId($staff_id){
        $this->db->from('tbl_advance_salary_installment_info as staff');
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAdvanceAmountInfo($filter = '')
    {
        $this->db->from('tbl_staff_advance_payment_info as section');
        if (!empty($filter['row_id '])) {
            $this->db->where('section.row_id ', $filter['row_id ']);
        }
        $this->db->where('section.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    function updateAdvancePaymentDetails($info,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_advance_payment_info', $info);
        return TRUE;
    }
    public function getAdvanceSalaryInstallmentInfo($staff_id, $row_id){
        $this->db->from('tbl_advance_salary_installment_info as staff');
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where('staff.advance_id', $row_id);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllStaffAdvanceSalaryInfo($filter)
    {
        $this->db->select('staff.user_name, shift.name as shift_name, shift.shift_code, shift.start_time, factory.factory_name,
        shift.end_time, staff.type, staff.row_id, staff.staff_id, staff.email, staff.name,dept.name as department, advance.advance_amount,
        staff.mobile, Role.role, staff.address, staff.dob,advance.date,advance.row_id as advance_id');
        $this->db->from('tbl_staff as staff'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
        $this->db->join('tbl_staff_advance_payment_info as advance', 'advance.staff_id = staff.staff_id','left');
        $this->db->join('tbl_factory_name as factory', 'factory.row_id = staff.factory_id','left');
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('staff.is_deleted', 0);
        // $this->db->where('staff.resignation_status', 0);
        $this->db->where('advance.is_deleted', 0);
        if($filter['factory_name']!='ALL')
        {
            $this->db->where('factory.factory_name', $filter['factory_name']);
        }
        if(!empty($filter['date_from']) && !empty($filter['date_to'])){
            $this->db->where('DATE(advance.date) >=', $filter['date_from']);
            $this->db->where('DATE(advance.date) <=', $filter['date_to']);
        }
        if(!empty($filter['date_from']) ){
            $this->db->where('DATE(advance.date) >=', $filter['date_from']);
        }
        if(!empty($filter['date_to'])){
            $this->db->where('DATE(advance.date) <=', $filter['date_to']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    function updateSalaryInfoByID($info,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_salary_info', $info);
        return TRUE;
    }
    public function getStaffOtInfo($staff_id,$date_from,$date_to)
    {
        $this->db->select('SUM(staff.total_ot_amount) as total_ot_amount');
        $this->db->from('tbl_staff_ot_info as staff');
        $this->db->where('staff.date>=', $date_from);
        $this->db->where('staff.date<=', $date_to);
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->total_ot_amount;
    }
    public function getSingleStaffAttendanceInfoAB($staff_id, $date_from, $date_to){
        // Generate an array of dates between date_from and date_to
        $dates = [];
        $current_date = strtotime($date_from);
        $end_date = strtotime($date_to);
    
        while ($current_date <= $end_date) {
            $dates[] = date("Y-m-d", $current_date);
            $current_date = strtotime("+1 day", $current_date);
        }
    
        // Convert the dates array to a comma-separated string for SQL
        $dates_str = "'" . implode("','", $dates) . "'";
    
        // Your original query
        $query = $this->db->query("SELECT staff.staff_id,sa.punch_time,sa.punch_out_time,
        sa.punch_date, staff.type, staff.row_id, staff.name, dept.name as department, staff.mobile, role_.role, role_.roleId,
        shift.start_time, shift.end_time, shift.name, shift.shift_code FROM 
        tbl_staff_attendance_info as sa
        JOIN tbl_staff as staff ON staff.staff_id = sa.staff_id
        JOIN tbl_roles as role_ ON role_.roleId = staff.role
        JOIN tbl_department as dept ON dept.dept_id = staff.department_id
        JOIN tbl_staff_shift_info as shift ON staff.shift_code = shift.shift_code
        WHERE
        staff.is_deleted = 0 AND 
        sa.staff_id = '$staff_id'
        AND sa.punch_date >= '$date_from' AND sa.punch_date <= '$date_to' 
        GROUP BY sa.punch_date");
    
        // Fetch the result
        $result = $query->result();
    
        // Create an associative array with dates as keys
        $attendance_info = [];
        foreach ($result as $row) {
            $attendance_info[$row->punch_date] = $row;
        }
    
        // Fill in missing dates with null values
        foreach ($dates as $date) {
            if (!isset($attendance_info[$date])) {
                $attendance_info[$date]['punch_date'] = '';
                $attendance_info[$date]['test_date'] = $date;
                $attendance_info[$date]['in_time'] =  '';
                $attendance_info[$date]['out_time'] =  '';
                $attendance_info[$date]['punch_time'] =  '';
                $attendance_info[$date]['start_time'] =  '';
            }
        }
    
        // Sort the array by date
        ksort($attendance_info);

        $attendance_info = json_decode(json_encode($attendance_info));
    
        return $attendance_info;
    }
    public function getAllStaffInfoSalarySlipGenartion($filter)
    {
        $this->db->select('staff.user_name, shift.name as shift_name, shift.shift_code, shift.start_time,bank.account_no,
        shift.end_time, staff.type, staff.row_id, staff.staff_id, staff.email, staff.name,dept.name as department');
        $this->db->distinct();
        $this->db->from('tbl_staff as staff'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
        $this->db->join('tbl_staff_bank_info as bank', 'bank.staff_id  = staff.staff_id','left');
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.resignation_status', 0);
        $this->db->where('staff.retirement_status', 0);
        $query = $this->db->get();
        return $query->result();
    }
    function checkInstitutionNameByID($institution_name) {
        $this->db->from('tbl_factory_name as Factory');
        $this->db->where('Factory.row_id', $institution_name);
        $this->db->where('Factory.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    function deleteAdanceInstallmentInfo($salary_slip_id, $info){
        $this->db->where('salary_slip_id', $salary_slip_id);
        $this->db->update('tbl_advance_salary_installment_info', $info);
        return TRUE;
    }
    public function getStaffInfoSalarySlipGenartion($filter)
    {
        $this->db->select('staff.user_name, shift.name as shift_name, shift.shift_code, shift.start_time,,salary.pf, salary.esi,salary.da, salary.pt,salary.cautional,
        shift.end_time, staff.type, staff.row_id, staff.staff_id, staff.email, staff.name,dept.name as department,  salary.hr, salary.con,salary.basic_salary,staff.tax_regime,
        staff.mobile_one, Role.role, staff.address, staff.dob,staff.salary_id,bank.account_no');
        $this->db->distinct();
        $this->db->from('tbl_staff as staff'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
        $this->db->join('tbl_staff_salary_info as salary', 'salary.row_id = staff.salary_id','left');
        $this->db->join('tbl_staff_bank_info as bank', 'bank.staff_id = staff.staff_id','left');
     
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.resignation_status', 0);
        $query = $this->db->get();
        return $query->result();
    }
}
?>