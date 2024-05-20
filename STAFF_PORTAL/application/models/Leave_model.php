<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
    class Leave_model extends CI_Model
    {
//getting all staff info

    public function getAllStaffLeaveInfo()
    {
        $this->db->select('leave.date_from, leave.date_to, leave.leave_reason, leave.total_days_leave,
        leave.row_id,leave.approved_status, leave.leave_type,
 
        staff.type, staff.staff_id, staff.email, staff.name,dept.name as department, staff.mobile_one, Role.role, staff.address');
        $this->db->from('tbl_staff_applied_leave as leave'); 
        $this->db->join('tbl_staff as staff', 'staff.staff_id = leave.staff_id','left');
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        //$this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
        $this->db->order_by('leave.date_from', 'DESC');
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('leave.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getLeaveInfoByStaffId($staff_id)
    {
        $this->db->from('tbl_staff_leave_management as leave');
        $this->db->where('leave.staff_id', $staff_id);
        $this->db->where('leave.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }



//     //add new leave info
      
     public function addStaffLeaveInfo($leaveInfo)
      {
          $this->db->trans_start();
          $this->db->insert('tbl_staff_leave_management', $leaveInfo);
          $insert_id = $this->db->insert_id();
          $this->db->trans_complete();
          return $insert_id;
      }
// //update leave info
      function updateStaffLeaveInfo($leaveInfo, $staff_id)
    {
        $this->db->where('staff_id', $staff_id);
        $this->db->update('tbl_staff_leave_management', $leaveInfo);
        return TRUE;
    } 

    function addAppliedStaffLeave($leaveInfo){
          $this->db->trans_start();
          $this->db->insert('tbl_staff_applied_leave', $leaveInfo);
          $insert_id = $this->db->insert_id();
          $this->db->trans_complete();
          return $insert_id;   
    }

          //checking leave already applied or not

public function checkLeaveAppliedAlready($date_from,$staff_id)
{
    $this->db->from('tbl_staff_applied_leave as leave'); 
    $this->db->where('leave.staff_id', $staff_id);
    $this->db->where('leave.date_from', date('Y-m-d',strtotime($date_from)));
    //$this->db->where('leave.approved_status', 1);
    $this->db->where('leave.is_deleted', 0);
    $query = $this->db->get();
    return $query->row();
}

    function assignStaffWork($staffInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_staff_assigned_work_info', $staffInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;   
    }
    function getStaffLeaveInfoByRow_Id($row_id){
        $this->db->select('leave.date_from, leave.date_to, leave.leave_reason, leave.total_days_leave,leave.medical_certificate,
        leave.row_id, leave.approved_status, leave.leave_type,
        leave.approved_by,leave.rejected_by,leavemgmt.casual_leave_earned,leavemgmt.sick_leave_earned,
         staff.type,  staff.staff_id, staff.email, staff.name,dept.name as department, staff.mobile_one, Role.role, staff.address');
        $this->db->from('tbl_staff_applied_leave as leave'); 
        $this->db->join('tbl_staff as staff', 'staff.staff_id = leave.staff_id','left');
        $this->db->join('tbl_staff_leave_management as leavemgmt', 'staff.staff_id = leavemgmt.staff_id','left');
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        //$this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
        $this->db->where('leave.is_deleted', 0);
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('leave.row_id', $row_id);
        $query = $this->db->get();
        return $query->row();
    }

    function getStaffWorkAssignByRow_Id($row_id){
        $this->db->from('tbl_staff_assigned_work_info as work');
        $this->db->where('work.rel_leave_row_id', $row_id);
        $this->db->where('work.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    //update applied leave info
    function updateStaffAppliedLeaveInfo($leaveInfo, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_applied_leave', $leaveInfo);
        return TRUE;
    } 



    public function getAppliedLeaveInfoByStaffId($staff_id){
        $this->db->select('leave.date_from, leave.date_to, leave.leave_reason, leave.total_days_leave,
        leave.row_id,leave.approved_status, leave.leave_type,
     
        staff.type, staff.staff_id, staff.email, staff.name,dept.name as department, staff.mobile_one, Role.role, staff.address');
        $this->db->from('tbl_staff_applied_leave as leave'); 
        $this->db->join('tbl_staff as staff', 'staff.staff_id = leave.staff_id','left');
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        //$this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
        $this->db->order_by('leave.date_from', 'DESC');
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('leave.is_deleted', 0);
        $this->db->where('leave.staff_id', $staff_id);
        $query = $this->db->get();
        return $query->result();
    }

    
    //get staff applied leave info by date 

     public function getAllStaffLeaveInfoForReport($from_date, $to_date, $staff_id, $leave_type, $leave_status)
    {
        $this->db->select('leave.date_from, leave.date_to, leave.leave_reason, leave.total_days_leave,
        leave.row_id,leave.approved_status, leave.leave_type,
     
        staff.type, staff.staff_id, staff.email, staff.name,dept.name as department, staff.mobile_one, Role.role, staff.address');
        $this->db->from('tbl_staff_applied_leave as leave'); 
        $this->db->join('tbl_staff as staff', 'staff.staff_id = leave.staff_id','left');
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        //$this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
        $this->db->where('leave.date_from >=', $from_date);
        $this->db->where('leave.date_from <=', $to_date);
        if($leave_type != 'ALL'){
            $this->db->where('leave.leave_type', $leave_type);
        }
        if($staff_id != 'ALL'){
            $this->db->where('leave.staff_id', $staff_id);
        }
        if($leave_status == 'PENDING'){
            $this->db->where('leave.approved_status', 0);
        } else if($leave_status == 'REJECTED'){
            $this->db->where('leave.approved_status', 2);
        } else if($leave_status == 'APPROVED'){
            $this->db->where('leave.approved_status', 1);
        }
        
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('leave.is_deleted', 0);
        $this->db->order_by('cast(staff.staff_id as unsigned)', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }



    public function getAllStaffLeaveInfoForReportTwo($from_date, $to_date, $staff_id, $leave_type, $leave_status)
{
    $this->db->select('leave.date_from, leave.date_to, leave.leave_reason, leave.total_days_leave,
    leave.row_id,leave.approved_status, leave.leave_type,
    staff.type, staff.staff_id, staff.email, staff.name,dept.name as department, staff.mobile_one, Role.role, staff.address');
    $this->db->from('tbl_staff_applied_leave as leave'); 
    $this->db->join('tbl_staff as staff', 'staff.staff_id = leave.staff_id','left');
    $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
    $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
  //  $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
    $this->db->where('leave.date_from >=', $from_date);
    $this->db->where('leave.date_from <=', $to_date);
    if($leave_type != 'ALL'){
        $this->db->where('leave.leave_type', $leave_type);
    }
    if($staff_id[0] != 'ALL'){
        $this->db->where_in('leave.staff_id', $staff_id);
    }
    if($leave_status == 'PENDING'){
        $this->db->where('leave.approved_status', 0);
    } else if($leave_status == 'REJECTED'){
        $this->db->where('leave.approved_status', 2);
    } else if($leave_status == 'APPROVED'){
        $this->db->where('leave.approved_status', 1);
    }
   
    $this->db->where('staff.staff_id !=', '123456');
    $this->db->where('staff.is_deleted', 0);
    $this->db->where('leave.is_deleted', 0);
    $this->db->order_by('cast(staff.staff_id as unsigned)', 'ASC');
    $query = $this->db->get();
    return $query->result();
}


public function getAllStaffLeavePendingInfoForReport2($staff_id,$year)
{
    $this->db->select('leave.casual_leave_earned,leave.sick_leave_earned,leave.marriage_leave_earned,leave.paternity_leave_earned,leave.maternity_leave_earned,
    leave.casual_leave_used,leave.sick_leave_used,leave.marriage_leave_used,leave.paternity_leave_used,leave.maternity_leave_used,leave.lop_leave,
    staff.type, staff.staff_id, staff.email, staff.name,dept.name as department, Role.role, staff.address');


    // if($year == "2019-20"){
    //     $this->db->from('tbl_staff_leave_management_2019_20 as leave');
    // }else if($year == "2020-21"){
    //     $this->db->from('tbl_staff_leave_management_2020_21 as leave');
    // }else if($year == "2021-22"){
    //     $this->db->from('tbl_staff_leave_management_2021_22 as leave');
    // }else if($year == "2022-23"){
    //     $this->db->from('tbl_staff_leave_management_2022_23 as leave');
    // }else{
        $this->db->from('tbl_staff_leave_management as leave');
    // }
    $this->db->join('tbl_staff as staff', 'staff.staff_id = leave.staff_id','left');
    $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
    $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
    // $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
    // if($leave_type != 'ALL'){
    //     $this->db->where('leave.leave_type', $leave_type);
    // }
    if($staff_id[0] != 'ALL'){
        $this->db->where_in('leave.staff_id', $staff_id);
    }
   
    $this->db->where('staff.staff_id !=', '123456');
    $this->db->where('staff.is_deleted', 0);
    $this->db->where('leave.is_deleted', 0);
    $this->db->order_by('cast(staff.staff_id as unsigned)', 'ASC');
    $query = $this->db->get();
    return $query->result();
}

public function getLeaveInfoByStaffIdNew($staff_id)
    {
        $this->db->from('tbl_staff_leave_management as leave');
        $this->db->where('leave.staff_id', $staff_id);
        $this->db->order_by('leave.year','DESC');
        $this->db->where('leave.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getLeaveInfoByStaffIdNew2024($staff_id)

    {

        $this->db->from('tbl_staff_leave_management as leave');

        $this->db->where('leave.staff_id', $staff_id);
        $this->db->where('leave.year','2024');

        $this->db->where('leave.is_deleted', 0);

        $query = $this->db->get();

        return $query->result();

    }

    public function getLeaveUsedSum($staff_id,$type,$year)
    {
        $this->db->select_sum('leave.total_days_leave');
        $this->db->from('tbl_staff_applied_leave as leave');
        $this->db->where('leave.staff_id', $staff_id);
        $this->db->where('leave.leave_type', $type);
        $this->db->where('leave.is_deleted', 0);
        $this->db->where('leave.approved_status', 1);
        $this->db->where('leave.year', $year);
        $query = $this->db->get();
        return $query->row();
    }

    public function getLeaveInfoByStaffIdYear($staff_id,$year)
    {
        $this->db->from('tbl_staff_leave_management as leave');
        $this->db->where('leave.staff_id', $staff_id);
        $this->db->where('leave.year', $year);
        $this->db->where('leave.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function updateStaffLeaveInfoByYearNew($leaveInfo, $staff_id,$year)
    {
        $this->db->where('staff_id', $staff_id);
        $this->db->where('year', $year);
        $this->db->update('tbl_staff_leave_management', $leaveInfo);
        return TRUE;
    } 

    




}


?>