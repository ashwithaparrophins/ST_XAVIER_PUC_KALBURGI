<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Application_model extends CI_Model {

    
    public function getAdmissionRegisteredInfoCount($filter=''){
        $this->db->from('tbl_admission_registered_student_temp as reg');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = reg.sslc_board_name_id','left');
    
        if(!empty($filter['name'])) {
            $likeCriteria = "(reg.name LIKE '%".$filter['name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['dob'])) {
            $likeCriteria = "(reg.dob LIKE '%".$filter['dob']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['mobile'])){
            $this->db->where('reg.mobile', $filter['mobile']);
        }
        if(!empty($filter['board_name'])){
            $this->db->where('board.board_name', $filter['board_name']);
        }
        if(!empty($filter['admission_year'])){
            $this->db->where('reg.reg_year', $filter['admission_year']);
        }
        if(!empty($filter['date'])){
            $this->db->where('reg.created_date', $filter['date']);
        }
        if(!empty($filter['email'])){
            $this->db->where('reg.email', $filter['email']);
        }
        // $this->db->where('std.admission_status', 1);
        // $this->db->where('reg.reg_year', 2021);
        $this->db->where('reg.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    //get students fetails lates update
    public function getAdmissionRegisteredInfo($filter=''){
    
        $this->db->select('reg.name,reg.registration_number,reg.mobile,reg.dob,reg.sslc_board_name_id,reg.other_board_name,reg.email,
        reg.created_date,board.board_name');
        $this->db->from('tbl_admission_registered_student_temp as reg');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = reg.sslc_board_name_id','left');
    
        if(!empty($filter['name'])) {
            $likeCriteria = "(reg.name LIKE '%".$filter['name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['dob'])) {
            $likeCriteria = "(reg.dob LIKE '%".$filter['dob']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['mobile'])){
            $this->db->where('reg.mobile', $filter['mobile']);
        }
        if(!empty($filter['board_name'])){
            $this->db->where('board.board_name', $filter['board_name']);
        }
        if(!empty($filter['admission_year'])){
            $this->db->where('reg.reg_year', $filter['admission_year']);
        }
        if(!empty($filter['date'])){
            $this->db->where('reg.created_date', $filter['date']);
        }
        if(!empty($filter['email'])){
            $this->db->where('reg.email', $filter['email']);
        }
        // $this->db->where('reg.reg_year', 2021);
        $this->db->where('reg.is_deleted', 0);
        $this->db->order_by('reg.row_id','DESC'); 
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getAllApplicationInfo($filter)
    {
        $this->db->select('
        personal.resgisted_tbl_row_id,
        approved.application_number, 
        approved.sslc_percentage, 
        approved.ninth_percentage, 
        personal.name,
        personal.father_name,
        personal.father_mobile,
        personal.mother_mobile,
        personal.caste,
        sjpuc.program_name,
        sjpuc.stream_name,
        sjpuc.second_stream_name,
        sjpuc.integrated_batch,
        board.board_name,
        approved.comments,
        exam.register_number, 
        personal.student_mobile, 
        personal.father_mobile, 
        personal.mother_mobile, 
        personal.residential_address_line_1, 
        personal.residential_address_line_2, 
        personal.residential_address_district, 
        personal.residential_address_state, 
        personal.residential_address_pincode');
        $this->db->from('tbl_admission_student_personal_details_temp as personal');
        $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_registered_student_temp as std', 'std.row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = std.sslc_board_name_id','left');
        $this->db->join('tbl_admission_students_status_temp as approved', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
     
        if(!empty($filter['by_category_name'])){
            $this->db->where('personal.caste', $filter['by_category_name']);
        }
        if(!empty($filter['integrated_batch'])){
            $this->db->where('sjpuc.integrated_batch', $filter['integrated_batch']);
        }
        if(!empty($filter['application_no'])){
            $this->db->where('approved.application_number', $filter['application_no']);
        }
        if(!empty($filter['student_name'])){
            $likeCriteria = "(personal.name  LIKE '%".$filter['student_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['father_name'])){
            $likeCriteria = "(personal.father_name  LIKE '%".$filter['father_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_first_preference'])){
            $this->db->where('sjpuc.stream_name', $filter['by_first_preference']);
        }
        if(!empty($filter['by_second_preference'])){
            $this->db->where('sjpuc.second_stream_name', $filter['by_second_preference']);
        }
        if(!empty($filter['by_sports_category'])){
            $this->db->where('sjpuc.national_level_sports_status', $filter['by_sports_category']);
        }
    
        if(!empty($filter['board_name'])){
            $this->db->where('board.board_name', $filter['board_name']);
        }
    
        if(!empty($filter['sslc_pecentage'])){
            $likeCriteria = "(approved.sslc_percentage  LIKE '%".$filter['sslc_pecentage']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['ninth_pecentage'])){
            $likeCriteria = "(personal.ninth_percentage  LIKE '%".$filter['ninth_pecentage']."%')";
            $this->db->where($likeCriteria);
        }
        // if(!empty($filter['sslc_pecentage'])){
        //     $this->db->where('personal.sslc_percentage <=', $filter['sslc_pecentage']);
        // }
        if(!empty($filter['admission_year'])){
            $this->db->where('approved.adm_year', $filter['admission_year']);
        }
        // $this->db->where('approved.adm_year', 2021);
        $this->db->where('approved.application_number !=', '');
        $this->db->where('personal.is_deleted', 0);
        $this->db->where('approved.admission_status', 0);
        $this->db->where('approved.application_fee_status', 1);
        //$this->db->where('approved.shortlisted_status', 0);
        $this->db->where('personal.is_deleted', 0);
        $this->db->where('approved.is_deleted', 0);
        $this->db->order_by('approved.sslc_percentage', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    
    //shortlisted view and count
    public function getAllApplicationInfoCount($filter) {
        $this->db->from('tbl_admission_student_personal_details_temp as personal');
        $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_registered_student_temp as std', 'std.row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = std.sslc_board_name_id','left');
        $this->db->join('tbl_admission_students_status_temp as approved', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
     
        if(!empty($filter['by_category_name'])){
            $this->db->where('personal.caste', $filter['by_category_name']);
        }
        if(!empty($filter['integrated_batch'])){
            $this->db->where('sjpuc.integrated_batch', $filter['integrated_batch']);
        }
        if(!empty($filter['application_no'])){
            $this->db->where('approved.application_number', $filter['application_no']);
        }
        if(!empty($filter['student_name'])){
            $likeCriteria = "(personal.name  LIKE '%".$filter['student_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['father_name'])){
            $likeCriteria = "(personal.father_name  LIKE '%".$filter['father_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_first_preference'])){
            $this->db->where('sjpuc.stream_name', $filter['by_first_preference']);
        }
        if(!empty($filter['second_preference'])){
            $this->db->where('sjpuc.second_stream_name', $filter['second_preference']);
        }
        if(!empty($filter['by_sports_category'])){
            $this->db->where('sjpuc.national_level_sports_status', $filter['by_sports_category']);
        }
    
        if(!empty($filter['board_name'])){
            $this->db->where('board.board_name', $filter['board_name']);
        }
    
    
        if(!empty($filter['sslc_pecentage'])){
            $likeCriteria = "(approved.sslc_percentage  LIKE '%".$filter['sslc_pecentage']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['ninth_pecentage'])){
            $likeCriteria = "(personal.ninth_percentage  LIKE '%".$filter['ninth_pecentage']."%')";
            $this->db->where($likeCriteria);
        }
        // if(!empty($filter['percentage_to'])){
        //     $this->db->where('personal.sslc_percentage <=', $filter['percentage_to']);
        // }
        if(!empty($filter['admission_year'])){
            $this->db->where('approved.adm_year', $filter['admission_year']);
        }
        // $this->db->where('approved.adm_year', 2021);
        $this->db->where('approved.application_number !=', '');
        $this->db->where('personal.is_deleted', 0);
        $this->db->where('approved.admission_status', 0);
        $this->db->where('approved.application_fee_status', 1);
        //$this->db->where('approved.shortlisted_status', 0);
        $this->db->where('personal.is_deleted', 0);
        $this->db->where('approved.is_deleted', 0);
      
        $this->db->order_by('approved.sslc_percentage', 'DESC');
        
        $query = $this->db->get();
        return $query->num_rows();
    }
        
    
    public function getRejectedApplicationInfo($filter){
        
        $this->db->select('
        personal.resgisted_tbl_row_id,
        approved.application_number, 
        approved.sslc_percentage, 
        personal.name,
        personal.father_name,
        personal.father_mobile,
        personal.mother_mobile,
        personal.caste,
        sjpuc.program_name,
        sjpuc.stream_name,
        sjpuc.second_stream_name,
        sjpuc.integrated_batch,
        board.board_name,
        exam.register_number, 
        personal.student_mobile, 
        personal.father_mobile, 
        personal.mother_mobile, 
        approved.comments,
        personal.residential_address_line_1, 
        personal.residential_address_line_2, 
        personal.residential_address_district, 
        personal.residential_address_state, 
        personal.residential_address_pincode');
        $this->db->from('tbl_admission_student_personal_details_temp as personal');
        $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_registered_student_temp as std', 'std.row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = std.sslc_board_name_id','left');
        $this->db->join('tbl_admission_students_status_temp as approved', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
    
        if(!empty($filter['by_category_name'])){
            $this->db->where('personal.caste', $filter['by_category_name']);
        }
        if(!empty($filter['integrated_batch'])){
            $this->db->where('sjpuc.integrated_batch', $filter['integrated_batch']);
        }
        if(!empty($filter['application_no'])){
            $this->db->where('approved.application_number', $filter['application_no']);
        }
        if(!empty($filter['student_name'])){
            $likeCriteria = "(personal.name  LIKE '%".$filter['student_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['father_name'])){
            $likeCriteria = "(personal.father_name  LIKE '%".$filter['father_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_first_preference'])){
            $this->db->where('sjpuc.stream_name', $filter['by_first_preference']);
        }
        if(!empty($filter['second_preference'])){
            $this->db->where('sjpuc.second_stream_name', $filter['second_preference']);
        }
        if(!empty($filter['by_sports_category'])){
            $this->db->where('sjpuc.national_level_sports_status', $filter['by_sports_category']);
        }

        if(!empty($filter['by_board_name'])){
            $this->db->where('board.board_name', $filter['by_board_name']);
        }

        if(!empty($filter['sslc_percentage'])){
            $likeCriteria = "(approved.sslc_percentage  LIKE '%".$filter['sslc_percentage']."%')";
            $this->db->where($likeCriteria);
        }

        if(!empty($filter['admission_year'])){
            $this->db->where('personal.admission_year', $filter['admission_year']);
        }
        
        // $this->db->where('personal.admission_year', 2021);
        $this->db->where('approved.application_number !=', '');
        $this->db->where('personal.is_deleted', 0);
        $this->db->where('approved.admission_status', 2);
        $this->db->order_by('approved.sslc_percentage', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    
    //shortlisted view and count
    public function getRejectedApplicationInfoCount($filter='') {
        $this->db->from('tbl_admission_student_personal_details_temp as personal');
        $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_registered_student_temp as std', 'std.row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = std.sslc_board_name_id','left');
        $this->db->join('tbl_admission_students_status_temp as approved', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
    
        if(!empty($filter['by_category_name'])){
            $this->db->where('personal.caste', $filter['by_category_name']);
        }
        if(!empty($filter['integrated_batch'])){
            $this->db->where('sjpuc.integrated_batch', $filter['integrated_batch']);
        }
        if(!empty($filter['application_no'])){
            $this->db->where('approved.application_number', $filter['application_no']);
        }
        if(!empty($filter['student_name'])){
            $likeCriteria = "(personal.name  LIKE '%".$filter['student_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['father_name'])){
            $likeCriteria = "(personal.father_name  LIKE '%".$filter['father_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_first_preference'])){
            $this->db->where('sjpuc.stream_name', $filter['by_first_preference']);
        }
        if(!empty($filter['second_preference'])){
            $this->db->where('sjpuc.second_stream_name', $filter['second_preference']);
        }
        if(!empty($filter['by_sports_category'])){
            $this->db->where('sjpuc.national_level_sports_status', $filter['by_sports_category']);
        }

        if(!empty($filter['by_board_name'])){
            $this->db->where('board.board_name', $filter['by_board_name']);
        }

        if(!empty($filter['sslc_percentage'])){
            $likeCriteria = "(approved.sslc_percentage  LIKE '%".$filter['sslc_percentage']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['admission_year'])){
            $this->db->where('personal.admission_year', $filter['admission_year']);
        }
    
        // $this->db->where('personal.admission_year', 2021);
        $this->db->where('approved.application_number !=', '');
        $this->db->where('personal.is_deleted', 0);
        $this->db->where('approved.admission_status', 2);
        $query = $this->db->get();
        return $query->num_rows();
    }


    // get stream Name
    function getStreamNamesByProgram($program_name){
        $this->db->from('tbl_program_stream_info as stream');
        $this->db->where('stream.program_name', $program_name);     
        $this->db->order_by('stream.row_id', 'ASC');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }
    function getStreamNames(){
        $this->db->from('tbl_program_stream_info as stream');  
        $this->db->order_by('stream.row_id', 'ASC');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }
    function getBoardName(){
        $this->db->from('tbl_sslc_board_name as board');
        $this->db->where('board.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();   
    }
    function getBoardNameByName($sslc_board_name){
        $this->db->from('tbl_sslc_board_name as board');
        $this->db->where('board.board_name', $sslc_board_name);
        $this->db->where('board.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();   
    }
    function updateBoardInfo($registered_row_id,$boardInfo){
        $this->db->where('row_id', $registered_row_id);
        $this->db->where('is_deleted', 0);
        $this->db->update('tbl_admission_registered_student_temp', $boardInfo);
        return $this->db->affected_rows();
    }
    function getBoardNameById($row_id){
        $this->db->from('tbl_sslc_board_name as board');
        $this->db->join('tbl_admission_registered_student_temp as std', 'std.sslc_board_name_id = board.row_id','left');
        $this->db->where('board.is_deleted', 0);
        $this->db->where('std.row_id', $row_id);
        $query = $this->db->get();
        return $query->row();   
    }
    

    function getCasteInfo(){
        $this->db->from('tbl_caste_details as caste');
        $this->db->where('caste.is_deleted',0);
        $this->db->order_by('caste.name', 'ASC');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    function getStateInfo(){
        $this->db->from('tbl_state as state');
        $this->db->where('state.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();   
    }
    
    function getNationality(){
        $this->db->from('tbl_nationality as nation');
        $this->db->where('nation.is_deleted',0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    function getReligionInfo(){
        $this->db->from('tbl_religion_details as religion');
        $this->db->where('religion.is_deleted',0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }
    function getStreamInfo(){
        $this->db->from('tbl_program_stream_info as stream');
        $this->db->where('stream.is_deleted',0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }
    // personal
    function getStudentApplicationInfo($registered_row_id){
        $this->db->from('tbl_admission_student_personal_details_temp as stud');
        $this->db->join('tbl_admission_students_status_temp as approved', 'approved.registered_row_id = stud.resgisted_tbl_row_id','left');
        $this->db->where('stud.resgisted_tbl_row_id', $registered_row_id);
        $this->db->where('approved.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    // parish
    function getParishPriestInfo($registered_row_id){
        $this->db->from('tbl_admission_priest_certificate_temp as std');
        $this->db->where('std.registered_row_id', $registered_row_id);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();   
    }
    
    function getDocumnetDetails($registred_row_id){
        $this->db->from('tbl_admission_document_details_temp as doc');
        $this->db->where_in('doc.registred_row_id', $registred_row_id);
        $this->db->where('doc.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();   
    }

    
    function getStudentSchoolInfo($registered_row_id){
        $this->db->select('school.name_of_the_school,school.month_of_passed,school.school_address,school.medium_instruction,school.year_of_passed,school.no_of_attempt,school.register_number,
        board.board_name');
        $this->db->from('tbl_admission_school_and_examination_deatils_temp as school');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = school.registred_row_id','left');
        $this->db->join('tbl_admission_registered_student_temp as std', 'std.row_id = school.registred_row_id','left');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = std.sslc_board_name_id','left');
     
        $this->db->where('school.registred_row_id', $registered_row_id);
        $this->db->where('school.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function getStudentMarkInfo($registered_row_id){
        $this->db->from('tbl_admission_student_sslc_mark_info_temp as school');
        $this->db->where('school.registred_row_id', $registered_row_id);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }


    function getStudentApplicationStatus($registered_row_id){
        $this->db->from('tbl_admission_students_status_temp as std');
        $this->db->where('std.registered_row_id', $registered_row_id);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();   
    }

    //get admission info for display
    function getCombinationInfo($registered_row_id){
        $this->db->from('tbl_admission_combination_language_opted_temp as adm');
        $this->db->where('adm.registred_row_id', $registered_row_id);
        $query = $this->db->get();
        return $query->row();
    }

    // update
    function updatePriestCertificate($registered_row_id,$priestCertificateInfo){
        $this->db->where('registered_row_id', $registered_row_id);
        $this->db->update('tbl_admission_priest_certificate_temp', $priestCertificateInfo);
        return $this->db->affected_rows();
    }

    function updateStudentPersonalInfo($registered_row_id,$personalInfo){
        $this->db->where('resgisted_tbl_row_id', $registered_row_id);
        $this->db->where('is_deleted', 0);
        $this->db->update('tbl_admission_student_personal_details_temp', $personalInfo);
        return $this->db->affected_rows();
    }
    function updateStudentSchoolInfo($registered_row_id,$schoolInfo){
        $this->db->where('registred_row_id', $registered_row_id);
        $this->db->where('is_deleted', 0);
        $this->db->update('tbl_admission_school_and_examination_deatils_temp', $schoolInfo);
        return $this->db->affected_rows();
    }
    function updateSSLC_MarkInfo($markInfo,$registered_row_id,$mark_row_id){
        $this->db->where('registred_row_id', $registered_row_id);
        $this->db->where('row_id', $mark_row_id);
        $this->db->update('tbl_admission_student_sslc_mark_info_temp', $markInfo);
        return $this->db->affected_rows();
    }

    function checkSSLCMarkExists($registered_row_id,$course_row_id){
        $this->db->from('tbl_admission_student_sslc_mark_info_temp as school');
        $this->db->where('school.registred_row_id', $registered_row_id);
        $this->db->where_in('school.row_id', $course_row_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function saveStudentSSLC_MarkInfo($markInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_admission_student_sslc_mark_info_temp', $markInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }


    
    function updateStudentCombinationData($register_row_id,$admissionInfo){
        $this->db->where('registred_row_id', $register_row_id);
        $this->db->update('tbl_admission_combination_language_opted_temp', $admissionInfo);
        return $this->db->affected_rows();
    }

    function updatedApplicationStatusByID($registered_row_id,$applicationStatus){
        $this->db->where('registered_row_id', $registered_row_id);
        $this->db->update('tbl_admission_students_status_temp', $applicationStatus);
        return $this->db->affected_rows();
    }

    
    function updateStudentApplicationStatus($application_number,$applicationStatus){
        $this->db->where('application_number', $application_number);
        $this->db->update('tbl_admission_students_status_temp', $applicationStatus);
        return $this->db->affected_rows();
    }

    // dashboard count  - admission
    public function getAdmissionRegisteredStudentCount($admission_year_filter){
        $this->db->from('tbl_admission_registered_student_temp as std');
        $this->db->where('std.reg_year', $admission_year_filter);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function getAdmissionAppliedCount($admission_year_filter){
        $this->db->from('tbl_admission_students_status_temp as std');
        $this->db->where('std.application_number !=', '');        
        $this->db->where('std.is_deleted', 0);  
        $this->db->where('std.adm_year', $admission_year_filter);
        $this->db->group_by('std.application_number');
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getAdmissionApprovedCount($admission_year_filter){
        $this->db->from('tbl_admission_students_status_temp as approve');
        $this->db->where('approve.admission_status', 1);
        $this->db->where('approve.shortlisted_status', 0);
        $this->db->where('approve.application_fee_status', 1);
        $this->db->where('approve.joined_status', 0);
        $this->db->where('approve.submitted_doc_status', 1);
        $this->db->where('approve.interview_status', 0);
        $this->db->where('approve.adm_year', $admission_year_filter);
        $this->db->where('approve.is_deleted', 0);
        $this->db->group_by('approve.application_number');
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getAdmissionRejectedCount($admission_year_filter){
        $this->db->from('tbl_admission_students_status_temp as approve');
        $this->db->where('approve.admission_status', 2);
        $this->db->where('approve.application_fee_status', 1);
        $this->db->where('approve.adm_year', $admission_year_filter);
        $this->db->where('approve.is_deleted', 0);
        $this->db->group_by('approve.application_number');
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function getShortlistedCount($admission_year_filter){
        $this->db->from('tbl_admission_students_status_temp as approved');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->where('approved.is_deleted', 0);
        $this->db->where('approved.shortlisted_status', 1);
        $this->db->where('approved.joined_status', 0);
        $this->db->where('approved.interview_status', 0);
        $this->db->where('approved.cancel_status', 0);
        $this->db->where('approved.adm_year', $admission_year_filter);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function getInterviewedStudentsCount($admission_year_filter){
        $this->db->from('tbl_admission_students_status_temp as approved');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->where('approved.is_deleted', 0);
        $this->db->where('personal.admission_year', $admission_year_filter);
        $this->db->where('approved.shortlisted_status', 1);
        $this->db->where('approved.interview_status', 1);
        //$this->db->where('approved.joined_status', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getAdmissionCompletedCount($admission_year_filter){
        $this->db->from('tbl_admission_students_status_temp as approved');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->where('approved.is_deleted', 0);
        $this->db->where('personal.admission_year', $admission_year_filter);
        $this->db->where('approved.shortlisted_status', 1);
        //$this->db->where('approved.interview_status', 1);
        $this->db->where('approved.joined_status', 1);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getStreamApprovedCount($stream,$admission_year_filter){
        $this->db->from('tbl_program_stream_info as stream');
        $this->db->join('tbl_admission_combination_language_opted_temp as adm', 'adm.stream_name = stream.stream_name','left');
        $this->db->join('tbl_admission_students_status_temp as approve', 'approve.registered_row_id = adm.registred_row_id','left');
        $this->db->where('stream.stream_name', $stream);
        $this->db->where('approve.admission_status', 1);
        $this->db->where('approve.shortlisted_status', 0);
        $this->db->where('approve.application_fee_status', 1);
        $this->db->where('approve.submitted_doc_status', 1);
        $this->db->where('approve.joined_status', 0);
        $this->db->where('approve.interview_status', 0);
        $this->db->where('approve.adm_year', $admission_year_filter);
        $this->db->where('approve.is_deleted', 0);
        $this->db->group_by('approve.application_number');
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getStreamCompletedCount($stream,$admission_year_filter){
        $this->db->from('tbl_program_stream_info as stream');
        $this->db->join('tbl_admission_combination_language_opted_temp as adm', 'adm.stream_name = stream.stream_name','left');
        $this->db->join('tbl_admission_students_status_temp as approve', 'approve.registered_row_id = adm.registred_row_id','left');
        $this->db->where('stream.stream_name', $stream);
        $this->db->where('approve.shortlisted_status', 1);
        $this->db->where('approve.interview_status', 1);
        $this->db->where('approve.joined_status', 1);
        $this->db->where('approve.admission_status', 1);
        $this->db->where('approve.adm_year', $admission_year_filter);
        $this->db->where('approve.is_deleted', 0);
        $this->db->group_by('approve.application_number');
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function getStreamRejectedCount($stream,$admission_year_filter){
        $this->db->from('tbl_program_stream_info as stream');
        $this->db->join('tbl_admission_combination_language_opted_temp as adm', 'adm.stream_name = stream.stream_name','left');
        $this->db->join('tbl_admission_students_status_temp as approve', 'approve.registered_row_id = adm.registred_row_id','left');
        $this->db->where('stream.stream_name', $stream);
        $this->db->where('approve.admission_status', 2);
        $this->db->where('approve.adm_year', $admission_year_filter);
        $this->db->where('approve.is_deleted', 0);
        $this->db->group_by('approve.application_number');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function categoryAdmissionCount($stream,$cat,$admission_year_filter){
        $this->db->from('tbl_admission_students_status_temp as approve');
        $this->db->join('tbl_admission_combination_language_opted_temp as adm', 'adm.registred_row_id = approve.registered_row_id','left');
        $this->db->join('tbl_admission_student_personal_details_temp as per', 'per.resgisted_tbl_row_id = approve.registered_row_id','left');

        $this->db->where('per.caste', $cat);
        $this->db->where('adm.stream_name', $stream);  
        $this->db->where('approve.shortlisted_status', 1);
        $this->db->where('approve.interview_status', 1);
        $this->db->where('approve.joined_status', 1);
        $this->db->where('approve.adm_year', $admission_year_filter);
        $this->db->where('approve.is_deleted', 0);
        $this->db->group_by('approve.application_number');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getElectiveLanguageAdmittedCount($stream,$elective_sub,$admission_year_filter){
        $this->db->from('tbl_admission_combination_language_opted_temp as adm');
        $this->db->join('tbl_admission_students_status_temp as approve', 'approve.registered_row_id = adm.registred_row_id','left');
        $this->db->where('adm.stream_name', $stream);  
        $this->db->where('adm.second_language', $elective_sub); 
        $this->db->where('approve.shortlisted_status', 1);
        $this->db->where('approve.interview_status', 1);
        $this->db->where('approve.joined_status', 1);
        $this->db->where('approve.adm_year', $admission_year_filter);
        $this->db->where('approve.admission_status', 1);
        $this->db->where('approve.is_deleted', 0);
        $this->db->group_by('approve.application_number');
        $query = $this->db->get();
        return $query->num_rows();
    }

    // dashboard application search
    public function getStudentByApplicationNo($application_number,$admission_year){
        $this->db->select('application.application_number,personal.name,personal.caste,personal.father_name,personal.father_mobile,
        personal.mother_name,personal.mother_mobile,language.stream_name,application.admission_status,application.application_fee_status,
        personal.resgisted_tbl_row_id');
        $this->db->from('tbl_admission_student_personal_details_temp as personal');
        $this->db->join('tbl_admission_combination_language_opted_temp as language', 'language.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_students_status_temp as application', 'application.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->where('application.application_number', $application_number);
        $this->db->where('personal.admission_year', $admission_year);
        $this->db->where('personal.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();   
    }
    
    public function getStudentPhotoByApplicationNo($registred_row_id){
        $this->db->from('tbl_admission_document_details_temp as doc');
        $this->db->where('doc.registred_row_id', $registred_row_id);
        $this->db->where('doc.doc_name', 'student_photo');
        $this->db->where('doc.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();   
    }


    // shortlisted application
    public function getShortlistedStudentsCount($filter=''){
        $this->db->from('tbl_admission_students_status_temp as approved');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_registered_student_temp as std', 'std.row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = std.sslc_board_name_id','left');
        $this->db->join('tbl_admission_shortlisted_student_info as shortlisted', 'shortlisted.application_no = approved.application_number','left');

    
        if(!empty($filter['shortlisted_list_number'])){
            $this->db->where('approved.shortlisted_list_number', $filter['shortlisted_list_number']);
        }

        if(!empty($filter['by_category_name'])){
            $this->db->where('approved.student_category', $filter['by_category_name']);
        }
        if(!empty($filter['application_number'])){
            $this->db->where('approved.application_number', $filter['application_number']);
        }
        if(!empty($filter['student_name'])){
            $likeCriteria = "(personal.name  LIKE '%".$filter['student_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['father_name'])){
            $likeCriteria = "(personal.father_name  LIKE '%".$filter['father_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_first_preference'])){
            $this->db->where('sjpuc.stream_name', $filter['by_first_preference']);
        }
        if(!empty($filter['by_sports_category'])){
            $this->db->where('sjpuc.national_level_sports_status', $filter['by_sports_category']);
        }

        if(!empty($filter['by_board_name'])){
            $this->db->where('board.board_name', $filter['by_board_name']);
        }
        if(!empty($filter['by_interview_date'])){
            $this->db->where('shortlisted.interview_date', $filter['by_interview_date']);
        }
        if(!empty($filter['integrated_batch'])){
            $this->db->where('sjpuc.integrated_batch', $filter['integrated_batch']);
        }
        //sms status
        if(!empty($filter['sms_status'])){
            if($filter['sms_status'] == 'Cancelled'){
                $this->db->where('approved.interview_status', 0);
            }else if($filter['sms_status'] == 'Active'){
                $this->db->where('approved.interview_status', 1);
            }
        }

        if(!empty($filter['admission_status'])){
            if($filter['admission_status'] == 'NOT PAID'){
                $this->db->where('approved.joined_status', 0);
            }else if($filter['admission_status'] == 'PAID'){
                $this->db->where('approved.joined_status', 1);
            }
        }


        if(!empty($filter['by_program_name'])){
            $this->db->where('sjpuc.program_name', $filter['by_program_name']);
        }

        if(!empty($filter['by_stream_name'])){
            $this->db->where('sjpuc.stream_name', $filter['by_stream_name']);
        }

        if(!empty($filter['shortlisted_by'])){
            $this->db->where('approved.shortlisted_by', $filter['shortlisted_by']);
        }

        if(!empty($filter['percentage_from'])){
            $this->db->where('approved.sslc_percentage >=', $filter['percentage_from']);
        }
        if(!empty($filter['percentage_to'])){
            $this->db->where('approved.sslc_percentage <=', $filter['percentage_to']);
        }
        
        if(!empty($filter['admission_year'])){
            $this->db->where('approved.adm_year', $filter['admission_year']);
        }

        $this->db->where('approved.is_deleted', 0);
        // $this->db->where('personal.admission_year', 2021);
        $this->db->where('approved.application_number !=', '');
        $this->db->where('approved.shortlisted_status', 1);
        //$this->db->where('approved.submitted_doc_status', 1);
        $this->db->where('approved.application_fee_status', 1);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getShortlistedStudentsDetails($filter) {
        $this->db->select('personal.resgisted_tbl_row_id,
        approved.application_number, 
        personal.name,
        personal.religion,
        personal.father_name,
        personal.mother_name,
        personal.father_mobile,
        personal.mother_mobile,
        personal.student_mobile,
        sjpuc.program_name,
        sjpuc.stream_name,
        sjpuc.second_stream_name,
        sjpuc.integrated_batch,
        board.board_name,
        approved.shortlisted_by,
        approved.sslc_percentage,
        approved.student_category,
        approved.sms_status,
        approved.admission_status,
        approved.cancel_status,
        approved.joined_status,
        approved.interview_status,
        approved.shortlisted_list_number,
        exam.register_number,
        shortlisted.interview_date,
        shortlisted.shortlisted_date,
        shortlisted.shortlisted_by as shortlistedBy,
        shortlisted.any_comments,
        shortlisted.interview_link');
    
        $this->db->from('tbl_admission_students_status_temp as approved');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_registered_student_temp as std', 'std.row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = std.sslc_board_name_id','left');
        $this->db->join('tbl_admission_shortlisted_student_info as shortlisted', 'shortlisted.application_no = approved.application_number','left');

        if(!empty($filter['shortlisted_list_number'])){
            $this->db->where('approved.shortlisted_list_number', $filter['shortlisted_list_number']);
        }

        if(!empty($filter['by_category_name'])){
            $this->db->where('approved.student_category', $filter['by_category_name']);
        }
        if(!empty($filter['application_number'])){
            $this->db->where('approved.application_number', $filter['application_number']);
        }
        if(!empty($filter['student_name'])){
            $likeCriteria = "(personal.name  LIKE '%".$filter['student_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['father_name'])){
            $likeCriteria = "(personal.father_name  LIKE '%".$filter['father_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_stream_name'])){
            $this->db->where('sjpuc.stream_name', $filter['by_stream_name']);
        }
        if(!empty($filter['integrated_batch'])){
            $this->db->where('sjpuc.integrated_batch', $filter['integrated_batch']);
        }
        if(!empty($filter['by_sports_category'])){
            $this->db->where('sjpuc.national_level_sports_status', $filter['by_sports_category']);
        }

        if(!empty($filter['by_board_name'])){
            $this->db->where('board.board_name', $filter['by_board_name']);
        }
        if(!empty($filter['by_interview_date'])){
            $this->db->where('shortlisted.interview_date', $filter['by_interview_date']);
        }
        //sms status
        if(!empty($filter['sms_status'])){
            if($filter['sms_status'] == 'Cancelled'){
                $this->db->where('approved.interview_status', 0);
            }else if($filter['sms_status'] == 'Active'){
                $this->db->where('approved.interview_status', 1);
            }
        }

        if(!empty($filter['admission_status'])){
            if($filter['admission_status'] == 'NOT PAID'){
                $this->db->where('approved.joined_status', 0);
            }else if($filter['admission_status'] == 'PAID'){
                $this->db->where('approved.joined_status', 1);
            }
        }


        if(!empty($filter['by_program_name'])){
            $this->db->where('sjpuc.program_name', $filter['by_program_name']);
        }

        if(!empty($filter['shortlisted_by'])){
            $this->db->where('approved.shortlisted_by', $filter['shortlisted_by']);
        }

        if(!empty($filter['percentage_from'])){
            $this->db->where('approved.sslc_percentage >=', $filter['percentage_from']);
        }
        if(!empty($filter['percentage_to'])){
            $this->db->where('approved.sslc_percentage <=', $filter['percentage_to']);
        }
        if(!empty($filter['admission_year'])){
            $this->db->where('personal.admission_year', $filter['admission_year']);
        }
        
        $this->db->where('approved.is_deleted', 0);
        // $this->db->where('personal.admission_year', 2021);
       // $this->db->where('personal.application_number !=', '');
        $this->db->where('approved.shortlisted_status', 1);
        $this->db->where('approved.submitted_doc_status', 1);
        $this->db->where('approved.application_fee_status', 1);
        $this->db->order_by('approved.sslc_percentage', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    // approved
    public function getApprovedStudentsCount($filter='') {
        $this->db->from('tbl_admission_students_status_temp as approved');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_registered_student_temp as std', 'std.row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = std.sslc_board_name_id','left');

    
        if(!empty($filter['by_category_name'])){
            $this->db->where('approved.student_category', $filter['by_category_name']);
        }
        if(!empty($filter['integrated_batch'])){
            $this->db->where('sjpuc.integrated_batch', $filter['integrated_batch']);
        }
        if(!empty($filter['application_number'])){
            $this->db->where('approved.application_number', $filter['application_number']);
        }
        if(!empty($filter['student_name'])){
            $likeCriteria = "(personal.name  LIKE '%".$filter['student_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['father_name'])){
            $likeCriteria = "(personal.father_name  LIKE '%".$filter['father_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_first_preference'])){
            $this->db->where('sjpuc.stream_name', $filter['by_first_preference']);
        }
        if(!empty($filter['by_second_preference'])){
            $this->db->where('sjpuc.second_stream_name', $filter['by_second_preference']);
        }

        if(!empty($filter['by_sports_category'])){
            $this->db->where('sjpuc.national_level_sports_status', $filter['by_sports_category']);
        }

        if(!empty($filter['by_board_name'])){
            $this->db->where('board.board_name', $filter['by_board_name']);
        }

        if(!empty($filter['percentage_from'])){
            $this->db->where('approved.sslc_percentage', $filter['percentage_from']);
        }

        if(!empty($filter['ninth_percentage'])){
            $this->db->where('approved.ninth_percentage', $filter['ninth_percentage']);
        }
        
        if(!empty($searchText)){
            $this->db->where('approved.application_number', $searchText);
        }
        if(!empty($filter['sms_status'])){
            if($filter['sms_status'] == 'Pending'){
                $this->db->where('approved.shortlisted_status', 0);
            }else if($filter['sms_status'] == 'Shortlisted'){
                $this->db->where('approved.shortlisted_status', 1);
            }
        }

        if(!empty($filter['admission_year'])){
            $this->db->where('personal.admission_year', $filter['admission_year']);
        }
        
        // $this->db->where('personal.student_application_status', 1);
        $this->db->where('approved.application_number !=', '');
        $this->db->where('approved.admission_status', 1);
        // $this->db->where('personal.admission_year', 2021);
        $this->db->where('approved.is_deleted', 0);
        $this->db->where('approved.shortlisted_status', 0);
        $this->db->where('approved.application_fee_status', 1);
        $this->db->where('approved.submitted_doc_status', 1);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getApprovedStudentsDetails($filter) {
        $this->db->select('personal.resgisted_tbl_row_id,
        approved.application_number, 
        personal.name,
        personal.religion,
        personal.father_name,
        personal.father_mobile,
        personal.mother_mobile,
        personal.student_mobile,
        sjpuc.program_name,
        sjpuc.stream_name,
        sjpuc.second_stream_name,
        sjpuc.integrated_batch,
        board.board_name,
        approved.sslc_percentage,
        approved.ninth_percentage,
        approved.student_category,
        approved.shortlisted_status,
        approved.comments,
        personal.student_mobile, 
        personal.father_mobile, 
        personal.mother_mobile, 
        personal.residential_address_line_1, 
        personal.residential_address_line_2, 
        personal.residential_address_district, 
        personal.residential_address_state, 
        personal.residential_address_pincode,
        exam.register_number');
        $this->db->from('tbl_admission_students_status_temp as approved');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_registered_student_temp as std', 'std.row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = std.sslc_board_name_id','left');
    
        if(!empty($filter['by_category_name'])){
            $this->db->where('approved.student_category', $filter['by_category_name']);
        }
        if(!empty($filter['integrated_batch'])){
            $this->db->where('sjpuc.integrated_batch', $filter['integrated_batch']);
        }
        if(!empty($filter['application_number'])){
            $this->db->where('approved.application_number', $filter['application_number']);
        }
        if(!empty($filter['student_name'])){
            $likeCriteria = "(personal.name  LIKE '%".$filter['student_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['father_name'])){
            $likeCriteria = "(personal.father_name  LIKE '%".$filter['father_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_first_preference'])){
            $this->db->where('sjpuc.stream_name', $filter['by_first_preference']);
        }
        if(!empty($filter['by_second_preference'])){
            $this->db->where('sjpuc.second_stream_name', $filter['by_second_preference']);
        }

        if(!empty($filter['by_sports_category'])){
            $this->db->where('sjpuc.national_level_sports_status', $filter['by_sports_category']);
        }

        if(!empty($filter['by_board_name'])){
            $this->db->where('board.board_name', $filter['by_board_name']);
        }

        if(!empty($filter['percentage_from'])){
            $this->db->where('approved.sslc_percentage', $filter['percentage_from']);
        }

        if(!empty($filter['ninth_percentage'])){
            $this->db->where('approved.ninth_percentage', $filter['ninth_percentage']);
        }
        
        if(!empty($searchText)){
            $this->db->where('approved.application_number', $searchText);
        }

        if(!empty($filter['sms_status'])){
            if($filter['sms_status'] == 'Pending'){
                $this->db->where('approved.shortlisted_status', 0);
            }else if($filter['sms_status'] == 'Shortlisted'){
                $this->db->where('approved.shortlisted_status', 1);
            }
        }
        if(!empty($filter['admission_year'])){
            $this->db->where('personal.admission_year', $filter['admission_year']);
        }
        
        // $this->db->where('personal.student_application_status', 1);
        $this->db->where('approved.application_number !=', '');
        $this->db->where('approved.admission_status', 1);
        // $this->db->where('personal.admission_year', 2021);
        $this->db->where('approved.is_deleted', 0);
        $this->db->where('approved.shortlisted_status', 0);
        $this->db->where('approved.application_fee_status', 1);
        $this->db->where('approved.submitted_doc_status', 1);
        $this->db->order_by('approved.sslc_percentage', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getFeePendingApplication($filter=''){
        $this->db->select('std.resgisted_tbl_row_id,std.row_id,std.application_number,std.name,std.gender,std.student_email,
        std.dob,std.blood_group,std.father_name,std.mother_name,std.father_mobile,std.mother_mobile,sjpuc.program_name,sjpuc.stream_name,
        std.nationality,std.religion,std.caste');
        $this->db->from('tbl_admission_student_personal_details_temp as std');
        $this->db->join('tbl_admission_students_status_temp as status', 'status.registered_row_id = std.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = std.resgisted_tbl_row_id','left');

        if(!empty($filter['application_no'])){
            $likeCriteria = "(std.application_number  LIKE '%" . $filter['application_no'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_name'])){
            $likeCriteria = "(std.name  LIKE '%" . $filter['by_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_gender'])){
            $this->db->where('std.gender', $filter['by_gender']);
        }
        if(!empty($filter['by_dob'])){
            $this->db->where('std.dob', $filter['by_dob']);
        }
        if(!empty($filter['by_class'])){
            $this->db->where('std.admission_for', $filter['by_class']);
        }
        if(!empty($filter['program_name'])){
            $this->db->where('sjpuc.program_name', $filter['program_name']);
        }
        
        if(!empty($filter['stream_name'])){
            $this->db->where('sjpuc.stream_name', $filter['stream_name']);
        }
        if(!empty($filter['religion'])){
            $this->db->where('std.religion', $filter['religion']);
        }
        if(!empty($filter['admission_year'])){
            $this->db->where('std.admission_year', $filter['admission_year']);
        }
        
        $this->db->where('std.is_deleted', 0);
        $this->db->where('status.application_number !=', '');
        $this->db->where('status.application_fee_status', 0);
        $this->db->order_by('std.row_id', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getFeePendingApplicationCount($filter='') {
            $this->db->from('tbl_admission_student_personal_details_temp as std');
            $this->db->join('tbl_admission_students_status_temp as status', 'status.registered_row_id = std.resgisted_tbl_row_id','left');
            $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = std.resgisted_tbl_row_id','left');
    
            if(!empty($filter['application_no'])){
                $likeCriteria = "(std.application_number  LIKE '%" . $filter['application_no'] . "%')";
                $this->db->where($likeCriteria);
            }
            if(!empty($filter['by_name'])){
                $likeCriteria = "(std.name  LIKE '%" . $filter['by_name'] . "%')";
                $this->db->where($likeCriteria);
            }
            if(!empty($filter['by_gender'])){
                $this->db->where('std.gender', $filter['by_gender']);
            }
            if(!empty($filter['by_dob'])){
                $this->db->where('std.dob', $filter['by_dob']);
            }
            if(!empty($filter['by_class'])){
                $this->db->where('std.admission_for', $filter['by_class']);
            }
            if(!empty($filter['program_name'])){
                $this->db->where('sjpuc.program_name', $filter['program_name']);
            }
            
            if(!empty($filter['stream_name'])){
                $this->db->where('sjpuc.stream_name', $filter['stream_name']);
            }
            if(!empty($filter['religion'])){
                $this->db->where('std.religion', $filter['religion']);
            }
            if(!empty($filter['admission_year'])){
                $this->db->where('std.admission_year', $filter['admission_year']);
            }
            
            $this->db->where('std.is_deleted', 0);
            $this->db->where('status.application_number !=', '');
            $this->db->where('status.application_fee_status', 0);
            $query = $this->db->get();
            return $query->num_rows();
        }
        // check admission status
        public function checkStudentAdmissionStatus($registered_row_id){
            $this->db->from('tbl_admission_students_status_temp as std');
            $this->db->where('std.registered_row_id', $registered_row_id);
            $this->db->where('std.is_deleted', 0);
            $query = $this->db->get();
            return $query->row();
        }
        function updateStudentApplicationInfoStatus($registered_row_id,$applicationStatus){
            $this->db->where('registered_row_id', $registered_row_id);
            $this->db->update('tbl_admission_students_status_temp', $applicationStatus);
            return $this->db->affected_rows();
        }

        function saveStudentApplicationStatus($applicationStatus){
            $this->db->trans_start();
            $this->db->insert('tbl_admission_students_status_temp', $applicationStatus);
            $insert_id = $this->db->insert_id(); 
            $this->db->trans_complete();
            return $insert_id;
        }

    // update application status
    function updatedStudentApplicationStatus($shortlistedStstus,$application_number){
        $this->db->where('application_number', $application_number);
        $this->db->where('is_deleted', 0);
        $this->db->update('tbl_admission_students_status_temp', $shortlistedStstus);
        return $this->db->affected_rows();
    }

    function getAdmissionGrievanceListing($filter='', $page, $segment){
        $this->db->select('support.row_id,support.registered_row_id,support.subject,support.message,support.status,support.created_date_time,
        personal.name,personal.student_mobile,personal.father_mobile');
        $this->db->from('tbl_admission_contact_us as support');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'personal.resgisted_tbl_row_id = support.registered_row_id','left');
        
        if(!empty($filter['by_date'])){
            $likeCriteria = "(support.created_date_time  LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['register_row_id'])){
            $this->db->where('support.registered_row_id', $filter['register_row_id']);
        }
        if(!empty($filter['student_name'])){
            $likeCriteria = "(personal.name  LIKE '%".$filter['student_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['student_mobile_no'])){
            $likeCriteria = "(personal.student_mobile  LIKE '%".$filter['student_mobile_no']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['father_mobile_no'])){
            $likeCriteria = "(personal.father_mobile  LIKE '%".$filter['father_mobile_no']."%')";
            $this->db->where($likeCriteria);
        }

        $this->db->where('support.is_deleted', 0);
        $this->db->where('personal.is_deleted', 0);
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        return $query->result();   
    }

    function getAdmissionGrievanceListingCount($filter=''){
        $this->db->select('support.row_id,support.registered_row_id,support.subject,support.message,support.status,support.created_date_time,
        personal.name,personal.student_mobile,personal.father_mobile');
        $this->db->from('tbl_admission_contact_us as support');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'personal.resgisted_tbl_row_id = support.registered_row_id','left');
        
        if(!empty($filter['by_date'])){
            $likeCriteria = "(support.created_date_time  LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['register_row_id'])){
            $this->db->where('support.registered_row_id', $filter['register_row_id']);
        }
        if(!empty($filter['student_name'])){
            $likeCriteria = "(personal.name  LIKE '%".$filter['student_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['student_mobile_no'])){
            $likeCriteria = "(personal.student_mobile  LIKE '%".$filter['student_mobile_no']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['father_mobile_no'])){
            $likeCriteria = "(personal.father_mobile  LIKE '%".$filter['father_mobile_no']."%')";
            $this->db->where($likeCriteria);
        }

        $this->db->where('support.is_deleted', 0);
        $this->db->where('personal.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();   
    }


    //download merit list info
    public function getMertListDetailsApproved($preference,$category,$board_name,$percentage_from,$percentage_to,$type,$student_type="")
    {
        $this->db->select('personal.resgisted_tbl_row_id,
        approved.application_number, 
        personal.dyslexia_challenged,
        personal.physically_challenged,
        sjpuc.ncc_certificate_status,
        sjpuc.national_level_sports_status,
        personal.name,
        sjpuc.stream_name,
        board.board_name,
        approved.sslc_percentage,
        approved.student_category');
        $this->db->from('tbl_admission_students_status_temp as approved');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_registered_student_temp as std', 'std.row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = std.sslc_board_name_id','left');
        
        if(!empty($student_type)){
            if($student_type == 'NCC'){
                $this->db->where('sjpuc.ncc_certificate_status', 'YES');
            }else if($student_type == 'SPORTS'){
                $this->db->where('sjpuc.national_level_sports_status', 'YES');
            }else if($student_type == 'DYC'){
                $this->db->where('personal.dyslexia_challenged', 'YES');
            }else if($student_type == 'PH'){
                $this->db->where('personal.physically_challenged', 'YES');
            }
        }

        if(!empty($board_name)){
            $this->db->where('board.board_name', $board_name);
        }

        if(!empty($percentage_from)){
            $this->db->where('personal.sslc_percentage >=', $percentage_from);
        }
        if(!empty($percentage_to)){
            $this->db->where('personal.sslc_percentage <=', $percentage_to);
        }

        if(!empty($preference)){
            $this->db->where('sjpuc.stream_name', $preference);
        }
        
        //$this->db->where('approved.shortlisted_status', 1);
        $this->db->where('approved.student_category', $category);
        $this->db->where('personal.admission_year', 2021);
        // $this->db->where('personal.student_application_status', 1);
        $this->db->where('approved.admission_status', 1);
        $this->db->where('approved.is_deleted', 0);
        // $this->db->where('approved.shortlisted_status', 1);
        // $this->db->where('approved.submitted_doc_status', 1);
        $this->db->order_by('approved.sslc_percentage', 'DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

        
    //download merit list info
    public function getMertListDetails($preference,$category,$board_name,$percentage_from,$percentage_to,$type,$student_type="")
    {
        $this->db->select('personal.resgisted_tbl_row_id,
        approved.application_number, 
        personal.dyslexia_challenged,
        personal.religion,
        personal.physically_challenged,
        sjpuc.ncc_certificate_status,
        sjpuc.national_level_sports_status,
        sjpuc.second_language,
        personal.name,
        sjpuc.stream_name,
        board.board_name,
        approved.sslc_percentage,
        
        approved.student_category');
        $this->db->from('tbl_admission_students_status_temp as approved');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_registered_student_temp as std', 'std.row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = std.sslc_board_name_id','left');
        
        if(!empty($student_type)){
            if($student_type == 'NCC'){
                $this->db->where('sjpuc.ncc_certificate_status', 'YES');
            }else if($student_type == 'SPORTS'){
                $this->db->where('sjpuc.national_level_sports_status', 'YES');
            }else if($student_type == 'DYC'){
                $this->db->where('personal.dyslexia_challenged', 'YES');
            }else if($student_type == 'PH'){
                $this->db->where('personal.physically_challenged', 'YES');
            }
        }

        if(!empty($board_name)){
            $this->db->where('board.board_name', $board_name);
        }

        if(!empty($percentage_from)){
            $this->db->where('personal.sslc_percentage >=', $percentage_from);
        }
        if(!empty($percentage_to)){
            $this->db->where('personal.sslc_percentage <=', $percentage_to);
        }

        if(!empty($preference)){
            $this->db->where('sjpuc.stream_name', $preference);
        }
        if($type != "ALL"){
            
        }
        // $this->db->where('approved.shortlisted_status', 1);
        // $this->db->where('approved.student_category', $category);
        // $this->db->where('personal.admission_year', 2020);
        // // $this->db->where('personal.student_application_status', 1);
        // $this->db->where('approved.admission_status', 1);
        // $this->db->where('approved.is_deleted', 0);
        //  $this->db->where('approved.shortlisted_status', 1);
        // // $this->db->where('approved.submitted_doc_status', 1);
        // $this->db->order_by('approved.sslc_percentage', 'DESC');
        // $query = $this->db->get();
        // $result = $query->result();
        // return $result;
            $list = array('3','4');
        $this->db->where('approved.shortlisted_status', 1);
        $this->db->where('approved.student_category', $category);
        $this->db->where('personal.admission_year', 2021);
        // $this->db->where('personal.student_application_status', 1);
        $this->db->where('approved.admission_status', 1);
        $this->db->where('approved.is_deleted', 0);
        $this->db->where_in('approved.shortlisted_list_number', $list);
        // $this->db->where('approved.joined_status', 1);
        $this->db->order_by('approved.sslc_percentage', 'DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function getAllShortlistedList($preference,$category,$board_name,$percentage_from,$percentage_to,$type,$student_type="",$admission_year,$shortlist_number,$integrated_batch)
    {
        $this->db->select('personal.resgisted_tbl_row_id,
        personal.father_mobile,
        personal.mother_mobile,
        approved.application_number, 
        personal.dyslexia_challenged,
        personal.religion,
        personal.physically_challenged,
        sjpuc.ncc_certificate_status,
        sjpuc.national_level_sports_status,
        sjpuc.second_language,
        sjpuc.integrated_batch,
        personal.name,
        sjpuc.stream_name,
        board.board_name,
        approved.sslc_percentage,
        
        approved.student_category');
        $this->db->from('tbl_admission_students_status_temp as approved');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_registered_student_temp as std', 'std.row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = std.sslc_board_name_id','left');
        
        if(!empty($student_type)){
            if($student_type == 'NCC'){
                $this->db->where('sjpuc.ncc_certificate_status', 'YES');
            }else if($student_type == 'SPORTS'){
                $this->db->where('sjpuc.national_level_sports_status', 'YES');
            }else if($student_type == 'DYC'){
                $this->db->where('personal.dyslexia_challenged', 'YES');
            }else if($student_type == 'PH'){
                $this->db->where('personal.physically_challenged', 'YES');
            }
        }

        if(!empty($integrated_batch)){
            $this->db->where('sjpuc.integrated_batch', $integrated_batch);
        }

        if(!empty($board_name)){
            $this->db->where('board.board_name', $board_name);
        }

        if(!empty($percentage_from)){
            $this->db->where('personal.sslc_percentage >=', $percentage_from);
        }
        if(!empty($percentage_to)){
            $this->db->where('personal.sslc_percentage <=', $percentage_to);
        }

        if($preference != 'ALL'){
            $this->db->where('sjpuc.stream_name', $preference);
        }
        // if($type != "ALL"){
            
        // }
        // $this->db->where('approved.shortlisted_status', 1);
        // $this->db->where('approved.student_category', $category);
        // $this->db->where('personal.admission_year', 2020);
        // // $this->db->where('personal.student_application_status', 1);
        // $this->db->where('approved.admission_status', 1);
        // $this->db->where('approved.is_deleted', 0);
        //  $this->db->where('approved.shortlisted_status', 1);
        // // $this->db->where('approved.submitted_doc_status', 1);
        // $this->db->order_by('approved.sslc_percentage', 'DESC');
        // $query = $this->db->get();
        // $result = $query->result();
        // return $result;
           // $list = array('3','4');
        $this->db->where('approved.shortlisted_status', 1);
        $this->db->where('approved.student_category', $category);
        $this->db->where('personal.admission_year', $admission_year);
        // $this->db->where('personal.student_application_status', 1);
        $this->db->where('approved.admission_status', 1);
        $this->db->where('approved.is_deleted', 0);
        if(!empty($shortlist_number)){
        $this->db->where('approved.shortlisted_list_number', $shortlist_number);
        }
        // $this->db->where('approved.joined_status', 1);
        $this->db->order_by('approved.sslc_percentage', 'DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }




    public function getAllShortlistedList_PDF($preference)
    {
        $this->db->select('personal.resgisted_tbl_row_id,
        personal.father_mobile,
        personal.mother_mobile,
        approved.application_number, 
        personal.dyslexia_challenged,
        personal.religion,
        personal.physically_challenged,
        sjpuc.ncc_certificate_status,
        sjpuc.national_level_sports_status,
        sjpuc.second_language,
        personal.name,
        sjpuc.stream_name,
        board.board_name,
        approved.sslc_percentage,
        
        approved.student_category');
        $this->db->from('tbl_admission_students_status_temp_list as approved');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_registered_student_temp as std', 'std.row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = std.sslc_board_name_id','left');
        
        $this->db->where('sjpuc.stream_name', $preference);
        
        $this->db->where('approved.shortlisted_status', 1);
      
        $this->db->where('approved.adm_year', 2022);
        // $this->db->where('personal.student_application_status', 1);
        $this->db->where('approved.admission_status', 1);
        $this->db->where('approved.is_deleted', 0);
        $list_array = array('6');
        $this->db->where_in('approved.shortlisted_list_number', $list_array);
        // $this->db->where('approved.joined_status', 1);
        $this->db->order_by('approved.application_number', 'DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getApprovedListDetails($preference,$category,$board_name,$percentage_from,$percentage_to,$type,$student_type="",$report_type,$admission_year,$integrated_batch)
    {
        $this->db->select('personal.resgisted_tbl_row_id,
        approved.application_number, 
        personal.dyslexia_challenged,
        personal.religion,
        personal.physically_challenged,
        sjpuc.ncc_certificate_status,
        sjpuc.national_level_sports_status,
        sjpuc.second_language,
        sjpuc.integrated_batch,
        personal.name,
        sjpuc.stream_name,
        board.board_name,
        approved.sslc_percentage,
        
        approved.student_category');
        $this->db->from('tbl_admission_students_status_temp as approved');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_registered_student_temp as std', 'std.row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = std.sslc_board_name_id','left');
        
        if(!empty($student_type)){
            if($student_type == 'NCC'){
                $this->db->where('sjpuc.ncc_certificate_status', 'YES');
            }else if($student_type == 'SPORTS'){
                $this->db->where('sjpuc.national_level_sports_status', 'YES');
            }else if($student_type == 'DYC'){
                $this->db->where('personal.dyslexia_challenged', 'YES');
            }else if($student_type == 'PH'){
                $this->db->where('personal.physically_challenged', 'YES');
            }
        }

        if(!empty($integrated_batch)){
            $this->db->where('sjpuc.integrated_batch', $integrated_batch);
        }

        if(!empty($board_name)){
            $this->db->where('board.board_name', $board_name);
        }

        if(!empty($percentage_from)){
            $this->db->where('personal.sslc_percentage >=', $percentage_from);
        }
        if(!empty($percentage_to)){
            $this->db->where('personal.sslc_percentage <=', $percentage_to);
        }

        if(!empty($preference)){
            $this->db->where('sjpuc.stream_name', $preference);
        }
        // if($type != "ALL"){
            
        // }
        // if(!empty($report_type == 'APPLICATION_APPROVED')){
            // if($report_type == 'APPLICATION_APPROVED'){
            //     $this->db->where('approved.admission_status', 1);
            //     $this->db->where('approved.shortlisted_status', 0);
            //     $this->db->where('approved.approved_date !=','');
            //     // $this->db->where('approved.joined_status', 0);
            // }else 
            if($report_type == 'APPLICATION_REJECTED'){
                $this->db->where('approved.admission_status', 2);
                $this->db->where('approved.shortlisted_status', 0);
            }
            
        // }
        // $this->db->where('approved.shortlisted_status', 1);
        // $this->db->where('approved.student_category', $category);
        // $this->db->where('personal.admission_year', 2020);
        // // $this->db->where('personal.student_application_status', 1);
        // $this->db->where('approved.admission_status', 1);
        // $this->db->where('approved.is_deleted', 0);
        //  $this->db->where('approved.shortlisted_status', 1);
        // // $this->db->where('approved.submitted_doc_status', 1);
        // $this->db->order_by('approved.sslc_percentage', 'DESC');
        // $query = $this->db->get();
        // $result = $query->result();
        // return $result;
           // $list = array('3','4');
        $this->db->where('approved.student_category', $category);
        $this->db->where('approved.adm_year', $admission_year);
        // $this->db->where('personal.student_application_status', 1);
        // $this->db->where('approved.admission_status', 1);
        $this->db->where('approved.is_deleted', 0);
       // $this->db->where_in('approved.shortlisted_list_number', $list);
        // $this->db->where('approved.joined_status', 1);
        $this->db->order_by('approved.sslc_percentage', 'DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }




    public function getApplicationFeePaidDetails($filter="")
    {
        $this->db->select('personal.resgisted_tbl_row_id,
        approved.application_number, 
        personal.dyslexia_challenged,
        personal.religion,
        personal.name,
        personal.physically_challenged,
        sjpuc.ncc_certificate_status,
        sjpuc.national_level_sports_status,
        sjpuc.second_language,
        sjpuc.integrated_batch,
        personal.name,
        sjpuc.stream_name,
        board.board_name,
        approved.sslc_percentage,
        
        approved.student_category');
        $this->db->from('tbl_admission_students_status_temp as approved');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_registered_student_temp as std', 'std.row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = std.sslc_board_name_id','left');
        
     

        
        // if(!empty($preference)){
        //     $this->db->where('sjpuc.stream_name', $preference);
        // }
        // if($type != "ALL"){
            
        // }
        // if(!empty($report_type == 'APPLICATION_APPROVED')){
          
            
        // }
        // $this->db->where('approved.shortlisted_status', 1);
        // $this->db->where('approved.student_category', $category);
        // $this->db->where('personal.admission_year', 2020);
        // // $this->db->where('personal.student_application_status', 1);
        // $this->db->where('approved.admission_status', 1);
        // $this->db->where('approved.is_deleted', 0);
        //  $this->db->where('approved.shortlisted_status', 1);
        // // $this->db->where('approved.submitted_doc_status', 1);
        // $this->db->order_by('approved.sslc_percentage', 'DESC');
        // $query = $this->db->get();
        // $result = $query->result();
        // return $result;
           // $list = array('3','4');
        $this->db->where('approved.adm_year', 2022);
        $this->db->where('approved.application_number!=','');
        // $this->db->where('personal.student_application_status', 1);
        // $this->db->where('approved.admission_status', 1);
        $this->db->where('approved.is_deleted', 0);
       // $this->db->where_in('approved.shortlisted_list_number', $list);
        // $this->db->where('approved.joined_status', 1);
        $this->db->order_by('approved.sslc_percentage', 'DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }








    public function getAdmittedListDetails($preference,$board_name,$percentage_from,$percentage_to,$type,$student_type="",$report_type,$admission_year,$integrated_batch)
    {
        $this->db->select('personal.resgisted_tbl_row_id,
        approved.application_number, 
        personal.dyslexia_challenged,
        personal.religion,
        personal.physically_challenged,
        sjpuc.ncc_certificate_status,
        sjpuc.national_level_sports_status,
        sjpuc.second_language,
        personal.name,
        sjpuc.stream_name,
        board.board_name,
        approved.sslc_percentage,
        
        approved.student_category');
        $this->db->from('tbl_admission_students_status_temp as approved');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_registered_student_temp as std', 'std.row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = std.sslc_board_name_id','left');
        
        if(!empty($student_type)){
            if($student_type == 'NCC'){
                $this->db->where('sjpuc.ncc_certificate_status', 'YES');
            }else if($student_type == 'SPORTS'){
                $this->db->where('sjpuc.national_level_sports_status', 'YES');
            }else if($student_type == 'DYC'){
                $this->db->where('personal.dyslexia_challenged', 'YES');
            }else if($student_type == 'PH'){
                $this->db->where('personal.physically_challenged', 'YES');
            }
        }

        if(!empty($board_name)){
            $this->db->where('board.board_name', $board_name);
        }

        if(!empty($integrated_batch)){
            $this->db->where('sjpuc.integrated_batch', $integrated_batch);
        }

        if(!empty($percentage_from)){
            $this->db->where('personal.sslc_percentage >=', $percentage_from);
        }
        if(!empty($percentage_to)){
            $this->db->where('personal.sslc_percentage <=', $percentage_to);
        }

        if(!empty($preference)){
            $this->db->where('sjpuc.stream_name', $preference);
        }
        // if($type != "ALL"){
            
        // }
        // if(!empty($report_type == 'APPLICATION_APPROVED')){
            $this->db->where('approved.admission_status', 1);
            $this->db->where('approved.shortlisted_status', 1);
            $this->db->where('approved.joined_status',1);
        // }
        // $this->db->where('approved.shortlisted_status', 1);
        // $this->db->where('approved.student_category', $category);
        // $this->db->where('personal.admission_year', 2020);
        // // $this->db->where('personal.student_application_status', 1);
        // $this->db->where('approved.admission_status', 1);
        // $this->db->where('approved.is_deleted', 0);
        //  $this->db->where('approved.shortlisted_status', 1);
        // // $this->db->where('approved.submitted_doc_status', 1);
        // $this->db->order_by('approved.sslc_percentage', 'DESC');
        // $query = $this->db->get();
        // $result = $query->result();
        // return $result;
           // $list = array('3','4');
      //  $this->db->where('approved.student_category', $category);
        $this->db->where('approved.adm_year', $admission_year);
        // $this->db->where('personal.student_application_status', 1);
        // $this->db->where('approved.admission_status', 1);
        $this->db->where('approved.is_deleted', 0);
       // $this->db->where_in('approved.shortlisted_list_number', $list);
        // $this->db->where('approved.joined_status', 1);
        $this->db->order_by('personal.name', 'ASC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }


    public function getNewAdmittedStudentInfo($application_num) {
        $this->db->select('personal.resgisted_tbl_row_id,
        approved.application_number, 
        personal.name,
        personal.religion,
        personal.father_name,
        personal.mother_name,
        personal.father_mobile,
        personal.mother_mobile,
        personal.student_mobile,
        sjpuc.program_name,
        sjpuc.stream_name,
        sjpuc.second_stream_name,
        board.board_name,
        approved.shortlisted_by,
        approved.sslc_percentage,
        approved.student_category,
        approved.sms_status,
        approved.admission_status,
        approved.cancel_status,
        approved.joined_status,
        approved.interview_status,
        approved.shortlisted_list_number,
        exam.register_number,');
    
        $this->db->from('tbl_admission_students_status_temp as approved');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_registered_student_temp as std', 'std.row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_sslc_board_name as board', 'board.row_id = std.sslc_board_name_id','left');
        $this->db->where('approved.application_number', $application_num);
        $this->db->where('personal.admission_year', 2022);
        $this->db->where('approved.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row(); 
        return $result;
    }


       //get admission info for display
       function getAdmissionInfo($registered_row_id){
        $this->db->from('tbl_admission_combination_language_opted_temp as adm');
        $this->db->where('adm.registred_row_id', $registered_row_id);
        $query = $this->db->get();
        return $query->row();
    }
  // student registration info
  function getStudentRegisteredInfo($row_id){
    $this->db->from('tbl_admission_registered_student_temp as stud');
    $this->db->where('stud.row_id', $row_id);
    $this->db->where('stud.is_deleted', 0);
    $query = $this->db->get();
    return $query->row();
}

function getStudentImage($registered_row_id){
    $this->db->from('tbl_admission_document_details_temp as doc');
    $this->db->where('doc.registred_row_id', $registered_row_id);
    $this->db->where('doc.doc_name', 'student_photo');
    $this->db->where('doc.is_deleted', 0);
    $query = $this->db->get();
    return $query->row();   
}

public function getAllAdmittedListInfo()
{
    $this->db->select('personal.resgisted_tbl_row_id,
    approved.application_number, 
    personal.dyslexia_challenged,
    personal.religion,
    personal.physically_challenged,
    sjpuc.ncc_certificate_status,
    sjpuc.national_level_sports_status,
    sjpuc.second_language,
    personal.name,
    sjpuc.stream_name,
    board.board_name,
    approved.sslc_percentage,
    
    approved.student_category');
    $this->db->from('tbl_admission_students_status_temp as approved');
    $this->db->join('tbl_admission_student_personal_details_temp as personal', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
    $this->db->join('tbl_admission_school_and_examination_deatils_temp as exam', 'exam.registred_row_id = personal.resgisted_tbl_row_id','left');
    $this->db->join('tbl_admission_combination_language_opted_temp as sjpuc', 'sjpuc.registred_row_id = personal.resgisted_tbl_row_id','left');
    $this->db->join('tbl_admission_registered_student_temp as std', 'std.row_id = personal.resgisted_tbl_row_id','left');
    $this->db->join('tbl_sslc_board_name as board', 'board.row_id = std.sslc_board_name_id','left');
   

    // if(!empty($board_name)){
    //     $this->db->where('board.board_name', $board_name);
    // }

    // if(!empty($percentage_from)){
    //     $this->db->where('personal.sslc_percentage >=', $percentage_from);
    // }
    // if(!empty($percentage_to)){
    //     $this->db->where('personal.sslc_percentage <=', $percentage_to);
    // }

    // if(!empty($preference)){
    //     $this->db->where('sjpuc.stream_name', $preference);
    // }
    // if($type != "ALL"){
        
    // }
    // if(!empty($report_type == 'APPLICATION_APPROVED')){
    $this->db->where('approved.admission_status', 1);
    $this->db->where('approved.shortlisted_status', 1);
    $this->db->where('approved.joined_status',1);
    $this->db->where('approved.adm_year', 2021);
    $this->db->where('approved.is_deleted', 0);
    $this->db->order_by('personal.name', 'ASC');
    $query = $this->db->get();
    $result = $query->result();
    return $result;
}
         //get students fetails lates update
         public function getApplicationInfoForReport($filter){ 
            $this->db->select('personal.row_id,
            personal.application_number,
            personal.gender,
            personal.student_mobile,
            personal.resgisted_tbl_row_id,
            personal.name,
            personal.religion,
            personal.caste,
            personal.sub_caste,
            personal.gender,
            personal.blood_group,
            personal.student_email,
          
           
            personal.father_name,
            personal.mother_name,
            personal.father_mobile,
            personal.mother_mobile,
            personal.student_application_status,
            personal.dob,
            course.program_name ,
            course.stream_name ,
            personal.guardian_mobile,
           
            ');
            $this->db->from('tbl_admission_student_personal_details_temp as personal');
            $this->db->join('tbl_admission_registered_student_temp as reg', 'reg.row_id = personal.resgisted_tbl_row_id','left');
            $this->db->join('tbl_admission_students_status_temp as std', 'std.registered_row_id = personal.resgisted_tbl_row_id','left');
            $this->db->join('tbl_admission_combination_language_opted_temp as course', 'course.registred_row_id = personal.resgisted_tbl_row_id','left');

                     
            if($filter['by_class']!='ALL'){
                $this->db->where('course.program_name', $filter['by_class']);
            }
            if($filter['by_stream']!='ALL'){
                $this->db->where('course.stream_name', $filter['by_stream']);
            }
            if(!empty($filter['by_year'])){
                $this->db->where('std.adm_year', $filter['by_year']);
            }
            if(!empty($filter['by_gedner'])){
                $this->db->where('personal.gender', $filter['by_gedner']);
            }
           
            // $this->db->where('personal.application_number !=', "");
            if($filter['report_type'] == 'ALL_MERIT'){
                //$this->db->where('std.application_status', 1);
               // $this->db->where('std.fee_payment_status', 0);
            }else if($filter['report_type'] == 'APPLICATION_STACK'){
                $this->db->where('std.admission_status', 0);
                // $this->db->where('std.shortlisted_status', 0);
               $this->db->where('std.application_fee_status',1); 
            }else if($filter['report_type'] == 'APPLICATION_FEE_PENDING'){
                $this->db->where('std.admission_status', 0);
                $this->db->where('std.application_fee_status', 0);
            }else if($filter['report_type'] == 'APPLICATION_APPROVED'){
                $this->db->where('std.admission_status', 1);
                // $this->db->where('std.shortlisted_status', 0);
            }else if($filter['report_type'] == 'APPLICATION_SHORTLISTED'){
                
                $this->db->where('std.shortlisted_status', 1);
            }else if($filter['report_type'] == 'APPLICATION_REJECTED'){
                $this->db->where('std.admission_status', 2);
                // $this->db->where('std.shortlisted_status', 0);
            }
            
            $this->db->where('std.is_deleted', 0);
            $this->db->where('personal.is_deleted', 0);
            $this->db->group_by('personal.row_id'); 
           
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }

        public function getAdmissionApplicationFeePaidReport($filter){ 
            $this->db->select('student.application_number,student.name,course.program_name,course.stream_name,std.cash_paid_date,
            student.admission_year');
            $this->db->from('tbl_admission_student_personal_details_temp as student');
            $this->db->join('tbl_admission_students_status_temp as std', 'std.registered_row_id = student.resgisted_tbl_row_id','left');
            $this->db->join('tbl_admission_application_payment_temp as fee', 'fee.registered_tbl_row_id = student.resgisted_tbl_row_id','left');
            $this->db->join('tbl_admission_combination_language_opted_temp as course', 'course.registred_row_id = student.resgisted_tbl_row_id','left');
    
        //     if(!empty($filter['type'])){
        //     if($filter['type']=='ONLINE' ){
        //         $this->db->where('std.payment_type', $filter['type']);
        //     }
        //     if($filter['type']=='CASH' ){
        //         $this->db->where('std.payment_type', $filter['type']);
        //     }
        // }
            if($filter['by_class']!='ALL'){
                $this->db->where('course.program_name', $filter['by_class']);
            }
            if($filter['by_stream']!='ALL'){
                $this->db->where('course.stream_name', $filter['by_stream']);
            }
            $this->db->where('std.application_fee_status', 1);  
            // $this->db->where('fee.payment_status','captured');  
                  
            $this->db->where('std.adm_year', $filter['year']);
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }
  // student registration info
  function getAllmicrosoftInfo(){
    $this->db->from('tbl_student_microsoft_credentials_info as stud');
 
    $this->db->where('stud.is_deleted', 0);
    $query = $this->db->get();
    return $query->result();
}

    public function getAdmissionCompletedStudent($admission_year_filter){
        $this->db->from('tbl_admission_students_status_temp as approved');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'approved.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as com', 'com.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->where('approved.is_deleted', 0);
        $this->db->where('personal.admission_year', $admission_year_filter);
        $this->db->where('approved.shortlisted_status', 1);
        //$this->db->where('approved.interview_status', 1);
        $this->db->where('approved.joined_status', 1);
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllRegisteredStdInfo($filter){
        $this->db->from('tbl_admission_registered_student_temp as reg');
        
        if(!empty($filter['year'])){
            $this->db->where('reg.reg_year', $filter['year']);
        }
        $this->db->where('reg.is_deleted', 0);
        $this->db->order_by('reg.row_id','DESC'); 
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function getviewGrievance($filter=''){
        $this->db->select('reg.name,
       contact.subject,contact.message,
        reg.mobile,contact.created_date_time');
        // $this->db->from('tbl_admission_student_info as std');
        // $this->db->join('tbl_admission_students_status as status', 'status.application_number = std.application_number','left');
        $this->db->select('contact.subject,contact.message,contact.active_status,reg.mobile,contact.row_id,contact.created_date_time');
        $this->db->from('tbl_admission_contact_us as contact');
        $this->db->join('tbl_admission_registered_student_temp as reg', 'reg.row_id = contact.registered_row_id ','left');
        
     
        if(!empty($filter['subject'])){
            $likeCriteria = "(contact.subject  LIKE '%" . $filter['subject'] . "%')";
            $this->db->where($likeCriteria);
        }
      
        if(!empty($filter['message'])){
            $likeCriteria = "(contact.message  LIKE '%" . $filter['message'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['mobile'])){
            $this->db->where('reg.mobile', $filter['mobile']);
        }
        if(!empty($filter['by_name'])){
            $likeCriteria = "(reg.name  LIKE '%" . $filter['by_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['date'])){
            $this->db->where('contact.created_date_time', $filter['date']);
        }
        if(!empty($filter['admission_year'])){
            $this->db->where('reg.reg_year', $filter['admission_year']);
        }
      
        $this->db->where('contact.is_deleted', 0);
        $this->db->order_by('contact.active_status','ASC'); 
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getviewGrievanceCount($filter=''){
        $this->db->from('tbl_admission_contact_us as contact');
        $this->db->join('tbl_admission_registered_student_temp as reg', 'reg.row_id = contact.registered_row_id ','left');
        if(!empty($filter['subject'])){
            $likeCriteria = "(contact.subject  LIKE '%" . $filter['subject'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_name'])){
            $likeCriteria = "(reg.name  LIKE '%" . $filter['by_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['message'])){
            $likeCriteria = "(contact.message  LIKE '%" . $filter['message'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['mobile'])){
            $this->db->where('reg.mobile', $filter['mobile']);
        }
        if(!empty($filter['date'])){
            $this->db->where('contact.created_date_time', $filter['date']);
        }
        if(!empty($filter['admission_year'])){
            $this->db->where('reg.reg_year', $filter['admission_year']);
        }
      
        $this->db->where('contact.is_deleted', 0);
      
        $query = $this->db->get();
        return $query->num_rows();
    }
    function updateGrievanceInfo($studentInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_admission_contact_us', $studentInfo);
        return TRUE;
    }

    function getStudentApplicationStatusByAppNo($application_number){
        $this->db->from('tbl_admission_students_status_temp as std');
        $this->db->where_in('std.application_number', $application_number);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();   
    }
    function getStudentApplicationInfoByID($registered_row_id){
        $this->db->from('tbl_admission_student_personal_details_temp as stud');
        $this->db->where('stud.resgisted_tbl_row_id', $registered_row_id);
        $this->db->where('stud.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    function getStudentAcademicInformation($registered_row_id){
        $this->db->from('tbl_admission_combination_language_opted_temp as stud');
        $this->db->where('stud.registred_row_id ', $registered_row_id);
        // $this->db->where('stud.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    function getStudentPreviousInformation($registered_row_id){
        $this->db->from('tbl_admission_school_and_examination_deatils_temp as stud');
        $this->db->where('stud.registred_row_id', $registered_row_id);
        $this->db->where('stud.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    public function addStudentInfo($student_info) {
        $this->db->trans_start();
        $this->db->insert('tbl_students_info', $student_info);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    function getBoardNameInfoById($row_id){
        $this->db->from('tbl_sslc_board_name as board');
        $this->db->where('board.is_deleted', 0);
        $this->db->where_in('board.row_id', $row_id);
        $query = $this->db->get();
        return $query->row();   
    }
}
?>