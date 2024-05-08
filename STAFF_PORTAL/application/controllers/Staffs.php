<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Staffs extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public $active_status = "leave_info";
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('leave_model','leave');
        $this->load->model('staff_model','staff');
        $this->load->model('settings_model','settings');
        $this->load->model('subjects_model','subject');
        $this->load->model('feedback_model');
        $this->isLoggedIn();

          //load library
		$this->load->library('zend');
    }
    function staffDetails()
    {
        if($this->isAdmin() == TRUE )
        {
            $this->loadThis();
        } else {
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Staffs Details';
            $this->loadViews("staffs/staffs", $this->global, NULL , NULL);
        }
    }

    public function get_staffs(){
        if($this->isAdmin() == TRUE )
        {
            $this->loadThis();
        } else {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
          $data_array_new = [];
          $staffInfo = $this->staff->getAllStaffInfo();
          foreach($staffInfo as $staff) {
            $staffViewMore =  "";
              $editButton = "";
              $deleteButton = "";
              $checkbox = '<input type="checkbox" class="singleSelect" value="' . $staff->staff_id . '" />';
            //   $staffViewMore = '<a class="btn btn-xs btn-primary"
            //   href="'.base_url().'viewStaffInfoById/'.$staff->row_id.'"
            //   title="View More"><i class="fa fa-eye"></i></a>';

            if($this->role == ROLE_ADMIN || $this->role == ROLE_SUPER_ADMIN || $this->role == ROLE_PRIMARY_ADMINISTRATOR || $this->role == ROLE_PRINCIPAL || $this->role == ROLE_OFFICE || $this->role == ROLE_VICE_PRINCIPAL){
                $editButton = '<a class="btn btn-xs btn-primary"
                href="'.base_url().'editStaff/'.$staff->row_id.'" title="Edit Staff"><i
                    class="fa fa-eye"></i></a>';
                
            }

            
            
            if($this->role == ROLE_ADMIN || $this->role == ROLE_SUPER_ADMIN || $this->role == ROLE_PRIMARY_ADMINISTRATOR){
                $deleteButton = '<a class="btn btn-xs btn-danger deleteStaff" href="#"
                data-row_id="'.$staff->row_id.'" title="Delete Staff"><i
                    class="fa fa-trash"></i></a>';
            }
            $viewFeedback = '';
            $printFeedback = '';
            $printFeedback22 = '';
            if($this->role == ROLE_PRINCIPAL || $this->role == ROLE_ADMIN || $this->role == ROLE_PRIMARY_ADMINISTRATOR){
                $commentsInfo = $this->feedback_model->getStudentFeedbackCount($staff->row_id);
                $commentsInfo22 = $this->feedback_model->getStudentFeedbackCount_22($staff->row_id);
                $counselorInfo = $this->feedback_model->getCounselorFeedbackCount($staff->row_id);
                $staffInfoId = $this->staff->getStaffInfoById($staff->row_id);
                if($staffInfoId->role_id == ROLE_TEACHING_STAFF){
                    if(count($commentsInfo) > 0){
                        $viewFeedback = '<a target="_blank" class="btn btn-xs btn-success" href="'.base_url().'viewStudentFeedbackByStaff/'.$staff->row_id.'" title="View Student Feedback"><i class="fa fa-book"></i></a>';
                        // $printFeedback = '<a target="_blank" class="btn btn-xs btn-info" href="'.base_url().'pintStudentFeedbackResponse_21/'.$staff->row_id.'" title="Print Student Feedback 2021"><i class="fa fa-print"></i></a>';
                        $printFeedback = '';
                    }else{
                        $viewFeedback = '';
                        $printFeedback = '';
                    }
                    if(count($commentsInfo22) > 0){
                        $printFeedback22 = '<a target="_blank" class="btn btn-xs btn-info" href="'.base_url().'pintStudentFeedbackResponse_23/'.$staff->row_id.'" title="Print Student Feedback 2023"><i class="fa fa-print"></i></a>';
                    }else{
                        $printFeedback22 = '';
                    }
                }else if ($staffInfoId->role_id == ROLE_COUNSELOR){
                    if(count($counselorInfo) > 0){
                        $viewFeedback = '<a target="_blank" class="btn btn-xs btn-success" href="'.base_url().'viewStudentFeedbackByStaff/'.$staff->row_id.'" title="View Student Feedback"><i class="fa fa-book"></i></a>';
                        $printFeedback = '<a target="_blank" class="btn btn-xs btn-info" href="'.base_url().'pintStudentCouncellorFeedbackResponse/'.$staff->row_id.'" title="Print Student Feedback 2023"><i class="fa fa-print"></i></a>';
                    }else{
                        $viewFeedback = '';
                        $printFeedback = '';
                    }    
                }
            }
            $staff_name = strtoupper($staff->name);
            $data_array_new[] = array(
                $checkbox,
                $staff->staff_id,
                strtoupper($staff_name),
                $staff->department,
                $staff->role,
                $staff->mobile,
                $staffViewMore.' '.$editButton.' '.$deleteButton.' '.$viewFeedback.' '.$printFeedback.' '.$printFeedback22
                );
            }
         $count = count($staffInfo);
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

    function addNewStaff() {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $data['departments'] = $this->staff->getStaffDepartment();
            $data['designation'] = $this->staff->getStaffRoles();
            $data['shiftsInfo'] = $this->staff->getStaffShifts();
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Add New Staff';
            $this->loadViews("staffs/addNewStaff", $this->global, $data, NULL);
        }
    }
    public function updateResignedDate(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('staff_id');
            $resigned_date = $this->input->post('resigned_date');
            $staffInfo = array('resignation_date' => date('Y-m-d',strtotime($resigned_date)),'updated_by'=>$this->staff_id);
            $result = $this->staff->updateStaff($staffInfo, $row_id);
            if($result == true) {
                $this->session->set_flashdata('success', 'Staff resignation info updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to modify staff resignation info');
            }
            redirect('staffDetailsResigned');
        } 
    }

    public function updateResignationInfo(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $row_id = $this->input->post('row_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('resign_date','Resignation Date','trim|required');
            
            if($this->form_validation->run() == FALSE) {
                redirect('editSchoolStaff/'.$row_id);  
            } else {
                
                $resign_date = $this->input->post('resign_date');
                
                if(!empty($resign_date)) {
                    $resign_date = date('Y-m-d',strtotime($resign_date));
                } else {
                    $resign_date = "";
                }
                
                
                $resignInfo = array(
                    'resignation_date' => $resign_date, 
                    'resignation_status' => 1, 
                    'createdBy' => $this->staff_id, 
                    'modified_date_time' => date('Y-m-d H:i:s'));
                    
                $result = $this->staff->updateStaff($resignInfo, $row_id);
                if($result == true) {
                    $this->session->set_flashdata('success', 'Staff resignation info updated successfully');
                } else {
                    $this->session->set_flashdata('error', 'Failed to modify staff resignation info');
                }
                redirect('editStaff/'.$row_id);  
            }
        }
    }

    function addNewStaffToSjbhs() {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('fname','Staff Name','trim|required');
            $this->form_validation->set_rules('staff_id','Staff Id','trim|required');
            $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
            $this->form_validation->set_rules('role', 'Role', 'trim|required|numeric');
            $this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
            // $this->form_validation->set_rules('shift_id', 'Shift Info', 'trim|required');

            if($this->form_validation->run() == FALSE) {
                $this->addNewStaff();
            } else {
                $image_path="";
                $config=['upload_path' => './upload/',
                'allowed_types' => 'jpg|png|jpeg','max_size' => '2048','overwrite' => TRUE,'file_ext_tolower' => TRUE];
                $this->load->library('upload', $config);
                if($this->upload->do_upload()) {
                    $post=$this->input->post();
                    $data=$this->upload->data();
                    $image_path=base_url("upload/".$data['raw_name'].$data['file_ext']);
                    $post['image_path']=$image_path;
                }
                $dob = $this->input->post('dob');
                $date_of_join = $this->input->post('date_of_join');
                if(!empty($date_of_join)) {
                    $date_of_join = date('Y-m-d',strtotime($date_of_join));
                } else {
                    $date_of_join = "";
                }
                if(!empty($dob)) {
                    $dob = date('Y-m-d',strtotime($dob));
                } else {
                    $dob = "";
                }
                $gender = $this->input->post('gender');
                $blood_group = $this->input->post('blood_group');
                $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
                $isExist = $this->staff->checkStaffIdExists($staff_id);
                if(!empty($isExist)){
                    $this->session->set_flashdata('error', 'Staff Id Already Exists');
                    redirect('addNewStaff');
                }
                $name = $this->security->xss_clean($this->input->post('fname'));
                $email = strtolower($this->security->xss_clean($this->input->post('email')));
                $password = 'kxpuc@123';

                // $shift_code = $this->input->post('shift_id');
                $roleId = $this->input->post('role');
                $department = $this->input->post('department');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                $address = $this->input->post('address');
                $aadhar_no = $this->security->xss_clean($this->input->post('aadhar_no'));
                $pan_no = $this->security->xss_clean($this->input->post('pan_no'));
                $voter_no = $this->security->xss_clean($this->input->post('voter_no'));
                $user_name = sprintf('AGNES%04d', $staff_id);
                    $staffInfo = array(
                    'user_name' => $user_name,
                    'photo_url'=>$image_path, 
                    'staff_id' => $staff_id,
                    'department_id'=>$department, 
                    'email' => $email, 
                    'dob' => $dob,
                    'doj' => $date_of_join,
                    'gender' => $gender,
                    'password' => getHashedPassword($password), 
                    'password_text' => base64_encode($password), 
                    'role' => $roleId, 'name' => $name,
                    'mobile' => $mobile, 
                    'address' => $address, 
                    'aadhar_no' => $aadhar_no,
                    'pan_no' => $pan_no,
                    'voter_no' => $voter_no,
                    'blood_group' => $blood_group,
                    'createdBy' => $this->staff_id, 
                    'modified_date_time' => date('Y-m-d H:i:s'));
                    $result = $this->staff->addNewStaff($staffInfo);

                    if($result > 0) {
                        $this->session->set_flashdata('success', 'New Staff Added Successfully');
                    } else {
                        $this->session->set_flashdata('error', 'New Staff Add failed');
                    }

                    redirect('addNewStaff');  
            }
        }
    }


    public function viewStaffInfoById($row_id = null)
    {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            if($row_id == null) {
                redirect('staffDetails');
            }
            
            $data['staffInfo'] = $this->staff->getStaffInfoById($row_id);
           
            $data['active'] = '';
            $this->global['pageTitle'] = ''.TAB_TITLE.' : View Staff Details';
            $this->loadViews("staffs/staffProfile", $this->global, $data, null);
        }
    }
    public function get_staffs_resigned(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
          $data_array_new = [];
        //   $staffInfo_ = $this->staff->getAllStaffInfoForJob();
        //   foreach($staffInfo_ as $record) {
        //   $user_name = sprintf('SJBHS%03d', $record->staff_id);
        //   $staffInfo = array(
        //       'user_name' => $user_name
        //   );
        //   $this->staff->updateStaff($staffInfo, $record->row_id);
        // }
          $staffInfo = $this->staff->getResignedStaffInfo();
          foreach($staffInfo as $staff) {
              $editButton = "";
              $deleteButton = "";
              $staffViewMore = '<a class="btn btn-xs btn-primary"
              href="'.base_url().'viewStaffInfoById/'.$staff->row_id.'"
              title="View More"><i class="fa fa-eye"></i></a>';
                $date = date('d-m-Y',strtotime($staff->resignation_date));
            
            // if($this->role == ROLE_ADMIN){
            //     $deleteButton = '<a class="btn btn-xs btn-danger deleteStaff" href="#"
            //     data-row_id="'.$staff->row_id.'" title="Delete Staff"><i
            //         class="fa fa-trash"></i></a>';
            $editButton = '<a class="btn btn-xs btn-info"
            onclick="editResignDate(' . htmlspecialchars(json_encode($date), ENT_QUOTES, 'UTF-8') . ', ' .$staff->row_id . ','. htmlspecialchars(json_encode($staff->name), ENT_QUOTES, 'UTF-8') .')" title="Edit Date"><i
            class="fa fa-pen"></i></a>';
    
            // }
             
            $data_array_new[] = array(
                $staff->staff_id,
                $staff->name,
                $staff->department,
                $staff->role,
                $staff->mobile_one,
                $date,
                $staffViewMore.' '.$editButton.' '.$deleteButton
                );
            }
         $count = count($staffInfo);
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
    
    function staffDetailsResigned()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Staffs Details';
            $this->loadViews("staffs/resignedStaff", $this->global, NULL , NULL);
        }
    }
    public function editStaff($staff_id = null)
    {
        if ($this->isAdmin() == true ) {
            $this->loadThis();
        } else {
            if ($staff_id == NULL) {
                // log_message('debug','this is test');
                redirect('staffDetails');
               
            }
           
            $data['active'] = $this->active_status;
            $data['departments'] = $this->staff->getStaffDepartment();
            $data['designation'] = $this->staff->getStaffRoles();
            $data['shiftsInfo'] = $this->staff->getStaffShifts();
            $staff = $this->staff->getStaffInfoById($staff_id);
            $data['staffInfo'] = $staff;
            $data['subjectInfo'] = $this->subject->getAllSubjectInfo();
            $data['sectionInfo'] = $this->settings->getSectionInfo();
            $data['staffSectionInfo'] = $this->staff->getSectionByStaffId($staff->staff_id);
            $data['staffSubjectInfo'] = $this->staff->getAllSubjectByStaffId($staff->staff_id);
            $data['leaveInfo'] = $this->leave->getLeaveInfoByStaffId($staff_id);
         
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Staff Details';
            $this->loadViews("staffs/editStaffInfo", $this->global, $data, null);
        }
    }


    public function updateStaff(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        } else {
            $row_id = $this->input->post('row_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('fname','Staff Name','trim|required');
            $this->form_validation->set_rules('staff_id','Staff Id','trim|required');
            $this->form_validation->set_rules('role', 'Role', 'trim|required|numeric');
            $this->form_validation->set_rules('gender', 'gender', 'trim|required');
            $this->form_validation->set_rules('department', 'Department', 'trim|required|numeric');
            
            if($this->form_validation->run() == FALSE)
            {
                redirect('editStaff/'.$row_id);  
            }
            else
            {
                $image_path="";
                $config=['upload_path' => './upload/',
                'allowed_types' => 'jpg|png|jpeg','max_size' => '2048','overwrite' => TRUE,'file_ext_tolower' => TRUE];
                $this->load->library('upload', $config);
                if($this->upload->do_upload())
                {
                    $post=$this->input->post();
                    $data=$this->upload->data();
                    $image_path=base_url("upload/".$data['raw_name'].$data['file_ext']);
                    $post['image_path']=$image_path;
                }

                $dob = $this->input->post('dob');
                $date_of_join = $this->input->post('date_of_join');
                if(!empty($date_of_join)) {
                    $date_of_join = date('Y-m-d',strtotime($date_of_join));
                } else {
                    $date_of_join = "";
                }
                if(!empty($dob)) {
                    $dob = date('Y-m-d',strtotime($dob));
                } else {
                    $dob = "";
                }
                $gender = $this->input->post('gender');
                $blood_group = $this->input->post('blood_group');
                $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
                $isExist = $this->staff->checkStaffIdExists($staff_id);
                if(!empty($isExist)){
                    if($row_id != $isExist->row_id){
                        $this->session->set_flashdata('error', 'Staff Id Already Exists');
                        redirect('editStaff/'.$row_id); 
                    }
                }
                $name = $this->security->xss_clean($this->input->post('fname'));
                $email = strtolower($this->security->xss_clean($this->input->post('email')));
                // $shift_code = $this->input->post('shift_id');
                $roleId = $this->input->post('role');
                $department = $this->input->post('department');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                $address = $this->input->post('address');
                $aadhar_no = $this->security->xss_clean($this->input->post('aadhar_no'));
                $pan_no = $this->security->xss_clean($this->input->post('pan_no'));
                $voter_no = $this->security->xss_clean($this->input->post('voter_no'));
                    $staffInfo = array(
                    'staff_id' => $staff_id,
                    'department_id'=>$department, 
                    'email' => $email, 
                    'dob' => $dob,
                    'doj' => $date_of_join,
                    'gender' => $gender,
                    'role' => $roleId, 
                    'name' => $name,
                    'mobile' => $mobile, 
                    'address' => $address, 
                    'aadhar_no' => $aadhar_no,
                    'pan_no' => $pan_no,
                    'voter_no' => $voter_no,
                    'blood_group' => $blood_group,
                    'createdBy' => $this->staff_id, 
                    'modified_date_time' => date('Y-m-d H:i:s'));

                    if(!empty($image_path)){
                        $staffInfo['photo_url'] = $image_path;
                    }
                    $result = $this->staff->updateStaff($staffInfo, $row_id);
                    if($result == true)
                    {
                     $this->session->set_flashdata('success', 'Staff Updated Successfully');
                    } else {
                        $this->session->set_flashdata('error', 'Staff Modified failed');
                    }
                    redirect('editStaff/'.$row_id);  
            }
        }
    }
