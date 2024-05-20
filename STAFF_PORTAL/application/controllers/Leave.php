<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseControllerFaculty.php';

class Leave extends BaseController {
    public function __construct()
    {
        parent::__construct();
        //$this->load->library('excel');
        $this->load->model('staff_model','staff');
        $this->load->model('leave_model','leave');
        $this->load->model('settings_model','settings');
        $this->isLoggedIn();
    }
    function staffLeaveInfo() {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {        
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Staffs Leave Info';
            $this->loadViews("staff_leave/viewStaffLeave", $this->global, NULL , NULL);
        }
    }

    public function viewApplyLeave(){
        if ($this->isAdmin() == true) {
            $this->loadThis();
        } else {
            $data['staffInfo'] = $this->staff->getAllStaffInfo();
            $data['leaveInfo'] = $this->leave->getLeaveInfoByStaffId($this->staff_id);
            $data['streamInfo'] = $this->settings->getStreamInfo();
            $data['active'] = '';
            $this->global['pageTitle'] = ''.TAB_TITLE.' : View Staff Details';
            $this->loadViews("staff_leave/apply_staff_leave", $this->global, $data, null);
        } 
    }

   public function applyLeaveByStaff(){
    if ($this->isAdmin() == true) {
        $this->loadThis();
    } else {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fromDate','Leave Date From','trim|required');
        $this->form_validation->set_rules('total_leave_days','Total Days','trim|required');
        $this->form_validation->set_rules('leave_type','Leave Type','trim|required');
        $this->form_validation->set_rules('leave_reason','Leave Reason','trim|required');
        if($this->form_validation->run() == FALSE) {
            redirect('viewApplyLeave');
        } else {
            $leave_valid_status = false;
            $date_from = $this->security->xss_clean($this->input->post('fromDate'));
            $date_to = $this->security->xss_clean($this->input->post('toDate'));
            $total_leave_days = $this->security->xss_clean($this->input->post('total_leave_days'));
            $leave_type = $this->security->xss_clean($this->input->post('leave_type'));
            $leave_reason = $this->security->xss_clean($this->input->post('leave_reason'));
            
            $assignedDate = $this->security->xss_clean($this->input->post('assignedDate'));
            $assignedPeriod = $this->security->xss_clean($this->input->post('assignedPeriod'));
            $assignedClass = $this->security->xss_clean($this->input->post('assignedClass'));
            $assignedStream = $this->security->xss_clean($this->input->post('assignedStream'));
            $assignedSection = $this->security->xss_clean($this->input->post('assignedSection'));
            $assigned_staff_id = $this->security->xss_clean($this->input->post('assigned_staff_id'));

            $isApplied = $this->leave->checkLeaveAppliedAlready($date_from,$this->staff_id);
            $leaveDetails = $this->leave->getLeaveInfoByStaffId($this->staff_id);

            $uploadPath = 'upload/medical_certificate/'.$this->staff_id.'/';
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $image_path="";
            $config=['upload_path' => $uploadPath,
            'allowed_types' => 'jpg|png|jpeg','max_size' => '2048','overwrite' => TRUE,'file_ext_tolower' => TRUE];
            $this->load->library('upload', $config);
            if($this->upload->do_upload()) {
                $post=$this->input->post();
                $data=$this->upload->data();
                $image_path = $uploadPath.$data['raw_name'].$data['file_ext'];
                $post['image_path']=$image_path;
            }

            if($leave_type == 'LOP'){
                $leave_valid_status = true;
            }else if($leave_type == 'CL'){
                $cl_rem = $leaveDetails->casual_leave_earned - $leaveDetails->casual_leave_used;
                if($total_leave_days <= $cl_rem){
                    $leave_valid_status = true;
                }else{
                    $this->session->set_flashdata('error', 'Please check remaining casual leave balance!');
                    $leave_valid_status = false;
                }
            } else if($leave_type == 'ML'){
                $ml_rem = $leaveDetails->sick_leave_earned - $leaveDetails->sick_leave_used;
                if($total_leave_days <= $ml_rem){
                    $leave_valid_status = true;
                }else{
                    $this->session->set_flashdata('error', 'Please check remaining medical leave balance!');
                    $leave_valid_status = false;
                }
            }else if($leave_type == 'MARL'){
                $mrl_rem = $leaveDetails->marriage_leave_earned - $leaveDetails->marriage_leave_used;
                if($total_leave_days <= $mrl_rem){
                    $leave_valid_status = true;
                }else{
                    $this->session->set_flashdata('error', 'Please check remaining marriage leave balance!');
                    $leave_valid_status = false;
                }
            }else if($leave_type == 'PL'){
                $pl_rem = $leaveDetails->paternity_leave_earned - $leaveDetails->paternity_leave_used;
                if($total_leave_days <= $pl_rem){
                    $leave_valid_status = true;
                }else{
                    $this->session->set_flashdata('error', 'Please check remaining paternity leave balance!');
                    $leave_valid_status = false;
                }
            }else if($leave_type == 'MATL'){
                $mtl_rem = $leaveDetails->maternity_leave_earned - $leaveDetails->maternity_leave_used;
                if($total_leave_days <= $mtl_rem){
                    $leave_valid_status = true;
                }else{
                    $this->session->set_flashdata('error', 'Please check remaining maternity leave balance!');
                    $leave_valid_status = false;
                }
            }
            if(empty($isApplied)){
                if($leave_valid_status == true){
            $leaveInfo = array(
                'staff_id' => $this->staff_id,
                'applied_date_time' => date('Y-m-d H:i:s'),
                'date_from' => date('Y-m-d',strtotime($date_from)) ,
                'date_to' => date('Y-m-d',strtotime($date_to)),
                'leave_reason' => $leave_reason,
                'total_days_leave' => $total_leave_days,
                'medical_certificate' => $image_path,
                'leave_type' => $leave_type,
                'year' => LEAVE_YEAR,
                'created_by' => $this->staff_id,
                'created_date_time' => date('Y-m-d H:i:s'),
            );
            $return_id = $this->leave->addAppliedStaffLeave($leaveInfo);
            if($return_id){
                if(!empty($assignedDate)){
                    for($i=0; $i<count($assignedDate); $i++){
                        $assignedStaffs = array(
                            'rel_leave_row_id' => $return_id,
                            'assigned_date' => date('Y-m-d',strtotime($assignedDate[$i])),
                            'assigned_period' => $assignedPeriod[$i],
                            'assigned_class_name' => $assignedClass[$i],
                            'assigned_class_section' => $assignedSection[$i],
                            'assigned_stream_name' => $assignedStream[$i],
                            'assigned_staff_id' => $assigned_staff_id[$i],
                            'created_by' => $this->staff_id,
                            'created_date_time' => date('Y-m-d H:i:s'),
                        );
                        $return_assigned = $this->leave->assignStaffWork($assignedStaffs);
                    }
                }
               
                $this->session->set_flashdata('success', 'Leave Applied Successfully');
            }else{
                $this->session->set_flashdata('error', 'Apply leave failed');
            }
        }
        }else{
            $this->session->set_flashdata('error', 'Leave already applied on selected date');
        }
        
            redirect('viewApplyLeave');
        }
    }
   }


