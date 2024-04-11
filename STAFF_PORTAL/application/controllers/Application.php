<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Application extends BaseController {
    public function __construct()
    {
        parent::__construct(); 
        $this->load->library('pdf');
        $this->load->model('application_model','application');
        $this->load->model('subjects_model','subject');
        $this->load->model('staff_model','staff');
        $this->load->model('fee_model','fee');
        $this->load->library('excel');
        $this->load->model('students_model','student');
        $this->isLoggedIn();
    }
    public function getAllApplicationInfoForCheck(){
        $appInfo = $this->application->getAllApplicationInfoForCheck();
        foreach($appInfo as $app){
        //  log_message('debug','number=='.$app->application_number);  
        }
        redirect("newAdmission");
    }

    
    public function getAdmissionPaymentPeningApplication(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $filter = array();
            $application_no = $this->input->post('application_no');
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $parent_generation = $this->security->xss_clean($this->input->post('parent_generation'));
            $sslc_pecentage = $this->security->xss_clean($this->input->post('sslc_pecentage'));
            $board_name = $this->security->xss_clean($this->input->post('board_name'));
    
            $data['application_no'] = $application_no;
            $data['student_name'] = $student_name;
            $data['term_name'] = $term_name;
            $data['stream_name'] = $stream_name;
            $data['parent_generation'] = $parent_generation;
            $data['sslc_pecentage'] = $sslc_pecentage;
            $data['board_name'] = $board_name;
    
            $filter['application_no']= $application_no;
            $filter['student_name']= $student_name;
            $filter['term_name']= $term_name;
            $filter['stream_name']= $stream_name;
            $filter['parent_generation']= $parent_generation;
            $filter['sslc_pecentage'] = $sslc_pecentage;
            $filter['board_name'] = $board_name;
 
            $this->load->library('pagination');
            $count = $this->application->getPendingPaymentApplicationInfoCount($filter);
            $returns = $this->paginationCompress("getAdmissionPaymentPeningApplication/", $count, 100);
            $data['studentCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['studentInfo'] = $this->application->getPendingPaymentApplicationInfo($filter);
            $data['streamInfo'] = $this->application->getStreamNames();
            $data['boardInfo'] = $this->application->getBoardName();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Payment Pending Application';
            $this->loadViews("application/admissionPendingList", $this->global, $data, null);
        }
    }

    
    public function getAdmissionRegisteredStudent(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $filter = array();
            $name = $this->input->post('name');
            $dob = $this->security->xss_clean($this->input->post('dob'));
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            $date = $this->security->xss_clean($this->input->post('date'));
            $email = $this->security->xss_clean($this->input->post('email'));
            $board_name = $this->security->xss_clean($this->input->post('board_name'));
            // $parent_generation = $this->security->xss_clean($this->input->post('parent_generation'));
            // $sslc_pecentage = $this->security->xss_clean($this->input->post('sslc_pecentage'));
            $admission_year = $this->security->xss_clean($this->input->post('admission_year'));

            
            $data['admission_year'] = $admission_year;


            if($admission_year == '') {
                $filter['admission_year'] = 2024;

            }else {
                $filter['admission_year']  = $admission_year;

            }
    
            $data['name'] = $name;
            $data['board_name'] = $board_name;
            $data['mobile'] = $mobile;
            $data['board_name'] = $board_name;
            $data['email'] = $email;

    
            $filter['name']= $name;
            $filter['board_name']= $board_name;
            $filter['mobile']= $mobile;
            $filter['board_name'] = $board_name;
            $filter['email'] = $email;


            if(!empty($dob)){
                $data['dob'] = date('d-m-Y',strtotime($dob));
                $filter['dob']= date('Y-m-d',strtotime($dob));
            }else{
                $data['dob'] = '';
                $filter['dob']= '';
            }

            

            if(!empty($date)){
                $data['date'] = date('d-m-Y',strtotime($date));
                $filter['date']= date('Y-m-d',strtotime($date));
            }else{
                $data['date'] = '';
                $filter['date']= '';
            }
 
            $this->load->library('pagination');
            $count = $this->application->getAdmissionRegisteredInfoCount($filter);
            $returns = $this->paginationCompress("getAdmissionPaymentPeningApplication/", $count, 100);
            $data['studentCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['studentInfo'] = $this->application->getAdmissionRegisteredInfo($filter);
            $data['streamInfo'] = $this->application->getStreamNames();
            $data['boardInfo'] = $this->application->getBoardName();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Admission Registered Student';
            $this->loadViews("application/admissionRegisteration", $this->global, $data, null);
        }
    }
    
    public function newAdmission(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $filter = array();
            $by_sports_category = $this->security->xss_clean($this->input->post('by_sports_category')); 
            $application_number =$this->security->xss_clean($this->input->post('application_number')); 
            $student_name =$this->security->xss_clean($this->input->post('student_name')); 
            $father_name =$this->security->xss_clean($this->input->post('father_name')); 
            $by_first_preference =$this->security->xss_clean($this->input->post('by_first_preference')); 
            $by_second_preference =$this->security->xss_clean($this->input->post('by_second_preference')); 
            $sms_status = $this->security->xss_clean($this->input->post('sms_status')); 
            $percentage_from =$this->security->xss_clean($this->input->post('percentage_from')); 
            $percentage_to =$this->security->xss_clean($this->input->post('percentage_to')); 
            $by_category_name =$this->security->xss_clean($this->input->post('by_category_name'));
            $by_board_name =$this->security->xss_clean($this->input->post('by_board_name')); 
            $by_program_name =  $this->security->xss_clean($this->input->post('program_name')); 
            $by_stream_name =  $this->security->xss_clean($this->input->post('by_stream_name')); 
            $ninth_percentage =  $this->security->xss_clean($this->input->post('ninth_percentage')); 
            $admission_year = $this->security->xss_clean($this->input->post('admission_year'));
            $integrated_batch = $this->security->xss_clean($this->input->post('integrated_batch'));


            
            $data['admission_year'] = $admission_year;


            if($admission_year == '') {
                $filter['admission_year'] = 2024;

            }else {
                $filter['admission_year']  = $admission_year;

            }


            $data['sms_status'] = $sms_status;
            $data['by_sports_category'] = $by_sports_category;
            $data['searchTextCust'] = $searchTextCust;
            $data['application_number'] = $application_number;
            $data['student_name'] = $student_name;
            $data['father_name'] = $father_name;
            $data['percentage_from'] = $percentage_from;
            $data['percentage_to'] = $percentage_to;
            $data['by_first_preference'] = $by_first_preference;
            $data['by_second_preference'] = $by_second_preference;
            $data['by_category_name'] = $by_category_name;
            $data['by_board_name'] = $by_board_name;
            $data['ninth_percentage'] = $ninth_percentage;
            $data['integrated_batch'] = $integrated_batch;



            $filter['by_sports_category'] = $by_sports_category;
            $filter['application_number'] = $application_number;
            $filter['by_category_name'] = $by_category_name;
            $filter['student_name'] = $student_name;
            $filter['father_name'] = $father_name;
            $filter['percentage_from'] = $percentage_from;
            $filter['percentage_to'] = $percentage_to;
            $filter['by_first_preference'] = $by_first_preference;
            $filter['by_second_preference'] = $by_second_preference;
            $filter['sms_status'] = $sms_status;
            $filter['by_program_name'] = $by_program_name;
            $filter['by_board_name'] = $by_board_name;
            $filter['by_stream_name'] = $by_stream_name;
            $filter['ninth_percentage'] = $ninth_percentage;
            $filter['integrated_batch'] = $integrated_batch;

            
            $this->load->library('pagination');
            $count = $this->application->getApprovedStudentsCount($filter);
            $returns = $this->paginationCompress("newAdmission/", $count, 100);
            $data['studentCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['studentInfo'] = $this->application->getApprovedStudentsDetails($filter);
            $data['streamInfo'] = $this->application->getStreamNames();
            $data['boardInfo'] = $this->application->getBoardName();
            $data['casteInfo'] = $this->application->getCasteInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Approved Application';
            $this->loadViews("application/newAdmission", $this->global, $data, null);
        }
    }

    public function viewAdmissionCompletedInfo(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $filter = array();
            $application_no = $this->input->post('application_no');
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $application_status = $this->security->xss_clean($this->input->post('application_status'));
            $sslc_pecentage = $this->security->xss_clean($this->input->post('sslc_pecentage'));
    
            $data['application_no'] = $application_no;
            $data['student_name'] = $student_name;
            $data['term_name'] = $term_name;
            $data['stream_name'] = $stream_name;
            $data['application_status'] = $application_status;
            $data['sslc_pecentage'] = $sslc_pecentage;
    
            $filter['application_no']= $application_no;
            $filter['student_name']= $student_name;
            $filter['term_name']= $term_name;
            $filter['stream_name']= $stream_name;
            $filter['application_status']= $application_status;
            $filter['sslc_pecentage'] = $sslc_pecentage;
 
            $this->load->library('pagination');
            $count = $this->application->getAdmissionCompletedInfoCount($filter);
            $returns = $this->paginationCompress("viewAdmissionCompletedInfo/", $count, 100);
            $data['studentCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['studentInfo'] = $this->application->getAdmissionCompletedInfo($filter);
            $data['streamInfo'] = $this->application->getStreamNames();
            $data['boardInfo'] = $this->application->getBoardName();
            $data['casteInfo'] = $this->application->getCasteInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Admitted Application';
            $this->loadViews("application/viewAdmissionCompletedInfo", $this->global, $data, null);
        }
    }
    

    public function getAllApplicationInfo(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $filter = array();
            $application_no = $this->input->post('application_no');
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $by_first_preference = $this->security->xss_clean($this->input->post('by_first_preference'));
            $by_second_preference = $this->security->xss_clean($this->input->post('by_second_preference'));
            $by_category_name = $this->security->xss_clean($this->input->post('by_category_name'));
            $sslc_pecentage = $this->security->xss_clean($this->input->post('sslc_pecentage'));
            $ninth_pecentage = $this->security->xss_clean($this->input->post('ninth_pecentage'));
            $board_name = $this->security->xss_clean($this->input->post('board_name'));
            $admission_year = $this->security->xss_clean($this->input->post('admission_year'));
            $integrated_batch = $this->security->xss_clean($this->input->post('integrated_batch'));


            
            $data['admission_year'] = $admission_year;


            if($admission_year == '') {
                $filter['admission_year'] = 2024;

            }else {
                $filter['admission_year']  = $admission_year;

            }
    
            $data['application_no'] = $application_no;
            $data['integrated_batch'] = $integrated_batch;
            $data['student_name'] = $student_name;
            $data['term_name'] = $term_name;
            $data['by_first_preference'] = $by_first_preference;
            $data['by_second_preference'] = $by_second_preference;
            $data['by_category_name'] = $by_category_name;
            $data['sslc_pecentage'] = $sslc_pecentage;
            $data['ninth_pecentage'] = $ninth_pecentage;
            $data['board_name'] = $board_name;
    
            $filter['application_no']= $application_no;
            $filter['integrated_batch']= $integrated_batch;
            $filter['student_name']= $student_name;
            $filter['term_name']= $term_name;
            $filter['by_first_preference']= $by_first_preference;
            $filter['by_second_preference']= $by_second_preference;
            $filter['by_category_name']= $by_category_name;
            $filter['sslc_pecentage'] = $sslc_pecentage;
            $filter['ninth_pecentage'] = $ninth_pecentage;
            $filter['board_name'] = $board_name;
 
            $this->load->library('pagination');
            $count = $this->application->getAllApplicationInfoCount($filter);
            $returns = $this->paginationCompress("getAllApplicationInfo/", $count, 100);
            $data['studentCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['studentInfo'] = $this->application->getAllApplicationInfo($filter);
            $data['streamInfo'] = $this->application->getStreamNames();
            $data['boardInfo'] = $this->application->getBoardName();
            $data['casteInfo'] = $this->application->getCasteInfo();
            // log_message('debug','dfeuh=='.print_r($data['studentInfo'],true));
            // log_message('debug','filter=='.print_r($filter,true));
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Application Stack';
            $this->loadViews("application/viewApplicationStack", $this->global, $data, null);
        }
    }

    public function getRejectedApplicationInfo(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $filter = array();
            $application_no = $this->input->post('application_no');
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $by_board_name = $this->security->xss_clean($this->input->post('by_board_name'));
            $by_first_preference = $this->security->xss_clean($this->input->post('by_first_preference'));
            $second_preference = $this->security->xss_clean($this->input->post('second_preference'));
            $sslc_pecentage = $this->security->xss_clean($this->input->post('sslc_pecentage'));
            $by_category_name = $this->security->xss_clean($this->input->post('by_category_name'));
            $admission_year = $this->security->xss_clean($this->input->post('admission_year'));
            $integrated_batch = $this->security->xss_clean($this->input->post('integrated_batch'));


            
            $data['admission_year'] = $admission_year;


            if($admission_year == '') {
                $filter['admission_year'] = 2024;

            }else {
                $filter['admission_year']  = $admission_year;

            }
    
            $data['application_no'] = $application_no;
            $data['integrated_batch'] = $integrated_batch;
            $data['student_name'] = $student_name;
            $data['by_board_name'] = $by_board_name;
            $data['by_first_preference'] = $by_first_preference;
            $data['second_preference'] = $second_preference;
            $data['sslc_pecentage'] = $sslc_pecentage;
            $data['by_category_name'] = $by_category_name;
    
            $filter['integrated_batch']= $integrated_batch;
            $filter['application_no']= $application_no;
            $filter['student_name']= $student_name;
            $filter['by_board_name']= $by_board_name;
            $filter['by_first_preference']= $by_first_preference;
            $filter['second_preference']= $second_preference;
            $filter['sslc_pecentage'] = $sslc_pecentage;
            $filter['by_category_name'] = $by_category_name;
 
            $this->load->library('pagination');
            $count = $this->application->getRejectedApplicationInfoCount($filter);
            $returns = $this->paginationCompress("getRejectedApplicationInfo/", $count, 100);
            $data['studentCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['studentInfo'] = $this->application->getRejectedApplicationInfo($filter);
            $data['streamInfo'] = $this->application->getStreamNames();
            $data['boardInfo'] = $this->application->getBoardName();
            $data['casteInfo'] = $this->application->getCasteInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Rejected Application';
            $this->loadViews("application/viewRejectedApplication", $this->global, $data, null);
        }
    }

    
    public function getShortlistedApplication(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $filter = array();
            $admission_status = $this->security->xss_clean($this->input->post('admission_status')); 
            $by_sports_category = $this->security->xss_clean($this->input->post('by_sports_category')); 
            $sms_status = $this->security->xss_clean($this->input->post('sms_status')); 
            $shortlisted_by = $this->security->xss_clean($this->input->post('shortlisted_by'));
            $application_number =$this->security->xss_clean($this->input->post('application_number')); 
            $student_name =$this->security->xss_clean($this->input->post('student_name')); 
            $father_name =$this->security->xss_clean($this->input->post('father_name')); 
            $by_first_preference =$this->security->xss_clean($this->input->post('by_first_preference')); 
            $by_second_preference =$this->security->xss_clean($this->input->post('by_second_preference')); 
            $by_interview_date =$this->security->xss_clean($this->input->post('by_interview_date')); 
            $percentage_from =$this->security->xss_clean($this->input->post('percentage_from')); 
            $percentage_to =$this->security->xss_clean($this->input->post('percentage_to'));
            $by_category_name =$this->security->xss_clean($this->input->post('by_category_name'));
            $by_board_name =$this->security->xss_clean($this->input->post('board_name')); 
            $by_program_name =  $this->security->xss_clean($this->input->post('program_name')); 
            $by_stream_name =  $this->security->xss_clean($this->input->post('stream_name')); 
            $shortlisted_list_number =  $this->security->xss_clean($this->input->post('shortlisted_list_number')); 
            $admission_year = $this->security->xss_clean($this->input->post('admission_year'));
            $integrated_batch = $this->security->xss_clean($this->input->post('integrated_batch'));


            
            $data['admission_year'] = $admission_year;


            if($admission_year == '') {
                $filter['admission_year'] = 2024;

            }else {
                $filter['admission_year']  = $admission_year;

            }
            


            $data['stream_name'] = $by_stream_name;
            $data['sms_status'] = $sms_status;
            $data['admission_status'] = $admission_status;
            $data['by_sports_category'] = $by_sports_category;
            $data['searchTextCust'] = $searchTextCust;
            $data['application_number'] = $application_number;
            $data['student_name'] = $student_name;
            $data['father_name'] = $father_name;
            $data['percentage_from'] = $percentage_from;
            $data['percentage_to'] = $percentage_to;
            $data['by_first_preference'] = $by_first_preference;
            $data['by_second_preference'] = $by_second_preference;
            $data['by_category_name'] = $by_category_name;
            $data['shortlisted_by'] = $shortlisted_by;
            $data['by_board_name'] = $by_board_name;
            $data['shortlisted_list_number'] = $shortlisted_list_number;
            $data['integrated_batch'] = $integrated_batch;


            

            $filter['shortlisted_list_number'] = $shortlisted_list_number;
            $filter['admission_status'] = $admission_status;
            $filter['by_sports_category'] = $by_sports_category;
            $filter['sms_status'] = $sms_status;
            $filter['shortlisted_by'] = $shortlisted_by;
            $filter['application_number'] = $application_number;
            $filter['by_category_name'] = $by_category_name;
            $filter['student_name'] = $student_name;
            $filter['father_name'] = $father_name;
            $filter['percentage_from'] = $percentage_from;
            $filter['percentage_to'] = $percentage_to;
            $filter['by_first_preference'] = $by_first_preference;
            $filter['by_second_preference'] = $by_second_preference;
            $filter['by_program_name'] = $by_program_name;
            $filter['by_board_name'] = $by_board_name;
            $filter['by_stream_name'] = $by_stream_name;
            $filter['integrated_batch'] = $integrated_batch;


            if(!empty($by_interview_date)){
                $filter['by_interview_date'] = date('Y-m-d',strtotime($by_interview_date));
                $data['by_interview_date'] = date('d-m-Y',strtotime($by_interview_date));
            }else{
                $data['by_interview_date'] = "";
            }


            $this->load->library('pagination');
            $count = $this->application->getShortlistedStudentsCount($filter);
            $returns = $this->paginationCompress("getShortlistedApplication/", $count, 100);
            $data['studentCount'] = $count;
            $data['studentInfo'] = $this->application->getShortlistedStudentsDetails($filter);
            $data['streamInfo'] = $this->application->getStreamNames();
            $data['boardInfo'] = $this->application->getBoardName();
            $data['casteInfo'] = $this->application->getCasteInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Shortlisted Students';
            $this->loadViews("application/viewShortlisteddApplication", $this->global, $data, null);
        }
    }

       
    public function getAllApplicationFeePaidInfo(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $filter = array();
            $application_no = $this->input->post('application_no');
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $parent_generation = $this->security->xss_clean($this->input->post('parent_generation'));
            $fee_amount = $this->security->xss_clean($this->input->post('fee_amount'));
            $order_id = $this->security->xss_clean($this->input->post('order_id'));
    
            $data['application_no'] = $application_no;
            $data['student_name'] = $student_name;
            $data['term_name'] = $term_name;
            $data['stream_name'] = $stream_name;
            $data['parent_generation'] = $parent_generation;
            $data['fee_amount'] = $fee_amount;
            $data['order_id'] = $order_id;
    
            $filter['application_no']= $application_no;
            $filter['student_name']= $student_name;
            $filter['term_name']= $term_name;
            $filter['stream_name']= $stream_name;
            $filter['parent_generation']= $parent_generation;
            $filter['fee_amount'] = $fee_amount;
            $filter['order_id'] = $order_id;
 
            $this->load->library('pagination');
            $count = $this->application->getApplicationFeePaidInfoCount($filter);
            $returns = $this->paginationCompress("getAllApplicationFeePaidInfo/", $count, 100);
            $data['studentCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['studentInfo'] = $this->application->getApplicationFeePaidInfo($filter);
            $data['streamInfo'] = $this->application->getStreamNames();
            $data['boardInfo'] = $this->application->getBoardName();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Application Fee Paid';
            $this->loadViews("application/applicationFeePaidDetails", $this->global, $data, null);
        }
    }


    // get caste info
    public function getCasteInfoById(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $caste = $this->input->post("caste");
            $data['result'] = $this->application->getCasteById($caste);
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }



