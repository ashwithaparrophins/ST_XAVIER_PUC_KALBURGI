<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Push_Notification extends BaseController {

    public function __construct() {
        parent:: __construct();   
        $this->load->model('push_notification_model');  
        $this->load->model('custom_email_model'); 
        $this->load->model('students_model');
        $this->load->library('pagination');  
        $this->isLoggedIn();  
    }

	public function index()
	{
        if ($this->isAdmin() == TRUE ) {
            $this->loadThis();
        } else {
            $data['streams'] = $this->students_model->getAllStreamName();
            $data['sections'] = $this->students_model->getAllSectionName();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Push Notification ';
            $this->loadViews("push_notification/pushNotification", $this->global, $data, NULL);
        }
    }

    public function addBlockedUser(){
        if($this->input->server("REQUEST_METHOD")=="POST"){
            echo $this->push_notification_model->addBlockedUser();
        } 
    }

    public function addFcmToken(){
        if($this->input->server("REQUEST_METHOD")=="POST"){
            $res=$this->push_notification_model->addFcmToken($this->input->post('token'));
            echo $res;
        }        
    }

    public function getStaffNotifications(){
        $data['notifications'] = $this->push_notification_model->getStaffNotifications();
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Staff Notification ';
        $this->loadViews("push_notification/staffNotification", $this->global, $data, NULL);
    }

    // public function getStudentNotifications(){
    //     $data['notifications'] = $this->push_notification_model->getStudentNotifications();
    //     $this->global['pageTitle'] = ''.TAB_TITLE.' : Student Notification ';
    //     $this->loadViews("push_notification/studentNotification", $this->global, $data, NULL);
    // }

    public function validateForm(){
        if($this->input->server("REQUEST_METHOD") == "POST"){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('msg_subject','Subject','required');
            $this->form_validation->set_rules('message','Message','required');
            if($this->form_validation->run() == FALSE)
            {
                $this->index();
            }else{
                $uploadedFilePath = '';
                if($_FILES['msg_file']['name'] != ""){
                    $destinationPath = 'upload/notifications/';
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    $config['upload_path'] = $destinationPath;
                    $config['allowed_types'] = 'pdf|doc|docx|png|jpg|jpeg';
                    $config['max_size'] = 2000;
                    // $uniquFileName = uniqid("JNPUC-",true).$_FILES['msg_file']['name'];
                    // $config['file_name'] = $uniquFileName;
                    $this->load->library('upload', $config);
                    if($this->upload->do_upload('msg_file')){
                        $data = array('upload_data' => $this->upload->data());
                        $uploadedFilePath = "upload/notifications/".$data['upload_data']['orig_name'];
                        log_message('debug','dd'.$uploadedFilePath);
                    }else{                        
                        $this->session->set_flashdata('error', $this->upload->display_errors());
                        redirect('pushNotification');
                    }
                }
                $title = $this->input->post('msg_subject');
                $body = $this->input->post('message');
                if($this->input->post("user_name") === "staff"){
                    $this->sendPushNotificationToAllStaffs($title,$body);
                    $email_option = $this->input->post('send_email_option');
                    if(isset($email_option)){
                        $this->sendEmailToAllStaff($title,$body);
                    }
                    $this->push_notification_model->saveStaffNotification($title,$body);
                }else if($this->input->post("user_name") === "student"){
                    $filter['term_name'] = $this->input->post("term_name");
                    $filter['stream_name'] = $this->input->post("stream_name");
                    $filter['section_name'] = $this->input->post("section_name");
                    $this->sendPushNotificationToStudents($title,$body,$uploadedFilePath,$filter);
                    // $email_option = $this->input->post('send_email_option');
                    // if(isset($email_option)){
                    //     $this->sendEmailToAllStudent($title,$body);
                    // }

                    $this->push_notification_model->saveStudentNotification($filter['term_name'],$filter['stream_name'],$filter['section_name'],$title,$body,$uploadedFilePath);    
                }
                $this->index(); 
            }
        }
    }
    
    private function sendPushNotificationToAllStaffs($title,$body){
        $all_users_token = $this->push_notification_model->getAllStaffsToken();
        $tokenBatch = array_chunk($all_users_token,500);
        for($itr = 0; $itr < count($tokenBatch); $itr++){
            $this->push_notification_model->sendMessage($title,$body,$tokenBatch[$itr],USER_TYPE_STAFF);
        }
        $this->session->set_flashdata('success','Notification sent..!');            
    }

    private function sendPushNotificationToStudents($title,$body,$uploadedFilePath,$filters=array()){
        $all_users_token = $this->push_notification_model->getStudentsToken($filters);
        $tokenBatch = array_chunk($all_users_token,500);
        for($itr = 0; $itr < count($tokenBatch); $itr++){
            $this->push_notification_model->sendMessage($title,$body,$tokenBatch[$itr],'student');
        }
        $this->session->set_flashdata('success','Notification sent..!'); 
    }

    private function sendEmailToAllStaff($title,$body){
        $users_email_address = $this->custom_email_model->getAllStaffsEmail();
        $users_email_address = array_filter($users_email_address);
        if(! empty($users_email_address !== 0)){
            $this->custom_email_model->sendEmail($title,$body,$users_email_address);
        }                        
    }

    private function sendEmailToAllStudent($title,$body){
        $users_email_address = $this->custom_email_model->getAllStudentsEmail();
        $users_email_address = array_filter($users_email_address);
        if(! empty($users_email_address !== 0)){
            $this->custom_email_model->sendEmail($title,$body,$users_email_address);
        }                       
    }

 // Student Notification Listing
    function studentNotifications() {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $filter = array();
            $by_date = $this->security->xss_clean($this->input->post('by_date'));
            $by_term = $this->security->xss_clean($this->input->post('by_term'));
            $by_stream = $this->security->xss_clean($this->input->post('by_stream'));
            $by_Section = $this->security->xss_clean($this->input->post('by_Section'));
            $by_subject = $this->security->xss_clean($this->input->post('by_subject'));
            $by_message = $this->security->xss_clean($this->input->post('by_message'));
            $sent_by = $this->security->xss_clean($this->input->post('sent_by'));

            $data['by_subject'] = $by_subject;
            $data['by_term'] = $by_term;
            $data['by_stream'] = $by_stream;
            $data['by_Section'] = $by_Section;
            $data['sent_by'] = $sent_by;
            $data['by_message'] = $by_message;

            $filter['by_subject'] = $by_subject;
            $filter['by_term'] = $by_term;
            $filter['by_stream'] = $by_stream;
            $filter['by_Section'] = $by_Section;
            $filter['by_message'] = $by_message;
            $filter['sent_by'] = $sent_by;

            if(!empty($by_date)){
                $filter['by_date'] = date('Y-m-d',strtotime($by_date));
                $data['by_date'] = date('d-m-Y',strtotime($by_date));
            }else{
                $data['by_date'] = '';
                $filter['by_date'] = '';
            }

            $data['streamInfo'] = $this->students_model->getAllStreamName();
            $count = $this->push_notification_model->getAllstudentNotificationCount($filter);
            $returns = $this->paginationCompress("studentNotifications/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['notifications'] = $this->push_notification_model->getAllstudentNotification($filter);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Student Details';
            $this->loadViews("push_notification/studentNotification", $this->global,$data, NULL);

        }
    }

         //delete an Notification info
     public function deleteStudentNotification(){
        if ($this->isAdmin() == true) {
            echo (json_encode(array('status' => 'access')));
        } else {
            $row_id = $this->input->post('row_id');
            $notifications = array('is_deleted' => 1,
            'updated_by' => $this->staff_id,
            'updated_date_time' => date('Y-m-d h:i:s'));
            $result = $this->push_notification_model->updateNotification($row_id, $notifications);
            if ($result > 0) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        }
    } 
    

}
