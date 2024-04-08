<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class App_staff_login extends CI_Model
{
    function checkMobNo($mblNumber) 
    {

        log_message('debug','mblNumber-->'.print_r($mblNumber,true));

       
        $this->db->from('tbl_staff');
        $this->db->where('is_deleted', 0);
        $this->db->group_start();
        $this->db->where('mobile',$mblNumber);
        $this->db->or_where('mobile_two',$mblNumber);
        $this->db->group_end();
        $query = $this->db->get();
       // log_message('debug','query-->'.print_r($query,true));

        $user = $query->row();
        log_message('debug','user-->'.print_r($user,true));

        return $user;
       
    }

    function fetchStaffDetails($mblNumber)
    {
        // log_message('debug','model_mbl_number'.print_r($mblNumber,true));
        $this->db->select(
            'staff.name,staff.row_id,staff.staff_id,staff.user_name,staff.type,staff.mobile,staff.mobile_two,staff.email,staff.address,staff.photo_url,staff.dob,staff.doj,staff.aadhar_no,staff.pan_no,staff.voter_no,staff.gender,staff.blood_group,dept.name as department_name,Roles.role'
        );
        $this->db->from('tbl_staff as staff');
        $this->db->join('tbl_roles as Roles', 'Roles.roleId = staff.role');
        $this->db->join(
            'tbl_department as dept',
            'dept.dept_id = staff.department_id'
        );
        $this->db->where('staff.is_deleted', 0);
        $this->db->group_start();
        $this->db->where('staff.mobile_one', $mblNumber);
        $this->db->or_where('staff.mobile_two', $mblNumber);
        $this->db->group_end();
        $query = $this->db->get();
        return $query->result();
    }

    function fetchLeaveMangementInfo($staffID)
    {  
        $this->db->from('tbl_staff_leave_management');
        $this->db->where('is_deleted', 0);
        $this->db->where('staff_id', $staffID);
        $query = $this->db->get();
        return $query->result();
    }

    public function applyLeaveInsert($info){
        $this->db->trans_start();
        $this->db->insert('tbl_staff_applied_leave', $info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function getLeaveHistory($staff_id)
    {
        
        $this->db->from('tbl_staff_applied_leave');
        $this->db->where('staff_id', $staff_id);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function cancellLeave($leaveRowId,$info)
    {
        $this->db->where("row_id", $leaveRowId); 
        $this->db->update("tbl_staff_applied_leave", $info);
        return 1;
    }
    

   
}

?>