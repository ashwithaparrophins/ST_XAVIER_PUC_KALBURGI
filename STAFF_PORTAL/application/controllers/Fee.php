<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';
require APPPATH . '/third_party/encdec_paytm.php';
// require APPPATH . '/third_party/Kit/AWLMEAPI.php';
class Fee extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('fee_model','fee');
        $this->load->model('students_model','student');
        $this->load->model('account_model','account');
        $this->load->model('admission_model','admission');
        $this->load->model('application_model','application');
        $this->load->model('settings_model','settings');
        $this->load->library('pdf');
        $this->load->library('excel');
        $this->isLoggedIn();
    }
    
    public function viewFeeConcession(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {  
            $filter = array();
            $by_name = $this->security->xss_clean($this->input->post('by_name'));
            $amount = $this->security->xss_clean($this->input->post('amount'));
            $by_date = $this->security->xss_clean($this->input->post('by_date'));
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $year = $this->security->xss_clean($this->input->post('year'));

            $data['by_name'] = $by_name;
            $data['amount'] = $amount;
            $data['student_id'] = $student_id;
            $data['year'] = $year;


            $filter['student_id'] = $student_id;
            $filter['by_name'] = $by_name;
            $filter['amount'] = $amount;
            $filter['year'] = $year;

            if(!empty($by_date)){
                $filter['by_date'] = date('Y-m-d',strtotime($by_date));
                $data['by_date'] = date('d-m-Y',strtotime($by_date));
            }else{
                $data['by_date'] = '';
            }
            
            $this->load->library('pagination');
            $count = $this->fee->getFeeConcessionCount($filter);
            $returns = $this->paginationCompress("viewFeeConcession/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['concessionInfo'] = $this->fee->getFeeConcessionInfo($filter);
            $data['studentInfo'] = $this->student->getStudentInfoForConcession();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Fee Concession';
            $this->loadViews("feeConcession/concession.php", $this->global, $data, null);
        }
    }
  
    public function addConcession() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('application_no','Student ID','trim|required');
            $this->form_validation->set_rules('fee_amount','Amount','trim|required|numeric');

            $data['studentInfo'] = $this->student->getStudentInfoForConcession();

            if($this->form_validation->run() == FALSE) {
                $this->viewFeeConcession();
            } else {
                $application_no = $this->security->xss_clean($this->input->post('application_no'));
                $fee_amount = $this->security->xss_clean($this->input->post('fee_amount'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $year = $this->security->xss_clean($this->input->post('year'));
                $isExist = $this->fee->checkStudentIdExists($application_no,$year);
                if(!empty($isExist)){
                    $this->session->set_flashdata('warning', 'Student ID Already Exists');
                    redirect('viewFeeConcession');
                }else{ 
                    $feeInfo = array(
                        'application_no'=>$application_no,
                        'fee_amt'=>$fee_amount,
                        'description'=>$description,
                        'year'=>$year,
                        'date'=>date('Y-m-d H:i:s'),
                        'approved_status'=>1,
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->fee->addConcession($feeInfo);
                    if($result > 0){
                        $this->session->set_flashdata('success', 'Concession Added successfully');
                    } else{
                        $this->session->set_flashdata('error', 'Failed to Add Concession');
                    }
                }
                redirect('viewFeeConcession');
            }
        }
    } 
    
    public function editConcession($row_id = null){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            if ($row_id == NULL) {
                redirect('viewFeeStructure');
            }
            $data['feeInfo'] = $this->fee->getFeeConcessionById($row_id);
            $data['studentInfo'] = $this->student->getStudentInfoForConcession();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Update Concession';
            $this->loadViews("feeConcession/editConcession", $this->global, $data, null);
        }
    }

    public function updateConcession() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $row_id = $this->input->post('row_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('application_no','Student ID','trim|required');
            $this->form_validation->set_rules('fee_amount','Amount','trim|required|numeric');

            if($this->form_validation->run() == FALSE) {
                redirect('editConcession/'.$row_id);
            } else {
                $application_no = $this->security->xss_clean($this->input->post('application_no'));
                $fee_amount = $this->security->xss_clean($this->input->post('fee_amount'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $year = $this->security->xss_clean($this->input->post('year'));

                    $feeInfo = array(
                        'application_no'=>$application_no,
                        'fee_amt'=>$fee_amount,
                        'description'=>$description,
                        'year'=> $year,
                        'updated_by'=>$this->staff_id,
                        'updated_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->fee->updateConcession($feeInfo,$row_id);
                    if($result > 0){
                        $this->session->set_flashdata('success', 'Concession Updated successfully');
                    } else{
                        $this->session->set_flashdata('error', 'Failed to Update Concession');
                    }
                redirect('editConcession/'.$row_id);
            }
        }
    }

    
    public function deleteConcession(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feeInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->fee->updateConcession($feeInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }


    public function approveConcession(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feeInfo = array('approved_status' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->fee->updateConcession($feeInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
    
    public function rejectConcession(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feeInfo = array('approved_status' => 2,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->fee->fee->updateConcession($feeInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }


    public function viewScholarship(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {  
            $filter = array();
            $by_name = $this->security->xss_clean($this->input->post('by_name'));
            $amount = $this->security->xss_clean($this->input->post('amount'));
            $by_date = $this->security->xss_clean($this->input->post('by_date'));
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $year = $this->security->xss_clean($this->input->post('year'));

            $data['by_name'] = $by_name;
            $data['amount'] = $amount;
            $data['student_id'] = $student_id;
            $data['year'] = $year;

            $filter['student_id'] = $student_id;
            $filter['by_name'] = $by_name;
            $filter['amount'] = $amount;
            $filter['year'] = $year;

            if(!empty($by_date)){
                $filter['by_date'] = date('Y-m-d',strtotime($by_date));
                $data['by_date'] = date('d-m-Y',strtotime($by_date));
            }else{
                $data['by_date'] = '';
            }
            
            $this->load->library('pagination');
            $count = $this->fee->getFeeScholarshipCount($filter);
            $returns = $this->paginationCompress("viewScholarship/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['concessionInfo'] = $this->fee->getFeeScholarshipInfo($filter);
            $data['studentInfo'] = $this->student->getStudentInfoForConcession();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Fee Scholarship';
            $this->loadViews("feeScholarship/scholarship.php", $this->global, $data, null);
        }
    }
  
    public function addScholarship() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('application_no','Student ID','trim|required');
            $this->form_validation->set_rules('fee_amount','Amount','trim|required|numeric');

            $data['studentInfo'] = $this->student->getStudentInfoForConcession();

            if($this->form_validation->run() == FALSE) {
                $this->viewScholarship();
            } else {
                $application_no = $this->security->xss_clean($this->input->post('application_no'));
                $fee_amount = $this->security->xss_clean($this->input->post('fee_amount'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $year = $this->security->xss_clean($this->input->post('year'));
                    $feeInfo = array(
                        'application_no'=>$application_no,
                        'fee_amt'=>$fee_amount,
                        'description'=>$description,
                        'year'=>$year,
                        'date'=>date('Y-m-d H:i:s'),
                        'approved_status'=>1,
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->fee->addScholarship($feeInfo);
                    if($result > 0){
                        $this->session->set_flashdata('success', 'Scholarship Added successfully');
                    } else{
                        $this->session->set_flashdata('error', 'Failed to Add Scholarship');
                    }
                redirect('viewScholarship');
            }
        }
    } 
    
    public function editScholarship($row_id = null){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            if ($row_id == NULL) {
                redirect('viewScholarship');
            }
            $data['feeInfo'] = $this->fee->getFeeScholarshipById($row_id);
            $data['studentInfo'] = $this->student->getStudentInfoForConcession();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Update Scholarship';
            $this->loadViews("feeScholarship/editScholarship", $this->global, $data, null);
        }
    }

    public function updateScholarship() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $row_id = $this->input->post('row_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('application_no','Student ID','trim|required');
            $this->form_validation->set_rules('fee_amount','Amount','trim|required|numeric');

            if($this->form_validation->run() == FALSE) {
                redirect('editScholarship/'.$row_id);
            } else {
                $application_no = $this->security->xss_clean($this->input->post('application_no'));
                $fee_amount = $this->security->xss_clean($this->input->post('fee_amount'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $year = $this->security->xss_clean($this->input->post('year'));

                    $feeInfo = array(
                        'application_no'=>$application_no,
                        'fee_amt'=>$fee_amount,
                        'description'=>$description,
                        'year'=> $year,
                        'updated_by'=>$this->staff_id,
                        'updated_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->fee->updateScholarship($feeInfo,$row_id);
                    if($result > 0){
                        $this->session->set_flashdata('success', 'Scholarship Updated successfully');
                    } else{
                        $this->session->set_flashdata('error', 'Failed to Update Scholarship');
                    }
                redirect('editScholarship/'.$row_id);
            }
        }
    }

    
  

    public function approveScholarship(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feeInfo = array('approved_status' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->fee->updateScholarship($feeInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
    
    public function rejectScholarship(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feeInfo = array('approved_status' => 2,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->fee->fee->updateScholarship($feeInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    //fee payment proceed in portal
    public function newAdmissionFeePayNow(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $data['fee_pending_status'] = false;
        // $data['studentInfoSelection'] = $this->student->getAllStudentsInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Pay Now';
            $this->loadViews("admission/feePaymentPortal", $this->global, $data, null);
        }
    }


    public function feeInstallmentListing(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {  
        
        $filter = array();
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $student_name = $this->security->xss_clean($this->input->post('student_name'));
            $amount = $this->security->xss_clean($this->input->post('amount'));
            $last_date = $this->security->xss_clean($this->input->post('last_date'));
            $year= $this->security->xss_clean($this->input->post('year'));

            $data['student_id'] = $student_id;
            $data['student_name'] = $student_name;
            $data['amount'] = $amount;
            $data['year'] = $year;

            $filter['student_id'] = $student_id;
            $filter['student_name'] = $student_name;
            $filter['amount'] = $amount;
            $filter['year'] = $year;
          
            if(!empty($last_date)){
                $filter['last_date'] = date('Y-m-d',strtotime($last_date));
                $data['last_date'] = date('d-m-Y',strtotime($last_date));
            }else{
                $data['last_date'] = '';
            }
            
            $this->load->library('pagination');
            $count = $this->fee->getFeeInstallmentCount($filter);
            $returns = $this->paginationCompress("feeInstallmentListing/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['installmentInfo'] = $this->fee->getAllFeeInstallmentInfo($filter, $returns["page"], $returns["segment"]);
            $data['studentInfo'] = $this->student->getAllStudentsInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Fee Installment';
            $this->loadViews("feeInstallment/installment", $this->global, $data, null);
        }
    }

    public function addFeeInstallment() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('application_no','Student ID','trim|required');
            $this->form_validation->set_rules('amount','Amount','trim|required|numeric');
            $this->form_validation->set_rules('last_date','Last Date For Payment','trim|required');

            if($this->form_validation->run() == FALSE) {
                $this->feeInstallmentListing();
            } else {
                $application_no = $this->security->xss_clean($this->input->post('application_no'));
                $last_date = $this->security->xss_clean($this->input->post('last_date'));
                $amount = $this->security->xss_clean($this->input->post('amount'));
                $remarks = $this->security->xss_clean($this->input->post('remarks'));
                $year = $this->security->xss_clean($this->input->post('year'));
                    $installmentInfo = array(
                        'application_no'=>$application_no,
                        'amount'=>$amount,
                        'last_date' => date('Y-m-d',strtotime($last_date)),
                        'created_by'=>$this->staff_id,
                        'remarks'=>$remarks,
                        'year' => $year,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->fee->addFeeInstallment($installmentInfo);
                    
                    if($result > 0){
                        $this->session->set_flashdata('success', 'Fee Instalment added successfully');
                    } else{
                        $this->session->set_flashdata('error', 'Failed to Add Fee Instalment');
                    }
                redirect('feeInstallmentListing');
            }
        }
    }

    public function editFeeInstallment($row_id = null){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            if ($row_id == NULL) {
                redirect('feeInstallmentListing');
            }
            $data['installmentInfo'] = $this->fee->getFeeInstallmentById($row_id);
            // $data['studentInfo'] = $this->student->getstudentInfo();
            $data['studentInfo'] =$this->student->getAllStudentsInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Update Fee Instalment';
            $this->loadViews("feeInstallment/editFeeInstallment", $this->global, $data, null);
        }
    }

    public function updateFeeInstallment() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $row_id = $this->input->post('row_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('application_no','Student ID','trim|required');
            $this->form_validation->set_rules('amount','Amount','trim|required|numeric');
            $this->form_validation->set_rules('last_date','Last Date For Payment','trim|required');

            if($this->form_validation->run() == FALSE) {
                redirect('editFeeInstallment/'.$row_id);
            } else {
                $application_no = $this->security->xss_clean($this->input->post('application_no'));
                $last_date = $this->security->xss_clean($this->input->post('last_date'));
                $amount = $this->security->xss_clean($this->input->post('amount'));
                $remarks = $this->security->xss_clean($this->input->post('remarks'));
                $year = $this->security->xss_clean($this->input->post('year'));

                $installmentInfo = array(
                        'application_no'=>$application_no,
                        'amount'=>$amount,
                        'last_date' => date('Y-m-d',strtotime($last_date)),
                        'remarks'=>$remarks,
                        'year' => $year,
                        'updated_by'=>$this->staff_id,
                        'updated_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->fee->updateFeeInstallment($installmentInfo,$row_id);
                    if($result > 0){
                        $this->session->set_flashdata('success', 'Fee Instalment Updated successfully');
                    } else{
                        $this->session->set_flashdata('error', 'Failed to Update Fee Instalment');
                    }
                redirect('editFeeInstallment/'.$row_id);
            }
        }
    }


    public function deleteFeeInstallment(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $installmentInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->fee->updateFeeInstallment($installmentInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }


    //fee payment proceed in portal
    
    public function feePayNow(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $data['fee_pending_status'] = false; 
            $data['allStudentInfo'] = $this->student->getAllOldStudentsInfo();
           //  $data['studentInfoSelection'] = $this->student->getAllFirstYearStudent();
            // $data['allStudentInfo'] = $this->admission->getFirstYearStudentsInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Pay Now';
            $this->loadViews("fees/paymentPortal", $this->global, $data, null);
        }
    }

    public function getStudentFeePaymentInfo(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $term_name = $this->security->xss_clean($this->input->post('term_name')); 
            //$application_no = $this->security->xss_clean($this->input->post('application_no')); 
            if(empty($student_id)){
                $student_id = $_SESSION["FEE_STUDENT_ID"];
                $term_name = $_SESSION["FEE_TERM_NAME"];
            }
            $studentInfo = $this->student->getAllStudentsInfoByStudentID($student_id);
            
            $filter = array();
      
            $data['student_id'] = $student_id;
            $data['term_name'] = $term_name;
            $filter['stream_name'] = $studentInfo->stream_name;
            
            if($student_id == '20P1777' || $student_id == '20P1577' || $student_id == '20P3179' || $student_id == '20P5780' || $student_id == '20P4176' || $student_id == '20P1377'){
                $filter['term_name'] = 'I PUC';
                $filter['board_name'] = 'SSLC';
            }else{
                $filter['term_name'] = 'II PUC';
            }

            if(strtoupper($studentInfo->elective_sub) == 'FRENCH'){
                $filter['lang_fee_status'] = true;
            }else{
                $filter['lang_fee_status'] = false;
            }
            $filter['category'] = strtoupper($studentInfo->category);
           
            if($studentInfo->intake_year == '2019-2020'){
                $data['feeInfo'] = $this->fee->getFeePendingAmount2019($student_id);
                $data['feePaidInfo'] = $this->fee->getFeePaidInfo2019($studentInfo->application_no);
                $data['balance'] = $data['feeInfo']->balance;
                $data['fee_year'] = 2019;
            }else if($studentInfo->term_name == 'II PUC'){
                if($term_name == 'I PUC'){
                    $data['feeInfo'] = $this->fee->getFeePendingAmount2021($student_id);
                    $data['feePaidInfo'] = $this->fee->getFeePaidInfo2020($studentInfo->application_no);
                    $data['balance'] = $data['feeInfo']->balance;
                }else{
                    // $filter['term_name'] = 'II PUC';
                    $data['feePaidInfo'] = $this->fee->getFeePaidInfo2021($studentInfo->application_no);
                    $filter['fee_year'] = '2021';
                    $data['fee_year'] = '2021';
                    $total_fee = $this->fee->getTotalFeeAmount($filter);
                    $total_fee_to_pay = $total_fee->total_fee;
                    $data['total_fee'] = $total_fee->total_fee;
                    if(!empty($data['feePaidInfo'])){
                        foreach($data['feePaidInfo'] as $fee){
                            $total_fee_to_pay = $total_fee_to_pay - $fee->paid_amount;
                        }
                    }
                    $data['balance'] = $total_fee_to_pay;
                }
            }else{
                $data['feeInfo'] = $this->fee->getFeePendingAmount2019($student_id);
                $data['feePaidInfo'] = $this->fee->getFeePaidInfo2020($studentInfo->application_no);
                $data['balance'] = $data['feeInfo']->balance;
            }

            //$data['total_fee'] = $total_fee;
            $data['studentInfo'] = $studentInfo;

            $data['allStudentInfo'] = $this->student->getAllOldStudentsInfo();
            $this->global['pageTitle'] = TAB_TITLE.' : Fee Payment' ;
            $this->loadViews("fees/paymentPortal", $this->global, $data, null);
        }
    }


    public function addFeePaymentInfo(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {  
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('term_name')); 
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $application_no = $this->security->xss_clean($this->input->post('application_no'));

            $paid_fee_amount = $this->security->xss_clean($this->input->post('paid_fee_amount'));
            $payment_type = $this->security->xss_clean($this->input->post('payment_type'));

            $dd_number = $this->security->xss_clean($this->input->post('dd_number'));
            $dd_date = $this->security->xss_clean($this->input->post('dd_date'));
            $bank_name = $this->security->xss_clean($this->input->post('bank_name'));

            $tran_number = $this->security->xss_clean($this->input->post('tran_number'));
            $tran_date = $this->security->xss_clean($this->input->post('tran_date'));
            $tran_bank_name = $this->security->xss_clean($this->input->post('tran_bank_name'));

            $payment_date = $this->security->xss_clean($this->input->post('transaction_date'));

            $excess_amount = $this->security->xss_clean($this->input->post('excess_amount'));
            $_SESSION["FEE_STUDENT_ID"] = $student_id;
            $_SESSION["FEE_TERM_NAME"] = $term_name;


            $filter['student_id'] = $student_id;
            $studentInfo = $this->student->getAllStudentsInfoByStudentID($student_id);
            
            if($studentInfo->term_name == 'II PUC' && $studentInfo->intake_year == '2020-2022'){
                if($term_name == 'I PUC'){
                    $data['feeInfo'] = $this->fee->getFeePendingAmount2021($student_id);
                    $data['feePaidInfo'] = $this->fee->getFeePaidInfo2020($studentInfo->application_no);
                    $data['balance'] = $data['feeInfo']->balance;

                    $fee_year= 2020;
                    $feeInfo = $this->fee->getFeePendingAmount2021($student_id);

                    $lastReceiptInfo = $this->fee->getLastReceiptNo2021();
                    if(!empty($lastReceiptInfo->receipt_number)){
                        $sub_recpt = substr($lastReceiptInfo->receipt_number,1) + 1;
                        $receipt_no = 'S'.sprintf('%04d',$sub_recpt);
                    }
                    if($feeInfo->balance > 0){
                        $overallFee = array(
                            'receipt_number' => $receipt_no,
                            'application_no' => $studentInfo->application_no,
                            'payment_type' => $payment_type,
                            'payment_date' => date('Y-m-d',strtotime($payment_date)),
                            'total_amount' => $feeInfo->total_fee,
                            'paid_amount' => $paid_fee_amount,
                            'excess_amount' => $excess_amount,
                            'fee_concession' => 0,
                            'pending_balance' => $feeInfo->balance - $paid_fee_amount,
                            'fee_pending_status' => 0,
                            'fee_year' => $fee_year,
                            'collected_staff_name' => $this->staff_id,
                            'created_by' => $this->staff_id,
                            'created_date_time' => date('Y-m-d H:i:s'));
                        $receipt_number = $this->fee->addFeeDetails2020IPUC($overallFee);
                        $balance = $feeInfo->balance - $paid_fee_amount;
                        $pendingFeeUpdate = array(
                            'application_no' => $studentInfo->application_no,
                            'balance' => $balance,
                        );
            
                        $return = $this->fee->updatePendingFeeOld($pendingFeeUpdate,$studentInfo->application_no);

                        $remaining_fee_amt = $paid_fee_amount;

                        $filter['fee_year'] = $fee_year;
                        $filter['term_name'] = 'I PUC';
                        $filter['stream_name'] = $studentInfo->stream_name;
                        $filter['category'] = strtoupper($studentInfo->category);
                        if($studentInfo->last_board_name != 'KARNATAKA STATE BOARD'){
                            $filter['board_name'] = 'SSLC';
                        }else{
                            $filter['board_name'] = 'OTHER';
                        }
                        if(strtoupper($studentInfo->elective_sub) == 'FRENCH'){
                            $filter['lang_fee_status'] = true;
                        }else{
                            $filter['lang_fee_status'] = false;
                        }
                        // log_message('debug','pp'.print_r($filter,true));
                        $feeStructureInfo = $this->fee->getFeeStructureInfo2021($filter);
                        foreach($feeStructureInfo as $fee){
                            $db_save_status = false;
                            $fee_structure_amt = $fee->fee_amount_state_board;
                            $isAlreadyPaid = $this->fee->checkFeeTypeIsAlreadyPaid2021($studentInfo->application_no,$fee->row_id);
                            if($remaining_fee_amt >= 0){
                                $pending_amt1 = $fee->fee_amount_state_board - $isAlreadyPaid->paid_amount;
                                if(!empty($isAlreadyPaid)){
                                    if($pending_amt1>0){
                                        $remaining_fee_amt -= $pending_amt1;
                                        if($remaining_fee_amt >= 0){
                                            $paid_amt = $pending_amt1;
                                            $pending_amt = 0;
                                            $fee_pending_status = 0;
                                        } else {
                                            $paid_amt = $pending_amt1 - abs($remaining_fee_amt);
                                            $pending_amt = $pending_amt1 - $paid_amt;
                                            $fee_pending_status = 1;
                                        } 
                                        $db_save_status = true;
                                    }
                                }else{
                                    $remaining_fee_amt -= $fee_structure_amt;
                                    if($remaining_fee_amt >= 0){
                                        //$pending_amount = 0;
                                        $paid_amt = $fee_structure_amt;
                                        $pending_amt = 0;
                                        $fee_pending_status = 0;
                                    } else {
                                        //$dd_amount = 0; 
                                        $paid_amt = $fee_structure_amt - abs($remaining_fee_amt);
                                        $pending_amt = $fee_structure_amt - $paid_amt;
                                        $fee_pending_status = 1;
                                    } 
                                    $db_save_status = true;
                                }
                            }else{
                                if(empty($isAlreadyPaid)){
                                $pending_amt = $fee_structure_amt;
                                $paid_amt = 0;
                                $fee_pending_status = 1;
                                $db_save_status = true;
                                }
                            }
                            if($db_save_status){
                                $feeReceiptPayment = array(
                                    'application_no' => $studentInfo->application_no,
                                    'receipt_number' => $receipt_no,
                                    'payment_date' => date('Y-m-d',strtotime($payment_date)), 
                                    'fee_type_id' => $fee->row_id,
                                    'paid_amount' => $paid_amt,
                                    'school_account_id' => $fee->account_row_id,
                                    'created_by' => 'schoolphins',
                                    'created_date_time' => date('Y-m-d H:i:s'));
                                    
                                $receipt_return_feeType = $this->fee->addReceiptFeeTypeOld($feeReceiptPayment);
                            }
                        
                        }
                    }
                
                }else{
                    $feePaymentInfo = $this->fee->getStdPaidDetailsByApplicationNo($studentInfo->application_no);
                    if(empty($feePaymentInfo)){
                        $paid_count = 1;
                    }else{
                        $paid_count = $feePaymentInfo->payment_count+1;
                    }
                    if($student_id == '20P1777' || $student_id == '20P1577' || $student_id == '20P3179' || $student_id == '20P5780' || $student_id == '20P4176' || $student_id == '20P1377'){
                        $filter['term_name'] = 'I PUC';
                        $filter['board_name'] = 'SSLC';
                    }else{
                        $filter['term_name'] = 'II PUC';
                    }
                    // $filter['term_name'] = 'II PUC';
                    $filter['stream_name'] = $studentInfo->stream_name;
                
                    if(strtoupper($studentInfo->elective_sub) == 'FRENCH'){
                        $filter['lang_fee_status'] = true;
                    }else{
                        $filter['lang_fee_status'] = false;
                    }
                    $filter['category'] = strtoupper($studentInfo->category);
                    
                    $data['feePaidInfo'] = $this->fee->getFeePaidInfo2021($studentInfo->application_no);
                    $filter['fee_year'] = '2021';
                    $data['fee_year'] = '2021';
                    $total_fee = $this->fee->getTotalFeeAmount($filter);
                    $feeStructureInfo = $this->fee->getFeeStructureInfo2021($filter);
                    $total_fee_to_pay = $total_fee->total_fee;
                    $data['total_fee'] = $total_fee->total_fee;
                    if(!empty($data['feePaidInfo'])){
                        foreach($data['feePaidInfo'] as $fee){
                            $total_fee_to_pay = $total_fee_to_pay - $fee->paid_amount;
                        }
                    }

                    $pending_fee_balance = $total_fee_to_pay - $paid_fee_amount;
                    if($pending_fee_balance <= 0){
                        $fee_excess_amount = abs($pending_fee_balance);
                        $fee_pending_status = 0;
                    }else if($pending_fee_balance > 0){
                        $fee_excess_amount = 0;
                        $fee_pending_status = 1;
                    }
                    $fee_year= 2021;
                    $overallFee = array(
                        'application_no' => $studentInfo->application_no,
                        'payment_type' => $payment_type,
                        'payment_date' => date('Y-m-d',strtotime($payment_date)),
                        'total_amount' => $total_fee->total_fee,
                        'paid_amount' => $paid_fee_amount,
                        'excess_amount' => $fee_excess_amount,
                        'fee_concession' => 0,
                        'pending_balance' => abs($pending_fee_balance),
                        'fee_pending_status' => $fee_pending_status,
                        'payment_count' => $paid_count,
                        'fee_year' => $fee_year,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d H:i:s'));
                        
                        $receipt_number = $this->fee->addFeeDetailsNewAdmission($overallFee);

                        $fee_amount_balance_pending = $paid_fee_amount;
                        $remaining_fee_amt = $paid_fee_amount;
                        foreach($feeStructureInfo as $fee){
                            $db_save_status = false;
                            $fee_structure_amt = $fee->fee_amount_state_board;
                            $isAlreadyPaid = $this->fee->checkFeeTypeIsAlreadyPaid($studentInfo->application_no,$fee->row_id);
                            if($remaining_fee_amt >= 0){
                                if(!empty($isAlreadyPaid)){
                                    if($isAlreadyPaid->pending_status == 1){
                                        $remaining_fee_amt -= $isAlreadyPaid->pending_amt;
                                        if($remaining_fee_amt >= 0){
                                            //$pending_amount = 0;
                                            $paid_amt = $isAlreadyPaid->pending_amt;
                                            $pending_amt = 0;
                                            $fee_pending_status = 0;
                                        } else {
                                            //$dd_amount = 0; 
                                            $paid_amt = $isAlreadyPaid->pending_amt - abs($remaining_fee_amt);
                                            $pending_amt = $isAlreadyPaid->pending_amt - $paid_amt;
                                            $fee_pending_status = 1;
                                        } 
                                        $db_save_status = true;
                                    }
                                }else{
                                    $remaining_fee_amt -= $fee_structure_amt;
                                    if($remaining_fee_amt >= 0){
                                        //$pending_amount = 0;
                                        $paid_amt = $fee_structure_amt;
                                        $pending_amt = 0;
                                        $fee_pending_status = 0;
                                    } else {
                                        //$dd_amount = 0; 
                                        $paid_amt = $fee_structure_amt - abs($remaining_fee_amt);
                                        $pending_amt = $fee_structure_amt - $paid_amt;
                                        $fee_pending_status = 1;
                                    } 
                                    $db_save_status = true;
                                }
                            }else{
                                if(empty($isAlreadyPaid)){
                                $pending_amt = $fee_structure_amt;
                                $paid_amt = 0;
                                $fee_pending_status = 1;
                                $db_save_status = true;
                                }
                            }
                            if($db_save_status){
                                $feeReceiptPayment = array(
                                    'application_no' => $studentInfo->application_no,
                                    'receipt_number' => $receipt_number,
                                    'payment_date' => date('Y-m-d',strtotime($payment_date)), 
                                    'fee_type_id' => $fee->row_id,
                                    'paid_amount' => $paid_amt,
                                    'pending_amt' => $pending_amt,
                                    'pending_status' => $fee_pending_status,
                                    'school_account_id' => $fee->account_row_id,
                                    'created_by' => 'schoolphins',
                                    'fee_amount' => $fee_structure_amt,
                                    'created_date_time' => date('Y-m-d H:i:s'));
                                    
                                $receipt_return_feeType = $this->fee->addReceiptFeeType($feeReceiptPayment);
                            }
                        
                        }
                }
            } else {
                    $fee_year= 2019;
                    $feeInfo = $this->fee->getFeePendingAmount2019($student_id);
                    if($feeInfo->balance > 0){
                        $overallFee = array(
                            'application_no' => $studentInfo->application_no,
                            'payment_type' => $payment_type,
                            'payment_date' => date('Y-m-d',strtotime($payment_date)),
                            'total_amount' => $feeInfo->total_fee,
                            'paid_amount' => $paid_fee_amount,
                            'excess_amount' => $excess_amount,
                            'fee_concession' => 0,
                            'pending_balance' => 0,
                            'fee_pending_status' => 0,
                            'fee_year' => $fee_year,
                            'collected_staff_name' => $this->staff_id,
                            'created_by' => $this->staff_id,
                            'created_date_time' => date('Y-m-d H:i:s'));
                        $receipt_number = $this->fee->addFeePending2019($overallFee);
                        $balance = $feeInfo->balance - $paid_fee_amount;
                        $pendingFeeUpdate = array(  
                            'student_id' => $studentInfo->student_id,
                            'balance' => $balance,
                        );
            
                        $return = $this->fee->updatePendingFee2019($pendingFeeUpdate,$studentInfo->student_id);
                    }
            }
           
            
            if(!empty($receipt_number)){
                if($payment_type == 'DD'){
                    $ddInfo = array(
                        'fee_year' => $fee_year,
                        'receipt_number' => $receipt_number,
                        'dd_number' => $dd_number,
                        'dd_date' => date('Y-m-d',strtotime($dd_date)),
                        'bank_name' => $bank_name,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d H:i:s')
                    );
                    $this->fee->addDDInfo($ddInfo);
                }else if($payment_type == 'CARD'){
                    $bankInfo = array(
                        'receipt_number' => $receipt_number,
                        'transaction_number' => $tran_number,
                        'transaction_date' => date('Y-m-d',strtotime($tran_date)),
                        'bank_name' => $tran_bank_name,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d H:i:s')
                    );
                    $this->fee->addBankInfo($bankInfo);
                }
                $this->session->set_flashdata('success', 'Fee Paid Successfully');
                // redirect('feePaymentReceiptPrint/'.$receipt_number); 
               
            }else{
                $this->session->set_flashdata('error', 'Fee Payment Failed!');
            }
            redirect('getStudentFeePaymentInfo'); 
        }
    }

   
  

   


    public function viewAdmFeeConcession(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {  
            $filter = array();
            $by_name = $this->security->xss_clean($this->input->post('by_name'));
            $amount = $this->security->xss_clean($this->input->post('amount'));
            $by_date = $this->security->xss_clean($this->input->post('by_date'));
            $application_no = $this->security->xss_clean($this->input->post('application_no'));
            $term_name = $this->security->xss_clean($this->input->post('term_name'));
            $year = $this->security->xss_clean($this->input->post('year'));

            $data['by_name'] = $by_name;
            $data['amount'] = $amount;
            $data['application_no'] = $application_no;
            $data['year'] = $year;
            if(empty($term_name)){
                $data['term_name'] = "II PUC";
                $filter['term_name'] = "II PUC";
            }else{
                $data['term_name'] = $term_name;
                $filter['term_name'] = $term_name;
            }
            $filter['application_no'] = $application_no;
            $filter['by_name'] = $by_name;
            $filter['amount'] = $amount;
            $filter['year'] = $year;

            if(!empty($by_date)){
                $filter['by_date'] = date('Y-m-d',strtotime($by_date));
                $data['by_date'] = date('d-m-Y',strtotime($by_date));
            }else{
                $data['by_date'] = '';
            }
            
            $this->load->library('pagination');
            $count = $this->fee->getFeeConcessionCount($filter);
            $returns = $this->paginationCompress("viewAdmFeeConcession/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['concessionInfo'] = $this->fee->getFeeConcessionInfo($filter);
            $data['studentInfo'] = $this->student->getStudentInfoForConcession();
            // $data['newAdmStdInfo'] = $this->admission->getAllAdmittedStudentInfo();
            // $data['reAdmStdInfo'] = $this->student->getAll_II_PUC_StudentsInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : New Admission Fee Concession 2021';
            $this->loadViews("feeConcession/feeConcessionNewAdmission", $this->global, $data, null);
        }
    }

    
    function getAllFeePaymentInfo()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $filter = array();
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $application_no = $this->security->xss_clean($this->input->post('application_no'));
            $date_select = $this->security->xss_clean($this->input->post('date_select'));
            $receipt_number = $this->security->xss_clean($this->input->post('receipt_number'));
            $amount_paid = $this->security->xss_clean($this->input->post('amount_paid'));
            $amount_pending = $this->security->xss_clean($this->input->post('amount_pending'));
            $reference_number = $this->security->xss_clean($this->input->post('reference_number'));
            $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
            $bank_settlement = $this->security->xss_clean($this->input->post('bank_settlement'));
            $by_bank_date = $this->security->xss_clean($this->input->post('by_bank_date'));
            $year = $this->security->xss_clean($this->input->post('year'));
            $date_from_filter = $this->security->xss_clean($this->input->post('date_from_filter'));
            $date_to_filter = $this->security->xss_clean($this->input->post('date_to_filter'));
            
            $searchText = "";
            $data['year'] = $filter['by_year'] = $year;
            if(!empty($application_no)){
                $filter['application_no'] = $application_no;
                $data['application_no'] = $application_no;
            }else{
                $data['application_no'] = '';
            }
            if(!empty($student_id)){
                $filter['student_id'] = $student_id;
                $data['student_id'] = $student_id;
            }else{
                $data['student_id'] = '';
            }
            if(!empty($date_select)){
                $filter['date_select'] = date('Y-m-d',strtotime($date_select));
                $data['date_select'] = date('d-m-Y',strtotime($date_select));;
            }else{
                $data['date_select'] = '';
            }
            if(!empty($receipt_number)){
                $filter['receipt_number'] = $receipt_number;
                $data['receipt_number'] = $receipt_number;
            }else{
                $data['receipt_number'] = '';
            }
            if(!empty($amount_paid)){
                $filter['amount_paid'] = $amount_paid;
                $data['amount_paid'] = $amount_paid;
            }else{
                $data['amount_paid'] = '';
            }
            if(!empty($amount_pending)){
                $filter['amount_pending'] = $amount_pending;
                $data['amount_pending'] = $amount_pending;
            }else{
                $data['amount_pending'] = '';
            } 
            if(!empty($reference_number)){
                $filter['order_id'] = $reference_number;
                $data['order_id'] = $reference_number;
            }else{
                $data['order_id'] = '';
            } 
            if(!empty($payment_type)){
                $filter['payment_type'] = $payment_type;
                $data['payment_type'] = $payment_type;
            }else{
                $data['payment_type'] = '';
            } 
            if($bank_settlement == 'Pending'){
                $filter['bank_settlement'] = 'Pending';;
                $data['bank_settlement'] = 'Pending';
            }else if($bank_settlement == 'Settled'){
                $data['bank_settlement'] = 'Settled';
                $filter['bank_settlement'] = 'Settled';
            }else{
                $data['bank_settlement'] = 'Settled';
                $filter['bank_settlement'] = 1;
            }
            // log_message('debug','fff=='.print_r($feeStructure,true));
            
            if(!empty($by_bank_date)){
                $filter['by_bank_date'] = date('Y-m-d',strtotime($by_bank_date));
                $data['by_bank_date'] = date('d-m-Y',strtotime($by_bank_date));;
            }else{
                $data['by_bank_date'] = '';
            }

            if(!empty($date_from_filter)){
	            $filter['date_from_filter'] = date('Y-m-d',strtotime($date_from_filter));
	            $data['date_from_filter'] = $date_from_filter;
	        }else{
	            $data['date_from_filter'] = date('Y-m-01');
                $filter['date_from_filter'] = date('Y-m-01');
	        }

            if(!empty($date_to_filter)){
	            $filter['date_to_filter'] = date('Y-m-d',strtotime($date_to_filter));
	            $data['date_to_filter'] = $date_to_filter;
	        }else{
	            $data['date_to_filter'] = date('Y-m-t');
                $filter['date_to_filter'] = date('Y-m-t');
            }
            $this->load->library('pagination');
            $count = $this->fee->getAllFeePaymentInfoCount($filter);
            $returns = $this->paginationCompress("onlinePaymentInfo/", $count, 100 );
            $data['online_pay_count'] = $count;
            $data['feePaidInfo'] = $this->fee->getAllFeePaymentInfo( $returns["page"], $returns["segment"], $filter);
            
            // $data['feePaidStdInfo'] = $this->account->getFeePaidStudentInfo();
            // log_message('debug','jbcdbc'.print_r($data['onlineFeeInfo'],true));
            $this->global['pageTitle'] = ''.TAB_TITLE.' :Fee Paid Details';
            $data['orderIDInfo'] = $this->fee->getReAdmUnProcessedOrderID();
            $data['neworderIDInfo'] = $this->fee->getNewAdmUnProcessedOrderID();
            $this->loadViews("fees/getAllFeePaymentInfo", $this->global, $data, NULL);
        }
    }

    
    function getAllFeePaymentInfoNewAdm()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $filter = array();
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $application_no = $this->security->xss_clean($this->input->post('application_no'));
            $date_select = $this->security->xss_clean($this->input->post('date_select'));
            $receipt_number = $this->security->xss_clean($this->input->post('receipt_number'));
            $amount_paid = $this->security->xss_clean($this->input->post('amount_paid'));
            $amount_pending = $this->security->xss_clean($this->input->post('amount_pending'));
            $reference_number = $this->security->xss_clean($this->input->post('reference_number'));
            $payment_type = $this->security->xss_clean($this->input->post('payment_type'));
            $bank_settlement = $this->security->xss_clean($this->input->post('bank_settlement'));
            $by_bank_date = $this->security->xss_clean($this->input->post('by_bank_date'));

            
            $searchText = "";
            if(!empty($application_no)){
                $filter['application_no'] = $application_no;
                $data['application_no'] = $application_no;
            }else{
                $data['application_no'] = '';
            }
            if(!empty($student_id)){
                $filter['student_id'] = $student_id;
                $data['student_id'] = $student_id;
            }else{
                $data['student_id'] = '';
            }
            if(!empty($date_select)){
                $filter['date_select'] = date('Y-m-d',strtotime($date_select));
                $data['date_select'] = date('d-m-Y',strtotime($date_select));;
            }else{
                $data['date_select'] = '';
            }
            if(!empty($receipt_number)){
                $filter['receipt_number'] = $receipt_number;
                $data['receipt_number'] = $receipt_number;
            }else{
                $data['receipt_number'] = '';
            }
            if(!empty($amount_paid)){
                $filter['amount_paid'] = $amount_paid;
                $data['amount_paid'] = $amount_paid;
            }else{
                $data['amount_paid'] = '';
            }
            if(!empty($amount_pending)){
                $filter['amount_pending'] = $amount_pending;
                $data['amount_pending'] = $amount_pending;
            }else{
                $data['amount_pending'] = '';
            } 
            if(!empty($reference_number)){
                $filter['order_id'] = $reference_number;
                $data['order_id'] = $reference_number;
            }else{
                $data['order_id'] = '';
            } 
            if(!empty($payment_type)){
                $filter['payment_type'] = $payment_type;
                $data['payment_type'] = $payment_type;
            }else{
                $data['payment_type'] = '';
            } 
            if($bank_settlement == 'Pending'){
                $filter['bank_settlement'] = 'Pending';;
                $data['bank_settlement'] = 'Pending';
            }else if($bank_settlement == 'Settled'){
                $data['bank_settlement'] = 'Settled';
                $filter['bank_settlement'] = 'Settled';
            }else{
                $data['bank_settlement'] = 'Settled';
                $filter['bank_settlement'] = 1;
            }
            // log_message('debug','fff=='.print_r($feeStructure,true));
            
            if(!empty($by_bank_date)){
                $filter['by_bank_date'] = date('Y-m-d',strtotime($by_bank_date));
                $data['by_bank_date'] = date('d-m-Y',strtotime($by_bank_date));;
            }else{
                $data['by_bank_date'] = '';
            }

            
            $this->load->library('pagination');
            $count = $this->fee->getAllFeePaymentInfoCountNewAdm($filter);
            $returns = $this->paginationCompress("getAllFeePaymentInfoNewAdm/", $count, 100 );
            $data['online_pay_count'] = $count;
            $data['feePaidInfo'] = $this->fee->getAllFeePaymentInfoNewAdm( $returns["page"], $returns["segment"], $filter);
            
            // $data['process'] = $this->fee->getAllFeePaymentInfoNewAdmPROCESS();
            // foreach($data['process'] as $p){
            //     $applicationStatus = array(
            //         'joined_status' => 1,
            //         'admission_status'=> 1,
            //         'updated_date_time' => date('Y-m-d H:i:s'));
            //    $this->admission->updateStudentApplicationStatus($p->application_no,$applicationStatus);
            // }
           
            // $data['feePaidStdInfo'] = $this->account->getFeePaidStudentInfo();
            // log_message('debug','jbcdbc'.print_r($data['onlineFeeInfo'],true));
            $this->global['pageTitle'] = ''.TAB_TITLE.' :Fee Paid Details';
            $this->loadViews("fees/newAdmFeePaidInfo21", $this->global, $data, NULL);
        }
    }
    
    public function feePaymentReceiptPrint($row_id){
        $filter = array();
        $feeInfo = $data['feeInfo'] = $this->fee->getFeeInfoByReceiptNum($row_id);

        $studentInfo =  $this->student->getStudentInfoByRowId($data['feeInfo']->application_no);
        $lastRow = $this->fee->getLastOverallFeeRow($data['feeInfo']->application_no);
        $concession = $this->fee->getSumFeeConcessionInfoForReport($data['feeInfo']->application_no,$data['feeInfo']->payment_year);
        $scholarship = $this->fee->getSumFeeScholarshipInfoForReport($data['feeInfo']->application_no,$data['feeInfo']->payment_year,$data['feeInfo']->created_date_time);

        // if($lastRow->row_id == $row_id && (($feeInfo->pending_balance == $concession->fee_amt) || ($feeInfo->pending_balance == $scholarship->fee_amt) || ($feeInfo->pending_balance == $scholarship->fee_amt + $concession->fee_amt))){
        //     $data['concession'] = $concession->fee_amt;
        //     $data['scholarship'] = $scholarship->fee_amt;
        //     $data['pending_bal'] = $data['feeInfo']->pending_balance - $data['concession'] - $data['scholarship'];   
           
        // }else{
        //     $data['pending_bal'] = $data['feeInfo']->pending_balance;
        // }
        if($lastRow->row_id == $row_id){
            if($feeInfo->pending_balance == $concession->fee_amt){
                $data['concession'] = $concession->fee_amt;
                $data['pending_bal'] = $data['feeInfo']->pending_balance - $data['concession'];
            }else if($feeInfo->pending_balance == $scholarship->fee_amt){
                $data['scholarship'] = $scholarship->fee_amt;
                $data['pending_bal'] = $data['feeInfo']->pending_balance - $data['scholarship'];
            }else if($feeInfo->pending_balance == $scholarship->fee_amt + $concession->fee_amt){
                $data['concession'] = $concession->fee_amt;
                $data['scholarship'] = $scholarship->fee_amt;
                $data['pending_bal'] = $data['feeInfo']->pending_balance - $data['concession'] - $data['scholarship'];   

            }else{
                $data['pending_bal'] = $data['feeInfo']->pending_balance;
            }

        }else{
                $data['pending_bal'] = $data['feeInfo']->pending_balance;
        }
        // $filter['fee_year'] = ($studentInfo->intake_year_id)+1;
        // if($studentInfo->term_name == 'I PUC'){
        //     $studentInfo = $this->application->getApprovedStudentInfoByApplicationNo($data['feeInfo']->application_no);
            $filter['fee_year'] = $data['feeInfo']->payment_year;
        // }

        $filter['stream_name'] = $studentInfo->stream_name;
        $filter['term_name'] = $data['feeInfo']->term_name;
    
        $data['feeStructureInfo'] = $this->fee->getFeeStructureInfo($filter);
        // $data['concession_amount'] = $this->fee->getFeeConcessionByAppNo($data['feeInfo']->application_no,$filter['fee_year']);
        //log_message('debug','feeStruct='.print_r($data['feeStructureInfo'],true));
        // $concession = $this->fee->getStudentFeeConcessionInfo($data['feeInfo']->rel_stud_row_id);
        // $data['paidFeeSum'] = $this->fee->getSumOfFeesPaid($data['feeInfo']->application_no,$data['feeInfo']->payment_year);
        $data['paidFeeSum'] = $this->fee->getSumOfFeesPaidForReceipt($data['feeInfo']->application_no,$data['feeInfo']->payment_year,$data['feeInfo']->created_date_time);
       
        // $data['fee_concession'] = $concession->fee_amt;
        $data['studentInfo'] = $studentInfo;
        
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Fee Receipt';
        $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman', 'format' => 'A4-L']);
        $mpdf->AddPage('L','','','','',10,10,3,1,8,8);
        
        $data['paid_amount'] = $data['feeInfo']->paid_amount;
        $data['previousFeePaidInfo'] = $this->fee->getPreviousFeePaidInfo($row_id,$data['feeInfo']->application_no, $studentInfo->term_name);
        $data['paid_amount_words'] = $this->getIndianCurrency(floatval($data['paid_amount']));
        $data['name_count'] = 0;
        $html_student_copy = $this->load->view('fees/feeReceiptPrint',$data,true);
        $data['name_count'] = 1;
        $html_office_copy = $this->load->view('fees/feeReceiptPrint',$data,true);
       
        
        $mpdf->WriteHTML('<columns column-count="2" vAlign="J" column-gap="10" />');
        $mpdf->WriteHTML($html_student_copy);
        $mpdf->WriteHTML($html_office_copy);

        $mpdf->Output('Fee_Receipt.pdf', 'I');
        
    }

    function getIndianCurrency(float $number) {
            $decimal = round($number - ($no = floor($number)), 2) * 100;
            $hundred = null;
            $digits_length = strlen($no);
            $i = 0;
            $str = array();
            $words = array(0 => '', 1 => 'one', 2 => 'two',
                3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
                7 => 'seven', 8 => 'eight', 9 => 'nine',
                10 => 'ten', 11 => 'eleven', 12 => 'twelve',
                13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
                16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
                19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
                40 => 'forty', 50 => 'fifty', 60 => 'sixty',
                70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
            $digits = array('', 'hundred','thousand','lakh', 'crore');
            while( $i < $digits_length ) {
                $divider = ($i == 2) ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i += $divider == 10 ? 1 : 2;
                if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
                } else $str[] = null;
            }
            $Rupees = implode('', array_reverse($str));
            $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
            return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
        }

    public function addBankSettlementSubmitNewAdm(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $date = $this->input->post('date');
            $receipt_number = json_decode(stripslashes($this->input->post('receipt_number')));
            foreach($receipt_number as $receipt){
                $isExist = $this->account->getBankSettlementByReceiptNoNewAdm($receipt);
                if(empty($isExist)){
                  
                    $settleInfo = array(
                        'date' => date('Y-m-d',strtotime($date)),
                        'receipt_number' => $receipt,
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    $return_id = $this->account->addBankSettlementNewAdm($settleInfo);
                }else{
                    $settleInfo = array(
                        'date' => date('Y-m-d',strtotime($date)),
                        'receipt_number' => $receipt,
                        'updated_by'=>$this->staff_id,
                        'is_deleted' => 0,
                        'updated_date_time'=>date('Y-m-d H:i:s'));
                    $return_id = $this->account->updateBankSettlementNewAdm($settleInfo, $receipt);
                }
                $feePaidInfo = array(
                    'receipt_number' => $receipt,
                    'bank_settlement_status' => 1,
                    'updated_by'=>$this->staff_id,
                    'updated_date_time'=>date('Y-m-d H:i:s'));
                $return =  $this->account->updatefeeSettleStatusNewAdm2021($feePaidInfo, $receipt);
               
            }
            if($return_id > 0){
                echo "success";
                exit;
            }else{
                echo "error";
                exit;
            }
        } 
    }

    public function addBankSettlementSubmit(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $date = $this->input->post('date');
            $receipt_number = json_decode(stripslashes($this->input->post('receipt_number')));
            foreach($receipt_number as $receipt){
                // $isExist = $this->account->getBankSettlementByReceiptNo($receipt);
                // if(empty($isExist)){
                //     $settleInfo = array(
                //         'date' => date('Y-m-d',strtotime($date)),
                //         'receipt_number' => $receipt,
                //         'fee_year' => CURRENT_YEAR,
                //         'created_by'=>$this->staff_id,
                //         'created_date_time'=>date('Y-m-d H:i:s'));
                //     $return_id = $this->account->addBankSettlement($settleInfo);
                // }else{
                //     $settleInfo = array(
                //         'date' => date('Y-m-d',strtotime($date)),
                //         'receipt_number' => $receipt,
                //         'updated_by'=>$this->staff_id,
                //         'is_deleted' => 0,
                //         'updated_date_time'=>date('Y-m-d H:i:s'));
                //     $return_id = $this->account->updateBankSettlement($settleInfo, $receipt);
                // }
                $feePaidInfo = array(
                    'bank_settlement_date' => date('Y-m-d',strtotime($date)),
                    'bank_settlement_status' => 1,
                    'updated_by'=>$this->staff_id,
                    'updated_date_time'=>date('Y-m-d H:i:s'));
                $return_id =  $this->account->updatefeeSettleStatus($feePaidInfo, $receipt);
               
            }
            echo "success";
            exit;
        } 
    }

    
    // management fee
    public function viewManagementFeeInfo(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {  
            $filter = array();
            $by_name = $this->security->xss_clean($this->input->post('by_name'));
            $amount = $this->security->xss_clean($this->input->post('amount'));
            $by_date = $this->security->xss_clean($this->input->post('by_date'));
            $student_id = $this->security->xss_clean($this->input->post('student_id'));
            $order_id = $this->security->xss_clean($this->input->post('order_id'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));

            $data['by_name'] = $by_name;
            $data['amount'] = $amount;
            $data['student_id'] = $student_id;
            $data['order_id'] = $order_id;
            $data['stream_name'] = $stream_name;

            $filter['student_id'] = $student_id;
            $filter['by_name'] = $by_name;
            $filter['amount'] = $amount;
            $filter['order_id'] = $order_id;
            $filter['stream_name'] = $stream_name;

            if(!empty($by_date)){
                $filter['by_date'] = date('Y-m-d',strtotime($by_date));
                $data['by_date'] = date('d-m-Y',strtotime($by_date));
            }else{
                $data['by_date'] = '';
            }
            
            $this->load->library('pagination');
            $count = $this->fee->getStdMngtFeeInfoInfoCount($filter);
            $returns = $this->paginationCompress("viewManagementFeeInfo/", $count, 100);
            $data['totalCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['mngtFeeInfo'] = $this->fee->getStdMngtFeeInfoInfo($filter);
            $data['studentInfo'] = $this->student->getAllFirstYearStudent();
            $data['mngtfeeSum'] = $this->fee->getSumOfManagementFee();
            $data['streamInfo'] = $this->student->getAllStreamName();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Management Fee';
            $this->loadViews("fees/mngtFeeInfo", $this->global, $data, null);
        }
    }

    public function addManagementFeeInfo() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('application_no','Student ID','trim|required');
            $this->form_validation->set_rules('feeDate','Date','trim|required');
            $this->form_validation->set_rules('fee_amount','Amount','trim|required|greater_than_equal_to[1]|less_than_equal_to[5000]');

            if($this->form_validation->run() == FALSE) {
                $this->viewManagementFeeInfo();
            } else {
                $application_no = $this->security->xss_clean($this->input->post('application_no'));
                $fee_amount = $this->security->xss_clean($this->input->post('fee_amount'));;
                $feeDate = $this->security->xss_clean($this->input->post('feeDate'));
                // $description = $this->security->xss_clean($this->input->post('description'));

                $isExist = $this->fee->checkStudentForMngtFeeExists($application_no); 
                if($isExist > 0){
                    $this->session->set_flashdata('warning', 'Student already exist');
                    redirect('viewManagementFeeInfo');
                }else{
                    $fee_date = date('Y-m-d',strtotime($feeDate));
                    $feeInfo = array(
                        'application_no' => $application_no,
                        'amount' => $fee_amount,
                        'date' => $fee_date,
                        'created_by'=>$this->staff_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->fee->addStudentMngtFee($feeInfo);
                }
               
                if($result > 0){
                    $this->session->set_flashdata('success', 'Management Fee Added successfully');
                } else{
                    $this->session->set_flashdata('error', 'Failed to Add Management Fee');
                }
                redirect('viewManagementFeeInfo');
            }
        }
    } 
     
    public function editMngtFee($row_id = null){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            if ($row_id == NULL) {
                redirect('viewFeeStructure');
            }
            $data['feeInfo'] = $this->fee->getStudentManagementFeeInfoById($row_id);
            $data['studentInfo'] = $this->student->getAllFirstYearStudent();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Management Fee';
            $this->loadViews("fees/editMngtFee", $this->global, $data, null);
        }
    }

    public function updateMngtFee() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $row_id = $this->input->post('row_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('application_no','Student ID','trim|required');
            $this->form_validation->set_rules('fee_amount','Amount','trim|required|greater_than_equal_to[1]|less_than_equal_to[5000]');

            if($this->form_validation->run() == FALSE) {
                redirect('editMngtFee/'.$row_id);
            } else {
                $application_no = $this->security->xss_clean($this->input->post('application_no'));
                $fee_amount = $this->security->xss_clean($this->input->post('fee_amount'));;
                $feeDate = $this->security->xss_clean($this->input->post('feeDate'));

                $isExist = $this->fee->checkStudentForMngtFeeExists($application_no,$row_id); 
                if($isExist > 0){
                    $this->session->set_flashdata('warning', 'Student already exist');
                    redirect('viewManagementFeeInfo');
                }else{
                    $feeInfo = array(
                        'application_no' => $application_no,
                        'amount' => $fee_amount,
                        'date' => date('Y-m-d',strtotime($feeDate)),
                        'updated_by'=>$this->staff_id,
                        'updated_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->fee->updateManagementFee($feeInfo,$row_id);
                }

                if($result > 0){
                    $this->session->set_flashdata('success', 'Management Fee Updated successfully');
                } else{
                    $this->session->set_flashdata('error', 'Failed to Update Management Fee');
                }
                redirect('editMngtFee/'.$row_id);
            }
        }
    }

    public function deleteMngtFee(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feeInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id);
            $result = $this->fee->updateManagementFee($feeInfo,$row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function printMngtFeeReceipt($row_id){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $filter = array();

            $this->global['pageTitle'] = ''.TAB_TITLE.' : Fee Receipt';
            $data['feeInfo'] = $this->fee->getStudentManagementFeeInfoById($row_id);
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman', 'format' => [130, 140]]);
            $mpdf->AddPage('L','','','','',10,10,10,10,8,8);
            $mpdf->SetTitle('Fee Receipt');
            $html = $this->load->view('fees/printMngtFeeReceipt',$data,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Fee_Receipt.pdf', 'I');
        } 
    }



    public function download_II_PUC_StudentFeePaidReport(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $filter = array();
            $student = $this->security->xss_clean($this->input->post('by_student'));

            //$by_sslc_board = $this->security->xss_clean($this->input->post('by_board'));
        // $generation_type = $this->security->xss_clean($this->input->post('generation_type'));
            $elective_sub = $this->security->xss_clean($this->input->post('elective_sub'));
            $paid_type = $this->security->xss_clean($this->input->post('payment_type'));
            $stream = array(
                'PCMB',
                'PCMC',
                'CEBA',
                'HEBA',
                'SEBA',
                'HESP'
            );
            $cellNameByStudentReport = array('G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        // $filter['bank_settlement'] = $bank_settlement;
            for($sheet = 0; $sheet < count($stream);  $sheet++){
                $this->excel->setActiveSheetIndex($sheet);
                //name the worksheet
                $this->excel->getActiveSheet()->setTitle($stream[$sheet]);
                $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:L500');
                //set Title content with some text
                $this->excel->getActiveSheet()->setCellValue('A1', EXCEL_TITLE);
                $this->excel->getActiveSheet()->setCellValue('A2', 'Fee Paid - '.$stream[$sheet]. " Fee Paid Report 2020-21");
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
                $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
                
                $excel_row = 3;
                $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
                
                $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $this->excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, 'SL No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, 'Application No.');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, 'Student ID');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, 'Name');

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, 'Elective');

                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, 'Total Fee');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, 'Paid Amt');
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, 'Pending Amt');
            // $filter['report_type']= $report_type;
                $filter['stream_name']= $stream[$sheet];
            // $filter['by_sslc_board']= $by_sslc_board;

                $filter['paid_type']= $paid_type;
            
                $filter['generation_type']= $generation_type;
                $filter['elective_sub']= $elective_sub;
                $sl = 1;
                $excel_row = 4;
                $studentInfo = $this->fee->downloadAdmittedStudentFeePaidReport($filter);
                    foreach($studentInfo as $std){
                        $filter['stream_name'] = $std->stream_name;
                        $filter['term_name'] = 'II';
                        if(strtoupper($std->elective_sub) == 'FRENCH'){
                            $filter['lang_fee_status'] = true;
                        }else{
                            $filter['lang_fee_status'] = false;
                        }
                        // $total_fee_obj = $this->admission->getTotalFeeAmount($filter);
                        $total_fee_amount = $total_fee_obj->total_fee;
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row, $sl++);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row, $std->application_no);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row, $std->student_id);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row, $std->student_name);
                    
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row, $std->elective_sub);

                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row, $total_fee_amount);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row, $std->paid_amount);
                        $this->excel->setActiveSheetIndex($sheet)->setCellValue('H'.$excel_row, $std->pending_balance);
                        $excel_row++;
                    }
                    $this->excel->createSheet(); 
                }
                
            }
            
            $filename = 'II_PUC_Fee_Paid_Report_-'.date('d-m-Y').'.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
                        
            //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
            //if you want to save it as .XLSX Excel 2007 format
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            ob_start();
            $objWriter->save("php://output");
            
    }

    // get student data based on term
    public function getStudentInfoByTermForFee(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $term_name = $this->input->post("term_name");
            $filter['term_name'] = $term_name;
            $data['result'] = $this->admission->getStudentDetailsForFeePayment($filter);
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }

