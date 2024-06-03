<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
    class Permission_model extends CI_Model
    {
        public function getAllStaffPermissionInfo($filter = ""){
            $this->db->select('permission.row_id,
            permission.staff_id, 
            permission.permission_date_from, 
            permission.permission_date_to, 
            permission.out_time, 
            permission.return_time, permission.reason, permission.approved_status,
            permission.permission_type,
            permission.approved_by,
            permission.rejected_by,
            staff.name as staff_name'); 
            $this->db->from('tbl_staff_permission_info as permission');
            $this->db->join('tbl_staff as staff', 'permission.staff_id = staff.staff_id','left');
            $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
            $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
            $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
            $this->db->where('staff.is_deleted', 0);
            $this->db->where('staff.staff_id !=', '123456');
            $this->db->where('Role.roleId !=', '50');
            $this->db->where('permission.is_deleted', 0);
            if(!empty($filter['staff_id'])){ 
                $this->db->where('permission.staff_id', $filter['staff_id']);
            }
            if(!empty( $filter['by_date'])){ 
              $this->db->where('permission.permission_date_from >=',  $filter['by_date']);
            }
           
            $this->db->order_by('permission.approved_status', 'DESC');
            $query = $this->db->get();
            return $query->result();
        }

        public function getPermissionInfoByRowId($row_id){
            $this->db->select('permission.row_id,
            permission.staff_id, 
            permission.permission_date_from, 
            permission.permission_date_to, 
            permission.out_time, 
            permission.return_time, permission.reason, permission.approved_status,
            permission.permission_type,
            permission.approved_by,
            permission.rejected_by,
            staff.name as staff_name'); 
            $this->db->from('tbl_staff_permission_info as permission');
            $this->db->join('tbl_staff as staff', 'permission.staff_id = staff.staff_id','left');
            $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
            $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
            $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
            $this->db->where('staff.is_deleted', 0);
            $this->db->where('permission.is_deleted', 0);
            $this->db->where('permission.row_id', $row_id);
            $query = $this->db->get();
            return $query->row();
        }

      public function addNewPermissionInfo($permissionInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_staff_permission_info', $permissionInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
      }

      public function updateStaffAppliedPermissionInfo($permissionInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_permission_info', $permissionInfo);
        return $this->db->affected_rows();
      }
  

      public function getPermissionCountByDate($from, $to , $staff_id){
        $this->db->from('tbl_staff_permission_info as permission');
        $this->db->where('permission.permission_date_from >=', $from);
        $this->db->where('permission.permission_date_from <=', $to);
        $this->db->where('permission.staff_id', $staff_id);
        $this->db->where('permission.approved_status', 1);
        $this->db->where('permission.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
      }

      public function getAllStaffPermissionForReport($start_date, $end_date, $staff_id, $permission_type){
        $this->db->select('permission.row_id,
        permission.staff_id, 
        permission.permission_date_from, 
        permission.permission_date_to, 
        permission.out_time, 
        permission.return_time, 
        permission.reason, 
        permission.approved_status,
        permission.permission_type,
        permission.approved_by,
        permission.rejected_by,
        dept.name as department,
        staff.name as staff_name,
        Role.role'); 
        $this->db->from('tbl_staff_permission_info as permission');
        $this->db->join('tbl_staff as staff', 'permission.staff_id = staff.staff_id','left');
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
     
        $this->db->where('permission.permission_date_from >=', $start_date);
        $this->db->where('permission.permission_date_from <=', $end_date);
      
        if($permission_type != 'ALL'){
          if($permission_type =='special'){
            $this->db->where('permission.special_permission_status', 1);
          }else{
            $this->db->where('permission.permission_type', $permission_type);
          }
        }
        if($staff_id != 'ALL'){
            $this->db->where('permission.staff_id', $staff_id);
        }
        $this->db->where('permission.approved_status', 1);
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('Role.roleId !=', '50');
        $this->db->where('permission.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    }