<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class students_model extends CI_Model
{

    public function getAllstudentInfo($filter,$student){
        $this->db->select('student.row_id,student.blood_group,student.student_no,student.application_no,student.register_no, 
        student.student_id,student.hall_ticket_no,student.student_name,student.elective_sub,student.dob,student.mobile,student.email,
        student.date_of_admission,student.roll_number,student.gender,student.student_status,student.residential_address,
        student.pu_board_number,student.category,student.last_board_name,student.present_address,student.permanent_address,
        student.father_name,student.father_mobile,student.mother_name,student.mother_mobile,student.program_name,student.stream_name,
        student.intake_year,student.term_name,student.section_name,student.elective_sub');
        $this->db->from('tbl_students_info as student'); 
        // $this->db->join('tbl_student_academic_info as academic', 'student.application_no = student.application_no');
            
        if(!empty($filter['student_id'])){
            $likeCriteria = "(student.student_id  LIKE '%" . $filter['student_id'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['application_no'])){
            $this->db->where('student.application_no', $filter['application_no']);
        }
        if(!empty($filter['by_name'])){
            $likeCriteria = "(student.student_name  LIKE '%" . $filter['by_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_term'])){
            $this->db->where('student.term_name', $filter['by_term']);
        }
        if(!empty($filter['by_stream'])){
            $this->db->where('student.stream_name', $filter['by_stream']);
        }
        if(!empty($filter['by_Section'])){
            $this->db->where('student.section_name', $filter['by_Section']);
        }
        if(!empty($filter['by_elective'])){
            $this->db->where('student.elective_sub', $filter['by_elective']);
        }
        if(!empty($student)){
            $this->db->where_in('student.row_id', $student);
        }
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.is_active', 1);
        $this->db->order_by('student.student_id', 'ASC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllstudentInfoCount($filter,$student){
        $this->db->from('tbl_students_info as student'); 
        // $this->db->join('tbl_student_academic_info as academic', 'student.application_no = student.application_no');
            
        if(!empty($filter['student_id'])){
            $likeCriteria = "(student.student_id  LIKE '%" . $filter['student_id'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['application_no'])){
            $this->db->where('student.application_no', $filter['application_no']);
        }
        if(!empty($filter['by_name'])){
            $likeCriteria = "(student.student_name  LIKE '%" . $filter['by_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_term'])){
            $this->db->where('student.term_name', $filter['by_term']);
        }
        if(!empty($filter['by_stream'])){
            $this->db->where('student.stream_name', $filter['by_stream']);
        }
        if(!empty($filter['by_Section'])){
            $this->db->where('student.section_name', $filter['by_Section']);
        }
        if(!empty($filter['by_elective'])){
            $this->db->where('student.elective_sub', $filter['by_elective']);
        }
        if(!empty($student)){
            $this->db->where_in('student.row_id', $student);
        }
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.is_active', 1);
        // $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    
    public function getAlumniStudentInfo($filter){
        $this->db->select('student.row_id,student.blood_group,student.student_no,student.application_no,student.register_no, 
        student.student_id,student.hall_ticket_no,student.student_name,student.elective_sub,student.dob,student.mobile,student.email,
        student.date_of_admission,student.roll_number,student.gender,student.student_status,student.residential_address,
        student.pu_board_number,student.category,student.last_board_name,student.present_address,student.permanent_address,
        student.father_name,student.father_mobile,student.mother_name,student.mother_mobile,student.program_name,student.stream_name,
        student.intake_year,student.term_name,student.section_name');
        $this->db->from('tbl_students_info as student'); 
        // $this->db->join('tbl_student_academic_info as academic', 'student.application_no = student.application_no');
            
        if(!empty($filter['student_id'])){
            $likeCriteria = "(student.student_id  LIKE '%" . $filter['student_id'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['application_no'])){
            $this->db->where('student.application_no', $filter['application_no']);
        }
        if(!empty($filter['by_name'])){
            $likeCriteria = "(student.student_name  LIKE '%" . $filter['by_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_term'])){
            $this->db->where('student.term_name', $filter['by_term']);
        }
        if(!empty($filter['by_stream'])){
            $this->db->where('student.stream_name', $filter['by_stream']);
        }
        if(!empty($filter['by_Section'])){
            $this->db->where('student.section_name', $filter['by_Section']);
        }
        $this->db->where('student.is_deleted', 0); 
        $this->db->where('student.is_active', 0);
        $this->db->order_by('student.student_id', 'ASC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }
    public function getAlumniStudentCount($filter){
        $this->db->from('tbl_students_info as student'); 
        // $this->db->join('tbl_student_academic_info as academic', 'student.application_no = student.application_no');
            
        if(!empty($filter['student_id'])){
            $likeCriteria = "(student.student_id  LIKE '%" . $filter['student_id'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['application_no'])){
            $this->db->where('student.application_no', $filter['application_no']);
        }
        if(!empty($filter['by_name'])){
            $likeCriteria = "(student.student_name  LIKE '%" . $filter['by_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_term'])){
            $this->db->where('student.term_name', $filter['by_term']);
        }
        if(!empty($filter['by_stream'])){
            $this->db->where('student.stream_name', $filter['by_stream']);
        }
        if(!empty($filter['by_Section'])){
            $this->db->where('student.section_name', $filter['by_Section']);
        }
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.is_active', 0);
        // $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getStudentInfoById($row_id=''){
        $this->db->from('tbl_students_info as student'); 
        $this->db->where('student.row_id', $row_id);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getStudentsInfoById($row_id=''){
        $this->db->select('student.row_id,student.blood_group,student.student_no,student.application_no,student.register_no, student.cancel_bus_status,
        student.student_id,student.hall_ticket_no,student.student_name,student.elective_sub,student.dob,student.mobile,student.email,
        student.date_of_admission,student.roll_number,student.gender,student.student_status,student.residential_address,student.nationality,student.mother_educational_qualification,student.mother_annual_income,
        student.pu_board_number,student.category,student.last_board_name,student.present_address,student.permanent_address,student.religion,student.father_email,student.mother_profession,student.mother_email,
        student.father_name,student.father_mobile,student.mother_name,student.mother_mobile,student.program_name,student.stream_name,student.father_profession,student.father_annual_income,
        student.route_id,route.name as route_name,route.rate,route.bus_no,student.caste,student.sub_caste,student.mother_tongue,student.is_dyslexic,student.father_educational_qualification,
        student.intake_year,student.term_name,student.section_name,student.sat_number,student.doj,student.primary_mobile');
        $this->db->from('tbl_students_info as student'); 
        $this->db->join('tbl_student_transport_rate_info as route', 'route.row_id = student.route_id','left');
        $this->db->where('student.row_id', $row_id);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
   
    
    public function getStudentByStudentId($student_id){
        $this->db->from('tbl_students_info as student'); 
        $this->db->where('student.student_id', $student_id);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    public function getStudentInfoByStudentId($filter=''){
        $this->db->from('tbl_students_info as student'); 
        if(!empty($filter['student_id'])){
            $this->db->where('student.student_id', $filter['student_id']);
        } 
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.is_active', 1);
        $query = $this->db->get();
        return $query->row();
    }

    //get data for tc
    public function getStudentById($student_id) {
        $this->db->from('tbl_students_info as std');
        $this->db->where('std.student_id', $student_id);
        $query = $this->db->get();
        return $query->row();
    }

    // function getStudentTcInfoById($student_id) {
    //     $this->db->from('tbl_applied_students_tc_info as std');
    //     $this->db->where('std.student_id', $student_id);
    //     $query = $this->db->get();
    //     return $query->row();
    // }
    function getStudentTcInfoById($student_id) {
        
        $this->db->from('tbl_applied_students_tc_info as tc');
        $this->db->join('tbl_students_info as student', 'student.student_id = tc.student_id','left');

        $this->db->where('tc.student_id', $student_id);
        $query = $this->db->get();
        return $query->row();
        }


    // add tc info
    function addStudentTcInfo($tcInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_applied_students_tc_info', $tcInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function checkTCNumberExists($student_id,$applied_year){
        $this->db->from('tbl_applied_students_tc_info as std');
        $this->db->where('std.student_id', $student_id);
        $this->db->where('std.applied_year', $applied_year);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    public function getStudentTCAppliedLastRowId($applied_year){
        $this->db->from('tbl_applied_students_tc_info as std');
        $this->db->where('std.applied_year', $applied_year);
        $this->db->where('std.is_deleted', 0);
        $this->db->order_by('std.row_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    // update TC info
    function checkStudentTCAppliedStatus($student_id) {
        $this->db->from('tbl_applied_students_tc_info as std');
        $this->db->where('std.is_deleted', 0);
        $this->db->where('std.student_id', $student_id);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function updateTcInfo($tcInfo, $student_id){
        $this->db->where('student_id', $student_id);
        $this->db->update('tbl_applied_students_tc_info', $tcInfo);
        return TRUE;
    }
    function updateStudentTcStatusInfo($studentInfo, $student_id) {
        $this->db->where('student_id', $student_id);
        $this->db->update('tbl_students_info', $studentInfo);
        return TRUE;
    }


    public function getStudentImageById($row_id){
        $this->db->select('student.application_no,doc.document,doc.name');
        $this->db->from('tbl_students_info as student'); 
        $this->db->join('tbl_student_document as doc', 'doc.application_no = student.application_no','left');
        $this->db->where('student.row_id', $row_id);
        $this->db->where('student.is_deleted', 0);
        // $this->db->where('doc.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function updateStudentInfo($studentInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_students_info', $studentInfo);
        return TRUE;
    }

    

    public function updateStudentImage($studentImage,$application_no){
        $this->db->where('application_no',$application_no);
        $this->db->update('tbl_student_document',$studentImage);
        return TRUE;
    }
    public function addStudentImage($studentImage) {
        $this->db->trans_start();
        $this->db->insert('tbl_student_document', $studentImage);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }


    public function getMotherTongueInfo()
    {
        $this->db->from('tbl_mother_tongue as language');
        $this->db->where('language.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    // get count of first year students
    public function getCountOfStudents($filter){
        $this->db->from('tbl_students_info as student'); 
        // if(!empty($filter['by_intake_year'])){
        //     $this->db->where('student.intake_year', $filter['by_intake_year']);
        // }
        if(!empty($filter['term'])){
            $this->db->where('student.term_name', $filter['term']);
        }
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // get count of alumni students
    public function getCountOfTotalOldStudents($filter){
        $this->db->from('tbl_students_info as student'); 
        if(!empty($filter['by_start_year'])){
            $this->db->where('student.intake_year >=', $filter['by_start_year']);
        }
        if(!empty($filter['by_end_year'])){
            $this->db->where('student.intake_year <=', $filter['by_end_year']);
        }
        // $this->db->where('student.is_admitted', 1);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getStudentInfoForReportDownload($filter){
        $this->db->from('tbl_students_info as student'); 
        if(!empty($filter['preference'])){
            $this->db->where('student.stream_name', $filter['preference']);
        }
        if(!empty($filter['term'])){
            $this->db->where('student.term_name', $filter['term']);
        }
        if(!empty($filter['section_name'])){
            if($filter['section_name'] != 'ALL'){
                $this->db->where('student.section_name', $filter['section_name']);
            }
        }
        if(!empty($filter['academic_year'])){
            $this->db->where_in('student.intake_year', $filter['academic_year']);
        }
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $this->db->order_by('student.student_id,student.section_name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

   

    public function getAllStreamName() {
        $this->db->from('tbl_program_stream_info as stream'); 
        $this->db->group_by('stream_name');
        $this->db->where('stream.is_deleted', 0);
        $this->db->order_by('stream.row_id');
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllSectionName(){
        $this->db->select('section.row_id,section.stream_id,section.term_name,section.section_name');
        $this->db->group_by('section.section_name');
        $this->db->from('tbl_section_info as section'); 
        $this->db->where('section.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getStudentInfoForAnnualExam($term,$sub_name='',$stream_name,$filterBatch =''){
        $this->db->from('tbl_students_info as student');
        $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = student.application_no');
        if($filterBatch != NULL){
               $this->db->where('student.student_id BETWEEN "'.$filterBatch->student_id_from.'" AND "'.$filterBatch->student_id_to.'"');
        }
        if(!empty($sub_name)){
           if($sub_name == 'Kannada'){
               $this->db->where('academic.elective_sub', 'KANNADA');
           }else if($sub_name == 'French'){
               $this->db->where('academic.elective_sub', 'FRENCH');
           }else if($sub_name == 'Hindi'){
               $this->db->where('academic.elective_sub', 'HINDI');
           }
        }
        $this->db->where('student.intake_year', '2019');
        $this->db->where('academic.stream_name', $stream_name);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('academic.is_deleted', 0);
        $this->db->order_by('academic.pu_board_number', 'ASC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    // excel import
    public function getAllstudentInfoForExcel($student_id)
    {
        $this->db->select('student.row_id,student.blood_group,student.student_no,student.application_no,student.register_no, 
        student.student_id,student.hall_ticket_no,student.student_name,student.elective_sub,student.dob,student.mobile,student.email,
        student.date_of_admission,student.roll_number,student.gender,student.student_status,student.residential_address,
        student.pu_board_number,student.category,student.last_board_name,student.present_address,student.permanent_address,
        student.father_name,student.father_mobile,student.mother_name,student.mother_mobile,student.program_name,student.stream_name,
        student.intake_year,student.term_name,student.section_name,student.sat_number');
        $this->db->from('tbl_students_info as student'); 
        // $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = student.application_no');
        $this->db->where('academic.student_id', $student_id);
        // $this->db->where('student.intake_year', '2019');
        $this->db->where('student.is_deleted', 0);
        // $this->db->where('academic.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    
    //get first puc student for annual result report
    function getStudentsToAnnualResultReport($term_name,$stream_name){
        $this->db->select('student.row_id,student.blood_group,student.student_no,student.application_no,student.register_no, 
        student.student_id,student.hall_ticket_no,student.student_name,student.elective_sub,student.dob,student.mobile,student.email,
        student.date_of_admission,student.roll_number,student.gender,student.student_status,student.residential_address,
        student.pu_board_number,student.category,student.last_board_name,student.present_address,student.permanent_address,
        student.father_name,student.father_mobile,student.mother_name,student.mother_mobile,student.program_name,student.stream_name,
        student.intake_year,student.term_name,student.section_name,student.sat_number');
        $this->db->from('tbl_students_info as student'); 
        // $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = student.application_no');
        $this->db->where('student.term_name', $term_name);
        $this->db->where('student.stream_name', $stream_name);
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $this->db->order_by('student.student_id', 'ASC');
        // $this->db->where('academic.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }
    
   
    public function getAllStudentsInfo(){
        $this->db->from('tbl_students_info as student'); 
        //$this->db->where('student.is_active', 1);
        //$this->db->where('academic.is_current', 1);
        $this->db->where('student.is_deleted', 0);
       // $this->db->where('academic.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getAllStudentsInfoByStudentID($student_id){
        $this->db->from('tbl_students_info as student'); 
        //$this->db->where('student.is_active', 1);
        $this->db->where('student.student_id', $student_id);
        $this->db->where('student.is_deleted', 0);
       // $this->db->where('academic.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function getStudentInfoForInternal($filter=''){
        $this->db->from('tbl_students_info as student');
        if(!empty($filter['subject_name'])){
           if($filter['subject_name'] == 'Kannada'){
               $this->db->where('student.elective_sub', 'KANNADA');
           }else if($filter['subject_name'] == 'French'){
               $this->db->where('student.elective_sub', 'FRENCH');
           }else if($filter['subject_name'] == 'Hindi'){
               $this->db->where('student.elective_sub', 'HINDI');
           }
        }
        if(!empty($filter['stream_name'])){
            $this->db->where('student.stream_name', $filter['stream_name']);
        }
        if(!empty($filter['term_name'])){
           $this->db->where('student.term_name', $filter['term_name']);
        }
        if(!empty($filter['section_name'])){
            $this->db->where('student.section_name', $filter['section_name']);
        }
        if(!empty($filter['student_id'])){
            $this->db->where_in('student.student_id', $filter['student_id']);
        }
        if(!empty($filter['class_batch'])){
            $this->db->where_in('student.batch', $filter['class_batch']);
        }
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $this->db->order_by('student.student_id', 'ASC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getInternalMarkStudentInfo($term_name,$stream_name,$section_name){
        $this->db->from('tbl_students_info as student');
        $this->db->where_in('student.stream_name', $stream_name);
        $this->db->where('student.term_name', $term_name);
        $this->db->where('student.section_name', $section_name);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.is_active', 1);
        $this->db->order_by('student.student_id', 'ASC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }


    // add from excel
    public function addStudentDetailsFromExcel($student_info,$application_no) {
        $this->db->where('application_no', $application_no);
        $this->db->update('tbl_students_info',$student_info);
        return TRUE;
    }
    
    public function addstudentData($student_info) {
        $this->db->trans_start();
        $this->db->insert('tbl_students_info', $student_info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
  
    // add from excel
    public function updateStudentInfoBStdId($student_info,$student_id){
        $this->db->where('student_id', $student_id);
        $this->db->update('tbl_students_info',$student_info);
        return TRUE;
    }
    
    // by application no
    public function updateStudentInfoApp($student_info,$application_no){
        $this->db->where('application_no', $application_no);
        $this->db->update('tbl_students_info',$student_info);
        return TRUE;
    }

     // add from excel
    public function updateStudentInfoAdmissionNo($student_info,$application_no){
        $this->db->where('application_no', $application_no);
        $this->db->update('tbl_students_info',$student_info);
        return TRUE;
    }

    // class held information for attendance
    public function getClassHeldInfo($filter,$subject_code){
        $this->db->from('tbl_class_completed_by_staff as class');
        if(!empty($filter['stream_name'])){
            $this->db->where('class.stream_name', $filter['stream_name']);
        }
        if(!empty($filter['section_name'])){
            $this->db->where('class.section_name', $filter['section_name']);
        }
        if(!empty($filter['term_name'])){
            $this->db->where('class.term_name', $filter['term_name']);
        }
        if(!empty($filter['subject_type'])){
            $this->db->where('class.subject_type', $filter['subject_type']);
        }
        $this->db->where_in('class.subject_code', $subject_code);
        $this->db->where('class.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getStudentAbsentInfo($student_id,$subject_code){
        $this->db->from('tbl_student_attendance_details as std');
        $this->db->where_in('std.subject_code', $subject_code);
        $this->db->where_in('std.student_id', $student_id);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // get first internal exam mark
    public function getFirstInternaltMark($student_id,$subjects_code){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.name as sub_name,
        sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_type', 'I_UNIT_TEST');
        $this->db->where('exam.exam_year', '2023-24');
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

     // get second internal exam mark
     public function getSecondInternalMark($student_id,$subjects_code){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.name,
        sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_type', 'II_UNIT_TEST');
        $this->db->where('exam.exam_year', '2023-24');
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    // get first internal exam mark
    public function getFirstTermMark($student_id,$subjects_code){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.sub_name,
        sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_type', 'I_TERM');
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    // get mid term exam mark
    public function getMidTermMark($student_id,$subjects_code){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.name,
        sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_type', 'MID_TERM_EXAM');
        $this->db->where('exam.exam_year', EXAM_YEAR);
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

     // get mid term exam mark
     public function getFirstPreparatoryMark($student_id,$subjects_code){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,sub.name,
        sub.sub_type,sub.lab_status	');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_type', 'I_PREPARATORY');
        $this->db->where('exam.exam_year', '2022-23');
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getStudentInfoForConcession(){
        $this->db->select('student.row_id, 
        student.student_name, 
        student.application_no,
        student.student_id,');
        $this->db->from('tbl_students_info as student'); 
        // $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = student.application_no','left');
        // $this->db->where('academic.term_name', 'II PUC');
        $this->db->where('student.is_active', 1);
        // $this->db->where('student.is_current', 1);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    
    public function getStudentInfoByApplicationNumber(){
        $this->db->select('std.row_id, 
        std.student_name, 
        std.application_no,
        academic.student_id,');
        $this->db->from('tbl_students_info as std');
        $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = std.application_no','left');
        //$this->db->where('std.is_active', 1);
        $this->db->where('academic.is_current', 1);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

     function getStudentId($student_id){
        $this->db->from('tbl_student_academic_info as academic');
        $this->db->where('academic.student_id', $student_id);
        $this->db->where('academic.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }


     public function updateStudentInfoByExcel($studentInfo, $studentApplicationNo){
        $this->db->where('application_no', $studentApplicationNo);
        $this->db->update('tbl_students_info', $studentInfo);
        return TRUE;
    }

    // 
    public function getFeePaidStudentInfoByAppNo($application_no){
        $this->db->select('student.row_id, 
        student.student_name, 
        student.application_no, 
        student.caste_others,
        academic.student_id,
        academic.term_name,
        academic.stream_name,
        academic.section_name,
        academic.elective_sub,
        fee.receipt_number,');
        $this->db->from('tbl_students_info as student'); 
        $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = student.application_no','left');
        $this->db->join('tbl_students_overall_fee_payment_info as fee', 'fee.application_no = student.application_no','right');

        $this->db->where('student.application_no', $application_no);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getAllFirstYearStudent(){
        $this->db->select('student.row_id, 
        student.student_name, 
        student.application_no,academic.term_name,academic.section_name,academic.elective_sub,
        academic.student_id');
        $this->db->from('tbl_students_info as student'); 
        $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = student.application_no','left');
        $this->db->where('academic.term_name', 'I PUC');
          $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    // SJPUC lates

    public function getStudentInfoBy_Application_no($application_no){
        $this->db->from('tbl_students_info as student'); 
        $this->db->where('student.application_no', $application_no);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getStudentInfoBy_StudentID($student_id){
        $this->db->from('tbl_students_info as student'); 
        $this->db->where('student.student_id', $student_id);
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getStudentInfoByRowId($row_id){
        $this->db->from('tbl_students_info as student'); 
        $this->db->where('student.row_id', $row_id);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getAllStudentInfo_For_Fee_report($term_name,$year){
        $this->db->from('tbl_students_info as student'); 
        $this->db->where('student.term_name', $term_name);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.is_active', 1);
        $this->db->where('student.intake_year_id',$year);
        $query = $this->db->get();
        return $query->result();
    }
    

    function getStudentsDetailsForTC($filter){
        $this->db->select('tc.row_id,
                          tc.student_id,
                          tc.leaving_date,
                          tc.is_promoted,
                          tc.created_date_time,
                          tc.tc_number,
                          std.student_name,
                          std.section_name,
                          std.stream_name,
                          std.program_name,
                          std.mobile,
                          std.term_name,
                          std.hall_ticket_no,
                         ');
        $this->db->from('tbl_applied_students_tc_info as tc');
        $this->db->join('tbl_students_info as std','std.student_id = tc.student_id','left');
    
        if(!empty($filter['student_id'])) {
            $this->db->where('std.student_id', $filter['student_id']);
        }
        if(!empty($filter['student_name'])) {
            $this->db->where('std.student_name', $filter['student_name']);
        }
        if(!empty($filter['term_name'])) {
            $this->db->where('std.term_name', $filter['term_name']);
        }
        if(!empty($filter['section_name'])) {
            $this->db->where('std.section_name', $filter['section_name']);
        }
        if(!empty($filter['stream_name'])) {
            $this->db->where('std.stream_name', $filter['stream_name']);
        }
        if(!empty($filter['register_no'])) {
            $this->db->where('std.hall_ticket_no', $filter['register_no']);
        }
        if(!empty($filter['tc_number'])) {
            $this->db->where('tc.tc_number', $filter['tc_number']);
        }
         if (!empty($filter['by_date'])) {
            $this->db->where('tc.created_date_time', $filter['by_date']);
        }
         if(!empty($filter['year'])) {
            $this->db->where('tc.applied_year', $filter['year']);
        }
        $this->db->where('tc.is_deleted', 0);
        // $this->db->where('tc.applied_year', '2021');
        $this->db->order_by('tc.student_id', 'ASC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    function getStudentsDetailsForTcCount($filter){
        $this->db->from('tbl_applied_students_tc_info as tc');
        $this->db->join('tbl_students_info as std','std.student_id = tc.student_id','left');
        
        if(!empty($filter['student_id'])) {
            $this->db->where('std.student_id', $filter['student_id']);
        }
        if(!empty($filter['student_name'])) {
            $this->db->where('std.student_name', $filter['student_name']);
        }
        if(!empty($filter['term_name'])) {
            $this->db->where('std.term_name', $filter['term_name']);
        }
        if(!empty($filter['section_name'])) {
            $this->db->where('std.section_name', $filter['section_name']);
        }
        if(!empty($filter['stream_name'])) {
            $this->db->where('std.stream_name', $filter['stream_name']);
        }
        if(!empty($filter['register_no'])) {
            $this->db->where('std.hall_ticket_no', $filter['register_no']);
        }
        if(!empty($filter['tc_number'])) {
            $this->db->where('tc.tc_number', $filter['tc_number']);
        }
        if (!empty($filter['by_date'])) {
            $this->db->where('tc.created_date_time', $filter['by_date']);
        }
         if(!empty($filter['year'])) {
            $this->db->where('tc.applied_year', $filter['year']);
        }
        $this->db->where('tc.is_deleted', 0);
        // $this->db->where('tc.applied_year', '2021');
        $query = $this->db->get();
        return $query->num_rows();
    }

    //get student tc data
    function getStudentsTcInfoById($student_id){
        $this->db->select('tc.row_id,
        tc.student_id,
        tc.tc_number,
        tc.leaving_date,
        tc.is_promoted,
        tc.reason_unqualified,
        tc.is_belongs_sc_st,
        tc.is_cleared_college_due,
        tc.character_conduct,
        tc.created_date_time,
        std.student_name,
        std.section_name,
        std.stream_name,
       
        std.program_name,
        std.mobile,
        std.term_name,
        std.dob,
        std.nationality,
        std.caste,
        std.religion,
        std.father_name,
        std.mother_name,
        std.date_of_admission,
        std.elective_sub,
        std.hall_ticket_no,
        std.student_id,
        std.register_no,
        std.application_no,
        std.admission_no,
        std.student_no,
        std.sat_number,
       std.admission_number');
        $this->db->from('tbl_students_info as std');
        $this->db->join('tbl_applied_students_tc_info as tc','tc.student_id = std.student_id','left');
        $this->db->where_in('tc.student_id', $student_id);
        $this->db->where('tc.is_deleted', 0);
        $this->db->order_by('tc.student_id', 'ASC');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    } 

    // assignment and internal assessment mark
    public function getStudentFinalMarks($student_id,$subjects_code,$exam_type){
        $this->db->select('exam.student_id,exam.subject_code,exam.obt_theory_mark,exam.obt_lab_mark,exam.exam_type,
        sub.name as sub_name,sub.sub_type,sub.lab_status');
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code');
        $this->db->from('tbl_college_internal_exam_marks as exam');
        $this->db->where('exam.student_id', $student_id);
        $this->db->where('exam.subject_code', $subjects_code);
        $this->db->where('exam.exam_year', '2022-23');
        $this->db->where_in('exam.exam_type', $exam_type);
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    
    function getStudentMarksSheetByStudentId($student_id){
        $this->db->from('tbl_students_info as std');
        $this->db->where_in('std.student_id', $student_id);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    
    
    //get first puc student for annual result report
    function getStudentsInfoByApplicationNumber($application_no){
        $this->db->from('tbl_students_info as student'); 
        $this->db->where('student.application_no', $application_no);
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    
    function getStudentsInfoByStudentID($student_id){
        $this->db->select('
        std.application_no,
        std.student_name,
        std.section_name,
        std.stream_name,
        std.program_name,
        std.mobile,
        std.term_name,
        std.dob,
        std.nationality,
        std.caste,
        std.religion,
        std.father_name,
        std.mother_name,
        std.date_of_admission,
        std.elective_sub,
        std.hall_ticket_no,
        std.student_id,
        std.father_mobile,
        std.mother_mobile,
       ');
        $this->db->from('tbl_students_info as std');
       
        $this->db->where_in('std.student_id', $student_id);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();        
        return $result;
    } 

    // analytics
    public function getStudentInfoBySectionTerm($term,$filter,$stream_name){
        $this->db->from('tbl_students_info as student');
        $this->db->where('student.term_name', $term);
        if(!empty($filter['section_name'])) {
            $this->db->where('student.section_name', $filter['section_name']);
        }
        $this->db->where('student.stream_name', $stream_name);
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $this->db->order_by('student.student_id', 'ASC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getStudentInfoForAnalytics($term,$stream_name,$filter){
        $this->db->from('tbl_students_info as student');
        $this->db->where('student.term_name', $term);
          if($filter['section_name']=='ALL'){
            $this->db->where('student.section_name', '');
        }else{
            $this->db->where('student.section_name', $filter['section_name']);
        }
        if(!empty($filter['subject_name'])) {
            $this->db->where('student.elective_sub', $filter['subject_name']);
        }
        $this->db->where('student.stream_name', $stream_name);
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $this->db->order_by('student.student_id', 'ASC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    //get single student info from I Puc biodata
    function getStudentsInfoForPrintMarkCard($student_id){
        // if($term == 'I_PUC'){
        //     $this->db->from('tbl_first_puc_students_info as student');
        //  }else{
        //     $this->db->from('tbl_second_puc_students_info as student');
        //  }
        $this->db->from('tbl_students_info as student');
        $this->db->where_in('student.student_id', $student_id);
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getSubjectsForHallTicketPrintFirstYear($subject_code){
        $this->db->select('subjects.subject_code,subjects.name,exam.exam_date');
        $this->db->from('tbl_exam_details as exam');
        $this->db->join('tbl_subjects as subjects', 'subjects.subject_code = exam.subject_id','left');
        $this->db->where_in('exam.subject_id', $subject_code);
        $this->db->where('exam.exam_term_name', 'I PUC');
        $this->db->order_by('exam.exam_date', 'ASC');
        $this->db->where('exam.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function getFirstYearProfileImage($application_no){
        $this->db->from('tbl_admission_students_status_temp as status');
        $this->db->join('tbl_admission_document_details_temp as doc','doc.registred_row_id = status.registered_row_id');
        $this->db->where_in('status.application_number', $application_no);
        $this->db->where('doc.doc_name', 'student_photo');
        $this->db->where('doc.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();   
    }

    public function getSubjectsForHallTicketPrint($subject_code){
        $this->db->from('tbl_subjects as subjects');
        $this->db->where_in('subjects.subject_code', $subject_code);
        $this->db->where('subjects.lab_status','true');
        $this->db->where('subjects.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getStdInfoByStudentId($filter=''){
        $this->db->from('tbl_students_info as student'); 
        if(!empty($filter['student_id'])){
            $this->db->where_in('student.student_id', $filter['student_id']);
        } 
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.is_active', 1);
        $query = $this->db->get();
        return $query->result();
    }

    function getExamInfo($term_name,$stream_name,$subject_code,$exam_name){
        $this->db->select('sub.name,exam.exam_date,exam.time,exam.subject_code');
        $this->db->from('tbl_exam_info as exam'); 
        $this->db->join('tbl_subjects as sub','sub.subject_code = exam.subject_code','left');
        $this->db->where('exam.class', $term_name);
        $this->db->where('exam.stream', $stream_name);
        $this->db->where_in('exam.subject_code', $subject_code);
        $this->db->where('exam.exam_year', '2023');
        $this->db->where('exam.exam_name', $exam_name);
        $this->db->where('exam.is_deleted', 0);
        $this->db->where('exam.exam_status', 0);
        $this->db->where('sub.is_deleted', 0);
        $this->db->order_by('exam.exam_date', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    function getStudentsStreamName($section_name,$term_name,$stream_name){
        $this->db->select('std.stream_name');
        $this->db->from('tbl_students_info as std');
        $this->db->where('std.is_active', 1);
        $this->db->where('std.is_deleted', 0);
        $this->db->where('std.section_name', $section_name);
        $this->db->where('std.term_name', $term_name);
        if($stream_name != ''){
            $this->db->where('std.stream_name', $stream_name);
        }
        $query = $this->db->get();
        return $query->row();
    }
    

    function getStudentsToAddMark($term_name,$section_name){
       // $this->db->select('std.tc_given_status, std.Student_ID, std.Name,  std.Term_Name, std.Section_Name, std.Stream_Name','std.Program_Name');
        $this->db->from('tbl_students_info as std');
       // $this->db->join('tbl_roles as Role', 'Role.roleId = cust.roleId','left');
        $this->db->where('std.is_deleted', 0);
        $this->db->where('std.is_active', 1);
        $this->db->where('std.term_name', $term_name);
        $this->db->where('std.section_name', $section_name);
        //$this->db->join('tbl_student_exams_marks as tbl_marks',' std.Student_ID = tbl_marks.student_id','LEFT');
        //$this->db->where_in("(SELECT * FROM tbl_student_exams_marks WHERE exam_id = '$exam_id')");
        //$this->db->where('tbl_marks.staff_updated_status =', 0);
        //$this->db->where('tbl_marks.exam_id ', $exam_id);
        //$this->db->where('tbl_marks.staff_id', $staff_id);
        $this->db->order_by('std.student_id', 'ASC');
        
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    function getFullMarksOfStudent($student_id){
        $this->db->select('tbl_marks.student_id, 
        tbl_marks.obt_theory_mark,tbl_marks.obt_lab_mark, 
        sub.name as subject_name,sub.subject_code, sub.lab_status');
        $this->db->from('tbl_college_internal_exam_marks as tbl_marks');  
        $this->db->where('tbl_marks.is_deleted', 0);

        $this->db->where('tbl_marks.exam_type', 'ANNUAL_EXAMINATION');
        $this->db->where('tbl_marks.student_id', $student_id);
       // $this->db->join('tbl_exam_details as exam_details', 'exam_details.exam_id = tbl_marks.exam_id');
        $this->db->join('tbl_subjects as sub', 'sub.subject_code = tbl_marks.subject_code');
        $this->db->group_by('sub.subject_code');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getAllOldStudentsInfo(){
        $this->db->select('student.row_id,student.blood_group,student.student_no,student.application_no,student.register_no, 
        student.student_id,student.hall_ticket_no,student.student_name,student.elective_sub,student.dob,student.mobile,student.email,
        student.date_of_admission,student.roll_number,student.gender,student.student_status,student.residential_address,
        student.pu_board_number,student.category,student.last_board_name,student.present_address,student.permanent_address,
        student.father_name,student.father_mobile,student.mother_name,student.mother_mobile,student.program_name,student.stream_name,
        student.intake_year,student.term_name,student.section_name');
        $this->db->from('tbl_students_info as student'); 
        // $this->db->join('tbl_student_academic_info as academic', 'student.application_no = student.application_no');
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.intake_year!=', '2021-22');
        $this->db->order_by('student.student_id', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }


    public function getStudentByApplication_no($student_id){
        $this->db->from('tbl_students_info as student'); 
        $this->db->where('student.application_no', $student_id);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }


    public function updateStudentInfoByAppNo($student_info,$student_id){
        $this->db->where('application_no', $student_id);
        $this->db->update('tbl_students_info',$student_info);
        return TRUE;
    }



    public function getAllCourseRegisterInfo($filter){
        
       
        $this->db->from('tbl_course_students_reg as course');
        $this->db->join('tbl_students_info as student', 'student.student_id = course.student_id','left');
    
        if(!empty($filter['by_student_id'])){
            $this->db->where('course.student_id', $filter['by_student_id']);
        }
        if(!empty($filter['student_name'])){
            $this->db->where('student.student_name', $filter['student_name']);
        }
        if(!empty($filter['course_name'])){
            $this->db->where('course.course_name', $filter['course_name']);
        }
        if(!empty($filter['amount'])){
            $likeCriteria = "(course.paid_amount  LIKE '%".$filter['amount']."%')";
            $this->db->where($likeCriteria);
        }

        $this->db->where('course.payment_status', 1);
        $this->db->where('course.is_deleted', 0);
        $this->db->where('student.is_deleted', 0);
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    
    //shortlisted view and count
    public function getAllCourseRegisterInfoCount($filter='') {
        $this->db->from('tbl_course_students_reg as course');
        $this->db->join('tbl_students_info as student', 'student.student_id = course.student_id','left');
    
        if(!empty($filter['by_student_id'])){
            $this->db->where('course.student_id', $filter['by_student_id']);
        }
        if(!empty($filter['student_name'])){
            $this->db->where('student.student_name', $filter['student_name']);
        }
        if(!empty($filter['course_name'])){
            $this->db->where('course.course_name', $filter['course_name']);
        }
        if(!empty($filter['amount'])){
            $likeCriteria = "(course.paid_amount  LIKE '%".$filter['amount']."%')";
            $this->db->where($likeCriteria);
        }

        $this->db->where('course.payment_status', 1);
        $this->db->where('course.is_deleted', 0);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }





    public function getAllCourseRegisterInfoForReport(){
        
       
        $this->db->from('tbl_course_students_reg as course');
        $this->db->join('tbl_students_info as student', 'student.student_id = course.student_id','left');
    
        // if(!empty($filter['by_student_id'])){
        //     $this->db->where('course.student_id', $filter['by_student_id']);
        // }
        // if(!empty($filter['student_name'])){
        //     $this->db->where('student.student_name', $filter['student_name']);
        // }
        // if(!empty($filter['course_name'])){
        //     $this->db->where('course.course_name', $filter['course_name']);
        // }
        // if(!empty($filter['amount'])){
        //     $likeCriteria = "(course.paid_amount  LIKE '%".$filter['amount']."%')";
        //     $this->db->where($likeCriteria);
        // }

        $this->db->where('course.payment_status', 1);
        $this->db->where('course.is_deleted', 0);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function AddAluminiStudentTCInfo($studentInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_alumni_student_tc_info', $studentInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function getAluminiStudentsDetailsForTC($filter){
      
        $this->db->from('tbl_alumni_student_tc_info as tc');
     
        if(!empty($filter['name'])) {
            $this->db->where('tc.name', $filter['name']);
        }
        if(!empty($filter['class'])) {
            $this->db->where('tc.class', $filter['class']);
        }
       
        if(!empty($filter['register_no'])) {
            $this->db->where('tc.register_no', $filter['register_no']);
        }
        if(!empty($filter['tc_number'])) {
            $this->db->where('tc.tc_number', $filter['tc_number']);
        }
         if (!empty($filter['by_date'])) {
            $this->db->where('tc.created_date_time', $filter['by_date']);
        }
        
        $this->db->order_by('tc.row_id', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $this->db->where('tc.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }


    function getStudentsDetailsForAlumniTcCount($filter){
        $this->db->from('tbl_alumni_student_tc_info as tc');
        
        if(!empty($filter['name'])) {
            $this->db->where('tc.name', $filter['name']);
        }
        if(!empty($filter['class'])) {
            $this->db->where('tc.class', $filter['class']);
        }
       
        if(!empty($filter['register_no'])) {
            $this->db->where('tc.register_no', $filter['register_no']);
        }
        if(!empty($filter['tc_number'])) {
            $this->db->where('tc.tc_number', $filter['tc_number']);
        }
         if (!empty($filter['by_date'])) {
            $this->db->where('tc.created_date_time', $filter['by_date']);
        }
        $this->db->order_by('tc.row_id', 'ASC');
        $this->db->where('tc.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

        //get student tc data
        function getAlumniStudentsTcInfoById($row_id){
            
            $this->db->from('tbl_alumni_student_tc_info as std');
            $this->db->where_in('std.row_id', $row_id);
            $this->db->order_by('std.row_id', 'ASC');
            $query = $this->db->get();
            $result = $query->result();        
            return $result;
        } 
        public function checkAlumniTCNumberExists($roll_no,$applied_year){
            $this->db->from('tbl_alumni_student_tc_info as std');
            $this->db->where('std.roll_no', $roll_no);
            $this->db->where('std.applied_year', $applied_year);
            $this->db->where('std.is_deleted', 0);
            $query = $this->db->get();
            return $query->row();
        }

        public function getAlumniStudentTCAppliedLastRowId($applied_year){
            $this->db->from('tbl_alumni_student_tc_info as std');
            $this->db->where('std.applied_year', $applied_year);
            $this->db->where('std.is_deleted', 0);
            $this->db->order_by('std.row_id', 'DESC');
            $this->db->limit(1);
            $query = $this->db->get();
            return $query->row();
        }

        public function getCertificateInfo($row_id){
            $this->db->from('tbl_certificate_name as name'); 
            $this->db->where('name.row_id', $row_id);
            $this->db->where('name.is_deleted', 0);
            $query = $this->db->get();
            $result = $query->row();        
            return $result;
        }
        function getAllRequestFormInfoCount($filter){
            $this->db->from('tbl_request_form as request'); 
            $this->db->join('tbl_students_info as std', 'std.row_id = request.student_row_id','left');
            $this->db->join('tbl_certificate_name as name', 'name.row_id = request.certificate_Id','left');
            if(!empty($filter['student_row_id'])) {
                $this->db->where('request.student_row_id', $filter['student_row_id']);
            }
            // if(!empty($filter['enrolment_no'])) {
            //     $this->db->where('std.enrolment_no', $filter['enrolment_no']);
            // }
            if(!empty($filter['student_name'])){
                $this->db->where('std.student_name', $filter['student_name']);
            }
            if(!empty($filter['request_sub'])){
                $this->db->where('request.request_sub', $filter['request_sub']);
            }
            if(!empty($filter['request_issue'])) {
                $this->db->where('request.issue', $filter['request_issue']);
            }
            if(!empty($filter['request_certificate'])) {
                $this->db->where('request.certificate_Id', $filter['request_certificate']);
            }
            if(!empty($filter['student_name'])){
                $likeCriteria = "(std.student_name  LIKE '%" . $filter['student_name'] . "%')";
                $this->db->where($likeCriteria);
            }
            $this->db->where('request.is_deleted', 0);
            $query = $this->db->get();
            return $query->num_rows();
        } 
        function getAllRequestFormInfo($filter, $page, $segment){
            $this->db->select('request.row_id,request.issue,request.certificate_Id,request.request_sub,name.row_id as nameid,
            name.certificate_name,std.student_name,std.student_id');
            $this->db->from('tbl_request_form as request'); 
            $this->db->join('tbl_students_info as std', 'std.row_id = request.student_row_id','left');
            $this->db->join('tbl_certificate_name as name', 'name.row_id = request.certificate_Id','left');
            if(!empty($filter['student_row_id'])) {
                $this->db->where('request.student_row_id', $filter['student_row_id']);
            }
            if(!empty($filter['student_id'])) {
                $this->db->where('std.student_id', $filter['student_id']);
            }
            if(!empty($filter['student_name'])){
                $this->db->where('std.student_name', $filter['student_name']);
            }
            if(!empty($filter['request_sub'])){
                $this->db->where('request.request_sub', $filter['request_sub']);
            }
            if(!empty($filter['request_issue'])) {
                $this->db->where('request.issue', $filter['request_issue']);
            }
            if(!empty($filter['request_certificate'])) {
                $this->db->where('request.certificate_Id', $filter['request_certificate']);
            }
            $this->db->where('request.is_deleted', 0);
            $this->db->order_by('request.row_id', 'DESC');
            $this->db->limit($page, $segment);
            $query = $this->db->get();
            return $query->result();        
        }

        function certificateNames(){
            $this->db->from('tbl_certificate_name as name'); 
            $this->db->where('name.is_deleted', 0);
            $query = $this->db->get();
            $result = $query->result();        
            return $result;
        }

        function studentData(){
            $this->db->from('tbl_students_info as std'); 
            $this->db->where('std.is_deleted', 0);
            $query = $this->db->get();
            $result = $query->result();        
            return $result;
        }

        function addStudentRequestForm($requestInfo){
            $this->db->trans_start();
            $this->db->insert('tbl_request_form', $requestInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }

        public function getInfoForStudyCertificate($row_id){
            $this->db->select('std.intake_year,request.row_id as receipt_id,std.student_name,std.section_name,std.student_id,std.mother_tongue,std.gender,
            std.mother_name,request.row_id as receipt_no,std.father_name,request.classes_from,request.classes_to,request.college_from,request.college_to,std.dob,std.program_name,std.term_name,std.admission_no,request.classes_from,request.classes_to,request.college_from,request.college_to,request.character_conduct');
            $this->db->from('tbl_students_info as std');
            $this->db->join('tbl_request_form as request', 'request.student_row_id = std.row_id','left');
            $this->db->where_in('request.row_id', $row_id);
            $this->db->where('request.certificate_Id ', 2);
           // $this->db->where('std.is_active', 1);
            $this->db->where('std.is_deleted', 0);
            $this->db->where('request.is_deleted', 0);
            $query = $this->db->get();
            return $query->result();
        }

        public function getInfoForCertificate($enrolment_id){
            $this->db->select('name.certificate_name');
            $this->db->distinct();
            $this->db->from('tbl_certificate_name as name');
            $this->db->join('tbl_request_form as request', 'request.certificate_Id = name.row_id','left');
            $this->db->where_in('request.row_id', $enrolment_id);
            $this->db->where('request.is_deleted', 0);
            $this->db->where('name.is_deleted', 0);
            $query = $this->db->get();
            return $query->result();
        }

        public function getStudentInfoBy_AppNo($application_no){
            $this->db->from('tbl_students_info as std');
            // $this->db->join('tbl_student_academic_info as academic','std.application_no = academic.application_no','left');
          
            $this->db->where('std.is_deleted', 0);
            $this->db->where_in('std.application_no', $application_no);
            // $this->db->where('academic.is_deleted', 0);
            $query = $this->db->get();
            return $query->row();
            
        }
        public function deleteAdmittedStudentInfo($application_no){
            $this->db->where('application_no', $application_no);
            $this->db->delete('tbl_students_info');
            return true;
        }

        function getAllCurrentStudentInfo(){
            $this->db->select('student.row_id,student.admission_no,student.student_name,student.dob,student.gender, 
            student.blood_group,student.admission_no,student.application_no,student.intake_year,student.term_name,
            student.section_name,student.intake_year,student.student_id,student.stream_name');
            $this->db->from('tbl_students_info as student'); 
            $this->db->where('student.is_active', 1);
            $this->db->where('student.is_deleted', 0);
            $query = $this->db->get();
            return $query->result();
        }

        public function updateStudentAcademicInfo($academicInfo,$application_no){
            $this->db->where('application_no', $application_no);
            $this->db->update('tbl_students_info',$academicInfo);
            return TRUE;
        }

        public function updateRequestCertificate($requestInfo, $row_id){
            $this->db->where('row_id', $row_id);
            $this->db->update('tbl_request_form', $requestInfo);
            return TRUE;
        }


        public function getstudentInfo(){   
            $this->db->select('student.row_id,student.student_id, student.student_name, student.dob, student.gender, student.mobile,
            student.application_no,student.intake_year,student.term_name,student.stream_name,student.section_name');
            $this->db->from('tbl_students_info as student'); 
            // $this->db->join('tbl_student_academic_info as academic', 'academic.rel_student_row_id = student.row_id');
            $this->db->where('student.is_active', 1);
           // $this->db->where('academic.is_current', 1);
            $this->db->where('student.is_deleted', 0);
            $this->db->order_by('student.term_name','asc');
            $query = $this->db->get();
            return $query->result();
        }
        

        function getStudentsBirthdayNotification($dob){
            $this->db->select('student.row_id,student.student_id, student.student_name, student.dob, student.gender, student.mobile,
            student.application_no,student.intake_year,student.term_name,student.stream_name,student.section_name');
            $this->db->from('tbl_students_info as student'); 
            // $this->db->join('tbl_student_academic_info as academic', 'academic.rel_student_row_id = student.row_id');
            $this->db->where_in('student.dob', $dob);
            $this->db->where('student.is_active', 1);
           // $this->db->where('academic.is_current', 1);
            $this->db->where('student.is_deleted', 0);
            $this->db->order_by('student.term_name','asc');
            $query = $this->db->get();
            $result = $query->result();        
            return $result;
        }


        public function getRemarksData($row_id){
            $this->db->select('student.row_id as student_row_id,student.student_name,student.application_no,
            remark.row_id,remark.student_id,remark.created_by,
            remark.date,remark.type_id,remark.file_path,remark.year,remark.description,
            remark.remarks');
            
            $this->db->from('tbl_student_remark_info as remark'); 
          //  $this->db->join('tbl_student_remarks_type as type','type.row_id = remark.type_id','left');
            $this->db->join('tbl_students_info as student', 'student.row_id = remark.student_id');
            
    
            // if(!empty($filter['student_Id'])){
            //     $this->db->where('remark.student_id', $filter['student_Id']);
            // }
            // if(!empty($filter['remark_type'])){
            //     $this->db->where('remark.type_id', $filter['remark_type']);
            // } 
            // if(!empty($filter['file_path'])){
            //     $this->db->where('remark.file_path', $filter['file_path']);
            // } 
            // if(!empty($filter['year'])){
            //     $this->db->where('remark.year', $filter['year']);
            // } 
            // if(!empty($filter['name'])){
            //     $likeCriteria = "(student.student_name  LIKE '%" . $filter['name'] . "%')";
            //     $this->db->where($likeCriteria);
            // } 
            
            // if(!empty($filter['description'])){
            //     $likeCriteria = "(remark.description  LIKE '%" . $filter['description'] . "%')";
            //     $this->db->where($likeCriteria);
            // }
            // if(!empty($filter['date'])){
            //     $this->db->where('remark.date', $filter['date']);
            // }
    
            $this->db->where('remark.student_id', $row_id);
            $this->db->order_by('remark.date', 'DESC');
            $this->db->where('remark.is_deleted', 0);
            $this->db->where('student.is_deleted', 0);
            $this->db->where('student.is_active', 1);
            $query = $this->db->get();
            $result = $query->result();        
            return $result;
        }
    

        function addRemarks($remarkInfo){
            $this->db->trans_start();
            $this->db->insert('tbl_student_remark_info', $remarkInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }

        function updateRemarksInfo($remarkInfo, $row_id){
            $this->db->where('row_id', $row_id);
            $this->db->update('tbl_student_remark_info', $remarkInfo);
            return TRUE;
        }

        
        public function getAllstudentInfoRowId($filter){
            $this->db->select('student.row_id'); 
            $this->db->from('tbl_students_info as student'); 
            // $this->db->join('tbl_student_academic_info as academic', 'student.application_no = student.application_no');
                
            // if(!empty($filter['student_id'])){
            //     $likeCriteria = "(student.student_id  LIKE '%" . $filter['student_id'] . "%')";
            //     $this->db->where($likeCriteria);
            // }
            // if(!empty($filter['application_no'])){
            //     $this->db->where('student.application_no', $filter['application_no']);
            // }
            // if(!empty($filter['by_name'])){
            //     $likeCriteria = "(student.student_name  LIKE '%" . $filter['by_name'] . "%')";
            //     $this->db->where($likeCriteria);
            // }
            // if(!empty($filter['by_term'])){
            //     $this->db->where('student.term_name', $filter['by_term']);
            // }
            // if(!empty($filter['by_stream'])){
            //     $this->db->where('student.stream_name', $filter['by_stream']);
            // }
            // if(!empty($filter['by_Section'])){
            //     $this->db->where('student.section_name', $filter['by_Section']);
            // }
    
            if(!empty($filter['by_term_T'])){
                $this->db->where('student.term_name', $filter['by_term_T']);
            }
            if(!empty($filter['by_stream_T'])){
                $this->db->where('student.stream_name', $filter['by_stream_T']);
            }
            if(!empty($filter['by_Section_T'])){
                $this->db->where('student.section_name', $filter['by_Section_T']);
            }
            $this->db->where('student.is_deleted', 0);
            $this->db->where('student.is_active', 1);
            $this->db->order_by('student.student_id', 'ASC');
            $query = $this->db->get();
            return $query->result();
        }

        
    public function getCurrentStudentInfoForTrans()
    {
        $this->db->from('tbl_students_info as student'); 
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.route_id!=', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getStudentPreviousPendingAmt()
    {
        $this->db->select('bus.std_row_id,student.student_name,bus.amount,bus.term_name'); 
        $this->db->from('tbl_pending_amount_bus as bus'); 
        $this->db->join('tbl_students_info as student', 'student.row_id = bus.std_row_id');
        $this->db->where('student.is_deleted', 0);
        $this->db->where('bus.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getCurrentStudentInfoForTransReport($filter)
    {
        $this->db->select('student.row_id as student_row_id,student.student_name,student.student_id,
        student.stream_name,month.month,month.amount,student.route_id,bus.total_amount,bus.pending_balance,bus.bus_fees');
        $this->db->from('tbl_student_bus_management_details as bus'); 
        $this->db->join('tbl_students_info as student','student.row_id  = bus.student_id','left');
        $this->db->join('tbl_transport_month_payment as month','month.payment_id  = bus.row_id','left');
        
        if(!empty($filter['term_name'])){
            $this->db->where('student.term_name', $filter['term_name']);
        }
        if(!empty($filter['month'])){
            $this->db->where('month.month', $filter['month']);
        }
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('bus.is_deleted', 0);
        $this->db->where('student.route_id!=', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getArrearStudentInfoForTransReport($filter)
    {
        $this->db->select('student.row_id as student_row_id,student.student_name,student.student_id,
        student.stream_name,student.route_id,bus.total_amount,bus.pending_balance,bus.bus_fees');
        $this->db->from('tbl_student_bus_management_details as bus'); 
        $this->db->join('tbl_students_info as student','student.row_id  = bus.student_id','left');
        $this->db->join('tbl_pending_amount_bus as bal','bal.std_row_id  = bus.student_id','left');
      
        if(!empty($filter['term_name'])){
            $this->db->where('bus.term_name', $filter['term_name']);
        }
        if(!empty($filter['year'])){
            $this->db->where('bus.intake_year', $filter['year']);
        }
        $this->db->where('student.is_deleted', 0);
        $this->db->where('bus.is_deleted', 0);
        $this->db->where('bal.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getArrearStudentInfoForFeeReport($filter)
    {
        $this->db->select('student.row_id as student_row_id,student.student_name,student.student_id,
        student.stream_name,fee.total_amount,fee.pending_balance,fee.paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee'); 
        $this->db->join('tbl_students_info as student','student.row_id  = fee.application_no','left');
        $this->db->join('tbl_pending_amount as bal','bal.std_row_id  = fee.application_no','left');
      
        if(!empty($filter['term_name'])){
            $this->db->where('fee.term_name', $filter['term_name']);
        }
        if(!empty($filter['year'])){
            $this->db->where('fee.payment_year', $filter['year']);
        }
        $this->db->where('student.is_deleted', 0);
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('bal.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }


    public function getStudentInfoForTransReport($filter)
    {
        $this->db->select('student.row_id,student.student_name,student.student_id,student.term_name,student.stream_name,student.route_id');
       
        $this->db->from('tbl_students_info as student'); 
        $this->db->join('tbl_student_transport_rate_info as route','route.row_id  = student.route_id','left');
        if(!empty($filter['term_name'])){
            $this->db->where('student.term_name', $filter['term_name']);
        }
        if(!empty($filter['bus_no'])){
            $this->db->where('route.bus_no', $filter['bus_no']);
        }
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.cancel_bus_status', 0);
        $this->db->where('student.route_id!=', 0);
        $query = $this->db->get();
        return $query->result();
    }


    public function getStudentRollNo($row_id){
        $this->db->select('student.row_id,student.student_name,student.sat_number,student.term_name,student.section_name,student.student_id,student.admission_no');
          $this->db->from('tbl_students_info as student'); 
          $this->db->where_in('student.student_id', $row_id);
          $this->db->where('student.is_deleted', 0);
         // $this->db->order_by('student.register_no', 'ASC');
          $query = $this->db->get();
          return $query->row();
      }



      public function getSMSReport($filter = '') {
        $this->db->select('std.term_name, 
        std.stream_name, std.section_name,
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
        // $this->db->join('tbl_student_academic_info as acdmic', 'acdmic.application_no = std.application_no','left');
        if (!empty($filter['date_from'])) {
            $this->db->where('log.sent_date >=', $filter['date_from']);
        }
        if (!empty($filter['date_to'])) {
            $this->db->where('log.sent_date <=', $filter['date_to']);
        }
        if (!empty($filter['term_name'])) {
            $this->db->where('std.term_name', $filter['term_name']);
        }
        if (!empty($filter['stream_name'])) {
            $this->db->where('std.stream_name', $filter['stream_name']);
        }
        if (!empty($filter['section_name'])) {
            $this->db->where('std.section_name', $filter['section_name']);
        }
        $this->db->where('std.is_deleted', 0);
        $this->db->where('std.is_active', 1);
        $this->db->order_by('log.sent_date','ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getAbsenteesSMSReport($filter = '') {
        $this->db->select('std.term_name, 
        std.stream_name, std.section_name,
        std.student_id,
        std.student_name,log.date,
        sub.name,std.application_no');
        $this->db->from('tbl_absent_sms_info as log');
        $this->db->join('tbl_students_info as std', 'std.row_id = log.student_id','left');
        $this->db->join('tbl_student_attendance_details as attendance', 'attendance.student_id = std.student_id','left');
        $this->db->join('tbl_class_completed_by_staff as class','class.row_id = attendance.class_row_id','left');
        $this->db->join('tbl_subjects as sub', 'sub.subject_code = class.subject_code','left');
        if (!empty($filter['date_from'])) {
            $this->db->where('log.date >=', $filter['date_from']);
        }
        if (!empty($filter['date_to'])) {
            $this->db->where('log.date <=', $filter['date_to']);
        }
        if (!empty($filter['date_from'])) {
            $this->db->where('attendance.absent_date >=', $filter['date_from']);
        }
        if (!empty($filter['date_to'])) {
            $this->db->where('attendance.absent_date <=', $filter['date_to']);
        }
        if (!empty($filter['term_name'])) {
            $this->db->where('std.term_name', $filter['term_name']);
        }
        if (!empty($filter['stream_name'])) {
            $this->db->where('std.stream_name', $filter['stream_name']);
        }
        if (!empty($filter['section_name'])) {
            $this->db->where('std.section_name', $filter['section_name']);
        }
        $this->db->where('std.is_deleted', 0);
        $this->db->where('std.is_active', 1);
        $this->db->order_by('log.date','ASC');
        $this->db->order_by('std.student_id', 'ASC');
        $this->db->group_by('attendance.row_id');
        $this->db->where('attendance.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
   
    }

    public function getAllStudentInfo_For_FeeDuereport($term_name,$preference,$year){
        $this->db->from('tbl_students_info as student'); 
        $this->db->where('student.term_name', $term_name);
        if(($preference!= 'ALL')){
            $this->db->where('student.stream_name', $preference);
        }
        $this->db->where('student.is_deleted', 0);
        $this->db->where('student.is_active', 1);
        $this->db->where('student.intake_year_id',$year);
        $this->db->order_by('student.stream_name', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    }