<?php

class Push_notification_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->library(array('user_agent'));
        $this->load->helper('date');
    }

    public function getStaffNotifications($filter){
        $this->db->from('tbl_staff_notifications');
        if(!empty($filter['date'])){
            $likeCriteria = "(date_time  LIKE '" . $filter['date'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['date_from']) && !empty($filter['date_to'])){
            $this->db->where('date_time >=', $filter['date_from']);
            $this->db->where('date_time <=', $filter['date_to']);
        }
        if(!empty($filter['date_from']) ){
            $this->db->where('date_time >=', $filter['date_from']);
        }
        if(!empty($filter['date_to'])){
            $this->db->where('date_time <=', $filter['date_to']);
        }
        $this->db->where('is_deleted',0);
        $this->db->order_by("row_id", "desc");
        $query = $this->db->get(); 
        return $query->result();
    }

    public function getStudentNotifications($filter){
        $this->db->from('tbl_student_notifications');
        if(!empty($filter['date_from']) && !empty($filter['date_to'])){
            $this->db->where('date_time >=', $filter['date_from']);
            $this->db->where('date_time <=', $filter['date_to']);
        }
        if(!empty($filter['date_from']) ){
            $this->db->where('date_time >=', $filter['date_from']);
        }
        if(!empty($filter['date_to'])){
            $this->db->where('date_time <=', $filter['date_to']);
        }
        $this->db->order_by("row_id", "desc");
        $this->db->where('is_deleted', 0);
        $query = $this->db->get(); 
        return $query->result();
    }
    
    public function addBlockedUser(){
        $client_platform=$this->agent->platform();
        $client_agent_string=$this->agent->agent_string();
        date_default_timezone_set('Asia/Kolkata');
        $format = "%Y-%m-%d %h:%i:%s";
        $cdate = mdate($format);
        $where = [
            'user_id'=> $this->session->userdata('staff_id'),
            'agent_string'=>$client_agent_string,
            'platform'=>$client_platform,
        ];
        $result=$this->db->select('row_id')->from('tbl_staff_push_notification_blocked_users')->where($where)->get()->row();
        if($this->db->affected_rows() <= 0){
            $data = [
                'row_id' => null,
                'user_id' => $this->session->userdata('staff_id'),
                'agent_string' => $client_agent_string,
                'platform' => $client_platform,
                'date_time' => $cdate,
                'status' => 1
            ];
            $this->db->insert('tbl_staff_push_notification_blocked_users', $data);
            if($this->db->affected_rows() <= 0){
                return 0;
            }else{
                return 1;
            }
        }else{
            $data = [
                'date_time' => $cdate,
                'status' => 1
            ];
            $this->db->update('tbl_staff_push_notification_blocked_users', $data, array(
                'row_id' => $result->row_id                                                      
            ));
            if($this->db->affected_rows() <= 0){
                return 0;
            }else{
                return 1; 
            } 
        }
    }
    
    public function addFcmToken($token){
        $client_platform=$this->agent->platform();
        $client_agent_string=$this->agent->agent_string();
        $where = ['user_id'=> $this->session->userdata('staff_id'),'agent_string'=>$client_agent_string,'platform'=>$client_platform];
        $result=$this->db->select('row_id')->from('tbl_staff_push_notification_token_manager')->where($where)->get()->row();
        if(isset($result)){
           return $this->updateFcmToken($token);
        }else{
            $data = [
                'row_id' => null,
                'user_id' => $this->session->userdata('staff_id'),
                'agent_string' => $client_agent_string,
                'platform'=>$client_platform,
                'token' => $token,
            ];
            $this->db->insert('tbl_staff_push_notification_token_manager', $data);
            if($this->db->affected_rows() <= 0){
                return 0;
            }else{
                return 1;
            }
        }
    }

    public function updateFcmToken($token){
        $data = [
            'token' => $token
        ];
        $this->db->update('tbl_staff_push_notification_token_manager', $data, array(
                                                                    'user_id' => $this->session->userdata('staff_id'),
                                                                    'agent_string' => $this->agent->agent_string(),
                                                                    'platform'=> $this->agent->platform()                                                                    
                                                              ));
        if($this->db->affected_rows() <= 0){
            return 0;
        }else{
            return 1; 
        } 
    }

    public function getAllStaffsToken(){        
        $this->db->select('token');
        $query = $this->db->get('tbl_staff_push_notification_token_manager');
        if($this->db->affected_rows() <= 0){
            return array();
        }else{
            $all_users_token=$query->result_array();
            $sorted_registration_ids = array();
            foreach ($all_users_token as $value) {
               array_push($sorted_registration_ids,$value['token']);
            }
            return $sorted_registration_ids;
        }
    }

    public function getStudentsToken($filters=array()){
        $this->db->select('student_token.token');
        $this->db->from('tbl_token as student_token'); 
        $this->db->join('tbl_students_info as academic', 'academic.student_id = student_token.student_id','left');
        
        if(!empty($filters['term_name'])){
            if($filters['term_name'] == "ALL"){

            }else{
                $this->db->where('academic.term_name', $filters['term_name']);
            }
        }
        if(!empty($filters['stream_name'])){
            if($filters['stream_name'] == "ALL"){

            }else{
                $this->db->where('academic.stream_name', $filters['stream_name']);
            }
        }
        if(!empty($filters['section_name'])){
            if($filters['section_name'] == "ALL"){

            }else{
                $this->db->where('academic.section_name', $filters['section_name']);
            }
        }
        $this->db->where('academic.is_deleted', 0);
        $this->db->where('student_token.is_deleted', 0);
        $query = $this->db->get();
        if($this->db->affected_rows() <= 0){
            return array();
        }else{
            $all_users_token=$query->result_array();
            $sorted_registration_ids = array();
            foreach ($all_users_token as $value) {
               array_push($sorted_registration_ids,$value['token']);
            }
            return $sorted_registration_ids;
        }
    }
    
    // public function getStudentTokenByID($id){
    //     $this->db->select('student.token');
    //     $this->db->from('tbl_std_push_notification_token_manager as student');
    //     $this->db->where('student.user_id',$id);
    //     $query = $this->db->get();
    //     if($this->db->affected_rows() <= 0){
    //         return array();
    //     }else{
    //         $all_token=$query->result_array();
    //         $sorted_tokens = array();
    //         foreach ($all_token as $value) {
    //            array_push($sorted_tokens,$value['token']);
    //         }
    //         return $sorted_tokens;
    //     }
        
    // }
    public function getTokenForReplyMessage($row_id){
        $this->db->select('student.student_id');
        $this->db->from('tbl_student_feedback_for_management as student');
        $this->db->where('student.row_id',$row_id);
        $query = $this->db->get();
        if($this->db->affected_rows() <= 0){
            return array();
        }else{
            return $this->getStudentTokenByID($query->row()->student_id);
        }
    }


    ///FCM Get Single studemt token///
    public function getSingleStudentsToken($student_id){
        $this->db->select('token');
        $this->db->from('tbl_token'); 
        $this->db->where('student_id',$student_id);
        $this->db->where('is_deleted',0);
        $query = $this->db->get();
        if($this->db->affected_rows() <= 0){
            return array();
        }else{
            $all_users_token=$query->result_array();
            $sorted_registration_ids = array();
            foreach ($all_users_token as $value) {
               array_push($sorted_registration_ids,$value['token']);
            }
            return $sorted_registration_ids;
        }        
    }

    //sending message to all tokens at once without loop
    public function sendMessage($title,$body,$user_tokens,$user_type){
        if( is_array($user_tokens) && count($user_tokens) > 0){
            $fcm_data=array(
                'title' => $title,
                'body'=> $body,
                'image'=> NOTIFICATION_LOGO, 
                'user_type'=>$user_type         
            );
            $fcm_fields= array(
                'registration_ids' => $user_tokens,
                'notification' => $fcm_data,
            );
            $fcm_result_array=$this->fcmPushNotification($fcm_fields);
            return 1;
        }else{
            return 0;
        }
    }    

    private static function fcmPushNotification($fields=array()){
        $headers = array(
            'Authorization: key=' . FCM_SERVER_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, FCM_URL);
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch);
        curl_close( $ch );
        return json_decode($result,true);
    }

    public function saveStaffNotification($title,$body,$uploadedFile){
        $sent_by = $this->session->userdata('name');
        date_default_timezone_set('Asia/Kolkata');
        $format = "%Y-%m-%d %h:%i:%s";
       // $cdate = mdate($format);
        $data = [
            'row_id' => null,
            'subject' => $title,
            'message' => $body,
            'sent_by'=> $sent_by,
            'date_time' => date('Y-m-d H:i:s'),
            'filepath' => $uploadedFile
        ];
        $this->db->insert('tbl_staff_notifications', $data);
        if($this->db->affected_rows() <= 0){
            return 0;
        }else{
            return 1;
        }
    }

    public function saveStudentNotification($term,$stream,$section,$title,$body,$uploadedFile){
        $sent_by = $this->session->userdata('name');
        date_default_timezone_set('Asia/Kolkata');
        $format = "%Y-%m-%d %h:%i:%s";
       // $cdate = mdate($format);
        $data = [
            'row_id' => null,
            'term_name' => $term,
            'stream_name' => $stream,
            'section_name' =>$section,
            'subject' => $title,
            'message' => $body,
            'sent_by'=> $sent_by,
            'date_time' => date('Y-m-d H:i:s'),
            'filepath' => $uploadedFile
        ];
        $this->db->insert('tbl_student_notifications', $data);
        if($this->db->affected_rows() <= 0){
            return 0;
        }else{
            return 1;
        }
    }


    public function getAllstudentNotification($filter){
        $this->db->from('tbl_student_notifications as notifications');       
        if(!empty($filter['by_message'])){
            $likeCriteria = "(notifications.message  LIKE '%" . $filter['by_message'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_subject'])){
            $likeCriteria = "(notifications.subject  LIKE '%" . $filter['by_subject'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['sent_by'])){
            $likeCriteria = "(notifications.sent_by  LIKE '%" . $filter['sent_by'] . "%')";
            $this->db->where($likeCriteria);
        }
        // if(!empty($filter['by_date'])){
        //         $this->db->where('notifications.date_time', $filter['by_date']);
        //     }
          if(!empty($filter['by_date'])){
            $likeCriteria = "(notifications.date_time  LIKE '%" . $filter['by_date'] . "%')";
            $this->db->where($likeCriteria);
        }
        
        if(!empty($filter['by_term'])){
            $this->db->where('notifications.term_name', $filter['by_term']);
        }
        if(!empty($filter['by_stream'])){
            $this->db->where('notifications.stream_name', $filter['by_stream']);
        }
        if(!empty($filter['by_Section'])){
            $this->db->where('notifications.section_name', $filter['by_Section']);
        }
        $this->db->where('notifications.is_deleted', 0);
        $this->db->order_by('notifications.row_id', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }
    public function getAllstudentNotificationCount($filter){
        $this->db->from('tbl_student_notifications as notifications');        
         if(!empty($filter['by_message'])){
            $likeCriteria = "(notifications.message  LIKE '%" . $filter['by_message'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_subject'])){
            $likeCriteria = "(notifications.subject  LIKE '%" . $filter['by_subject'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['sent_by'])){
            $likeCriteria = "(notifications.sent_by  LIKE '%" . $filter['sent_by'] . "%')";
            $this->db->where($likeCriteria);
        }
        // if(!empty($filter['by_date'])){
        //         $this->db->where('notifications.date_time', $filter['by_date']);
        //     }
        if(!empty($filter['by_date'])){
            $likeCriteria = "(notifications.date_time  LIKE '%" . $filter['by_date'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['by_term'])){
            $this->db->where('notifications.term_name', $filter['by_term']);
        }
        if(!empty($filter['by_stream'])){
            $this->db->where('notifications.stream_name', $filter['by_stream']);
        }
        if(!empty($filter['by_Section'])){
            $this->db->where('notifications.section_name', $filter['by_Section']);
        }
        $this->db->where('notifications.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function updateNotification($row_id, $notifications){
            $this->db->where('row_id', $row_id);
            $this->db->update('tbl_student_notifications', $notifications);
            return $this->db->affected_rows();
    }

    public function updatedStaffNotification($row_id, $notInfo){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_staff_notifications', $notInfo);
        return $this->db->affected_rows();
    }
    

    public function getStudentsTokenByIDs($student_id){
        $this->db->select('student_token.token');
        $this->db->from('tbl_token as student_token'); 
        $this->db->where_in('student_token.student_id', $student_id);
        $query = $this->db->get();
        if($this->db->affected_rows() <= 0){
            return array();
        }else{
            $all_users_token=$query->result_array();
            $sorted_registration_ids = array();
            foreach ($all_users_token as $value) {
               array_push($sorted_registration_ids,$value['token']);
            }
            return $sorted_registration_ids;
        }
    }

    public function saveStudentNotificationByID($student_ids,$title,$body,$uploadedFilePath){
        $sent_by = $this->session->userdata('name');
        date_default_timezone_set('Asia/Kolkata');
        $format = "%Y-%m-%d %h:%i:%s";
        $cdate = mdate($format);
        for($i=0; $i < count($student_ids); $i++){
                $data = [
                    'row_id' => null,
                    'term_name' => '',
                    'stream_name' => '',
                    'section_name' => '',
                    'student_id' => $student_ids[$i],
                    'subject' => $title,
                    'filepath' => $uploadedFilePath,
                    'message' => $body,
                    'sent_by'=> $sent_by,
                    'date_time' => $cdate,
                ];
                $this->db->insert('tbl_student_notifications', $data);
        }
        if($this->db->affected_rows() <= 0){
            return 0;
        }else{
            return 1;
        }
    }

    function getStudentInfoForNotificationById($student_id){
        $this->db->select('student.row_id,student.student_id');
         $this->db->from('tbl_students_info as student'); 
        $this->db->where('student.student_id',$student_id);
        $this->db->where('student.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function saveBulkStudentNotification($data){
        if(!empty($data)){
            $this->db->insert('tbl_student_bulk_notification', $data);
            if($this->db->affected_rows() <= 0){
                return 0;
            }else{
                return 1;
            }
        }
    }

    function updateStudentIndividualNotification($info, $row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_student_bulk_notification', $info);
        return $this->db->affected_rows();
    }

    public function getStudentIndividualNotificationByID($row_id){
        $this->db->where('notification.row_id', $row_id);
        $this->db->from('tbl_student_bulk_notification as notification');
        $this->db->where('notification.is_Deleted', 0);
        $query = $this->db->get(); 
        return $query->row();

    }

    public function getStudentIndividualNotifications($filter,$student){
        $this->db->select('notification.row_id, notification.active_date, notification.message, notification.filepath,student.student_name,student.term_name,student.stream_name,student.section_name,notification.sent_by,notification.updated_date_time');
        $this->db->from('tbl_student_bulk_notification as notification');
        $this->db->join('tbl_students_info as student', 'student.student_id = notification.userId');
        if(!empty($student)){
            $this->db->where_in('notification.row_id', $student);
        }
        if(!empty($filter['date_from']) && !empty($filter['date_to'])){
            $this->db->where('notification.active_date >=', $filter['date_from']);
            $this->db->where('notification.active_date <=', $filter['date_to']);
        }
        if(!empty($filter['date_from']) ){
            $this->db->where('notification.active_date >=', $filter['date_from']);
        }
        if(!empty($filter['date_to'])){
            $this->db->where('notification.active_date <=', $filter['date_to']);
        }
        if(!empty($filter['term'])){
            $this->db->where_in('student.term_name', $filter['term']);
        }
        if(!empty($filter['stream'])){
            $this->db->where_in('student.stream_name', $filter['stream']);
        }
        if (!empty($filter['section'])) {
                $this->db->where_in('student.section_name', $filter['section']);
        }
        if(!empty($filter['staff_id']) ){
            $this->db->where('notification.updated_by', $filter['staff_id']);
        }
        if (!empty($filter['Student_Name'])) {
            $likeCriteria = "(student.student_name  LIKE '%" . $filter['Student_Name'] . "%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('student.is_deleted',0);
        $this->db->where('notification.is_deleted',0);
        $this->db->order_by('notification.row_id', 'DESC');
        $query = $this->db->get(); 
        return $query->result();
    }

    public function getAllstudentInfoRowId($filter){
        $this->db->select('notification.row_id');
        $this->db->from('tbl_student_bulk_notification as notification');
        $this->db->join('tbl_students_info as student', 'student.student_id = notification.userId');
        if(!empty($filter['term'])){
            $this->db->where_in('student.term_name', $filter['term']);
        }
        if(!empty($filter['stream'])){
            $this->db->where_in('student.stream_name', $filter['stream']);
        }
        if (!empty($filter['section'])) {
                $this->db->where_in('student.section_name', $filter['section']);
        }
        if(!empty($filter['staff_id']) ){
            $this->db->where('notification.updated_by', $filter['staff_id']);
        }
       
        $this->db->where('student.is_deleted',0);
        $this->db->where('notification.is_deleted',0);
        $this->db->order_by('notification.row_id', 'DESC');
        $query = $this->db->get(); 
        return $query->result();
    }

    public function getStudentIndividualNotificationsforView($filter,$row_id){
        $this->db->select('notification.row_id, notification.active_date, notification.message, notification.filepath,student.student_name,notification.filepath_two,notification.sent_by');
        $this->db->from('tbl_student_bulk_notification as notification');
        $this->db->join('tbl_students_info as student', 'student.student_id = notification.userId');

        $this->db->where_in('student.row_id', $row_id);

        if(!empty($filter['date_from']) && !empty($filter['date_to'])){
            $this->db->where('notification.active_date >=', $filter['date_from']);
            $this->db->where('notification.active_date <=', $filter['date_to']);
        }
        if(!empty($filter['date_from']) ){
            $this->db->where('notification.active_date >=', $filter['date_from']);
        }
        if(!empty($filter['date_to'])){
            $this->db->where('notification.active_date <=', $filter['date_to']);
        }
        
        if(!empty($filter['staff_id']) ){
            $this->db->where('notification.updated_by', $filter['staff_id']);
        }
        $this->db->where('student.is_deleted',0);
        $this->db->where('notification.is_deleted',0);
        $this->db->order_by('notification.row_id', 'DESC');
        $query = $this->db->get(); 
        return $query->result();
    }

    public function getStaffTokenforLeaveApprove(){
        $this->db->select('token');
        $this->db->from('tbl_staff_token as token'); 
        $this->db->join('tbl_staff as staff', 'staff.staff_id = token.staff_id','left'); 
        $this->db->join('tbl_roles as Role', 'Role.roleId = staff.role','left');
        $this->db->join('tbl_department as dept', 'dept.dept_id = staff.department_id','left');
        $this->db->where('staff.leave_approved_status',1);
        $this->db->where('staff.is_deleted',0);
        $query = $this->db->get();
        if($this->db->affected_rows() <= 0){
            return array();
        }else{
            $all_users_token=$query->result_array();
            $sorted_registration_ids = array();
            foreach ($all_users_token as $value) {
               array_push($sorted_registration_ids,$value['token']);
            }
            return $sorted_registration_ids;
        }        
    }

    public function getStaffTokenforApprove($staff_id){
        $this->db->select('token');
        $this->db->from('tbl_staff_token as token'); 
        $this->db->join('tbl_staff as staff', 'staff.staff_id = token.staff_id','left'); 
        $this->db->where('token.staff_id', $staff_id);
        $this->db->where('staff.is_deleted',0);
        $query = $this->db->get();
        if($this->db->affected_rows() <= 0){
            return array();
        }else{
            $all_users_token=$query->result_array();
            $sorted_registration_ids = array();
            foreach ($all_users_token as $value) {
               array_push($sorted_registration_ids,$value['token']);
            }
            return $sorted_registration_ids;
        }        
    }

    public function sendStaffMessage($title,$body,$user_tokens,$user_type){
        if( is_array($user_tokens) && count($user_tokens) > 0){
            $fcm_data=array(
                'title' => $title,
                'body'=> $body,
                'image'=> STAFF_NOTIFICATION_LOGO, 
                'user_type'=>$user_type         
            );
            $fcm_fields= array(
                'registration_ids' => $user_tokens,
                'notification' => $fcm_data,
            );
            $fcm_result_array=$this->fcmPushNotificationStaff($fcm_fields);
            return 1;
        }else{
            return 0;
        }
    } 
    
    private static function fcmPushNotificationStaff($fields=array()){
        $headers = array(
            'Authorization: key=' . STAFF_FCM_SERVER_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, FCM_URL);
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch);
        curl_close( $ch );
        return json_decode($result,true);
    }
}
