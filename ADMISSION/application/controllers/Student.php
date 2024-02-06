<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';
require APPPATH . '/third_party/encdec_paytm.php';
class Student extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('pdf');
        $this->load->model('student_model');
        $this->load->model('registration_model');
        $this->isLoggedIn();
    }

    public function index() {
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Dashboard';
        $student = $this->student_model->getStudentApplicationInfo($this->student_row_id);
        $data['studentApplicationStatus'] = $this->student_model->getStudentApplicationStatus($this->student_row_id);
        // $data['microsoftTeamInfo'] = $this->student_model->getStudentMicrosoftTeamInfo($data['studentApplicationStatus']->application_number);
        $data['studentApplicationInfo'] = $student;
        $data['sslcRegisterNumber'] = $this->registration_number;
        $_SESSION['application_status'] = false;
        $_SESSION['application_number_status']= false;
        $data['studentWebsiteGrievance'] = $this->student_model->getWebsiteGrievanceStatus($this->student_row_id);
        if(!empty($student)){
            $application_status = $student->student_application_status;
            if(!empty($data['studentApplicationStatus']->application_number)){
                $application_no = $data['studentApplicationStatus']->application_number;
                $personalInfo = array(
                    'application_number' => $application_no
                );
                $this->student_model->updateStudentPersonalInfo($this->student_row_id,$personalInfo);
            }
        }else{
            $application_status = 0;
            $application_no = '';
        }
        $_SESSION['submission_status'] = false;
        $_SESSION['joined_status'] = false;
        if(!empty($application_no)){
            $_SESSION['application_number_status']= true;
            if($data['studentApplicationStatus']->admission_status == 1 || $data['studentApplicationStatus']->joined_status == 1){
                $_SESSION['submission_status'] = true;
                if($data['studentApplicationStatus']->joined_status == 1){
                    $_SESSION['joined_status'] = true;
                }
            }
            
            $this->loadViews("dashboard", $this->global, $data, NULL);  
        }else{
            redirect('viewPersonalDetail');
        }

        // if($application_status == 0){
            // $_SESSION['application_status']= true;
            // $this->loadViews("dashboard", $this->global, $data, NULL);  
        // }else{
        //    redirect('viewPersonalDetail');
        // }
    }

    public function viewPersonalDetail() {
        $data['sslcRegisterNumber'] = $this->registration_number;
        $student = $this->student_model->getStudentApplicationInfo($this->student_row_id);
        $data['parishPriestInfo'] = $this->student_model->getParishPriestInfo($this->student_row_id);
        $data['documentInfo'] = $this->student_model->getDocumnetDetails($this->student_row_id);
        $data['stateInfo'] = $this->student_model->getStateInfo();
        $data['nationalityInfo'] = $this->student_model->getNationality();
        $data['religionInfo'] = $this->student_model->getReligionInfo();
        $data['casteInfo'] = $this->student_model->getCasteInfo();
        $data['studentApplicationInfo'] = $student;
      
        $_SESSION['application_number_status'] = false;
        if(!empty($student)){
            $application_no = $student->application_number;
        }else{ 
            $application_no = '';
        }
        if(!empty($application_no)){
            $_SESSION['application_number_status'] = true;
        }
        $appStatus = $this->student_model->getStudentApplicationStatus($this->student_row_id);

        $this->global['pageTitle']= ''.TAB_TITLE.'  : Student Personal Details';
        if(empty($appStatus)){
            $this->loadViews("admission/personalDetails", $this->global ,$data ,NULL);
        }else if($appStatus->admission_status == 1 || $appStatus->joined_status == 1){
            redirect('dashboard');
        }else{
            $this->loadViews("admission/personalDetails", $this->global ,$data ,NULL);
        }
       
    }

    public function viewSchoolDetail() {
        $boardData = $this->student_model->getStudentSchoolInfo($this->student_row_id);
        // log_message('debug','darraa'.$boardData->sslc_board_name_id);
        if(empty($boardData)) {
            $sslc_id = -1;
        }
        else{
            $sslc_id = $boardData->sslc_board_name_id;
        }
        $data['boardData'] = $boardData;
        log_message('debug','boardid='.$sslc_id);
        $data['sslcRegisterNumber'] = $this->registration_number;
        $student = $this->student_model->getStudentApplicationInfo($this->student_row_id);
        $data['studentSchoolInfo'] = $this->student_model->getStudentSchoolInfo($this->student_row_id);
        $data['studentMarkInfo'] = $this->student_model->getStudentMarkInfoforDisplay($this->student_row_id);
       // log_message('debug','jhgfdsgfd'.print_r($data['studentMarkInfo'],true));
        $data['marksDetail'] = $this->student_model->getMarksDetailforDisplay($this->student_row_id);
        $data['boardInfo'] = $this->student_model->getBoardNameById($sslc_id); //$this->sslc_board_name_id
       log_message('debug','kdkfd'.print_r($data['boardInfo'],true));
        $data['allBoardsInfo'] = $this->registration_model->getBoardName();
        $data['documentInfo'] = $this->student_model->getDocumnetDetails($this->student_row_id);
        $data['studentApplicationInfo'] = $student;
        $_SESSION['application_number_status'] = false;
        if(!empty($student)){
            $application_no = $student->application_number;
        }else{
            $application_no = '';
        }
        if(!empty($application_no)){
            $_SESSION['application_number_status'] = true;
        }
        $this->global['pageTitle']=''.TAB_TITLE.' : School Details';
        $appStatus = $this->student_model->getStudentApplicationStatus($this->student_row_id);
        if(empty($appStatus)){
            $this->loadViews("admission/schoolDetail", $this->global,$data,null);
        }else if($appStatus->admission_status == 1 || $appStatus->joined_status == 1){
            redirect('dashboard');
        }else{
            $this->loadViews("admission/schoolDetail", $this->global,$data,null);
        }
        
      
    }

    public function viewCombinationDetail() {
        $student = $this->student_model->getStudentApplicationInfo($this->student_row_id);
        $data['documentInfo'] = $this->student_model->getDocumnetDetails($this->student_row_id);
        $data['studentAdmissionInfo'] = $this->student_model->getAdmissionInfo($this->student_row_id);
        $_SESSION['application_number_status'] = false;
        if(!empty($student)){
            $application_no = $student->application_number;
        }else{
            $application_no = '';
        }
        if(!empty($application_no)){
            $_SESSION['application_number_status'] = true;
        }

        $this->global['pageTitle']=''.TAB_TITLE.' : Combination and Language Details';
        $appStatus = $this->student_model->getStudentApplicationStatus($this->student_row_id);
        if(empty($appStatus)){
            $this->loadViews("admission/combinationAndLanguage", $this->global,$data,null);
        }else if($appStatus->admission_status == 1 || $appStatus->joined_status == 1){
            redirect('dashboard');
        }else{
            $this->loadViews("admission/combinationAndLanguage", $this->global,$data,null);
        }
       
    }

    public function viewPrintApplication() {
        $data['sslcRegisterNumber'] = $this->registration_number;
        $boardData = $this->student_model->getStudentBoardInformation($this->student_row_id);                
        $sslc_id = $boardData->sslc_board_name_id;
        $data['boardInfo'] = $this->student_model->getBoardNameById($sslc_id);
        $student = $this->student_model->getStudentApplicationInfo($this->student_row_id);
        $data['appInfo'] = $this->student_model->geApplicationInfo($this->student_row_id);
        $data['studentSchoolInfo'] = $this->student_model->getStudentSchoolInfo($this->student_row_id);
        $data['studentMarkInfo'] = $this->student_model->getStudentMarkInfo($this->student_row_id);
        $data['studentAdmissionInfo'] = $this->student_model->getAdmissionInfo($this->student_row_id);
        $data['studentInfo'] = $this->student_model->getStudentRegisteredInfo($this->student_row_id);
        $data['documentInfo'] = $this->student_model->getDocumnetDetails($this->student_row_id);
        $data['photoInfo'] = $this->student_model->getStudentImage($this->student_row_id);
        $data['studentApplicationInfo'] = $student; 
        $this->global['pageTitle']= ''.TAB_TITLE.'  : Application Form';
        $this->loadViews("admission/printApplication", $this->global, $data, NULL);
    }


    /**
     * This function is used to show users profile
     */
    function profile($active = "details"){
        $data['photoInfo'] = $this->student_model->getStudentImage($this->student_row_id);
        $data['studentInfo'] = $this->student_model->getStudentRegisteredInfo($this->student_row_id);
        $data["active"] = $active;
        $this->global['pageTitle'] = ''.TAB_TITLE.' : My Profile' ;
        $this->loadViews("users/profile", $this->global, $data, NULL);
    }

    /**
     * This function is used to change the password of the user
     * @param text $active : This is flag to set the active tab
     */
    function changePassword($active = "changepass"){
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('password','New password','required|min_length[6]');
        $this->form_validation->set_rules('cpassword','Confirm new password','required|matches[password]|min_length[6]');
        
        if($this->form_validation->run() == FALSE) {
            $this->profile($active);
        }else {
            $oldPassword = $this->input->post('oldPassword');
            $password = $this->input->post('password');
            $resultPas = $this->student_model->matchOldPassword($this->student_row_id, $oldPassword);
            if(empty($resultPas)) {
                $this->session->set_flashdata('nomatch', 'Your old password is not correct');
                redirect('profile/'.$active);
            }
            else{
                $usersData = array('password'=>getHashedPassword($password), 'updated_by'=>$this->student_row_id,
                                'updatedDtm'=>date('Y-m-d H:i:s'));
                $result = $this->student_model->changePassword($this->student_row_id, $usersData);
                if($result > 0) { 
                    $this->session->set_flashdata('success', 'Password updation successful'); 
                }else { 
                    $this->session->set_flashdata('error', 'Password updation failed'); 
                }
                redirect('profile/'.$active);
            }
        }
    }
    function getFormInformation(){
        $data['nationality'] = $this->student_model->getNationality();
        $data['caste'] = $this->student_model->getCasteInfo();
        $data['religion'] = $this->student_model->getReligionInfo();
        header('Content-type: text/plain'); 
        // set json non IE
        header('Content-type: application/json'); 
        echo json_encode($data);
        exit(0);
    }

    function getStudentMarkSheet(){
        // $medium = $this->input->post('medium');
        $sslc_board_name_id = $this->input->post('board_name');
log_message('debug','csdfsdr'.$sslc_board_name_id);
        $boardData = $this->student_model->getStudentBoardInformation($this->student_row_id);                
        $sslc_id = $boardData->sslc_board_name_id;
       $boardInfo = $this->student_model->getBoardNameById($sslc_id);

        $studentSchoolInfo = $this->student_model->getStudentSchoolInfo($this->student_row_id);
        if($boardData->sslc_board_name_id != $sslc_board_name_id){
            $boardArray= array('sslc_board_name_id'=>$sslc_board_name_id);
            $result= $this->student_model->updateBoardName($this->student_row_id,$boardArray);
            $this->student_model->updateBoardInfo($this->student_row_id,$boardArray);
            $sslcMarkInfo = $this->student_model->checkAllSSLCMarkExists($this->student_row_id);
            // if($sslcMarkInfo > 0 && $result > 0){
            //    $this->student_model->deleteMarkInfo($this->student_row_id);
            // }

            if($sslcMarkInfo > 0 && $result > 0){
                $MarksInfo =array(
                    'is_deleted'=>1,
                );
            $this->student_model->UpdateMarkInfo($this->student_row_id,$MarksInfo);
            }
        }
    
        if($sslc_board_name_id == 1){
            // if($medium == "KANNADA"){
            //     $this->load->view('student_sslc_subjects/state_board_karnataka_kannada');
            // }else{
                $this->load->view('student_sslc_subjects/state_board_karnataka_english');
            // }
        } else if($sslc_board_name_id == 2){
            $this->load->view('student_sslc_subjects/cbse_subjects');
        }else if($sslc_board_name_id == 3){
            $this->load->view('student_sslc_subjects/icse_board');
        }else if($sslc_board_name_id == 4){
            $this->load->view('student_sslc_subjects/other_board_subject');
        }
    }

    function getStudentMarkSheet_two(){
        // $medium = $this->input->post('medium');
        $board_name = $this->input->post('board_name');
        $sslc_board_name_id = $this->input->post('board_name');

        $studentSchoolInfo = $this->student_model->getStudentSchoolInfo($this->student_row_id);

     
       
        if($sslc_board_name_id == 1){
            // if($medium == "KANNADA"){
            //     $this->load->view('student_sslc_subjects/state_board_karnataka_kannada');
            // }else{
                $this->load->view('student_sslc_subjects/state_board_karnataka_english');
            // }
        } else if($sslc_board_name_id == 2){
            $this->load->view('student_sslc_subjects/cbse_subjects');
        }else if($sslc_board_name_id == 3){
            $this->load->view('student_sslc_subjects/icse_board');
        }else if($sslc_board_name_id == 4){
            $this->load->view('student_sslc_subjects/other_board_subject');
        }else if($sslc_board_name_id == 5){
            $this->load->view('student_sslc_subjects/other_board_subject');
        }

    }

    function getStreamNamesByProgram(){
        $program_name = $this->input->post('program_name');
        $data['stream_name'] = $this->student_model->getStreamNamesByProgram($program_name);
        header('Content-type: text/plain');
        header('Content-type: application/json'); 
        echo json_encode($data);
        exit(0);
    }
    function saveStudentPersonalInfo(){
        $appStatus = $this->student_model->getStudentApplicationStatus($this->student_row_id);
        if(!empty($appStatus)){
        if($appStatus->admission_status == 1){
            redirect('dashboard');
        }
    }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
        // $this->form_validation->set_rules('dob','Date of Birth','trim|required');
        $this->form_validation->set_rules('native_place','Native Place','required');
        $this->form_validation->set_rules('gender','Gender','required');
        $this->form_validation->set_rules('mother_tongue','Mother Tongue','required');
        $this->form_validation->set_rules('nationality','Nationality','required');
        $this->form_validation->set_rules('religion','Select religion','required');
        $this->form_validation->set_rules('caste','Select Caste Category','required');
        $this->form_validation->set_rules('father_name','Father Name','trim|required|max_length[128]');
        $this->form_validation->set_rules('mother_name','Moather Name','trim|required|max_length[128]');
        $this->form_validation->set_rules('father_mobile','Father Mobile','required|numeric|min_length[10]');
        // $this->form_validation->set_rules('father_age','Father Age','required');
        // $this->form_validation->set_rules('mother_age','Mother Age','required');
        $this->form_validation->set_rules('father_annual_income','Father Annual Income','trim|required');
        $this->form_validation->set_rules('permanent_address_line_1','Permanent Address Line 1','trim|required');
        // $this->form_validation->set_rules('student_email','Student Email','required');
        // $this->form_validation->set_rules('mother_annual_income','Mother Annual Income','trim|required');
        $this->form_validation->set_rules('physically_challenged','Physically Challenged?','required');
        $this->form_validation->set_rules('dyslexia_challenged','Dyslexic?','required');
        if($this->form_validation->run() == FALSE) {
            $this->viewPersonalDetail();
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
            $permanent_address_taluk = $this->security->xss_clean($this->input->post('permanent_address_taluk'));

            $residence_address_line_1 = $this->security->xss_clean($this->input->post('residence_address_line_1'));
            $residence_address_line_2 = $this->security->xss_clean($this->input->post('residence_address_line_2'));
            $residence_address_district = $this->security->xss_clean($this->input->post('residence_address_district'));
            $residence_address_state = $this->security->xss_clean($this->input->post('residence_address_state'));
            $residence_address_pincode = $this->security->xss_clean($this->input->post('residence_address_pincode'));
            $residence_address_taluk = $this->security->xss_clean($this->input->post('residence_address_taluk'));
            
            $priest_name = $this->security->xss_clean($this->input->post('priest_name'));
            $priest_mobile = $this->security->xss_clean($this->input->post('priest_mobile'));
            $monthly_income = $this->security->xss_clean($this->input->post('monthly_income'));
            
            $pastor_name = $this->security->xss_clean($this->input->post('pastor_name'));
            $pastor_mobile = $this->security->xss_clean($this->input->post('pastor_mobile'));

            $dyslexia_challenged = $this->security->xss_clean($this->input->post('dyslexia_challenged'));
            $physically_challenged = $this->security->xss_clean($this->input->post('physically_challenged'));

            $hostel_facility = $this->security->xss_clean($this->input->post('hostel_facility'));
            $bus_facility = $this->security->xss_clean($this->input->post('bus_facility'));
            $boarding_point = $this->security->xss_clean($this->input->post('boarding_point'));
            
            
            $documentName = $this->security->xss_clean($this->input->post('documentName'));
            $caste_no = $this->security->xss_clean($this->input->post('caste_no'));
            $income_no = $this->security->xss_clean($this->input->post('income_no'));
            $guardian_relation = $this->security->xss_clean($this->input->post('guardian_relation'));

            $native_taluk = $this->security->xss_clean($this->input->post('native_taluk'));
            $native_state = $this->security->xss_clean($this->input->post('native_state'));
            $native_district = $this->security->xss_clean($this->input->post('native_district'));



            $uploadPath = 'upload/document/'.$this->student_row_id.'/';
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $doc_name = 'priest_certificate';
            $parish_config=['upload_path' => $uploadPath, 'file_name' => $doc_name,
            'allowed_types' => 'pdf|doc|docx|jpg|png|jpeg','max_size' => '1024','overwrite' => TRUE, ];
            $image_file="";
            $this->load->library('upload', $parish_config);
            if($this->upload->do_upload('pastor_file')) {
                $post=$this->input->post();
                $data=$this->upload->data();
                $image_file = $uploadPath.$data['raw_name'].$data['file_ext'];
            }

            
            $priest_config=['upload_path' => $uploadPath, 'file_name' => $doc_name,
            'allowed_types' => 'pdf|doc|docx|jpg|png|jpeg','max_size' => '1024','overwrite' => TRUE, ];
            $this->load->library('upload', $priest_config);
            if($this->upload->do_upload('priest_file')) {
                $priest_config['file_name'] = $doc_name; 
                $post=$this->input->post();
                $data=$this->upload->data();
                $image_path = $uploadPath.$data['raw_name'].$data['file_ext'];
            }

            $config=['upload_path' => $uploadPath,
            'allowed_types' => 'pdf|jpg|png|jpeg','max_size' => '1024','overwrite' => TRUE, ];
            $this->load->library('upload', $config);
            $files = $_FILES;
            $ImgCount = count($_FILES['userfile']['name']);
            for($i = 0; $i < $ImgCount; $i++){
                if(!empty($_FILES['userfile']['name'][$i])){
                    $config['file_name'] = $documentName[$i]; 
                    $_FILES['file']['name']       = $files['userfile']['name'][$i];
                    $_FILES['file']['type']       = $files['userfile']['type'][$i];
                    $_FILES['file']['tmp_name']   = $files['userfile']['tmp_name'][$i];
                    $_FILES['file']['error']      = $files['userfile']['error'][$i];
                    $_FILES['file']['size']       = $files['userfile']['size'][$i];
                    $this->upload->initialize($config);
                    if($this->upload->do_upload('file')){
                        $imageData = $this->upload->data();
                        $uploadImgData[$i] = $uploadPath.$imageData['file_name'];
                    }

                    // if($_FILES['file']['size'] >  105000) {
                    //     $this->session->set_flashdata('error', 'File size should be less than 200KB');
                    //     redirect('viewPersonalDetail');  
                    // } else{
                    //     $this->upload->initialize($config);
                    //     if($this->upload->do_upload('file')){
                    //         $imageData = $this->upload->data();
                    //         $uploadImgData[$i] = $uploadPath.$imageData['file_name'];
                    //     }
                    // }
                }
            }

          



            
        // $personal_info = $this->input->post('personal_info');
        // // parse_str($personal_info, $personalInfoArray);
        // $date_of_birth = str_replace('/', '-', $personalInfoArray['dob']);

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
            'resgisted_tbl_row_id'=> $this->student_row_id,
            'name'=> $fname,
            'dob'=> $date_of_birth,
            'gender'=> $gender,
            'native_place'=> $native_place, 
            'native_taluk'=> $native_taluk, 
            'native_district'=> $native_district, 
            'native_state'=> $native_state, 
            'nationality'=> $nationality,
            'religion'=> $religion,
            'caste'=> $caste,
            'caste_no'=> $caste_no, 
            'income_no'=> $income_no, 
            'monthly_income'=> $monthly_income, 
            'residence_address_taluk' => $residence_address_taluk,
            'permanent_address_taluk' => $permanent_address_taluk,
            'guardian_relation' => $guardian_relation,
            'bus_facility' => $bus_facility,
            'hostel_facility' => $hostel_facility,
            'boarding_point' => $boarding_point,
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
            'admission_year'=> ADMISSION_YEAR,
            'physically_challenged'=> $physically_challenged,
            'dyslexia_challenged'=> $dyslexia_challenged, 
            'created_by'=> $this->student_row_id,
            'created_date'=>date('Y-m-d H:i:s'));

            $studentPersonalInfo = array_map('strtoupper', $studentPersonalInfo);
            $isExist = $this->student_model->checkStudentAlreadyApplied($this->student_row_id);
            if($isExist > 0){
                unset($studentPersonalInfo['created_date']);
                $studentPersonalInfo['updated_by'] = $this->student_row_id;
                $studentPersonalInfo['updated_dtm'] = date('Y-m-d H:i:s');
                $retun_id = $this->student_model->updateStudentPersonalInfo($this->student_row_id,$studentPersonalInfo); 
            }else{
                $retun_id = $this->student_model->saveStudentPersonalInfo($studentPersonalInfo);
            }

            $registrationInfo = array(
                'name' => $fname,
                'email'=> $student_email, 
                'dob'=> $date_of_birth,
                'updated_by' => $this->student_row_id, 
                'updatedDtm' => date('Y-m-d H:i:s'));

                $this->student_model->updateRegisterInfo($this->student_row_id,$registrationInfo); 

            if($retun_id > 0){
                if(!empty($priest_name)){ 
                    $priestCertificateInfo = array(
                        'registered_row_id'=> $this->student_row_id,
                        'priest_name' => $priest_name,
                        'mobile_number' => $priest_mobile,
                        'created_by'=> $this->student_row_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));

                    if(!empty($image_path)){
                        $priestCertificateInfo['certificate_path'] = $image_path;
                    }
                    $isPresent = $this->student_model->checkPriestCertificateExists($this->student_row_id);
                    if($isPresent > 0){
                        unset($priestCertificateInfo['created_date']);
                        $priestCertificateInfo['updated_by'] = $this->student_row_id;
                        $priestCertificateInfo['updated_date_time'] = date('Y-m-d H:i:s');
                        $retun_one = $this->student_model->updatePriestCertificate($this->student_row_id,$priestCertificateInfo); 
                    }else{
                        $retun_one = $this->student_model->savePriestCertificateInfo($priestCertificateInfo);
                    }
                }

                if(!empty($pastor_name)){ 
                    $pastorCertificateInfo = array(
                        'registered_row_id'=> $this->student_row_id,
                        'priest_name' => $pastor_name,
                        'mobile_number' => $pastor_mobile,
                        'created_by'=> $this->student_row_id,
                        'created_date_time'=>date('Y-m-d H:i:s'));
                        
                    if(!empty($image_file)){
                        $pastorCertificateInfo['certificate_path'] = $image_file;
                    }
                    $isExist = $this->student_model->checkPriestCertificateExists($this->student_row_id);
                    if($isExist > 0){
                        unset($pastorCertificateInfo['created_date']);
                        $pastorCertificateInfo['updated_by'] = $this->student_row_id;
                        $pastorCertificateInfo['updated_date_time'] = date('Y-m-d H:i:s');
                        $retun = $this->student_model->updatePriestCertificate($this->student_row_id,$pastorCertificateInfo); 
                    }else{
                        $retun = $this->student_model->savePriestCertificateInfo($pastorCertificateInfo);
                    
                    }
                }


                for($j=0;$j<count($documentName);$j++){
                    if(!empty($uploadImgData[$j])){
                        $certificateInfo = array(
                            'doc_name' => $documentName[$j],
                            'doc_path'=> $uploadImgData[$j], 
                            'registred_row_id' => $this->student_row_id,
                            'created_by' => $this->student_row_id, 
                            'created_date_time' => date('Y-m-d H:i:s'));

                        $isExist = $this->student_model->checkDocumentInfoExists($this->student_row_id,$documentName[$j]);
                        if($isExist > 0){
                            $certificateInfo['updated_by'] = $this->student_row_id;
                            $certificateInfo['updated_date_time'] = date('Y-m-d H:i:s');
                            $result = $this->student_model->updateDocument($this->student_row_id,$certificateInfo,$documentName[$j]); 
                        }else{
                            $result = $this->student_model->addDocument($certificateInfo);
                        }
                    }
                }
            }


            if($retun_id > 0){
                $this->session->set_flashdata('success', 'Personal  Details Added Successfully<br> Please Fill the School Details');
                redirect('viewSchoolDetail');
            } else {
                $this->session->set_flashdata('error', 'Failed to Add Personal Details');
            }
            
        }
    }

    function getStudentApplicationInfo(){
        
        $studentApplicationInfo = $this->student_model->getStudentApplicationInfo($this->student_row_id);
        header('Content-type: text/plain'); 
        header('Content-type: application/json'); 
        echo json_encode($studentApplicationInfo);
        exit(0);
    }
    function saveStudentSchoolInfo(){
        $appStatus = $this->student_model->getStudentApplicationStatus($this->student_row_id);
        if(!empty($appStatus)){
        if($appStatus->admission_status == 1){
            redirect('dashboard');
        }
    }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name_of_the_school','Name of The School','trim|required|max_length[128]');
        $this->form_validation->set_rules('medium','Medium of Instruction','trim|required');
        $this->form_validation->set_rules('school_address','School Address','trim|required|max_length[2000]');
        $this->form_validation->set_rules('year_of_passed','Passing Year','required');
        if($this->form_validation->run() == FALSE) {
            $this->viewSchoolDetail();
        } else {
            $other_board_name="";
            $mark_row_id = "";
            $name_of_the_school = $this->security->xss_clean($this->input->post('name_of_the_school'));
            $medium = $this->security->xss_clean($this->input->post('medium'));
            $school_address = $this->security->xss_clean($this->input->post('school_address'));
            $year_of_passed = $this->security->xss_clean($this->input->post('year_of_passed'));
            $month_of_passed = $this->security->xss_clean($this->input->post('month_of_passed'));
            // $board_name = $this->security->xss_clean($this->input->post('board_name'));
            $other_medium_instruction = $this->security->xss_clean($this->input->post('other_medium_instruction'));
            $doc_name = $this->security->xss_clean($this->input->post('doc_name'));

            $sslc_board_name = $this->security->xss_clean($this->input->post('sslc_board_name'));

            $other_board_name = $this->security->xss_clean($this->input->post('other_board_name'));

            $no_of_attempt = $this->security->xss_clean($this->input->post('no_of_attempt'));
            $register_number = $this->security->xss_clean($this->input->post('register_number'));
            $boardInfo = $this->student_model->getBoardNameById($this->sslc_board_name_id);

            $board_name = $this->registration_model->getBoardNameByName($sslc_board_name);

            $boardName_row_id = $board_name->row_id;
        
            $subject_name = $this->input->post('subject_name');
            $subject_max_mark = $this->input->post('subject_max_mark');
            $subject_obtained = $this->input->post('subject_obtained');
            // $obt_mark_9_std = $this->input->post('obt_mark_9_std');
            $course_row_id = $this->input->post('course_row_id');
            
            
            if($medium == "OTHER"){
                $medium_instruction = $other_medium_instruction;
            }else{
                $medium_instruction = $medium;
            }

            $uploadPath = 'upload/document/'.$this->student_row_id.'/';
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $config=['upload_path' => $uploadPath,
            'allowed_types' => 'pdf|jpg|png|jpeg','max_size' => '1024','overwrite' => TRUE,];
            $this->load->library('upload', $config);
            $files = $_FILES;
            $ImgCount = count($_FILES['userfile']['name']);
            for($i = 0; $i < $ImgCount; $i++){
                if(!empty($_FILES['userfile']['name'][$i])){
                    $config['file_name'] = $doc_name[$i]; 
                    $_FILES['file']['name']       = $files['userfile']['name'][$i];
                    $_FILES['file']['type']       = $files['userfile']['type'][$i];
                    $_FILES['file']['tmp_name']   = $files['userfile']['tmp_name'][$i];
                    $_FILES['file']['error']      = $files['userfile']['error'][$i];
                    $_FILES['file']['size']       = $files['userfile']['size'][$i];
                    $this->upload->initialize($config);
                    if($this->upload->do_upload('file')){
                        $imageData = $this->upload->data();
                        $uploadImgData[$i] = $uploadPath.$imageData['file_name'];
                    }
                    // if($_FILES['file']['size'] >  105000) {
                    //     $this->session->set_flashdata('error', 'File size should be less than 100KB');
                    //     redirect('viewSchoolDetail');  
                    // } else{
                    //     $this->upload->initialize($config);
                    //     if($this->upload->do_upload('file')){
                    //         $imageData = $this->upload->data();
                    //         $uploadImgData[$i] = $uploadPath.$imageData['file_name'];
                    //     }
                    // }
                }
            }
                
                $schoolInfo = array(
                    'name_of_the_school' => $name_of_the_school,
                    'medium_instruction' => $medium_instruction,
                    'sslc_board_name_id' => $board_name->row_id,
                    'no_of_attempt'      => $no_of_attempt,
                    'other_state_board_name'=>$other_board_name,
                    'school_address' => $school_address,
                    'year_of_passed' => $year_of_passed,
                    'month_of_passed' => $month_of_passed,
                    'register_number' => $register_number,
                    'registred_row_id' => $this->student_row_id,
                    'created_by' => $this->student_row_id,
                    'created_date_time' => date('Y-m-d H:i:s'));

                    $Other_board = array(
                        'other_board_name' => $other_board_name,
                         'sslc_board_name_id' => $boardName_row_id); 



            $schoolInfo = array_map('strtoupper', $schoolInfo);
            $isExist = $this->student_model->checkStudentAlreadyFilledschoolInfo($this->student_row_id);
            if($isExist > 0){
                unset($schoolInfo['created_date']);
                unset($schoolInfo['created_by']);
                $schoolInfo['updated_by'] = $this->student_row_id;
                $schoolInfo['updated_date_time'] = date('Y-m-d H:i:s');
                $retun_id = $this->student_model->updateStudentSchoolInfo($this->student_row_id,$schoolInfo);
                $this->student_model->updateBoardInfo($this->student_row_id,$Other_board);
            }else{
                $retun_id = $this->student_model->saveStudentSchoolInfo($schoolInfo);
                $this->student_model->updateBoardInfo($this->student_row_id,$Other_board);

            }

            $markExist = $this->student_model->checkStudentMarkInfoAdded($this->student_row_id);
            if($markExist > 0){
                $deleted_id =  $this->student_model->deleteAllSubject($this->student_row_id);
            }

            if($retun_id > 0){
                    for($j=0;$j<count($doc_name);$j++){
                        if(!empty($uploadImgData[$j])){
                            $certificateInfo = array(
                                'doc_name' => $doc_name[$j],
                                'doc_path'=> $uploadImgData[$j], 
                                'registred_row_id' => $this->student_row_id,
                                'created_by' => $this->student_row_id, 
                                'created_date_time' => date('Y-m-d H:i:s'));
    
                            $isExist = $this->student_model->checkDocumentInfoExists($this->student_row_id,$doc_name[$j]);
                            if($isExist > 0){
                                $certificateInfo['updated_by'] = $this->student_row_id;
                                $certificateInfo['updated_date_time'] = date('Y-m-d H:i:s');
                                $result = $this->student_model->updateDocument($this->student_row_id,$certificateInfo,$doc_name[$j]); 
                            }else{
                                $result = $this->student_model->addDocument($certificateInfo);
                            }
                        }
                    }

                if($sslc_board_name == "CBSE"){
                    for($i=0; $i<5;$i++){
                        // if(!empty($subject_name[$i])){
                            $obtained_mark = ($subject_obtained[$i]);
                            $markInfo = array(
                            'registred_row_id'=>$this->student_row_id,
                            'register_number'=> $register_number,
                            'subject_name'=> $subject_name[$i],
                            'max_mark'=> 100,
                            'obtnd_mark'=> $obtained_mark,
                            'is_deleted'=>0,
                            // 'mark_obt_9_std'=> $obt_mark_9_std[$i],
                            'created_by'=>$this->student_row_id,
                            'created_date_time'=>date('Y-m-d H:i:s'));
                            $markInfo = array_map('strtoupper', $markInfo);
                            if(!empty($course_row_id[$i])){
                                $course_row_id[$i] = $course_row_id[$i];
                            }else{
                                $course_row_id[$i] = 0;
                            }
                            $markExist = $this->student_model->checkSSLCMarkExists($this->student_row_id,$course_row_id[$i]);
                            if($markExist > 0){
                                $markInfo['updated_by'] = $this->student_row_id;
                                $markInfo['updated_date_time'] = date('Y-m-d H:i:s');
                                unset($markInfo['created_date']);
                                unset($markInfo['created_by']);
                                $mark_id = $this->student_model->updateSSLC_MarkInfo($markInfo,$this->student_row_id,$course_row_id[$i]);
                            }else{ 
                                $mark_id = $this->student_model->saveStudentSSLC_MarkInfo($markInfo);
                            }
                        // }
                    }
                }else if($sslc_board_name == "ICSE"){
                    for($i=0; $i<5;$i++){
                        // if(!empty($subject_name[$i])){
                            $obtained_mark = ($subject_obtained[$i]);
                            $markInfo = array(
                            'registred_row_id'=>$this->student_row_id,
                            'register_number'=> $register_number,
                            'subject_name'=> $subject_name[$i],
                            'max_mark'=> 100,
                            'is_deleted'=>0,
                            'obtnd_mark'=> $obtained_mark,
                            // 'mark_obt_9_std'=> $obt_mark_9_std[$i],
                            'created_by'=>$this->student_row_id,
                            'created_date_time'=>date('Y-m-d H:i:s'));
                            $markInfo = array_map('strtoupper', $markInfo);
                            if(!empty($course_row_id[$i])){
                                $course_row_id[$i] = $course_row_id[$i];
                            }else{
                                $course_row_id[$i] = 0;
                            }
                            $markExist = $this->student_model->checkSSLCMarkExists($this->student_row_id,$course_row_id[$i]);
                            if($markExist > 0){
                                unset($markInfo['created_date']);
                                unset($markInfo['created_by']);
                                $markInfo['updated_by'] = $this->student_row_id;
                                $markInfo['updated_date_time'] = date('Y-m-d H:i:s');
                                $mark_id = $this->student_model->updateSSLC_MarkInfo($markInfo,$this->student_row_id,$course_row_id[$i]);
                            }else{ 
                                $mark_id = $this->student_model->saveStudentSSLC_MarkInfo($markInfo);
                            }
                        // }
                    }
                }else{
                    for($i=0; $i<6;$i++){
                    //    if(!empty($subject_name[$i])){
                        $markInfo = array(
                            'registred_row_id'=>$this->student_row_id,
                            'register_number'=> $register_number,
                            'subject_name'=> $subject_name[$i],
                            'max_mark'=> $subject_max_mark[$i],
                            'obtnd_mark'=> $subject_obtained[$i],
                            'is_deleted'=>0,
                            // 'mark_obt_9_std'=> $obt_mark_9_std[$i],
                            'created_by'=>$this->student_row_id,
                            'created_date_time'=>date('Y-m-d H:i:s'));
                            $markInfo = array_map('strtoupper', $markInfo);
                            if(!empty($course_row_id[$i])){
                                $course_row_id[$i] = $course_row_id[$i];
                            }else{
                                $course_row_id[$i] = 0;
                            }
                            $markExist = $this->student_model->checkSSLCMarkExists($this->student_row_id,$course_row_id[$i]);
                            if($markExist > 0){
                                unset($markInfo['created_date']);
                                unset($markInfo['created_by']);
                                $markInfo['updated_by'] = $this->student_row_id;
                                $markInfo['updated_date_time'] = date('Y-m-d H:i:s');
                                $mark_id = $this->student_model->updateSSLC_MarkInfo($markInfo,$this->student_row_id,$course_row_id[$i]);
                            }else{ 
                                $mark_id = $this->student_model->saveStudentSSLC_MarkInfo($markInfo);
                            }
                    //    }
                    }
                }
            }
            if($retun_id > 0) {
                $this->session->set_flashdata('success', 'School Details Added Successfully<br> Please Fill the Combination Details');
                redirect('viewCombinationDetail');
                
            } else {
                $this->session->set_flashdata('error', 'Failed to Add Academic Details');
            }
        }
    }
    
    function getStudentSchoolExamInfo(){
        $studentApplicationInfo = $this->student_model->getStudentApplicationInfo($this->student_row_id);
        header('Content-type: text/plain'); 
        header('Content-type: application/json'); 
        echo json_encode($studentApplicationInfo);
        exit(0);
    }

    function saveAdmissionInfo(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('language_second','Second Language','trim|required');
        $this->form_validation->set_rules('program_name','Program Name','trim|required');
        $this->form_validation->set_rules('stream_name','School Address','trim|required');
        // $this->form_validation->set_rules('sports','National Level Sports','required');
        // $this->form_validation->set_rules('ncc','NCC','trim|required');
        if($this->form_validation->run() == FALSE) {
            $this->viewCombinationDetail();
        } else {
            $language_second = $this->security->xss_clean($this->input->post('language_second'));
            $program_name = $this->security->xss_clean($this->input->post('program_name'));
            $stream_name = $this->security->xss_clean($this->input->post('stream_name'));
            $second_stream_name = $this->security->xss_clean($this->input->post('second_stream_name'));
            $second_program_name = $this->security->xss_clean($this->input->post('second_program_name'));
            $integrated_batch = $this->security->xss_clean($this->input->post('integrated_batch'));

            $sports = $this->security->xss_clean($this->input->post('sports'));
            $ncc = $this->security->xss_clean($this->input->post('ncc'));
            $doc_name = $this->security->xss_clean($this->input->post('doc_name'));

            $uploadPath = 'upload/document/'.$this->student_row_id.'/';
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $config=['upload_path' => $uploadPath,
            'allowed_types' => 'pdf|jpg|png|jpeg','max_size' => '1024','overwrite' => TRUE,];
            $this->load->library('upload', $config);
            $files = $_FILES;
            $ImgCount = count($_FILES['userfile']['name']);
            for($i = 0; $i < $ImgCount; $i++){
                if(!empty($_FILES['userfile']['name'][$i])){
                    $config['file_name'] = $doc_name[$i]; 
                    $_FILES['file']['name']       = $files['userfile']['name'][$i];
                    $_FILES['file']['type']       = $files['userfile']['type'][$i];
                    $_FILES['file']['tmp_name']   = $files['userfile']['tmp_name'][$i];
                    $_FILES['file']['error']      = $files['userfile']['error'][$i];
                    $_FILES['file']['size']       = $files['userfile']['size'][$i];

                    $this->upload->initialize($config);
                    if($this->upload->do_upload('file')){
                        $imageData = $this->upload->data();
                        $uploadImgData[$i] = $uploadPath.$imageData['file_name'];
                    }

                    // if($_FILES['file']['size'] >  105000) {
                    //     $this->session->set_flashdata('error', 'File size should be less than 100KB');
                    //     redirect('viewCombinationDetail');  
                    // } else{
                    //     $this->upload->initialize($config);
                    //     if($this->upload->do_upload('file')){
                    //         $imageData = $this->upload->data();
                    //         $uploadImgData[$i] = $uploadPath.$imageData['file_name'];
                    //     }
                    // }
                }
            }

            $admissionInfo = array(
                'registred_row_id' => $this->student_row_id,
                'first_language' => 'ENGLISH',
                'second_language' => $language_second,
                'program_name' => $program_name,
                'stream_name' => $stream_name,
                'second_stream_name' => $second_stream_name,
                'second_program_name' => $second_program_name,
                'national_level_sports_status' => $sports,
                'ncc_certificate_status' => $ncc,
                'integrated_batch'       =>$integrated_batch,
                'created_by' => $this->student_row_id,
                'created_date_time' => date('Y-m-d H:i:s'));
                $addExist = $this->student_model->checkAdmissionInfoAdded($this->student_row_id);
                if($addExist > 0){
                    unset($admissionInfo['registred_row_id']);
                    unset($admissionInfo['created_date']);
                    unset($admissionInfo['created_by']);
                    $admissionInfo['updated_by'] = $this->student_row_id;
                    $admissionInfo['updated_date_time'] = date('Y-m-d H:i:s');
                    $retun_id = $this->student_model->updateAdmissionInfo($this->student_row_id,$admissionInfo);
                }else{
                    $retun_id = $this->student_model->saveAdmissionInfo($admissionInfo);
                }
            
            if($retun_id > 0){
                for($j=0;$j<count($doc_name);$j++){
                    if(!empty($uploadImgData[$j])){
                        $certificateInfo = array(
                            'doc_name' => $doc_name[$j],
                            'doc_path'=> $uploadImgData[$j], 
                            'registred_row_id' => $this->student_row_id,
                            'created_by' => $this->student_row_id, 
                            'created_date_time' => date('Y-m-d H:i:s'));

                        $isExist = $this->student_model->checkDocumentInfoExists($this->student_row_id,$doc_name[$j]);
                        if($isExist > 0){
                            $certificateInfo['updated_by'] = $this->student_row_id;
                            $certificateInfo['updated_date_time'] = date('Y-m-d H:i:s');
                            $result = $this->student_model->updateDocument($this->student_row_id,$certificateInfo,$doc_name[$j]); 
                        }else{
                            $result = $this->student_model->addDocument($certificateInfo);
                        }
                    }
                }
            }

            if($retun_id > 0) {
                // $this->session->set_flashdata('success', 'Combination and Language Details Added Successfully<br>Please Pay the Fees');
                $boardData = $this->student_model->getStudentBoardInformation($this->student_row_id);                
                     $sslc_id = $boardData->sslc_board_name_id;
                    $boardInfo = $this->student_model->getBoardNameById($sslc_id);
                    $studentMarkInfo = $this->student_model->getStudentMarkInfo($this->student_row_id);
                    $total_max_mark = 0;
                    $total_ninth_mark = 0;
                    $total_mark = 0;
                    $totalPercentage = 0; 
                    if($boardInfo->board_name == "CBSE"){
                        foreach($studentMarkInfo as $mark){
                            $total_max_mark += $mark->max_mark;  
                            $total_mark += $mark->obtnd_mark;
                            // $total_ninth_mark += $mark->mark_obt_9_std;
                            $totalPercentage = ($total_mark / $total_max_mark) * 100;
                            // $totalNinthPercentage = ($total_ninth_mark / $total_max_mark) * 100;
                        }
                    } else if($boardInfo->board_name == "ICSE"){
                        $markInfo = array_slice($studentMarkInfo, 0, 5, true);
                        foreach($markInfo as $mark){
                            $total_max_mark += $mark->max_mark;  
                            $total_mark += $mark->obtnd_mark;
                            // $total_ninth_mark += $mark->mark_obt_9_std;
                            $totalPercentage = ($total_mark / $total_max_mark) * 100;
                            // $totalNinthPercentage = ($total_ninth_mark / $total_max_mark) * 100;
                        }
                    } else {
                        foreach($studentMarkInfo as $mark){
                            if($mark->subject_name == 'EXEMPTED'){
                                $max_mark = 0;  
                            }else{
                                $max_mark = $mark->max_mark;  
                            }
                            $total_mark += $mark->obtnd_mark;
                            // $total_ninth_mark += $mark->mark_obt_9_std;
                            $total_max_mark += $max_mark; 
                            if($max_mark == 0){
                                $totalPercentage = 0;
                            } else{
                                $totalPercentage = ($total_mark / $total_max_mark) * 100;

                            }
                            // $totalNinthPercentage = ($total_ninth_mark / $total_max_mark) * 100;
                        }
                    }
                    $total_percentage = round($totalPercentage,2);

                    if(is_nan($total_percentage)){
                        $total_percentage = 0;
                    }
                    // $total_ninth_percentage = round($totalNinthPercentage,2);
                    // $isApplied = $this->student_model->getStudentApplication_2021($this->student_row_id);
                    // if(empty($isApplied)){
                    //     $regInfo = array(
                    //         'registered_row_id'=> $this->student_row_id,
                    //     );
                    //     $row_id = $this->student_model->saveStudentApplicationReg_2021($regInfo);
                    //     $applicationNumber = '22'.sprintf('%04d', $row_id);
                    // }else{
                    //     $applicationNumber = '22'.sprintf('%04d', $isApplied->row_id);
                    // }


                    $existsApplicationStatus = $this->student_model->checkStudentAdmissionStatus($this->student_row_id);
                    if(empty($existsApplicationStatus)){
                        $isExistsApplicationNumber = $this->student_model->getPreviousStudentApplicationInfo();
                        if(!empty($isExistsApplicationNumber)){
                            $appNo = substr($isExistsApplicationNumber->application_number,2);

                             $appliNo = $appNo + 1;
                            $applicationNumber = '24'.sprintf('%04d', $appliNo);
                        }else {
                               $applicationNumber = '24'.sprintf('%04d', 1);

                               }
                            }else{
                                $applicationNumber = $existsApplicationStatus->application_number;
                            }


                    $isExists = $this->student_model->checkStudentAdmissionStatus($this->student_row_id);
                    if(!empty($isExists)){

               
                $applicationStatus = array(
                    'adm_year' => 2024,
                    'application_number'=> $applicationNumber,
                    'registered_row_id' => $this->student_row_id,
                    'sslc_percentage' => $total_percentage,
                    // 'ninth_percentage' => $total_ninth_percentage,
                    // 'application_fee_status' => 1,
                    'admission_status'=> 0,
                    'updated_by' => $this->student_row_id,
                    'updated_date_time' => date('Y-m-d H:i:s'));

                    $retun = $this->student_model->updateStudentApplicationStatus($this->student_row_id,$applicationStatus);
                }else{

                    $applicationStatus = array(
                        'adm_year' => 2024,
                        'registered_row_id' => $this->student_row_id,
                        'application_number'=> $applicationNumber,
                        'sslc_percentage' => $total_percentage,
                        // 'application_fee_status' => 1,
                        // 'ninth_percentage' => $total_ninth_percentage,
                        'admission_status'=> 0,
                        'created_by' => $this->student_row_id,
                        'created_date_time' => date('Y-m-d H:i:s'));
                        $retun = $this->student_model->saveStudentApplicationStatus($applicationStatus);
                }

               

                    $studentPersonalInfo = array(
                        'student_application_status'=> 0,
                        'application_number'=> $applicationNumber,
                        'sslc_percentage' => $total_percentage,
                        // 'ninth_percentage' => $total_ninth_percentage,
                        'updated_by' => $this->student_row_id,
                        'updated_dtm' => date('Y-m-d H:i:s'));

                      
                $retun_id = $this->student_model->updateStudentPersonalInfo($this->student_row_id,$studentPersonalInfo);
               
                $this->session->set_flashdata('success', 'Application Successfully Submitted');
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Failed to Add Combination and Language Details');
            }
        }
    }

    function studentFinalSubmission(){
        // $this->load->library('form_validation');
        // $this->form_validation->set_rules('stream_name','Stream Name','trim|required');
        // if($this->form_validation->run() == FALSE) {
        //     $this->viewPersonalDetail();
        // } else {
            $boardData = $this->student_model->getStudentBoardInformation($this->student_row_id);                
             $sslc_id = $boardData->sslc_board_name_id;
            $boardInfo = $this->student_model->getBoardNameById($sslc_id);
            $studentMarkInfo = $this->student_model->getStudentMarkInfo($this->student_row_id);
            $total_max_mark = 0;
            $total_mark = 0;
            $total_ninth_mark = 0;
            $totalPercentage = 0; 
            if($boardInfo->board_name == "CBSE"){
                foreach($studentMarkInfo as $mark){
                    $total_max_mark += $mark->max_mark;  
                    $total_mark += $mark->obtnd_mark;
                    // $total_ninth_mark += $mark->mark_obt_9_std;
                    $totalPercentage = ($total_mark / $total_max_mark) * 100;
                    // $totalNinthPercentage = ($total_ninth_mark / $total_max_mark) * 100;
                }
            } else if($boardInfo->board_name == "ICSE"){
                $markInfo = array_slice($studentMarkInfo, 0, 5, true);
                foreach($markInfo as $mark){
                    $total_max_mark += $mark->max_mark;  
                    $total_mark += $mark->obtnd_mark;
                    // $total_ninth_mark += $mark->mark_obt_9_std;
                    $totalPercentage = ($total_mark / $total_max_mark) * 100;
                    // $totalNinthPercentage = ($total_ninth_mark / $total_max_mark) * 100;
                }
            } else {
                foreach($studentMarkInfo as $mark){
                    if($mark->subject_name == 'EXEMPTED'){
                        $max_mark = 0;  
                    }else{
                        $max_mark = $mark->max_mark;  
                    }
                    $total_mark += $mark->obtnd_mark;
                    // $total_ninth_mark += $mark->mark_obt_9_std;
                    $total_max_mark += $max_mark;  
                    $totalPercentage = ($total_mark / $total_max_mark) * 100;
                    // $totalNinthPercentage = ($total_ninth_mark / $total_max_mark) * 100;
                }
            }
            $total_percentage = round($totalPercentage,2);
            // $total_ninth_percentage = round($totalNinthPercentage,2);
            $applicationNumber = '22'.sprintf('%04d', $this->student_row_id);
            
            $studentPersonalInfo = array(
                'application_number'=> $applicationNumber,
                'student_application_status'=> 0,
                'sslc_percentage' => $total_percentage,
                // 'ninth_percentage' => $total_ninth_percentage,
                'updated_by' => $this->student_row_id,
                'updated_dtm' => date('Y-m-d H:i:s')
            );

            $applicationStatus = array(
                'application_number'=> $applicationNumber,
                'registered_row_id' => $this->student_row_id,
                'sslc_percentage' => $total_percentage,
                // 'ninth_percentage' => $total_ninth_percentage,
                'admission_status'=> 0,
                'updated_by' => $this->student_row_id,
                'updated_date_time' => date('Y-m-d H:i:s'));
                
            $isExists = $this->student_model->checkStudentAdmissionStatus($this->student_row_id);
            if(!empty($isExists)){
                $retun = $this->student_model->updateStudentApplicationStatus($this->student_row_id,$applicationStatus);
            }else{
                $retun = $this->student_model->saveStudentApplicationStatus($applicationStatus);
            }
            $retun_id = $this->student_model->updateStudentPersonalInfo($this->student_row_id,$studentPersonalInfo);

            if($retun_id > 0) {
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Failed to Submit Application');
            }
        // }
    }


    // payment 
    public function paymentDetail() {

        $ORDER_ID = "";
	    $requestParamList = array();
	    $responseParamList = array();
        $boardData = $this->student_model->getStudentBoardInformation($this->student_row_id);                
        $sslc_id = $boardData->sslc_board_name_id;
       $boardInfo = $this->student_model->getBoardNameById($sslc_id);
       $data['boardInfo'] = $boardInfo;
        $student = $this->student_model->getStudentApplicationInfo($this->student_row_id);
        $data['studentAdmissionInfo'] = $this->student_model->getAdmissionInfo($this->student_row_id);
      
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Payment';
        $data['application_applied_status'] = false;
        $_SESSION['application_status'] = false; 
        if(!empty($student)){
            $application_status = $student->student_application_status;
        }else{
            $application_status = 0;
        }
        $data['payment_status'] = false;
        $data['isValidChecksum'] = "";
        $paymentInfo = $this->student_model->getAllApplicationPaymentLog($this->student_row_id);
        if(!empty($student->application_number)){
            $data['application_applied_status'] = true;
        }
        if(!empty($paymentInfo)){
            foreach($paymentInfo as $pay){
                $ORDER_ID = $pay->order_id;
                $requestParamList = array("MID" => PAYTM_MERCHANT_MID , "ORDERID" => $ORDER_ID);  
		
                $StatusCheckSum = getChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY);
                
                $requestParamList['CHECKSUMHASH'] = $StatusCheckSum;
        
                // Call the PG's getTxnStatusNew() function for verifying the transaction status.
                $responseParamList = getTxnStatusNew($requestParamList);
                if($responseParamList['STATUS'] == 'TXN_SUCCESS'){
                    $data['payment_status'] = true;
                    $payInfo = array(
                        'tran_id' =>$responseParamList['TXNID'],
                        'tran_date' => $responseParamList['TXNDATE'],
                        'amount' => $responseParamList['TXNAMOUNT'],
                        'payment_mode'=>$responseParamList['PAYMENTMODE'],
                        'payment_status'=>$responseParamList['STATUS']
                    );
                    $this->student_model->updateApplicationPaymentLogOrderID($responseParamList['ORDERID'],$payInfo);
                    $boardData = $this->student_model->getStudentBoardInformation($this->student_row_id);                
                     $sslc_id = $boardData->sslc_board_name_id;
                    $boardInfo = $this->student_model->getBoardNameById($sslc_id);
                    $studentMarkInfo = $this->student_model->getStudentMarkInfo($this->student_row_id);
                    $total_max_mark = 0;
                    $total_ninth_mark = 0;
                    $total_mark = 0;
                    $totalPercentage = 0; 
                    if($boardInfo->board_name == "CBSE"){
                        foreach($studentMarkInfo as $mark){
                            $total_max_mark += $mark->max_mark;  
                            $total_mark += $mark->obtnd_mark;
                            // $total_ninth_mark += $mark->mark_obt_9_std;
                            $totalPercentage = ($total_mark / $total_max_mark) * 100;
                            // $totalNinthPercentage = ($total_ninth_mark / $total_max_mark) * 100;
                        }
                    } else if($boardInfo->board_name == "ICSE"){
                        $markInfo = array_slice($studentMarkInfo, 0, 5, true);
                        foreach($markInfo as $mark){
                            $total_max_mark += $mark->max_mark;  
                            $total_mark += $mark->obtnd_mark;
                            // $total_ninth_mark += $mark->mark_obt_9_std;
                            $totalPercentage = ($total_mark / $total_max_mark) * 100;
                            // $totalNinthPercentage = ($total_ninth_mark / $total_max_mark) * 100;
                        }
                    } else {
                        foreach($studentMarkInfo as $mark){
                            if($mark->subject_name == 'EXEMPTED'){
                                $max_mark = 0;  
                            }else{
                                $max_mark = $mark->max_mark;  
                            }
                            $total_mark += $mark->obtnd_mark;
                            // $total_ninth_mark += $mark->mark_obt_9_std;
                            $total_max_mark += $max_mark;  
                            $totalPercentage = ($total_mark / $total_max_mark) * 100;
                            // $totalNinthPercentage = ($total_ninth_mark / $total_max_mark) * 100;
                        }
                    }
                    $total_percentage = round($totalPercentage,2);
                    // $total_ninth_percentage = round($totalNinthPercentage,2);
                    // $isApplied = $this->student_model->getStudentApplication_2021($this->student_row_id);
                    // if(empty($isApplied)){
                    //     $regInfo = array(
                    //         'registered_row_id'=> $this->student_row_id,
                    //     );
                    //     $row_id = $this->student_model->saveStudentApplicationReg_2021($regInfo);
                    //     $applicationNumber = '22'.sprintf('%04d', $row_id);
                    // }else{
                    //     $applicationNumber = '22'.sprintf('%04d', $isApplied->row_id);
                    // }


                    $existsApplicationStatus = $this->student_model->checkStudentAdmissionStatus($this->student_row_id);
                    if(empty($existsApplicationStatus)){
                        $isExistsApplicationNumber = $this->student_model->getPreviousStudentApplicationInfo();
                        if(!empty($isExistsApplicationNumber)){
                            $appNo = substr($isExistsApplicationNumber->application_number,2);

                             $appliNo = $appNo + 1;
                            $applicationNumber = '24'.sprintf('%04d', $appliNo);
                        }else {
                               $applicationNumber = '24'.sprintf('%04d', 1);

                               }
                            }else{
                                $applicationNumber = $existsApplicationStatus->application_number;
                            }


                    $isExists = $this->student_model->checkStudentAdmissionStatus($this->student_row_id);
                    if(!empty($isExists)){

               
                $applicationStatus = array(
                    'adm_year' => 2024,
                    'application_number'=> $applicationNumber,
                    'registered_row_id' => $this->student_row_id,
                    'sslc_percentage' => $total_percentage,
                    // 'ninth_percentage' => $total_ninth_percentage,
                    // 'application_fee_status' => 1,
                    'admission_status'=> 0,
                    'updated_by' => $this->student_row_id,
                    'updated_date_time' => date('Y-m-d H:i:s'));

                    $retun = $this->student_model->updateStudentApplicationStatus($this->student_row_id,$applicationStatus);
                }else{

                    $applicationStatus = array(
                        'adm_year' => 2024,
                        'registered_row_id' => $this->student_row_id,
                        'application_number'=> $applicationNumber,
                        'sslc_percentage' => $total_percentage,
                        // 'ninth_percentage' => $total_ninth_percentage,
                        'admission_status'=> 0,
                        'updated_by' => $this->student_row_id,
                        'updated_date_time' => date('Y-m-d H:i:s'));
                        $retun = $this->student_model->saveStudentApplicationStatus($applicationStatus);
                }

               

                    $studentPersonalInfo = array(
                        'student_application_status'=> 0,
                        'application_number'=> $applicationNumber,
                        'sslc_percentage' => $total_percentage,
                        // 'ninth_percentage' => $total_ninth_percentage,
                        'updated_by' => $this->student_row_id,
                        'updated_dtm' => date('Y-m-d H:i:s'));

                      
                $retun_id = $this->student_model->updateStudentPersonalInfo($this->student_row_id,$studentPersonalInfo);
               
                
                if($retun_id > 0){
                    $data['application_applied_status'] = true;
                }else{
                    $data['application_applied_status'] = false;
                }
                }
            }
        }
       

        //$data['responseParamList'] = $responseParamList;
        $studentt = $this->student_model->getStudentApplicationStatus($this->student_row_id);
        $data['studentInfo'] = $studentt;
        if($application_status == 1){
            $this->loadViews("dashboard", $this->global, $data, NULL);  
        }else{
            $this->loadViews("admission/payment", $this->global , $data ,NULL);
           
        }
    }



    function payTmPaymentProcess(){ 
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");
        $checkSum = "";
        $paramList = array();

        $isExists = $this->student_model->getStudentApplication_Details($this->student_row_id);

        $boardData = $this->student_model->getStudentBoardInformation($this->student_row_id);                
        $sslc_id = $boardData->sslc_board_name_id;
       $boardInfo = $this->student_model->getBoardNameById($sslc_id);

    //    if($boardInfo->board_name =="ICSE" || $boardInfo->board_name=="CBSE"){

    //     if(!empty($isExists->application_number)){
    //         $TXN_AMOUNT = 75.00;
    //         $payment_type = 'PROSPECTIVE FEE';

    //     }else{
    //         $TXN_AMOUNT = 125.00;
    //         $payment_type = 'APPLICATION FEE';

    //     }
    // }else{

    //     if(!empty($isExists->application_number)){
    //         $TXN_AMOUNT = 75.00;
    //         $payment_type = 'PROSPECTIVE FEE';

    //     }else{
    //         $TXN_AMOUNT = 25.00;
    //         $payment_type = 'APPLICATION FEE';

    //     }


    // }

      $TXN_AMOUNT = 25.00;
      $payment_type = 'APPLICATION FEE';

       
        $CUST_ID = "STXPUC".$this->student_row_id;
        $INDUSTRY_TYPE_ID = "Retail";
        $CHANNEL_ID = "WEB";

        $payInfo = array(
            'm_id' =>PAYTM_MERCHANT_MID,
            'registered_tbl_row_id' => $this->student_row_id,
            'amount' => $TXN_AMOUNT,
            'payment_type' =>$payment_type,
            'created_by' => $this->student_row_id,
            'created_date_time' => date('Y-m-d H:i:s'));
        $response = $this->student_model->addApplicationPaymentLog($payInfo);
        if($response > 0){
                $ORDER_ID = 'APPF22w'.$response;
            
            $payInfo = array(
                'order_id' =>$ORDER_ID);
            $this->student_model->updateApplicationPaymentLog($response,$payInfo);
            $_SESSION['order_id'] = $ORDER_ID;
        }

        // Create an array having all required parameters for creating checksum.
        $paramList["MID"] = PAYTM_MERCHANT_MID;
        $paramList["ORDER_ID"] = $ORDER_ID;
        $paramList["CUST_ID"] = $CUST_ID;
        $paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
        $paramList["CHANNEL_ID"] = $CHANNEL_ID;
        $paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
        $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;


        $paramList["CALLBACK_URL"] = base_url()."payTmPaymentResponse";
        /*$paramList["MSISDN"] = $MSISDN; //Mobile number of customer
        $paramList["EMAIL"] = $EMAIL; //Email ID of customer
        $paramList["VERIFIED_BY"] = "EMAIL"; //
        $paramList["IS_USER_VERIFIED"] = "YES"; //

        */

        //Here checksum string will return by getChecksumFromArray() function.
        $checkSum = getChecksumFromArray($paramList,PAYTM_MERCHANT_KEY);
        $data['checkSum'] = $checkSum;
        $data['paramList'] = $paramList;
        $this->global['pageTitle'] = ''.TAB_TITLE.' : PayTm Payment';
        $this->loadViews("admission/paytm_payment_process", $this->global , $data ,NULL);

    }


    function payTmPaymentResponse(){
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");

        $paytmChecksum = "";
        $paramList = array();
        $isValidChecksum = "FALSE";

        $boardData = $this->student_model->getStudentBoardInformation($this->student_row_id);                
        $sslc_id = $boardData->sslc_board_name_id;
       $boardInfo = $this->student_model->getBoardNameById($sslc_id);
       $data['boardInfo'] = $boardInfo;
        
        $paramList = $_POST;
        $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
        $data['application_applied_status'] = false;
        //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
        $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.
        if($isValidChecksum == true){ 
            if($_POST['STATUS'] == 'TXN_SUCCESS'){ 
                $payInfo = array(
                    'tran_id' =>$_POST['TXNID'],
                    'tran_date' => $_POST['TXNDATE'],
                    'amount' => $_POST['TXNAMOUNT'],
                    'payment_mode'=>$_POST['PAYMENTMODE'],
                    'payment_status'=>$_POST['STATUS']);

                    $boardData = $this->student_model->getStudentBoardInformation($this->student_row_id);
                  
                        $sslc_id = $boardData->sslc_board_name_id;
                    
                    $boardInfo = $this->student_model->getBoardNameById($sslc_id);
                    $studentMarkInfo = $this->student_model->getStudentMarkInfo($this->student_row_id);
                    $total_max_mark = 0;
                    $total_mark = 0;
                    $total_ninth_mark = 0;
                    $totalPercentage = 0; 
                    if($boardInfo->board_name == "CBSE"){
                        foreach($studentMarkInfo as $mark){
                            $total_max_mark += $mark->max_mark;  
                            $total_mark += $mark->obtnd_mark;
                            // $total_ninth_mark += $mark->mark_obt_9_std;
                            $totalPercentage = ($total_mark / $total_max_mark) * 100;
                            // $totalNinthPercentage = ($total_ninth_mark / $total_max_mark) * 100;
                        }
                    } else if($boardInfo->board_name == "ICSE"){
                        $markInfo = array_slice($studentMarkInfo, 0, 5, true);
                        foreach($markInfo as $mark){
                            $total_max_mark += $mark->max_mark;  
                            $total_mark += $mark->obtnd_mark;
                            // $total_ninth_mark += $mark->mark_obt_9_std;
                            $totalPercentage = ($total_mark / $total_max_mark) * 100;
                            // $totalNinthPercentage = ($total_ninth_mark / $total_max_mark) * 100;
                        }
                    } else {
                        foreach($studentMarkInfo as $mark){
                            if($mark->subject_name == 'EXEMPTED'){
                                $max_mark = 0;  
                            }else{
                                $max_mark = $mark->max_mark;  
                            }
                            $total_mark += $mark->obtnd_mark;
                            // $total_ninth_mark += $mark->mark_obt_9_std;
                            $total_max_mark += $max_mark;  
                            $totalPercentage = ($total_mark / $total_max_mark) * 100;
                            // $totalNinthPercentage = ($total_ninth_mark / $total_max_mark) * 100;
                        }
                    }
                    $total_percentage = round($totalPercentage,2);
                    // $total_ninth_percentage = round($totalNinthPercentage,2);

                          
                    $existsApplicationStatus = $this->student_model->checkStudentAdmissionStatus($this->student_row_id);
                    if(empty($existsApplicationStatus)){
                        $isExistsApplicationNumber = $this->student_model->getPreviousStudentApplicationInfo();
                        if(!empty($isExistsApplicationNumber)){
                            $appNo = substr($isExistsApplicationNumber->application_number,2);

                             $appliNo = $appNo + 1;
                            $applicationNumber = '24'.sprintf('%04d', $appliNo);
                        }else {
                               $applicationNumber = '24'.sprintf('%04d', 1);

                               }
                            }else{
                                $applicationNumber = $existsApplicationStatus->application_number;
                            }


                    $isExists = $this->student_model->checkStudentAdmissionStatus($this->student_row_id);
                    if(!empty($isExists)){

               
                $applicationStatus = array(
                    'adm_year' => 2024,
                    'application_number'=> $applicationNumber,
                    'registered_row_id' => $this->student_row_id,
                    'sslc_percentage' => $total_percentage,
                    // 'ninth_percentage' => $total_ninth_percentage,
                    // 'application_fee_status' => 1,
                    'admission_status'=> 0,
                    'updated_by' => $this->student_row_id,
                    'updated_date_time' => date('Y-m-d H:i:s'));

                    $retun = $this->student_model->updateStudentApplicationStatus($this->student_row_id,$applicationStatus);
                }else{

                    $applicationStatus = array(
                        'adm_year' => 2024,
                        'registered_row_id' => $this->student_row_id,
                        'application_number'=> $applicationNumber,
                        'sslc_percentage' => $total_percentage,
                        // 'ninth_percentage' => $total_ninth_percentage,
                        'admission_status'=> 0,
                        'updated_by' => $this->student_row_id,
                        'updated_date_time' => date('Y-m-d H:i:s'));
                        $retun = $this->student_model->saveStudentApplicationStatus($applicationStatus);
                }

                $student = $this->student_model->getStudentApplicationInfo($this->student_row_id);

                $amountt = $_POST['TXNAMOUNT'];

                if($student->application_number== ''){


                $studentPersonalInfo = array(
                    'application_number'=> $applicationNumber,
                    'student_application_status'=> 0,
                    'sslc_percentage' => $total_percentage,
                    // 'ninth_percentage' => $total_ninth_percentage,
                    'updated_by' => $this->student_row_id,
                    'updated_dtm' => date('Y-m-d H:i:s'));
    
                
                    
               
                $retun_id = $this->student_model->updateStudentPersonalInfo($this->student_row_id,$studentPersonalInfo);

                }

                
                if($retun > 0){
                    $data['application_applied_status'] = true;
                }else{
                    $data['application_applied_status'] = false;
                }
                
            } else{
                $payInfo = array(
                    'tran_id' =>$_POST['TXNID'],
                    'tran_date' => $_POST['TXNDATE'],
                    'amount' => $_POST['TXNAMOUNT'],
                    'payment_mode'=>$_POST['PAYMENTMODE'],
                    'payment_status'=>$_POST['STATUS']
                );  
            }
        }
        $this->student_model->updateApplicationPaymentLogOrderID($_POST['ORDERID'],$payInfo);
        $data['isValidChecksum'] = $isValidChecksum;
        $data['paramList'] = $paramList;
        $data['payment_status'] = false;
        $data['payment_done_now'] = false;
        if($isValidChecksum == "TRUE") {
            if ($_POST["STATUS"] == "TXN_SUCCESS") {
                $data['payment_status'] = true;
                $data['payment_done_now'] = true;
                
                $paymentStatus = array(
                    'registered_row_id' => $this->student_row_id,
                    // 'application_fee_status' => 1,
                    'updated_by' => $this->student_row_id,
                    'updated_date_time' => date('Y-m-d H:i:s'));
                    
                $isExists = $this->student_model->checkStudentAdmissionStatus($this->student_row_id);
                if(!empty($isExists)){
                    $retun = $this->student_model->updateStudentApplicationStatus($this->student_row_id,$paymentStatus);
                }else{
                    $retun = $this->student_model->saveStudentApplicationStatus($paymentStatus);
                }
            }
            else {
                $data['payment_status'] = false;
                $data['payment_done_now'] = false;
            }
                
        }
        else {
            $data['payment_done_now'] = false;
            $data['payment_status'] = false;
        }
        $studentt = $this->student_model->getStudentApplicationStatus($this->student_row_id);
        $data['studentInfo'] = $studentt;
        redirect('paymentDetail');

    }


    public function saveWebsiteAdmissionGrievance(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('subject','Subject','trim|required|max_length[120]');
        $this->form_validation->set_rules('message','Message','trim|required|max_length[200]');
        if($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $subject = $this->security->xss_clean($this->input->post('subject'));
            $message = $this->security->xss_clean($this->input->post('message'));
    
            $messageInfo = array(
                'registered_row_id' => $this->student_row_id,
                'subject' => $subject,
                'message' => $message,
                'status' => 1,
                'created_by' => $this->student_row_id,
                'created_date_time' => date('Y-m-d H:i:s'));
            $retun_id = $this->student_model->addWebsiteAdmissionGrievance($messageInfo);

            if($retun_id > 0) {
                $this->session->set_flashdata('success', 'Message Sent Successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to Send Message');
            }
            $this->index();
        }
    }
    function updateStudentBoardInfo(){
        if($this->input->server('REQUEST_METHOD') === 'POST'){
            $sslc_board_name = trim($this->security->xss_clean($this->input->post('sslc_board_name')));
            $boardInfo = $this->registration_model->getBoardNameByName($sslc_board_name);
            $updateData = array(
                'sslc_board_name_id'=> $boardInfo->row_id,
                'other_board_name'=> $this->security->xss_clean($this->input->post('other_board_name')),
                'updated_by' => $this->student_row_id,
                'updatedDtm' => date('Y-m-d H:i:s')
            );
            $result =  $this->registration_model->updateStudentRegistrationInfo($this->student_row_id,$updateData);
            if($result){
                $this->student_model->deleteAllSubject($this->registration_number);
                $this->session->set_userdata('sslc_board_name_id', $boardInfo->row_id);
                $this->session->set_flashdata('success', 'Board Updated Successfully');
            } 
            else $this->session->set_flashdata('error', 'Failed to update board');
        }else{
            $this->session->set_flashdata('error', 'Something went wrong..!');
        }
        redirect('viewSchoolDetail');
    }
}
?>
