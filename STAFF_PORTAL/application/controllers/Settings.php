<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Settings extends BaseController {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        $this->load->model('staff_model','staff');
        $this->load->model('settings_model','settings');
        $this->load->model('students_model','student');
        $this->load->model('timetable_model','timetable');
        $this->load->model('admission_model','admission');
        $this->load->model('transport_model', 'transport');
        $this->load->model('fee_model','fee');
        $this->isLoggedIn();
    }
    public function viewSettings(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {
            

            $data['shiftInfo'] = $this->settings->getAllShiftInfo();
            $data['departmentInfo'] = $this->settings->getAllDepartmentInfo();
            $data['religionInfo'] = $this->settings->getAllReligionInfo();
            $data['nationalityInfo'] = $this->settings->getAllNationalityInfo();
            $data['casteInfo'] = $this->settings->getAllCasteInfo();
            $data['categoryInfo'] = $this->settings->getAllCategoryInfo();
            $data['streamInfo'] = $this->settings->getStreamInfo();
            $data['weekName'] = $this->timetable->getAllWeekName();
            // $data['sectionInfo'] = $this->settings->getSectionInfo($filter);
            $data['classTimingsInfo'] = $this->settings->getAllClassTimingsInfo();
            $data['timetableShiftInfo'] = $this->settings->getAllTimetableDayShiftingInfo();
            $data['remarkNameInfo'] = $this->settings->getRemarkNameInfo();
            $data['settingInfo'] = $this->transport->getTransportNameInfo();
            $data['miscellaneousTypeInfo'] = $this->settings->getAllMiscellaneousTypeInfo();
            $data['feeNameInfo'] ="";// $this->settings->getAllFeeNameInfo();
            $data['postInfo'] = "";// $this->settings->getAllPostInfo();
            $data['feeTypeInfo'] = "";//$this->settings->getAllFeeTypeInfo();


            $this->global['pageTitle'] = ''.TAB_TITLE.' : Settings';
            $this->loadViews("settings/settingsDashboard", $this->global, $data, null);  
          
            // $feeInfo = $this->fee->getOverallFeeInfo();
            // foreach($feeInfo as $fee){
            //     $studentInfo = $this->student->getStudentInfoByRowId($fee->application_no);
            //     $filter['stream_name'] = $studentInfo->stream_name;
            //     $filter['term_name'] = $studentInfo->term_name;
            //     $filter['fee_year'] = CURRENT_YEAR;
            //     $total_fee_obj = $this->fee->getTotalFeeAmount($filter);
            //     $paid_amt = $this->fee->getFeesPaidInfo($fee->application_no,CURRENT_YEAR,$fee->row_id);
            //     $total_amt = $total_fee_obj->total_fee - $paid_amt;
            //     if(($total_amt - $fee->paid_amount) == 0){
            //         $status = 0;
            //     }else{
            //         $status = 1;
            //     }
            //     $feeInfo = array('total_amount'=>$total_amt,'pending_balance'=>$total_amt - $fee->paid_amount,'fee_pending_status' => $status);
            //     $result = $this->fee->updateOverallFee($feeInfo,$fee->row_id);
            // }
        }
    }

    function addDepartment()
    {
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE)
        {
            $this->loadThis();
        }  else {
            $dept_id =$this->security->xss_clean($this->input->post('dept_id'));
            $dept_name =$this->security->xss_clean($this->input->post('dept_name'));
            $isExist = $this->settings->checkDeptIdExists($dept_id);
            if($isExist > 0){
                $this->session->set_flashdata('warning', 'Department ID already exists!');
                redirect('viewSettings');
            }else{
                $departmentInfo = array('dept_id'=>$dept_id,'name'=>$dept_name);
                $result = $this->settings->addDepartment($departmentInfo);
                if($result > 0){
                    $this->session->set_flashdata('success', 'New Department created successfully');
                } else{
                    $this->session->set_flashdata('error', 'Department creation failed');
                }
                redirect('viewSettings');

            }
        }
    }

    /**
     * This function is used to add Religion Details
     */
    function addReligion()
    {
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE)
        {
            $this->loadThis();
        }  else {
            $religion =$this->security->xss_clean($this->input->post('religion'));
                $religionInfo = array('name'=>$religion,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));
                $result = $this->settings->addReligion($religionInfo);
            if($result > 0){
                $this->session->set_flashdata('success', 'New Religion created successfully');
            } else{
                $this->session->set_flashdata('error', 'Religion creation failed');
            }
            redirect('viewSettings');
        }
        
    }

      /**
     * This function is used to add Cast Details
     */
    function addCaste()
    {
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE)
        {
            $this->loadThis();
        }  else {
            $caste =$this->security->xss_clean($this->input->post('caste'));
            $isExist = $this->settings->checkCasteExists($caste);
            if($isExist > 0){
                $this->session->set_flashdata('warning', 'Caste already exists!');
            }else{
                $castInfo = array('name'=>$caste,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                $result = $this->settings->addCaste($castInfo);
                if($result > 0){
                    $this->session->set_flashdata('success', 'New Caste created successfully');
                } else{
                    $this->session->set_flashdata('error', 'Caste creation failed');
                }
            }
            redirect('viewSettings');
        }
    }
    /**
     * This function is used to add Nationality Details
     */
    function addNationality()
    {
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE)
        {
            $this->loadThis();
        }  else {
                $nationality =$this->security->xss_clean($this->input->post('nationality'));
            $nationalityInfo = array('name'=>$nationality,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));
            $result = $this->settings->addNationality($nationalityInfo);
            if($result > 0){
                $this->session->set_flashdata('success', 'New Nationality created successfully');
            } else{
                $this->session->set_flashdata('error', 'Nationality creation failed');
            }
            redirect('viewSettings');
        }
    }

     /**
     * This function is used to add Category Details
     */
    function addCategory()
    {
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE)
        {
            $this->loadThis();
        }  else {
            $category =$this->security->xss_clean($this->input->post('category'));
            $categoryInfo = array('category_name'=>$category,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));
            $result = $this->settings->addCategory($categoryInfo);
            if($result > 0){
                $this->session->set_flashdata('success', 'New Category created successfully');
            } else{
                $this->session->set_flashdata('error', 'Category creation failed');
            }
            redirect('viewSettings');
        }
    }
    
    public function deleteNationality(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $nationalityInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateNationality($nationalityInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function deleteReligion(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $religionInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateReligion($religionInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function deleteCaste(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $casteInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateCaste($casteInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function deleteCategory(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $categoryInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateCategory($categoryInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function deleteDepartment(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $deptInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateDepartment($deptInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    
    public function addClassTimings(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {
            $start_time_hh =$this->security->xss_clean($this->input->post('start_time_hh'));
            $start_time_mm =$this->security->xss_clean($this->input->post('start_time_mm'));
            $end_time_hh =$this->security->xss_clean($this->input->post('end_time_hh'));
            $end_time_mm =$this->security->xss_clean($this->input->post('end_time_mm'));
            $week_id =$this->security->xss_clean($this->input->post('week_id'));
            $start_time = $start_time_hh.':'.$start_time_mm;
            $end_time = $end_time_hh.':'.$end_time_mm;

            $isExist = $this->settings->checkClassTimingsExists($start_time,$end_time,$week_id);
            if($isExist > 0){
                $this->session->set_flashdata('warning', 'Class Timings already exists!');
            }else{
                $classInfo = array(
                    'start_time'=>$start_time,
                    'end_time'=>$end_time,
                    'week_row_id'=>$week_id,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));

                $result = $this->settings->addTimings($classInfo);
                        
                if($result > 0){
                    $this->session->set_flashdata('success', 'Class Timings Added successfully');
                } else{
                    $this->session->set_flashdata('error', 'Class Timings creation failed');
                }
            }
            redirect('viewSettings');
        }
    }

    public function deleteClassTimings(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $classInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateClassTimings($classInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    
    // add day shifting info
    public function addTimetableDayShifting() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $week_id = $this->security->xss_clean($this->input->post('week_id'));
            $date = $this->security->xss_clean($this->input->post('date'));
            $shift_date = date('Y-m-d',strtotime($date));

            $isExist = $this->settings->checkTimetableShiftingExists($week_id,$shift_date);
            if($isExist > 0){
                $this->session->set_flashdata('warning', 'Time table day shift already exists!');
                redirect('viewSettings');
            }else{
                $shiftingInfo = array(
                    'week_id'=>$week_id,
                    'date'=> $shift_date,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                $result = $this->settings->addDayShiftingInfo($shiftingInfo);
            }
            if($result > 0){
                $this->session->set_flashdata('success', 'Shifting Info added successfully');
            } else{
                $this->session->set_flashdata('error', 'Shifting Info creation failed');
            }
            redirect('viewSettings');
        }
    }
    public function deleteDayShifting(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $shiftInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateTimetableDayShift($shiftInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    
    public function addFeesName(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {
            $fee_name =ucwords($this->security->xss_clean($this->input->post('fee_name')));

            $isExist = $this->settings->checkFeeNameExists($fee_name);
            if($isExist > 0){
                $this->session->set_flashdata('warning', 'Fee Name already exists!');
            }else{
                $feeInfo = array(
                    'fee_name'=>$fee_name,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));

                $result = $this->settings->addFeesName($feeInfo);
                        
                if($result > 0){
                    $this->session->set_flashdata('success', 'Fee Name Added successfully');
                } else{
                    $this->session->set_flashdata('error', 'Fee Name creation failed');
                }
            }
            redirect('viewSettings');
        }
    }

    public function deleteFeeName(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feeInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateFeeNameInfo($feeInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    // election
    function addPost(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE)
        {
            $this->loadThis();
        }  else {
            $post_name =$this->security->xss_clean($this->input->post('post_name'));
            $postInfo = array('post_name'=>$post_name,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));
            $result = $this->settings->addPost($postInfo);
            if($result > 0){
                $this->session->set_flashdata('success', 'New Post created successfully');
            } else{
                $this->session->set_flashdata('error', 'Post creation failed');
            }
            redirect('viewSettings');
        }
    }



    public function deletePost(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $post_id = $this->input->post('post_id');
            $postInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->updatePost($postInfo, $post_id);
            // log_message('debug','post'.print_r($postInfo));
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    
    // fee type
    function addFeeType(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE) {
            $this->loadThis();
        }  else {
            $feeType =$this->security->xss_clean($this->input->post('feeType'));
            $feeInfo = array('feeType'=>$feeType,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));
            $result = $this->settings->addFeeType($feeInfo);
            if($result > 0){
                $this->session->set_flashdata('success', 'New Fee Type created successfully');
            } else{
                $this->session->set_flashdata('error', 'Fee Type creation failed');
            }
            redirect('viewSettings');
        }
    }



    public function deleteFeeType(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $feeInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateFeeType($feeInfo, $row_id);
            // log_message('debug','post'.print_r($postInfo));
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
    
    public function getNewAdmittedStudentsImport(){
        $config=['upload_path' => './upload/',
        'allowed_types' => 'xlsx|csv|xls','max_size' => '102400','overwrite' => TRUE,
        ];
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('excelFile')) {
            $error = array('error' => $this->upload->display_errors());
        } else { 
            $data = array('upload_data' => $this->upload->data());
        }
       if (!empty($data['upload_data']['file_name'])) {
            $import_xls_file = $data['upload_data']['file_name'];
        } else {
            $import_xls_file = 0;
        }
        $inputFileName = 'upload/'. $import_xls_file;
       
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                    . '": ' . $e->getMessage());
        }
       
        $excelValues = array();
        $excelValues2 = array();
        $sheetCount = $objPHPExcel->getSheetCount();
        $sheetNames = $objPHPExcel->getSheet();
        $objWorksheet = $objPHPExcel->getActiveSheet($sheetCount);
        $row_index = $objWorksheet->getHighestRow(); 
        $col_name = $objWorksheet->getHighestColumn();
        $headings = array();
        $cell_config = array(); 
        $row_count = 1;
        $total_records = 0;
        $highestRow = $objWorksheet->getHighestDataRow(); 
        $highestColumn = $objWorksheet->getHighestDataColumn();
        $total_fields = 2;
        $student_count = 0;
        $studentNotExistCount = 0;
        $student_update_count = 0;
        $app_no = array();
        // $highestRow

        for($i=2;$i<=$highestRow;$i++){
            $admission_no = $objWorksheet->getCellByColumnAndRow(0,$i)->getFormattedValue();
            $student_name = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();
            $program_name = $objWorksheet->getCellByColumnAndRow(2,$i)->getFormattedValue();
            $stream_name = $objWorksheet->getCellByColumnAndRow(3,$i)->getFormattedValue();
            $dob = $objWorksheet->getCellByColumnAndRow(4,$i)->getFormattedValue();
            $gender = $objWorksheet->getCellByColumnAndRow(5,$i)->getFormattedValue();
            $register_no = $objWorksheet->getCellByColumnAndRow(6,$i)->getFormattedValue();
            $student_id  = $objWorksheet->getCellByColumnAndRow(7,$i)->getFormattedValue();
            $sat_number  = $objWorksheet->getCellByColumnAndRow(8,$i)->getFormattedValue();
            $aadhar_no  = $objWorksheet->getCellByColumnAndRow(9,$i)->getFormattedValue();
            $religion = $objWorksheet->getCellByColumnAndRow(10,$i)->getFormattedValue();
            $caste = $objWorksheet->getCellByColumnAndRow(11,$i)->getFormattedValue();
            $mother_tongue = $objWorksheet->getCellByColumnAndRow(12,$i)->getFormattedValue();
            $present_address = $objWorksheet->getCellByColumnAndRow(13,$i)->getFormattedValue();
            $permanent_address = $objWorksheet->getCellByColumnAndRow(14,$i)->getFormattedValue();
            $father_name = $objWorksheet->getCellByColumnAndRow(15,$i)->getFormattedValue();
            $father_profession = $objWorksheet->getCellByColumnAndRow(16,$i)->getFormattedValue();
            $mother_name = $objWorksheet->getCellByColumnAndRow(17,$i)->getFormattedValue();
            $mother_profession = $objWorksheet->getCellByColumnAndRow(18,$i)->getFormattedValue();
            $mobile = $objWorksheet->getCellByColumnAndRow(19,$i)->getFormattedValue();
            $email = $objWorksheet->getCellByColumnAndRow(20,$i)->getFormattedValue();
            $date_of_admission = $objWorksheet->getCellByColumnAndRow(21,$i)->getFormattedValue();
            $intake_year = $objWorksheet->getCellByColumnAndRow(22,$i)->getFormattedValue();
            $Is_physically_challenged = $objWorksheet->getCellByColumnAndRow(23,$i)->getFormattedValue();
            $term_name = $objWorksheet->getCellByColumnAndRow(24,$i)->getFormattedValue();
            $language_one = $objWorksheet->getCellByColumnAndRow(25,$i)->getFormattedValue();
            $language_two = $objWorksheet->getCellByColumnAndRow(26,$i)->getFormattedValue();
            $dobs = str_replace("/", "-", $dob); 
            $doa = str_replace("/", "-", $date_of_admission); 
            if(!empty($admission_no)){
                    $student_info = array(
                    'admission_no'=>$admission_no,
                    'student_name'=>$student_name,
                    'program_name' => $program_name,
                    'stream_name'=>$stream_name,
                    'dob' => date('Y-m-d',strtotime($dobs)),
                    'gender' => $gender,
                    'register_no' => $register_no,
                    'student_id' => strtoupper($student_id),
                    'sat_number'=>$sat_number,
                    'aadhar_no' => $aadhar_no,
                    'religion'=>$religion, 
                    'caste'=>$caste, 
                    'mother_tongue'=>$mother_tongue,
                    'present_address' => $present_address,
                    'permanent_address' => $permanent_address,
                    'father_name'=>$father_name, 
                    'father_profession'=>$father_profession,
                    'mother_name'=>$mother_name,
                    'mother_profession' => $mother_profession,
                    'mobile' => $mobile,
                    'email' => $email,
                     'date_of_admission'=>date('Y-m-d',strtotime($doa)),
                     'intake_year'=>$intake_year,  
                     'Is_physically_challenged' => $Is_physically_challenged,
                     'term_name' =>$term_name,
                     'language_one' =>$language_one,
                     'language_two' =>$language_two,
                    'is_active' => 1,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
               
                  
                    $return = $this->student->addstudentData($student_info);
                 
              log_message('debug','student=='.print_r($application_no,true));
        }
    }
    $student_count++;
        redirect('viewSettings');
    }




    
    // // update missing fields
    // public function addStudentMissingData(){
    //     $config=['upload_path' => './upload/',
    //     'allowed_types' => 'xlsx|csv|xls','max_size' => '102400','overwrite' => TRUE,
    //     ];
    //     $this->load->library('upload', $config);
    //     if (!$this->upload->do_upload('excelFile')) {
    //         $error = array('error' => $this->upload->display_errors());
    //     } else { 
    //         $data = array('upload_data' => $this->upload->data());
    //     }
    //    if (!empty($data['upload_data']['file_name'])) {
    //         $import_xls_file = $data['upload_data']['file_name'];
    //     } else {
    //         $import_xls_file = 0;
    //     }
    //     $inputFileName = 'upload/'. $import_xls_file;
       
    //     try {
    //         $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    //         $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    //         $objPHPExcel = $objReader->load($inputFileName);
    //     } catch (Exception $e) {
    //         die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
    //                 . '": ' . $e->getMessage());
    //     }
       
    //     $excelValues = array();
    //     $excelValues2 = array();
    //     $sheetCount = $objPHPExcel->getSheetCount();
    //     $sheetNames = $objPHPExcel->getSheet();
    //     $objWorksheet = $objPHPExcel->getActiveSheet($sheetCount);
    //     $row_index = $objWorksheet->getHighestRow(); 
    //     $col_name = $objWorksheet->getHighestColumn();
    //     $headings = array();
    //     $cell_config = array(); 
    //     $row_count = 1;
    //     $total_records = 0;
    //     $highestRow = $objWorksheet->getHighestDataRow(); 
    //     $highestColumn = $objWorksheet->getHighestDataColumn();
    //     $total_fields = 2;
    //     $student_count = 0;
    //     $studentNotExistCount = 0;
    //     $student_update_count = 0;
    //     $app_no = array();

    //     for($i=2;$i<=$highestRow;$i++){
    //         $name = $objWorksheet->getCellByColumnAndRow(2,$i)->getFormattedValue();
    //         $fname = $objWorksheet->getCellByColumnAndRow(3,$i)->getFormattedValue();
    //         $mname = $objWorksheet->getCellByColumnAndRow(4,$i)->getFormattedValue();
    //         $student_id = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();
    //         // $sat_no = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();
    //         // $application_no = $objWorksheet->getCellByColumnAndRow(0,$i)->getFormattedValue();
    //         // $date_of_admission = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();

    //         $date_of_admission = date('d-m-Y',strtotime($date_of_admission));
    //         // log_message('debug','Info = '.print_r($studentInfo,true));
    //         if(!empty($student_id)){
    //             $student_info = array(
    //                 'student_name'=>$name,
    //                 'father_name'=>$fname,
    //                 'mother_name'=>$mname,
    //             // 'date_of_admission'=>$date_of_admission,
    //             // 'sat_number' => $sat_no,
    //             // 'updated_by'=>$this->staff_id,
    //             // 'updated_date_time'=>date('Y-m-d H:i:s')
    //         );
    //                 // log_message('debug','Info std = '.print_r($student_info,true));
    //                 // log_message('debug','student_id std = '.$student_id);
    //                 $result = $this->student->updateStudentInfoBStdId($student_info,$student_id);
    //                 // $result = $this->student->updateStudentInfoApp($student_info,$application_no);
    //                 $student_count++;
    //         }else{
    //             $studentNotExistCount++;
    //             // array_push($app_no,$application_number);
    //         }
    //     }
    //     log_message('debug','Student NOT Count= '.$studentNotExistCount);
    //     log_message('debug','Total Count= '.$student_count);
    //     redirect('viewSettings');
    // }

    
    // // update missing fields
    public function addStudentMissingData(){
        $config=['upload_path' => './upload/',
        'allowed_types' => 'xlsx|csv|xls','max_size' => '102400','overwrite' => TRUE,
        ];
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('excelFile')) {
            $error = array('error' => $this->upload->display_errors());
        } else { 
            $data = array('upload_data' => $this->upload->data());
        }
       if (!empty($data['upload_data']['file_name'])) {
            $import_xls_file = $data['upload_data']['file_name'];
        } else {
            $import_xls_file = 0;
        }
        $inputFileName = 'upload/'. $import_xls_file;
       
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                    . '": ' . $e->getMessage());
        }
       
        $excelValues = array();
        $excelValues2 = array();
        $sheetCount = $objPHPExcel->getSheetCount();
        $sheetNames = $objPHPExcel->getSheet();
        $objWorksheet = $objPHPExcel->getActiveSheet($sheetCount);
        $row_index = $objWorksheet->getHighestRow(); 
        $col_name = $objWorksheet->getHighestColumn();
        $headings = array();
        $cell_config = array(); 
        $row_count = 1;
        $total_records = 0;
        $highestRow = $objWorksheet->getHighestDataRow(); 
        $highestColumn = $objWorksheet->getHighestDataColumn();
        $total_fields = 2;
        $student_count = 0;
        $studentNotExistCount = 0;
        $student_update_count = 0;
        $app_no = array();

        for($i=3;$i<=$highestRow;$i++){
          
           
             $student_id = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();
             $student_id_new = $objWorksheet->getCellByColumnAndRow(2,$i)->getFormattedValue();
            // $name = $objWorksheet->getCellByColumnAndRow(2,$i)->getFormattedValue();
            // $fname = $objWorksheet->getCellByColumnAndRow(3,$i)->getFormattedValue();
            // $mname = $objWorksheet->getCellByColumnAndRow(4,$i)->getFormattedValue();
            // $application_no = $objWorksheet->getCellByColumnAndRow(2,$i)->getFormattedValue();
            // $section = $objWorksheet->getCellByColumnAndRow(5,$i)->getFormattedValue();
            // $sat_no = $objWorksheet->getCellByColumnAndRow(3,$i)->getFormattedValue();
            // $application_no = $objWorksheet->getCellByColumnAndRow(0,$i)->getFormattedValue();
            // $date_of_admission = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();

            // $date_of_admission = date('d-m-Y',strtotime($date_of_admission));
            // log_message('debug','Info = '.print_r($studentInfo,true));
            if(!empty($student_id)){
                $student_info = array(
                    // 'student_name'=>$name,
                    // 'father_name'=>$fname,
                    // 'mother_name'=>$mname,
                     'elective_sub'=>trim($student_id_new),
                     
                    //  'section_name' => $section,
                    // 'student_no'=>$student_no,
                    // 'pu_board_number'=>$student_no,
                    // 'sat_number'=>$sat_no,
                // 'date_of_admission'=>$date_of_admission,
                // 'sat_number' => $sat_no,
                'updated_by'=>$this->staff_id,
                'updated_date_time'=>date('Y-m-d H:i:s')
            );
                    log_message('debug','Info std = '.print_r($student_info,true));
                    // log_message('debug','student_id std = '.$student_id);
                    // $result = $this->student->updateStudentInfoAdmissionNo($student_info,$application_no);
                    $result = $this->student->updateStudentInfoBStdId($student_info,$student_id);
                    $student_count++;
            }else{
              //  $studentNotExistCount++;
            //  log_message('debug','student_id NotExist'.$student_id);
                // array_push($app_no,$application_number);
            }
        }
        // log_message('debug','notUpdated '.$studentNotExistCount);
       // log_message('debug','Student NOT Count= '.$studentNotExistCount);
     log_message('debug','Total Count= '.$student_count);
        redirect('viewSettings');
    }



    // // update missing fields
    public function addLibData(){
        $config=['upload_path' => './upload/',
        'allowed_types' => 'xlsx|csv|xls','max_size' => '102400','overwrite' => TRUE,
        ];
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('excelFile')) {
            $error = array('error' => $this->upload->display_errors());
        } else { 
            $data = array('upload_data' => $this->upload->data());
        }
       if (!empty($data['upload_data']['file_name'])) {
            $import_xls_file = $data['upload_data']['file_name'];
        } else {
            $import_xls_file = 0;
        }
        $inputFileName = 'upload/'. $import_xls_file;
       
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                    . '": ' . $e->getMessage());
        }
       
        $excelValues = array();
        $excelValues2 = array();
        $sheetCount = $objPHPExcel->getSheetCount();
        $sheetNames = $objPHPExcel->getSheet();
        $objWorksheet = $objPHPExcel->getActiveSheet($sheetCount);
        $row_index = $objWorksheet->getHighestRow(); 
        $col_name = $objWorksheet->getHighestColumn();
        $headings = array();
        $cell_config = array(); 
        $row_count = 1;
        $highestRow = $objWorksheet->getHighestDataRow(); 
        $highestColumn = $objWorksheet->getHighestDataColumn();
        $total_fields = 2;
      $count = 0;
        //$studentNotExistCount = 0;
        //$student_update_count = 0;
       // $app_no = array();

       for($i=3;$i<=$highestRow;$i++){
          
           
        $access_code = $objWorksheet->getCellByColumnAndRow(0,$i)->getFormattedValue();
        $book_title = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();
        $category = $objWorksheet->getCellByColumnAndRow(2,$i)->getFormattedValue();
        $publisher_name = $objWorksheet->getCellByColumnAndRow(3,$i)->getFormattedValue();
        $author_name = $objWorksheet->getCellByColumnAndRow(4,$i)->getFormattedValue();
        $price = $objWorksheet->getCellByColumnAndRow(5,$i)->getFormattedValue();
        $no_of_copies = $objWorksheet->getCellByColumnAndRow(6,$i)->getFormattedValue();
        $year = $objWorksheet->getCellByColumnAndRow(7,$i)->getFormattedValue();
        $no_of_page = $objWorksheet->getCellByColumnAndRow(8,$i)->getFormattedValue();


        // $date_of_admission = date('d-m-Y',strtotime($date_of_admission));
        // log_message('debug','Info = '.print_r($studentInfo,true));
        if(!empty($access_code)){
            $book_info = array(
                'access_code'=>trim($access_code),
                'book_title'=>strtoupper($book_title),
                'category'=>strtoupper($category),
                'publisher_name'=>strtoupper($publisher_name),
                 'author_name'=>strtoupper($author_name),
                 'price' =>trim($price),
                 'no_of_copies' =>trim($no_of_copies),
                 'year' =>trim($year),
                 'no_of_page' =>trim($no_of_page),
            //     // 'student_no'=>$student_no,
            //     // 'pu_board_number'=>$student_no,
            //     // 'sat_number'=>$sat_no,
            // // 'date_of_admission'=>$date_of_admission,
            // // 'sat_number' => $sat_no,
            // 'updated_by'=>$this->staff_id,
            // 'updated_date_time'=>date('Y-m-d H:i:s')
        );
               
                // log_message('debug','student_id std = '.$student_id);
                // $result = $this->student->updateStudentInfoAdmissionNo($student_info,$application_no);
                
                //$result = $this->settings->updateBook($book_info,$access_code);
                $result = $this->settings->addBookInfo($book_info);
                $student_count++;
                log_message('debug','Info std = '.print_r($book_info,true));
        }
        //else{
          //  $studentNotExistCount++;
        //  log_message('debug','student_id NotExist'.$student_id);
            // array_push($app_no,$application_number);
        //}
    }  log_message('debug','Info std = '.print_r($student_count,true));
    // log_message('debug','Info std = '.print_r($student_count,true));
    //  log_message('debug','notUpdated '.$studentNotExistCount);
    // log_message('debug','Student NOT Count= '.$studentNotExistCount);
    // log_message('debug','Total Count= '.$student_count);
    redirect('viewSettings');
}






          public function addAllApprovedStudent(){
         
            $studentInfo = $this->admission->getAllAdmittedStudentInfo();
            
            foreach($studentInfo as $std){  

            $permanent_add = $std->permanent_address_line_1.' '.$std->permanent_address_line_2.' '.$std->permanent_address_district.','.$std->permanent_address_state.','.$std->permanent_address_pincode;
            $present_add = $std->residential_address_line_1.' '.$std->residential_address_line_2.' '.$std->residential_address_district.','.$std->residential_address_state.','.$std->residential_address_pincode;

                           
                $isExists = $this->student->getStudentByApplication_no($std->application_number);
                if(!empty($isExists)){
                    $student_info = array(
                    'student_name'=>$std->name,
                    'blood_group' =>$std->blood_group,
                    'mobile' => $std->student_mobile,
                    'email' => $std->email,
                    'gender' => $std->gender,
                    'residential_address' => $permanent_add,
                    'category' => $std->student_category,
                    'last_board_name' => $std->board_name,
                    'last_percentage' => $std->sslc_percentage,
                    'last_register_number' => $std->register_number,
                    'is_physically_challenged' => $std->physically_challenged,
                    'is_dyslexic' => $std->dyslexia_challenged,
                    'present_address' => $present_add,
                    'mother_tongue'=>$std->mother_tongue,
                    'nationality'=>$std->nationality,  
                    'religion'=>$std->religion, 
                    'caste'=>$std->caste, 
                    'sub_caste' => $std->sub_caste,
                    'father_name'=>$std->father_name, 
                    'father_email' => $std->father_email,
                    'father_mobile' => $std->father_mobile,
                    'father_educational_qualification' => $std->father_qualification,
                    'father_age' => $std->father_age,
                    'father_profession'=>$std->father_profession,
                    'mother_name'=>$std->mother_name,
                    'mother_email' => $std->mother_email,
                    'mother_mobile' => $std->mother_mobile,
                    'mother_educational_qualification' => $std->mother_qualification,
                    'mother_age' => $std->mother_age,
                    'mother_profession' => $std->mother_profession,
                    'father_annual_income'=>$std->father_annual_income,
                    'mother_annual_income'=>$std->mother_annual_income,
                    'guardian_name' => $std->guardian_name,
                    'guardian_mobile' => $std->guardian_mobile,
                    'guardian_address' => $std->guardian_address,
                    'native_place' => $std->native_place,
                    'aadhar_no' => $std->aadhar_no,
                    'dob' => $std->dob,
                    'updated_by'=>$this->staff_id,
                    'updated_date_time'=>date('Y-m-d H:i:s'));

                    $return = $this->student->updateStudentInfoByAppNo($student_info,$std->application_number);
                
            }
        }
        $this->session->set_flashdata('success', 'Updated successfully');
        redirect('viewSettings');
    

}


    // // update missing fields
    public function updateStdInfo(){
        $config=['upload_path' => './upload/',
        'allowed_types' => 'xlsx|csv|xls','max_size' => '102400','overwrite' => TRUE,
        ];
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('excelFile')) {
            $error = array('error' => $this->upload->display_errors());
        } else { 
            $data = array('upload_data' => $this->upload->data());
        }
       if (!empty($data['upload_data']['file_name'])) {
            $import_xls_file = $data['upload_data']['file_name'];
        } else {
            $import_xls_file = 0;
        }
        $inputFileName = 'upload/'. $import_xls_file;
       
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                    . '": ' . $e->getMessage());
        }
       
        $excelValues = array();
        $excelValues2 = array();
        $sheetCount = $objPHPExcel->getSheetCount();
        $sheetNames = $objPHPExcel->getSheet();
        $objWorksheet = $objPHPExcel->getActiveSheet($sheetCount);
        $row_index = $objWorksheet->getHighestRow(); 
        $col_name = $objWorksheet->getHighestColumn();
        $headings = array();
        $cell_config = array(); 
        $row_count = 1;
        $total_records = 0;
        $highestRow = $objWorksheet->getHighestDataRow(); 
        $highestColumn = $objWorksheet->getHighestDataColumn();
        $total_fields = 2;
        $student_count = 0;
        $studentNotExistCount = 0;
        $student_update_count = 0;
        $app_no = array();

        for($i=6;$i<=$highestRow;$i++){
          
           
            $student_id = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();
            $name = $objWorksheet->getCellByColumnAndRow(2,$i)->getFormattedValue();
            $subject = $objWorksheet->getCellByColumnAndRow(3,$i)->getFormattedValue();
            $mobile_one = $objWorksheet->getCellByColumnAndRow(5,$i)->getFormattedValue();
            $mobile_two = $objWorksheet->getCellByColumnAndRow(6,$i)->getFormattedValue();
            $section_name = $objWorksheet->getCellByColumnAndRow(7,$i)->getFormattedValue();
 log_message('debug','student_id std = '.$student_id);

            if($subject == "KAN"){
                $elective_sub = 'KANNADA';
            }else if($subject == "HIN"){
                $elective_sub = 'HINDI';
            }
           
           //elective subject update
            if(!empty($student_id)){
                $electiveInfo = array(
                'elective_sub'=>$elective_sub,
                'section_name'=>$section_name,
                'updated_by'=>$this->staff_id,
                'updated_date_time'=>date('Y-m-d H:i:s')
            );
                 $result = $this->student->updateStudentInfoBStdId($electiveInfo,trim($student_id));
             }

             //elective subject update
            if(!empty($mobile_one)){
                $mobileInfo = array(
                'mobile'=>$mobile_one,
                'updated_by'=>$this->staff_id,
                'updated_date_time'=>date('Y-m-d H:i:s')
            );
                 $result2 = $this->student->updateStudentInfoBStdId($mobileInfo,trim($student_id));
           }
                if(!empty($mobile_two)){
                $mobile2Info = array(
                'mobile_two'=>$mobile_two,
                'updated_by'=>$this->staff_id,
                'updated_date_time'=>date('Y-m-d H:i:s')
            );
                $result3 = $this->student->updateStudentInfoBStdId($mobile2Info,trim($student_id));
            }
                    log_message('debug','Info std = '.print_r($electiveInfo,true));
                     log_message('debug','mobileInfo std = '.print_r($mobileInfo,true));
                      log_message('debug','mobile2Info std = '.print_r($mobile2Info,true));
                    // log_message('debug','student_id std = '.$student_id);
                    // $result = $this->student->updateStudentInfoAdmissionNo($student_info,$application_no);
                   
             }      
                    
                    $student_count++;
            // }else{
            //     $studentNotExistCount++;
            //   log_message('debug','student_id NotExist'.$student_id);
            //     // array_push($app_no,$application_number);
            // }
       
         log_message('debug','notUpdated '.$studentNotExistCount);
        log_message('debug','Student NOT Count= '.$studentNotExistCount);
        log_message('debug','Total Count= '.$student_count);
        redirect('viewSettings');
       
    }


    function addRemarkName(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }  else {
                $remark_name =$this->security->xss_clean($this->input->post('remark_name'));
                $remarkInfo = array('remark_name'=>$remark_name,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                    $result = $this->settings->addRemarkName($remarkInfo);
                if($result > 0){
                    $this->session->set_flashdata('success', 'New Student Remark created successfully');
                } else{
                    $this->session->set_flashdata('error', 'Student Remark creation failed');
                }
                redirect('viewSettings');
        }
        
    }


    public function deleteRemarkName(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $remarkInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->deleteRemarkName($remarkInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function addStudentMissingFields2(){
        $config=['upload_path' => './upload/',
        'allowed_types' => 'xlsx|csv|xls','max_size' => '102400','overwrite' => TRUE,
        ];
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('excelFile')) {
            $error = array('error' => $this->upload->display_errors());
        } else { 
            $data = array('upload_data' => $this->upload->data());
        }
       if (!empty($data['upload_data']['file_name'])) {
            $import_xls_file = $data['upload_data']['file_name'];
        } else {
            $import_xls_file = 0;
        }
        $inputFileName = 'upload/'. $import_xls_file;
       
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                    . '": ' . $e->getMessage());
        }
       
        $excelValues = array();
        $excelValues2 = array();
        $sheetCount = $objPHPExcel->getSheetCount();
        $sheetNames = $objPHPExcel->getSheet();
        $objWorksheet = $objPHPExcel->getActiveSheet($sheetCount);
        $row_index = $objWorksheet->getHighestRow(); 
        $col_name = $objWorksheet->getHighestColumn();
        $headings = array();
        $cell_config = array(); 
        $row_count = 1;
        $highestRow = $objWorksheet->getHighestDataRow(); 
        $highestColumn = $objWorksheet->getHighestDataColumn();
        $total_fields = 2;
        $count = 0;


        for($i=3;$i<=$highestRow;$i++){
            
            // $application_no = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();
            $register_no = $objWorksheet->getCellByColumnAndRow(1,$i)->getFormattedValue();
            $student_name = $objWorksheet->getCellByColumnAndRow(2,$i)->getFormattedValue();
            $program_name = $objWorksheet->getCellByColumnAndRow(3,$i)->getFormattedValue();
            $stream_name = $objWorksheet->getCellByColumnAndRow(4,$i)->getFormattedValue();
            $elective_sub = $objWorksheet->getCellByColumnAndRow(5,$i)->getFormattedValue();
            $section_name = $objWorksheet->getCellByColumnAndRow(6,$i)->getFormattedValue();
             // $permanent_address = $objWorksheet->getCellByColumnAndRow(2,$i)->getFormattedValue();
              $studentInfo = $this->student->getStudentInfoBy_StudentID($register_no);
              $rowId = $studentInfo->row_id;
              $student_id = $studentInfo->student_id;
               if(!empty($register_no)){
                if(!empty($studentInfo)){
                $student_info = array(
                     'program_name' => trim(strtoupper($program_name)),
                     'stream_name' => trim(strtoupper($stream_name)),
                     // 'elective_sub' => trim(strtoupper($elective_sub)),
                     'section_name' => trim(strtoupper($section_name))
                     // 'reg_no' => trim($register_no)
                 );
               
                // $attinfo = array(
                //      'student_id' => trim($register_no));
                
                // $token_info = array(
                //      'student_id' => trim($register_no));
               

                  $result = $this->student->updateStudentInfo($student_info,$rowId);
$count++;
                 // $resultAtt = $this->student->updateStudentAttInfoByStdID($attinfo ,$student_id);
                 // $resultToken = $this->student->updateStudentTokenInfoByStdID($token_info ,$student_id);
             }else{
                // log_message('debug','application_no NotExist'.$application_no);
                log_message('debug','register_no NotExist'.$register_no);
             }
         }
            
            
            // $result = $this->student->updateStudentInfoByExcel($student_info ,$studentApplicationNo);

                
            // $result = $this->student->addFeeInfo($student_info);      
            log_message('debug','Inserted Record=='.print_r($student_info,true));

              
        }
          log_message('debug','Total Count= '.$count);
        redirect('viewSettings');
    }

    function addMiscellaneousType(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        }  else {
            $miscellaneousType =$this->security->xss_clean($this->input->post('miscellaneousType'));
            // $miscellaneousAmount =$this->security->xss_clean($this->input->post('miscellaneousAmount'));
            $miscellaneousInfo = array('miscellaneous_type'=>$miscellaneousType,'created_by'=>$this->staff_id,'created_date_time'=>date('Y-m-d H:i:s'));
            $result = $this->settings->addMiscellaneousType($miscellaneousInfo);
            if($result > 0){
                $this->session->set_flashdata('success', 'New Miscellaneous Type created successfully');
            } else{
                $this->session->set_flashdata('error', 'Miscellaneous Type creation failed');
            }
            redirect('viewSettings');
        }
    }

    public function deleteMiscellaneousType(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $miscellaneousInfo = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id
            );
            $result = $this->settings->updateMiscellaneousType($miscellaneousInfo, $row_id);
            // log_message('debug','post'.print_r($postInfo));
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
 // Exam marks import
 public function importExamInfo(){
    $config=['upload_path' => './upload/',
    'allowed_types' => 'xlsx|csv|xls','max_size' => '102400','overwrite' => TRUE,
    ];
    $this->load->library('upload', $config);
    if (!$this->upload->do_upload('excelFile')) {
        $error = array('error' => $this->upload->display_errors());
    } else { 
        $data = array('upload_data' => $this->upload->data());
    }
   if (!empty($data['upload_data']['file_name'])) {
        $import_xls_file = $data['upload_data']['file_name'];
    } else {
        $import_xls_file = 0;
    }
    $inputFileName = 'upload/'. $import_xls_file;
   
    try {
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);
    } catch (Exception $e) {
        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                . '": ' . $e->getMessage());
    }
   
    $excelValues = array();
    $excelValues2 = array();
    $sheetCount = $objPHPExcel->getSheetCount();
    $sheetNames = $objPHPExcel->getSheet();
    //sheet index
    $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
    $row_index = $objWorksheet->getHighestRow(); 
    $col_name = $objWorksheet->getHighestColumn();
    $headings = array();
    $cell_config = array(); 
    $row_count = 1;
    $highestRow = $objWorksheet->getHighestDataRow(); 
    $highestColumn = $objWorksheet->getHighestDataColumn();
    $total_fields = 2;
    $count = 0;
    $sub_name = array();
    $startingColumn = 'C'; // The column to start from
    $endingColumn = 'P';   // The column to end at

    $sub_name = array();

    for ($j = $startingColumn; $j <= $endingColumn; $j = chr(ord($j) + 2)) {
        $sub_column = $objWorksheet->getCellByColumnAndRow(ord($j) - ord('C') + 2, 1)->getFormattedValue();
        array_push($sub_name, $sub_column);
    }

            for ($i = 2; $i <= $highestRow; $i++) {
                $student_id = $objWorksheet->getCellByColumnAndRow(1, $i)->getFormattedValue();
                $pass_status = $objWorksheet->getCellByColumnAndRow(16, $i)->getFormattedValue();
                // $sat_number = $objWorksheet->getCellByColumnAndRow(15, $i)->getFormattedValue();
                // $enrollment_no = $objWorksheet->getCellByColumnAndRow(16, $i)->getFormattedValue();
                    $studentInfo = $this->settings->getStudentByStudentId($student_id);
                    

                    $startColumnIndex = 2;
                    for ($j = 0; $j < count($sub_name); $j++) {

                        $temp_sub_code = $sub_name[$j]; // Create a temporary variable to hold the modified subject code

                        if ($sub_name[$j] == 'Language') {
                            if ($studentInfo->elective_sub == 'KANNADA') {
                                $temp_sub_code = '01';
                            } else if ($studentInfo->elective_sub == 'HINDI') {
                                $temp_sub_code = '03';
                            } else if ($studentInfo->elective_sub == 'FRENCH') {
                                $temp_sub_code = '12';
                            }else if ($studentInfo->elective_sub == 'URDU') {
                                $temp_sub_code = '08';
                            }
                        }

                        // if($pass_status == 'PASS'){
                        //     $pass = 'PASS';
                        // }else{
                        //     $pass = 'FAIL';
                        // }

                        $obt_theory_mark = $objWorksheet->getCellByColumnAndRow($startColumnIndex, $i)->getFormattedValue();
                        $obt_lab_mark = $objWorksheet->getCellByColumnAndRow($startColumnIndex + 1, $i)->getFormattedValue();
                      

                        $isExists = $this->settings->checkmarkExists($student_id, $temp_sub_code,'ANNUAL_IMPORT','2023-24');

                        $isExistsStudent = $this->settings->getStudentByStudentId($student_id);
                        
                        if(!empty($isExistsStudent)){
                            if(empty($isExists)){
                                // Check if both obt_theory_mark and obt_lab_mark are not empty
                                if (!empty($obt_theory_mark) && !empty($obt_lab_mark)) {
                                $info = array(
                                    'student_id' => trim($student_id),
                                    'subject_code' => trim($temp_sub_code),
                                    'obt_theory_mark' => trim($obt_theory_mark),
                                    'obt_lab_mark' => trim($obt_lab_mark),
                                    'exam_year' => '2023-24',
                                    'exam_type' => 'ANNUAL_IMPORT',
                                    'is_deleted' => '0',
                                    'staff_updated_status' =>'1',
                                    'created_by' => $this->staff_id,
                                    'created_date_time' => date('Y-m-d H:i:s')
                                );
                                $result = $this->settings->addMarkInfo($info);
                            }
                        }
                        }else{
                            log_message('debug','student'.$student_id);
                        }
                       
                            $startColumnIndex += 2;
                    }

                    if(!empty($isExistsStudent)){
                        $studentInfo = array(
                            'pass_status' => trim($pass_status),
                            'updated_by'=> $this->staff_id, 
                            'updated_date_time'=>date('Y-m-d H:i:s')
                        );

                        $result2 = $this->settings->updateStudentInfo($studentInfo,$student_id);
                    }
            }
                redirect('viewSettings');
        }


}