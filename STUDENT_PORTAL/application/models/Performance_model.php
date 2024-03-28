<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Performance_model extends CI_Model
{
    public function getSubjectInfo($subjectsCode){
        $this->db->from('tbl_subjects as sub');
        $this->db->where('sub.subject_code', $subjectsCode);
        $this->db->where('sub.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }


    public function getAllSubjectInfo($subjectsCode){
        $this->db->from('tbl_subjects as sub');
        $this->db->where('sub.subject_code', $subjectsCode);
        $this->db->where('sub.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getSubjectMarkInfo($student_id){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.name,sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.exam_year', '2020');
        $this->db->where('exam.office_validation_status', 1);
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    
    // get first internal exam mark
    public function getFirstInternaltMark($student_id,$subjects_code,$exam_year){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.name,sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_type', 'I_UNIT_TEST');
        $this->db->where('exam.exam_year', $exam_year);
        // $this->db->where('exam.office_validation_status', 1);
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getFirstTermMark($student_id,$subjects_code,$exam_year){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.name,sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_type', 'I_UNIT_TEST');
        $this->db->where('exam.exam_year', $exam_year);
        $this->db->where('exam.office_validation_status', 1);
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function getMidTermExamMark($student_id,$subjects_code,$exam_year){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.name,
        sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_type', 'MID_TERM_EXAM');
        $this->db->where('exam.exam_year', $exam_year);
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getSecondInternalMark($student_id,$subjects_code,$exam_year){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.name,sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_type', 'II_UNIT_TEST');
        $this->db->where('exam.exam_year', $exam_year);
        // $this->db->where('exam.office_validation_status', 1);
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    public function getFirstPreparatoryMark($student_id,$subjects_code,$exam_year){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.name,
        sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_type', 'I_PREPARATORY');
        $this->db->where('exam.exam_year', $exam_year);
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    function getStudentFinalExamMarkInfo($student_id) { 
        $this->db->select('exam.subject_code,exam.exam_id,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_year,exam.staff_updated_status,
        std.student_name,exam.student_id,std.father_name,std.mother_name,std.elective_sub,std.stream_name,std.pu_board_number');
        $this->db->from('tbl_students_info as std');
        $this->db->join('tbl_student_exams_marks as exam','exam.student_id = std.student_id');
        $this->db->where_in('exam.student_id', $student_id);
        $this->db->group_by('exam.subject_code');
        $this->db->where('std.is_deleted', 0);
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();    
    }

    
    // assignment and internal assessment mark
    public function getStudentAssignmentExamMarks($student_id,$subjects_code,$exam_type){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,
        sub.name,sub.sub_type,sub.lab_status');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where_in('exam.exam_type', $exam_type);
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    public function getFirstAnnualMark($student_id,$subjects_code,$exam_year){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.name,sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_type', 'ANNUAL_EXAMINATION');
        $this->db->where('exam.exam_year', $exam_year);
        $this->db->where('exam.office_validation_status', 1);
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }


    public function getAnnualExamMark($student_id,$subjects_code,$exam_year){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.name,sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_type', 'ANNUAL_EXAMINATION');
        $this->db->where('exam.exam_year', '2023-24');
        // $this->db->where('exam.office_validation_status', 1);
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
}
?>