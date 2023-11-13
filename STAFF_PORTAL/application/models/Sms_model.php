<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
    class SMS_model extends CI_Model
    {
        
   public function getStudentListForSMSByRowID($student_id){
        $this->db->select('std.row_id,std.admission_no,std.student_name,std.dob,std.application_no,std.term_name,
        std.primary_mobile');
        $this->db->from('tbl_students_info as std');
        $this->db->where_in('std.row_id', $student_id);
        $this->db->where('std.is_deleted', 0);
        $this->db->where('std.is_active', 1);
        $query = $this->db->get();
        return $query->row();
        
    } 


    function addAbsentSMSInfo($absentInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_absent_sms_info', $absentInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    } 



    public function getSMSListReport($filter = '') {
        $this->db->select('log.application_no,
            log.mobile_number as mobile,
            log.sms_count,
            log.sent_date, 
            log.message, 
            log.status');
        $this->db->from('tbl_student_bulk_sms_log as log');
        
        if (!empty($filter['date_from'])) {
            $this->db->where('log.sent_date >=', $filter['date_from']);
        }
        if (!empty($filter['date_to'])) {
            $this->db->where('log.sent_date <=', $filter['date_to']);
        }
        $this->db->where('log.application_no', ' ');
        $this->db->order_by('log.sent_date','ASC');
        $query = $this->db->get();
        return $query->result();

    
    }

    function getSMSTemplates(){
        $this->db->select('template.row_id, template.name');
        $this->db->from('tbl_sms_templates as template');
        $this->db->where('template.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    function getSMSTemplateByID($id){
        $this->db->select('template.row_id, template.linked_header, template.name, template.reg_no, template.content');
        $this->db->from('tbl_sms_templates as template');
        $this->db->where('template.is_deleted', 0);
        $this->db->where('template.row_id', $id);
        return $this->db->get()->row();
    }

    function saveSMSLog($msg){
        $this->db->trans_start();
        $this->db->insert('tbl_student_bulk_sms_log', $msg);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function getStudentInfoForSMS($term_name,$stream_name,$section_name){
        $this->db->select('std.father_mobile, std.mother_mobile,std.row_id,std.student_id,std.application_no,std.primary_mobile,
        std.stream_name,std.student_name');
        $this->db->from('tbl_students_info as std');
       // $this->db->join('tbl_student_academic_info as acdmic', 'acdmic.application_no = std.application_no','left');
        
        $this->db->where_in('std.term_name', $term_name);
        if($stream_name != 'ALL'){
            $this->db->where_in('std.stream_name', $stream_name);
        }
        
        if($section_name != 'ALL'){
            $this->db->where_in('std.section_name', $section_name);
        }
        $this->db->where('std.is_active', 1);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
            
    }

    function getAllStaffInfoForSMSByDepartment($deptID){
        $this->db->select('staff.user_name, 
            staff.type, 
            staff.row_id,
            staff.staff_id,
          staff.mobile');
        $this->db->from('tbl_staff as staff'); 
        if(strtoupper($deptID) != "ALL"){
            $this->db->where('staff.department_id', $deptID);
        }
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getStudentListForSMS($student_id){
        $this->db->select('std.row_id,std.application_no,std.student_name,std.dob,std.term_name,std.student_id,
        std.stream_name,std.section_name,std.caste,std.father_mobile,std.mother_mobile,std.primary_mobile');
        $this->db->from('tbl_students_info as std');
        $this->db->where_in('std.student_id', $student_id);
        $this->db->where('std.is_active', 1);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
        
    }

    public function getSMSSentReportCount($filter) {
       
        $this->db->from('tbl_student_bulk_sms_log as log');
        $this->db->join('tbl_students_info as std', 'std.application_no = log.application_no','left');
       // $this->db->join('tbl_student_academic_info as acdmic', 'acdmic.application_no = std.application_no','left');
        if(!empty($filter['term_name'])){
            $this->db->where('std.term_name', $filter['term_name']);
        }
        if(!empty($filter['date_search'])){
            $this->db->where('log.sent_date', $filter['date_search']);
        }
        if(!empty($filter['mobile'])){
            $this->db->where('log.mobile_number', $filter['mobile']);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);
        }
        if(!empty($filter['by_name'])){
            $this->db->where('std.student_name', $filter['by_name']);
        }

        if(!empty($filter['by_stream'])){
            $this->db->where('std.stream_name', $filter['by_stream']);
        }

        if(!empty($filter['sms_count'])){
            $this->db->where('log.sms_count', $filter['sms_count']);
        }

        if(!empty($filter['message'])){
            $this->db->where('log.message', $filter['message']);
        }
       // $this->db->where('acdmic.is_deleted', 0);
        $this->db->where('std.is_active', 1);
        //$this->db->where('acdmic.is_current', 1);
        $this->db->where('std.is_deleted', 0);
        $this->db->order_by('log.sent_date','ASC');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getSMSSentReport($filter) {
        $this->db->select('std.term_name, 
        std.stream_name, 
        std.section_name, 
            std.student_id,
            std.student_name,
            log.application_no,
            log.mobile_number as mobile,
            log.sms_count,
            log.sent_date, 
            log.message, 
            log.status');
        $this->db->from('tbl_student_bulk_sms_log as log');
         $this->db->join('tbl_students_info as std', 'std.application_no = log.application_no','left');
        //$this->db->join('tbl_student_academic_info as acdmic', 'acdmic.application_no = std.application_no','left');
        if(!empty($filter['term_name'])){
            $this->db->where('std.term_name', $filter['term_name']);
        }
        if(!empty($filter['date_search'])){
            $this->db->where('log.sent_date', $filter['date_search']);
        }
        if(!empty($filter['mobile'])){
            $this->db->where('log.mobile_number', $filter['mobile']);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);
        }
        if(!empty($filter['by_name'])){
            $this->db->where('std.student_name', $filter['by_name']);
        }

        if(!empty($filter['by_stream'])){
            $this->db->where('std.stream_name', $filter['by_stream']);
        }

        if(!empty($filter['by_section'])){
            $this->db->where('std.section_name', $filter['by_section']);
        }

        if(!empty($filter['sms_count'])){
            $this->db->where('log.sms_count', $filter['sms_count']);
        }

        if(!empty($filter['message'])){
            $this->db->where('log.message', $filter['message']);
        }
        //$this->db->where('acdmic.is_deleted', 0);
        $this->db->where('std.is_active', 1);
       // $this->db->where('acdmic.is_current', 1);
        $this->db->where('std.is_deleted', 0);
        $this->db->order_by('log.sent_date','ASC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

}
?>