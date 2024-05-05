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
        $this->db->where('staff.resignation_status', 0);
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
          //  $this->db->where('roleId !=', 1);
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
        $this->db->select('staff.doj, staff.gender, staff.dob, staff.type, staff.row_id, 
        staff.staff_id, staff.email, staff.name,dept.name as department, staff.mobile_one,staff.mobile, 
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
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.resignation_status',1);
        //  $this->db->where('staff.staff_type_id', 1);
        $query = $this->db->get();
        return $query->result();
    }
    function updateStaffSections($sectionInfo, $staff_id){
        $this->db->where('staff_id', $staff_id);
        $this->db->update('tbl_staff_sections', $sectionInfo);
        return TRUE;
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
        staff.email, staff.name,dept.name as department,
         staff.mobile, Role.role, staff.address,staff.dob');
        $this->db->from('tbl_staff as staff'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->where('staff.staff_id !=', '123456');
        $this->db->where('dept.is_deleted', 0);
        $this->db->where('staff.is_deleted', 0);
        $this->db->where('staff.resignation_status', 0);
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
      

        $query = $this->db->query("SELECT MIN(from_unixtime(sa.attendance_time)) as in_time, 
        MAX(from_unixtime(sa.attendance_time)) as out_time, staff.staff_id,
        sa.punch_time, staff.type, staff.row_id, staff.name,dept.name as department,
        staff.mobile,staff.mobile_two, role_.role, role_.roleId FROM 
        tbl_staff_attendance_info as sa, tbl_staff as staff, tbl_roles as role_,
        tbl_department as dept WHERE
        staff.staff_id = sa.staff_id AND
        
        role_.roleId = staff.role AND
       
        dept.dept_id = staff.department_id AND staff.is_deleted = 0 AND
        sa.staff_id = $staff_id AND
        sa.punch_date = '$date_today'
        GROUP BY staff.staff_id
       ");
        $result = $query->row();        
        return $result;
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
   
}