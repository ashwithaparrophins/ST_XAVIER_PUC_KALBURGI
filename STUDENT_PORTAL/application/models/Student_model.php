<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Student_model extends CI_Model
{
    public function getStudentInfoById($student_id,$term_name){
        $this->db->from('tbl_students_info as std');
        $this->db->where('std.student_id', $student_id);
        $this->db->where('std.term_name', $term_name);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getStudentInfoBystudId($student_id){
        $this->db->from('tbl_students_info as std');
        $this->db->where('std.student_id', $student_id);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    

    public function getStudentAppInfoById($student_id,$term_name){
        $this->db->from('tbl_student_app_registration as student');
        $this->db->where('student.student_id', $student_id);
        // $this->db->where('student.profile_update_status', 0);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    /**
     * This function is used to match student password for change password
     * @param number $row_id : This is row id
     */
    function matchOldPassword($student_id,$oldPassword)
    {
        $this->db->select('student_id, password');
        $this->db->where('student_id', $student_id);        
        $this->db->where('is_deleted', 0);
        $query = $this->db->get('tbl_students_info');
        
        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($oldPassword,$user[0]->password)){
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
    function changePassword($student_id, $usersData)
    {
        $this->db->where('student_id', $student_id);
        $this->db->where('is_deleted', 0);
        $this->db->update('tbl_students_info', $usersData);
        return $this->db->affected_rows();
    }

    public function sendFeedbackMessage($feedbackMessage){
        $this->db->trans_start();
        $this->db->insert('tbl_student_feedback_for_management', $feedbackMessage);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
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



     // function to get attendance info
     public function getAttendanceReport($filter){
        $this->db->select('attendance.absent_date,sub.name as sub_name,time.start_time,time.end_time');
        $this->db->from('tbl_student_attendance_details as attendance');
        $this->db->join('tbl_subjects as sub','sub.subject_code = attendance.subject_code');
        $this->db->join('tbl_class_timings_info as time','time.row_id = attendance.time_row_id');
        $this->db->where('attendance.student_id', $filter['student_id']);
        if(!empty($filter['date'])){
            $this->db->where('attendance.absent_date', $filter['date']);
        }
        if(!empty($filter['sub_code'])){
            $this->db->where('attendance.subject_code', $filter['sub_code']);
        }
        if(!empty($filter['time_id'])){
            $this->db->where('attendance.time_row_id', $filter['time_id']);
        }
        $this->db->where('attendance.is_deleted',0);
        $this->db->where('attendance.office_verified_status',0);
        $this->db->order_by('attendance.absent_date', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    // function to get attendance count 
    public function getAttendanceReportCount($filter){
        $this->db->select('attendance.absent_date,sub.name as sub_name,time.start_time,time.end_time');
        $this->db->from('tbl_student_attendance_details as attendance');
        $this->db->join('tbl_subjects as sub','sub.subject_code = attendance.subject_code');
        $this->db->join('tbl_class_timings_info as time','time.row_id = attendance.time_row_id');
        $this->db->where('attendance.student_id', $filter['student_id']);
        if(!empty($filter['date'])){
            $this->db->where('attendance.absent_date', $filter['date']);
        }
        if(!empty($filter['sub_code'])){
            $this->db->where('attendance.subject_code', $filter['sub_code']);
        }
        if(!empty($filter['time_id'])){
            $this->db->where('attendance.time_row_id', $filter['time_id']);
        }
        $this->db->where('attendance.is_deleted',0);
        $this->db->where('attendance.office_verified_status',0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    // getting student subjects
    public function getStudentSubjectInfo($subject_code){
        $this->db->from('tbl_subjects as sub');
        $this->db->where_in('sub.subject_code', $subject_code);
        $this->db->where('sub.is_deleted',0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    // getting class time
    public function getAllTimeInfo(){
        $this->db->from('tbl_class_timings_info as time');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    // getting class student late days
    public function getLateComerReport($filter){
        $this->db->from('tbl_latecomer_info as late');
        $this->db->where('late.student_id', $filter['student_id']);
        if(!empty($filter['date'])){
            $this->db->where('late.date', $filter['date']);
        }
        $this->db->where('late.is_deleted',0);
        $this->db->order_by('late.date', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    // getting class student late days count pagination
    public function getLateComerReportCount($filter){
        $this->db->from('tbl_latecomer_info as late');
        $this->db->where('late.student_id', $filter['student_id']);
        if(!empty($filter['date'])){
            $this->db->where('late.date', $filter['date']);
        }
        $this->db->where('late.is_deleted',0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // getting class student notification date and message
    public function getNotificationReport($filter){
        $this->db->from('tbl_student_bulk_sms_log as msg');
        $this->db->where('msg.student_id', $filter['student_id']);
        if(!empty($filter['date'])){
            
            $this->db->where("msg.date_time LIKE '%".$filter['date']."%'");
        }
        $this->db->order_by('msg.date_time', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    // getting class student notification count
    public function getNotificationReportCount($filter){
        $this->db->from('tbl_student_bulk_sms_log as msg');
        $this->db->where('msg.student_id', $filter['student_id']);
        if(!empty($filter['date'])){
            
            $this->db->where("msg.date_time LIKE '%".$filter['date']."%'");
        }
        $this->db->order_by('msg.date_time', 'DESC');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getSuggestionInfoById($student_id){
        $this->db->from('tbl_student_feedback_for_management as feedback');
        $this->db->where('feedback.student_id', $student_id);
        $this->db->where('feedback.is_deleted', 0);
        $this->db->where('feedback.status', 0);
        $query = $this->db->get();
        return $query->result();
    }

    // suggestion page  
    function suggestionToDB($suggestionInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_student_feedback_for_management', $suggestionInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    
    
    function addFamilyInfo($familyInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_student_family_info', $familyInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    } 

    function addSiblingInfo($sibInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_studnts_siblings_info', $sibInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    } 

    function updateStudentInfoStatus($student_id, $usersData)
    {
        $this->db->where('student_id', $student_id);
        $this->db->update('tbl_student_app_registration', $usersData);
        return $this->db->affected_rows();
    }

    public function getWorldlinePaymentLogByStudentId($student_id){
        $this->db->from('tbl_worldline_payment_log as fee');
        $this->db->where('fee.student_id', $student_id);
        $this->db->where('fee.payment_status', 'SUCCESS');
        $this->db->where('fee.remarks !=', 'SJPUC Supplementary Exam Fee - 2020');
        
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function getOnlineClassCredentialsInfo($student_id){
        $this->db->from('db_online_class_credentials');
        $this->db->where('student_id', $student_id);
        $query = $this->db->get();
        return $query->row();
    }

// function to get attendance info
public function supplyStudentInfo($filter){
    $this->db->select('supp.student_id,
    supp.supply_fee,
    std.student_name,
    std.stream_name,
    std.section_name,
    std.pu_board_number,
    supp.row_id,
    ');
    $this->db->from('tbl_supplementary_students_info as supp');
    $this->db->join('tbl_first_puc_students_info as std','std.student_id = supp.student_id');
    //$this->db->join('tbl_class_timings_info as time','time.row_id = attendance.time_row_id');
    $this->db->where('supp.student_id', $filter['student_id']);
    $this->db->where('supp.payment_status', 0);

    
    $this->db->where('std.is_deleted', 0);
    $query = $this->db->get();
    $result = $query->row();
    return $result;
}
   

function updateStudentSupplyInfo($row_id, $info)
{
    $this->db->where('row_id', $row_id);
    $this->db->update('tbl_supplementary_students_info', $info);
    return $this->db->affected_rows();
}

// function to get attendance info
public function getSupplyStudentInfoByStatus($filter){
    $this->db->select('supp.student_id,
    supp.supply_fee,
    std.student_name,
    std.stream_name,
    std.section_name,
    std.pu_board_number,
    supp.row_id,
    supp.payment_status,
    ');
    $this->db->from('tbl_supplementary_students_info as supp');
    $this->db->join('tbl_first_puc_students_info as std','std.student_id = supp.student_id');
    //$this->db->join('tbl_class_timings_info as time','time.row_id = attendance.time_row_id');
    $this->db->where('supp.student_id', $filter['student_id']);
    $this->db->where('std.is_deleted', 0);
    $query = $this->db->get();
    $result = $query->row();
    return $result;
}



// public function addMunFeePaymentLog($paymentInfo){
//     $this->db->trans_start();
//     $this->db->insert('tbl_paytm_mun_registration_fee_payment_log', $paymentInfo);
//     $insert_id = $this->db->insert_id(); 
//     $this->db->trans_complete();
//     return $insert_id; 
// }

//  // add from excel
//  public function updateMunPaymentLog($paymentInfo,$row_id) {
//     $this->db->where('row_id', $row_id);
//     $this->db->update('tbl_paytm_mun_registration_fee_payment_log',$paymentInfo);
//     return TRUE;
// }

//  // add from excel
//  public function updateMunPaymentLogByOrderId($paymentInfo,$order_id) {
//     $this->db->where('order_id', $order_id);
//     $this->db->update('tbl_paytm_mun_registration_fee_payment_log',$paymentInfo);
//     return TRUE;
// }
// public function getAllFeeMunPaymentLogByApplicationNo($student_id){
//     $this->db->from('tbl_paytm_mun_registration_fee_payment_log as fee');
//     $this->db->where('student_id', $student_id);
//     $this->db->where('is_deleted', 0);
//     $query = $this->db->get();
//     return $query->result();
// }

public function getInfoMUN_Register($student_id){
    $this->db->from('tbl_mun_internal_students_reg as mun');
    $this->db->where('mun.student_id', $student_id);

    $this->db->where('mun.is_deleted', 0);
    $query = $this->db->get();
    return $query->row();
}

public function addMunRegister($stdInfo){
    $this->db->trans_start();
    $this->db->insert('tbl_mun_internal_students_reg', $stdInfo);
    $insert_id = $this->db->insert_id(); 
    $this->db->trans_complete();
    return $insert_id; 
}

// public function updateMunRegister($stdInfo,$student_id) {
//     $this->db->where('student_id', $student_id);
//     $this->db->update('tbl_mun_internal_students_reg',$stdInfo);
//     return TRUE;
// }








public function addRGDFeePaymentLog($paymentInfo){
    $this->db->trans_start();
    $this->db->insert('tbl_paytm_rgd_registration_fee_payment_log', $paymentInfo);
    $insert_id = $this->db->insert_id(); 
    $this->db->trans_complete();
    return $insert_id; 
}

 // add from excel
 public function updateRGDPaymentLog($paymentInfo,$row_id) {
    $this->db->where('row_id', $row_id);
    $this->db->update('tbl_paytm_rgd_registration_fee_payment_log',$paymentInfo);
    return TRUE;
}

 // add from excel
 public function updateRGDPaymentLogByOrderId($paymentInfo,$order_id) {
    $this->db->where('order_id', $order_id);
    $this->db->update('tbl_paytm_rgd_registration_fee_payment_log',$paymentInfo);
    return TRUE;
}
public function getAllFeeRGDPaymentLogByApplicationNo($student_id){
    $this->db->from('tbl_paytm_rgd_registration_fee_payment_log as fee');
    $this->db->where('student_id', $student_id);
    $this->db->where('is_deleted', 0);
    $query = $this->db->get();
    return $query->result();
}

public function getInfoRGD_Register($student_id){
    $this->db->from('tbl_rgd_internal_students_reg as rgd');
    $this->db->where('rgd.student_id', $student_id);

    $this->db->where('rgd.is_deleted', 0);
    $query = $this->db->get();
    return $query->row();
}

public function addRGDRegister($stdInfo){
    $this->db->trans_start();
    $this->db->insert('tbl_rgd_internal_students_reg', $stdInfo);
    $insert_id = $this->db->insert_id(); 
    $this->db->trans_complete();
    return $insert_id; 
}

public function updateRGDRegister($stdInfo,$student_id) {
    $this->db->where('student_id', $student_id);
    $this->db->update('tbl_rgd_internal_students_reg',$stdInfo);
    return TRUE;
}


//admission project model

public function getStudentStudentInfo($registered_row_id){
    $this->db->select('personal.application_number,
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
    $this->db->join('tbl_admission_students_status_temp as application', 'application.application_number = personal.application_number','left');
    $this->db->join('tbl_admission_document_details_temp as doc', 'doc.registred_row_id = personal.resgisted_tbl_row_id','left');
    $this->db->where('application.registered_row_id', $registered_row_id);
    //$this->db->where('doc.doc_name', 'student_photo');
    $this->db->where('personal.is_deleted', 0);
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

function getStudentMarksSheetByStudentId($student_id){
    $this->db->from('tbl_students_info as std');
    $this->db->where_in('std.student_id', $student_id);
    $this->db->where('std.is_deleted', 0);
    $query = $this->db->get();
    $result = $query->row();        
    return $result;
}

public function getStudentInfoByStudentId($student_id){
    $this->db->from('tbl_students_info as std');
    $this->db->where('std.student_id', $student_id);
    $this->db->where('std.is_deleted', 0);
    $this->db->where('std.is_active',1);
    $query = $this->db->get();
    return $query->row();
}

public function getStudentLateInfo($student_id){
    $this->db->from('tbl_latecomer_info as late');
    $this->db->where('late.student_id', $student_id);
    $this->db->where('late.is_deleted', 0);
    $query = $this->db->get();
    return $query->result();
}



public function addCourseRegistrationFeePaymentLog($paymentInfo){
    $this->db->trans_start();
    $this->db->insert('tbl_paytm_course_registration_fee_payment_log', $paymentInfo);
    $insert_id = $this->db->insert_id(); 
    $this->db->trans_complete();
    return $insert_id; 
}

public function updateCoursePaymentLogByRowId($paymentInfo,$order_id) {
        $this->db->where('row_id', $order_id);
        $this->db->update('tbl_paytm_course_registration_fee_payment_log',$paymentInfo);
        return TRUE;
    }

    public function updateCoursePaymentLogByOrderId($paymentInfo,$order_id) {
        $this->db->where('order_id', $order_id);
        $this->db->update('tbl_paytm_course_registration_fee_payment_log',$paymentInfo);
        return TRUE;
    }


    public function getInfoCourse_Register($student_id,$course_name){
        $this->db->from('tbl_course_students_reg as course');
        $this->db->where('course.student_id', $student_id);
        $this->db->where('course.course_name', $course_name);
        $this->db->where('course.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function addCourseRegister($stdInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_course_students_reg', $stdInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }

    public function updateCourseRegister($stdInfo,$student_id,$course) {
            $this->db->where('student_id', $student_id);
            $this->db->where('course_name', $course);
            $this->db->update('tbl_course_students_reg',$stdInfo);
            return TRUE;
        }

        public function getAllCourseRegisterInfo($student_id){
            $this->db->from('tbl_course_students_reg as course');
            $this->db->where('course.student_id', $student_id);
            $this->db->where('course.is_deleted', 0);
            $query = $this->db->get();
            return $query->result();
        }


          public function getAllFeeCoursePaymentLogByStudentId($student_id){
          $this->db->from('tbl_paytm_course_registration_fee_payment_log as fee');
          $this->db->where('student_id', $student_id);
          $this->db->where('is_deleted', 0);
          $query = $this->db->get();
          return $query->result();
        }

        public function getStudentNotifications($term_name,$section_name,$stream_name){
            $this->db->from('tbl_student_notifications as notification');
            if(!empty($term_name)){
                $this->db->where_in('notification.term_name',array($term_name,"ALL"));
            }else{
                $this->db->where('notification.term_name',"ALL");
            }
            if(!empty($stream_name)){
                $this->db->where_in('notification.stream_name',array($stream_name,"ALL"));
            }else{
                $this->db->where('notification.stream_name',"ALL");
            }
            if(!empty($section_name)){
                $this->db->where_in('notification.section_name',array($section_name,"ALL"));
            }else{
                $this->db->where('notification.section_name',"ALL");
            }
            $this->db->where('notification.is_deleted', 0);
            $this->db->order_by("notification.row_id","DESC");
            //$this->db->limit(50);
            $query = $this->db->get(); 
            return $query->result();
        }



        public function getStudentNotificationsDetail($filter){
            $this->db->from('tbl_student_notifications as notification');
            if(!empty($filter['term_name'])){
                $this->db->where_in('notification.term_name',array($filter['term_name'],"ALL"));
            }else{
                $this->db->where('notification.term_name',"ALL");
            }
            if(!empty($filter['stream_name'])){
                $this->db->where_in('notification.stream_name',array($filter['stream_name'],"ALL"));
            }else{
                $this->db->where('notification.stream_name',"ALL");
            }
            if(!empty($filter['section_name'])){
                $this->db->where_in('notification.section_name',array($filter['section_name'],"ALL"));
            }else{
                $this->db->where('notification.section_name',"ALL");
            }
            $this->db->where('notification.is_deleted', 0);
            $this->db->order_by("date_time","DESC");
           // $this->db->limit(50);
            $query = $this->db->get(); 
            return $query->result();
        }

        public function getRemarkInfoApi($row_id){
            $this->db->select('student.student_name,student.row_id as stdrowid,Observation.student_id,Observation.date,
            Observation.type_id,Observation.file_path,Observation.year,Observation.description,Observation.created_date_time,
            type.row_id as typRowid,type.remark_name,Observation.remarks');
            $this->db->from('tbl_student_remark_info as Observation'); 
            $this->db->join('tbl_students_info as student', 'student.row_id = Observation.student_id','left');
            $this->db->join('tbl_student_remarks_type as type','type.row_id = Observation.type_id','left');
            $this->db->order_by('Observation.date', 'DESC');
            $this->db->where('Observation.is_deleted', 0);
            $this->db->where('Observation.student_id', $row_id);
            $this->db->where('student.is_deleted', 0);
            $query = $this->db->get();
            $result = $query->result();        
            return $result;
        }


        

        public function getStudentInfoByRowId($row_id){
            $this->db->from('tbl_students_info as std');
            $this->db->where('std.row_id', $row_id);
            $this->db->where('std.is_active', 1);
            $this->db->where('std.is_deleted', 0);
            $query = $this->db->get();
            return $query->row();
        }

        function updateRegistration($student_id,$info){
            $this->db->where("student_id", $student_id); 
            $this->db->update("tbl_student_app_registration", $info);
            return 1;
        }

        public function getEvents(){
            $this->db->from('tbl_website_event as event');
            $this->db->where('event.is_deleted',0);
            $this->db->where('event.date >=',date('Y-m-d'));
            $this->db->order_by('event.date', 'DESC');
            $this->db->where('event.status',0);
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }

        public function getCalender(){
            $this->db->from('tbl_calendar_event_manager as calender');
            $this->db->where('calender.is_deleted',0);
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }

        public function deleteToken($id){
            $this->db->where('device_id', $id);
            $this->db->delete('tbl_token');
            return true;
        }
    

        public function getabsentDetails($student_id){
            $this->db->select('attendance.absent_date,sub.name,time.start_time,time.end_time');
            $this->db->from('tbl_student_attendance_details as attendance');
            $this->db->join('tbl_subjects as sub','sub.subject_code = attendance.subject_code');
            $this->db->join('tbl_class_timings as time','time.row_id = attendance.time_row_id');
            $this->db->where('attendance.student_row_id', $student_id);
            $this->db->where('attendance.year',CURRENT_YEAR);
            $this->db->where('attendance.is_deleted',0);
            $this->db->where('sub.is_deleted',0);
            $this->db->where('time.is_deleted',0);
            // $this->db->where('attendance.office_verified_status',1);
            $this->db->order_by('attendance.absent_date', 'DESC');
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }

          
    // dashboard news feed
    public function getNewsFeed($filter) {
        $this->db->select('news.row_id,news.subject,news.description,news.term_name,news.date,news.stream_name,
        news.photo_url');
        $this->db->from('tbl_news_feed as news'); 
        $this->db->join('tbl_news_feed_role_mngt as role', 'role.rel_news_row_id = news.row_id','right');
        if(!empty($filter['term_name'])){
            $this->db->where_in('news.term_name',array($filter['term_name'], '','ALL'));
        }
        // if(!empty($filter['role']) || !empty($filter['role_one'])){
            $this->db->where_in('role.visible_type',array('STUDENT', 'ALL'));
        // }
        $this->db->where('news.is_deleted', 0);
        $this->db->where('role.is_deleted', 0);
        $this->db->order_by('news.date', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        //return $this->db->last_query();
        return $query->result();
    }
    public function getNewsFeedApi($filter) {
        $this->db->select('news.row_id,news.subject,news.description,news.term_name,news.date,news.stream_name,
        news.photo_url');
        $this->db->from('tbl_news_feed as news'); 
        $this->db->join('tbl_news_feed_role_mngt as role', 'role.rel_news_row_id = news.row_id','right');
        if(!empty($filter['term_name'])){
            $this->db->where_in('news.term_name',array($filter['term_name'], '','ALL'));
        }
        if(!empty($filter['role']) || !empty($filter['role_one'])){
            $this->db->where_in('role.visible_type',array($filter['role'], $filter['role_one']));
        }
        $this->db->where('news.is_deleted', 0);
        $this->db->where('role.is_deleted', 0);
        $this->db->order_by('news.date', 'DESC');
        // $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        //return $this->db->last_query();
        return $query->result();
    }

    public function getStudentNotificationsById($student_id){  
        $this->db->from('tbl_student_notifications as notification');
        $this->db->where('notification.student_id',$student_id);
        $this->db->where('notification.is_deleted',0);
        $this->db->order_by("date_time","DESC");
        $query = $this->db->get(); 
        return $query->result();
    }

    public function getStudentBulkNotificationsApi($studentRowId){  
        
        $this->db->from('tbl_student_bulk_notification as notification');
        if(!empty($studentRowId)){
            $this->db->where_in('notification.userId',array($studentRowId,"ALL"));
        }else{
            $this->db->where('notification.userId',"ALL");
        }
       // $this->db->where('notification.active_date >=', date('Y-m-d',strtotime($todayDate)));
        $this->db->order_by("notification.row_id","DESC");
        $this->db->where('notification.is_deleted',0);
        $this->db->limit($limit);
        $query = $this->db->get(); 
        return($query->result());
    }

    public function getStudentfeedNotifications($term_name,$section_name,$stream_name){
        $this->db->from('tbl_student_notifications as notification');
        if(!empty($term_name)){
            $this->db->where_in('notification.term_name',array($term_name,"ALL"));
        }else{
            $this->db->where('notification.term_name',"ALL");
        }
        if(!empty($stream_name)){
            $this->db->where_in('notification.stream_name',array($stream_name,"ALL"));
        }else{
            $this->db->where('notification.stream_name',"ALL");
        }
        if(!empty($section_name)){
            $this->db->where_in('notification.section_name',array($section_name,"ALL"));
        }else{
            $this->db->where('notification.section_name',"ALL");
        }
        $this->db->where('notification.is_deleted', 0);
        $this->db->where('DATE(notification.date_time)',date('Y-m-d'));
        $this->db->order_by("notification.row_id","DESC");
        $query = $this->db->get();
        return $query->result();
    }
    public function getStudentfeedBulkNotificationsApi($studentRowId){  
       
        $this->db->from('tbl_student_bulk_notification as notification');
        if(!empty($studentRowId)){
            $this->db->where_in('notification.userId',array($studentRowId,"ALL"));
        }else{
            $this->db->where('notification.userId',"ALL");
        }
       // $this->db->where('notification.active_date >=', date('Y-m-d',strtotime($todayDate)));
        $this->db->where('DATE(notification.updated_date_time)',date('Y-m-d'));
        $this->db->order_by("notification.row_id","DESC");
        $this->db->where('notification.is_deleted',0);
        $this->db->limit($limit);
        $query = $this->db->get();
        return($query->result());
    }
    public function getabsentDetailsfeed($student_id){
        $this->db->select('attendance.absent_date,sub.name,time.start_time,time.end_time');
        $this->db->from('tbl_student_attendance_details as attendance');
        $this->db->join('tbl_subjects as sub','sub.subject_code = attendance.subject_code');
        $this->db->join('tbl_class_timings as time','time.row_id = attendance.time_row_id');
        $this->db->where('attendance.student_row_id', $student_id);
        $this->db->where('attendance.year',CURRENT_YEAR);
        $this->db->where('attendance.is_deleted',0);
        $this->db->where('sub.is_deleted',0);
        $this->db->where('time.is_deleted',0);
        $this->db->where('attendance.absent_date',date('Y-m-d'));
        // $this->db->where('attendance.office_verified_status',1);
        $this->db->order_by('attendance.absent_date', 'DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
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

    public function getStudentsInfoById($row_id=''){
        $this->db->select('student.row_id,student.blood_group,student.student_no,student.application_no,student.register_no, 
        student.student_id,student.hall_ticket_no,student.student_name,student.elective_sub,student.dob,student.mobile,student.email,
        student.date_of_admission,student.roll_number,student.gender,student.student_status,student.residential_address,student.nationality,student.mother_educational_qualification,student.mother_annual_income,
        student.pu_board_number,student.category,student.last_board_name,student.present_address,student.permanent_address,student.religion,student.father_email,student.mother_profession,student.mother_email,
        student.father_name,student.father_mobile,student.mother_name,student.mother_mobile,student.program_name,student.stream_name,student.father_profession,student.father_annual_income,
        student.route_id,route.name as route_name,route.rate,route.bus_no,student.caste,student.sub_caste,student.mother_tongue,student.is_dyslexic,student.father_educational_qualification,
        student.intake_year,student.term_name,student.section_name');
        $this->db->from('tbl_students_info as student'); 
        $this->db->join('tbl_student_transport_rate_info as route', 'route.row_id = student.route_id','left');
        $this->db->where('student.row_id', $row_id);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getTransportTotalPaidAmount($stud_id,$year){
        $this->db->select('SUM(fee.bus_fees) as paid_amount');
        $this->db->from('tbl_student_bus_management_details as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.student_id', $stud_id);
        $this->db->where('fee.intake_year',$year);
        $query = $this->db->get();
        return $query->row();
    }

    public function getStudentOverallTransFeePaymentInfo($stud_id,$year){
        $this->db->from('tbl_student_bus_management_details as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.student_id', $stud_id);
        $this->db->where('fee.intake_year',$year);
        $query = $this->db->get();
        return $query->result();
    }

    public function getcheckpassword($student_id){
        $this->db->select('pass.password');
        $this->db->from('tbl_students_info as pass'); 
       // $this->db->join('tbl_student_document as doc', 'doc.application_no = std.application_no','left');
        $this->db->where('pass.row_id', $student_id);
        $this->db->where('pass.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    

    // subject info
    public function getSubjectInfo($subjects_code){
        $this->db->select('sub.name');
        $this->db->from('tbl_subjects as sub');
        $this->db->where_in('sub.subject_code', $subjects_code);
        $this->db->where('sub.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

     // sum of attendance month wise// class held information for attendance
     public function getSumOfAttendanceMonthBased($student_id,$subject_code){

        $this->db->select('SUM(class.class_held) as class_held,SUM(class.class_attended)as class_attended');
        $this->db->from('tbl_attendance_additional_info as class');
        $this->db->where_in('class.subject_code', $subject_code);
        $this->db->where_in('class.student_id', $student_id);
        // $this->db->where_in('class.month', ['JUNE','JULY']);
        //$this->db->where_in('class.month',strtoupper(date('F')));
        $this->db->where('class.year',CURRENT_YEAR);
        $this->db->where('class.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getSumOfAttendancelastMonth($student_id,$subject_code){

        $this->db->select('SUM(class.class_held) as class_held,SUM(class.class_attended) as class_attended');
        $this->db->from('tbl_attendance_additional_info as class');
        $this->db->where_in('class.subject_code', $subject_code);
        $this->db->where_in('class.student_id', $student_id);
        // $this->db->where_in('class.month', ['JUNE','JULY']);
        //$this->db->where_in('class.month',strtoupper(date('F',strtotime('-1 month'))));
        $this->db->where('class.year',CURRENT_YEAR);
        $this->db->where('class.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getFeeConcessionInfo($student_row_id,$year){
        $this->db->select('SUM(fee.fee_amt) as fee_amt');
        $this->db->from('tbl_student_bus_fee_concession as fee');
        $this->db->where('fee.student_id', $student_row_id);
        $this->db->where('fee.con_year', $year);
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.approved_status', 1);
        $query = $this->db->get();
        return $query->row();
    }


 
}
?>