public function processTheFeePayment(){
                    $paidInfo = $this->fee->getFeePaidInfo2021_ALL();
                    foreach($paidInfo as $paid){
                        $isExist = $this->fee->checkFeeAlreadyReceiptProcessed($paid->receipt_number);
                        $studentInfo = $this->student->getStudentInfoBy_Application_no($paid->application_no);
                      
                        $filter['fee_year'] = '2021';
                        $filter['term_name'] = 'II PUC';
                        $filter['stream_name'] = $studentInfo->stream_name;
                        if(strtoupper($studentInfo->elective_sub) == 'FRENCH'){
                            $filter['lang_fee_status'] = true;
                        }else{
                            $filter['lang_fee_status'] = false;
                        }
                        
                        $filter['category'] = strtoupper($studentInfo->category);
                        $feeStructureInfo = $this->fee->getFeeStructureInfo2021($filter);
                        $paid_fee_amount = $paid->paid_amount;
                        if(empty($isExist)){
                            $fee_amount_balance_pending = $paid_fee_amount;
                            $remaining_fee_amt = $paid_fee_amount;
                            foreach($feeStructureInfo as $fee){
                                $db_save_status = false;
                                $fee_structure_amt = $fee->fee_amount_state_board;
        
                                $isAlreadyPaid = $this->fee->checkFeeTypeIsAlreadyPaid($paid->application_no,$fee->row_id);
                                if($remaining_fee_amt >= 0){
                                    if(!empty($isAlreadyPaid)){
                                        if($isAlreadyPaid->pending_status == 1){
                                            $remaining_fee_amt -= $isAlreadyPaid->pending_amt;
                                            if($remaining_fee_amt >= 0){
                                                //$pending_amount = 0;
                                                $paid_amt = $isAlreadyPaid->pending_amt;
                                                $pending_amt = 0;
                                                $fee_pending_status = 0;
                                            } else {
                                                //$dd_amount = 0; 
                                                $paid_amt = $isAlreadyPaid->pending_amt - abs($remaining_fee_amt);
                                                $pending_amt = $isAlreadyPaid->pending_amt - $paid_amt;
                                                $fee_pending_status = 1;
                                            } 
                                            $db_save_status = true;
                                        }
                                    }else{
                                        $remaining_fee_amt -= $fee_structure_amt;
                                        if($remaining_fee_amt >= 0){
                                            //$pending_amount = 0;
                                            $paid_amt = $fee_structure_amt;
                                            $pending_amt = 0;
                                            $fee_pending_status = 0;
                                        } else {
                                            //$dd_amount = 0; 
                                            $paid_amt = $fee_structure_amt - abs($remaining_fee_amt);
                                            $pending_amt = $fee_structure_amt - $paid_amt;
                                            $fee_pending_status = 1;
                                        } 
                                        $db_save_status = true;
                                    }
                                }else{
                                    if(empty($isAlreadyPaid)){
                                    $pending_amt = $fee_structure_amt;
                                    $paid_amt = 0;
                                    $fee_pending_status = 1;
                                    $db_save_status = true;
                                    }
                                }
                                if($db_save_status){
                                    $feeReceiptPayment = array(
                                        'application_no' => $paid->application_no,
                                        'receipt_number' => $paid->receipt_number,
                                        'payment_date' => date('Y-m-d',strtotime($paid->payment_date)), 
                                        'fee_type_id' => $fee->row_id,
                                        'paid_amount' => $paid_amt,
                                        'pending_amt' => $pending_amt,
                                        'pending_status' => $fee_pending_status,
                                        'school_account_id' => $fee->account_row_id,
                                        'created_by' => 'schoolphins',
                                        'fee_amount' => $fee_structure_amt,
                                        'created_date_time' => date('Y-m-d H:i:s'));
                                        
                                    $receipt_return_feeType = $this->fee->addReceiptFeeType($feeReceiptPayment);
                                }
                            
                            }
        
                        }
                    }
                   
                    
                    
}
  