//     // approve reject admission
//     public function updateApplicationStatus(){
//         if($this->isAdmin() == TRUE){
//             $this->loadThis();
//         } else {   
//             $application_number = $this->input->post('application_number');
//             $registered_row_id = $this->input->post('registered_row_id');
//             $section = $this->input->post('section');
//             $comments = $this->input->post('comments');
//             $student_category = $this->input->post('student_category');
//             $application_status_btn = $this->input->post('application_status_btn');
//             $student = $this->application->getNewAdmittedStudentInfo($application_number);
//             // log_message('debug','wjd'.print_r($student,true));

//             log_message('debug','fa ma='.$student->father_mobile);
            
//             $studentApplicationStatus = $this->application->getStudentApplicationStatusByAppNo($application_number);
//             $studentApplicationInfo = $this->application->getStudentApplicationInfoByID($studentApplicationStatus->registered_row_id);
//             $studentApplicationAcademicInfo = $this->application->getStudentAcademicInformation($studentApplicationStatus->registered_row_id);
//             $studentApplicationPreviousInfo = $this->application->getStudentPreviousInformation($studentApplicationStatus->registered_row_id);
//             $boardInfo = $this->application->getBoardNameInfoById($studentApplicationAcademicInfo->sslc_board_name_id);
    
//             $checkExists = $this->student->getStudentInfoBy_AppNo($application_number);

//             if(!empty($student)){
//                 $number .= $student->father_mobile.','.$student->mother_mobile;
//             }
            
//             // $type = $this->input->post('type');
//             if($application_status_btn == 'Approve'){
                
//                 $applicationInfo = array(
//                     'admission_status' => 1,
//                     'comments'=>$comments,
//                     'student_category' =>$student_category,
//                     'section'=>$section,
//                     'approved_by' => $this->staff_id,
//                     'submitted_doc_status'=>1,
//                     'approved_date' => date('Y-m-d'),
//                     'updated_date_time' => date('Y-m-d H:i:s'),
//                     'updated_by' => $this->staff_id);

//                     // $message = "Dear Parent/Guardian, \nYour daughter's/ward's Application No. $application_number is approved. Please click the link given below to pay the fees within TWO days from receipt of this sms failing which you might have to forgo the seat. Anyone having an issue kindly send an email to admissions@jnpuc.org\nLink - https://bit.ly/2VBVo9M\nBest Regards\nPrincipal \nJyoti Nivas Pre-University College.";
//                     // $response = $this->sendSingleNumberSMS($number, $message);
        
//                            if(empty($checkExists->students_appliction_number)){                   
//                             $studentInfo = array(
//                              'student_name' => $studentApplicationInfo->name,
//                              'application_no' => $studentApplicationStatus->application_number ,
//                              'student_id '=>$studentApplicationStatus->application_number ,
//                             'last_board_name' => $boardInfo->board_name,
//                              'term_name' => $studentApplicationAcademicInfo->program_name,
//                              'stream_name' => $studentApplicationAcademicInfo->stream_name,
//                              'section_name'=>$section,
//                              'is_active' => 1,
//                              'is_admitted' => 1,
//                              'admission_status'=>1,
//                              'intake_year' => '2023-2024',
//                              'native_place'=>$studentApplicationInfo->native_place,
//                              'last_percentage'=>$studentApplicationInfo->sslc_percentage,
//                              'mother_name' =>$studentApplicationInfo->mother_name,
//                              'father_name'  =>$studentApplicationInfo->father_name,
//                              'father_profession' =>$studentApplicationInfo->father_profession,
//                              'mother_profession'  =>$studentApplicationInfo->mother_profession,
//                              'gender'=> $studentApplicationInfo->gender,
//                              'nationality'=> $studentApplicationInfo->nationality,
//                              'religion'=> $studentApplicationInfo->religion,
//                              'caste' => $studentApplicationInfo->caste,
//                              'sub_caste' => $studentApplicationInfo->sub_caste,
//                              'category' => $studentApplicationInfo->caste,
//                              'aadhar_no'=> $studentApplicationInfo->aadhar_no,
//                              'mobile'=>$studentApplicationInfo->student_mobile,
//                              'email'=> $studentApplicationInfo->student_email,
//                              'father_annual_income'=> $studentApplicationInfo->father_annual_income,
//                              'mother_annual_income'=> $studentApplicationInfo->mother_annual_income,
//                              'guardian_name'=> $studentApplicationInfo->guardian_name,
//                              'guardian_mobile'=> $studentApplicationInfo->guardian_mobile,
//                              'guardian_address'=> $studentApplicationInfo->guardian_address,
//                              'dob'=> $studentApplicationInfo->dob,
//                             'father_age' => $studentApplicationInfo->father_age,
//                             'mother_age	'=> $studentApplicationInfo->mother_age,
//                            'mother_tongue'=> $studentApplicationInfo->mother_tongue,
//                            'mother_mobile'=> $studentApplicationInfo->mother_mobile,
//                            'father_mobile'=> $studentApplicationInfo->father_mobile,
//                            'blood_group'=> $studentApplicationInfo->blood_group,
//                            'permanent_address'=>$studentApplicationInfo->permanent_address_line_1.' '.$studentApplicationInfo->permanent_address_line_2.' '.$studentApplicationInfo->permanent_address_district.' '.$studentApplicationInfo->permanent_address_state.' '.$studentApplicationInfo->permanent_address_pincode,
//                            'present_address'=>$studentApplicationInfo->residential_address_line_1.' '.$studentApplicationInfo->residential_address_line_2.' '.$studentApplicationInfo->residential_address_district.' '.$studentApplicationInfo->residential_address_state.' '.$studentApplicationInfo->residential_address_pincode,
                             
