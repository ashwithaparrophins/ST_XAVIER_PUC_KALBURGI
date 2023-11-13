<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Subjects_model extends CI_Model
{
    protected $_table_name = 'tbl_subjects';
    public function getAllSubjectInfo() {
        $this->db->select('sub.row_id,sub.subject_code,sub.department_id,dept.name,sub.name as sub_name,sub.sub_type,sub.lab_status');
        $this->db->from($this->_table_name. ' as sub'); 
        $this->db->join('tbl_department as dept', 'sub.department_id = dept.dept_id');
        $this->db->where('sub.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllSubjectInfoById($row_id)
    {
        $this->db->select('sub.row_id,sub.subject_code,sub.department_id,dept.name,sub.name as sub_name,sub.sub_type,sub.lab_status');
        $this->db->from($this->_table_name. ' as sub'); 
        $this->db->join('tbl_department as dept', 'sub.department_id = dept.dept_id');
        $this->db->where('sub.row_id', $row_id);
        $this->db->where('sub.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function addNewSubject($subInfo)
    {
        $this->db->trans_start();
        $this->db->insert($this->_table_name, $subInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id; 
    }

    
    public function checkSubjectCodeExists($sub_code, $row_id = 0){
        $this->db->select("subject_code");
        $this->db->from($this->_table_name);
        $this->db->where("subject_code", $sub_code);
        $this->db->where("is_deleted", 0);
        if($row_id != 0){
            $this->db->where("row_id !=", $row_id);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
   

    public function editSubject($subInfo, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update($this->_table_name, $subInfo);
        return true;
    }


    
    public function getAllSubjectByID($sub_code) {
        $this->db->select('sub.row_id,sub.subject_code,sub.department_id,dept.name,sub.name as sub_name,sub.sub_type,sub.lab_status');
        $this->db->from($this->_table_name. ' as sub'); 
        $this->db->join('tbl_department as dept', 'sub.department_id = dept.dept_id','left');
        $this->db->where('sub.subject_code', $sub_code);
        $this->db->where('sub.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getAllSubjectByIDResult($sub_code) {
        $this->db->select('sub.row_id,sub.subject_code,sub.department_id,dept.name,sub.name as sub_name,sub.sub_type,sub.lab_status');
        $this->db->from($this->_table_name. ' as sub'); 
        $this->db->join('tbl_department as dept', 'sub.department_id = dept.dept_id','left');
        $this->db->where('sub.subject_code', $sub_code);
        $this->db->where('sub.is_deleted', 0);
        $this->db->group_by('sub.subject_code');
        $query = $this->db->get();
        return $query->result();
    }

    
    public function getStaffSubjectsbyStaffId($staff_id){
        $this->db->select('sub.department_id, 
                            sub.name as sub_name, 
                            sub.lab_status,
                            sub.subject_code as subject_id,
                            ');
        $this->db->from('tbl_staff_teaching_subjects as staff_sub');
        $this->db->join($this->_table_name. ' as sub', 'sub.subject_code = staff_sub.subject_code');
        $this->db->where('staff_sub.subject_type !=', 'LAB');
        $this->db->where('staff_sub.staff_id', $staff_id);
        $this->db->where('sub.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    

    public function getSubjectInfoById($sub_id)
    {
        $this->db->from($this->_table_name. ' as sub');
        $this->db->where('sub.subject_code', $sub_id);
        $this->db->where('sub.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();    
    }

    
    public function getStaffSubjectName($filter=''){
        // $this->db->select('sub.department_id,sub.sub_name, sub.lab_status,sub.subject_code as subject_id');
        $this->db->from($this->_table_name. ' as sub');
        if(!empty($filter['staff_id'])){
            $this->db->join('tbl_staff_teaching_subjects as staff_sub', 'staff_sub.subject_code = sub.subject_code');
            $this->db->where('staff_sub.staff_id', $filter['staff_id']);
            $this->db->where('staff_sub.is_deleted', 0);
        } 
        $this->db->where('sub.is_deleted', 0);
        $this->db->group_by('sub.subject_code');
        $query = $this->db->get();
        return $query->result();
    }

    public function getStaffSubjectCodebyStaffId($staff_id){
        $this->db->select('sub.department_id, 
                            sub.name as sub_name, 
                            sub.lab_status,
                            sub.subject_code as subject_id,
                            ');
        $this->db->from('tbl_staff_teaching_subjects as staff_sub');
        $this->db->join($this->_table_name. ' as sub', 'sub.subject_code = staff_sub.subject_code');
        $this->db->where('staff_sub.subject_type !=', 'LAB');
        $this->db->where('staff_sub.staff_id', $staff_id);
        $this->db->where('staff_sub.is_deleted', 0);
        $this->db->where('sub.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getStudentSubjectInfo($subject_code){
        $this->db->select('sub.row_id,sub.subject_code,sub.department_id,sub.name as sub_name,sub.sub_type,sub.lab_status');
        $this->db->from($this->_table_name. ' as sub'); 
        $this->db->where_in('sub.subject_code', $subject_code);
        $this->db->where('sub.is_deleted',0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getSubjectInfo($subject_code){
        $this->db->select('sub.row_id,sub.subject_code,sub.department_id,sub.name as sub_name,sub.sub_type,sub.lab_status');
        $this->db->from($this->_table_name. ' as sub'); 
        $this->db->where('sub.subject_code', $subject_code);
        $this->db->where('sub.is_deleted',0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getSubjectsById($sub_code)
    {
        $this->db->select('sub.department_id, sub.name, sub.row_id, sub.subject_code,sub.sub_type, sub.lab_status, dept.name as department');
        $this->db->from($this->_table_name. ' as sub');
        $this->db->join('tbl_department as dept', 'sub.department_id = dept.dept_id');
        $this->db->where('sub.is_deleted', 0);
        $this->db->where('sub.subject_code', $sub_code);
        $query = $this->db->get();
        return $query->row();
    }

}