// I PUC 2021 ADMISSION PAYMENT

  //fee payment proceed in portal
    
// public function newAdm_feePayNow(){
//     if ($this->isAdmin() == true ) {
//         $this->loadThis();
//     } else {
//         $data['fee_pending_status'] = false; 
//         //$data['allStudentInfo'] = $this->student->getAllStudentsInfo();
//        //  $data['studentInfoSelection'] = $this->student->getAllFirstYearStudent();
//         $data['allStudentInfo'] = $this->admission->getFirstYearStudentsInfo();
//         $this->global['pageTitle'] = ''.TAB_TITLE.' : Pay Now';
//         $this->loadViews("fees/newAdmPaymentPortal", $this->global, $data, null);
//     }
// }


// public function getNewAdm_StudentFeePaymentInfo(){
//     if ($this->isAdmin() == true ) {
//         $this->loadThis();
//     } else {
       
//         //$student_id = $this->security->xss_clean($this->input->post('student_id'));
//         $term_name = 'I PUC'; 
//         $application_no = $this->security->xss_clean($this->input->post('application_no')); 
//         if(empty($application_no)){
//             $application_no = $_SESSION["FEE_STUDENT_ID"];
//            // $term_name = $_SESSION["FEE_TERM_NAME"];
//         }
//         $studentInfo = $this->admission->getStudentStudentInfo($application_no);
        