//                             'is_dyslexic'=>$studentApplicationInfo->dyslexia_challenged,
                          
//                              'created_by' => $this->staff_id,
//                              'created_date_time' => date('Y-m-d H:i:s'),
//                              'updated_by' => $this->staff_id);
            
            
//                          }


//             }else if($application_status_btn == 'Reject'){
//                 $applicationInfo = array(
//                     'admission_status' => 2,
//                     'comments'=>$comments,
//                     'student_category' =>$student_category,
//                     'rejected_by' => $this->staff_id,
//                     'submitted_doc_status'=>0,
//                     'rejected_date' => date('Y-m-d'),
//                     'updated_date_time' => date('Y-m-d H:i:s'),
//                     'updated_by' => $this->staff_id);

// //                 $message = "Dear Student/ Parents,
// // Your application has been rejected. Please check the reason, update and re-submit the application form.
// // Regards
// // Principal
// // St. Joseph's Pre-University College HASSAN";
// //                     $response = $this->sendSingleNumberSMS($number, $message);
//             }
//             $result = $this->application->updateStudentApplicationStatus($application_number,$applicationInfo);
            
//             if($result > 0){
//                 if($application_status_btn == 'Approve'){
//                     $this->session->set_flashdata('success', 'Application Number <b>'.$application_number.'</b> Approved Successfully');
//                     $resultstd = $this->application->addStudentInfo($studentInfo);