   public function get_applied_leave_info(){
    if ($this->isAdmin() == true) {
        $this->loadThis();
    } else {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
          $data_array_new = [];
         
          $leaveInfo = $this->leave->getAllStaffLeaveInfo();
          log_message('debug',print_r($leaveInfo,true));
          foreach($leaveInfo as $staff) {
            $deleteButton = "";
            $editButton = "";
            $staffViewMore = '<button class="btn btn-xs btn-primary" onclick="viewMoreInfo('.$staff->row_id.')"
            title="View More"><i class="fa fa-eye"></i> View</button>';

              if($this->role == ROLE_ADMIN || $this->role == ROLE_PRIMARY_ADMINISTRATOR){
                $deleteButton = '<a class="btn btn-xs btn-danger deleteAppliedLeave" href="#"
                data-row_id="'.$staff->row_id.'" title="Delete Leave"><i
                    class="fa fa-trash"></i></a>';
  
                $editButton = '<a class="btn btn-xs btn-info"
                href="'.base_url().'editStaffLeaveInfo/'.$staff->row_id.'"  title="Edit Staff"><i
                        class="fas fa-pencil-alt"></i></a>';
              }
            
            if( $staff->approved_status == 0){
                $leave_status = '<b id="tr'.$staff->row_id.'" style="color:#B7950B">Pending</b>';
            }else if($staff->approved_status == 1){
                $leave_status = '<b id="tr'.$staff->row_id.'" style="color:green">Approved</b>';
            }else{
                $leave_status = '<b id="tr'.$staff->row_id.'" style="color:Red">Rejected</b>'; 
            }
            $data_array_new[] = array(
                date('d-m-Y',strtotime($staff->date_from)),
                date('d-m-Y',strtotime($staff->date_to)),
                $staff->staff_id,
                $staff->name,
                $staff->total_days_leave,
                $staff->leave_type,
                $leave_status,
                $staffViewMore.' '.$editButton.' '.$deleteButton
                );
            }
         $count = count($leaveInfo);
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

   public function get_single_staff_applied_leave_info(){
    if ($this->isAdmin() == true) {
        $this->loadThis();
    } else {
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
          $data_array_new = [];
          $leaveInfo = $this->leave->getAppliedLeaveInfoByStaffId($this->staff_id);
          foreach($leaveInfo as $staff) {
              $staffViewMore = '<button class="btn btn-xs btn-primary" onclick="viewMoreInfo('.$staff->row_id.')"
              title="View More"><i class="fa fa-eye"></i> View</button>';

                if($staff->approved_status == 0){
                    $editButton = '<a class="btn btn-xs btn-info"
                    href="'.base_url().'editStaffLeaveInfo/'.$staff->row_id.'"  title="Edit Staff"><i
                            class="fas fa-pencil-alt"></i></a>';
                }else{
                    $editButton = "";
                }
             
            if( $staff->approved_status == 0){
                $leave_status = '<b id="tr'.$staff->row_id.'" style="color:#B7950B">Pending</b>';
            }else if($staff->approved_status == 1){
                $leave_status = '<b id="tr'.$staff->row_id.'" style="color:green">Approved</b>';
            }else{
                $leave_status = '<b id="tr'.$staff->row_id.'" style="color:Red">Rejected</b>'; 
            }
            $data_array_new[] = array(
                date('d-m-Y',strtotime($staff->date_from)),
                date('d-m-Y',strtotime($staff->date_to)),
                $staff->total_days_leave,
                $staff->leave_type,
                $leave_status,
                $staffViewMore.' '.$editButton
                );
            }
         $count = count($leaveInfo);
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

   public function getStaffLeaveInfoById(){
    if ($this->isAdmin() == true) {
         $this->loadThis();
    } else {
        $row_id = $this->security->xss_clean($this->input->post('row_id'));
        $data['leaveInfo'] = $this->leave->getStaffLeaveInfoByRow_Id($row_id);
        
        $data['leavePending'] = $this->leave->getLeaveInfoByStaffId($data['leaveInfo']->staff_id);

        $data['workAssign'] = $this->leave->getStaffWorkAssignByRow_Id($row_id);
      
        echo json_encode($data);
        exit();
    }
   }


   //this update method for approve, reject staff leave 
   public function updateStaffLeaveInfo(){
    if($this->isAdmin() == TRUE){
        $this->loadThis();
    } else {   
        $row_id = $this->input->post('row_id');
        $type = $this->input->post('type');
        $AppliedLeaveInfo = $this->leave->getStaffLeaveInfoByRow_Id($row_id);
        // $leaveDetails = $this->leave->getLeaveInfoByStaffId($AppliedLeaveInfo->staff_id);
    $leaveDetails = $this->leave->getLeaveInfoByStaffIdYear($AppliedLeaveInfo->staff_id,$AppliedLeaveInfo->year);

        $updateLeaveInfo = array(
           'updated_date_time' => date('Y-m-d H:i:s'), 
        );
        if($type == 'Approve'){
            if($AppliedLeaveInfo->approved_status == 0 || $AppliedLeaveInfo->approved_status == 2){
            if($AppliedLeaveInfo->leave_type == 'LOP'){
                $lop_used = $AppliedLeaveInfo->total_days_leave + $leaveDetails->lop_leave;
                $updateLeaveInfo['lop_leave'] = $lop_used;
               
            }else if($AppliedLeaveInfo->leave_type == 'CL'){
                $cl_used = $AppliedLeaveInfo->total_days_leave + $leaveDetails->casual_leave_used;
                $updateLeaveInfo['casual_leave_used'] = $cl_used;
                
            } else if($AppliedLeaveInfo->leave_type == 'ML'){
                $ml_used = $AppliedLeaveInfo->total_days_leave + $leaveDetails->sick_leave_used;
                $updateLeaveInfo['sick_leave_used'] = $ml_used;
               
            }else if($AppliedLeaveInfo->leave_type == 'MARL'){
                $marl_used = $AppliedLeaveInfo->total_days_leave + $leaveDetails->marriage_leave_used;
                $updateLeaveInfo['marriage_leave_used'] = $marl_used;

            }else if($AppliedLeaveInfo->leave_type == 'PL'){
                $pl_used = $AppliedLeaveInfo->total_days_leave + $leaveDetails->paternity_leave_used;
                $updateLeaveInfo['paternity_leave_used'] = $pl_used;

            }else if($AppliedLeaveInfo->leave_type == 'MATL'){
                $matl_used = $AppliedLeaveInfo->total_days_leave + $leaveDetails->maternity_leave_used;
                $updateLeaveInfo['maternity_leave_used'] = $matl_used;
            }
           
            }
            $staffInfo = array('approved_status' => 1,
            'approved_by' => $this->staff_id,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id,
        );
        }else if($type == 'Reject'){
            if($AppliedLeaveInfo->approved_status == 1){
                if($AppliedLeaveInfo->leave_type == 'LOP'){
                    $lop_used = $leaveDetails->lop_leave - $AppliedLeaveInfo->total_days_leave ;
                    $updateLeaveInfo['lop_leave'] = $lop_used;
                }else if($AppliedLeaveInfo->leave_type == 'CL'){
                    $cl_used = $leaveDetails->casual_leave_used - $AppliedLeaveInfo->total_days_leave ;
                    $updateLeaveInfo['casual_leave_used'] = $cl_used;
                } else if($AppliedLeaveInfo->leave_type == 'ML'){
                    $ml_used =  $leaveDetails->sick_leave_used - $AppliedLeaveInfo->total_days_leave;
                    $updateLeaveInfo['sick_leave_used'] = $ml_used;
                }else if($AppliedLeaveInfo->leave_type == 'MARL'){
                    $marl_used =  $leaveDetails->marriage_leave_used - $AppliedLeaveInfo->total_days_leave;
                    $updateLeaveInfo['marriage_leave_used'] = $marl_used;
                }else if($AppliedLeaveInfo->leave_type == 'PL'){
                    $pl_used = $leaveDetails->paternity_leave_used - $AppliedLeaveInfo->total_days_leave ;
                    $updateLeaveInfo['paternity_leave_used'] = $pl_used;
                }else if($AppliedLeaveInfo->leave_type == 'MATL'){
                    $matl_used =  $leaveDetails->maternity_leave_used - $AppliedLeaveInfo->total_days_leave;
                    $updateLeaveInfo['maternity_leave_used'] = $matl_used;
                }
               
                }
            $staffInfo = array('approved_status' => 2,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'rejected_by' => $this->staff_id,
            'updated_by' => $this->staff_id,
        );
        }
        // $this->leave->updateStaffLeaveInfo($updateLeaveInfo, $AppliedLeaveInfo->staff_id);
    $this->leave->updateStaffLeaveInfoByYearNew($updateLeaveInfo, $AppliedLeaveInfo->staff_id,$AppliedLeaveInfo->year);

        $result = $this->leave->updateStaffAppliedLeaveInfo($staffInfo, $row_id);
        if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
    } 
}




//delete a leave applied 
public function deleteAppliedLeave(){
    if($this->isAdmin() == TRUE){
        $this->loadThis();
    } else {   
        $row_id = $this->input->post('row_id');
        $leaveInfo = array('is_deleted' => 1,'updated_date_time' => date('Y-m-d H:i:s'));
        $result = $this->leave->updateStaffAppliedLeaveInfo($leaveInfo, $row_id);
        if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
    } 
}

//edit Staff View

public function editStaffLeaveInfo($row_id){
    if($this->isAdmin() == TRUE){
        $this->loadThis();
    } else {
        if($row_id == NULL){
            redirect("staffLeaveInfo");
        }
       
        $data['staffInfo'] = $this->staff->getAllStaffInfo();
        $data['AppliedLeaveInfo'] = $this->leave->getStaffLeaveInfoByRow_Id($row_id);
        $data['workAssign'] = $this->leave->getStaffWorkAssignByRow_Id($row_id);
        $data['leaveInfo'] = $this->leave->getLeaveInfoByStaffId($data['AppliedLeaveInfo']->staff_id);  
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Edit Staff Leave Info';
        $this->loadViews("staff_leave/editStaffLeaveInfo", $this->global, $data , NULL);
    }
}

//update Staff Leave info
public function updateStaffLeaveInfoByAdmin(){
    if($this->isAdmin() == TRUE){
        $this->loadThis();
    } else { 
        $row_id = $this->security->xss_clean($this->input->post('row_id'));
        $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('fromDate','Leave Date From','trim|required');
        $this->form_validation->set_rules('total_leave_days','Total Days','trim|required');
        $this->form_validation->set_rules('leave_type','Leave Type','trim|required');
        $this->form_validation->set_rules('leave_reason','Leave Reason','trim|required');
        
        if($this->form_validation->run() == FALSE) {
            redirect('editStaffLeaveInfo/'.$row_id);
        } else { 
            $date_from = $this->security->xss_clean($this->input->post('fromDate'));
            $date_to = $this->security->xss_clean($this->input->post('toDate'));
            $total_leave_days = $this->security->xss_clean($this->input->post('total_leave_days'));
            $leave_type = $this->security->xss_clean($this->input->post('leave_type'));
            $leave_reason = $this->security->xss_clean($this->input->post('leave_reason'));
            
            $assignedDate = $this->security->xss_clean($this->input->post('assignedDate'));
            $assignedPeriod = $this->security->xss_clean($this->input->post('assignedPeriod'));
            $assignedClass = $this->security->xss_clean($this->input->post('assignedClass'));
            $assignedSection = $this->security->xss_clean($this->input->post('assignedSection'));
            $assigned_staff_id = $this->security->xss_clean($this->input->post('assigned_staff_id'));

            $AppliedLeaveInfo = $this->leave->getStaffLeaveInfoByRow_Id($row_id);

            $leaveDetails = $this->leave->getLeaveInfoByStaffId($AppliedLeaveInfo->staff_id);

            $uploadPath = 'upload/medical_certificate/'.$AppliedLeaveInfo->staff_id.'/';
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $image_path="";
            $config=['upload_path' => $uploadPath,
            'allowed_types' => 'jpg|png|jpeg','max_size' => '2048','overwrite' => TRUE,'file_ext_tolower' => TRUE];
            $this->load->library('upload', $config);
            if($this->upload->do_upload()) {
                $post=$this->input->post();
                $data=$this->upload->data();
                $image_path= $uploadPath.$data['raw_name'].$data['file_ext'];
                $post['image_path']=$image_path;
            }

            if($leave_type == 'LOP'){
                $leave_valid_status = true;
            }else if($leave_type == 'CL'){
                $cl_rem = $leaveDetails->casual_leave_earned  - $leaveDetails->casual_leave_used;
                if($total_leave_days <= $cl_rem){
                    $leave_valid_status = true;
                }else{
                    $this->session->set_flashdata('error', 'Please check remaining casual leave balance!');
                    $leave_valid_status = false;
                }
            } else if($leave_type == 'ML'){
                $ml_rem = $leaveDetails->sick_leave_earned  - $leaveDetails->sick_leave_used;
                if($total_leave_days <= $ml_rem){
                    $leave_valid_status = true;
                }else{
                    $this->session->set_flashdata('error', 'Please check remaining medical leave balance!');
                    $leave_valid_status = false;
                }
            }else if($leave_type == 'MARL'){
                $mrl_rem = $leaveDetails->marriage_leave_earned  - $leaveDetails->marriage_leave_used;
                if($total_leave_days <= $mrl_rem){
                    $leave_valid_status = true;
                }else{
                    $this->session->set_flashdata('error', 'Please check remaining marriage leave balance!');
                    $leave_valid_status = false;
                }
            }else if($leave_type == 'PL'){
                $pl_rem = $leaveDetails->paternity_leave_earned  - $leaveDetails->paternity_leave_used;
                if($total_leave_days <= $pl_rem){
                    $leave_valid_status = true;
                }else{
                    $this->session->set_flashdata('error', 'Please check remaining paternity leave balance!');
                    $leave_valid_status = false;
                }
            }else if($leave_type == 'MATL'){
                $mtl_rem = $leaveDetails->maternity_leave_earned  - $leaveDetails->maternity_leave_used;
                if($total_leave_days <= $mtl_rem){
                    $leave_valid_status = true;
                }else{
                    $this->session->set_flashdata('error', 'Please check remaining maternity leave balance!');
                    $leave_valid_status = false;
                }
            }
          
            if($leave_valid_status == true){
                $leaveInfo = array(
                    'applied_date_time' => date('Y-m-d H:i:s'),
                    'date_from' => date('Y-m-d',strtotime($date_from)) ,
                    'date_to' => date('Y-m-d',strtotime($date_to)),
                    'leave_reason' => $leave_reason,
                    'total_days_leave' => $total_leave_days,
                    'leave_type' => $leave_type,
                    'medical_certificate' => $image_path,
                    'updated_by' => $this->staff_id,
                    'updated_date_time' => date('Y-m-d H:i:s'),
                );
                $result = $this->leave->updateStaffAppliedLeaveInfo($leaveInfo, $row_id);
                // log_message('debug','testsss'.print_r($leaveInfo,true));
                if(!empty($assignedDate)){
                    for($i=0; $i<count($assignedDate); $i++){
                        $assignedStaffs = array(
                            'rel_leave_row_id' => $row_id,
                            'assigned_date' => date('Y-m-d',strtotime($assignedDate[$i])),
                            'assigned_period' => $assignedPeriod[$i],
                            'assigned_class_name' => $assignedClass[$i],
                            'assigned_class_section' => $assignedSection[$i],
                            'assigned_staff_id' => $assigned_staff_id[$i],
                            'created_by' => $this->staff_id,
                            'created_date_time' => date('Y-m-d H:i:s'),
                        );
                        $return_assigned = $this->leave->assignStaffWork($assignedStaffs);
                    }
                }
            }else{
                redirect('editStaffLeaveInfo/'.$row_id);
            }

            if($result){
                $this->session->set_flashdata('success', 'Leave Updated Successfully');
                redirect('editStaffLeaveInfo/'.$row_id);
            }else{
                $this->session->set_flashdata('error', 'leave Updated failed');
                redirect('editStaffLeaveInfo/'.$row_id);
            }
           
        } 
    }
}
  public function getStaffLeaveInfoByStaffId(){
    if ($this->isAdmin() == true) {
         $this->loadThis();
    } else {
        $staff_id = $this->security->xss_clean($this->input->post('staff_id'));
        $data['leaveInfo'] = $this->leave->getLeaveInfoByStaffId($staff_id);
        echo json_encode($data);
        exit();
    }
   }


public function viewAdminApplyLeavePage(){
    if ($this->isAdmin() == true) {
        $this->loadThis();
    } else {
        $data['staffInfo'] = $this->staff->getAllStaffInfo();
        $data['leaveInfo'] = "";
        $data['active'] = '';
        $data['streamInfo'] = $this->settings->getStreamInfo();
        $this->global['pageTitle'] = ''.TAB_TITLE.' : View Admin Staff Leave';
        $this->loadViews("staff_leave/apply_leave_by_admin", $this->global, $data, null);
    }
}


public function applyStaffLeaveByAdmin(){
    if ($this->isAdmin() == true) {
        $this->loadThis();
    } else {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('applied_staff_id','Applied Staff Id','trim|required');
        $this->form_validation->set_rules('fromDate','Leave Date From','trim|required');
        $this->form_validation->set_rules('total_leave_days','Total Days','trim|required');
        $this->form_validation->set_rules('leave_type','Leave Type','trim|required');
        $this->form_validation->set_rules('leave_reason','Leave Reason','trim|required');
        if($this->form_validation->run() == FALSE) {
            redirect('viewApplyLeave');
        } else {
            $applied_staff_id = $this->security->xss_clean($this->input->post('applied_staff_id'));
            $date_from = $this->security->xss_clean($this->input->post('fromDate'));
            $date_to = $this->security->xss_clean($this->input->post('toDate'));
            $total_leave_days = $this->security->xss_clean($this->input->post('total_leave_days'));
            $leave_type = $this->security->xss_clean($this->input->post('leave_type'));
            $leave_reason = $this->security->xss_clean($this->input->post('leave_reason'));
            
            $uploadPath = 'upload/medical_certificate/'.$applied_staff_id.'/';
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $image_path="";
            $staffInfo = array();
            $config=['upload_path' => $uploadPath,
            'allowed_types' => 'jpg|png|jpeg','max_size' => '2048','overwrite' => TRUE,'file_ext_tolower' => TRUE];
            $this->load->library('upload', $config);
            if($this->upload->do_upload()) {
                $post=$this->input->post();
                $data=$this->upload->data();
                $image_path = $uploadPath.$data['raw_name'].$data['file_ext'];
                $post['image_path']=$image_path;
            }
            
            $assignedDate = $this->security->xss_clean($this->input->post('assignedDate'));
            $assignedPeriod = $this->security->xss_clean($this->input->post('assignedPeriod'));
            $assignedClass = $this->security->xss_clean($this->input->post('assignedClass'));
            $assignedStream = $this->security->xss_clean($this->input->post('assignedStream'));
            $assignedSection = $this->security->xss_clean($this->input->post('assignedSection'));
            $assigned_staff_id = $this->security->xss_clean($this->input->post('assigned_staff_id'));
            $leaveInfo = array(
                'staff_id' => $applied_staff_id,
                'applied_date_time' => date('Y-m-d H:i:s'),
                'date_from' => date('Y-m-d',strtotime($date_from)) ,
                'date_to' => date('Y-m-d',strtotime($date_to)),
                'leave_reason' => $leave_reason,
                'total_days_leave' => $total_leave_days,
                'leave_type' => $leave_type,
                'year' => LEAVE_YEAR,
                'medical_certificate' => $image_path,
                'created_by' => $this->staff_id,
                'created_date_time' => date('Y-m-d H:i:s'),
            );
            $return_id = $this->leave->addAppliedStaffLeave($leaveInfo);
            if($return_id){
                if(!empty($assignedDate)){
                    for($i=0; $i<count($assignedDate); $i++){
                        $assignedStaffs = array(
                            'rel_leave_row_id' => $return_id,
                            'assigned_date' => date('Y-m-d',strtotime($assignedDate[$i])),
                            'assigned_period' => $assignedPeriod[$i],
                            'assigned_class_name' => $assignedClass[$i],
                            'assigned_stream_name' => $assignedStream[$i],
                            'assigned_class_section' => $assignedSection[$i],
                            'assigned_staff_id' => $assigned_staff_id[$i],
                            'created_by' => $this->staff_id,
                            'created_date_time' => date('Y-m-d H:i:s'),
                        );
                        $return_assigned = $this->leave->assignStaffWork($assignedStaffs);
                    }
                }
               
                $this->session->set_flashdata('success', 'Staff Leave Applied Successfully');
            }else{
                $this->session->set_flashdata('error', 'Apply leave staff failed');
            }
            redirect('viewAdminApplyLeavePage');
        }
    }
   }

}
?>