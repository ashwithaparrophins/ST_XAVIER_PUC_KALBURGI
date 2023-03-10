<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Attendance_model extends CI_Model
{
    function getSubjectInfo($subject_id){
        $this->db->from("tbl_subjects as sub");
        $this->db->where('sub.subject_code',$subject_id);
        $query = $this->db->get();
        return $query->row();
    }

    function getTotalClassHeld($subject_id,$term_name,$section_name,$type,$batch_name,$absent_date_from,$attendance_date_to){
        $this->db->from('tbl_class_completed_by_staff as class');
        $this->db->where('class.subject_code',$subject_id);
        $this->db->where('class.class_year','2022');
        $this->db->where('class.term_name',$term_name);
        $this->db->where('class.section_name',$section_name);
        $this->db->where('class.subject_type',$type);
        $this->db->where('class.is_deleted',0);
        $this->db->where('class.date BETWEEN "'.$absent_date_from. '" and "'.$attendance_date_to.'"');
        if(!empty($batch_name)){
            $this->db->where('class.batch',$batch_name);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function getTotalClassCompletedDates($subject_id,$term_name,$section_name,$type,$batch_name,$absent_date_from,$attendance_date_to){
        $this->db->from('tbl_class_completed_by_staff as class');
        $this->db->where('class.subject_code',$subject_id);
        $this->db->where('class.class_year','2022');
        $this->db->where('class.term_name',$term_name);
        $this->db->where('class.section_name',$section_name);
        $this->db->where('class.subject_type',$type);
        $this->db->where('class.is_deleted',0);
        $this->db->where('class.date BETWEEN "'.$absent_date_from. '" and "'.$attendance_date_to.'"');
        if(!empty($batch_name)){
            $this->db->where('class.batch',$batch_name);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function getStudentAbsentCount($subject_id,$student_id,$absent_date_from,$attendance_date_to,$type){
        $sql="SELECT * FROM tbl_student_attendance_details as ab WHERE ab.student_id = '$student_id' AND ab.year = '2022' AND ab.absent_date BETWEEN '$absent_date_from' AND '$attendance_date_to' AND ab.is_deleted = 0 AND ab.staff_subject_row_id IN(SELECT sub.row_id FROM tbl_staff_teaching_subjects as sub WHERE sub.subject_code='$subject_id' AND sub.subject_type='$type' AND sub.is_deleted = 0)";    
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
}

