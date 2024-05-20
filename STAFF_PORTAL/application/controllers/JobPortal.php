<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class JobPortal extends BaseController{
    function __construct(){
        parent::__construct();        
        $this->isLoggedIn();
        $this->load->model('jobportal_model',"jobportal");
        $this->load->library('pagination');
        $this->load->helper('date');
    }
    function index(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {  
              
            $date_from_filter = $data['date_from_filter'] = $this->input->post('date_from_filter'); 
            if(!empty($date_from_filter)){
	            $filter['date_from_filter'] = date('Y-m-d',strtotime($date_from_filter));
	            $data['date_from_filter'] = $date_from_filter;
	        }else{
	            $data['date_from_filter'] = date('Y-m-01');
                $filter['date_from_filter'] = date('Y-m-01');
	        }

            $date_to_filter = $data['date_to_filter'] = $this->input->post('date_to_filter'); 
            if(!empty($date_to_filter)){
	            $filter['date_to_filter'] = date('Y-m-d',strtotime($date_to_filter));
	            $data['date_to_filter'] = $date_to_filter;
	        }else{
	            $data['date_to_filter'] = date('Y-m-t');
                $filter['date_to_filter'] = date('Y-m-t');
            }
            // $applied_date = $data['applied_date'] = $this->input->post('applied_date'); 
            // if(!empty($applied_date)){
	        //     $filter['applied_date'] = date('Y-m-d',strtotime($applied_date));
	        //     $data['applied_date'] = $applied_date;
	        // }else{
	        //     $data['applied_date'] = '';
            //     $filter['applied_date'] = '';
	        // }
   
            $data['applied_date'] = $this->input->post('applied_date');
            $data['subject'] = $this->input->post('subject');
            $data['applicant_name'] = $this->input->post('applicant_name');
            $data['mobile_number'] = $this->input->post('mobile_number');
            $data['qualification'] = $this->input->post('qualification');
            $data['work_experience'] = $this->input->post('work_experience');
            $data['bed_percent'] = $this->input->post('bed_percent');
            $data['job_post'] = $this->input->post('job_post');
            $data['applicants'] = $this->jobportal->applicantListing($data);
            $data['getPostName'] = $this->jobportal->getPostName(); 
            $data['totalApplicants'] = count($data['applicants']);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Job Application ';
            $this->loadViews('job_portal/listing', $this->global, $data, null);
        }
    }
    function viewApplicant($apcnt_id=""){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {        
            $data['info'] = $this->jobportal->getApplicantInfoByID($apcnt_id);
            // log_message('debug','info '.print_r($data['info'],true));
            if(empty($data['info'])){
                redirect('jobPortal');
            }else{
                  $this->global['pageTitle'] = ''.TAB_TITLE.' : Job Application ';
                $this->loadViews('job_portal/view_applicant', $this->global, $data, null);
            }
        }
    }
    function deleteApplicant(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {        
            if($this->input->server('REQUEST_METHOD') === 'POST'){
                if(!empty($this->input->post('row_id'))){
                    $details = array(
                        'is_deleted' => 1,
                        'updated_by' => $this->session->userdata('staff_id'),
                        'updated_date_time' =>  mdate("%Y-%m-%d %h:%i:%s")
                    );
                    echo $this->jobportal->deleteApplicant($this->input->post('row_id'),$details);
                }else{
                    echo 0;
                }
            }
        }
    }


    public function updateApprovedStatus(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else { 
            // $number = "";  
            $application_number = $this->input->post('application_number');
            $comments = $this->input->post('comments');
            $type = $this->input->post('type');

            // log_message('debug','$application_number '.$application_number);
            // log_message('debug','$comments '.$comments);
            // log_message('debug','$type '.$type);
            
    
            // $studentApplicationStatus = $this->admission->getStudentApplicationStatusByAppNo($application_number);
    
            // $studentApplicationInfo = $this->admission->getStudentApplicationInfoByID($studentApplicationStatus->registered_row_id);
    
            // if(!empty($studentApplicationInfo)){
            //     $number .= $studentApplicationInfo->permanent_phone_number;
            // }
           
            // $checkExists = $this->admission->getStudentInfoBy_AppNo($application_number);
    
            
    
        //    $class =  $studentApplicationInfo->std_class;
        //    $bank_account =  $studentApplicationInfo->bank_account_no;
        //    $branch =  $studentApplicationInfo->branch_name;
        //    $ifsc =  $studentApplicationInfo->ifsc_code;
    
            if($type == 'Approve'){
    
                // $office_no = '8431594151';
                // $message = "Dear Parent, Your application is approved. For more details please contact the school office ".$office_no." Thank you. Regards, Principal, St.Joseph School, Pandithahalli.";
                // $this->sendSMS($number, $message);
    
                $applicationInfo = array(
                    'approved_status' => 1,
                    'comments' => $comments,
                    'approved_by' =>  $this->staff_id,
                    'approved_date_time' => date('Y-m-d H:i:s'),
                    'updated_date_time' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->staff_id
                );
                  
            }
            $result = $this->jobportal->updateApprovedStatus($applicationInfo, $application_number);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function updateJobApplicationStatus(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $application_number = $this->input->post('application_number');
            $type = $this->input->post('type');
            $comments = $this->input->post('comments');
            if($type == 'Approve'){
                $applicationInfo = array(
                    'approved_status' => 1,
                    'comments' => $comments,
                    'approved_by' =>  $this->staff_id,
                    'approved_date_time' => date('Y-m-d H:i:s'),
                    'updated_date_time' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->staff_id);
            }else if($type == 'Reject'){
                $applicationInfo = array(
                    'approved_status' => 2,
                    'comments' => $comments,
                    'rejected_by' =>  $this->staff_id,
                    'rejected_date_time' => date('Y-m-d H:i:s'),
                    'updated_date_time' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->staff_id);
            }
            $result = $this->jobportal->updateApprovedStatus($applicationInfo, $application_number);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function updateStudentJobStatus(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
    
        $comments = $this->input->post('comments');
        $application_number = $this->input->post('application_number');
        // $register_row_id = $this->input->post('register_row_id');
    
        // if($isExist == 0){
    
            $applicationInfo = array(
                    'approved_status' => 2,
                    'comments' => $comments,
                    'rejected_by' =>  $this->staff_id,
                    'rejected_date_time' => date('Y-m-d H:i:s'),
                    'updated_date_time' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->staff_id);
               
    
            $result = $this->jobportal->updateApprovedStatus($applicationInfo, $application_number);
    
            if($result > 0){
                $this->session->set_flashdata('success', 'Application Rejected Successfully');
            }else{
                $this->session->set_flashdata('error', 'Failed to Reject');
            }
    
            redirect('viewApplicant/'.$application_number); 
        } 
    }

    public function updateShortlistApplication() {
        // Debugging: Check if the method is reached
        // log_message('debug', 'updateShortlistApplication method reached');

        if ($this->isAdmin()) {
            $this->loadThis();
        } else {
            // Debugging: Check if data is received properly
            $students_application_number = $this->input->post('students_appliction_number');
            // log_message('debug', 'Received students_appliction_number: ' . $students_application_number);

            $application_number = json_decode(stripslashes($students_application_number), true);

            // Debugging: Log decoded data
            // log_message('debug', 'Decoded application numbers: ' . print_r($application_number, true));

            foreach ($application_number as $application_no) {
                $applicationInfo = array(
                    'shortlisted_by' => $this->staff_id,
                    'shortlisted_date_time' => date('Y-m-d H:i:s'),
                    'shortlisted_status' => 1,
                    'updated_by' => $this->staff_id,
                    'updated_date_time' => date('Y-m-d H:i:s'),
                );

                // Debugging: Log application info
                // log_message('debug', 'Application Info: ' . print_r($applicationInfo, true));

                $return_id = $this->jobportal->updateApprovedStatus($applicationInfo, $application_no);

                // Debugging: Log return ID
                // log_message('debug', 'Return ID: ' . $return_id);
            }

            // Debugging: Check if JSON response is sent
            header('Content-type: application/json');
            echo json_encode($return_id);
            exit(0);
        }
    }


    function approvedJobApplication(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {  
              
            $date_from_filter = $data['date_from_filter'] = $this->input->post('date_from_filter'); 
            if(!empty($date_from_filter)){
	            $filter['date_from_filter'] = date('Y-m-d',strtotime($date_from_filter));
	            $data['date_from_filter'] = $date_from_filter;
	        }else{
	            $data['date_from_filter'] = date('Y-m-01');
                $filter['date_from_filter'] = date('Y-m-01');
	        }

            $date_to_filter = $data['date_to_filter'] = $this->input->post('date_to_filter'); 
            if(!empty($date_to_filter)){
	            $filter['date_to_filter'] = date('Y-m-d',strtotime($date_to_filter));
	            $data['date_to_filter'] = $date_to_filter;
	        }else{
	            $data['date_to_filter'] = date('Y-m-t');
                $filter['date_to_filter'] = date('Y-m-t');
            }
           
   
            $data['applied_date'] = $this->input->post('applied_date');
            $data['subject'] = $this->input->post('subject');
            $data['applicant_name'] = $this->input->post('applicant_name');
            $data['mobile_number'] = $this->input->post('mobile_number');
            $data['qualification'] = $this->input->post('qualification');
            $data['work_experience'] = $this->input->post('work_experience');
            $data['bed_percent'] = $this->input->post('bed_percent');
            $data['job_post'] = $this->input->post('job_post');
            $data['applicants'] = $this->jobportal->approvedApplicantionListing($data);
            $data['getPostName'] = $this->jobportal->getPostName(); 
            $data['totalApplicants'] = count($data['applicants']);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Job Application ';
            $this->loadViews('job_portal/approvedApplication', $this->global, $data, null);
        }
    }

    function rejectedJobApplication(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {  
              
            $date_from_filter = $data['date_from_filter'] = $this->input->post('date_from_filter'); 
            if(!empty($date_from_filter)){
	            $filter['date_from_filter'] = date('Y-m-d',strtotime($date_from_filter));
	            $data['date_from_filter'] = $date_from_filter;
	        }else{
	            $data['date_from_filter'] = date('Y-m-01');
                $filter['date_from_filter'] = date('Y-m-01');
	        }

            $date_to_filter = $data['date_to_filter'] = $this->input->post('date_to_filter'); 
            if(!empty($date_to_filter)){
	            $filter['date_to_filter'] = date('Y-m-d',strtotime($date_to_filter));
	            $data['date_to_filter'] = $date_to_filter;
	        }else{
	            $data['date_to_filter'] = date('Y-m-t');
                $filter['date_to_filter'] = date('Y-m-t');
            }
           
   
            $data['applied_date'] = $this->input->post('applied_date');
            $data['subject'] = $this->input->post('subject');
            $data['applicant_name'] = $this->input->post('applicant_name');
            $data['mobile_number'] = $this->input->post('mobile_number');
            $data['qualification'] = $this->input->post('qualification');
            $data['work_experience'] = $this->input->post('work_experience');
            $data['bed_percent'] = $this->input->post('bed_percent');
            $data['job_post'] = $this->input->post('job_post');
            $data['applicants'] = $this->jobportal->rejectApplicantionListing($data);
            $data['getPostName'] = $this->jobportal->getPostName(); 
            $data['totalApplicants'] = count($data['applicants']);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Job Application ';
            $this->loadViews('job_portal/rejectedApplication', $this->global, $data, null);
        }
    }

    function shorlistedJobApplication(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {  
              
            $date_from_filter = $data['date_from_filter'] = $this->input->post('date_from_filter'); 
            if(!empty($date_from_filter)){
	            $filter['date_from_filter'] = date('Y-m-d',strtotime($date_from_filter));
	            $data['date_from_filter'] = $date_from_filter;
	        }else{
	            $data['date_from_filter'] = date('Y-m-01');
                $filter['date_from_filter'] = date('Y-m-01');
	        }

            $date_to_filter = $data['date_to_filter'] = $this->input->post('date_to_filter'); 
            if(!empty($date_to_filter)){
	            $filter['date_to_filter'] = date('Y-m-d',strtotime($date_to_filter));
	            $data['date_to_filter'] = $date_to_filter;
	        }else{
	            $data['date_to_filter'] = date('Y-m-t');
                $filter['date_to_filter'] = date('Y-m-t');
            }
           
   
            $data['applied_date'] = $this->input->post('applied_date');
            $data['subject'] = $this->input->post('subject');
            $data['applicant_name'] = $this->input->post('applicant_name');
            $data['mobile_number'] = $this->input->post('mobile_number');
            $data['qualification'] = $this->input->post('qualification');
            $data['work_experience'] = $this->input->post('work_experience');
            $data['bed_percent'] = $this->input->post('bed_percent');
            $data['job_post'] = $this->input->post('job_post');
            $data['applicants'] = $this->jobportal->shortlistedapplicantionListing($data);
            $data['getPostName'] = $this->jobportal->getPostName(); 
            $data['totalApplicants'] = count($data['applicants']);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Job Application ';
            $this->loadViews('job_portal/shortlistApplication', $this->global, $data, null);
        }
    }


    public function jobDashboard() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }else {
            $data['AppliedCount'] = $this->jobportal->applicantListingCount();
            $data['ApprovedCount'] = $this->jobportal->approvedapplicantionListingCount();
            $data['shortlistedCount'] = $this->jobportal->shortlistedapplicantionListingCount();
            $data['rejectedCount'] = $this->jobportal->rejectApplicantionListingCount();
            // log_message('debug','AppliedCount '.$data['AppliedCount']);
           
            // $data['admission_year'] =  '2023';
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Job Dashboard ';
            $this->loadViews("job_portal/jobDashboard", $this->global, $data, NULL);
        }
    }
    
    public function addJobPost() {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
            $job_post =$this->security->xss_clean($this->input->post('job_post'));
            $isExist = $this->jobportal->checkJobPostExists($job_post);
            if ($isExist) { // Check if $isExist is truthy
                $this->session->set_flashdata('error', 'Job Post is already Exist');
                redirect('viewSettings');
            }
            $jobPostInfo = array('job_post'=>$job_post,'is_active' => 0,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));
            $result = $this->jobportal->addJobPost($jobPostInfo);
            if($result > 0){
                $this->session->set_flashdata('success', 'New Job Post created successfully');
            } else{
                $this->session->set_flashdata('error', 'Job Post creation failed');
            }
            redirect('viewSettings');
        }
    }

     // Delete  visitor type information
     public function deleteJobPost(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $jobPostInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->jobportal->updateJobPostInfo($jobPostInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function activeJobPost(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $jobPostInfo = array('is_active' => 0,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->jobportal->updateJobPostInfo($jobPostInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function inactiveJobPost(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $jobPostInfo = array('is_active' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->jobportal->updateJobPostInfo($jobPostInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
}