//         $filter = array();
  
//         $data['application_no'] = $application_no;
//         $data['term_name'] = $term_name;
//         $filter['stream_name'] = $studentInfo->stream_name;
        
//         if(strtoupper($studentInfo->elective_sub) == 'FRENCH'){
//             $filter['lang_fee_status'] = true;
//         }else{
//             $filter['lang_fee_status'] = false;
//         }
//         $filter['category'] = strtoupper($studentInfo->category);
//         $boardInfo = $this->admission->getStudentRegisteredInfo($studentInfo->registered_row_id);
//         $data['board_id'] = $boardInfo->sslc_board_name_id;
//         if($boardInfo->sslc_board_name_id == 1){
//             $filter['board_name'] = "SSLC";
//            }else{
//             $filter['board_name'] = "OTHER";
//            }
//         $data['board_id'] = $boardInfo->sslc_board_name_id;
//         $filter['term_name'] = 'I PUC';
//         $filter['fee_year'] = CURRENT_YEAR;
//         $data['fee_year'] = CURRENT_YEAR;
//         $total_fee = $this->fee->getTotalFeeAmount($filter);
//         $total_fee_to_pay = $data['total_fee'] = $total_fee->total_fee;
//         $data['feePaidInfo'] = $this->fee->getFeePaidInfo_NewAdm_2021($application_no);
//         if(!empty($data['feePaidInfo'])){
//             foreach($data['feePaidInfo'] as $fee){
//                 $total_fee_to_pay = $total_fee_to_pay - $fee->paid_amount;
//             }
//         }
//         $data['balance'] = $total_fee_to_pay;

