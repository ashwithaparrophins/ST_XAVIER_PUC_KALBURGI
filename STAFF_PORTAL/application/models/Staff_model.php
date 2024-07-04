<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Staff_model extends CI_Model
{

    function staffListingCount($filter)
    {
        $this->db->select('staff.row_id, staff.staff_id, staff.email, staff.name,dept.name as department, staff.mobile_one, Role.role, staff.address');
        $this->db->from('tbl_staff as staff'); 
        
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
       
        if(!empty($filter['by_role'])) {
            $this->db->where('staff.role', $filter['by_role']);
        }
        if(!empty($filter['by_dept'])) {
            $this->db->where('dept.dept_id', $filter['by_dept']);
        }
        
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('Role.roleId !=', '50');
        $this->db->where('staff.resignation_status', 0);
        $this->db->where('staff.retirement_status',0);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function staffListing($filter, $page, $segment,$role)
    {
        $this->db->select('staff.type, staff.blood_group, staff.row_id, staff.staff_id, 
        staff.email, staff.name,dept.name as department,
        staff.doj,
        staff.mobile_one, Role.role, staff.address');
        $this->db->from('employee as staff'); 
        $this->db->join('designation as Role', 'Role.id = staff.designation_id','left');
        $this->db->join('department as dept', 'dept.id = staff.department_id','left');
       
        if(!empty($filter['by_role'])) {
            $this->db->where('staff.role', $filter['by_role']);
        }
        if(!empty($filter['by_department'])) {
            $this->db->where('staff.department_id', $filter['by_department']);
        }
        if(!empty($filter['by_email'])) {
            $this->db->where('staff.email', $filter['by_email']);
        }
        if(!empty($filter['mobile'])) {
            $this->db->where('staff.mobile_one', $filter['mobile']);
        }
        if(!empty($filter['staff_name'])) {
            $like = "(staff.name  LIKE '%".$filter['staff_name']."%')";
            $this->db->where($like);
        }
        if(!empty($filter['staff_id'])) {
            $this->db->where('staff.staff_id', $filter['staff_id']);
        }
        $this->db->where('staff.is_deleted', 0);
        $this->db->order_by('staff.name', 'ASC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

        function getStaffRoles(){
            $this->db->select('roleId, role');
            $this->db->from('tbl_roles');
            $this->db->where('roleId !=', '50');
            $query = $this->db->get();
            return $query->result();
        }

        function getStaffRolesForStaff($staff_id)
        {
            $this->db->select('roleId, role');
            $this->db->from('tbl_roles');
            if($staff_id != '123456'){
            $this->db->where('roleId !=', 15);
            $this->db->where('roleId !=', 50);
            }
            $query = $this->db->get();
            return $query->result();
        }

        function addNewStaff($staffInfo){
            $this->db->trans_start();
            $this->db->insert('tbl_staff', $staffInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }

        // function addNewStaffSections($sectionInfo)
        // {
        //     $this->db->trans_start();
        //     $this->db->insert('tbl_staff_sections', $sectionInfo);
        //     $insert_id = $this->db->insert_id();
        //     $this->db->trans_complete();
        //     return $insert_id;
        // }

        function checkStaffIdExists($staff_id){
            $this->db->from('tbl_staff as staff');
            $this->db->where('staff.is_deleted', 0);
            $this->db->where('staff.staff_id', $staff_id);
            $query = $this->db->get();
            return $query->row();
        }
    public function getStaffInfoById($staff_id)
    {
        $this->db->select('staff.doj, staff.gender, staff.dob, staff.type, staff.row_id, staff.employee_id,staff.resignation_date,staff.retirement_date,staff.retired_date,
        staff.staff_id, staff.email, staff.name,dept.name as department, staff.mobile_one,staff.mobile, staff.tax_regime, staff.uan_no,staff.qualification,
        Role.role, staff.role as role_id, staff.photo_url, staff.address, staff.department_id,staff.voter_no,staff.pan_no,staff.aadhar_no,leave.casual_leave_earned,leave.sick_leave_earned,leave.marriage_leave_earned,leave.paternity_leave_earned,leave.maternity_leave_earned, leave.lop_leave,leave.casual_leave_used, leave.sick_leave_used, leave.marriage_leave_used,leave.paternity_leave_used, leave.maternity_leave_used,staff.blood_group');
        $this->db->from('tbl_staff as staff');
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_staff_sections as sec', 'staff.staff_id = sec.staff_id','left');
        $this->db->join('tbl_department as dept', 'staff.department_id = dept.dept_id','left');
        $this->db->join(' tbl_staff_leave_management as leave', 'staff.staff_id = leave.staff_id','left');
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('dept.is_deleted', 0);
        $this->db->where('staff.row_id', $staff_id);
        $query = $this->db->get();
        return $query->row();
    }
    function updateStaff($staffInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff', $staffInfo);
        return TRUE;
    }
    public function updateResignedDate(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('staff_id');
            $resigned_date = $this->input->post('resigned_date');
            $staffInfo = array('resignation_date' => date('Y-m-d',strtotime($resigned_date)),'updated_by'=>$this->staff_id);
            $result = $this->staff->updateStaff($staffInfo, $row_id);
            if($result == true) {
                $this->session->set_flashdata('success', 'Staff resignation info updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to modify staff resignation info');
            }
            redirect('staffDetailsResigned');
        } 
    }
    public function getResignedStaffInfo($filter='')
    {

        $this->db->select('staff.user_name, shift.name as shift_name, shift.shift_code, shift.start_time, shift.end_time, 
        staff.type, staff.row_id, staff.staff_id, staff.email,staff.staff_type_id, staff.name,dept.name as department, 
        staff.mobile_one, Role.role, staff.address,staff.dob,staff.resignation_date');
        $this->db->from('tbl_staff as staff'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
    //    $this->db->join('tbl_institution_type_info as inst', 'staff.staff_type_id = inst.institutionId','left');
       
       if(!empty($filter['staff_id'])){
            $this->db->where('staff.staff_id', $filter['staff_id']); 
        }
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('Role.roleId !=', '50');
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.resignation_status',1);
        //  $this->db->where('staff.staff_type_id', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function getRetiredStaffInfo($filter='')
    {

        $this->db->select('staff.user_name, shift.name as shift_name, shift.shift_code, shift.start_time, shift.end_time, 
        staff.type, staff.row_id, staff.staff_id, staff.email,staff.staff_type_id, staff.name,dept.name as department, 
        staff.mobile_one, Role.role, staff.address,staff.dob,staff.resignation_date,staff.retired_date');
        $this->db->from('tbl_staff as staff'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
    //    $this->db->join('tbl_institution_type_info as inst', 'staff.staff_type_id = inst.institutionId','left');
       
       if(!empty($filter['staff_id'])){
            $this->db->where('staff.staff_id', $filter['staff_id']); 
        }
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('Role.roleId !=', '50');
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.retirement_status',1);
        //  $this->db->where('staff.staff_type_id', 1);
        $query = $this->db->get();
        return $query->result();
    }

    public function getStaffDetails($filter='')
    {
        $this->db->select('staff.row_id, staff.staff_id, staff.email, staff.name,dept.name as department,
        staff.mobile_one, Role.role, staff.address');
        $this->db->from('tbl_staff as staff'); 
        
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
    
        if(!empty($filter['staff_id'])){
            $this->db->where('staff.staff_id', $filter['staff_id']); 
        }
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('Role.roleId !=', '50');
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    function updateStaffSections($sectionInfo, $staff_id){
        $this->db->where('staff_id', $staff_id);
        $this->db->update('tbl_staff_sections', $sectionInfo);
        return TRUE;
    } 

    public function getAllDocumentTypeInfo() {
        $this->db->from('tbl_document_type_info as doc');
        $this->db->where('doc.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllCurrentStaffInfo()
    {
        $this->db->select('staff.user_name, shift.name as shift_name, shift.shift_code, shift.start_time, shift.end_time, staff.type, staff.row_id, staff.staff_id, staff.email,staff.staff_type_id, staff.name,dept.name as department, staff.mobile_one, Role.role, staff.address,staff.role as role_id');
        $this->db->from('tbl_staff as staff'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('Role.roleId !=', '50');
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.resignation_status', 0); 
        $this->db->where('staff.retirement_status',0);
        $query = $this->db->get();
        return $query->result();
    }

     //get staff attendance 
     public function getAllStaffAttendanceFromModel($staff_id,$date){
        $this->db->select('att.punch_out_time as out_time, att.punch_time as in_time, att.punch_date,
        staff.doj, staff.gender, staff.dob, staff.type, att.row_id, 
        staff.staff_id, staff.email, staff.name,dept.name as department, staff.mobile_one, 
        leave.casual_leave_earned,leave.sick_leave_earned,leave.marriage_leave_earned,leave.paternity_leave_earned,
        leave.maternity_leave_earned, leave.lop_leave,
        leave.casual_leave_used, leave.sick_leave_used, leave.marriage_leave_used,leave.paternity_leave_used, leave.maternity_leave_used,
        shift.name as shift_name, shift.start_time, shift.end_time, shift.shift_code,
        Role.role, staff.role as role_id, staff.photo_url, staff.address, staff.department_id');
        $this->db->from('tbl_staff as staff');
        $this->db->join('tbl_staff_attendance_info as att', 'staff.staff_id = att.staff_id','left');
        $this->db->join('tbl_staff_leave_management as leave', 'staff.staff_id = leave.staff_id','left');
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
        $this->db->join('tbl_department as dept', 'staff.department_id = dept.dept_id','left');
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('att.is_deleted', 0);
        $this->db->where('att.staff_id', $staff_id);
        $this->db->where('att.punch_date', $date);
        $query = $this->db->get();
        return $query->row();
    }

    //add new staff attendance
public function addNewStaffAttendance($attInfo){
    $this->db->trans_start();
    $this->db->insert('tbl_staff_attendance_info', $attInfo);
    $insert_id = $this->db->insert_id();
    $this->db->trans_complete();
    return $insert_id;
}

public function getAllStaffAttendanceDisplay($staff_id,$date){
    $this->db->select('att.punch_out_time as out_time, att.punch_time as in_time, att.punch_date,
    staff.doj, staff.gender, staff.dob, staff.type, att.row_id, 
    staff.staff_id, staff.email, staff.name,dept.name as department, staff.mobile_one, 
    leave.casual_leave_earned,leave.sick_leave_earned,leave.marriage_leave_earned,leave.paternity_leave_earned,
    leave.maternity_leave_earned, leave.lop_leave,
    leave.casual_leave_used, leave.sick_leave_used, leave.marriage_leave_used,leave.paternity_leave_used, leave.maternity_leave_used,
    shift.name as shift_name, shift.start_time, shift.end_time, shift.shift_code,
    Role.role, staff.role as role_id, staff.photo_url, staff.address, staff.department_id');
    $this->db->from('tbl_staff as staff');
    $this->db->join('tbl_staff_attendance_info as att', 'staff.staff_id = att.staff_id','left');
    $this->db->join('tbl_staff_leave_management as leave', 'staff.staff_id = leave.staff_id','left');
    $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
    $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
    $this->db->join('tbl_department as dept', 'staff.department_id = dept.dept_id','left');
    $this->db->where('staff.is_deleted', 0);
    $this->db->where('att.is_deleted', 0);
    $this->db->where('att.row_id', $staff_id);
    $this->db->where('att.punch_date', $date);
    $query = $this->db->get();
    return $query->row();
}

public function getStaffAttendanceInfoByRowId($row_id){
    $this->db->select('att.punch_time, att.punch_out_time, att.punch_date,att.punch_out_date,
    staff.doj, staff.gender, staff.dob, staff.type, att.row_id, 
    staff.staff_id, staff.email, staff.name,dept.name as department, 
    shift.name as shift_name, shift.start_time, shift.end_time, shift.shift_code,
    Role.role, staff.role as role_id, staff.photo_url, staff.address, staff.department_id');
    $this->db->from('tbl_staff as staff');
    $this->db->join('tbl_staff_attendance_info as att', 'staff.staff_id = att.staff_id','left');
    $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
    $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
    $this->db->join('tbl_department as dept', 'staff.department_id = dept.dept_id','left');
    $this->db->where('staff.is_deleted', 0);
    $this->db->where('att.is_deleted', 0);
    $this->db->where('att.row_id', $row_id);
    $query = $this->db->get();
    return $query->row();
}

 
    public function getStaffInfoForProfile($staff_id)
    {
        $this->db->select('staff.doj, staff.gender, staff.dob, staff.type, staff.row_id,staff.blood_group, 
        staff.staff_id, staff.email, staff.name,dept.name as department, staff.mobile_one,staff.mobile,
        Role.role, staff.role as role_id, staff.photo_url, staff.address, staff.department_id');
        $this->db->from('tbl_staff as staff');
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_staff_sections as sec', 'staff.staff_id = sec.staff_id','left');
        $this->db->join('tbl_department as dept', 'staff.department_id = dept.dept_id','left');
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('dept.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getStaffByRoles($roleId){
        $this->db->from('tbl_roles as role');
        $this->db->where('role.role', $roleId);
        $query = $this->db->get();
        return $query->row();
    }
    public function getStaffByDepartment($department){
        $this->db->from('tbl_department as dept');
        $this->db->where('dept.name', $department);
        $this->db->where('dept.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    function checkStaffMobileNoExists($mobile_one){
        $this->db->from('tbl_staff as staff');
        $this->db->where('staff.mobile_one', $mobile_one);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function checkStaffIdExistsInBank($staff_id){
        $this->db->from('tbl_staff_bank_info as bank');
        $this->db->where_in('bank.staff_id', $staff_id);
        $this->db->where('bank.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    } 

    public function updateBankInfo($bankInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_bank_info', $bankInfo);
        return TRUE;
    }


    public function addBankInfo($bankInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_staff_bank_info', $bankInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getStaffBankById($staff_id){
        $this->db->from('tbl_staff_bank_info as bank');
        $this->db->where('bank.staff_id', $staff_id);
        $this->db->where('bank.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function addSalaryDetails($StaffInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_staff_salary_info', $StaffInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getSalaryInfoByStaffId($staff_id){
        $this->db->from('tbl_staff_salary_info as staff');
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where('staff.is_deleted', 0);
        $this->db->order_by('staff.row_id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function checkStaffDocumentInfo($staff_id,$row_id){
        $this->db->from('tbl_document_staff as edu'); 
        $this->db->where('edu.staff_id', $staff_id);
        $this->db->where('edu.row_id', $row_id);
        $this->db->where('edu.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function updateDocumentInfo($updatedocument,$staff_id,$row_id){
        $this->db->where('staff_id', $staff_id);
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_document_staff ',$updatedocument);
        return TRUE;
    }

    public function addDocumentInfo($document) {
        $this->db->trans_start();
        $this->db->insert('tbl_document_staff', $document);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getStaffdocumentById($staff_id){
        $this->db->from('tbl_document_staff as doc');
        $this->db->where('doc.staff_id', $staff_id);
        $this->db->where('doc.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    public function checkStaffEducationInfo($staff_id,$row_id){
        $this->db->from('tbl_staff_educational_info as edu'); 
        $this->db->where('edu.staff_id', $staff_id);
        $this->db->where('edu.row_id', $row_id);
        $this->db->where('edu.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function updateEducationInfo($educationDetails,$staff_id,$row_id){
        $this->db->where('staff_id', $staff_id);
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_educational_info', $educationDetails);
        return TRUE;
    }  

    public function addEducationInfo($educationInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_staff_educational_info', $educationInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getStaffEducationById($staff_id){
        $this->db->from('tbl_staff_educational_info as edu');
        $this->db->where('edu.staff_id', $staff_id);
        $this->db->where('edu.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    public function getStaffWorkExperienceInfo($staff_id){
        $this->db->from('tbl_staff_work_experience');
        $this->db->where('staff_id', $staff_id);
        $this->db->where('is_deleted', 0);
       $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    public function updateStaffWorkExperience($workDetails,$staff_id,$row_id){
        $this->db->where('staff_id', $staff_id);
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_work_experience', $workDetails);
        return TRUE;
    }
    
    function addStaffWorkExperience($workInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_staff_work_experience', $workInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function checkStaffWorkExperience($staff_id,$row_id){
        $this->db->from('tbl_staff_work_experience as edu'); 
        $this->db->where('edu.staff_id', $staff_id);
        $this->db->where('edu.row_id', $row_id);
        $this->db->where('edu.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function addStaffRemarks($remarkInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_staff_observation_info', $remarkInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    function updateStaffRemarks($remarksInfo, $row_id)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_observation_info', $remarksInfo);
        return TRUE;
    }

    public function getStaffObservationInfo($row_id){
        $this->db->select('info.row_id,info.description,info.file_path,info.date,info.staff_row_id,info.type,info.created_by,info.management_reply');
        $this->db->from('tbl_staff_observation_info as info');
        $this->db->join('tbl_staff as staff', 'staff.row_id = info.staff_row_id','left');
        $this->db->where('info.staff_row_id', $row_id);
        $this->db->where('info.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getCollegeDocumentsInfo($filter, $page, $segment)
    {
        $this->db->from('tbl_college_document as study'); 
        if(!empty($filter['searchText'])){
            $likeCriteria = "(study.document_name_url  LIKE '%" . $filter['searchText'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_date'])){
            $this->db->where('study.date', $filter['by_date']);
        }
        if(!empty($filter['by_expiry_date'])){
            $this->db->where('study.expiry_date', $filter['by_expiry_date']);
        }
        if(!empty($filter['by_year'])){
            $this->db->where('study.document_year', $filter['by_year']);
        }  
        if(!empty($filter['stream_name'])){
            $this->db->where('study.stream_name', $filter['stream_name']);
        } 
        if(!empty($filter['subject_name'])){
            $this->db->where('study.suject_name', $filter['suject_name']);
        } 
        if(!empty($filter['type'])){
            $this->db->where('study.type', $filter['type']);
        } 
        if(!empty($filter['doc_name'])){
            $likeCriteria = "(study.doc_name  LIKE '%" . $filter['doc_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_description'])){
            $likeCriteria = "(study.description  LIKE '%" . $filter['by_description'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['staff_id'])){
            $this->db->where('study.created_by', $filter['staff_id']);
        } 
        $this->db->where('study.is_deleted', 0);
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }


    public function getCollegeDocumentsInfoCount($filter)
    {
        $this->db->from('tbl_college_document as study'); 
        if(!empty($filter['searchText'])){
            $likeCriteria = "(study.document_name_url  LIKE '%" . $filter['searchText'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_date'])){
            $this->db->where('study.date', $filter['by_date']);
        }
        if(!empty($filter['by_expiry_date'])){
            $this->db->where('study.expiry_date', $filter['by_expiry_date']);
        }
        if(!empty($filter['by_year'])){
            $this->db->where('study.document_year', $filter['by_year']);
        } 
        if(!empty($filter['subject_name'])){
            $this->db->where('study.suject_name', $filter['suject_name']);
        } 
        if(!empty($filter['stream_name'])){
            $this->db->where('study.stream_name', $filter['stream_name']);
        } 
        if(!empty($filter['type'])){
            $this->db->where('study.type', $filter['type']);
        } 
        if(!empty($filter['doc_name'])){
            $likeCriteria = "(study.doc_name  LIKE '%" . $filter['doc_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_description'])){
            $likeCriteria = "(study.description  LIKE '%" . $filter['by_description'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['staff_id'])){

            $this->db->where('study.created_by', $filter['staff_id']);

        } 
        $this->db->where('study.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();

    }

    function addNewDocumentDetails($metInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_college_document', $metInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function updateDocumen($row_id, $studyInfo){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_college_document', $studyInfo);
        return $this->db->affected_rows();

    }


    //assign subject to staff
    function addStaffSubject($subInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_staff_teaching_subjects', $subInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getSubjectsByStaffId($staff_id)
    {
        $this->db->select('tstf.subject_id,sub.name,sub.sub_type,sub.lab_status,tstf.subject_type');
        $this->db->from('tbl_staff_teaching_subjects as tstf');
        $this->db->join('tbl_subjects as sub', 'sub.subject_code = tstf.subject_id','left');
        $this->db->where('tstf.is_deleted', 0);
        $this->db->where('tstf.staff_id', $staff_id);
        $query = $this->db->get();
        return $query->result();
    }


    public function deleteTeachingSubject($sub_code, $subInfo)
    {
        $this->db->where('subject_id', $sub_code);
        $this->db->update('tbl_staff_teaching_subjects', $subInfo);
        return $this->db->affected_rows();
    }

    // update class completed Info
    
    public function updateClassCompletedInfo($row_id, $classInfo)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_subjected_teached_by_staff', $classInfo);
        return $this->db->affected_rows();
    }

    public function getTeachinStaffInfo()
    {
        $this->db->from('tbl_staff as tstf');
        $this->db->where('tstf.is_deleted', 0);
        $this->db->where('tstf.role', 2);
        $query = $this->db->get();
        return $query->result();
    }

 
    //get staff info for download   
    function getStaffInfoForDownloadReport($role)
    {
        $this->db->select('staff.type, staff.row_id, staff.staff_id, staff.email, staff.name,dept.name as department, staff.mobile_one, Role.role, staff.address');
        $this->db->from('tbl_staff as staff'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');

        if($role != 'ALL'){
            $this->db->where('staff.role', $role);
        }

        $this->db->where('staff.is_deleted', 0);
        $this->db->order_by('staff.staff_id', 'ASC');
    
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    } 

    //getting all staff info

    public function getAllStaffInfo()
    {
        $this->db->select('staff.type, staff.row_id, staff.staff_id, 
        staff.email, staff.name,dept.name as department,staff.employee_id,
         staff.mobile, Role.role, staff.address,staff.dob');
        $this->db->from('tbl_staff as staff'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('Role.roleId !=', '50');
        $this->db->where('dept.is_deleted', 0);
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.resignation_status', 0);
        $this->db->where('staff.retirement_status',0);
        $query = $this->db->get();
        return $query->result();
    }


    public function getAllStaffInfoByDeptId($dept_id)
    {
        $this->db->select('
          staff.type, staff.row_id, staff.staff_id, 
          staff.email, staff.name,dept.name as department,
           staff.mobile_one, Role.roleId, Role.role, staff.address');
        $this->db->from('tbl_staff as staff'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
      //  $this->db->join('tbl_staff_shift_info as shift', 'staff.shift_code = shift.shift_code','left');
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('Role.roleId !=', '50');
        $this->db->where('staff.department_id', $dept_id);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }


    function getStaffDepartment(){
        $this->db->select('id, name, dept_id');
        $this->db->from('tbl_department');
        // $this->db->where('dept_id !=', 22);
       // $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    } 

    function getStaffDepartmentById($dept_id){
        $this->db->select('dept.id, dept.name, dept.dept_id');
        $this->db->from('tbl_department as dept');
        $this->db->where('dept.dept_id', $dept_id);
        $query = $this->db->get();
        return $query->result();
    }

    function getStaffShifts(){
        $this->db->select('shift_code, name, start_time, end_time');
        $this->db->from('tbl_staff_shift_info as shift');
        $this->db->where('shift.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function addNewStaffSubject($staffSubjectInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_staff_teaching_subjects', $staffSubjectInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function addStaffSection($staffSectionInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_staff_sections', $staffSectionInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function getSectionByStaffId($staff_id){
        $this->db->select('section.stream_id,stream.stream_name,section.term_name,section.section_name,staff.row_id,staff.staff_id');
        $this->db->from('tbl_section_info as section');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id','left');
        $this->db->join('tbl_staff_sections as staff', 'staff.section_id = section.row_id','left');
        $this->db->where('staff.staff_id', $staff_id);
        // $this->db->where('section.year', 2021);
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('stream.is_deleted', 0);
        $this->db->where('section.is_deleted', 0);
        $this->db->order_by('stream.row_id','asc');
        $this->db->order_by('section.term_name','asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllSubjectByStaffId($staff_id){
        $this->db->select('staff.row_id,sub.subject_code,
        sub.department_id,sub.name as sub_name,sub.sub_type,sub.lab_status,
        staff.subject_type,staff.staff_id,dept.name');
        $this->db->from('tbl_subjects as sub');
        $this->db->join('tbl_staff_teaching_subjects as staff', 'staff.subject_code = sub.subject_code','left'); 
        $this->db->join('tbl_department as dept', 'sub.department_id = dept.dept_id','left');
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('dept.is_deleted', 0);
        $this->db->where('sub.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function updateStaffSubject($subjectInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_teaching_subjects', $subjectInfo);
        return TRUE;
    }
    
    public function updateStaffclass($classInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_sections', $classInfo);
        return TRUE;
    }
    
    function checkClassExists($staff_id,$section_id){
        $this->db->from('tbl_staff_sections as staff');
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where('staff.section_id', $section_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function deleteStaffById($row_id){
        $this->db->where('row_id', $row_id);
        $this->db->delete('tbl_staff');
    }

    public function checkSubjectTypeExists($staff_id,$subject_code,$subjectType) {
        $this->db->from('tbl_staff_teaching_subjects as sub');
        $this->db->where('sub.is_deleted', 0);
        $this->db->where('sub.staff_id', $staff_id);
        $this->db->where('sub.subject_code', $subject_code);
        $this->db->where('sub.subject_type', $subjectType);
        $query = $this->db->get();
        return $query->row();
    }

    
    public function getAllTeachingStaff() {
        $this->db->select('staff.type, staff.row_id, staff.staff_id, staff.email, staff.name,dept.name as department, staff.mobile_one, Role.role, staff.address');
        $this->db->from('tbl_staff as staff'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
     //   $this->db->where('staff.role', '2');
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('Role.roleId !=', '50');
        $this->db->where('dept.is_deleted', 0);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    //add dashboard news feed
    public function addNewsFeed($newsInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_news_feed', $newsInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    
    public function addNewsFeedVisibleType($roleInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_news_feed_role_mngt', $roleInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function updateNewsInfo($newsInfo, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_news_feed', $newsInfo);
        return TRUE;
    }
    public function updateNewsRoleInfo($roleInfo, $row_id){
        $this->db->where('rel_news_row_id ', $row_id);
        $this->db->update('tbl_news_feed_role_mngt', $roleInfo);
        return TRUE;
    }
    
    // get news feed information
    public function getNewsFeed($filter) {
        $this->db->select('news.row_id,news.subject,news.description,news.term_name,news.date,news.stream_name,
        news.photo_url');
        $this->db->from('tbl_news_feed as news'); 
        $this->db->join('tbl_news_feed_role_mngt as role', 'role.rel_news_row_id = news.row_id','right');
        
        if(!empty($filter['role']) || !empty($filter['role_one'])){
        $this->db->where_in('role.visible_type',array($filter['role'], $filter['role_one']));
        }
        $this->db->where('news.is_deleted', 0);
        $this->db->where('role.is_deleted', 0);
        $this->db->order_by('news.date', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }
    public function getNewsFeedCount($filter) {
        $this->db->select('news.row_id,news.subject,news.description,news.term_name,news.date,news.stream_name,
        news.photo_url');
        $this->db->from('tbl_news_feed as news'); 
        $this->db->join('tbl_news_feed_role_mngt as role', 'role.rel_news_row_id = news.row_id','right');
        
        if(!empty($filter['role']) || !empty($filter['role_one'])){
        $this->db->where_in('role.visible_type',array($filter['role'], $filter['role_one']));
        }
        $this->db->where('news.is_deleted', 0);
        $this->db->where('role.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function newsFeedLike($newsid,$userid){
        $this->db->select('likes.row_id');
        $this->db->from('tbl_news_feed_likes likes');
        $this->db->where('likes.user_id',$userid);
        $this->db->where('likes.news_feed_id',$newsid);
        $query = $this->db->get();
        if($query->num_rows()==0){
            $this->db->trans_start();
            $this->db->insert('tbl_news_feed_likes', array('user_id'=>$userid,'news_feed_id'=>$newsid));
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }
    }
    public function newsFeedDisLike($newsid,$userid){
        $this->db->where('user_id',$userid);
        $this->db->where('news_feed_id',$newsid);
        $this->db->delete('tbl_news_feed_likes');
        return $this->db->affected_rows();
    }
    public function isLiked($newsid,$userid){
        $this->db->select('likes.row_id');
        $this->db->from('tbl_news_feed_likes likes');
        $this->db->where('likes.user_id',$userid);
        $this->db->where('likes.news_feed_id',$newsid);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function totalLikes($newsid){
        $this->db->select('likes.row_id');
        $this->db->from('tbl_news_feed_likes likes');
        $this->db->where('likes.news_feed_id',$newsid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getAllSubjectInfo($filter=''){
        $this->db->select('teaching.row_id,sub.subject_code,sub.department_id,sub.name as sub_name,sub.sub_type,sub.lab_status,
        teaching.subject_type,teaching.staff_id,dept.name,staff.name as staff_name');
        $this->db->from('tbl_subjects as sub');
        $this->db->join('tbl_staff_teaching_subjects as teaching', 'teaching.subject_code = sub.subject_code','left'); 
        $this->db->join('tbl_staff as staff', 'staff.staff_id = teaching.staff_id','left'); 
        $this->db->join('tbl_department as dept', 'sub.department_id = dept.dept_id','left');
        if(!empty($filter['staff_id'])){
            $this->db->where('teaching.staff_id', $filter['staff_id']);
        }
       // $this->db->where('teaching.intake_year', CURRENT_YEAR);
        $this->db->where('teaching.is_deleted', 0);
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('dept.is_deleted', 0);
        $this->db->where('sub.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    // get stream and section details
    public function getSectionById($filter=''){
        $this->db->select('section.row_id,section.stream_id,stream.stream_name,section.section_name,section.class_type,
        section.class_teacher,section.term_name');
        $this->db->from('tbl_section_info as section');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id','left');
        $this->db->join('tbl_staff_sections as staff', 'staff.section_id = section.row_id','left');
        if(!empty($filter['term_name'])){
            $this->db->where('section.term_name', $filter['term_name']);
        }
        if(!empty($filter['staff_id'])){
            $this->db->where('staff.staff_id', $filter['staff_id']);
        }
        $this->db->order_by('stream.row_id','asc');
        $this->db->order_by('section.section_name','asc');
        $this->db->group_by('section.term_name,stream.stream_name,section.section_name');
        // $this->db->where('section.year', 2021);
        $this->db->where('section.is_deleted', 0);
        $this->db->where('stream.is_deleted', 0);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    // get stream and section details
    public function getStaffSectionByTerm($filter=''){
        $this->db->select('section.row_id,section.stream_id,stream.stream_name,section.section_name,section.class_type,
        section.class_teacher,section.term_name');
        $this->db->from('tbl_section_info as section');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id','left');
        $this->db->join('tbl_staff_sections as staff', 'staff.section_id = section.row_id','left');
        if(!empty($filter['term_name'])){
            $this->db->where('section.term_name', $filter['term_name']);
        }
        $this->db->order_by('stream.row_id','asc');
        $this->db->order_by('section.section_name','asc');
        $this->db->group_by('stream.stream_name');
        // $this->db->where('section.year', 2021);
        $this->db->where('section.is_deleted', 0);
        $this->db->where('stream.is_deleted', 0);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getDistinctSubjectInfo($filter=''){
        $this->db->select('teaching.row_id,sub.subject_code,sub.department_id,sub.name as sub_name,sub.sub_type,sub.lab_status,
        teaching.subject_type,teaching.staff_id,dept.name,staff.name as staff_name');
        $this->db->from('tbl_subjects as sub');
        $this->db->join('tbl_staff_teaching_subjects as teaching', 'teaching.subject_code = sub.subject_code','left'); 
        $this->db->join('tbl_staff as staff', 'staff.staff_id = teaching.staff_id','left'); 
        $this->db->join('tbl_department as dept', 'sub.department_id = dept.dept_id','left');
        if(!empty($filter['staff_id'])){
            $this->db->where('teaching.staff_id', $filter['staff_id']);
        }
        $this->db->where('teaching.is_deleted', 0);
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('dept.is_deleted', 0);
        $this->db->where('sub.is_deleted', 0);
        $this->db->group_by('staff.staff_id');
        $query = $this->db->get();
        return $query->result();
    }

    public function getStaffSubjectSectionByStaffId($staff_id){
        $this->db->select('section.stream_id,stream.stream_name,section.term_name,section.section_name,staff.row_id,staff.staff_id');
        $this->db->from('tbl_section_info as section');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id','right');
        $this->db->join('tbl_staff_sections as staff', 'staff.section_id = section.row_id','right');
        // $this->db->join('tbl_staff_teaching_subjects as sub', 'sub.staff_id = staff.staff_id','right'); 
        $this->db->where('staff.staff_id', $staff_id);
        // $this->db->where('section.year', 2021);
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('stream.is_deleted', 0);
        $this->db->where('section.is_deleted', 0);
        // $this->db->where('staff.is_deleted', 0);
        $this->db->order_by('stream.row_id','asc');
        $this->db->order_by('section.term_name','asc');
        $this->db->group_by('section.row_id');
        $query = $this->db->get();
        return $query->result();
    }

    public function geStaffClassCompletetedCount($staff_id,$term_name,$section_name,$stream_name){
        $this->db->from('tbl_class_completed_by_staff as class');
        $this->db->where('class.staff_id', $staff_id);
        // $this->db->where_in('class.subject_code', $subject_code);
        $this->db->where('class.term_name', $term_name);
        $this->db->where('class.section_name', $section_name);
        $this->db->where('class.stream_name', $stream_name);
        $this->db->where('class.class_year', 2023);
        $this->db->where('class.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getStaffAttendanceInfoAllStaff($filter){
        $custom_query = "";
        
        // if(!empty($filter['staff_name'])) {
        //     $custom_query .= "staff.name LIKE '%".$filter['staff_name']."%' AND ";
        // }
         
        // if(!empty($filter['staff_id'])) {
        //     $custom_query .= "sa.staff_id = '".$filter['staff_id']."' AND ";
        // }

        // if(!empty($filter['by_department'])) {
        //     $custom_query .= "staff.department_id = '".$filter['by_department']."' AND ";
        // }

        // if(!empty($filter['by_role'])) {
        //     $custom_query .= "staff.role = '".$filter['by_role']."' AND ";
        // }
        // if(!empty($filter['in_time'])) {
        //     $custom_query .= "sa.punch_time LIKE '%".$filter['in_time']."%' AND ";
        // }

        $date_search = $filter['by_date'];
        $staff_id = $filter['staff_id'];
        $query = $this->db->query("SELECT MIN(from_unixtime(sa.attendance_time)) as in_time, 
        MAX(from_unixtime(sa.attendance_time)) as out_time, staff.staff_id,
        sa.punch_time, staff.type, staff.row_id, staff.name,dept.name as department, staff.mobile,staff.mobile_two, role_.role, role_.roleId FROM 
        tbl_staff_attendance_info as sa, tbl_staff as staff, tbl_roles as role_,
        tbl_department as dept WHERE
        staff.staff_id = sa.staff_id AND
        staff.test_account_status = 0 AND
        role_.roleId = staff.role AND
        staff.test_account_status = 0 AND
        dept.dept_id = staff.department_id AND staff.is_deleted = 0 AND
        sa.staff_id = $staff_id AND
        sa.punch_date = '$date_search'
        GROUP BY staff.staff_id
       ");
        $result = $query->row();        
        return $result;
    }

    public function getStaffAttendanceNotFound($filter){
        $custom_query = "";
        
        if(!empty($filter['staff_name'])) {
            $custom_query .= "staff.name LIKE '%".$filter['staff_name']."%' AND ";
        }
        
        if(!empty($filter['staff_id'])) {
            $custom_query .= "staff.staff_id = '".$filter['staff_id']."' AND ";
        }

        if(!empty($filter['by_department'])) {
            $custom_query .= "staff.department_id = '".$filter['by_department']."' AND ";
        }

        if(!empty($filter['by_role'])) {
            $custom_query .= "staff.role = '".$filter['by_role']."' AND ";
        }
        

        $date_search = $filter['by_date'];
        $query = $this->db->query("SELECT staff.staff_id, staff.type, staff.row_id, staff.name,dept.name as department, staff.mobile,staff.mobile_two, role_.role, role_.roleId FROM 
        tbl_staff as staff, tbl_roles as role_,
        tbl_department as dept WHERE
        role_.roleId = staff.role AND
        staff.test_account_status = 0 AND
        dept.dept_id = staff.department_id AND staff.is_deleted = 0 AND
        ".$custom_query."
        staff.staff_id NOT IN(SELECT staff_id FROM tbl_staff_attendance_info WHERE punch_date = '$date_search')  
        ");
        $result = $query->result();        
        return $result;
    }

     //get single staff attandance
     public function getSingleStaffAttendanceInfo($staff_id,$date_today){
        $query = $this->db->query("SELECT sa.punch_time as in_time, sa.punch_out_time as out_time, staff.staff_id,
            sa.punch_date, sa.punch_time, staff.type, staff.row_id, staff.name,dept.name as department, staff.mobile_one, role_.role, role_.roleId
             FROM 
            tbl_staff_attendance_info as sa, tbl_staff as staff, tbl_roles as role_,
            tbl_department as dept
            WHERE
            staff.staff_id = sa.staff_id AND
            role_.roleId = staff.role AND
            dept.dept_id = staff.department_id AND staff.is_deleted = 0 AND sa.is_deleted = 0 AND
            sa.staff_id = '$staff_id' AND
            sa.punch_date = '$date_today'");
            return $query->row();
    }

    public function getPunchDateByStaffId($staff_id){
        $this->db->select('DISTINCT(punch_date) as punch_date');
        $this->db->from('tbl_staff_attendance_info as staff_att'); 
        $this->db->where('staff_att.staff_id', $staff_id);
        $this->db->where('staff_att.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getStaffInfoForReportDownload($filter=''){
        $this->db->select('staff.row_id, staff.staff_id, staff.email, staff.dob, staff.doj, staff.blood_group, staff.present_address, 
        staff.voter_no, staff.aadhar_no, staff.pan_no, staff.name,dept.name as department, staff.mobile, Role.role, 
        staff.permanent_address, staff.family_contact_no, staff.native_place, staff.mother_tongue, staff.religion, staff.caste');
        $this->db->from('tbl_staff as staff'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        // $this->db->join('tbl_institution_type_info as inst', 'staff.staff_type_id = inst.institutionId','left');
          if(!empty($filter['staff_role'])) {
            $this->db->where('staff.role', $filter['staff_role']);
        }
        if(!empty($filter['staff_department'])) {
            $this->db->where('staff.department_id', $filter['staff_department']);
        }
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('Role.roleId !=', '50');
        $this->db->where('staff.resignation_status', 0);
        //  $this->db->where('staff.staff_type_id', 1);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    
    public function getStaffRoleByName($filter){
        $this->db->from('tbl_roles as role');
        $this->db->where('role.roleId', $filter['staff_role']);
        $query = $this->db->get();
        return $query->row();
    }

    //deleted staff Info
    public function getDeletedAllStaffInfo(){
        $this->db->select('staff.type, staff.row_id, staff.staff_id, 
        staff.email, staff.name,dept.name as department,
         staff.mobile, Role.role, staff.address');
        $this->db->from('tbl_staff as staff'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('Role.roleId !=', '50');
        $this->db->where('dept.is_deleted', 0);
        $this->db->where('staff.is_deleted', 1);
        $query = $this->db->get();
        return $query->result();
    }

    function getStaffBirthdayInfoById($staff_id){
        $this->db->select('staff.user_name, staff.doj, staff.gender, staff.dob, staff.type, staff.row_id, 
           staff.staff_id, staff.email, staff.name, staff.mobile, 
           Role.role, staff.role as role_id, staff.photo_url, staff.address, staff.department_id,staff.aadhar_no,staff.voter_no,
           staff.pan_no,staff.blood_group');
           $this->db->from('tbl_staff as staff');
           $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
           $this->db->where_in('staff.staff_id', $staff_id); 
           $this->db->where('staff.is_deleted', 0);
           $query = $this->db->get();
           return $query->result();
       }

       public function getDistinctStaffClassInfo($staff_id){
        $this->db->select('section.stream_id,stream.stream_name,section.term_name,section.section_name,staff.row_id,staff.staff_id');
        $this->db->from('tbl_section_info as section');
        $this->db->join('tbl_stream_info as stream', 'stream.row_id = section.stream_id','right');
        $this->db->join('tbl_staff_sections as staff', 'staff.section_id = section.row_id','right');
        $this->db->where('staff.staff_id', $staff_id);
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('stream.is_deleted', 0);
        $this->db->order_by('stream.row_id','asc');
        $this->db->order_by('section.term_name','asc');
        $this->db->group_by('section.row_id');
        $query = $this->db->get();
        return $query->result();
    }


    public function getStaffId($row_id){
        $this->db->select('staff.row_id,staff.staff_id,staff.name as staff_name,dept.name,Role.role');
          $this->db->from('tbl_staff as staff'); 
          $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
          $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
          $this->db->where_in('staff.staff_id', $row_id);
          $this->db->where('staff.is_deleted', 0);
          $this->db->where('dept.is_deleted', 0);
         // $this->db->order_by('student.register_no', 'ASC');
          $query = $this->db->get();
          return $query->row();
      }
      public function updateStaffAttendanceByID($row_id, $attInfo){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_attendance_info', $attInfo);
        return TRUE;
    }
   
    public function getAllStaffInfoByDeptName($dept_id)
    {
        $this->db->select('staff.user_name,staff.type, staff.row_id, staff.staff_id, staff.email, staff.name,dept.name as department, staff.mobile_one, Role.roleId, Role.role, staff.address');
        $this->db->from('tbl_staff as staff'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('Role.roleId !=', '50');
        $this->db->where('staff.department_id', $dept_id);
        $this->db->where('staff.resignation_status', 0);
        $this->db->where('staff.retirement_status',0);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    function getStaffAllDepartmentInfoForReport(){
        $this->db->select('id, name, dept_id');
        $this->db->from('tbl_department');
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllStaffInfoByDeptIdReport($dept_id,$staff_id = 'ALL') {
        $this->db->select('staff.user_name, staff.type, staff.row_id, staff.staff_id, staff.email, staff.name,dept.name as department, staff.mobile_one, Role.roleId, Role.role, staff.address');
        $this->db->from('tbl_staff as staff'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('Role.roleId !=', '50');
        $this->db->where('staff.department_id', $dept_id);
        if($staff_id != 'ALL'){
            $this->db->where('staff.staff_id', $staff_id);
        }
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.resignation_status', 0);
        $this->db->where('staff.retirement_status',0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getStaffAttendanceByRowId($row_id){
        $this->db->from('tbl_staff_attendance_info as att');
        $this->db->where('att.row_id', $row_id);
        $this->db->where('att.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

     //delete staff attendance info 
     public function deleteStaffAttendanceInfo($staff_id, $punch_date, $attInfo){
        $this->db->where('punch_date', $punch_date);
        $this->db->where('staff_id', $staff_id);
        $this->db->update('tbl_staff_attendance_info', $attInfo);
        return TRUE;
    }


    
    // public function getPreviousEmployeeIdInfo(){
    //     $this->db->from('tbl_staff as staff');
    //     $this->db->where('staff.is_deleted', 0);
    //     $this->db->where('staff.employee_id!=', '');
    //     $this->db->order_by('staff.employee_id', 'DESC');
    //     $this->db->limit(1);
    //     $query = $this->db->get();
    //     return $query->row();   
    // }

    // public function getPreviousEmployeeIdInfo() {
    //     // Custom SQL query to order by last three digits of employee_id after the 9th place
    //     $sql = "
    //         SELECT * FROM (
    //             SELECT staff.*, SUBSTRING(staff.employee_id, -3) AS last_three_digits,
    //                 ROW_NUMBER() OVER (ORDER BY staff.employee_id DESC) AS row_num
    //             FROM tbl_staff AS staff
    //             WHERE staff.is_deleted = 0
    //             AND staff.employee_id != ''
    //         ) AS subquery
    //         ORDER BY
    //             CASE
    //                 WHEN row_num > 9 THEN last_three_digits
    //                 ELSE employee_id
    //             END DESC
    //         LIMIT 1
    //     ";
    
    //     // Execute the query
    //     $query = $this->db->query($sql);
    
    //     // Return the first row of the result
    //     return $query->row();
    // }
    
       public function getPreviousEmployeeIdInfo(){
            $this->db->from('tbl_staff as staff'); 
            $this->db->where('staff.employee_id!=', "");
            $this->db->where('staff.employee_id!=', "0");
            $this->db->where('staff.is_deleted', 0);
            $query = $this->db->get();
            return $query->result();
        }

    function checkStaffEmployeeIdExists($staff_id){
        $this->db->from('tbl_staff as staff');
        $this->db->where('staff.row_id', $staff_id);
        $this->db->where('staff.employee_id!=', '');
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }


    public function getCheckStaffId($staff_id){
        $this->db->from('tbl_staff as staff'); 
        $this->db->where('staff.row_id', $staff_id);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

//get role for admin api
public function getStaffByRole($filter) {
    $this->db->select('name,mobile_one,mobile_two');
    $this->db->from('tbl_staff');
    $this->db->where($filter);
    $this->db->where('name !=', '123456'); // Exclude staff with name '123456'
    $this->db->where('staff_id !=', 123456); // Exclude staff with staff_id '123456'
    $this->db->where('is_deleted', 0); // Add this line
    $this->db->where('retirement_status', 0); // Add this line
    $this->db->where('resignation_status', 0); // Add this line
    
    $query = $this->db->get();

    $result = $query->result();
    return $result;
}

    public function getResignedStaffCount() {
        $this->db->from('tbl_staff');
        $this->db->where('is_deleted', 0);
        $this->db->where('resignation_status', 1);
        
        $count = $this->db->count_all_results();
        return $count;
    }

   


}