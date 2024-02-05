<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Student_model extends CI_Model
{
    /**
     * This function is used to match student password for change password
     * @param number $row_id : This is row id
     */
    function matchOldPassword($row_id, $oldPassword)
    {
        $this->db->select('row_id, password');
        $this->db->where('row_id', $row_id);        
        $this->db->where('is_deleted', 0);
        $query = $this->db->get('tbl_admission_registered_student_temp');
        
        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($oldPassword, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    /**
     * This function is used to change student password
     * @param number $row_id : This is row id
     * @param array $studentInfo : This is user updation info
     */
    function changePassword($row_id, $usersData)
    {
        $this->db->where('row_id', $row_id);
        $this->db->where('is_deleted', 0);
        $this->db->update('tbl_admission_registered_student_temp', $usersData);
        return $this->db->affected_rows();
    }

    // student registration info
    function getStudentRegisteredInfo($row_id){
        $this->db->from('tbl_admission_registered_student_temp as stud');
        $this->db->where('stud.row_id', $row_id);
        $this->db->where('stud.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
   // student registration info
   function geApplicationInfo($row_id){
    $this->db->from('tbl_admission_students_status_temp as stud');
    $this->db->where('stud.registered_row_id', $row_id);
    $this->db->where('stud.is_deleted', 0);
    $query = $this->db->get();
    return $query->row();
}
    
    public function getStudentNotification($student_id,$date){
        $date = date('Y-m-d');
        $this->db->from('tbl_student_bulk_sms_log as notify');
        $this->db->where('notify.student_id', $student_id);
        $this->db->where('notify.date_time',$date);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

/**
     * This function is used to add student peronsonal informati
     * @return number $insert_id : This is last inserted id
     */
    function studentPersonalInfoToDb($studentPersonalInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_admission_student_personal_details_temp', $studentPersonalInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }


    function getNationality(){
        $this->db->from('tbl_nationality as nation');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    function getCasteInfo(){
        $this->db->from('tbl_caste_details as caste');
        $this->db->order_by('caste.name', 'ASC');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    function getReligionInfo(){
        $this->db->from('tbl_religion_details as religion');
        $this->db->order_by('religion.name', 'ASC');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    function getStreamNamesByProgram($program_name){
        $this->db->from('tbl_program_stream_info as stream');
        $this->db->where('stream.program_name', $program_name);     
        $this->db->order_by('stream.stream_name', 'ASC');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    function saveStudentPersonalInfo($personalInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_admission_student_personal_details_temp', $personalInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id;
    }

    function getStudentApplicationInfo($registered_row_id){
        $this->db->from('tbl_admission_student_personal_details_temp as stud');
        $this->db->where('stud.resgisted_tbl_row_id', $registered_row_id);
        $this->db->where('stud.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    //checking student is alraedy applied to college application
    function checkStudentAlreadyApplied($registered_row_id){
        $this->db->from('tbl_admission_student_personal_details_temp as stud');
        $this->db->where('stud.resgisted_tbl_row_id', $registered_row_id);
        $this->db->where('stud.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    //update student personal info
    function updateStudentPersonalInfo($registered_row_id,$personalInfo){
        $this->db->where('resgisted_tbl_row_id', $registered_row_id);
        $this->db->where('is_deleted', 0);
        $this->db->update('tbl_admission_student_personal_details_temp', $personalInfo);
        return $this->db->affected_rows();
    }

//get a school info for display
    function getStudentSchoolInfo($registered_row_id){
        $this->db->from('tbl_admission_school_and_examination_deatils_temp as school');
        $this->db->where('school.registred_row_id', $registered_row_id);
        $this->db->where('school.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function updateRegisterInfo($register_row_id,$registerInfo){
        $this->db->where('row_id', $register_row_id);
        $this->db->update('tbl_admission_registered_student_temp', $registerInfo);
        return $this->db->affected_rows();
    }

    //saving school info
    function saveStudentSchoolInfo($schoolInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_admission_school_and_examination_deatils_temp', $schoolInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }
//save to db sslc mark info
    function saveStudentSSLC_MarkInfo($markInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_admission_student_sslc_mark_info_temp', $markInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }

//checking school info already exist
    function checkStudentAlreadyFilledschoolInfo($registered_row_id){
        $this->db->from('tbl_admission_school_and_examination_deatils_temp as school');
        $this->db->where('school.registred_row_id', $registered_row_id);
        $this->db->where('school.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

//checking mark is already added
    function checkStudentMarkInfoAdded($registred_row_id ){
        $this->db->from('tbl_admission_student_sslc_mark_info_temp as school');
        $this->db->where('school.registred_row_id ', $registred_row_id );
        $query = $this->db->get();
        return $query->num_rows();
    }

    function checkSSLCMarkExists($registered_row_id,$course_row_id){
        $this->db->from('tbl_admission_student_sslc_mark_info_temp as school');
        $this->db->where('school.registred_row_id', $registered_row_id);
        $this->db->where_in('school.row_id', $course_row_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    //update school info
    function updateStudentSchoolInfo($registered_row_id,$schoolInfo){
        $this->db->where('registred_row_id', $registered_row_id);
        $this->db->where('is_deleted', 0);
        $this->db->update('tbl_admission_school_and_examination_deatils_temp', $schoolInfo);
        return $this->db->affected_rows();
    }
//update mark info of a student
    function updateSSLC_MarkInfo($markInfo,$registered_row_id,$mark_row_id){
        $this->db->where('registred_row_id', $registered_row_id);
        $this->db->where('row_id', $mark_row_id);
        $this->db->update('tbl_admission_student_sslc_mark_info_temp', $markInfo);
        return $this->db->affected_rows();
    }

  

     //get a student mark info
     function getStudentMarkInfo($registered_row_id){
        $this->db->from('tbl_admission_student_sslc_mark_info_temp as school');
        $this->db->where('school.registred_row_id', $registered_row_id);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

     //get a student mark info
     function getStudentMarkInfoforDisplay($registered_row_id){
        $this->db->from('tbl_admission_student_sslc_mark_info_temp as school');
        $this->db->where('school.registred_row_id', $registered_row_id);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }
    function getMarksDetailforDisplay($registered_row_id){
        $this->db->select('SUM(obtnd_mark) as obtnd_mark');
        $this->db->from('tbl_admission_student_sslc_mark_info_temp as school');
        $this->db->where('school.registred_row_id', $registered_row_id);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        return $query->row();   
    }
    function getMarksDetail($registered_row_id){
        $this->db->select('SUM(obtnd_mark) as obtnd_mark');
        $this->db->from('tbl_admission_student_sslc_mark_info_temp as school');
        $this->db->where('school.registred_row_id', $registered_row_id);
        $query = $this->db->get();
        return $query->row();   
    }

    //delete all subject for update
    function deleteAllSubject($registred_row_id ){
        $this->db->where('registred_row_id ', $registred_row_id );
        $this->db->delete('tbl_admission_student_sslc_mark_info_temp');
        return $this->db->affected_rows();
    }

    //save to db admission details
    function saveAdmissionInfo($admissionInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_admission_combination_language_opted_temp', $admissionInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }

    //get admission info for display
    function getAdmissionInfo($registered_row_id){
        $this->db->from('tbl_admission_combination_language_opted_temp as adm');
        $this->db->where('adm.registred_row_id', $registered_row_id);
        $query = $this->db->get();
        return $query->row();
    }

    

    //checking mark is already added
    function checkAdmissionInfoAdded($registered_row_id){
        $this->db->from('tbl_admission_combination_language_opted_temp as adm');
        $this->db->where('adm.registred_row_id', $registered_row_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    //updating admission info
    function updateAdmissionInfo($register_row_id,$admissionInfo){
        $this->db->where('registred_row_id', $register_row_id);
        $this->db->update('tbl_admission_combination_language_opted_temp', $admissionInfo);
        return $this->db->affected_rows();
    }

    //updating admission info
    function updateSSLC_percentage($register_row_id,$personalInfo){
        $this->db->where('resgisted_tbl_row_id', $register_row_id);
        $this->db->update('tbl_admission_student_personal_details_temp', $personalInfo);
        return $this->db->affected_rows();
    }

    //get a student mark info
    function getStudentMarkInfoForPercentage($registered_row_id){
        $this->db->select('SUM(max_mark) as max_mark');
        $this->db->from('tbl_admission_student_sslc_mark_info_temp as school');
        $this->db->where('school.registred_row_id', $registered_row_id);
        $query = $this->db->get();
        return $query->row();   
    }


    //save to db admission details
    function addDocument($certificateInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_admission_document_details_temp', $certificateInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }

    //uploading Document
    function updateDocument($register_row_id,$certificateInfo,$doc_name){
        $this->db->where('registred_row_id', $register_row_id);
        $this->db->where('doc_name', $doc_name);
        $this->db->update('tbl_admission_document_details_temp', $certificateInfo);
        return $this->db->affected_rows();
    }

    //checking Document info already exist
    function checkDocumentInfoExists($registered_row_id,$doc_name){
        $this->db->from('tbl_admission_document_details_temp as doc');
        $this->db->where('doc.registred_row_id', $registered_row_id);
        $this->db->where_in('doc_name', $doc_name);
        $this->db->where('doc.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function getDocumnetDetails($registered_row_id){
        $this->db->from('tbl_admission_document_details_temp as doc');
        $this->db->where_in('doc.registred_row_id', $registered_row_id);
        $this->db->where('doc.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();   
    }

    function getBoardNameById($row_id){
        $this->db->from('tbl_sslc_board_name as board');
        $this->db->where('board.is_deleted', 0);
        $this->db->where_in('board.row_id', $row_id);
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

    function getStudentApplicationStatus($registered_row_id){
        $this->db->from('tbl_admission_students_status_temp as std');
        $this->db->where('std.registered_row_id', $registered_row_id);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();   
    }
    function saveStudentApplicationStatus($applicationStatus){
        $this->db->trans_start();
        $this->db->insert('tbl_admission_students_status_temp', $applicationStatus);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id;
    }

    // get state 
    function getStateInfo(){
        $this->db->from('tbl_state as state');
        $this->db->where('state.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();   
    }

    // priest certificate info
     function savePriestCertificateInfo($priestCertificateInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_admission_priest_certificate_temp', $priestCertificateInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }

    //uploading certificate
    function updatePriestCertificate($registered_row_id,$priestCertificateInfo){
        $this->db->where('registered_row_id', $registered_row_id);
        $this->db->update('tbl_admission_priest_certificate_temp', $priestCertificateInfo);
        return $this->db->affected_rows();
    }

    //checking 
    function checkPriestCertificateExists($registered_row_id){
        $this->db->from('tbl_admission_priest_certificate_temp as priest');
        $this->db->where('priest.registered_row_id', $registered_row_id);
        $this->db->where('priest.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function getParishPriestInfo($registered_row_id){
        $this->db->from('tbl_admission_priest_certificate_temp as std');
        $this->db->where('std.registered_row_id', $registered_row_id);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();   
    }
    

    // check admission status
    public function checkStudentAdmissionStatus($registered_row_id){
        $this->db->from('tbl_admission_students_status_temp as std');
        $this->db->where('std.registered_row_id', $registered_row_id);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    function updateStudentApplicationStatus($registered_row_id,$applicationStatus){
        $this->db->where('registered_row_id', $registered_row_id);
        $this->db->update('tbl_admission_students_status_temp', $applicationStatus);
        return $this->db->affected_rows();
    }
    
    

    //paytm payment
    function addApplicationPaymentLog($payInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_admission_application_payment_temp', $payInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id;
    }

    //update 
    function updateApplicationPaymentLog($row_id,$payInfo){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_admission_application_payment_temp', $payInfo);
        return $this->db->affected_rows();
    }
      //update 
      function updateApplicationPaymentLogOrderID($order_id,$payInfo){
        $this->db->where('order_id', $order_id);
        $this->db->update('tbl_admission_application_payment_temp', $payInfo);
        return $this->db->affected_rows();
    }

    function getAllApplicationPaymentLog($registered_row_id){
        $this->db->from('tbl_admission_application_payment_temp as std');
        $this->db->where('std.registered_tbl_row_id', $registered_row_id);
        $this->db->where('std.is_deleted', 0);
        $this->db->where('std.order_id !=', "");
        $query = $this->db->get();
        return $query->result();   
    }

    public function getStudentStudentInfo($registered_row_id){
        $this->db->select('application.application_number,
        personal.name as student_name,
        personal.caste,
        personal.father_name,
        personal.father_mobile,
        personal.mother_name,
        personal.mother_mobile,
        language.stream_name,
        language.second_language as elective_sub,
        application.admission_status,
        application.student_category,
        doc.doc_path,
        application.sslc_percentage');
        $this->db->from('tbl_admission_student_personal_details_temp as personal');
        $this->db->join('tbl_admission_combination_language_opted_temp as language', 'language.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_students_status_temp as application', 'application.registered_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->join('tbl_admission_document_details_temp as doc', 'doc.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->where('application.registered_row_id', $registered_row_id);
        //$this->db->where('doc.doc_name', 'student_photo');
        $this->db->where('personal.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();   
    }

        // admission website grievance 
        public function addWebsiteAdmissionGrievance($messageInfo){
            $this->db->trans_start();
            $this->db->insert('tbl_website_admission_contact_us', $messageInfo);
            $insert_id = $this->db->insert_id(); 
            $this->db->trans_complete();
            return $insert_id; 
        }
        
        function getWebsiteGrievanceStatus($registered_row_id){
            $this->db->from('tbl_website_admission_contact_us as std');
            $this->db->where('std.registered_row_id', $registered_row_id);
            $this->db->where('std.is_deleted', 0);
            $query = $this->db->get();
            return $query->row();   
        }

        
    function getStudentMicrosoftTeamInfo($application_number){
        $this->db->from('tbl_admission_microsoft_team_login');
        $this->db->where('application_no', $application_number);
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        return $query->row();   
    }

    //2021

    function getStudentApplication_2021($registered_row_id){
        $this->db->from('tbl_applied_application_2021 as reg');
        $this->db->where('reg.registered_row_id', $registered_row_id);
        $query = $this->db->get();
        return $query->row();   
    }

    function saveStudentApplicationReg_2021($regInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_applied_application_2021', $regInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id;
    }


    function getStudentApplication_Details($registered_row_id){
        $this->db->from('tbl_admission_students_status_temp as status');
        $this->db->where('status.registered_row_id', $registered_row_id);
        $query = $this->db->get();
        return $query->row();   
    }

    function updateBoardName($registered_row_id,$schoolInfo){
        $this->db->where('registred_row_id', $registered_row_id);
        $this->db->where('is_deleted', 0);
        $this->db->update('tbl_admission_school_and_examination_deatils_temp', $schoolInfo);
        return $this->db->affected_rows();
    }

    function checkAllSSLCMarkExists($registered_row_id){
        $this->db->from('tbl_admission_student_sslc_mark_info_temp as school');
        $this->db->where('school.registred_row_id', $registered_row_id);
        // $this->db->where_in('school.row_id', $course_row_id);
        $query = $this->db->get();
        return $query->num_rows();
    }


    function deleteMarkInfo($registered_row_id){
        $this->db->where('registred_row_id', $registered_row_id);
        $this->db->delete('tbl_admission_student_sslc_mark_info_temp');
        return $this->db->affected_rows();
    }

    function UpdateMarkInfo($registered_row_id,$boardInfo){
        $this->db->where('registred_row_id', $registered_row_id);
        $this->db->update('tbl_admission_student_sslc_mark_info_temp', $boardInfo);
        return $this->db->affected_rows();
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


    
    function getStudentBoardInformation($registered_row_id){
        $this->db->from('tbl_admission_registered_student_temp as stud');
        $this->db->where('stud.row_id', $registered_row_id);
        $this->db->where('stud.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }


    
    public function getPreviousStudentApplicationInfo(){
        $this->db->from('tbl_admission_students_status_temp as std');
        $this->db->where('std.is_deleted', 0);
        // $this->db->where('std.application_fee_status', 1);
        $this->db->where('std.adm_year', '2024');
        $this->db->order_by('std.row_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();   
    }

}
?>