//         $data['studentInfo'] = $studentInfo;
        
//         $data['allStudentInfo'] = $this->admission->getFirstYearStudentsInfo();
//         $this->global['pageTitle'] = TAB_TITLE.' : Fee Payment' ;
//         $this->loadViews("fees/newAdmPaymentPortal", $this->global, $data, null);
//     }
// }

// public function newAdm_AddFeePaymentInfo(){
//     if($this->isAdmin() == TRUE){
//         $this->loadThis();
//     } else {  
//         $filter = array();
//         $term_name = $this->security->xss_clean($this->input->post('term_name')); 
        
//         $application_no = $this->security->xss_clean($this->input->post('application_no'));

//         $paid_fee_amount = $this->security->xss_clean($this->input->post('paid_fee_amount'));
//         $payment_type = $this->security->xss_clean($this->input->post('payment_type'));

//         $dd_number = $this->security->xss_clean($this->input->post('dd_number'));
//         $dd_date = $this->security->xss_clean($this->input->post('dd_date'));
//         $bank_name = $this->security->xss_clean($this->input->post('bank_name'));

//         $tran_number = $this->security->xss_clean($this->input->post('tran_number'));
//         $tran_date = $this->security->xss_clean($this->input->post('tran_date'));
//         $tran_bank_name = $this->security->xss_clean($this->input->post('tran_bank_name'));

//         $payment_date = $this->security->xss_clean($this->input->post('transaction_date'));

//         $excess_amount = $this->security->xss_clean($this->input->post('excess_amount'));
//         $_SESSION["FEE_STUDENT_ID"] = $application_no;
//         $_SESSION["FEE_TERM_NAME"] = $term_name;


//         $filter['student_id'] = $student_id;
//         $studentInfo = $this->admission->getStudentStudentInfo($application_no);
      
//             $feePaymentInfo = $this->fee->getStdPaidDetailsByApplicationNo_newADM($studentInfo->application_number);
//             if(empty($feePaymentInfo)){
//                 $paid_count = 1;
//             }else{
//                 $paid_count = $feePaymentInfo->payment_count+1;
//             }
//             $filter['term_name'] = 'I PUC';
//             $filter['stream_name'] = $studentInfo->stream_name;
        
//             if(strtoupper($studentInfo->elective_sub) == 'FRENCH'){
//                 $filter['lang_fee_status'] = true;
//             }else{
//                 $filter['lang_fee_status'] = false;
//             }
//             $filter['category'] = strtoupper($studentInfo->category);
//             $boardInfo = $this->admission->getStudentRegisteredInfo($studentInfo->registered_row_id);
//             $data['board_id'] = $boardInfo->sslc_board_name_id;
//             if($boardInfo->sslc_board_name_id == 1){
//                 $filter['board_name'] = "SSLC";
//             }else{
//                 $filter['board_name'] = "OTHER";
//             }
//             $data['feePaidInfo'] = $this->fee->getFeePaidInfo_NewAdm_2021($application_no);
//             $filter['fee_year'] = '2021';
//             $data['fee_year'] = '2021';
//             $total_fee = $this->fee->getTotalFeeAmount($filter);
//             $feeStructureInfo = $this->fee->getFeeStructureInfo2021($filter);
//             $total_fee_to_pay = $total_fee->total_fee;
//             $data['total_fee'] = $total_fee->total_fee;
//             if(!empty($data['feePaidInfo'])){
//                 foreach($data['feePaidInfo'] as $fee){
//                     $total_fee_to_pay = $total_fee_to_pay - $fee->paid_amount;
//                 }
//             }

//             $pending_fee_balance = $total_fee_to_pay - $paid_fee_amount;
//             if($pending_fee_balance <= 0){
//                 $fee_excess_amount = abs($pending_fee_balance);
//                 $fee_pending_status = 0;
//             }else if($pending_fee_balance > 0){
//                 $fee_excess_amount = 0;
//                 $fee_pending_status = 1;
//             }
           
//             $overallFee = array(
//                 'application_no' => $studentInfo->application_number,
//                 'payment_type' => $payment_type,
//                 'payment_date' => date('Y-m-d',strtotime($payment_date)),
//                 'total_amount' => $total_fee->total_fee,
//                 'paid_amount' => $paid_fee_amount,
//                 'excess_amount' => $fee_excess_amount,
//                 'fee_concession' => 0,
//                 'pending_balance' => abs($pending_fee_balance),
//                 'fee_pending_status' => $fee_pending_status,
//                 'payment_count' => $paid_count,
//                 'created_by' => $this->staff_id,
//                 'created_date_time' => date('Y-m-d H:i:s'));
//                 $fee_year= 2021;
//                 $receipt_number = $this->fee->addFeeDetailsNewAdmission_2021($overallFee);

//                 $fee_amount_balance_pending = $paid_fee_amount;
//                 $remaining_fee_amt = $paid_fee_amount;
//                 foreach($feeStructureInfo as $fee){
//                     $db_save_status = false;
//                     $fee_structure_amt = $fee->fee_amount_state_board;
//                     $isAlreadyPaid = $this->fee->checkFeeTypeIsAlreadyPaid($studentInfo->application_number,$fee->row_id);
//                     if($remaining_fee_amt >= 0){
//                         if(!empty($isAlreadyPaid)){
//                             if($isAlreadyPaid->pending_status == 1){
//                                 $remaining_fee_amt -= $isAlreadyPaid->pending_amt;
//                                 if($remaining_fee_amt >= 0){
//                                     //$pending_amount = 0;
//                                     $paid_amt = $isAlreadyPaid->pending_amt;
//                                     $pending_amt = 0;
//                                     $fee_pending_status = 0;
//                                 } else {
//                                     //$dd_amount = 0; 
//                                     $paid_amt = $isAlreadyPaid->pending_amt - abs($remaining_fee_amt);
//                                     $pending_amt = $isAlreadyPaid->pending_amt - $paid_amt;
//                                     $fee_pending_status = 1;
//                                 } 
//                                 $db_save_status = true;
//                             }
//                         }else{
//                             $remaining_fee_amt -= $fee_structure_amt;
//                             if($remaining_fee_amt >= 0){
//                                 //$pending_amount = 0;
//                                 $paid_amt = $fee_structure_amt;
//                                 $pending_amt = 0;
//                                 $fee_pending_status = 0;
//                             } else {
//                                 //$dd_amount = 0; 
//                                 $paid_amt = $fee_structure_amt - abs($remaining_fee_amt);
//                                 $pending_amt = $fee_structure_amt - $paid_amt;
//                                 $fee_pending_status = 1;
//                             } 
//                             $db_save_status = true;
//                         }
//                     }else{
//                         if(empty($isAlreadyPaid)){
//                         $pending_amt = $fee_structure_amt;
//                         $paid_amt = 0;
//                         $fee_pending_status = 1;
//                         $db_save_status = true;
//                         }
//                     }
//                     if($db_save_status){
//                         $feeReceiptPayment = array(
//                             'application_no' => $studentInfo->application_number,
//                             'receipt_number' => $receipt_number,
//                             'payment_date' => date('Y-m-d',strtotime($payment_date)), 
//                             'fee_type_id' => $fee->row_id,
//                             'paid_amount' => $paid_amt,
//                             'pending_amt' => $pending_amt,
//                             'pending_status' => $fee_pending_status,
//                             'school_account_id' => $fee->account_row_id,
//                             'created_by' => 'schoolphins',
//                             'fee_amount' => $fee_structure_amt,
//                             'created_date_time' => date('Y-m-d H:i:s'));
                            
//                         $receipt_return_feeType = $this->fee->addReceiptFeeType($feeReceiptPayment);
//                     }
                