//                 }else{
//                     $this->session->set_flashdata('success', 'Application Number <b>'.$application_number.'</b> Rejected Successfully');
//                     $this->student->deleteAdmittedStudentInfo($application_number);
//                 }
//             }else{
//                 if($application_status_btn == 'Approve'){
//                     $this->session->set_flashdata('error', 'Application Number <b>'.$application_number.'</b> Approved Failed');
//                 }else{
//                     $this->session->set_flashdata('error', 'Application Number <b>'.$application_number.'</b> Rejected Failed');
//                 }
//             }
//             redirect('editSingleStudentApplications/'.$registered_row_id);
//             // if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
//         } 
//     }
    public function updateApplicationStatus(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $application_number = $this->input->post('application_number');
            $seat_category = $this->input->post('seat_category');
            $type = $this->input->post('type');
            $section = $this->input->post('section');
            $student_category = $this->input->post('student_category');
            $studentApplicationStatus = $this->application->getStudentApplicationStatusByAppNo($application_number);
            $studentApplicationInfo = $this->application->getStudentApplicationInfoByID($studentApplicationStatus->registered_row_id);
            $studentApplicationAcademicInfo = $this->application->getStudentAcademicInformation($studentApplicationStatus->registered_row_id);
            $studentApplicationPreviousInfo = $this->application->getStudentPreviousInformation($studentApplicationStatus->registered_row_id);
            $boardInfo = $this->application->getBoardNameInfoById($studentApplicationAcademicInfo->sslc_board_name_id);
    
            $checkExists = $this->student->getStudentInfoBy_AppNo($application_number);

            if($type == 'Approve'){
                $applicationInfo = array(
                    'admission_status' => 1,
                    'comments'=>$comments,
                    'student_category' =>$student_category,
                    'section'=>$section,
                    'approved_by' => $this->staff_id,
                    'submitted_doc_status'=>1,
                    'approved_date' => date('Y-m-d'),
                    'updated_date_time' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->staff_id);

                    // $message = "Dear Parent/Guardian, \nYour daughter's/ward's Application No. $application_number is approved. Please click the link given below to pay the fees within TWO days from receipt of this sms failing which you might have to forgo the seat. Anyone having an issue kindly send an email to admissions@jnpuc.org\nLink - https://bit.ly/2VBVo9M\nBest Regards\nPrincipal \nJyoti Nivas Pre-University College.";
                    // $response = $this->sendSingleNumberSMS($number, $message);
        
                           if(empty($checkExists->students_appliction_number)){                   
                            $studentInfo = array(
                             'student_name' => $studentApplicationInfo->name,
                             'application_no' => $studentApplicationStatus->application_number ,
                             'student_id '=>$studentApplicationStatus->application_number ,
                            'last_board_name' => $boardInfo->board_name,
                             'term_name' => 'I PUC',
                             'program_name' => $studentApplicationAcademicInfo->program_name,
                             'stream_name' => $studentApplicationAcademicInfo->stream_name,
                             'language_one' => 'ENGLISH',
                             'language_two' => $studentApplicationAcademicInfo->second_language,
                             'elective_sub'=>$studentApplicationAcademicInfo->second_language,
                             'section_name'=>$section,
                             'is_active' => 1,
                             'is_admitted' => 1,
                             'admission_status'=>1,
                             'intake_year' => '2024-2025',
                             'intake_year_id' => '2024',
                             'native_place'=>$studentApplicationInfo->native_place,
                             'last_percentage'=>$studentApplicationStatus->sslc_percentage,
                             'mother_name' =>$studentApplicationInfo->mother_name,
                             'father_name'  =>$studentApplicationInfo->father_name,
                             'father_email' =>$studentApplicationInfo->father_email,
                             'mother_email'  =>$studentApplicationInfo->mother_email,
                             'father_educational_qualification' =>$studentApplicationInfo->father_qualification,
                             'mother_educational_qualification'  =>$studentApplicationInfo->mother_qualification,
                             'father_profession' =>$studentApplicationInfo->father_profession,
                             'mother_profession'  =>$studentApplicationInfo->mother_profession,
                             'gender'=> $studentApplicationInfo->gender,
                             'nationality'=> $studentApplicationInfo->nationality,
                             'religion'=> $studentApplicationInfo->religion,
                             'caste' => $studentApplicationInfo->caste,
                             'sub_caste' => $studentApplicationInfo->sub_caste,
                             'category' => $studentApplicationInfo->caste,
                             'aadhar_no'=> $studentApplicationInfo->aadhar_no,
                             'mobile'=>$studentApplicationInfo->student_mobile,
                             'email'=> $studentApplicationInfo->student_email,
                             'father_annual_income'=> $studentApplicationInfo->father_annual_income,
                             'mother_annual_income'=> $studentApplicationInfo->mother_annual_income,
                             'guardian_name'=> $studentApplicationInfo->guardian_name,
                             'guardian_mobile'=> $studentApplicationInfo->guardian_mobile,
                             'guardian_address'=> $studentApplicationInfo->guardian_address,
                             'dob'=> $studentApplicationInfo->dob,
                            'father_age' => $studentApplicationInfo->father_age,
                            'mother_age	'=> $studentApplicationInfo->mother_age,
                           'mother_tongue'=> $studentApplicationInfo->mother_tongue,
                           'mother_mobile'=> $studentApplicationInfo->mother_mobile,
                           'father_mobile'=> $studentApplicationInfo->father_mobile,
                           'blood_group'=> $studentApplicationInfo->blood_group,
                           'permanent_address'=>$studentApplicationInfo->permanent_address_line_1.' '.$studentApplicationInfo->permanent_address_line_2.' '.$studentApplicationInfo->permanent_address_district.' '.$studentApplicationInfo->permanent_address_state.' '.$studentApplicationInfo->permanent_address_pincode,
                           'present_address'=>$studentApplicationInfo->residential_address_line_1.' '.$studentApplicationInfo->residential_address_line_2.' '.$studentApplicationInfo->residential_address_district.' '.$studentApplicationInfo->residential_address_state.' '.$studentApplicationInfo->residential_address_pincode,
                            'residential_address'=>$studentApplicationInfo->permanent_address_line_1.' '.$studentApplicationInfo->permanent_address_line_2.' '.$studentApplicationInfo->permanent_address_district.' '.$studentApplicationInfo->permanent_address_state.' '.$studentApplicationInfo->permanent_address_pincode,
                            'is_dyslexic'=>$studentApplicationInfo->dyslexia_challenged,
                            'primary_mobile'=>$studentApplicationInfo->father_mobile,
                             'created_by' => $this->staff_id,
                             'created_date_time' => date('Y-m-d H:i:s'),
                             'updated_by' => $this->staff_id);
            
                     $resultstd = $this->application->addStudentInfo($studentInfo);
                 }
                }
                $result = $this->application->updateStudentApplicationStatus($application_number,$applicationInfo);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
    public function updateStudentAdmissionStatus(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   

        $comments = $this->input->post('comments');
        $application_number = $this->input->post('application_number');
        $registered_row_id = $this->input->post('registered_row_id');
        // if($isExist == 0){
            $applicationInfo = array(
                'admission_status' => 2,
                'comments'=>$comments,
                'rejected_by' => $this->staff_id,
                'submitted_doc_status'=>0,
                'rejected_date' => date('Y-m-d'),
                'updated_date_time' => date('Y-m-d H:i:s'),
                'updated_by' => $this->staff_id);
            // $applicationInfo = array(
            //     'comments'=>$comments,
            //     'admission_status' => 2,
            //     'shortlisted_status'=>0,
            //     'rejected_by' =>  $this->staff_id,
            //     'rejected_date' => date('Y-m-d H:i:s'));

            $result = $this->application->updateStudentApplicationStatus($application_number,$applicationInfo);

            if($result > 0){
                $this->session->set_flashdata('success', 'Application Number <b>'.$application_number.'</b> Rejected Successfully');
                $this->student->deleteAdmittedStudentInfo($application_number);
            }else{
                $this->session->set_flashdata('error', 'Failed to Reject Application Number <b>'.$application_number.'</b> ');
            }

            redirect('editSingleStudentApplications/'.$registered_row_id);
        } 
    }




  // approve reject admission
  public function sendSMSForNewAdm(){
    if($this->isAdmin() == TRUE){
        $this->loadThis();
    } else {   
        
        $stdMic = $this->application->getAllmicrosoftInfo();
        foreach($stdMic as $std){
            log_message('debug','wjd=='.$std->username);
            // $student = $this->application->getNewAdmittedStudentInfo($application_number);
            // if(!empty($student)){
            //     $number .= $student->father_mobile.','.$student->mother_mobile;
            // }
        }
      
        // log_message('debug','wjd'.print_r($student,true));
        
       
        $number = '9481611667';
        $message = "Dear Chandu,
        Please find your MS teams login credentials for I PUC online classes beginning tgrfff.
        ID : test45
        Password: test7
        Kindly Click on the below link for the video tutorial
        linkherer
        Thank you
        St. Joseph's Pre-University College HASSAN";
        $response = $this->sendSingleNumberSMS($number, $message);
        redirect('dashboard');
        // if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
    }
}

    function getStudentMarkSheet(){
        $medium = $this->input->post('medium');
        $board_name = $this->input->post('board_name');
        if($board_name == "KARNATAKA STATE BOARD"){
            if($medium == "KANNADA"){
                $this->load->view('student_sslc_subjects/state_board_karnataka_kannada');
            }else{
                $this->load->view('student_sslc_subjects/state_board_karnataka_english');
            }
        } else if($board_name == "CBSE"){
            $this->load->view('student_sslc_subjects/cbse_subjects');
        }else if($board_name == "ICSE"){
            $this->load->view('student_sslc_subjects/icse_board');
        }else if($board_name == "OTHER"){
            $this->load->view('student_sslc_subjects/other_board_subject');
        }
    }

    

    function getStreamNamesByProgram(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $program_name = $this->input->post('program_name');
            $data['stream_name'] = $this->application->getStreamNamesByProgram($program_name);
         ;
            header('Content-type: text/plain');
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }


    public function editSingleStudentApplications($resgisted_tbl_row_id = null){
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            // if($resgisted_tbl_row_id == null) {
            //     redirect('getAllApplicationInfo');
            // } 
            $filter = array();
            $filter['resgisted_tbl_row_id'] = $resgisted_tbl_row_id;
            $data['studentInfo'] = $this->application->getStudentApplicationInfo($resgisted_tbl_row_id);
            $data['parishPriestInfo'] = $this->application->getParishPriestInfo($resgisted_tbl_row_id);
            $data['documentInfo'] = $this->application->getDocumnetDetails($resgisted_tbl_row_id);
            $data['studentSchoolInfo'] = $this->application->getStudentSchoolInfo($resgisted_tbl_row_id);
            $data['studentMarkInfo'] = $this->application->getStudentMarkInfo($resgisted_tbl_row_id);
            $data['streamInfo'] = $this->application->getCombinationInfo($resgisted_tbl_row_id);
            $data['applicationInfo'] = $this->application->getStudentApplicationStatus($resgisted_tbl_row_id);
            $data['boardInfo'] = $this->application->getBoardNameById($resgisted_tbl_row_id);
            $data['allBoardsInfo'] = $this->application->getBoardName();
            // log_message('debug','scdjcn'.print_r($data['boardInfo'],true));
            $data['stateInfo'] = $this->application->getStateInfo();
            $data['nationalityInfo'] = $this->application->getNationality();
            $data['religionInfo'] = $this->application->getReligionInfo();
            $data['casteInfo'] = $this->application->getCasteInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Student Admission';
            $this->loadViews("application/edit_single_application", $this->global, $data, NULL);
        }
    }


    public function updateStudentPersonalData(){
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $registered_row_id = $this->security->xss_clean($this->input->post('registered_row_id'));
            $this->load->library('form_validation');
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('gender','Gender','required');
            // $this->form_validation->set_rules('mother_tongue','Mother Tongue','required');
            // $this->form_validation->set_rules('nationality','Nationality','required');
            // $this->form_validation->set_rules('religion','Select religion','required');
            // $this->form_validation->set_rules('caste','Select Caste Category','required');
            // $this->form_validation->set_rules('father_name','Father Name','trim|required|max_length[128]');
            // $this->form_validation->set_rules('mother_name','Moather Name','trim|required|max_length[128]');
            // $this->form_validation->set_rules('father_mobile','Father Mobile','required|numeric|min_length[10]');
            // $this->form_validation->set_rules('father_age','Father Age','required');
            // $this->form_validation->set_rules('mother_age','Mother Age','required');
            // $this->form_validation->set_rules('father_annual_income','Father Annual Income','trim|required');
            // $this->form_validation->set_rules('permanent_address_line_1','Permanent Address Line 1','trim|required');
            // $this->form_validation->set_rules('student_email','Student Email','required');
            // $this->form_validation->set_rules('place_of_birth','Place of Birth','trim|required');
            // $this->form_validation->set_rules('primary_contact','Prefered Mobile No. For SMS','trim|required');
            if($this->form_validation->run() == FALSE) {
                redirect('editSingleStudentApplications/'.$registered_row_id);
            } else {
                $fname = $this->security->xss_clean($this->input->post('fname'));
                $gender = $this->security->xss_clean($this->input->post('gender'));
            
                $native_place = $this->security->xss_clean($this->input->post('native_place'));
                $nationality = $this->security->xss_clean($this->input->post('nationality'));
                $religion = $this->security->xss_clean($this->input->post('religion'));
                $caste = $this->security->xss_clean($this->input->post('caste'));
                $sub_caste = $this->security->xss_clean($this->input->post('sub_caste'));
                $blood_group = $this->security->xss_clean($this->input->post('blood_group'));
                $mother_name = $this->security->xss_clean($this->input->post('mother_name'));
                $mother_qualification = $this->security->xss_clean($this->input->post('mother_qualification'));
                $mother_profession = $this->security->xss_clean($this->input->post('mother_profession'));
                $father_name = $this->security->xss_clean($this->input->post('father_name'));
                $father_qualification = $this->security->xss_clean($this->input->post('father_qualification'));
                $father_profession = $this->security->xss_clean($this->input->post('father_profession'));
                $guardian_name = $this->security->xss_clean($this->input->post('guardian_name'));
                $guardian_address = $this->security->xss_clean($this->input->post('guardian_address'));
                $aadhar_no = $this->security->xss_clean($this->input->post('aadhar_no'));
                $mother_tongue = $this->security->xss_clean($this->input->post('mother_tongue'));
                $mother_mobile = $this->security->xss_clean($this->input->post('mother_mobile'));
                $father_mobile = $this->security->xss_clean($this->input->post('father_mobile'));
                $mother_email = $this->security->xss_clean($this->input->post('mother_email'));
                $father_email = $this->security->xss_clean($this->input->post('father_email'));
                $father_age = $this->security->xss_clean($this->input->post('father_age'));
                $mother_age = $this->security->xss_clean($this->input->post('mother_age'));
                $guardian_mobile = $this->security->xss_clean($this->input->post('guardian_mobile'));
                $guardian_mobile = $this->security->xss_clean($this->input->post('guardian_mobile'));
                $student_mobile = $this->security->xss_clean($this->input->post('student_mobile'));
                $father_annual_income = $this->security->xss_clean($this->input->post('father_annual_income'));
                $mother_annual_income = $this->security->xss_clean($this->input->post('mother_annual_income'));
                $other_nationality = $this->security->xss_clean($this->input->post('other_nationality'));
                $other_religion_text = $this->security->xss_clean($this->input->post('other_religion_text'));
                $other_caste_text = $this->security->xss_clean($this->input->post('other_caste_text'));
                $dob = $this->security->xss_clean($this->input->post('dob'));
                $date_of_birth = date("Y-m-d", strtotime($dob));
                
                $student_email = $this->security->xss_clean($this->input->post('student_email'));
                $permanent_address_line_1 = $this->security->xss_clean($this->input->post('permanent_address_line_1'));
                $permanent_address_line_2 = $this->security->xss_clean($this->input->post('permanent_address_line_2'));
                $permanent_address_district = $this->security->xss_clean($this->input->post('permanent_address_district'));
                $permanent_address_state = $this->security->xss_clean($this->input->post('permanent_address_state'));
                $permanent_address_pincode = $this->security->xss_clean($this->input->post('permanent_address_pincode'));
                $residence_address_line_1 = $this->security->xss_clean($this->input->post('residence_address_line_1'));
                $residence_address_line_2 = $this->security->xss_clean($this->input->post('residence_address_line_2'));
                $residence_address_district = $this->security->xss_clean($this->input->post('residence_address_district'));
                $residence_address_state = $this->security->xss_clean($this->input->post('residence_address_state'));
                $residence_address_pincode = $this->security->xss_clean($this->input->post('residence_address_pincode'));
                $residence_address_taluk = $this->security->xss_clean($this->input->post('residence_address_taluk'));
                $permanent_address_taluk = $this->security->xss_clean($this->input->post('permanent_address_taluk'));
                $priest_name = $this->security->xss_clean($this->input->post('priest_name'));
                $priest_mobile = $this->security->xss_clean($this->input->post('priest_mobile'));
                
                $pastor_name = $this->security->xss_clean($this->input->post('pastor_name'));
                $pastor_mobile = $this->security->xss_clean($this->input->post('pastor_mobile'));

                $dyslexia_challenged = $this->security->xss_clean($this->input->post('dyslexia_challenged'));
                $physically_challenged = $this->security->xss_clean($this->input->post('physically_challenged'));
                $hostel_facility = $this->security->xss_clean($this->input->post('hostel_facility'));
                $bus_facility = $this->security->xss_clean($this->input->post('bus_facility'));
                $boarding_point = $this->security->xss_clean($this->input->post('boarding_point'));
                
                $caste_no = $this->security->xss_clean($this->input->post('caste_no'));
                $income_no = $this->security->xss_clean($this->input->post('income_no'));
                $guardian_relation = $this->security->xss_clean($this->input->post('guardian_relation'));
    
                $native_taluk = $this->security->xss_clean($this->input->post('native_taluk'));
                $native_state = $this->security->xss_clean($this->input->post('native_state'));
                $native_district = $this->security->xss_clean($this->input->post('native_district'));
                $monthly_income = $this->security->xss_clean($this->input->post('monthly_income'));
                
                // $documentName = $this->security->xss_clean($this->input->post('documentName'));

                // $uploadPath = 'upload/document/'.$this->student_row_id.'/';
                // if (!file_exists($uploadPath)) {
                //     mkdir($uploadPath, 0777, true);
                // }

                // $doc_name = 'priest_certificate';
                // $parish_config=['upload_path' => $uploadPath, 'file_name' => $doc_name,
                // 'allowed_types' => 'pdf|doc|docx|jpg|png|jpeg','max_size' => '1024','overwrite' => TRUE, ];
                // $image_file="";
                // $this->load->library('upload', $parish_config);
                // if($this->upload->do_upload('pastor_file')) {
                //     $post=$this->input->post();
                //     $data=$this->upload->data();
                //     $image_file = $uploadPath.$data['raw_name'].$data['file_ext'];
                // }

                
                // $priest_config=['upload_path' => $uploadPath, 'file_name' => $doc_name,
                // 'allowed_types' => 'pdf|doc|docx|jpg|png|jpeg','max_size' => '1024','overwrite' => TRUE, ];
                // $this->load->library('upload', $priest_config);
                // if($this->upload->do_upload('priest_file')) {
                //     $priest_config['file_name'] = $doc_name; 
                //     $post=$this->input->post();
                //     $data=$this->upload->data();
                //     $image_path = $uploadPath.$data['raw_name'].$data['file_ext'];
                // }

                // $config=['upload_path' => $uploadPath,
                // 'allowed_types' => 'jpg|png|jpeg','max_size' => '1024','overwrite' => TRUE, ];
                // $this->load->library('upload', $config);
                // $files = $_FILES;
                // $ImgCount = count($_FILES['userfile']['name']);
                // for($i = 0; $i < $ImgCount; $i++){
                //     if(!empty($_FILES['userfile']['name'][$i])){
                //         $config['file_name'] = $documentName[$i]; 
                //         $_FILES['file']['name']       = $files['userfile']['name'][$i];
                //         $_FILES['file']['type']       = $files['userfile']['type'][$i];
                //         $_FILES['file']['tmp_name']   = $files['userfile']['tmp_name'][$i];
                //         $_FILES['file']['error']      = $files['userfile']['error'][$i];
                //         $_FILES['file']['size']       = $files['userfile']['size'][$i];
                //         $this->upload->initialize($config);
                //         if($this->upload->do_upload('file')){
                //             $imageData = $this->upload->data();
                //             $uploadImgData[$i] = $uploadPath.$imageData['file_name'];
                //         }

                //     }
                // }

          


                if($nationality == "OTHER"){
                    $nationality = $other_nationality;
                }else{
                    $nationality = $nationality;
                }
                if($religion == "OTHER"){
                    $religion = $other_religion_text;
                }else{
                    $religion = $religion;
                }
                if($caste == "OTHER"){
                    $caste = $other_caste_text;
                }else{
                    $caste = $caste;
                }
                $studentPersonalInfo = array(
                    'name'=> $fname,
                    'dob'=> $date_of_birth,
                    'gender'=> $gender,
                    'native_place'=> $native_place, 
                    'nationality'=> $nationality,
                    'religion'=> $religion,
                    'caste'=> $caste,
                    'sub_caste'=> $sub_caste,
                    'mother_name'=> $mother_name,
                    'mother_qualification'=> $mother_qualification,
                    'mother_profession'=> $mother_profession,
                    'father_name'=> $father_name,
                    'father_qualification'=>$father_qualification, 
                    'father_profession'=> $father_profession,
                    'guardian_name'=> $guardian_name, 
                    'guardian_address'=> $guardian_address,
                    'aadhar_no'=> $aadhar_no,
                    'mother_tongue'=> $mother_tongue,
                    'mother_mobile'=> $mother_mobile,
                    'father_mobile'=> $father_mobile,
                    'blood_group'=> $blood_group,
                    'mother_email'=> $mother_email,
                    'father_email'=> $father_email,
                    'father_age'=> $father_age,
                    'mother_age'=> $mother_age,
                    'father_annual_income' => $father_annual_income,
                    'mother_annual_income' => $mother_annual_income,
                    'guardian_mobile'=> $guardian_mobile, 
                    'student_mobile'=> $student_mobile,
                    'student_email'=> $student_email,
                    'permanent_address_line_1'=> $permanent_address_line_1,
                    'permanent_address_line_2'=> $permanent_address_line_2,
                    'permanent_address_district'=> $permanent_address_district,
                    'permanent_address_state'=> $permanent_address_state,
                    'permanent_address_pincode'=> $permanent_address_pincode,
                    'residential_address_line_1'=> $residence_address_line_1, 
                    'residential_address_line_2'=> $residence_address_line_2, 
                    'residential_address_district'=> $residence_address_district, 
                    'residential_address_state'=> $residence_address_state, 
                    'residential_address_pincode'=> $residence_address_pincode, 
                    'physically_challenged'=> $physically_challenged,
                    'dyslexia_challenged'=> $dyslexia_challenged, 
                    'caste_no'=> $caste_no, 
                    'income_no'=> $income_no, 
                    'monthly_income'=> $monthly_income, 
                    'residence_address_taluk' => $residence_address_taluk,
                    'permanent_address_taluk' => $permanent_address_taluk,
                    'guardian_relation' => $guardian_relation,
                    'bus_facility' => $bus_facility,
                    'hostel_facility' => $hostel_facility,
                    'boarding_point' => $boarding_point,
                    'updated_by'=> $this->staff_id,
                    'updated_dtm'=>date('Y-m-d H:i:s'));

                $studentPersonalInfo = array_map('strtoupper', $studentPersonalInfo);
                $retun_id = $this->application->updateStudentPersonalInfo($registered_row_id,$studentPersonalInfo); 

                if($retun_id > 0){
                    if(!empty($priest_name)){ 
                        $priestCertificateInfo = array(
                            'priest_name' => $priest_name,
                            'mobile_number' => $priest_mobile,
                            'updated_by'=> $this->staff_id,
                            'updated_date_time'=>date('Y-m-d H:i:s'));

                        // if(!empty($image_path)){
                        //     $priestCertificateInfo['certificate_path'] = $image_path;
                        // }
                        $retun_one = $this->application->updatePriestCertificate($registered_row_id,$priestCertificateInfo); 
                        
                    }

                    if(!empty($pastor_name)){ 
                        $pastorCertificateInfo = array(
                            'priest_name' => $pastor_name,
                            'mobile_number' => $pastor_mobile,
                            'updated_by'=> $this->staff_id,
                            'updated_date_time'=>date('Y-m-d H:i:s'));
                            
                        // if(!empty($image_file)){
                        //     $pastorCertificateInfo['certificate_path'] = $image_file;
                        // }
                        $retun = $this->application->updatePriestCertificate($registered_row_id,$pastorCertificateInfo); 
                    
                    }

                }


                if($retun_id > 0){
                    $this->session->set_flashdata('success', 'Personal Details Updated Successfully');
                }else{
                    $this->session->set_flashdata('error', 'Failed to Update Personal Details');
                }
                redirect('editSingleStudentApplications/'.$registered_row_id);
            }
        }
    }

    public function updateSchoolData(){
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $registered_row_id = $this->security->xss_clean($this->input->post('registered_row_id'));
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name_of_the_school','Name of The School','trim|required|max_length[128]');
            $this->form_validation->set_rules('medium','Medium of Instruction','trim|required');
            $this->form_validation->set_rules('school_address','School Address','trim|required|max_length[2000]');
            $this->form_validation->set_rules('year_of_passed','Passing Year','required');
            if($this->form_validation->run() == FALSE) {
                redirect('editSingleStudentApplications/'.$registered_row_id);
            } else {
                $other_board_name="";
                $mark_row_id = "";
                $name_of_the_school = $this->security->xss_clean($this->input->post('name_of_the_school'));
                $medium = $this->security->xss_clean($this->input->post('medium'));
                $school_address = $this->security->xss_clean($this->input->post('school_address'));
                $year_of_passed = $this->security->xss_clean($this->input->post('year_of_passed'));
                $sslc_board_name = $this->security->xss_clean($this->input->post('sslc_board_name'));
                $other_medium_instruction = $this->security->xss_clean($this->input->post('other_medium_instruction'));
                $other_board_name = $this->security->xss_clean($this->input->post('other_board_name'));
                $doc_name = $this->security->xss_clean($this->input->post('doc_name'));
                $month_of_passed = $this->security->xss_clean($this->input->post('month_of_passed'));
                $no_of_attempt = $this->security->xss_clean($this->input->post('no_of_attempt'));
                $register_number = $this->security->xss_clean($this->input->post('register_number'));
                $boardInfo = $this->application->getBoardNameById($registered_row_id);
                $board_name = $this->application->getBoardNameByName($sslc_board_name);

                $boardName_row_id = $board_name->row_id;
            
                $subject_name = $this->input->post('subject_name');
                $subject_max_mark = $this->input->post('subject_max_mark');
                $subject_obtained = $this->input->post('subject_obtained');
                $course_row_id = $this->input->post('course_row_id');
                
                if($medium == "OTHER"){
                    $medium_instruction = $other_medium_instruction;
                }else{
                    $medium_instruction = $medium;
                }

                
                $subject_name = $this->input->post('subject_name');
                $subject_max_mark = $this->input->post('subject_max_mark');
                $subject_obtained = $this->input->post('subject_obtained');
                $obt_mark_9_std = $this->input->post('obt_mark_9_std');
                $course_row_id = $this->input->post('course_row_id');
            
                
                $schoolInfo = array(
                    'name_of_the_school' => $name_of_the_school,
                    'medium_instruction' => $medium_instruction,
                    'school_address' => $school_address,
                    'year_of_passed' => $year_of_passed,
                    'other_state_board_name'=>$other_board_name,
                    'month_of_passed'=>$month_of_passed,
                    'sslc_board_name_id'=>$board_name->row_id,
                    'register_number'=>$register_number,
                    'no_of_attempt'=>$no_of_attempt,
                    'updated_by' => $this->staff_id,
                    'updated_date_time' => date('Y-m-d H:i:s'));
                $schoolInfo = array_map('strtoupper', $schoolInfo);
            
                $Other_board = array(
                    'other_board_name' => $other_board_name,
                     'sslc_board_name_id' => $boardName_row_id); 

                     $this->application->updateBoardInfo($registered_row_id,$Other_board);
                $retun_id = $this->application->updateStudentSchoolInfo($registered_row_id,$schoolInfo);

                if($retun_id > 0){

                    if($boardInfo->board_name == "CBSE"){
                        for($i=0; $i<5;$i++){
                            if(!empty($subject_name[$i])){
                                $markInfo = array(
                                'subject_name'=> $subject_name[$i],
                                'max_mark'=> $subject_max_mark[$i],
                                'obtnd_mark'=> $subject_obtained[$i],
                                'registred_row_id'=>$registered_row_id,
                                'updated_by'=>$this->staff_id,
                                'updated_date_time'=>date('Y-m-d H:i:s'));
                                $markInfo = array_map('strtoupper', $markInfo);
                                if(!empty($course_row_id[$i])){
                                    $course_row_id[$i] = $course_row_id[$i];
                                }else{
                                    $course_row_id[$i] = 0;
                                }
                                $markExist = $this->application->checkSSLCMarkExists($registered_row_id,$course_row_id[$i]);
                                if($markExist > 0){
                                    unset($markInfo['created_date']);
                                    unset($markInfo['created_by']);
                                $mark_id = $this->application->updateSSLC_MarkInfo($markInfo,$registered_row_id,$course_row_id[$i]);
                            }else{ 
                                $mark_id = $this->application->saveStudentSSLC_MarkInfo($markInfo);
                            }
                            }
                        }
                    }else if($boardInfo->board_name == "ICSE"){
                        for($i=0; $i<5;$i++){
                            if(!empty($subject_name[$i])){
                                // log_message('debug','obtained='.$subject_name[$i]);
                                // log_message('debug','max='.$subject_max_mark[$i]);
                                // log_message('debug','nn='.$subject_obtained[$i]);
                                $markInfo = array(
                                'subject_name'=> $subject_name[$i],
                                'max_mark'=> $subject_max_mark[$i],
                                'obtnd_mark'=> $subject_obtained[$i],
                                'registred_row_id'=>$registered_row_id,
                                'updated_by'=>$this->staff_id,
                                'updated_date_time'=>date('Y-m-d H:i:s'));
                                $markInfo = array_map('strtoupper', $markInfo);
                                if(!empty($course_row_id[$i])){
                                    $course_row_id[$i] = $course_row_id[$i];
                                }else{
                                    $course_row_id[$i] = 0;
                                }
                                $markExist = $this->application->checkSSLCMarkExists($registered_row_id,$course_row_id[$i]);
                                if($markExist > 0){
                                    //log_message('debug','exiusat');
                                    unset($markInfo['created_date']);
                                    unset($markInfo['created_by']);
                                $mark_id = $this->application->updateSSLC_MarkInfo($markInfo,$registered_row_id,$course_row_id[$i]);
                            }else{ 
                               // log_message('debug','saveee');
                                $mark_id = $this->application->saveStudentSSLC_MarkInfo($markInfo);
                            }                                
                            }
                        }
                    }else{
                        for($i=0; $i<6;$i++){
                           if(!empty($subject_name[$i])){
                            $markInfo = array(
                                'subject_name'=> $subject_name[$i],
                                'max_mark'=> $subject_max_mark[$i],
                                'obtnd_mark'=> $subject_obtained[$i],
                                'registred_row_id'=>$registered_row_id,
                                'updated_by'=>$this->staff_id,
                                'updated_date_time'=>date('Y-m-d H:i:s'));
                                $markInfo = array_map('strtoupper', $markInfo);
                                if(!empty($course_row_id[$i])){
                                    $course_row_id[$i] = $course_row_id[$i];
                                }else{
                                    $course_row_id[$i] = 0;
                                }
                                $markExist = $this->application->checkSSLCMarkExists($registered_row_id,$course_row_id[$i]);
                                if($markExist > 0){
                                    unset($markInfo['created_date']);
                                    unset($markInfo['created_by']);
                                $mark_id = $this->application->updateSSLC_MarkInfo($markInfo,$registered_row_id,$course_row_id[$i]);
                            }else{ 
                                $mark_id = $this->application->saveStudentSSLC_MarkInfo($markInfo);
                            }                                
                           }
                        }
                    }

                    $studentMarkInfo = $this->application->getStudentMarkInfo($registered_row_id);
                    $total_max_mark = 0;
                    $total_mark = 0;
                    $total_ninth_mark = 0;
                    $totalPercentage = 0; 
                    if($boardInfo->board_name == "CBSE"){
                        foreach($studentMarkInfo as $mark){
                            $total_max_mark += $mark->max_mark;  
                            $total_mark += $mark->obtnd_mark;
                            $total_ninth_mark += $mark->mark_obt_9_std;
                            $totalPercentage = ($total_mark / $total_max_mark) * 100;
                            $totalNinthPercentage = ($total_ninth_mark / $total_max_mark) * 100;
                        }
                    } else if($boardInfo->board_name == "ICSE"){
                        $markInfo = array_slice($studentMarkInfo, 0, 5, true);
                        foreach($markInfo as $mark){
                            $total_max_mark += $mark->max_mark;  
                            $total_mark += $mark->obtnd_mark;
                            $total_ninth_mark += $mark->mark_obt_9_std;
                            $totalPercentage = ($total_mark / $total_max_mark) * 100;
                            $totalNinthPercentage = ($total_ninth_mark / $total_max_mark) * 100;
                        }
                    } else {
                        foreach($studentMarkInfo as $mark){
                            if($mark->subject_name == 'EXEMPTED'){
                                $max_mark = 0;  
                            }else{
                                $max_mark = $mark->max_mark;  
                            }
                            $total_mark += $mark->obtnd_mark;
                            $total_ninth_mark += $mark->mark_obt_9_std;
                            $total_max_mark += $max_mark;  
                            $totalPercentage = ($total_mark / $total_max_mark) * 100;
                            $totalNinthPercentage = ($total_ninth_mark / $total_max_mark) * 100;
                        }
                    }
                    $total_percentage = round($totalPercentage,2);
                    $total_ninth_percentage = round($totalNinthPercentage,2);
                    $studentPersonalInfo = array(
                        'sslc_percentage' => $total_percentage,
                        'ninth_percentage' => $total_ninth_percentage,
                        'updated_by' => $this->staff_id,
                        'updated_dtm' => date('Y-m-d H:i:s'));
                        
                    $this->application->updateStudentPersonalInfo($registered_row_id,$studentPersonalInfo); 
        
                    $applicationStatus = array(
                        'sslc_percentage' => $total_percentage,
                        'ninth_percentage' => $total_ninth_percentage,
                        'updated_by' => $this->staff_id,
                        'updated_date_time' => date('Y-m-d H:i:s'));
                        
                    $this->application->updatedApplicationStatusByID($registered_row_id,$applicationStatus); 


                    $this->session->set_flashdata('success', 'Updated Student School Details');
                }else{
                    $this->session->set_flashdata('error', 'Failed to Update School Details');
                }
                redirect('editSingleStudentApplications/'.$registered_row_id);
            }
        }
    }
    
    public function updateStudentCombination(){
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $registered_row_id = $this->security->xss_clean($this->input->post('registered_row_id'));
            $this->load->library('form_validation');
           
            $this->form_validation->set_rules('language_second','Elective Language','trim|required');
            $this->form_validation->set_rules('program_name','First Preference Program Name','trim|required');
            $this->form_validation->set_rules('stream_name','First Preference Stream Name','required');
            // $this->form_validation->set_rules('national_level_sports_status','National Level Sports','required');
            // $this->form_validation->set_rules('ncc_certificate_status','NCC Parade','required');
            if($this->form_validation->run() == FALSE) {
                redirect('editSingleStudentApplications/'.$registered_row_id);
            } else {
                $language_second = $this->security->xss_clean($this->input->post('language_second'));
                $program_name = $this->security->xss_clean($this->input->post('program_name'));
                $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
                $national_level_sports_status = $this->security->xss_clean($this->input->post('national_level_sports_status'));
                $ncc_certificate_status = $this->security->xss_clean($this->input->post('ncc_certificate_status'));
                $second_program_name = $this->security->xss_clean($this->input->post('second_program_name'));
                $second_stream_name = $this->security->xss_clean($this->input->post('second_stream_name'));
                $integrated_batch = $this->security->xss_clean($this->input->post('integrated_batch'));


                $ncc_activity = $this->security->xss_clean($this->input->post('ncc_activity'));
                $sports_activity = $this->security->xss_clean($this->input->post('sports_activity'));
                $intergrated_coaching = $this->security->xss_clean($this->input->post('intergrated_coaching'));
                $weakend_coaching = $this->security->xss_clean($this->input->post('weakend_coaching'));
                $cpat = $this->security->xss_clean($this->input->post('cpat'));
                $csat = $this->security->xss_clean($this->input->post('csat'));
                $music = $this->security->xss_clean($this->input->post('music'));
                $extra_curricular_activity = $this->security->xss_clean($this->input->post('extra_curricular_activity'));
                
                $combinationInfo = array(
                    'second_language'=> $language_second,
                    'program_name'=> $program_name, 
                    'stream_name'=> $stream_name,
                    'second_stream_name'=> $second_stream_name,
                    'second_program_name'=> $second_program_name,
                    'integrated_batch'   =>$integrated_batch,
                    // 'national_level_sports_status'=> $national_level_sports_status,
                    // 'ncc_certificate_status'=> $ncc_certificate_status,
                    'updated_by'=> $this->staff_id,
                    'updated_date_time'=>date('Y-m-d H:i:s'));
                    $combinationInfo = array_map('strtoupper', $combinationInfo);
                    $retun_id = $this->application->updateStudentCombinationData($registered_row_id,$combinationInfo); 

              

                if($retun_id > 0){
                    $this->session->set_flashdata('success', 'Updated Student Language & Combination Details');
                }else{
                    $this->session->set_flashdata('error', 'Failed to Update Language & Combination Details');
                }
                redirect('editSingleStudentApplications/'.$registered_row_id);
            }
        }
    }

    
    public function updateStudentAdmissionDocument(){
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $registered_row_id = $this->security->xss_clean($this->input->post('registered_row_id'));
            $this->load->library('form_validation');
            // log_message('debug','id'.$registered_row_id);
            $this->form_validation->set_rules('doc_name','Document Name','trim|required');
            if($this->form_validation->run() == FALSE) {
                redirect('editSingleStudentApplications/'.$registered_row_id);
            } else {
                $doc_name = $this->security->xss_clean($this->input->post('doc_name'));
                $image_path="";
                $uploadPath = 'upload/document/'.$registered_row_id.'/';
                $config=['upload_path' => ADMISSION_FILE_PATH.$uploadPath,
                'allowed_types' => 'jpg|png|jpeg','upload_max_filesize' => '100','overwrite' => TRUE,
                'file_ext_tolower' => TRUE,'file_name' => $doc_name]; 
                $this->load->library('upload', $config);
                if($this->upload->do_upload())
                {
                    $data=$this->upload->data();
                
                    if($data['file_size'] > $config['upload_max_filesize']){
                        $this->session->set_flashdata('error', 'File Size is greater than 100KB'); 
                        redirect('editSingleStudentApplications/'.$registered_row_id);
                    }else{ 
                        $image_path = $uploadPath.$data['raw_name'].$data['file_ext'];
                        $post['image_path'] = $image_path;
                    }
        
                }

                $certificateInfo = array(
                    'doc_name' => $doc_name,
                    'doc_path'=> $image_path, 
                    'updated_by' => $this->staff_id, 
                    'updated_date_time' => date('Y-m-d H:i:s'));

                $result = $this->application->updateStudentAdmissionDocument($registered_row_id,$certificateInfo,$doc_name); 
                // log_message('debug','info'.print_r($certificateInfo,true));
                if($result > 0){
                    $this->session->set_flashdata('success', 'Updated Student Document');
                }else{
                    $this->session->set_flashdata('error', 'Failed to Update Document');
                }
                redirect('editSingleStudentApplications/'.$registered_row_id);
            }
        }
    }

    
    public function updatedInterviewCompletedStudents(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $students_appliction_number = json_decode(stripslashes($this->input->post('students_appliction_number')));
            //$shortlist_number = $this->security->xss_clean($this->input->post('shortlist_number'));


            foreach($students_appliction_number as $app_no){           
                $admissionStatus = array(
                    'interview_status'=>1,
                    // 'shortlisted_list_number'=>$shortlist_number,
                    'updated_by' =>$this->staff_id,
                    'updated_date_time'=>date('Y-m-d H:i:s'));

                    // $shortlistInfo = array(
                    //     'shortlisted_list_number'=>$shortlist_number,
                    // );
                $return_id = $this->application->updatedStudentApplicationStatus($admissionStatus,$app_no);
                // if(!empty($shortlist_number)){
                //  $this->application->updatedStudentApplicationStatus($shortlistInfo,$app_no);
                // }
            }
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($return_id);
            exit(0); 
        }
    }


    public function viewPrintApplication($register_row_id = null) {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {  
            if($register_row_id == null) {
                redirect('getAllApplicationInfo');
            } 
            $filter = array();
            $filter['register_row_id'] = $register_row_id;
           // $data['appInfo'] = $this->application->getStudentInfoById($register_row_id);

            //$data['sslcRegisterNumber'] = $appInfo->registration_number;
         
            $student = $this->application->getStudentApplicationInfo($register_row_id);
            $data['studentSchoolInfo'] = $this->application->getStudentSchoolInfo($register_row_id);
            $data['studentMarkInfo'] = $this->application->getStudentMarkInfo($register_row_id);
            $data['studentAdmissionInfo'] = $this->application->getAdmissionInfo($register_row_id);
            $data['studentInfo'] = $this->application->getStudentRegisteredInfo($register_row_id);
            $data['boardInfo'] = $this->application->getBoardNameById($register_row_id);
            $data['documentInfo'] = $this->application->getDocumnetDetails($register_row_id);
            $data['photoInfo'] = $this->application->getStudentImage($register_row_id);
            $data['studentApplicationInfo'] = $student; 
            $this->global['pageTitle']= ''.TAB_TITLE.'  : Application Form';
            $this->loadViews("application/printApplication", $this->global, $data, NULL);
        }
    }
    


    public function admissionReportDashboard(){
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            if($this->role == ROLE_TEACHING_STAFF ){
                $filter['staff_id'] = $this->staff_id;
                $data['subjectInfo'] = $this->staff->getAllSubjectInfo($filter);
            }else{
                $data['subjectInfo'] = $this->subject->getAllSubjectInfo();
            }
            $data['streamInfo'] = $this->application->getStreamInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Admission Report';
            $this->loadViews("application/reportDashboard", $this->global, $data, NULL);
        }
    }


    // admission quick view
    public function admissionDashboard(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $streamApprovedCount = array();
            $streamCompletedCount = array();
            $streamRejectedCount = array();
            $electiveAdmittedCount = array();
            $streamInfo = $this->application->getStreamNames();
            $admission_year = $this->security->xss_clean($this->input->post('admission_year'));

            
            $data['admission_year'] = $admission_year;


            if($admission_year == '') {
                $admission_year_filter = 2024;

            }else {
                $admission_year_filter  = $admission_year;

            }
            $data['registeredCount'] = $this->application->getAdmissionRegisteredStudentCount($admission_year_filter);
            $data['appliedCount'] = $this->application->getAdmissionAppliedCount($admission_year_filter);
            $data['approvedCount'] = $this->application->getAdmissionApprovedCount($admission_year_filter);
            $data['rejectedCount'] = $this->application->getAdmissionRejectedCount($admission_year_filter);
            $data['completedCount'] = $this->application->getAdmissionCompletedCount($admission_year_filter);
            $data['shortlistedCount'] = $this->application->getShortlistedCount($admission_year_filter);
            $data['interviewCount'] = $this->application->getInterviewedStudentsCount($admission_year_filter);
            $categoryArray=array(
                "ROMAN CATHOLIC",
                "OTHER CHRISTIANS",
                "SC",
                "ST",
                "CAT-I",
                "2A",
                "2B",
                "3A",
                "3B",
                "GENERAL MERIT(GM)",
            );
            $electiveSubject = array("KANNADA","HINDI","FRENCH");
            $categoryStreamCount = array();
            for($i=0;$i<count($streamInfo);$i++){
                $stream = $streamInfo[$i]->stream_name;
                $streamApprovedCount[$i] = $this->application->getStreamApprovedCount($stream,$admission_year_filter);
                $streamCompletedCount[$i] = $this->application->getStreamCompletedCount($stream,$admission_year_filter);
                $streamRejectedCount[$i] = $this->application->getStreamRejectedCount($stream,$admission_year_filter);
                $streamRecord[$i] = $streamInfo[$i]->stream_name;
                for($c=0;$c<count($categoryArray);$c++){
                    $category = $categoryArray[$c];
                    $categoryStreamCount[$stream][$category] = $this->application->categoryAdmissionCount($stream,$categoryArray[$c],$admission_year_filter);
                }

                for($j=0;$j<count($electiveSubject);$j++){
                    $elective_sub = $electiveSubject[$j];
                    $electiveAdmittedCount[$stream][$elective_sub] = $this->application->getElectiveLanguageAdmittedCount($stream,$electiveSubject[$j],$admission_year_filter);
                }
            }

           


            $data['electiveAdmittedCount'] = $electiveAdmittedCount;
            $data['electiveSubject'] = $electiveSubject;
            $data['categoryStreamCount'] = $categoryStreamCount;
            $data['categoryArray'] = $categoryArray;
            $data['streamInfo'] = $streamRecord;
            $data['streamApprovedCount'] = $streamApprovedCount;
            $data['streamCompletedCount'] = $streamCompletedCount;
            $data['streamRejectedCount'] = $streamRejectedCount;

            $this->global['pageTitle'] = ''.TAB_TITLE.' : Admission Quick View';
            $this->loadViews("application/admissionQuickView", $this->global, $data, null);
        }
    }

    
    public function getStudentInfoByApplicationNumber(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $application_number = $this->security->xss_clean($this->input->post('application_number'));
            $admission_year = $this->security->xss_clean($this->input->post('admission_year'));  
            $data['studentInfo'] = $this->application->getStudentByApplicationNo($application_number,$admission_year);
            $data['stdPhoto'] = $this->application->getStudentPhotoByApplicationNo($data['studentInfo']->resgisted_tbl_row_id);
            $fee_info = $this->fee->getStdLastPaidDetailsByApplicationNo($application_number,CURRENT_YEAR); 
            $data['fee_payment_status'] = 0;
            if(!empty($fee_info)){
                if($fee_info->pending_balance <= 0){
                    $data['fee_payment_status'] = 1;
                }
            }
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }

    public function deleteApplication(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $reg_row_id = $this->input->post('reg_no');
            $appInfo = array('is_deleted' => 1);
            $result = $this->application->deleteStudentApplicationInfo($reg_row_id, $appInfo);
            $result = $this->application->deleteStudentRegistrationInfo($reg_row_id, $appInfo);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
    
    public function applicationPaymentComplete(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $reg_row_id = $this->input->post('row_id');
            $appInfo = array('application_fee_status' => 1);
            $result = $this->application->deleteStudentApplicationInfo($reg_row_id, $appInfo);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    

    public function updateShortListedStudents(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $students_appliction_number = json_decode(stripslashes($this->input->post('students_appliction_number')));


            // $online_interview_date = $this->input->post('online_interview_date');
            // $interview_link = $this->input->post('interview_link');
            // $any_comments = $this->input->post('any_comments');
            // $shortlist_number = $this->input->post('shortlist_number');

            $studentApplicationStatus = $this->application->getStudentApplicationStatusByAppNo($students_appliction_number);
            $studentApplicationInfo = $this->application->getStudentApplicationInfoByID($studentApplicationStatus->registered_row_id);
            $studentApplicationAcademicInfo = $this->application->getStudentAcademicInformation($studentApplicationStatus->registered_row_id);
            $studentApplicationPreviousInfo = $this->application->getStudentPreviousInformation($studentApplicationStatus->registered_row_id);
            $boardInfo = $this->application->getBoardNameInfoById($studentApplicationAcademicInfo->sslc_board_name_id);
    
            $checkExists = $this->student->getStudentInfoBy_AppNo($students_appliction_number);
    
            foreach($students_appliction_number as $app_no){           
                $admissionStatus = array(
                    'shortlisted_by'=> $this->name,
                    'approved_date' => date('Y-m-d'),
                    'shortlisted_status'=>1,
                    'updated_by' =>$this->staff_id,
                    'shortlisted_list_number' => $shortlist_number,
                    'updated_date_time'=>date('Y-m-d H:i:s'),

                   );


                   if(empty($checkExists->students_appliction_number)){                   
                    $studentInfo = array(
                     'student_name' => $studentApplicationInfo->name,
                     'application_no' => $studentApplicationStatus->application_number ,
                     'student_id '=>$studentApplicationStatus->application_number ,
                    'last_board_name' => $boardInfo->board_name,
                     'term_name' => $studentApplicationAcademicInfo->program_name,
                     'stream_name' => $studentApplicationAcademicInfo->stream_name,
                     'is_active' => 1,
                     'is_admitted' => 1,
                     'admission_status'=>1,
                     'intake_year' => '2024-2025',
                     'native_place'=>$studentApplicationInfo->native_place,
                     'last_percentage'=>$studentApplicationInfo->sslc_percentage,
                     'mother_name' =>$studentApplicationInfo->mother_name,
                     'father_name'  =>$studentApplicationInfo->father_name,
                     'father_profession' =>$studentApplicationInfo->father_profession,
                     'mother_profession'  =>$studentApplicationInfo->mother_profession,
                     'gender'=> $studentApplicationInfo->gender,
                     'nationality'=> $studentApplicationInfo->nationality,
                     'religion'=> $studentApplicationInfo->religion,
                     'caste' => $studentApplicationInfo->caste,
                     'sub_caste' => $studentApplicationInfo->sub_caste,
                     'category' => $studentApplicationInfo->caste,
                     'aadhar_no'=> $studentApplicationInfo->aadhar_no,
                     'mobile'=>$studentApplicationInfo->student_mobile,
                     'email'=> $studentApplicationInfo->student_email,
                     'father_annual_income'=> $studentApplicationInfo->father_annual_income,
                     'mother_annual_income'=> $studentApplicationInfo->mother_annual_income,
                     'guardian_name'=> $studentApplicationInfo->guardian_name,
                     'guardian_mobile'=> $studentApplicationInfo->guardian_mobile,
                     'guardian_address'=> $studentApplicationInfo->guardian_address,
                     'dob'=> $studentApplicationInfo->dob,
                    'father_age' => $studentApplicationInfo->father_age,
                    'mother_age	'=> $studentApplicationInfo->mother_age,
                   'mother_tongue'=> $studentApplicationInfo->mother_tongue,
                   'mother_mobile'=> $studentApplicationInfo->mother_mobile,
                   'father_mobile'=> $studentApplicationInfo->father_mobile,
                   'blood_group'=> $studentApplicationInfo->blood_group,
                   'permanent_address'=>$studentApplicationInfo->permanent_address_line_1.' '.$studentApplicationInfo->permanent_address_line_2.' '.$studentApplicationInfo->permanent_address_district.' '.$studentApplicationInfo->permanent_address_state.' '.$studentApplicationInfo->permanent_address_pincode,
                   'present_address'=>$studentApplicationInfo->residential_address_line_1.' '.$studentApplicationInfo->residential_address_line_2.' '.$studentApplicationInfo->residential_address_district.' '.$studentApplicationInfo->residential_address_state.' '.$studentApplicationInfo->residential_address_pincode,
                     
                    'is_dyslexic'=>$studentApplicationInfo->dyslexia_challenged,
                  
                     'created_by' => $this->staff_id,
                     'created_date_time' => date('Y-m-d H:i:s'),
                     'updated_by' => $this->staff_id);
    
    
                     $resultstd = $this->application->addStudentInfo($studentInfo);
                 }

                $return_id = $this->application->updatedStudentApplicationStatus($admissionStatus,$app_no);
            }

            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($return_id);
            exit(0); 
        }
    }


    public function viewAdmissionWebsiteGrievance(){

        if($this->isAdmin() == TRUE){

            $this->loadThis();

        } else {    

            $filter = array();

            $application_no = $this->security->xss_clean($this->input->post('application_no'));   

            $by_date =$this->security->xss_clean($this->input->post('by_date')); 

            $student_name =$this->security->xss_clean($this->input->post('student_name')); 

            $by_first_preference =$this->security->xss_clean($this->input->post('by_first_preference')); 

            $by_second_preference =$this->security->xss_clean($this->input->post('by_second_preference'));

            $board_name =$this->security->xss_clean($this->input->post('board_name'));

            $by_percentage =$this->security->xss_clean($this->input->post('by_percentage'));

            $by_category =$this->security->xss_clean($this->input->post('by_category'));



            $filter['application_no'] = $application_no;

            $filter['student_name'] = $student_name;

            $filter['by_first_preference'] = $by_first_preference;

            $filter['by_second_preference'] = $by_second_preference;

            $filter['board_name'] = $board_name;

            $filter['by_percentage'] = $by_percentage;

            $filter['by_category'] = $by_category;



            $data['application_no'] = $application_no;

            $data['student_name'] = $student_name;

            $data['by_first_preference'] = $by_first_preference;

            $data['by_second_preference'] = $by_second_preference; 

            $data['board_name'] = $board_name;

            $data['by_percentage'] = $by_percentage;

            $data['by_category'] = $by_category;



            if(!empty($by_date)){

                $filter['by_date'] = date('Y-m-d',strtotime($by_date));

                $data['by_date'] = date('d-m-Y',strtotime($by_date));

            }else{

                $data['by_date'] = '';

            }

            

            $this->load->library('pagination');

            $count = $this->application->getWebsiteAdmissionGrievanceCount($filter);

            $returns = $this->paginationCompress("viewAdmissionWebsiteGrievance/", $count, 100);

            $data['countMessage'] = $count;

            $data['supportInfo'] = $this->application->getWebsiteAdmissionGrievanceInfo($filter, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'Schoolphins : Grievance';

            $this->loadViews("management/websiteGrievance", $this->global, $data , NULL);     

        } 

    }
    public function admissionGrievance(){

        if($this->isAdmin() == TRUE){

            $this->loadThis();

        } else {    

            $filter = array();

            $register_row_id = $this->security->xss_clean($this->input->post('register_row_id')); 

            $student_name =$this->security->xss_clean($this->input->post('student_name')); 

            $student_mobile_no =$this->security->xss_clean($this->input->post('student_mobile_no')); 

            $father_mobile_no =$this->security->xss_clean($this->input->post('father_mobile_no'));  

            $by_date =$this->security->xss_clean($this->input->post('by_date')); 



            $filter['register_row_id'] = $register_row_id;

            $filter['student_name'] = $student_name;

            $filter['student_mobile_no'] = $student_mobile_no;

            $filter['father_mobile_no'] = $father_mobile_no;



            $data['register_row_id'] = $register_row_id;

            $data['student_name'] = $student_name;

            $data['student_mobile_no'] = $student_mobile_no;

            $data['father_mobile_no'] = $father_mobile_no; 



            if(!empty($by_date)){

                $filter['by_date'] = date('Y-m-d',strtotime($by_date));

                $data['by_date'] = date('d-m-Y',strtotime($by_date));

            }else{

                $data['by_date'] = '';

            }

            

            $this->load->library('pagination');

            $count = $this->application->getAdmissionGrievanceListingCount($filter);

            $returns = $this->paginationCompress("admissionGrievance/", $count, 100);

            $data['countMessage'] = $count;

            $data['supportInfo'] = $this->application->getAdmissionGrievanceListing($filter, $returns["page"], $returns["segment"]);

            $this->global['pageTitle'] = 'Schoolphins : Grievance';

            $this->loadViews("application/grievance", $this->global, $data , NULL);     

        } 

    }

    function viewApplicationFeePending(){
        $filter = array();
        $by_name = $this->security->xss_clean($this->input->post('by_name'));
        $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
        $by_dob = $this->security->xss_clean($this->input->post('by_dob'));
        $program_name = $this->security->xss_clean($this->input->post('program_name'));
        $religion = $this->security->xss_clean($this->input->post('religion'));
        $admission_year = $this->security->xss_clean($this->input->post('admission_year'));
        $application_no = $this->security->xss_clean($this->input->post('application_no'));
        $data['admission_year'] = $admission_year;

        if($admission_year == '') {
            $filter['admission_year'] = 2024;
        }else {
            $filter['admission_year']  = $admission_year;
        }
        
        $data['by_name'] = $by_name;
        $data['religion'] = $religion;
        $data['stream_name'] = $stream_name;
        $data['program_name'] = $program_name;
        $data['religion'] = $religion;
        $data['application_no'] = $application_no;
     
        $filter['application_no'] = $application_no;
        $filter['by_name'] = $by_name;
        $filter['religion'] = $religion;
        $filter['stream_name'] = $stream_name;
        $filter['program_name'] = $program_name;
        $filter['religion'] = $religion;
        
        if(!empty($by_dob)){
            $filter['by_dob'] = date('Y-m-d',strtotime($by_dob));
            $data['by_dob'] = date('d-m-Y',strtotime($by_dob));
        }else{
            $data['by_dob'] = '';
        }

        $data['religionInfo'] = $this->application->getReligionInfo();
        $data['StreamInfo'] = $this->application->getStreamInfo();
        $this->load->library('pagination');
        $filter['page'] = $returns["page"];
        $filter['segment'] = $returns["segment"];
        $count = $this->application->getFeePendingApplicationCount($filter);
        $applicationInfo = $this->application->getFeePendingApplication($filter);

        $returns = $this->paginationCompress("viewApplicationFeePending/", $count, 100);
        $data['applicationCount'] = $count;
        $data['applicationInfo'] = $this->application->getFeePendingApplication($filter);
        $data['markInfo'] = $this->application;
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Application Stack';
        $this->loadViews("application/feePendingApplication", $this->global, $data, NULL);
    }
    public function applicationPendingPaymentComplete(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $reg_row_id = $this->input->post('row_id');
            
                
          
            // $existsApplicationStatus = $this->admission->checkStudentAdmissionStatus($reg_row_id);
            // if(empty($existsApplicationStatus->application_number)){
            //     $isExistsApplicationNumber = $this->admission->getPreviousStudentApplicationInfo();
            //     if(!empty($isExistsApplicationNumber)){
            //         $appNo = substr($isExistsApplicationNumber->application_number,3);

            //          $appliNo = $appNo + 1;
            //         $applicationNumber = '23H'.sprintf('%04d', $appliNo);
            //     }else {
            //            $applicationNumber = '23H'.sprintf('%04d', 1);

            //            }
            //         }else{
            //             $applicationNumber = $existsApplicationStatus->application_number;
            //         }

                  
                $applicationStatus = array(
                    'registered_row_id' => $reg_row_id,
                    'admission_status'=> 0,
                    'application_fee_status'=>'1',
                    'payment_type'=>'CASH',
                    'cash_paid_date'=>date('Y-m-d'),
                    'updated_by' => $this->staff_id,
                    'updated_date_time' => date('Y-m-d H:i:s'));
         
                // $studentPersonalInfo = array(
                //         'application_number'=> $applicationNumber,
                //         'student_application_status'=> 0,
                //         'updated_by' => $this->staff_id,
                //         'updated_dtm' => date('Y-m-d H:i:s'));

                
                        $isExists = $this->application->checkStudentAdmissionStatus($reg_row_id);
                        if(!empty($isExists)){
                            $retun = $this->application->updateStudentApplicationInfoStatus($reg_row_id,$applicationStatus);
                        }else{
                            $retun = $this->application->saveStudentApplicationStatus($applicationStatus);
                        }
                        // $result = $this->admission->updateStudentPersonalInfo($reg_row_id,$studentPersonalInfo);

               
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

       // Grievance list
   function viewGrievance(){
    $filter = array();
    $application_no = $this->security->xss_clean($this->input->post('application_no'));
   
    $subject = $this->security->xss_clean($this->input->post('subject'));
    $message = $this->security->xss_clean($this->input->post('message'));
    $admission_year = $this->security->xss_clean($this->input->post('admission_year'));
    $mobile = $this->security->xss_clean($this->input->post('mobile'));
    $date = $this->security->xss_clean($this->input->post('date'));
    $by_name = $this->security->xss_clean($this->input->post('by_name'));
    // log_message('debug','dataa'.$by_name);
    $data['admission_year'] = $admission_year;

    if($admission_year == '') {
        $filter['admission_year'] = 2024;
    }else {
        $filter['admission_year']  = $admission_year;
    }

    if(!empty($date)){
        $filter['date'] = date('Y-m-d',strtotime($date));
        $data['date'] = date('d-m-Y',strtotime($date));
    }else{
        $data['date'] = '';
    }

    $data['application_no'] = $application_no;
    $data['by_name'] = $by_name;
    $data['subject'] = $subject;
    $data['message'] = $message;
    $data['mobile'] = $mobile;
    
   
    $filter['mobile'] = $mobile;
    $filter['application_no'] = $application_no;
    $filter['by_name'] = $by_name;
    $filter['message'] = $message;
    $filter['subject'] = $subject;
    
   
    $this->load->library('pagination');
    $data['religionInfo'] = $this->application->getReligionInfo();
    $count = $this->application->getviewGrievanceCount($filter);
    $returns = $this->paginationCompress("viewRejectedApplication/", $count, 100);
    $data['applicationCount'] = $count;  
    $filter['page'] = $returns["page"];
    $filter['segment'] = $returns["segment"];
    $data['applicationInfo'] = $this->application->getviewGrievance($filter);
    $this->global['pageTitle'] = ''.TAB_TITLE.' : Rejected Applications';
    $this->loadViews("application/viewGrievance", $this->global, $data, NULL);
}

public function grievanceSolved(){
    if($this->isAdmin() == TRUE){
        $this->loadThis();
    } else {   
        $row_id = $this->input->post('row_id');
        $studentInfo = array('active_status' => 1,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
        $result = $this->application->updateGrievanceInfo($studentInfo, $row_id);
        if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
       
    } 
}

    public function grievanceInactive(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $studentInfo = array('active_status' => 0,'updated_by'=>$this->staff_id,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->application->updateGrievanceInfo($studentInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        
        } 
    }

    public function downloadApplicationStack(){
        if ($this->isAdmin() == true ) {
            setcookie('isDownloading',0); 
            $this->loadThis();
        } else {
            $filter = array();
            $student = $this->security->xss_clean($this->input->post('by_student'));
            $percentage_to = $this->security->xss_clean($this->input->post('percentage_to'));
            $percentage_from = $this->security->xss_clean($this->input->post('percentage_from'));
            $report_type = $this->security->xss_clean($this->input->post('report_type'));
            $by_class = $this->security->xss_clean($this->input->post('by_class'));
            $by_year = $this->security->xss_clean($this->input->post('by_year'));
            $by_gedner = $this->security->xss_clean($this->input->post('by_gedner'));
            $by_stream = $this->security->xss_clean($this->input->post('by_stream'));
            $elective_sub = $this->security->xss_clean($this->input->post('elective_sub'));
           
            $std_class = $by_class;
    
            $cellNameByStudentReport = array('G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
            // $filter['bank_settlement'] = $bank_settlement;
            for($sheet = 0; $sheet < 1;  $sheet++){
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle($report_type);
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:N500');
                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $this->excel->getActiveSheet()->setCellValue('A2', $report_type." Admission Report");
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->mergeCells('A1:M1');
                $this->excel->getActiveSheet()->mergeCells('A2:M2');
                $this->excel->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A2:M2')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A1:M1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                
                $excel_row = 3;
                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(28);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(14);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(28);
                
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(28);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(28);
                $this->excel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
                $this->excel->getActiveSheet()->getColumnDimension('K')->setWidth(14);
                
                $this->excel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
                // $this->excel->getActiveSheet()->getColumnDimension('N')->setWidth(18);
                $this->excel->getActiveSheet()->getStyle('A3:M3')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A3:M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, 'SL No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, 'Application No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, 'Gender');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'Religion');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, 'Category');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, 'Father Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, 'Mother Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, 'Father Mobile');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, 'Mother Mobile');
    
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row, 'DOB');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row, 'Course');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row, 'Stream');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('N'.$excel_row, 'SSLC Percentage');
                $filter['report_type']= $report_type;
                $filter['by_stream']= $by_stream;
                $filter['by_class']= $by_class;
                $filter['by_year']= $by_year;
                $filter['by_gedner']= $by_gedner;
                // $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                // $this->excel->getActiveSheet()->getStyle('A1:K4')->applyFromArray($styleBorderArray);
    
                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A1:M3')->applyFromArray($styleBorderArray);
                $sl = 1;
                $excel_row = 4;
    log_message('debug','filter'.print_r($filter,true));
                $studentInfo = $this->application->getApplicationInfoForReport($filter);
    log_message('debug','filter'.print_r($studentInfo,true));
               
                    foreach($studentInfo as $std){
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, $sl++);
                        
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, $std->application_number);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, $std->name);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $std->gender);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $std->religion);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $std->caste);
                        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $std->category);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $std->father_name);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, $std->mother_name);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('I'.$excel_row, $std->father_mobile);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('J'.$excel_row, $std->mother_mobile);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('K'.$excel_row, date('d-m-Y',strtotime($std->dob)));
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('L'.$excel_row, $std->program_name);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('M'.$excel_row, $std->stream_name);
                        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('N'.$excel_row, $std->sslc_percentage);
                        $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':F'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $this->excel->getActiveSheet()->getStyle('G'.$excel_row.':H'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        $this->excel->getActiveSheet()->getStyle('I'.$excel_row.':M'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        // $this->excel->getActiveSheet()->getStyle('L'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        // $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        // $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':K4'.$excel_row)->applyFromArray($styleBorderArray);
                        $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getActiveSheet()->getStyle('A4:M'.$excel_row)->applyFromArray($styleBorderArray);
    
                        $excel_row++;
                        
                    }
                    $this->excel->createSheet(); 
                    
                }
                
            }
            
            $filename =  $report_type.'_Application_Report_-'.date('d-m-Y').'.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
                        
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            ob_start();
            setcookie('isDownloading',0); 
            $objWriter->save("php://output");
            
        }
    
        public function downloadApplicationFeepaidReport(){
            if ($this->isAdmin() == true ) {
                setcookie('isDownloading',0);
                $this->loadThis();
            } else {
                set_time_limit(0);
                ini_set('memory_limit', '256M');
    
                $filter = array();
                $date_from = $this->security->xss_clean($this->input->post('date_from'));
                $date_to = $this->security->xss_clean($this->input->post('date_to'));
                $year = $this->security->xss_clean($this->input->post('year'));
                $type = $this->security->xss_clean($this->input->post('type'));
                $by_stream = $this->security->xss_clean($this->input->post('by_stream'));
                $by_class = $this->security->xss_clean($this->input->post('by_class'));
                $cellNameByStudentReport = array('K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
                $sheet = 0;
                // for($sheet = 0; $sheet < count($stream);  $sheet++){
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle("APPLICATION FEE PAID REPORT");
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:H500');
                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $this->excel->getActiveSheet()->setCellValue('A2', "APPLICATION FEE PAID REPORT - ".$year);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                $this->excel->getActiveSheet()->mergeCells('A1:G1');
                $this->excel->getActiveSheet()->mergeCells('A2:G2');
                $this->excel->getActiveSheet()->getStyle('A1:A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                
                $excel_row = 3;
                $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(12);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(18);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(13);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
                // $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, 'SL No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, 'Date');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, 'Application No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, 'Name');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'Course');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, 'Stream');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, 'Fee');
                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, 'Order ID');
    
                
                $this->excel->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                if(!empty($date_from)){
                    $date_from = date('Y-m-d',strtotime($date_from));
                }
                if(!empty($date_to)){
                    $date_to = date('Y-m-d',strtotime($date_to));
                }
                
                $filter['date_from']= $date_from;
                $filter['date_to']= $date_to;
                $filter['year']= $year;
                $filter['type']= $type;
                $filter['by_class']= $by_class;
                $filter['by_stream']= $by_stream;
                $sl = 1;
                $excel_row = 4;
              
                $studentInfo = $this->application->getAdmissionApplicationFeePaidReport($filter);
                
                    
                $this->excel->getActiveSheet()->getStyle('A1:G3')->getFont()->setBold(true);
                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                $this->excel->getActiveSheet()->getStyle('A3:G3')->applyFromArray($styleBorderArray);
                foreach($studentInfo as $std){
                    // $std->amount
                    
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, $sl++);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, date('d-m-Y',strtotime($std->cash_paid_date)));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, $std->application_number);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, strtoupper($std->name));
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $std->program_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $std->stream_name);
                    $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, '100');
                    // $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, $std->order_id);
    
                    
    
                    $this->excel->getActiveSheet()->getStyle('A4:G'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('E'.$excel_row.':G'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    
                    $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                    $this->excel->getActiveSheet()->getStyle('A4:G'.$excel_row)->applyFromArray($styleBorderArray);
                    $excel_row++;
                }
                $this->excel->createSheet(); 
                
            }
            
            $filename =  'Application_Fee_Paid_-'.date('d-m-Y').'.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
                        
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            ob_start();
            setcookie('isDownloading',0);
            $objWriter->save("php://output");        
                
            }
    
            public function downloadAdmissionRegisteredStudent(){
                if ($this->isAdmin() == true ) {
                    setcookie('isDownloading',0);
                    $this->loadThis();
                } else {
                    $filter = array();
                   
                    $year = $this->security->xss_clean($this->input->post('year'));
                    
        
                    
                    $cellNameByStudentReport = array('G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
                    $sheet = 0;
                        $this->excel->setActiveSheetIndex($sheet);
                        $this->excel->getActiveSheet()->setTitle($sheet);
                        $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:N500');
                        $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                        $this->excel->getActiveSheet()->setCellValue('A2', "Registered Students Report - ".$year);
                        $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                        $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                        $this->excel->getActiveSheet()->mergeCells('A1:E1');
                        $this->excel->getActiveSheet()->mergeCells('A2:E2');
                        $this->excel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getStyle('A2:E2')->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getStyle('A1:E1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $this->excel->getActiveSheet()->getStyle('A1:E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        
                        $excel_row = 3;
                        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
                        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(27);
                        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(27);
                        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
                        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(28);
                        
                        // $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
                        $this->excel->getActiveSheet()->getStyle('A3:E3')->getFont()->setBold(true);
                        $this->excel->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, 'SL No.');
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, 'Name');
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, 'Email');
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, 'Mobile');
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'Registered Date');
                        // $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, 'Mobile');
                        // $filter['stream_name']= $stream[$sheet];
                        $filter['by_sslc_board']= $by_sslc_board;
        
                        $filter['year']= $year;
                        $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getActiveSheet()->getStyle('A1:E3')->applyFromArray($styleBorderArray);
                        $sl = 1;
                        $excel_row = 4;
                        $studentInfo = $this->application->getAllRegisteredStdInfo($filter);
                            foreach($studentInfo as $std){
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, $sl++);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, $std->name);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, $std->email);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $std->mobile);
                                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, date('d-m-Y',strtotime($std->created_date)));
                                // $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $std->mobile);
                                $this->excel->getActiveSheet()->getStyle('A'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $this->excel->getActiveSheet()->getStyle('B'.$excel_row.':C'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                                $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':E'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                                $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                                $this->excel->getActiveSheet()->getStyle('A4:E'.$excel_row)->applyFromArray($styleBorderArray);
                                
                                $excel_row++;
                            }
                            $this->excel->createSheet(); 
                        // }
                        
                    }
                    
                    $filename = 'Registered_Report_-'.date('d-m-Y').'.xls'; //save our workbook as this file name
                    header('Content-Type: admission/vnd.ms-excel'); //mime type
                    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
                    header('Cache-Control: max-age=0'); //no cache
                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
                    ob_start();
                    setcookie('isDownloading',0);
                    $objWriter->save("php://output");
                    
            }

    // public function AdmissionReportDashboard(){
    //     if($this->isAdmin() == TRUE ){
    //         $this->loadThis();
    //     } else {

    //         $this->global['pageTitle'] = ''.TAB_TITLE.' : Report';
    //         $this->loadViews("admission_22/reportDashboard", $this->global, $data, NULL);
    //     }
    // }
    public function getSubjectCodes($stream_name){
        //science
        $PCMB = array("33", "34", "35", '36');
        $PCMC = array("33", "34", "35", '41');
        $PCME = array("33", "34", "35", '40');
        //commarce
        $PEBA = array("29", "22", "27", '30');
        $MEBA = array("75", "22", "27", '30');
        $MSBA = array("75", "31", "27", '30');
        $CSBA = array("41", "31", "27", '30');
        $SEBA = array("31", "22", "27", '30');
        $CEBA = array("41", "22", "27", '30');
        //art
        $HESP = array("21", "22", "28", '32');
        $HEBA = array("21", "22", "27", '30');

        $HEPS = array("21", "22", "32", '31');
        switch ($stream_name) {
            case "PCMB":
                return  $PCMB;
                break;
            case "PCMC":
                return $PCMC;
                break;
            case "PEBA":
                return $PEBA;
                break;
            case "PCME":
                return $PCME;
                break;
            case "MEBA":
                return $MEBA;
                break;
            case "MSBA":
                return $MSBA;
                break;
            case "CSBA":
                return $CSBA;
                break;
            case "SEBA":
                return $SEBA;
                break;
            case "CEBA":
                return $CEBA;
                break;
            case "HEPS":
                return $HEPS;
                break;
            case "HESP":
                return $HESP;
                break;
            case "HEBA":
                return $HEBA;
                break;
        }
    }

    
    function sendSingleNumberSMS($mobile,$msg){
        $message = $msg;
        $message = rawurlencode($message);  
        $data = "username=".USERNAME_TEXTLOCAL."&hash=".HASH_TEXTLOCAL."&message=".$message."&sender=".SENDERID_TEXTLOCAL."&numbers=".$mobile;
        $ch = curl_init('https://api.textlocal.in/send/?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result_sms = curl_exec($ch); // This is the result from the API
        $json = json_decode($result_sms, true);
        //log_message('error', 'JSON=' );
        $status= $json['status'];
        log_message('error', 'JSON='.print_r($json));
        log_message('error', 'result_sms='.print_r($result_sms,true));
        curl_close($ch);
        return $status;
    }

    
}
?>