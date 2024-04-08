<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class ApiStaff extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('app_staff_login');
        
    }


    public function checkIsExist(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);  
       
        $mbl_number = $obj['mblnumber'];

        log_message('debug','mbl_number-->'.print_r($mbl_number,true));
       

        $isExist = $this->app_staff_login->checkMobNo($mbl_number);
        log_message('debug','isExist-->'.print_r($isExist,true));

       

        if($isExist > 0) { 
            
    //         $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
    //         $appId="WPtmySv14q3";
    //         $message = "$otp is your verification code for PARROPASS. $appId 
    // Regards, Parrophins.";
    //         $result_sms = $this->sendOtpmsg($mbl_number, $message);
    
    //        if($mbl_number!='1234567891' && $mbl_number!='1231231231' && $mbl_number!='1212121212'  && $mbl_number!='1313131313'){
    //             if($result_sms == 'success'){
            
    //                 $otpUpdate = array(
    //                     'last_otp'=>$otp
    //                 );
    
    //                 $update = $this->login_model->updateUserOtp($mbl_number,$otpUpdate);
                    
    //             }
    //        }
            $msg='isExist'; 
        }else { 
            $msg= 'failed'; 
        }    
        
       
        
    
        echo json_encode($msg);
        }


        public function fetchstaffDetails()
        {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);
            //log_message('debug', 'obj-->' . print_r($obj, true));
            $mbl_number = $obj['mblnumber'];
            //log_message('debug', 'mbl_number-->' . print_r($mbl_number, true));
    
            $fetchDetails = $this->app_staff_login->fetchStaffDetails($mbl_number);
    
            log_message(
                'debug',
                'staffDetails is -->' . print_r($fetchDetails, true)
            );
    
            echo json_encode($fetchDetails);
        }

        public function leaveType()
        {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);
            // log_message('debug', 'obj-->' . print_r($obj, true));
            $staffID = $obj['staff_id'];
            // log_message('debug', 'staffID-->' . print_r($staffID, true));
    
            // Fetch leave management information
            $fetchLeaveManagement = $this->app_staff_login->fetchLeaveMangementInfo(
                $staffID
            );
    
            // log_message(
            //     'debug',
            //     'fetchLeaveManagement is -->' . print_r($fetchLeaveManagement, true)
            // );
    
            // Initialize an array to store formatted leave types
            $formattedLeaveTypes = [];
    
            // Calculate remaining casual leave
            $casualLeaveRemaining =
                $fetchLeaveManagement[0]->casual_leave_earned -
                $fetchLeaveManagement[0]->casual_leave_used;
    
            $sickLeaveRemaining =
                $fetchLeaveManagement[0]->sick_leave_earned -
                $fetchLeaveManagement[0]->sick_leave_used;
    
            $marriageLeaveRemaining =
                $fetchLeaveManagement[0]->marriage_leave_earned -
                $fetchLeaveManagement[0]->marriage_leave_used;
    
            $paternityLeaveRemaining =
                $fetchLeaveManagement[0]->paternity_leave_earned -
                $fetchLeaveManagement[0]->paternity_leave_used;
    
            $maternityLeaveRemaining =
                $fetchLeaveManagement[0]->maternity_leave_earned -
                $fetchLeaveManagement[0]->maternity_leave_used;
    
            // Display casual leave if remaining is not zero
            if ($casualLeaveRemaining != 0) {
                $formattedLeaveTypes[] = (object) [
                    'leave_type' => 'Casual Leave(CL)',
                    'leave_short' => 'CL',
                    'count' => $casualLeaveRemaining,
                ];
            }
    
            if ($sickLeaveRemaining != 0) {
                $formattedLeaveTypes[] = (object) [
                    'leave_type' => 'Medical Leave(ML)',
                    'leave_short' => 'ML',
                    'count' => $sickLeaveRemaining,
                ];
            }
    
            if ($marriageLeaveRemaining != 0) {
                $formattedLeaveTypes[] = (object) [
                    'leave_type' => 'Marriage Leave(ML)',
                    'leave_short' => 'MARL',
                    'count' => $marriageLeaveRemaining,
                ];
            }
    
            if ($paternityLeaveRemaining != 0) {
                $formattedLeaveTypes[] = (object) [
                    'leave_type' => 'Paternity Leave(PL)',
                    'leave_short' => 'PL',
                    'count' => $paternityLeaveRemaining,
                ];
            }
    
            if ($maternityLeaveRemaining != 0) {
                $formattedLeaveTypes[] = (object) [
                    'leave_type' => 'Maternity Leave(ML)',
                    'leave_short' => 'MATL',
                    'count' => $maternityLeaveRemaining,
                ];
            }
    
            // Display other leave types
            $formattedLeaveTypes[] = (object) [
                'leave_type' => 'Loss Of Pay(LOP)',
                'leave_short' => 'LOP',
                'count' => '0',
            ];
            // Add more leave types here if needed
    
            log_message(
                'debug',
                'staffDetails is -->' . print_r($formattedLeaveTypes, true)
            );
    
            echo json_encode($formattedLeaveTypes);
        }
    
        public function listLeaveInfo()
        {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);
            //log_message('debug', 'obj-->' . print_r($obj, true));
            $staffID = $obj['staff_id'];
            //log_message('debug', 'staffID-->' . print_r($staffID, true));
    
            // Fetch leave management information
            $fetchLeaveManagement = $this->app_staff_login->fetchLeaveMangementInfo(
                $staffID
            );
    
            // log_message(
            //     'debug',
            //     'fetchLeaveManagement is -->' . print_r($fetchLeaveManagement, true)
            // );
    
            // Initialize an array to store formatted leave types
            $formattedLeaveTypes = [];
    
            // Calculate remaining casual leave
            $casualLeaveRemaining =
                $fetchLeaveManagement[0]->casual_leave_earned -
                $fetchLeaveManagement[0]->casual_leave_used;
    
            $sickLeaveRemaining =
                $fetchLeaveManagement[0]->sick_leave_earned -
                $fetchLeaveManagement[0]->sick_leave_used;
    
            $marriageLeaveRemaining =
                $fetchLeaveManagement[0]->marriage_leave_earned -
                $fetchLeaveManagement[0]->marriage_leave_used;
    
            $paternityLeaveRemaining =
                $fetchLeaveManagement[0]->paternity_leave_earned -
                $fetchLeaveManagement[0]->paternity_leave_used;
    
            $maternityLeaveRemaining =
                $fetchLeaveManagement[0]->maternity_leave_earned -
                $fetchLeaveManagement[0]->maternity_leave_used;
    
            // Display casual leave if remaining is not zero
            if ($casualLeaveRemaining != 0) {
                $formattedLeaveTypes[] = (object) [
                    'leave_type' => 'Casual Leave(CL)',
                    'leave_short' => 'CL',
                    'earned' => $fetchLeaveManagement[0]->casual_leave_earned,
                    'used' => $fetchLeaveManagement[0]->casual_leave_used,
                    'remaining' => $casualLeaveRemaining,
                ];
            }
    
            if ($sickLeaveRemaining != 0) {
                $formattedLeaveTypes[] = (object) [
                    'leave_type' => 'Medical Leave(ML)',
                    'leave_short' => 'ML',
                    'earned' => $fetchLeaveManagement[0]->sick_leave_earned,
                    'used' => $fetchLeaveManagement[0]->sick_leave_used,
                    'remaining' => $sickLeaveRemaining,
                ];
            }
    
            if ($marriageLeaveRemaining != 0) {
                $formattedLeaveTypes[] = (object) [
                    'leave_type' => 'Marriage Leave(ML)',
                    'leave_short' => 'MARL',
                    'earned' => $fetchLeaveManagement[0]->marriage_leave_earned,
                    'used' => $fetchLeaveManagement[0]->marriage_leave_used,
                    'remaining' => $marriageLeaveRemaining,
                ];
            }
    
            if ($paternityLeaveRemaining != 0) {
                $formattedLeaveTypes[] = (object) [
                    'leave_type' => 'Paternity Leave(PL)',
                    'leave_short' => 'PL',
                    'earned' => $fetchLeaveManagement[0]->paternity_leave_earned,
                    'used' => $fetchLeaveManagement[0]->paternity_leave_used,
                    'remaining' => $paternityLeaveRemaining,
                ];
            }
    
            if ($maternityLeaveRemaining != 0) {
                $formattedLeaveTypes[] = (object) [
                    'leave_type' => 'Maternity Leave(ML)',
                    'leave_short' => 'MATL',
                    'earned' => $fetchLeaveManagement[0]->maternity_leave_earned,
                    'used' => $fetchLeaveManagement[0]->maternity_leave_used,
                    'remaining' => $maternityLeaveRemaining,
                ];
            }
    
            // Display other leave types
            if (!empty($fetchLeaveManagement)) {
                $formattedLeaveTypes[] = (object) [
                    'leave_type' => 'Loss Of Pay(LOP)',
                    'leave_short' => 'LOP',
                    'earned' => '0',
                    'used' => '0',
                    'remaining' => $fetchLeaveManagement[0]->lop_leave,
                ];
            } else {
                $formattedLeaveTypes[] = (object) [
                    'leave_type' => 'Loss Of Pay(LOP)',
                    'leave_short' => 'LOP',
                    'earned' => '0',
                    'used' => '0',
                    'remaining' => '0',
                ];
            }
            // Add more leave types here if needed
    
            log_message(
                'debug',
                'staffDetails is -->' . print_r($formattedLeaveTypes, true)
            );
    
            echo json_encode($formattedLeaveTypes);
        }
    
        public function applyLeaveWithoutDoc()
        {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);
            $staff_id = $obj['staff_id'];
            $totalLeave = $obj['total_leave'];
            $leaveFromDate = $obj['leave_from_date'];
            $leaveToDate = $obj['leave_to_date'];
            $leaveType = $obj['leave_type'];
            $leaveReason = $obj['leave_reason'];
    
            $leaveInfo = [
                'staff_id' => $staff_id,
                'applied_date_time' => date('Y-m-d H:i:s'),
                'date_from' => date('Y-m-d', strtotime($leaveFromDate)),
                'date_to' => date('Y-m-d', strtotime($leaveToDate)),
                'leave_reason' => $leaveReason,
                'total_days_leave' => $totalLeave,
                'leave_type' => $leaveType,
                'created_by' => $staff_id,
                'created_date_time' => date('Y-m-d H:i:s'),
            ];
    
            $insertLeave = $this->app_staff_login->applyLeaveInsert($leaveInfo);
    
            if ($insertLeave > 0) {
                $msg = 'success';
            } else {
                $msg = 'failed';
            }
    
            log_message('debug', 'leaveInfo is -->' . print_r($leaveInfo, true));
    
            echo json_encode($msg);
        }
    
        public function applyLeaveWithDoc()
        {
            $file = $_FILES['file'];
            $filename = $file['name'] . '.' . $_POST['file_type'];
            $tmpFilePath = $file['tmp_name'];
            $targetDir = 'upload/medical_certificate/' . $_POST['staff_id'] . '/';
    
            // Check if target directory exists, if not create it
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true); // Creates the directory recursively
            }
    
            $targetPath = $targetDir . $filename;
            $profileImageSize = filesize($tmpFilePath);
    
            move_uploaded_file($tmpFilePath, $targetPath);
    
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);
            $staff_id = $_POST['staff_id'];
            $totalLeave = $_POST['total_leave'];
            $leaveFromDate = $_POST['leave_from_date'];
            $leaveToDate = $_POST['leave_to_date'];
            $leaveType = $_POST['leave_type'];
            $leaveReason = $_POST['leave_reason'];
    
            $leaveInfo = [
                'staff_id' => $staff_id,
                'applied_date_time' => date('Y-m-d H:i:s'),
                'date_from' => date('Y-m-d', strtotime($leaveFromDate)),
                'date_to' => date('Y-m-d', strtotime($leaveToDate)),
                'leave_reason' => $leaveReason,
                'total_days_leave' => $totalLeave,
                'leave_type' => $leaveType,
                'created_by' => $staff_id,
                'created_date_time' => date('Y-m-d H:i:s'),
                'medical_certificate' => $targetPath,
            ];
    
            $insertLeave = $this->app_staff_login->applyLeaveInsert($leaveInfo);
    
            if ($insertLeave > 0) {
                $msg = 'success';
            } else {
                $msg = 'failed';
            }
    
            log_message('debug', 'leaveInfo is -->' . print_r($leaveInfo, true));
    
            echo json_encode($msg);
        }
    
        public function listLeaveHistory()
        {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);
            //log_message('debug', 'obj-->' . print_r($obj, true));
            $staff_id = $obj['staff_id'];
            //  log_message('debug', 'staff_id-->' . print_r($staff_id, true));
    
            $fetchLeaveHistory = $this->app_staff_login->getLeaveHistory($staff_id);
    
            $db_data = [];
            foreach ($fetchLeaveHistory as $info) {
                $info->date_from = date('d-m-Y', strtotime($info->date_from));
                $info->date_to = date('d-m-Y', strtotime($info->date_to));
    
                if ($info->approved_status == 0) {
                    $info->status = 'Pending';
                } elseif ($info->approved_status == 1) {
                    $info->status = 'Approved';
                } else {
                    $info->status = 'Rejected';
                }
    
                $db_data[] = $info;
            }
            log_message('debug', 'db_data-->' . print_r($db_data, true));
    
            $data = json_encode($db_data);
            echo $data;
        }
    
        public function cancellLeave()
        {
            $json = file_get_contents('php://input');
            $obj = json_decode($json, true);
            log_message('debug', 'obj-->' . print_r($obj, true));
    
            $leaveId = $obj['leave_id'];
            log_message('debug', 'leaveId-->' . print_r($leaveId, true));
    
            $leaveInfo = [
                'is_deleted' => 1,
            ];
    
            $cancellLeave = $this->app_staff_login->cancellLeave(
                $leaveId,
                $leaveInfo
            );
    
            if ($cancellLeave > 0) {
                $msg = 'success';
            } else {
                $msg = 'failed';
            }
    
            // log_message('debug', 'leaveInfo is -->' . print_r($leaveInfo, true));
    
            echo json_encode($msg);
        }


   
}
?>