//                 }
        
  
       
        
//         if(!empty($receipt_number)){
//             if($payment_type == 'DD'){
//                 $ddInfo = array(
//                     'application_no' => $studentInfo->application_number,
//                     'fee_year' => $fee_year,
//                     'receipt_number' => $receipt_number,
//                     'dd_number' => $dd_number,
//                     'dd_date' => date('Y-m-d',strtotime($dd_date)),
//                     'bank_name' => $bank_name,
//                     'created_by' => $this->staff_id,
//                     'created_date_time' => date('Y-m-d H:i:s')
//                 );
//                 $this->fee->addDDInfo($ddInfo);
//             }else if($payment_type == 'CARD'){
//                 $bankInfo = array(
//                     'application_no' => $studentInfo->application_number,
//                     'receipt_number' => $receipt_number,
//                     'transaction_number' => $tran_number,
//                     'transaction_date' => date('Y-m-d',strtotime($tran_date)),
//                     'bank_name' => $tran_bank_name,
//                     'created_by' => $this->staff_id,
//                     'created_date_time' => date('Y-m-d H:i:s')
//                 );
//                 $this->fee->addBankInfo($bankInfo);
//             }
//             $this->session->set_flashdata('success', 'Fee Paid Successfully');
//             // redirect('feePaymentReceiptPrint/'.$receipt_number); 
//             $applicationStatus = array(
//                 'joined_status' => 1,
//                 'admission_status'=> 1,
//                 'updated_date_time' => date('Y-m-d H:i:s'));
//            $this->admission->updateStudentApplicationStatus($studentInfo->application_number,$applicationStatus);
//         }else{
//             $this->session->set_flashdata('error', 'Fee Payment Failed!');
//         }
//         redirect('getNewAdm_StudentFeePaymentInfo'); 
//     }
// }

    // re-admission order id process
    // public function reAdmissionOrderIdProcess(){
    //     $paytmChecksum = "";
    //     $paramList = array();
    //     $isValidChecksum = "FALSE";
    //     $order_id = $this->security->xss_clean($this->input->post('order_id'));
    //     $order_id = strtoupper($order_id);
    //     $paytmInfo = $this->fee->getReadmissionPayTmLogByAppNo($order_id);
    //     if(!empty($paytmInfo)){
           
    //         $application_no = $paytmInfo->student_id;
    //         $studentInfo = $this->student->getStudentsInfoByApplicationNumber($application_no);

    //         $requestParamList = array("MID" => PAYTM_MERCHANT_MID , "ORDERID" => $order_id);  

    //         // $paid_fee_amount = 15000;
    //         $filter = array();
    //         $filter['stream_name'] = $studentInfo->stream_name;
    //         $filter['term_name'] = $studentInfo->term_name;
    //         $filter['fee_year'] = CURRENT_YEAR;
    //         if(strtoupper($studentInfo->elective_sub) == 'FRENCH'){
    //             $filter['lang_fee_status'] = true;
    //         }else{
    //             $filter['lang_fee_status'] = false;
    //         }
    //        // $catInfo = $this->admission_model->getStudentCategoryByApplicationNum($studentInfo->application_no);
    //         $filter['category'] = strtoupper($studentInfo->category);
           
           
    //         $totalFeeObj = $this->fee->getTotalFeeAmount($filter);
    //         $feeStructureInfo = $this->fee->getFeeStructureInfo2021($filter);
    //         $total_fee_pending_to_pay = $totalFeeObj->total_fee;
           
          
    //         $StatusCheckSum = getChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY);
            
    //         $requestParamList['CHECKSUMHASH'] = $StatusCheckSum;
    
    //         // Call the PG's getTxnStatusNew() function for verifying the transaction status.
    //         $_POST = getTxnStatusNew($requestParamList);
          
                
    //         $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
    //         $data['application_applied_status'] = false;
    //         //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
    //         $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
    //         $data['isValidChecksum'] = $isValidChecksum;
    //         $data['paramList'] = $paramList;
    //         $data['payment_status'] = false;
    //         $data['payment_done_now'] = false;
    //         // $total_fee_pending_to_pay = $total_fee;
    //         $paid_fee_amount = $_POST['TXNAMOUNT'];
    //         if($isValidChecksum == true){ 
    //             if($_POST['STATUS'] == 'TXN_SUCCESS'){ 
    //                 $isExists = $this->fee->checkReAdmissionOrderIdExists($order_id);
    //                 if(empty($isExists)){
    //                     $totalPaid = $this->fee->getReAdmissionTotalPaidAmount($application_no);
    //                     if($totalPaid->paid_amount != 0){
    //                         $total_fee_pending_to_pay -= $totalPaid->paid_amount;
    //                     }
                        
    //                     $pending_fee_balance = $total_fee_pending_to_pay - $paid_fee_amount;
    //                     if($pending_fee_balance <= 0){
    //                         $fee_excess_amount = abs($pending_fee_balance);
    //                         $fee_pending_status = 0;
    //                     }else if($pending_fee_balance > 0){
    //                         $fee_excess_amount = 0;
    //                         $fee_pending_status = 1;
    //                     }
    //                     $feePaymentInfo = $this->fee->getReadmission_FeePaidDetailsByApplicationNo($studentInfo->application_no);
    //                     if(empty($feePaymentInfo)){
    //                         $paid_count = 1;
    //                     }else{
    //                         $paid_count = $feePaymentInfo->payment_count+1;
    //                     }

    //                     $receipt_no = $this->fee->getLastReceiptNoFromOverall($filter['term_name']);
    //                     if(empty($receipt_no)){
    //                         $receipt_no = 0;
    //                     }
    //                     $receipt_no += 1;
    //                     $receipt_no = sprintf('%04d', $receipt_no);

    //                     $overallFee = array(
    //                         'receipt_number'=> $receipt_no,
    //                         'application_no' => $studentInfo->application_no,
    //                         'payment_type' => 'ONLINE',
    //                         'payment_date' => date('Y-m-d',strtotime($_POST['TXNDATE'])),
    //                         'total_amount' => $total_fee_pending_to_pay,
    //                         'paid_amount' => $paid_fee_amount,
    //                         'excess_amount' => $fee_excess_amount,
    //                         'fee_concession' => 0,
    //                         'payment_year' => CURRENT_YEAR,
    //                         'term_name' => $studentInfo->term_name,
    //                         'pending_balance' => $pending_fee_balance,
    //                         'fee_pending_status' => $fee_pending_status,
    //                         'payment_count' => $paid_count,
    //                         'order_id' => $_POST["ORDERID"],
    //                         'collected_staff_name' => 'schoolphins',
    //                         'created_by' => $studentInfo->application_no,
    //                         'created_date_time' => date('Y-m-d H:i:s'));

    //                     $receipt_number = $this->fee->addReadmission_FeeDetailsInfo($overallFee);
    //                     $installmentAmtExist = $this->fee->checkInstallmentAlreadyExistNew($studentInfo->application_no);
    //                     if(!empty($installmentAmtExist)){
    //                         $instalUpdate = array(
    //                             'payment_status' =>1,
    //                             'amount' => $_POST['TXNAMOUNT'],
    //                             'receipt_number' => $receipt_number,
    //                             'updated_by' => $studentInfo->application_no,
    //                             'updated_date_time' => date('Y-m-d H:i:s')
    //                         );
    //                         $this->fee->updateInstalmentNew($instalUpdate, $studentInfo->application_no);
    //                     }
                    
    //                     $paymentLogUpdate = array(
    //                         'payment_mode' => $_POST['PAYMENTMODE'],
    //                         'reference_number'=>$_POST['TXNID'],
    //                         'payment_status' =>'SUCCESS',
    //                         'receipt_number' =>$receipt_number,
    //                         'amount_pending' =>$pending_fee_balance,
    //                         'fee_amount' => $_POST['TXNAMOUNT'],
    //                         'updated_by' => $studentInfo->application_no,
    //                         'updated_date_time' => date('Y-m-d H:i:s')
    //                     );
    //                         $fee_amount_balance_pending = $paid_fee_amount;
    //                         $remaining_fee_amt = $paid_fee_amount;
    //                         foreach($feeStructureInfo as $fee){
    //                             $db_save_status = false;
    //                             $fee_structure_amt = $fee->fee_amount_state_board;
    //                             $isAlreadyPaid = $this->fee->checkFeeTypeIsAlreadyPaid($studentInfo->application_no,$fee->row_id);
    //                             if($remaining_fee_amt >= 0){
    //                                 if(!empty($isAlreadyPaid)){
    //                                     if($isAlreadyPaid->pending_status == 1){
    //                                         $remaining_fee_amt -= $isAlreadyPaid->pending_amt;
    //                                         if($remaining_fee_amt >= 0){
    //                                             //$pending_amount = 0;
    //                                             $paid_amt = $isAlreadyPaid->pending_amt;
    //                                             $pending_amt = 0;
    //                                             $fee_pending_status = 0;
    //                                         } else {
    //                                             //$dd_amount = 0; 
    //                                             $paid_amt = $isAlreadyPaid->pending_amt - abs($remaining_fee_amt);
    //                                             $pending_amt = $isAlreadyPaid->pending_amt - $paid_amt;
    //                                             $fee_pending_status = 1;
    //                                         } 
    //                                         $db_save_status = true;
    //                                     }
    //                                 }else{
    //                                     $remaining_fee_amt -= $fee_structure_amt;
    //                                     if($remaining_fee_amt >= 0){
    //                                         //$pending_amount = 0;
    //                                         $paid_amt = $fee_structure_amt;
    //                                         $pending_amt = 0;
    //                                         $fee_pending_status = 0;
    //                                     } else {
    //                                         //$dd_amount = 0; 
    //                                         $paid_amt = $fee_structure_amt - abs($remaining_fee_amt);
    //                                         $pending_amt = $fee_structure_amt - $paid_amt;
    //                                         $fee_pending_status = 1;
    //                                     } 
    //                                     $db_save_status = true;
    //                                 }
    //                             }else{
    //                                 if(empty($isAlreadyPaid)){
    //                                 $pending_amt = $fee_structure_amt;
    //                                 $paid_amt = 0;
    //                                 $fee_pending_status = 1;
    //                                 $db_save_status = true;
    //                                 }
    //                             }
    //                             if($db_save_status){
    //                                 $feeReceiptPayment = array(
    //                                     'application_no' => $studentInfo->application_no,
    //                                     'receipt_number' => $receipt_number,
    //                                     'payment_date' => date('Y-m-d',strtotime($_POST['TXNDATE'])), 
    //                                     'fee_type_id' => $fee->row_id,
    //                                     'paid_amount' => $paid_amt,
    //                                     'pending_amt' => $pending_amt,
    //                                     'pending_status' => $fee_pending_status,
    //                                     'school_account_id' => $fee->account_row_id,
    //                                     'created_by' => 'schoolphins',
    //                                     'fee_amount' => $fee_structure_amt,
    //                                     'created_date_time' => date('Y-m-d H:i:s'));
                                        
    //                                 $receipt_return_feeType = $this->fee->addReceiptFeeType2021($feeReceiptPayment);
    //                             }
                            
    //                         }
                                
    //                         $this->session->set_flashdata('success', 'Order ID processed successfully '); 
                        
    //                     }else{
    //                         $paymentLogUpdate = array(
    //                             'payment_mode' => $_POST['PAYMENTMODE'],
    //                             'reference_number'=>$_POST['TXNID'],
    //                             'payment_status' =>'SUCCESS',
    //                             'receipt_number' =>$receipt_number,
    //                             'amount_pending' =>$pending_fee_balance,
    //                             'fee_amount' => $_POST['TXNAMOUNT'],
    //                             'updated_by' => $studentInfo->application_no,
    //                             'updated_date_time' => date('Y-m-d H:i:s'));
    //                         $this->session->set_flashdata('success', 'Order ID already exists'); 
    //                     }
    //                 }else{
    //                     $paymentLogUpdate = array(
    //                         'payment_status' =>'FAILED',
    //                         'fee_amount' => $_POST['TXNAMOUNT'],
    //                         'updated_by' => $studentInfo->application_no,
    //                         'updated_date_time' => date('Y-m-d H:i:s')
    //                     );
    //                     $this->session->set_flashdata('error', 'Payment checksum is failed.'); 
    //                 }
    //                 $this->fee->updateReadmission_PaymentLogByOrderIdPaytm($paymentLogUpdate, $_POST["ORDERID"]);
    //             }
                
    //         }else{
    //             $this->session->set_flashdata('success', 'Order ID already processed'); 
    //         }
    //     redirect('getAllFeePaymentInfo');
    // }

    // // New admissio order id process
    // public function newAdmissionOrderIdProcess(){
    //     $paytmChecksum = "";
    //     $paramList = array();
    //     $isValidChecksum = "FALSE";
    //     $order_id = $this->security->xss_clean($this->input->post('order_id'));
    //     $order_id = strtoupper($order_id);
    //     $paytmInfo = $this->fee->getAdmissionPayTmLogByOrderId($order_id);
    //     if(!empty($paytmInfo)){
           
    //         $application_no = $paytmInfo->student_id;
    //         $studentInfo = $this->admission->getStudentStudentInfo($application_no);
    //         // log_message('debug','tetst'.print_r($studentInfo,true));

    //         $requestParamList = array("MID" => PAYTM_MERCHANT_MID , "ORDERID" => $order_id);  

    //         $filter = array();
    //         $filter['term_name'] = 'I PUC';
    //         $filter['stream_name'] = $studentInfo->stream_name;
        
    //         if(strtoupper($studentInfo->elective_sub) == 'FRENCH'){
    //             $filter['lang_fee_status'] = true;
    //         }else{
    //             $filter['lang_fee_status'] = false;
    //         }
    //         $filter['category'] = strtoupper($studentInfo->category);
    //         $boardInfo = $this->admission->getStudentRegisteredInfo($studentInfo->registered_row_id);
    //         $data['board_id'] = $boardInfo->sslc_board_name_id;
    //         if($boardInfo->sslc_board_name_id == 1){
    //             $filter['board_name'] = "SSLC";
    //         }else{
    //             $filter['board_name'] = "OTHER";
    //         }
          
    //         $StatusCheckSum = getChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY);
            
    //         $requestParamList['CHECKSUMHASH'] = $StatusCheckSum;
    
    //         // Call the PG's getTxnStatusNew() function for verifying the transaction status.
    //         $_POST = getTxnStatusNew($requestParamList);
          
                
    //         $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
    //         $data['application_applied_status'] = false;
    //         //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
    //         $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
    //         $data['isValidChecksum'] = $isValidChecksum;
    //         $data['paramList'] = $paramList;
    //         $data['payment_status'] = false;
    //         $data['payment_done_now'] = false;
    //         // $total_fee_pending_to_pay = $total_fee;
    //         $paid_fee_amount = $_POST['TXNAMOUNT'];
    //         if($isValidChecksum == true){ 
    //             if($_POST['STATUS'] == 'TXN_SUCCESS'){ 
    //                 $isExists = $this->fee->checkAdmissionOrderIdExists($order_id);
    //                 if(empty($isExists)){
    //                     $feePaymentInfo = $this->fee->getStdPaidDetailsByApplicationNo_newADM($studentInfo->application_number);
    //                     if(empty($feePaymentInfo)){
    //                         $paid_count = 1;
    //                     }else{
    //                         $paid_count = $feePaymentInfo->payment_count+1;
    //                     }
                    
    //                     $data['feePaidInfo'] = $this->fee->getFeePaidInfo_NewAdm_2021($application_no);
    //                     $filter['fee_year'] = CURRENT_YEAR;
    //                     $data['fee_year'] = CURRENT_YEAR;
    //                     $total_fee = $this->fee->getTotalFeeAmount($filter);
    //                     $feeStructureInfo = $this->fee->getFeeStructureInfo2021($filter);
    //                     $total_fee_to_pay = $total_fee->total_fee;
    //                     $data['total_fee'] = $total_fee->total_fee;
    //                     if(!empty($data['feePaidInfo'])){
    //                         foreach($data['feePaidInfo'] as $fee){
    //                             $total_fee_to_pay = $total_fee_to_pay - $fee->paid_amount;
    //                         }
    //                     }
            
    //                     $pending_fee_balance = $total_fee_to_pay - $paid_fee_amount;
    //                     if($pending_fee_balance <= 0){
    //                         $fee_excess_amount = abs($pending_fee_balance);
    //                         $fee_pending_status = 0;
    //                     }else if($pending_fee_balance > 0){
    //                         $fee_excess_amount = 0;
    //                         $fee_pending_status = 1;
    //                     }

    //                     $receipt_no = $this->fee->getLastReceiptNoFromOverall($filter['term_name']);
    //                     if(empty($receipt_no)){
    //                         $receipt_no = 0;
    //                     }
    //                     $receipt_no += 1;
    //                     $receipt_no = sprintf('%04d', $receipt_no);
                    
    //                     $overallFee = array(
    //                         'receipt_number'=> $receipt_no,
    //                         'application_no' => $studentInfo->application_number,
    //                         'payment_type' => 'ONLINE',
    //                         'payment_date' => date('Y-m-d',strtotime($_POST['TXNDATE'])),
    //                         'total_amount' => $total_fee->total_fee,
    //                         'paid_amount' => $paid_fee_amount,
    //                         'excess_amount' => $fee_excess_amount,
    //                         'fee_concession' => 0,
    //                         'pending_balance' => abs($pending_fee_balance),
    //                         'fee_pending_status' => $fee_pending_status,
    //                         'payment_year' => CURRENT_YEAR,
    //                         'term_name' => 'I PUC',
    //                         'payment_count' => $paid_count,
    //                         'order_id' => $_POST["ORDERID"],
    //                         'created_by' => $this->staff_id,
    //                         'created_date_time' => date('Y-m-d H:i:s'));
    //                         $fee_year= 2022;
    //                         $receipt_number = $this->fee->addFeeDetailsNewAdmission_2021($overallFee);
    //                         // log_message('debug','bcbc'.print_r($overallFee,true));

                            
    //                     $paymentLogUpdate = array(
    //                         'payment_mode' => $_POST['PAYMENTMODE'],
    //                         'reference_number'=>$_POST['TXNID'],
    //                         'payment_status' =>'SUCCESS',
    //                         'receipt_number' =>$receipt_number,
    //                         'amount_pending' =>$pending_fee_balance,
    //                         'fee_amount' => $_POST['TXNAMOUNT'],
    //                         'updated_by' => $studentInfo->application_no,
    //                         'updated_date_time' => date('Y-m-d H:i:s'));
            
    //                         $fee_amount_balance_pending = $paid_fee_amount;
    //                         $remaining_fee_amt = $paid_fee_amount;
    //                         foreach($feeStructureInfo as $fee){
    //                             $db_save_status = false;
    //                             $fee_structure_amt = $fee->fee_amount_state_board;
    //                             $isAlreadyPaid = $this->fee->checkFeeTypeIsAlreadyPaid($studentInfo->application_number,$fee->row_id);
    //                             if($remaining_fee_amt >= 0){
    //                                 if(!empty($isAlreadyPaid)){
    //                                     if($isAlreadyPaid->pending_status == 1){
    //                                         $remaining_fee_amt -= $isAlreadyPaid->pending_amt;
    //                                         if($remaining_fee_amt >= 0){
    //                                             //$pending_amount = 0;
    //                                             $paid_amt = $isAlreadyPaid->pending_amt;
    //                                             $pending_amt = 0;
    //                                             $fee_pending_status = 0;
    //                                         } else {
    //                                             //$dd_amount = 0; 
    //                                             $paid_amt = $isAlreadyPaid->pending_amt - abs($remaining_fee_amt);
    //                                             $pending_amt = $isAlreadyPaid->pending_amt - $paid_amt;
    //                                             $fee_pending_status = 1;
    //                                         } 
    //                                         $db_save_status = true;
    //                                     }
    //                                 }else{
    //                                     $remaining_fee_amt -= $fee_structure_amt;
    //                                     if($remaining_fee_amt >= 0){
    //                                         //$pending_amount = 0;
    //                                         $paid_amt = $fee_structure_amt;
    //                                         $pending_amt = 0;
    //                                         $fee_pending_status = 0;
    //                                     } else {
    //                                         //$dd_amount = 0; 
    //                                         $paid_amt = $fee_structure_amt - abs($remaining_fee_amt);
    //                                         $pending_amt = $fee_structure_amt - $paid_amt;
    //                                         $fee_pending_status = 1;
    //                                     } 
    //                                     $db_save_status = true;
    //                                 }
    //                             }else{
    //                                 if(empty($isAlreadyPaid)){
    //                                 $pending_amt = $fee_structure_amt;
    //                                 $paid_amt = 0;
    //                                 $fee_pending_status = 1;
    //                                 $db_save_status = true;
    //                                 }
    //                             }
    //                             if($db_save_status){
    //                                 $feeReceiptPayment = array(
    //                                     'application_no' => $studentInfo->application_number,
    //                                     'receipt_number' => $receipt_number,
    //                                     'payment_date' => date('Y-m-d',strtotime($_POST['TXNDATE'])), 
    //                                     'fee_type_id' => $fee->row_id,
    //                                     'paid_amount' => $paid_amt,
    //                                     'pending_amt' => $pending_amt,
    //                                     'pending_status' => $fee_pending_status,
    //                                     'school_account_id' => $fee->account_row_id,
    //                                     'created_by' => 'schoolphins',
    //                                     'fee_amount' => $fee_structure_amt,
    //                                     'created_date_time' => date('Y-m-d H:i:s'));
                                        
    //                                 $receipt_return_feeType = $this->fee->addReceiptFeeType($feeReceiptPayment);
    //                             }
                            
    //                         }

    //                         $applicationStatus = array(
    //                             'joined_status' => 1,
    //                             'admission_status'=> 1,
    //                             'updated_date_time' => date('Y-m-d H:i:s'));
    //                         $this->admission->updateStudentApplicationStatus($studentInfo->application_number,$applicationStatus);
                              
    //                         $this->session->set_flashdata('success', 'Order ID processed successfully '); 
    //                     }else{
    //                         $paymentLogUpdate = array(
    //                             'payment_mode' => $_POST['PAYMENTMODE'],
    //                             'reference_number'=>$_POST['TXNID'],
    //                             'payment_status' =>'SUCCESS',
    //                             'receipt_number' =>$receipt_number,
    //                             'amount_pending' =>$pending_fee_balance,
    //                             'fee_amount' => $_POST['TXNAMOUNT'],
    //                             'updated_by' => $studentInfo->application_no,
    //                             'updated_date_time' => date('Y-m-d H:i:s'));
    //                         $this->session->set_flashdata('success', 'Order ID already exists'); 
    //                     }
                    
    //                 }else{
    //                     $paymentLogUpdate = array(
    //                         'payment_status' =>'FAILED',
    //                         'fee_amount' => $_POST['TXNAMOUNT'],
    //                         'updated_by' => $studentInfo->application_no,
    //                         'updated_date_time' => date('Y-m-d H:i:s')
    //                     );
    //                     $this->session->set_flashdata('error', 'Payment checksum is failed.'); 
    //                 }
    //                 $this->fee->updatePaymentLogByOrderId($paymentLogUpdate, $_POST["ORDERID"]);
    //             }
                
    //         }else{
    //             $this->session->set_flashdata('success', 'Order ID already processed'); 
    //         }
    //     redirect('getAllFeePaymentInfo');
    // }

            
    public function newFeePayNow(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $data['fee_pending_status'] = false; 
        //  $data['studentInfoSelection'] = $this->student->getAllFirstYearStudent();
            $data['newStdInfo'] = $this->admission->getFirstYearStudentsInfo();
            $data['allStudentInfo'] = $this->student->getAllStudentsInfo();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Pay Now';
            $this->loadViews("fees/newPaymentPortal", $this->global, $data, null);
        }
    }


    public function getNewStudentFeePaymentInfo(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            
            $application_no = $this->security->xss_clean($this->input->post('application_no'));
           
            //check student exist in student info table(persuing students)
            if(empty($application_no)){
                $application_no = $_SESSION["FEE_STUDENT_ID"];
            }
            $studentInfo =  $this->student->getStudentInfoByRowId($application_no);
            // if(empty($studentInfo)){
            //     //check student exist in new admission info
            //     $studentInfo = $this->admission->getStudentStudentInfo($application_no);
            // }
            $filter = array(); 
          

            if(!empty($studentInfo)){
                $term_name = $studentInfo->term_name;
               
                $data['application_no'] = $application_no;
                $data['term_name'] = $term_name;
                $filter['stream_name'] = $studentInfo->stream_name;
                $data['std_status'] = $studentInfo->std_status;
                
                // if(strtoupper($studentInfo->elective_sub) == 'FRENCH'){
                //     $filter['lang_fee_status'] = true;
                // }else{
                //     $filter['lang_fee_status'] = false;
                // }
                // $filter['category'] = strtoupper($studentInfo->category);
                

                if($term_name == 'I PUC'){
                    $data['text_display_view']  = "I PUC Student info";
                    // $boardInfo = $this->admission->getStudentRegisteredInfo($studentInfo->registered_row_id);
                    // $data['board_id'] = $boardInfo->sslc_board_name_id;
                    // if($boardInfo->sslc_board_name_id == 1){
                    //     $filter['board_name'] = "SSLC";
                    // }else{
                    //     $filter['board_name'] = "OTHER";
                    // }

                    $filter['term_name'] = $term_name;
                    $data['year'] = $filter['fee_year'] = CURRENT_YEAR;
                    $total_fee_obj = $this->fee->getTotalFeeAmount($filter);  
                    if($studentInfo->std_status  == 1){ //std_status = 1,then std is rejected
                        $paidFee = $this->fee->getTotalFeePaidInfo($application_no,CURRENT_YEAR);
                        $total_fee_amount = $paidFee;
                    }else{      
                        $total_fee_amount = $data['total_fee_amount'] = $total_fee_obj->total_fee;
                    }
                    $paidFee = $this->fee->getTotalFeePaidInfo($application_no,CURRENT_YEAR);
                    $paid = $this->fee->getFeePaidInfoAttempt($application_no,CURRENT_YEAR);
                    $data['feePaidInfo'] = $this->fee->getFeePaidInfo($application_no,CURRENT_YEAR);
                    $data['fee_installment'] = $this->fee->checkInstalmentExists($application_no);
                    $data['paid_amount'] = $paidFee;
                    $concession_amt = 0;
                    $feeConcession = $this->fee->getStudentFeeConcession($application_no);
                    // log_message('debug','concession'.print_r($application_no,true));
                    if(!empty($feeConcession)){
                        $concession_amt = $feeConcession->fee_amt;
                        $total_fee_amount -= $concession_amt;
                    }

                    $scholarship_amt = 0;
                    $feeScholarship = $this->fee->getStudentFeeScholarship($application_no);
                    if(!empty($feeScholarship)){
                        $scholarship_amt = $feeScholarship->fee_amt;
                        $total_fee_amount -= $scholarship_amt;
                    }
                    
                        $total_fee_amount -= $paidFee;
                        if($paid->attempt == '1'){
                            $total_fee_amount = $total_fee_amount -2000;
                        }else{
                            $total_fee_amount =$total_fee_amount;
                        }
                  
                    $data['previousBal'] = $data['first_puc_pending_amount'] = $data['pending_amount'] = $total_fee_amount;
                    $data['I_balance'] = $total_fee_amount;
                    $data['concession'] = $concession_amt;
                    $data['scholarship'] = $scholarship_amt;
                    $data['balance'] = 0;
                    }else{
                    //$prev_year = trim($studentInfo->intake_year_id)-1;
                    // this will execute if student only II PUC
                    //------ I PUC PENDING START
                       $data['text_display_view']  = "II PUC Student info";
                    
                        $filter['term_name'] = 'I PUC';
                        $data['year']=$filter['fee_year'] = trim($studentInfo->intake_year_id);
                        if($studentInfo->intake_year_id == 2023){
                            $total_fee_obj = $this->fee->getTotalFeeAmount($filter);
                            $data['first_puc_total_fee'] = $first_puc_total_bal = $total_fee_obj->total_fee;
                        }else{
                            $total_fee_obj = $this->fee->getfirstpucbal($application_no);
                            $data['first_puc_total_fee'] = $first_puc_total_bal = $total_fee_obj->amount;
                        }
                        // $total_fee_obj = $this->fee->getTotalFeeAmount($filter);

                        // $data['first_puc_total_fee'] = $first_puc_total_bal = $total_fee_obj->total_fee;
                        $paid = $this->fee->getFeePaidInfoAttempt($application_no,$filter['fee_year']);
                    
                        $paidFee = $this->fee->getTotalFeePaidInfo($application_no,$filter['fee_year']);
                        $data['feePaidInfo'] = $this->fee->getFeePaidInfo($application_no,$filter['fee_year']);
                       

                        $data['fee_installment'] = $this->fee->checkInstalmentExists($application_no);
                        $first_puc_total_bal -= $paidFee;
                        if($paid->attempt == '1'){
                            $first_puc_total_bal = $first_puc_total_bal -2000;    
                        }else{
                            $first_puc_total_bal =$first_puc_total_bal;
                        }
                        //if alumni first_puc_total_bal =0
                        if($studentInfo->is_active == 0 && trim($studentInfo->intake_year_id) == '2021'){
                            $first_puc_total_bal = 0;
                        }

                        //prev year fee
                        // if(trim($studentInfo->intake_year_id) == '2020'){
                        //     $paidFee = $this->fee->getTotalFeePaidInfo2020($application_no);
                        //     $data['feePaidInfo'] = $this->fee->getFeePaidInfo2020($application_no);
                        //     $first_puc_total_bal -= $paidFee;
                        // }
                        
                        $data['paid_first_puc'] = $paidFee;
                   
                            $data['I_balance'] = 0;
                            $data['first_puc_pending_amount'] = $data['previousBal'] = 0;
                
                            $data['I_balance'] = $first_puc_total_bal ;
                            $data['first_puc_pending_amount'] = $data['previousBal'] = $first_puc_total_bal;
                           
                    //I PUC PENDING END --------//

                    // II PUC fee calculation start
                    $filter['term_name'] = 'II PUC';
                    //add extra ine year to intake year only (based on clg database data)
                    $data['fee_year_II'] =  $filter['fee_year'] = trim($studentInfo->intake_year_id)+1;
                  
                    $filter['board_name'] = 'SSLC';
                    if($studentInfo->is_admitted == 1){
                        $filter['term_name'] = 'I PUC';
                        $filter['fee_year'] = CURRENT_YEAR;
                    }

                    //if alumni bal total fee pending else total fee
                    if($studentInfo->is_active == 0 && trim($studentInfo->intake_year_id) == '2021'){
                        $total_fee_obj = $this->fee->getfirstpucbal($application_no);
                        $data['second_puc_total_fee'] =  $data['total_fee_amount'] =  $total_fee_amount = $total_fee_obj->amount;

                    }else if($studentInfo->is_active == 0 && trim($studentInfo->intake_year_id) == '2022' && $studentInfo->std_status == 0){
                        $total_fee_amount = 0;
                    }else if($studentInfo->std_status  == 1){ //std_status = 1,then std is rejected
                        $paidFee = $this->fee->getTotalFeePaidInfo($application_no,$filter['fee_year']);
                        $total_fee_amount = $paidFee;
                    }else{
                        $total_fee_obj = $this->fee->getTotalFeeAmount($filter);
                        $data['second_puc_total_fee'] =  $data['total_fee_amount'] =  $total_fee_amount = $total_fee_obj->total_fee;
                    }
                    

                    $paidFee = $this->fee->getTotalFeePaidInfo($application_no,$filter['fee_year']);
                  
                    $paid = $this->fee->getFeePaidInfoAttempt($application_no,$filter['fee_year']);
                   
                    $data['II_feePaidInfo'] = $this->fee->getFeePaidInfo($application_no,$filter['fee_year']);
                    $total_fee_amount -= $paidFee;
                  
                        if($paid->attempt == '1'){
                            $total_fee_amount = $total_fee_amount -2000;    
                        }else{
                            $total_fee_amount =$total_fee_amount;
                        }

                    //prev year fee
                    // if(trim($studentInfo->intake_year_id) == '2020'){
                    //     $paidFee = $this->fee->getTotalFeePaidInfo2021($application_no);
                    //     $data['II_feePaidInfo'] = $this->fee->getFeePaidInfo2021($application_no);
                    //     $total_fee_amount -= $paidFee;
                    // }
                    $concession_amt = 0;
                    $feeConcession = $this->fee->getStudentFeeConcession($application_no);
                    if(!empty($feeConcession)){
                        $concession_amt = $feeConcession->fee_amt;
                    }

                    $scholarship_amt = 0;
                    $feeScholarship = $this->fee->getStudentFeeScholarship($application_no);
                    if(!empty($feeScholarship)){
                        $scholarship_amt = $feeScholarship->fee_amt;
                    }
                    $data['second_puc_pending_amount'] = $data['pending_amount'] = $total_fee_amount-$concession_amt-$scholarship_amt;
                    $data['paid_amount'] = $paidFee;
                  
                    //get list of payment in II PUC
                    $data['balance'] = $total_fee_amount;
                    $data['concession'] = $concession_amt;
                    $data['scholarship'] = $scholarship_amt;

                }
                // $data['balance'] = $total_fee_to_pay;
                
                $data['studentInfo'] = $studentInfo;
            }else{
                $this->session->set_flashdata('error', 'Sorry!, Student data not found!');
            }
           
            // $data['newStdInfo'] = $this->admission->getFirstYearStudentsInfo();
            $data['allStudentInfo'] = $this->student->getAllStudentsInfo();
            $this->global['pageTitle'] = TAB_TITLE.' : Fee Payment' ;
            $this->loadViews("fees/newPaymentPortal", $this->global, $data, null);
        }
    }

    public function newAddFeePaymentInfo(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {  
            $filter = array();
            $term_name = $this->security->xss_clean($this->input->post('term_name_selected')); 
          
            $application_no = $this->security->xss_clean($this->input->post('application_no'));
            $paid_fee_amount = $this->security->xss_clean($this->input->post('paid_fee_amount'));
            $payment_type = $this->security->xss_clean($this->input->post('payment_type'));

            $dd_number = $this->security->xss_clean($this->input->post('dd_number'));
            $dd_date = $this->security->xss_clean($this->input->post('dd_date'));
            $bank_name = $this->security->xss_clean($this->input->post('bank_name'));

            $upi_number = $this->security->xss_clean($this->input->post('upi_number'));

            $tran_number = $this->security->xss_clean($this->input->post('tran_number'));
            $tran_date = $this->security->xss_clean($this->input->post('tran_date'));
            $tran_bank_name = $this->security->xss_clean($this->input->post('tran_bank_name'));

            $payment_date = $this->security->xss_clean($this->input->post('transaction_date'));
            $fee_type = $this->security->xss_clean($this->input->post('fee_type'));

            $excess_amount = $this->security->xss_clean($this->input->post('excess_amount'));
            $ref_receipt_no = $this->security->xss_clean($this->input->post('ref_receipt_no'));
            $payment_year = $this->security->xss_clean($this->input->post('payment_year')); 
            $studentInfo =  $this->student->getStudentInfoByRowId($application_no);
            
            $fee_year = $studentInfo->intake_year_id;
            if($term_name == 'II PUC'){
                $fee_year = ($studentInfo->intake_year_id)+1;
               
            }
            $isExist = $this->fee->checkReceiptNoExists($ref_receipt_no,$fee_year);
            if(!empty($isExist)){
                $this->session->set_flashdata('error', 'Receipt No. Already Exists');
                
            $_SESSION["FEE_STUDENT_ID"] = $application_no;
            $_SESSION["FEE_TERM_NAME"] = $term_name;
                redirect('getNewStudentFeePaymentInfo');
                
            }

            $_SESSION["FEE_STUDENT_ID"] = $application_no;
            $_SESSION["FEE_TERM_NAME"] = $term_name;

            $filter['student_id'] = $student_id;
            $studentInfo =  $this->student->getStudentInfoByRowId($application_no);
            $filter['fee_year'] = $studentInfo->intake_year_id;
            // if(empty($studentInfo)){
            //     //check student exist in new admission info
            //     $studentInfo = $this->admission->getStudentStudentInfo($application_no);
            //     $filter['fee_year'] = CURRENT_YEAR;
            // }

            // if($term_name == 'II PUC'){
            //     $filter['fee_year'] = ($studentInfo->intake_year_id)+1;
            // }
            if($term_name == 'II PUC'){
                $filter['fee_year'] = ($studentInfo->intake_year_id)+1;
               
            }
        
                $filter['term_name'] = $term_name;
                $filter['stream_name'] = $studentInfo->stream_name;
            
                if(($term_name == 'I PUC' && $filter['fee_year'] == '2022') || ($term_name == 'II PUC' && $studentInfo->is_active == 0)){
                    $total_fee = $this->fee->getfirstpucbal($application_no);
                    $total_fee_to_pay = $total_fee->amount;
                    
                }else{
                
                    $total_fee = $this->fee->getTotalFeeAmount($filter); 
                    $total_fee_to_pay = $total_fee->total_fee;
                    if ($fee_type == "1") {
                        $total_fee_to_pay = $total_fee_to_pay - 2000;
                      
                    } else {
                        $total_fee_to_pay = $total_fee_to_pay;
                    }
                }
                // if(strtoupper($studentInfo->elective_sub) == 'FRENCH'){
                //     $filter['lang_fee_status'] = true;
                // }else{
                //     $filter['lang_fee_status'] = false;
                // }
                // $filter['category'] = strtoupper($studentInfo->category);
                
                // if($term_name == 'I PUC'){
                //     $studentInfo2 = $this->admission->getStudentStudentInfo($application_no);
                //     $boardInfo = $this->admission->getStudentRegisteredInfo($studentInfo2->registered_row_id);
                //     $data['board_id'] = $boardInfo->sslc_board_name_id;
                //     if($boardInfo->sslc_board_name_id == 1){
                //         $filter['board_name'] = "SSLC";
                //     }else{
                //         $filter['board_name'] = "OTHER";
                //     }
                // }

                // if($term_name == 'II PUC'){
                //     if($studentInfo->is_admitted == 1){
                //         $filter['term_name'] = 'I PUC';
                //         $filter['fee_year'] = CURRENT_YEAR;
                //         $filter['board_name'] = "SSLC";
                //     }
                // }

              

                $data['total_fee'] = $total_fee->total_fee;
                $concession_amt = 0;
                $feeConcession = $this->fee->getStudentFeeConcession($application_no);
                if(!empty($feeConcession)){
                    $concession_amt = $feeConcession->fee_amt;
                    $total_fee_to_pay -= $concession_amt;
                }
                $scholarship_amt = 0;
                $feeScholarship = $this->fee->getStudentFeeScholarship($application_no);
                if(!empty($feeScholarship)){
                    $scholarship_amt = $feeScholarship->fee_amt;
                    $total_fee_to_pay -= $scholarship_amt;
                }
                $data['feePaidInfo'] = $this->fee->getFeePaidInfo($application_no,$filter['fee_year']);
                if(!empty($data['feePaidInfo'])){
                    foreach($data['feePaidInfo'] as $fee){
                        $total_fee_to_pay = $total_fee_to_pay - $fee->paid_amount;
                    }
                }

                $pending_fee_balance = $total_fee_to_pay - $paid_fee_amount;
                if($pending_fee_balance <= 0){
                    $fee_excess_amount = abs($pending_fee_balance);
                    $fee_pending_status = 0;
                }else if($pending_fee_balance > 0){
                    $fee_excess_amount = 0;
                    $fee_pending_status = 1;
                }

                $feePaymentInfo = $this->fee->getStdLastPaidDetailsByApplicationNo($application_no,$filter['fee_year']);
                if(empty($feePaymentInfo)){
                    $paid_count = 1;
                }else{
                    $paid_count = $feePaymentInfo->payment_count+1;
                }

                

                $lastReceiptInfo = $this->fee->getLastReceiptNo($filter['fee_year']);
                if(!empty($lastReceiptInfo->receipt_number)){
                    $receipt_no = $lastReceiptInfo->receipt_number + 1;
                }else{
                    $receipt_no = 1;
                }
            
                $overallFee = array(
                    'application_no' => $application_no,
                    'receipt_number' => $receipt_no,
                    'ref_receipt_no' => $ref_receipt_no,
                    'payment_type' => $payment_type,
                    'attempt' => $fee_type,
                    'payment_date' => date('Y-m-d',strtotime($payment_date)),
                    'total_amount' => $total_fee_to_pay,
                    'paid_amount' => $paid_fee_amount,
                    'excess_amount' => $fee_excess_amount,
                    'fee_concession' => $concession_amt,
                    'fee_scholarship' => $scholarship_amt,
                    'pending_balance' => abs($pending_fee_balance),
                    'fee_pending_status' => $fee_pending_status,
                    'payment_count' => $paid_count,
                    'payment_year' => $filter['fee_year'],
                    'term_name' => $term_name,
                    'upi_number' => $upi_number,
                    'created_by' => $this->staff_id,
                    'created_date_time' => date('Y-m-d H:i:s'));
                    $fee_year= $filter['fee_year'];
                    $receipt_number = $this->fee->addFeeDetailsNewAdmission_2021($overallFee);

                    $fee_amount_balance_pending = $paid_fee_amount;
                    $remaining_fee_amt = $paid_fee_amount;

                    // log_message('debug','feeStruct='.print_r($feeStructureInfo,true));
                    // foreach($feeStructureInfo as $fee){
                    //     $db_save_status = false;
                    //     $fee_structure_amt = $fee->fee_amount_state_board;
                    //     $isAlreadyPaid = $this->fee->checkFeeTypeIsAlreadyPaid($application_no,$fee->row_id);
                    //     if($remaining_fee_amt >= 0){
                    //         if(!empty($isAlreadyPaid)){
                    //             if($isAlreadyPaid->pending_status == 1){
                    //                 $remaining_fee_amt -= $isAlreadyPaid->pending_amt;
                    //                 if($remaining_fee_amt >= 0){
                    //                     //$pending_amount = 0;
                    //                     $paid_amt = $isAlreadyPaid->pending_amt;
                    //                     $pending_amt = 0;
                    //                     $fee_pending_status = 0;
                    //                 } else {
                    //                     //$dd_amount = 0; 
                    //                     $paid_amt = $isAlreadyPaid->pending_amt - abs($remaining_fee_amt);
                    //                     $pending_amt = $isAlreadyPaid->pending_amt - $paid_amt;
                    //                     $fee_pending_status = 1;
                    //                 } 
                    //                 $db_save_status = true;
                    //             }
                    //         }else{
                    //             $remaining_fee_amt -= $fee_structure_amt;
                    //             if($remaining_fee_amt >= 0){
                    //                 //$pending_amount = 0;
                    //                 $paid_amt = $fee_structure_amt;
                    //                 $pending_amt = 0;
                    //                 $fee_pending_status = 0;
                    //             } else {
                    //                 //$dd_amount = 0; 
                    //                 $paid_amt = $fee_structure_amt - abs($remaining_fee_amt);
                    //                 $pending_amt = $fee_structure_amt - $paid_amt;
                    //                 $fee_pending_status = 1;
                    //             } 
                    //             $db_save_status = true;
                    //         }
                    //     }else{
                    //         if(empty($isAlreadyPaid)){
                    //         $pending_amt = $fee_structure_amt;
                    //         $paid_amt = 0;
                    //         $fee_pending_status = 1;
                    //         $db_save_status = true;
                    //         }
                    //     }
                    //     if($db_save_status){
                    //         $feeReceiptPayment = array(
                    //             'application_no' => $application_no,
                    //             'receipt_number' => $receipt_number,
                    //             'payment_date' => date('Y-m-d',strtotime($payment_date)), 
                    //             'fee_type_id' => $fee->row_id,
                    //             'paid_amount' => $paid_amt,
                    //             'pending_amt' => $pending_amt,
                    //             'pending_status' => $fee_pending_status,
                    //             'school_account_id' => $fee->account_row_id,
                    //             'created_by' => 'schoolphins',
                    //             'fee_amount' => $fee_structure_amt,
                    //             'created_date_time' => date('Y-m-d H:i:s'));
                                
                    //         $receipt_return_feeType = $this->fee->addReceiptFeeType($feeReceiptPayment);
                    //     }
                    
                    // }
            
                    $studentInfoStatus = array(
                        'new_admitted' => 1,
                        'updated_date_time' => date('Y-m-d H:i:s'));
                    $this->student->updateStudentInfo($studentInfoStatus,$application_no);
    
        
            
            if(!empty($receipt_number)){
                if($payment_type == 'DD'){
                    $ddInfo = array(
                        'application_no' => $application_no,
                        'fee_year' => $fee_year,
                        'receipt_number' => $receipt_number,
                        'dd_number' => $dd_number,
                        'dd_date' => date('Y-m-d',strtotime($dd_date)),
                        'bank_name' => $bank_name,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d H:i:s')
                    );
                    $this->fee->addDDInfo($ddInfo);
                }else if($payment_type == 'CARD'){
                    $bankInfo = array(
                        'application_no' => $application_no,
                        'receipt_number' => $receipt_number,
                        'transaction_number' => $tran_number,
                        'transaction_date' => date('Y-m-d',strtotime($tran_date)),
                        'bank_name' => $tran_bank_name,
                        'created_by' => $this->staff_id,
                        'created_date_time' => date('Y-m-d H:i:s')
                    );
                    $this->fee->addBankInfo($bankInfo);
                }
                $this->session->set_flashdata('success', 'Fee Paid Successfully');
                // redirect('feePaymentReceiptPrint/'.$receipt_number); 
                $applicationStatus = array(
                    'joined_status' => 1,
                    'admission_status'=> 1,
                    'updated_date_time' => date('Y-m-d H:i:s'));
            $this->admission->updateStudentApplicationStatus($studentInfo->application_number,$applicationStatus);
            }else{
                $this->session->set_flashdata('error', 'Fee Payment Failed!');
            }
            redirect('getNewStudentFeePaymentInfo'); 
        }
    }

    public function getReceiptNumber(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $filter = array();
            $ref_receipt_no = $this->input->post("reference_receipt_no");
            $year = $this->input->post("year");
            $data['result'] = $this->fee->getCheckReceiptNo($ref_receipt_no,$year);
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }

    public function getReceiptNo(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $filter = array();
            $ref_receipt_no = $this->input->post("ref_rept_no");
            $data['result'] = $this->fee->getCheckReceiptNo($ref_receipt_no);
            header('Content-type: text/plain'); 
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }

    public function updateFeeReceipt(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $receipt_no = $this->security->xss_clean($this->input->post('receipt_no'));

            $feeInfo = $this->fee->getFeeInfoByReceiptNum($row_id);
            $student_row_id = $feeInfo->application_no;
            $isExist = $this->fee->checkReceiptNoExists($receipt_no,$feeInfo->payment_year);
           
            if(!empty($isExist)){
              
                $this->session->set_flashdata('error', 'Receipt No. Already Exists');
                $_SESSION["FEE_STUDENT_ID"] = $student_row_id;
                $_SESSION["FEE_TERM_NAME"] = $term_name;
                redirect('getNewStudentFeePaymentInfo');
                
            }

            
            $term_name = $feeInfo->term_name;

                $overallFee = array(
                    'ref_receipt_no' => $receipt_no,
                    'updated_by' => $this->staff_id,
                    'updated_date_time' => date('Y-m-d H:i:s'));
    
            $receipt_number = $this->fee->updateReceiptNumber($overallFee,$row_id);
                    
            $_SESSION["FEE_STUDENT_ID"] = $student_row_id;
            $_SESSION["FEE_TERM_NAME"] = $term_name;
            if(!empty($receipt_number)){
                $this->session->set_flashdata('success', 'Fee Updated Successfully');
            }else{
                $this->session->set_flashdata('error', 'Fee Update Failed!');
            }
            redirect('getNewStudentFeePaymentInfo');

        }
    }

    public function miscellaneousFeeListing(){
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            $data['studentInfo'] = $this->student->getstudentInfo();
            $intake_year = $this->security->xss_clean($this->input->post('intake_year'));
            if(empty($intake_year)){
                $data['intake_year'] = CURRENT_YEAR;
            }else{
                $data['intake_year'] = $intake_year;
            }
            $miscellaneousFeeInfo = $this->fee->getMiscellaneousFeesInfo($filter);

            $data['miscellaneousTypeInfo'] = $this->settings->getAllMiscellaneousTypeInfo();
            // $data['streamInfo'] = $this->application->getStreamNames();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Miscellaneous Fee';
            $this->loadViews("fees/miscellaneousFee.php", $this->global, $data, null);
        }
    }

    public function getMiscellaneousFeeInfo(){
        if($this->isAdmin() == TRUE )
        {
            $this->loadThis();
        } else {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $data_array_new = [];
        $filter['intake_year'] = $this->security->xss_clean($this->input->post('intake_year'));
        $miscellaneousFeeInfo = $this->fee->getMiscellaneousFeesInfo($filter);
       // log_message('debug','mis'.print_r($miscellaneousFeeInfo,true));
        foreach($miscellaneousFeeInfo as $fee) {
            $checkbox="";
            $infoButton = "";
            $deleteButton = "";
            $receipt= "";
            $approve="";
            $payButton="";
            if(empty($fee->qnty)){
                $total_amount =  $fee->amount;   
            }else {
            $total_amount = $fee->qnty * $fee->amount;
            }
            $staffName = $this->fee->getStaffNameById($fee->created_by);

            // $infoButton = '<span><a href="#" title="Cashier Info : '. $staffName->name.'" data-toggle="popover" data-content="Name: '. $staffName->name.'"><span class="badge badge-primary"> <i class="fa fa-info-circle"></i></span></a></span>'; 

                    // $approve = '<a class="btn btn-xs p-2 btn-success approvePayment" href="#"
                    // data-row_id="'.$hostel->row_id.'" title="Approve"><i class="fas fa-thumbs-up"></i></a>';
                    $deleteButton = '<a class="btn btn-xs btn-danger deleteMiscellaneousFee" href="#"
                    data-row_id="'.$fee->row_id.'" title="Delete"><i class="fa fa-trash"></i></a>';
                
                    // $editButton = '<a class="btn btn-xs btn-primary"
                    // href="'.base_url().'editHostelPayment/'.$hostel->row_id.'" title="Edit"><i
                    // class="fas fa-pencil-alt"></i></a>';
                  
            
                // $editButton = '<a class="btn btn-xs btn-primary"
                // href="'.base_url().'editHostelPayment/'.$hostel->row_id.'" title="Edit"><i
                // class="fas fa-pencil-alt"></i></a>';
               
                    $receipt = '<a class="btn btn-xs btn-primary" 
                    href="'.base_url().'miscellaneousReceiptPrint/'.$fee->row_id.'"
                            target="_blank" title="Receipt"><i class="material-icons">receipt</i></a>';
               
                
            
            $data_array_new[] = array(
                $checkbox,
                date('d-m-Y',strtotime($fee->date)),
                $fee->ref_receipt_no,
                $fee->student_id,
                strtoupper($fee->student_name),
                strtoupper($fee->miscellaneous_type),
                // $fee->amount,
                $fee->qnty,
                $total_amount,
               $fee->payment_type,
                $deleteButton.' '.$approve.' '.$receipt.' '.$payButton 
                );
            }
        $count = count($miscellaneousFeeInfo);
            $result = array(
                "draw" => $draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $data_array_new
            );
        echo json_encode($result);
        exit();
        }
    }

    
   
    public function addMiscellaneousPayment(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('miscellaneous_type', 'MISCELLANEOUS', 'trim|required');
            if($this->form_validation->run() == FALSE)
            {
                redirect('miscellaneousFeeListing');  
            } else {
                $student_row_id = $this->security->xss_clean($this->input->post('stud_row_id'));
                $date = $this->security->xss_clean($this->input->post('date'));
                $miscellaneous_type = $this->security->xss_clean($this->input->post('miscellaneous_type'));
                $student_name = $this->security->xss_clean($this->input->post('student_name'));
                $course = $this->security->xss_clean($this->input->post('course'));
                $semester = $this->security->xss_clean($this->input->post('semester'));
                $ref_receipt_no = $this->security->xss_clean($this->input->post('ref_receipt_no'));
                $register_no = $this->security->xss_clean($this->input->post('register_no'));
                $quantity = $this->security->xss_clean($this->input->post('quantity'));
                $status = $this->security->xss_clean($this->input->post('status'));
                $amount = $this->security->xss_clean($this->input->post('amount'));
                $type = $this->security->xss_clean($this->input->post('type'));
                $ref_no = $this->security->xss_clean($this->input->post('ref_no'));
                $neft_ref_no = $this->security->xss_clean($this->input->post('neft_ref_no'));


                //  if($student_status == 'Active')
                //  {
                    $studentDetails = $this->student->getStudentInfoByRowId($student_row_id);
                    //log_message('debug','student'.print_r($studentDetails,true));
                    $stud_name = $studentDetails->student_name;
                    $student_id =   $studentDetails->student_id;
                    $term =   $studentDetails->term_name;
                    $stream = $studentDetails->stream_name;

                // }

                // else   if($student_status == 'Alumni')
                // {
                   // $stud_name = $student_name;
                    // $semester_name  =   $semester;
                    // $course_name =   $course;
                    // $register_no =   $register_no;
                    // $section_name = '';
               // }


                // $amount = $this->fee->getFeeByMiscId($miscellaneous_type);
                 
                $miscellaneousInfo = array(
                    'student_name' => $stud_name,
                    'date'=> date('Y-m-d',strtotime($date)), 
                    'created_by' => $this->staff_id, 
                    'miscellaneous_type' => $miscellaneous_type,
                    'amount'  => $amount,
                    'year' => CURRENT_YEAR,
                    'student_id' =>$student_id,
                    'student_row_id' => $student_row_id,
                  //  'student_status' =>$student_status,
                    'qnty'       =>$quantity,
                    'term' => $term,
                    //'section_name' => $section,
                    'stream' => $stream,
                    'total' => $amount * $quantity,
                    //'payment_status' => $status,
                    'payment_type' => $type,
                    'upi_ref_no' => $ref_no,
                    'ref_number' => $neft_ref_no,
                    'ref_receipt_no' => $ref_receipt_no,
                    'created_date_time' => date('Y-m-d H:i:s'));
          
                $result = $this->fee->addMiscellaneousPayment($miscellaneousInfo);
            
                if($result>0){
                    $this->session->set_flashdata('success', 'Added Miscellaneous Fee payment Successfully');
                    redirect('miscellaneousFeeListing');
                } else {
                    $this->session->set_flashdata('error', 'Failed to add Miscellaneous Fee payment');
                    redirect('miscellaneousFeeListing');
                }
                
            }
        }
    }

    public function deleteMiscellaneousFee(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $miscellaneousInfo = array('is_deleted' => 1,'updated_date_time' => date('Y-m-d H:i:s'),'updated_by'=>$this->staff_id);
            $result = $this->fee->updateMiscellaneousFee($miscellaneousInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        }
    }

    // public function miscellaneousReceiptPrint($row_id){
    //     if($this->isAdmin() == TRUE){
    //         $this->loadThis();
    //     } else {   
    //         error_reporting(0);
    //         $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf', 'default_font' => 'timesnewroman', 'format' => 'A4-L']);
    //         $mpdf->AddPage('L', '', '', '', '', 7, 7, 25, 15, 8, 8);
    //         $mpdf->SetTitle('Transport Receipt');
    //        log_message('debug','row'.$row_id);
    //         $data['miscellaneousInfo'] = $this->fee->getMiscellaneousFeesInfoById($row_id);
    //         log_message('debug','row'.print_r($data['miscellaneousInfo'],true));
           
           
    //         $data['name_count'] = 0;
    //         $html_student_copy = $this->load->view('fees/miscellaneousReceiptPrint',$data,true);
    //         $data['name_count'] = 1;
    //         $html_office_copy = $this->load->view('fees/miscellaneousReceiptPrint',$data,true);
           
    //         $mpdf->WriteHTML('<columns column-count="2" vAlign="J" column-gap="10" />');
    //         $mpdf->WriteHTML($html_student_copy);
    //         $mpdf->WriteHTML($html_office_copy);
    //         $mpdf->Output('Miscellaneous_Fee_Receipt.pdf', 'I');
    //     } 
    // }

    public function miscellaneousReceiptPrint($row_id = null)
    {
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            if ($row_id == null) {
                redirect('miscellaneousFeeListing');
            }
           // error_reporting(0);
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf', 'default_font' => 'timesnewroman', 'format' => 'A4-L']);
            $mpdf->AddPage('L', '', '', '', '', 7, 7, 25, 15, 8, 8);
            $mpdf->SetTitle('Miscellaneous Receipt');
           
            $data['miscellaneousInfo'] = $this->fee->getMiscellaneousFeesInfoById($row_id);
            if(empty($data['miscellaneousInfo']->qnty)){

                $amount = $data['miscellaneousInfo']->amount;
            }else{
            
                $amount = $data['miscellaneousInfo']->qnty * $data['miscellaneousInfo']->amount;
            
            }
            $data['amount_in_words'] = $this->getIndianCurrency(floatval($amount));
            $data['name_count'] = 0;
            $html_student_copy = $this->load->view('fees/miscellaneousReceiptPrint',$data,true);
            $data['name_count'] = 1;
            $html_office = $this->load->view('fees/miscellaneousReceiptPrint',$data,true);
          
        
            $mpdf->WriteHTML('<columns column-count="2" vAlign="J" column-gap="10" />');
            $mpdf->WriteHTML($html_student_copy);
            $mpdf->WriteHTML($html_office);
         

            $mpdf->Output('Fee_Receipt.pdf', 'I');
      
        }
    }

    public function deleteFeesReceipt(){
        if ($this->isAdmin() == true) {
            echo (json_encode(array('status' => 'access')));
        } else {
            $row_id = $this->input->post('row_id');
            $remark = $this->input->post('remark');
      
            $receiptInfo = array('is_deleted' => 1,
            'remarks' => $remark,
            'updated_by' => $this->staff_id,
            'updated_date_time' => date('Y-m-d h:i:s'));
        
            $result = $this->fee->updateReceiptNo($row_id, $receiptInfo);
            if ($result > 0) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        }
    }
}
?>