//delete a staff 
        public function deleteStaff(){
            if($this->isAdmin() == TRUE){
                $this->loadThis();
            } else {   
                $row_id = $this->input->post('row_id');
                $staffInfo = array('is_deleted' => 1,'modified_date_time' => date('Y-m-d H:i:s'));
                $result = $this->staff->updateStaff($staffInfo, $row_id);
                // $result = $this->staff->deleteStaffById($row_id);
                if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
            } 
        }

        public function checkStaffDExists()
        {
            $staff_id = $this->input->post("staff_id");
            $result = $this->staff->checkStaffIdExists($staff_id);
            if (empty($result)) {echo ("true");} else {echo ("false");}
        }
    

   
    


    //download staff info
    public function downloadStaffInfo(){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            $staff_type = $this->security->xss_clean($this->input->post('staff_type'));
            $staff_type_text = $this->security->xss_clean($this->input->post('staff_type_text'));
            
            $sheet = 0;
            $this->excel->setActiveSheetIndex($sheet);
            //name the worksheet
            $this->excel->getActiveSheet()->setTitle('SJPUC Staff Info');
            $this->excel->getActiveSheet()->getPageSetup()->setPrintArea('A1:G500');
            //set Title content with some text
            $this->excel->getActiveSheet()->setCellValue('A1', "JYOTI NIVAS PRE-UNIVERSITY COLLEGE");
            $this->excel->getActiveSheet()->setCellValue('A2', strtoupper($staff_type_text)."-INFORMATION 2019-2020");
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(18);
            $this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
            $this->excel->getActiveSheet()->mergeCells('A1:G1');
            $this->excel->getActiveSheet()->mergeCells('A2:G2');
            $this->excel->getActiveSheet()->getStyle('A1:A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
    
            $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(28);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(18);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(14);
            $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            

            $this->excel->setActiveSheetIndex($sheet)->setCellValue('A3', 'SL. NO.');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('B3', 'Staff ID');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('C3', 'Name');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('D3', 'Role');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('E3', 'Department');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('F3', 'Mobile');
            $this->excel->setActiveSheetIndex($sheet)->setCellValue('G3', 'Email');
            
            $this->excel->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setWrapText(true); 
            $this->excel->getActiveSheet()->getStyle('A3:G3')->getFont()->setBold(true); 
            $this->excel->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $styleBorderArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
            $this->excel->getActiveSheet()->getStyle('A1:G4')->applyFromArray($styleBorderArray);
            $staffRecords = $this->staff_model->getStaffInfoForDownloadReport($staff_type);
            $j=1;
            $excel_row = 4;
            foreach($staffRecords as $staff){
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('A'.$excel_row,$j++);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('B'.$excel_row,$staff->staff_id);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('C'.$excel_row,$staff->name);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('D'.$excel_row,$staff->role);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('E'.$excel_row,$staff->department);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('F'.$excel_row,$staff->mobile_one);
                $this->excel->setActiveSheetIndex($sheet)->setCellValue('G'.$excel_row,$staff->email);
                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':G'.$excel_row)->applyFromArray($styleBorderArray);
                $this->excel->getActiveSheet()->getStyle('A'.$excel_row.':B'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D'.$excel_row.':G'.$excel_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $excel_row++;
            }
            $this->excel->createSheet(); 
        
            $filename='just_some_random_name.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
            ob_start();
            $objWriter->save("php://output");
            $xlsData = ob_get_contents();
            ob_end_clean();

            $response =  array(
                'op' => 'ok',
                'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
            );
            die(json_encode($response));
        }
    }

    //update class completed info
    public function updateStaffSubjects(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        }
        else{
            $row_id = $this->security->xss_clean($this->input->post('row_id'));
            $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
            $sub_id = $this->security->xss_clean($this->input->post('sub_id'));
            $subject_code = $this->security->xss_clean($this->input->post('subject_code'));
            $subjectType = $this->security->xss_clean($this->input->post('subjectType'));
        
            $isExists = $this->staff->checkSubjectTypeExists($staff_id,$subject_code,$subjectType);
            if($isExists > 0) {
                $this->session->set_flashdata('warning', 'Subject Already Exists');
            } else {
                $staffSubjectInfo = array(
                    'staff_id' => $staff_id,
                    'intake_year' => date('Y'),
                    'subject_code' => $subject_code,
                    'subject_type' => $subjectType,
                    'created_date_time' =>date('Y-m-d H:i:s'));
                $result = $this->staff->addNewStaffSubject($staffSubjectInfo);

                if($result > 0){
                    $this->session->set_flashdata('success', 'Subject Updated successfully');
                }else{
                    $this->session->set_flashdata('error', 'Subject Update failed');
                }
            }
            redirect('editStaff/'.$row_id);  
        }
    }
    public function updateStaffSection(){
        if($this->isAdmin() == TRUE || $this->isSuperAdmin() != TRUE){
            $this->loadThis();
        }
        else{
            $row_id = $this->security->xss_clean($this->input->post('row_id'));
            $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
            $section_id = $this->security->xss_clean($this->input->post('section_id'));
            
            $isExist = $this->staff->checkClassExists($staff_id,$section_id);
            if($isExist > 0){
                $this->session->set_flashdata('warning', 'Class already exists!');
                redirect('editStaff/'.$row_id);  
            }else{
        
                
                $staffSectionInfo = array(
                    'staff_id' => $staff_id,
                    'section_id' => $section_id,
                    'year' => date('Y'),
                    'created_date_time' =>date('Y-m-d H:i:s'));
                $result = $this->staff->addStaffSection($staffSectionInfo);

                if($result > 0){
                    $this->session->set_flashdata('success', 'Class Updated successfully');
                }else{
                    $this->session->set_flashdata('error', 'Class Update failed');
                }
                redirect('editStaff/'.$row_id);
            }  
        }
    }

    
    public function deleteStaffSubject(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $subjectInfo = array('is_deleted' => 1,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->staff->updateStaffSubject($subjectInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function deleteStaffSection(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $classInfo = array('is_deleted' => 1,'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->staff->updateStaffclass($classInfo, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    
    public function getAllStaffInfo(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            $data['staffInfo'] = $this->staff->getAllStaffInfo();
            // log_message('debug','dne=='.print_r($data['studentInfo'],true));
            header('Content-type: text/plain'); 
            // set json non IE
            header('Content-type: application/json'); 
            echo json_encode($data);
            exit(0);
        }
    }


    //getstaff attaendance view page
function getStaffAttendanceInfo()
{
    if($this->isAdmin() == TRUE)
    {
        $this->loadThis();
    }else {
        $search_date = $this->input->post('dateSearch');
        if(!empty($search_date)){
            $date = date('Y-m-d',strtotime($search_date));
            $data['searchDate'] = date('d-m-Y',strtotime($search_date));
        }else{
            $data['searchDate'] = date('d-m-Y');
            $date = date('Y-m-d');
        }
        $data['departments'] = $this->staff->getStaffDepartment();    
     
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Staff Attendance Details ';
        $this->loadViews("staffs/staffAttendanceInfo", $this->global, $data, NULL);
    }
}

//get all staff attendance
public function get_attendance()
{
  $holiday_dates = [];
  $filter = array();
  $draw = intval($this->input->post("draw"));
  $start = intval($this->input->post("start"));
  $length = intval($this->input->post("length"));
    $data_array_new = [];
    $date = date('Y-m-d',strtotime($this->input->post('date')));
    $staffInfo = $this->staff->getAllStaffInfo();
  ///  log_message('debug','dhddh='.$date);
    foreach($staffInfo as $staff) {
        $filter['staff_id'] = $staff->staff_id;
        $filter['by_date'] = $date;
        $staff_data = $this->staff->getStaffAttendanceInfoAllStaff($filter);
      //  log_message('debug','dhddh='.print_r($staff_data,true));
        if(!empty($staff_data)){
            $deleteButton = "";
            $updateButton = "";
            $editButton = "";
            $check_in = date("h:i:s A",strtotime($staff_data->in_time.' +7 hour'));

            $check_out = date("h:i:s A",strtotime($staff_data->out_time.' +7 hour')); 

            $check_in_compare = new DateTime(date("h:i:s",strtotime($staff_data->in_time)));

            $check_out_compare = new DateTime(date("h:i:s",strtotime($staff_data->out_time)));

            $interval = $check_in_compare->diff($check_out_compare);
            $check_in_rule = new DateTime(date("h:i:s",strtotime($staff_data->punch_time)));
          
            if($staff_data->department == 'HOUSE KEEPING'){
                $in_time_rule = new DateTime('07:00:00');
            }else if($staff_data->department == 'SUPPORT STAFF'){
                $in_time_rule = new DateTime('08:00:00');
            }else{
                $in_time_rule = new DateTime('08:20:00');
            }
            
           

            $time_diff = $check_in_rule->diff($in_time_rule);

          

            if($time_diff->format('%R%i') < 0){
                $in_time =  '<span style="color:red">'. $check_in.'</span>';
            }else{
                $in_time =  '<span style="color:green">'. $check_in.'</span>';
            }
                // if(!empty($staff_data->in_time)){
                //     if(date('l', strtotime($date)) == 'Saturday'){
                //         if($staff_data->role_id == ROLE_SUPPORT_STAFF || $staff_data->role_id == ROLE_NON_TEACHING_STAFF || $staff_data->role_id == ROLE_ADMIN){
                //             $time = strtotime('08:15:00');
                //             $startTime = date("H:i:s", strtotime('+30 minutes', $time));
                //             $actual_in_time = new DateTime($startTime);
                //             $time_diff = $check_in_compare->diff($actual_in_time);
                //         }else{
                //             $actual_in_time = new DateTime('08:25:00');
                //             $time_diff = $check_in_compare->diff($actual_in_time);
                //         }
                //     }else{
                //         $actual_in_time = new DateTime('08:15:00');
                //         $time_diff = $check_in_compare->diff($actual_in_time);
                //     }
                //     if($time_diff->format('%R%i') < 0){
                //       $in_time =  '<span style="color:red">'. $staff_data->in_time.'</span>';
                //     }else{
                //         $in_time =  '<span style="color:green">'. $staff_data->in_time.'</span>';
                //     }
                // }else{
                //     if(date('l', strtotime($date)) == 'Sunday'){
                //         $in_time =  '<span style="color:green">SUN</span>';
                //     }else{
                //         $in_time =  '<span style="color:red">AB</span>';
                //     }
                    
                // }
              
            if($interval->format('%h') <= 0) {
                $check_out = '--';
            }else{
                $check_out = $check_out;//$staff_data->out_time;
            }
            // if($this->role == ROLE_ADMIN){
            //     $deleteButton = '<a class="btn btn-xs btn-danger deleteStaffAttendance" href="#"
            //     data-row_id="'.$staff_data->row_id.'" title="Delete Attendance"><i
            //         class="fa fa-trash"></i></a>';
            //     $editButton = '<button onclick="editStaffAttendance('.$staff_data->staff_id.')" class="btn btn-xs btn-info"
            //     title="Edit Attendance"><i
            //         class="fa fa-pencil"></i></button>';
            // }

            $data_array_new[] = array(
               date('d-m-Y',strtotime($date)),
               $staff->staff_id,
               strtoupper($staff->name),
               $staff->department,
               $staff->role,
               $in_time,
               $check_out,
               $editButton.' '.$deleteButton,
          );
        }else{
            $data_array_new[] = array(
                date('d-m-Y',strtotime($date)),
                $staff->staff_id,
                strtoupper($staff->name),
                $staff->department,
                $staff->role,
                '<span style="color:red">AB</span>',
                '<span style="color:red">AB</span>',
                $editButton.' '.$deleteButton,
           );
        }
   }
   $count = count($staffInfo);
    $result = array(
         "draw" => $draw,
          "recordsTotal" => $count,
          "recordsFiltered" => $count,
          "data" => $data_array_new
     );
echo json_encode($result);
exit();
}

public function addNewStaffAttendance(){
    if ($this->isAdmin() == true) {
        $this->loadThis();
    }else{
        $this->load->library('form_validation');
        $this->form_validation->set_rules('attendance_staff_id','Staff Name','trim|required');
        $this->form_validation->set_rules('new_date','Attendance Date','trim|required');
        $this->form_validation->set_rules('check_in_hh', 'Check In', 'trim|required|numeric|min_length[2]');
        $this->form_validation->set_rules('check_in_mm', 'Check In', 'trim|required|numeric|min_length[2]');
        $this->form_validation->set_rules('check_in_ss', 'Check In', 'trim|required|numeric|min_length[2]');
        $this->form_validation->set_rules('check_out_hh', 'Check Out', 'trim|required|numeric|min_length[2]');
        $this->form_validation->set_rules('check_out_mm', 'Check Out', 'trim|required|numeric|min_length[2]');
        $this->form_validation->set_rules('check_out_ss', 'Check Out', 'trim|required|numeric|min_length[2]');
        
        if($this->form_validation->run() == FALSE){
            redirect('getStaffAttendanceInfo');  
        }else{
            $staff_id = $this->security->xss_clean($this->input->post('attendance_staff_id'));
            $new_date =$this->security->xss_clean($this->input->post('new_date')); 
            $check_in_hh =$this->security->xss_clean($this->input->post('check_in_hh')); 
            $check_in_mm =$this->security->xss_clean($this->input->post('check_in_mm')); 
            $check_in_ss =$this->security->xss_clean($this->input->post('check_in_ss')); 
            $check_out_hh =$this->security->xss_clean($this->input->post('check_out_hh')); 
            $check_out_mm =$this->security->xss_clean($this->input->post('check_out_mm')); 
            $check_out_ss =$this->security->xss_clean($this->input->post('check_out_ss')); 
    
            $punch_in_time = $check_in_hh.":".$check_in_mm.":".$check_in_ss;
            $punch_out_time = $check_out_hh.":".$check_out_mm.":".$check_out_ss;

            $punch_date = date('Y-m-d',strtotime($new_date));
            $attendance_time = strtotime($punch_date.$punch_in_time);
            $attInfoCheckIn = array(
                'service_tag_id' => 'manual_check_in',
                'staff_id' => $staff_id,
                'attendance_time' => $attendance_time,
                'punch_time' => $punch_in_time,
                'punch_date' => $punch_date,
                'attendance_type' => 'CheckIn',
                'created_date_time' =>date('Y-m-d H:i:s'),
            );
            $attendance_time = strtotime($punch_date.' '.$punch_out_time);
            $attInfoCheckOut = array(
                'service_tag_id' => 'manual_check_out',
                'staff_id' => $staff_id,
                'attendance_time' => $attendance_time,
                'punch_time' => $punch_out_time,
                'punch_date' => $punch_date,
                'attendance_type' => 'CheckOut',
                'created_date_time' =>date('Y-m-d H:i:s'),
            );
            $result = $this->staff->addNewStaffAttendance($attInfoCheckIn);
            $result = $this->staff->addNewStaffAttendance($attInfoCheckOut);
            if($result > 0){
                $this->session->set_flashdata('success', 'Staff Attendance Added successfully');
            }else{
                $this->session->set_flashdata('error', 'Staff Attendance Add failed');
            }
            redirect('getStaffAttendanceInfo');  
        }

    }
}

        public function getStaffAttendanceInfoByDate_Staff_Id(){
            if($this->isAdmin() == TRUE){
                $this->loadThis();
            }
            else{
                $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
                $date = $this->security->xss_clean($this->input->post('date')); 
                $result = $this->staff->getAllStaffAttendanceFromModel($staff_id,date('Y-m-d',strtotime($date)));
                echo json_encode($result);
                exit();
            }
        }

    function deletedStaffDetails()
    {
        if($this->isAdmin() == TRUE )
        {
            $this->loadThis();
        } else {
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Staffs Details';
            $this->loadViews("staffs/deletedStaffs", $this->global, NULL , NULL);
        }
    }

    public function get_deleted_staffs(){
        if($this->isAdmin() == TRUE )
        {
            $this->loadThis();
        } else {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
          $data_array_new = [];
          $staffInfo = $this->staff->getDeletedAllStaffInfo();
          foreach($staffInfo as $staff) {
            $restoreButton = "";
            
            if($this->role == ROLE_ADMIN || $this->role == ROLE_SUPER_ADMIN || $this->role == ROLE_PRIMARY_ADMINISTRATOR){
                 $restoreButton = '<a class="btn btn-xs btn-danger restoreStaff" href="#"
                 data-row_id="'.$staff->row_id.'" title="Restore Staff"><i class="fas fa-trash-restore"></i></a>';
            }
            $staff_name = strtoupper($staff->name);
            $data_array_new[] = array(
                $checkbox,
                $staff->staff_id,
                strtoupper($staff_name),
                $staff->department,
                $staff->role,
                $staff->mobile,
                $restoreButton
                );
            }
            $count = count($staffInfo);
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

    //restore staff
    public function restoreStaff(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $staffInfo = array('is_deleted' => 0,'modified_date_time' => date('Y-m-d H:i:s'));
            $result = $this->staff->updateStaff($staffInfo, $row_id);
            // $result = $this->staff->deleteStaffById($row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function updateLeaveInfo(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $this->active_status = 'leave_info';
            $row_id =$this->security->xss_clean($this->input->post('row_id_leave')); 
            $staff_id = $this->security->xss_clean($this->input->post('staff_id_leave')); 
            $casual_leave =$this->security->xss_clean($this->input->post('casual_leave')); 
            $sick_leave =$this->security->xss_clean($this->input->post('sick_leave')); 
            $paternity_leave =$this->security->xss_clean($this->input->post('paternity_leave'));
            $maternity_leave =$this->security->xss_clean($this->input->post('maternity_leave')); 
            $marriage_leave =$this->security->xss_clean($this->input->post('marriage_leave')); 
            $lop =$this->security->xss_clean($this->input->post('lop')); 
            $leaveInfo = $this->leave->getLeaveInfoByStaffId($staff_id);
            if($leaveInfo == NULL){
                $leaveInfo = array(
                    'staff_id' => $staff_id,
                    'casual_leave_earned' => $casual_leave,
                    'sick_leave_earned' => $sick_leave,
                    'marriage_leave_earned' => $marriage_leave,
                    'paternity_leave_earned' => $paternity_leave,
                    'maternity_leave_earned' => $maternity_leave,
                    'lop_leave' => $lop,
                    'created_by' => $this->staff_id,
                    'created_date_time' => date('Y-m-d H:i:s')
                );
                log_message('debug','test'.print_r('$leaveInfo',true));
                $return = $this->leave->addStaffLeaveInfo($leaveInfo);
                if($return > 0) {
                    $this->session->set_flashdata('success', 'Leave details Added Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Leave Details Update failed');
                }
                redirect('editStaff/'.$row_id);
            }else{
                $leaveInfo = array(
                    'staff_id' => $staff_id,
                    'casual_leave_earned' => $casual_leave,
                    'sick_leave_earned' => $sick_leave,
                    'marriage_leave_earned' => $marriage_leave,
                    'paternity_leave_earned' => $paternity_leave,
                    'maternity_leave_earned' => $maternity_leave,
                    'lop_leave' => $lop,
                    'created_by' => $this->staff_id,
                    'updated_date_time' => date('Y-m-d H:i:s')
                );
                $return = $this->leave->updateStaffLeaveInfo($leaveInfo, $staff_id);
                if($return) {
                    $this->session->set_flashdata('success', 'Leave details Updated Successfully');
                } else {
                    $this->session->set_flashdata('error', 'Leave Details Update failed');
                }
                redirect('editStaff/'.$row_id);
            }
            
        }
    }


    public function generateBarcodeForStaff($row_id = null){
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            if($row_id == null){
                $row_id = $this->security->xss_clean($this->input->get('row_id'));
                $row_id = base64_decode(urldecode($row_id));
                $row_id = json_decode(stripslashes($row_id));
                // log_message('debug','data'.print_r($row_id,true));
            }
          
            foreach($row_id as $id){
                
                $roll_number[$id] = $this->staff->getStaffId($id);
                // log_message('debug','data'.print_r($roll_number[$id],true));
                // log_message('debug','data'.$roll_number[$id]->student_id);
                $generate_barcode[$id] = $this->set_barcode($roll_number[$id]->staff_id);
            }
            $data['generate_barcode'] = $generate_barcode;
           
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','default_font' => 'timesnewroman','format' => 'A4-L']);
            $mpdf->AddPage('P','','','','',7,7,7,7,8,8);
            $mpdf->SetTitle('Bar Code');
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Barcode';

            $html = $this->load->view('staffs/viewBarCodePrintForStaff',$data,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('BarCode.pdf', 'I'); 

        }
    }


    function set_barcode($code)
        {
            //load in folder Zend
            $this->zend->load('Zend/Barcode');
            //generate barcode
            $file = Zend_Barcode::draw('code128', 'image', array('text'=>$code), array());
            //$code = str_replace('/', '_', $code);
            $code = time().$code;
            $barcodeRealPath = APPPATH. '/barcode/'.$code.'.png';
            $barcodePath = APPPATH.'/barcode/';
    
            header('Content-Type: image/png');
            $store_image = imagepng($file,$barcodeRealPath);
            return $barcodePath.$code.'.png';
        }

}