<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ApiStaff extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('app_staff_login');
        $this->load->model('login_model');
    }

    public function checkIsExist()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        //  log_message('debug', 'obj-->' . print_r($obj, true));
        $mbl_number = $obj['mblnumber'];
        // log_message('debug', 'mbl_number-->' . print_r($mbl_number, true));

        $isExist = $this->app_staff_login->checkMobNo($mbl_number);
        if ($isExist > 0) {
            $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $appId = 'BVnhKhGtGAc';
            $message = "$otp is your verification code for STAFF APP $appId Regards, Parrophins.";
            $result_sms = $this->sendOtpmsg($mbl_number, $message);

            if (
                $mbl_number != '1234567891' &&
                $mbl_number != '1231231231' &&
                $mbl_number != '1212121212' &&
                $mbl_number != '1313131313'
            ) {
                if ($result_sms == 'success') {
                    $otpUpdate = [
                        'last_otp' => $otp,
                    ];

                    $update = $this->app_staff_login->updateOtp(
                        $otpUpdate,
                        $mbl_number
                    );
                }
            }
            $msg = 'isExist';
        } else {
            $msg = 'failed';
        }

        echo json_encode($msg);
    }

    public function sendOtpmsg($mobile, $msg)
    {

        $message = rawurlencode($msg);

        $data = "username=" . APP_USERNAME_TEXTLOCAL . "&hash=" . APP_HASH_TEXTLOCAL . "&message=" . $message . "&sender=" . APP_SENDERID_TEXTLOCAL . "&numbers=" . $mobile;

        $ch = curl_init('https://api.textlocal.in/send/?');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result_sms = curl_exec($ch); // This is the result from the API

        $json = json_decode($result_sms, true);
        $status = $json['status'];

        curl_close($ch);
        return $status;
    }

    public function checkOtp(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);  
       // log_message('debug','obj--->'.print_r($obj,true));
        $mbl_number = $obj['mobile_number'];
        $otp=$obj['otp'];
    
        
        $isExist = $this->app_staff_login->checkOtp($mbl_number,$otp);

        if($isExist > 0) {  
            $msg='success'; 
        }else { 
            $msg= 'failed'; 
        }     
        //log_message('debug','msg-->'.print_r($msg,true));
    
        echo json_encode($msg);
    }


    public function fetchstaffDetails()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        // log_message('debug', 'obj-->' . print_r($obj, true));
        $mbl_number = $obj['mblnumber'];
        //  log_message('debug', 'mbl_number-->' . print_r($mbl_number, true));

        $fetchDetails = $this->app_staff_login->fetchStaffDetails($mbl_number);

        // log_message(
        //     'debug',
        //     'staffDetails is -->' . print_r($fetchDetails, true)
        // );

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

        $leaveTypes = ['CL', 'ML', 'MARL', 'PL', 'MATL', 'LOP'];

        $leaveCounts = [];
        foreach ($leaveTypes as $type) {
            $leaveCount = $this->app_staff_login->getSumLeaveInfo(
                $staffID,
                $type
            )->total_days_leave;
           // log_message('debug', 'leaveCount' . print_r($leaveCount, true));

            $leaveCounts[$type] = $leaveCount;

            if ($type == 'CL') {
                $casualLeaveEarned =
                    $fetchLeaveManagement[0]->casual_leave_earned;
             //   log_message('debug', '$casualLeaveEarned' . $casualLeaveEarned);

                $casualLeaveUsed = $leaveCount;
                $casualRemaining =
                    $fetchLeaveManagement[0]->casual_leave_earned - $leaveCount;
            } elseif ($type == 'ML') {
                $medicalEraned = $fetchLeaveManagement[0]->sick_leave_earned;
                $medicalUsed = $leaveCount;
                $medicalRemaining =
                    $fetchLeaveManagement[0]->sick_leave_earned - $leaveCount;
            } elseif ($type == 'MARL') {
                $marriageLeaveEarned =
                    $fetchLeaveManagement[0]->marriage_leave_earned;
                $marriageLeaveUsed = $leaveCount;
                $marriageLeaveRemaining =
                    $fetchLeaveManagement[0]->marriage_leave_earned -
                    $leaveCount;
            } elseif ($type == 'PL') {
                $paternityLeaveEarned =
                    $fetchLeaveManagement[0]->paternity_leave_earned;
                $paternityLeaveUsedd = $leaveCount;
                $paternityLeaveRemaining =
                    $fetchLeaveManagement[0]->paternity_leave_earned -
                    $leaveCount;
            } elseif ($type == 'MATL') {
                $maternityLeaveEarned =
                    $fetchLeaveManagement[0]->maternity_leave_earned;
                $maternityLeaveUsed = $leaveCount;
                $maternityLeaveRemaining =
                    $fetchLeaveManagement[0]->maternity_leave_earned -
                    $leaveCount;
            } elseif ($type == 'LOP') {
                $lopUsed = $leaveCount ?? 0;
            }

           // log_message('debug', "$type count of dropdown: $leaveCount");
        }

        // Initialize an array to store formatted leave types
        $formattedLeaveTypes = [];

        // Calculate remaining casual leave
        $casualLeaveRemaining = $casualRemaining ?? 0;

        $sickLeaveRemaining = $medicalRemaining ?? 0;

        $marriageLeaveRemaining = $marriageLeaveRemaining ?? 0;

        $paternityLeaveRemaining = $paternityLeaveRemaining ?? 0;

        $maternityLeaveRemaining = $maternityLeaveRemaining ?? 0;

        // Display casual leave if remaining is not zero
        if ($casualLeaveRemaining != 0) {
            $formattedLeaveTypes[] = (object) [
                'leave_type' =>
                    'Casual Leave(CL)' . ' (' . $casualLeaveRemaining . ')',
                'leave_name' => 'Casual Leave(CL)',
                'leave_short' => 'CL',
                'count' => $casualLeaveRemaining,
            ];
        }

        if ($sickLeaveRemaining != 0) {
            $formattedLeaveTypes[] = (object) [
                'leave_type' =>
                    'Medical Leave(ML)' . ' (' . $sickLeaveRemaining . ')',
                'leave_name' => 'Medical Leave(ML)',
                'leave_short' => 'ML',
                'count' => $sickLeaveRemaining,
            ];
        }

        if ($marriageLeaveRemaining != 0) {
            $formattedLeaveTypes[] = (object) [
                'leave_type' =>
                    'Marriage Leave(ML)' . ' (' . $marriageLeaveRemaining . ')',
                'leave_name' => 'Marriage Leave(ML)',
                'leave_short' => 'MARL',
                'count' => $marriageLeaveRemaining,
            ];
        }

        if ($paternityLeaveRemaining != 0) {
            $formattedLeaveTypes[] = (object) [
                'leave_type' =>
                    'Paternity Leave(PL)' .
                    ' (' .
                    $paternityLeaveRemaining .
                    ')',
                'leave_name' => 'Paternity Leave(PL)',
                'leave_short' => 'PL',
                'count' => $paternityLeaveRemaining,
            ];
        }

        if ($maternityLeaveRemaining != 0) {
            $formattedLeaveTypes[] = (object) [
                'leave_type' =>
                    'Maternity Leave(ML)' .
                    ' (' .
                    $maternityLeaveRemaining .
                    ')',
                'leave_name' => 'Maternity Leave(ML)',
                'leave_short' => 'MATL',
                'count' => $maternityLeaveRemaining,
            ];
        }

        // Display other leave types
        $formattedLeaveTypes[] = (object) [
            'leave_type' => 'Loss Of Pay(LOP)' . ' (' . $lopUsed . ' used )',
            'leave_name' => 'Loss Of Pay(LOP)',
            'leave_short' => 'LOP',
            'count' => '0',
        ];
        // Add more leave types here if needed

        // log_message(
        //     'debug',
        //     'staffDetails is -->' . print_r($formattedLeaveTypes, true)
        // );

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

        $leaveTypes = ['CL', 'ML', 'MARL', 'PL', 'MATL', 'LOP'];

        $leaveCounts = [];
        foreach ($leaveTypes as $type) {
            $leaveCount = $this->app_staff_login->getSumLeaveInfo(
                $staffID,
                $type
            )->total_days_leave;
            //log_message('debug', 'leaveCount' . print_r($leaveCount, true));

            $leaveCounts[$type] = $leaveCount;

            if ($type == 'CL') {
                $casualLeaveEarned =
                    $fetchLeaveManagement[0]->casual_leave_earned;
                //log_message('debug', '$casualLeaveEarned' . $casualLeaveEarned);

                $casualLeaveUsed = $leaveCount;
                $casualRemaining =
                    $fetchLeaveManagement[0]->casual_leave_earned - $leaveCount;
            } elseif ($type == 'ML') {
                $medicalEraned = $fetchLeaveManagement[0]->sick_leave_earned;
                $medicalUsed = $leaveCount;
                $medicalRemaining =
                    $fetchLeaveManagement[0]->sick_leave_earned - $leaveCount;
            } elseif ($type == 'MARL') {
                $marriageLeaveEarned =
                    $fetchLeaveManagement[0]->marriage_leave_earned;
                $marriageLeaveUsed = $leaveCount;
                $marriageLeaveRemaining =
                    $fetchLeaveManagement[0]->marriage_leave_earned -
                    $leaveCount;
            } elseif ($type == 'PL') {
                $paternityLeaveEarned =
                    $fetchLeaveManagement[0]->paternity_leave_earned;
                $paternityLeaveUsedd = $leaveCount;
                $paternityLeaveRemaining =
                    $fetchLeaveManagement[0]->paternity_leave_earned -
                    $leaveCount;
            } elseif ($type == 'MATL') {
                $maternityLeaveEarned =
                    $fetchLeaveManagement[0]->maternity_leave_earned;
                $maternityLeaveUsed = $leaveCount;
                $maternityLeaveRemaining =
                    $fetchLeaveManagement[0]->maternity_leave_earned -
                    $leaveCount;
            } elseif ($type == 'LOP') {
                $lopUsed = $leaveCount ?? 0;
            }

          //  log_message('debug', "$type count of dropdown: $leaveCount");
        }

        // log_message(
        //     'debug',
        //     'fetchLeaveManagement is -->' . print_r($fetchLeaveManagement, true)
        // );

        // Initialize an array to store formatted leave types
        $formattedLeaveTypes = [];

        $casualLeaveRemaining = $casualRemaining ?? 0;

        $sickLeaveRemaining = $medicalRemaining ?? 0;

        $marriageLeaveRemaining = $marriageLeaveRemaining ?? 0;

        $paternityLeaveRemaining = $paternityLeaveRemaining ?? 0;

        $maternityLeaveRemaining = $maternityLeaveRemaining ?? 0;

        // Display casual leave if remaining is not zero
        if ($casualLeaveEarned != 0) {
            $formattedLeaveTypes[] = (object) [
                'leave_type' => 'Casual Leave(CL)',
                'leave_short' => 'CL',
                'earned' => $casualLeaveEarned ?? 0,
                'used' => $casualLeaveUsed ?? 0,
                'remaining' => $casualLeaveRemaining,
            ];
        }

        if ($medicalEraned != 0) {
            $formattedLeaveTypes[] = (object) [
                'leave_type' => 'Medical Leave(ML)',
                'leave_short' => 'ML',
                'earned' => $medicalEraned ?? 0,
                'used' => $medicalUsed ?? 0,
                'remaining' => $sickLeaveRemaining,
            ];
        }

        if ($marriageLeaveEarned != 0) {
            $formattedLeaveTypes[] = (object) [
                'leave_type' => 'Marriage Leave(ML)',
                'leave_short' => 'MARL',
                'earned' => $marriageLeaveEarned ?? 0,
                'used' => $marriageLeaveUsed ?? 0,
                'remaining' => $marriageLeaveRemaining,
            ];
        }

        if ($paternityLeaveEarned != 0) {
            $formattedLeaveTypes[] = (object) [
                'leave_type' => 'Paternity Leave(PL)',
                'leave_short' => 'PL',
                'earned' => $paternityLeaveEarned ?? 0,
                'used' => $paternityLeaveUsedd ?? 0,
                'remaining' => $paternityLeaveRemaining,
            ];
        }

        if ($maternityLeaveEarned != 0) {
            $formattedLeaveTypes[] = (object) [
                'leave_type' => 'Maternity Leave(ML)',
                'leave_short' => 'MATL',
                'earned' => $maternityLeaveEarned ?? 0,
                'used' => $maternityLeaveUsed ?? 0,
                'remaining' => $maternityLeaveRemaining,
            ];
        }

        // Display other leave types
        // if (!empty($fetchLeaveManagement)) {
            $formattedLeaveTypes[] = (object) [
                'leave_type' => 'Loss Of Pay(LOP)',
                'leave_short' => 'LOP',
                'earned' => '0',
                'used' => '0',
                'remaining' => $lopUsed??'0',
            ];
        // } else {
            
       // }
        // Add more leave types here if needed

        // log_message(
        //     'debug',
        //     'staffDetails is -->' . print_r($formattedLeaveTypes, true)
        // );

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
        $leaveName = $obj['leave_name'];
        $staffName = $obj['staff_name'];

      //  log_message('debug', 'leaveName is -->' . print_r($leaveName, true));

        $leaveInfo = [
            'staff_id' => $staff_id,
            'applied_date_time' => date('Y-m-d H:i:s'),
            'date_from' => date('Y-m-d', strtotime($leaveFromDate)),
            'date_to' => date('Y-m-d', strtotime($leaveToDate)),
            'leave_reason' => $leaveReason,
            'total_days_leave' => $totalLeave,
            'leave_type' => $leaveType,
            'created_by' => $staff_id,
            'leave_name' => $leaveName,

            'created_date_time' => date('Y-m-d H:i:s'),
        ];

        $insertLeave = $this->app_staff_login->applyLeaveInsert($leaveInfo);

        if ($insertLeave > 0) {
            $fetchApproversList = $this->app_staff_login->fetchApproverList();

            $fetchMangementStatus = $this->app_staff_login->getManagmentStatus($staff_id);
            //log_message('debug', 'fetchMangementStatus: '.print_r($fetchMangementStatus,true));

            $title = 'Leave Request';

            $body = "$staffName  has requested leave for $totalLeave days";

            if ($fetchMangementStatus[0]->management_view_status == 1) {
                // Make GET request to the API endpoint
                $apiUrl = KJES_LINK;
                $ch = curl_init($apiUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                // Parse JSON response
                $tokens = json_decode($response, true);
            
                // Log tokens
                if ($tokens !== null) {
                    foreach ($tokens as $tokenData) {
                        if (isset($tokenData['token'])) {
                            $token = $tokenData['token'];
                            $this->app_staff_login->sendMessage(
                                $title,
                                $body,
                                $token,
                                ''
                            );
                          //  log_message('debug', 'Token: '.print_r($token,true));
                        }
                    }
                } else {
                   // log_message('error', 'Failed to fetch tokens from the API.');
                }
            }else{

                foreach ($fetchApproversList as $info) {
               

                    $staff_token = $this->app_staff_login->getToken(
                        $info->staff_id
                    );
    
                    $tokenCheck = $staff_token[0]->token;
                    
                    if (!empty($tokenCheck)) {
                        $this->app_staff_login->sendMessage(
                            $title,
                            $body,
                            $tokenCheck,
                            ''
                        );
                    }
                }

            }
                   

            $msg = 'success';
        } else {
            $msg = 'failed';
        }

       // log_message('debug', 'leaveInfo is -->' . print_r($leaveInfo, true));

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
        $leaveName = $_POST['leave_name'];
        $staffName = $_POST['staff_name'];

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
            'leave_name' => $leaveName,
            'medical_certificate' => $targetPath,
        ];

        $insertLeave = $this->app_staff_login->applyLeaveInsert($leaveInfo);

        if ($insertLeave > 0) {
            $fetchApproversList = $this->app_staff_login->fetchApproverList();


            $fetchMangementStatus = $this->app_staff_login->getManagmentStatus($staff_id);
          //  log_message('debug', 'fetchMangementStatus: '.print_r($fetchMangementStatus,true));

            $title = 'Leave Request';

            $body = "$staffName  has requested leave for $totalLeave days";

            if ($fetchMangementStatus[0]->management_view_status == 1) {
                // Make GET request to the API endpoint
                $apiUrl = KJES_LINK;
                $ch = curl_init($apiUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                // Parse JSON response
                $tokens = json_decode($response, true);
            
                // Log tokens
                if ($tokens !== null) {
                    foreach ($tokens as $tokenData) {
                        if (isset($tokenData['token'])) {
                            $token = $tokenData['token'];
                            $this->app_staff_login->sendMessage(
                                $title,
                                $body,
                                $token,
                                ''
                            );
                            //log_message('debug', 'Token: '.print_r($token,true));
                        }
                    }
                } else {
                   // log_message('error', 'Failed to fetch tokens from the API.');
                }
            }else{

                foreach ($fetchApproversList as $info) {
               

                    $staff_token = $this->app_staff_login->getToken(
                        $info->staff_id
                    );
    
                    $tokenCheck = $staff_token[0]->token;
                    
                    if (!empty($tokenCheck)) {
                        $this->app_staff_login->sendMessage(
                            $title,
                            $body,
                            $tokenCheck,
                            ''
                        );
                    }
                }

            }

            // foreach ($fetchApproversList as $info) {
            //     $title = 'Leave Request';

            //     $body = "$staffName  has requested leave for $totalLeave days";

            //     log_message('debug', 'body-->' . print_r($body, true));

            //     $staff_token = $this->app_staff_login->getToken(
            //         $info->staff_id
            //     );

            //     $tokenCheck = $staff_token[0]->token;
            //     log_message(
            //         'debug',
            //         'tokenCheck-->' . print_r($tokenCheck, true)
            //     );

            //     if (!empty($tokenCheck)) {
            //         $this->app_staff_login->sendMessage(
            //             $title,
            //             $body,
            //             $tokenCheck,
            //             ''
            //         );
            //     }
            // }
            $msg = 'success';
        } else {
            $msg = 'failed';
        }

       // log_message('debug', 'leaveInfo is -->' . print_r($leaveInfo, true));

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
       // log_message('debug', 'db_data-->' . print_r($db_data, true));

        $data = json_encode($db_data);
        echo $data;
    }

    public function cancellLeave()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
       // log_message('debug', 'obj-->' . print_r($obj, true));

        $leaveId = $obj['leave_id'];
        $staffName = $obj['name'];
        $totalLeave = $obj['total_leave'];
        $staff_id = $obj['staff_id'];
      //  log_message('debug', 'leaveId-->' . print_r($leaveId, true));

        $leaveInfo = [
            'is_deleted' => 1,
        ];

        $cancellLeave = $this->app_staff_login->cancellLeave(
            $leaveId,
            $leaveInfo
        );

        if ($cancellLeave > 0) {
            $fetchApproversList = $this->app_staff_login->fetchApproverList();

            $fetchMangementStatus = $this->app_staff_login->getManagmentStatus($staff_id);
          //  log_message('debug', 'fetchMangementStatus: '.print_r($fetchMangementStatus,true));

            $title = 'Leave Cancelled';

            $body = "$staffName  has cancelled leave request for $totalLeave days";

            if ($fetchMangementStatus[0]->management_view_status == 1) {
                // Make GET request to the API endpoint
                $apiUrl = KJES_LINK;
                $ch = curl_init($apiUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                // Parse JSON response
                $tokens = json_decode($response, true);
            
                // Log tokens
                if ($tokens !== null) {
                    foreach ($tokens as $tokenData) {
                        if (isset($tokenData['token'])) {
                            $token = $tokenData['token'];
                            $this->app_staff_login->sendMessage(
                                $title,
                                $body,
                                $token,
                                ''
                            );
                           // log_message('debug', 'Token: '.print_r($token,true));
                        }
                    }
                } else {
                   // log_message('error', 'Failed to fetch tokens from the API.');
                }
            }else{

                foreach ($fetchApproversList as $info) {
               

                    $staff_token = $this->app_staff_login->getToken(
                        $info->staff_id
                    );
    
                    $tokenCheck = $staff_token[0]->token;
                    
                    if (!empty($tokenCheck)) {
                        $this->app_staff_login->sendMessage(
                            $title,
                            $body,
                            $tokenCheck,
                            ''
                        );
                    }
                }

            }

            // foreach ($fetchApproversList as $info) {
              

            //     log_message('debug', 'body-->' . print_r($body, true));

                

            //     $staff_token = $this->app_staff_login->getToken(
            //         $info->staff_id
            //     );

            //     $tokenCheck = $staff_token[0]->token;
            //     log_message(
            //         'debug',
            //         'tokenCheck-->' . print_r($tokenCheck, true)
            //     );

            //     if (!empty($tokenCheck)) {
            //         $this->app_staff_login->sendMessage(
            //             $title,
            //             $body,
            //             $tokenCheck,
            //             ''
            //         );
            //     }
            // }
            $msg = 'success';
        } else {
            $msg = 'failed';
        }

        // log_message('debug', 'leaveInfo is -->' . print_r($leaveInfo, true));

        echo json_encode($msg);
    }


    function dashboardMenu()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        $staff_id = $obj['staff_id'];

        $fetchRole = $this->app_staff_login->getStaffRoleId($staff_id);

        $role = $fetchRole[0]->roleId;
        $approvedStatus = $fetchRole[0]->leave_approved_status;

        $dashboardInfo = $this->app_staff_login->dashboardInfo();


        $db_data = [];
        foreach ($dashboardInfo as $info) {
            if ($info->title == 'STUDENTS INFO') {
                if (
                    $role == ROLE_ADMIN ||
                    $role == ROLE_PRINCIPAL ||
                    $role == ROLE_VICE_PRINCIPAL ||
                    $role == ROLE_PRIMARY_ADMINISTRATOR ||
                    $role == ROLE_OFFICE ||
                    $role == ROLE_TEACHING_STAFF
                ) {
                    $db_data[] = $info;
                } else {
                    continue;
                }
            } elseif($info->title == 'STAFF INFO'){
                if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_VICE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_OFFICE){
                    $db_data[] = $info;
                }else{
                    continue;
                }
            }
            elseif (
                $info->title == 'TAKE ATTENDANCE' ||
                $info->title == 'ABSENT INFO' ||
                $info->title == 'CLASS COMPLETED' ||
                $info->title == 'EXAM MARKS' || 
                $info->title == 'STUDY MATERIAL' 
                
            ) {
                if (
                    $role == ROLE_ADMIN ||
                    $role == ROLE_VICE_PRINCIPAL ||
                    $role == ROLE_PRIMARY_ADMINISTRATOR ||
                    $role == ROLE_TEACHING_STAFF ||
                    $role == ROLE_OFFICE ||
                    $role == ROLE_PRINCIPAL
                ) {
                    $db_data[] = $info;
                } else {
                    continue;
                }
            }elseif( $info->title == 'APPROVE LEAVE' && $approvedStatus==0){
                continue;
            }
              else {
                $db_data[] = $info;
            }
        }

        $data = json_encode($db_data);
        echo $data;
    }

    function webLogin($staff_id)
    {
        $result = $this->login_model->loginMe($staff_id, PASSWORD);

        if (!empty($result)) {
            $lastLogin = $this->login_model->lastLoginInfo($result->staff_id);

            $sessionArray = [
                'staff_id' => $result->staff_id,

                'role' => $result->roleId,

                'roleText' => $result->role,

                'mobile' => $result->mobile_one,

                'email' => $result->email,

                'name' => $result->name,

                'type' => $result->type,

                'photo_url' => $result->photo_url,

                'lastLogin' => $lastLogin->createdDtm,

                'dept_id' => $result->department_id,

                'isLoggedIn' => true,
            ];

            $this->session->set_userdata($sessionArray);

            unset(
                $sessionArray['userId'],
                $sessionArray['isLoggedIn'],
                $sessionArray['lastLogin']
            );

            $_SESSION['loggedIn_type'] = 'Mobile';

            $loginInfo = [
                'userId' => $result->staff_id,
                'sessionData' => json_encode($sessionArray),
                'machineIp' => $_SERVER['REMOTE_ADDR'],
                'userAgent' => getBrowserAgent(),
                'agentString' => $this->agent->agent_string(),
                'platform' => $this->agent->platform(),
            ];

            $this->login_model->lastLogin($loginInfo);
        }
    }

    function staffAppStudentDetails()
    {
        $staff_id = $_GET['staffId'];
        $this->webLogin($staff_id);
        redirect('studentDetails');
    }

    function staffAppStaffDetails()
    {
        $staff_id = $_GET['staffId'];
        $this->webLogin($staff_id);
        redirect('staffDetails');
    }

    function staffAppTakeAttendance()
    {
        $staff_id = $_GET['staffId'];
        $this->webLogin($staff_id);
        redirect('getAttendanceDetails');
    }

    function staffAppAbsentInfo()
    {
        $staff_id = $_GET['staffId'];
        $this->webLogin($staff_id);
        redirect('viewAttendanceInfo');
    }

    function staffAppClassComplete()
    {
        $staff_id = $_GET['staffId'];
        $this->webLogin($staff_id);
        redirect('viewClassCompletedInfo');
    }

    function staffAppExamMark()
    {
        $staff_id = $_GET['staffId'];
        $this->webLogin($staff_id);
        redirect('addInternalMark');
    }

    function staffAppStudyMaterial()
    {
        $staff_id = $_GET['staffId'];
        $this->webLogin($staff_id);
        redirect('viewStudyMaterials');
    }

    public function approveLeaveList()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        //log_message('debug', 'obj-->' . print_r($obj, true));
        $staff_id = $obj['staff_id'];
        //  log_message('debug', 'staff_id-->' . print_r($staff_id, true));

        $fetchLeaveHistory = $this->app_staff_login->getApproveLeaveList(
            $staff_id
        );
        //log_message('debug', 'fetchLeaveHistory-->' . print_r($fetchLeaveHistory, true));

        $db_data = [];
        foreach ($fetchLeaveHistory as $info) {
            $info->date_from = date('d-m-Y', strtotime($info->date_from));
            $info->date_to = date('d-m-Y', strtotime($info->date_to));
            $info->applied_date_time = date(
                'd-m-Y',
                strtotime($info->applied_date_time)
            );

            $getStaffDetails = $this->app_staff_login->getStaffName(
                $info->staff_id
            );

            $fetchLeaveManagement = $this->app_staff_login->fetchLeaveMangementInfo(
                $info->staff_id
            );

            $leaveTypes = ['CL', 'ML', 'MARL', 'PL', 'MATL', 'LOP'];

            $leaveCounts = [];
            foreach ($leaveTypes as $type) {
                $leaveCount = $this->app_staff_login->getLeaveUsedSum(
                    $info->staff_id,
                    $type
                )->total_days_leave;
                $leaveCounts[$type] = $leaveCount;

                if ($type == 'CL') {
                    $casualLeaveEarned =
                        $fetchLeaveManagement[0]->casual_leave_earned;
                    // log_message(
                    //     'debug',
                    //     '$casualLeaveEarned' . $casualLeaveEarned
                    // );

                    $casualLeaveUsed = $leaveCount;
                    $casualRemaining =
                        $fetchLeaveManagement[0]->casual_leave_earned -
                        $leaveCount;
                } elseif ($type == 'ML') {
                    $medicalEraned =
                        $fetchLeaveManagement[0]->sick_leave_earned;
                    $medicalUsed = $leaveCount;
                    $medicalRemaining =
                        $fetchLeaveManagement[0]->sick_leave_earned -
                        $leaveCount;
                } elseif ($type == 'MARL') {
                    $marriageLeaveEarned =
                        $fetchLeaveManagement[0]->marriage_leave_earned;
                    $marriageLeaveUsed = $leaveCount;
                    $marriageLeaveRemaining =
                        $fetchLeaveManagement[0]->marriage_leave_earned -
                        $leaveCount;
                } elseif ($type == 'PL') {
                    $paternityLeaveEarned =
                        $fetchLeaveManagement[0]->paternity_leave_earned;
                    $paternityLeaveUsedd = $leaveCount;
                    $paternityLeaveRemaining =
                        $fetchLeaveManagement[0]->paternity_leave_earned -
                        $leaveCount;
                } elseif ($type == 'MATL') {
                    $maternityLeaveEarned =
                        $fetchLeaveManagement[0]->maternity_leave_earned;
                    $maternityLeaveUsed = $leaveCount;
                    $maternityLeaveRemaining =
                        $fetchLeaveManagement[0]->maternity_leave_earned -
                        $leaveCount;
                } elseif ($type == 'LOP') {
                    $lopUsed = $leaveCount;
                }

               // log_message('debug', "$type count: $leaveCount");
            }

            if ($info->approved_status == 0) {
                $info->status = 'Pending';
            } elseif ($info->approved_status == 1) {
                $info->status = 'Approved';
            } else {
                $info->status = 'Rejected';
            }

            $info->staff_name = $getStaffDetails[0]->name;

            //csual leave

            $info->casualLeaveEarned = $casualLeaveEarned ?? 0;
            $info->casualLeaveUsed = $casualLeaveUsed ?? 0;
            $info->casualLeaveRemain = $casualRemaining ?? 0;

            //medical leave

            $info->medicalLeaveEarned = $medicalEraned ?? 0;
            $info->medicalLeaveUsed = $medicalUsed ?? 0;
            $info->medicalLeaveRemain = $medicalRemaining ?? 0;

            //marriage leave

            $info->marriageLeaveEarned = $marriageLeaveEarned ?? 0;
            $info->marriageLeaveUsed = $marriageLeaveUsed ?? 0;
            $info->marriageLeaveRemain = $marriageLeaveRemaining ?? 0;

            //paternity Leave

            $info->paternityLeaveEarned = $paternityLeaveEarned ?? 0;
            $info->paternityLeaveUsed = $paternityLeaveUsedd ?? 0;
            $info->paternityLeaveRemain = $paternityLeaveRemaining ?? 0;

            //maternity leave
            $info->maternityLeaveEarned = $maternityLeaveEarned ?? 0;
            $info->maternityLeaveUsed = $maternityLeaveUsed ?? 0;
            $info->maternityLeaveRemain = $maternityLeaveRemaining ?? 0;

            //LOP
            $info->lopused = $lopUsed ?? '0';

            $db_data[] = $info;
        }
        //log_message('debug', 'db_data-->' . print_r($db_data, true));

        $data = json_encode($db_data);
        echo $data;
    }

    public function approveLeave()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        $staff_id = $obj['staff_id'];
        $leaveStaffId = $obj['leave_staff_id'];
        $leaveRowId = $obj['leave_row_id'];
        $leaveType = $obj['leave_type'];
        $remark = $obj['remark'];

       // log_message('debug', 'leaveName is -->' . print_r($leaveName, true));

        $leaveInfo = [
            'approved_status' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'remark' => $remark,
            'approved_by' => $staff_id,
        ];

        $updateLeave = $this->app_staff_login->approveLeaveUpdate(
            $leaveRowId,
            $leaveInfo
        );

        // $title='Leave Request';

        // $body = "staffname(staffId) has requested the leave";

        // $title='Leave Applied';

        // $body = "successfully leave applied";

        if ($updateLeave > 0) {
            $msg = 'success';

            $fetchLeaveInfo = $this->app_staff_login->fetchGivenLeave(
                $leaveRowId
            );

            $title = 'Leave Approved';
            $body =
                'Your ' .
                $fetchLeaveInfo[0]->total_days_leave .
                ' day leave has been approved.';
            // $body = "Your leave has been approved for ".$fetchLeaveInfo[0]->total_days_leave." days ";
            // log_message(
            //     'debug',
            //     'fetchLeave-->' . print_r($fetchLeaveInfo[0]->staff_id, true)
            // );

            $staff_token = $this->app_staff_login->getToken(
                $fetchLeaveInfo[0]->staff_id
            );

            $tokenCheck = $staff_token[0]->token;
            //log_message('debug', 'tokenCheck-->' . print_r($tokenCheck, true));

            if (!empty($tokenCheck)) {
                $this->app_staff_login->sendMessage(
                    $title,
                    $body,
                    $tokenCheck,
                    ''
                );
            }
        } else {
            $msg = 'failed';
        }

       // log_message('debug', 'leaveInfo is -->' . print_r($leaveInfo, true));

        echo json_encode($msg);
    }

    public function rejectLeave()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        $staff_id = $obj['staff_id'];
        $leaveStaffId = $obj['leave_staff_id'];
        $leaveRowId = $obj['leave_row_id'];
        $leaveType = $obj['leave_type'];
        $remark = $obj['remark'];

        //log_message('debug', 'leaveName is -->' . print_r($leaveName, true));

        $leaveInfo = [
            'approved_status' => 2,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'remark' => $remark,
            'rejected_by' => $staff_id,
        ];

        $updateLeave = $this->app_staff_login->approveLeaveUpdate(
            $leaveRowId,
            $leaveInfo
        );

        if ($updateLeave > 0) {
            $msg = 'success';

            $fetchLeaveInfo = $this->app_staff_login->fetchGivenLeave(
                $leaveRowId
            );
            // log_message(
            //     'debug',
            //     'fetchLeave-->' . print_r($fetchLeaveInfo[0]->staff_id, true)
            // );

            $title = 'Leave Rejected';
            $body =
                'Your ' .
                $fetchLeaveInfo[0]->total_days_leave .
                ' day leave has been rejected.';

            // $body = "Your leave has been rejected for ".$fetchLeaveInfo[0]->total_days_leave." days ";

            $staff_token = $this->app_staff_login->getToken(
                $fetchLeaveInfo[0]->staff_id
            );

            $tokenCheck = $staff_token[0]->token;
            //log_message('debug', 'tokenCheck-->' . print_r($tokenCheck, true));

            if (!empty($tokenCheck)) {
                $this->app_staff_login->sendMessage(
                    $title,
                    $body,
                    $tokenCheck,
                    ''
                );
            }
        } else {
            $msg = 'failed';
        }

       // log_message('debug', 'leaveInfo is -->' . print_r($leaveInfo, true));

        echo json_encode($msg);
    }

    function tokenToDB()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        $staffRowId = $obj['staff_row_id'];
        $token = $obj['token'];
        $staffName = $obj['staff_name'];
        $staffId = $obj['staff_id'];
        $mobileNumber = $obj['mobile_number'];
        $staffRole = $obj['staff_role'];
        $model = $obj['model'];
        $sdk = $obj['sdk'];
        $device_id = $obj['device_id'];
        // log_message("debug","err=".print_r($device_id,true));
        if ($staffId != '' && $device_id != '') {
            $check_device = $this->app_staff_login->checkDeviceExists(
                $staffId,
                $device_id
            );
            if ($check_device > 0) {
                $info = [
                    'token' => $token,
                    'updated_by' => $staffId,
                    'updated_date_time' => date('Y-m-d H:i:s'),
                ];
                $result = $this->app_staff_login->updateToken(
                    $device_id,
                    $info
                );
            } else {
                $info = [
                    'staff_row_id' => $staffRowId,
                    'token' => $token,
                    'staff_name' => $staffName,
                    'staff_id' => $staffId,
                    'mobile_number' => $mobileNumber,
                    'staff_role' => $staffRole,
                    'device_model' => $model,
                    'device_sdk' => $sdk,
                    'device_id' => $device_id,
                    'created_by' => $staffId,
                    'created_date_time' => date('Y-m-d H:i:s'),
                ];
                $result = $this->app_staff_login->addToken($info);
            }
        }
        if ($result > 0) {
            $msg = 'token success';
        } else {
            $msg = 'token failed';
        }
        $jsonmsg = json_encode($msg);
        echo $jsonmsg;
    }

    public function attendance()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $staffId = $obj['staff_id'];

        $fetchTodaysCheckIn = $this->app_staff_login->getAttendance($staffId);

        // Convert time format for each entry
        foreach ($fetchTodaysCheckIn as $entry) {
            if ($entry->punch_time != '00:00:00') {
                $entry->punch_time = date(
                    'g:i A',
                    strtotime($entry->punch_time)
                );
            } else {
                $entry->punch_time = ''; // Set to empty string
            }
            if ($entry->punch_out_time != '00:00:00') {
                $entry->punch_out_time = date(
                    'g:i A',
                    strtotime($entry->punch_out_time)
                );
            } else {
                $entry->punch_out_time = ''; // Set to empty string
            }
        }
//
        echo json_encode($fetchTodaysCheckIn);
    }

    public function attendanceList()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $staffId = $obj['staff_id'];

      //  log_message('debug', 'staffId-->' . print_r($staffId, true));

        $fetchList = $this->app_staff_login->getAttendanceList($staffId);
     //   log_message('debug', 'fetchList-->' . print_r($fetchList, true));

        foreach ($fetchList as $entry) {
            if ($entry->punch_time != '00:00:00') {
                $entry->punch_time = date(
                    'g:i A',
                    strtotime($entry->punch_time)
                );
            } else {
                $entry->punch_time = ''; // Set to empty string
            }
            if ($entry->punch_out_time != '00:00:00') {
                $entry->punch_out_time = date(
                    'g:i A',
                    strtotime($entry->punch_out_time)
                );
            } else {
                $entry->punch_out_time = ''; // Set to empty string
            }
            $entry->punch_date = date('d-m-Y', strtotime($entry->punch_date));
            # code...
        }

        echo json_encode($fetchList);
    }

    public function subjectList()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        //log_message('debug', 'obj-->' . print_r($obj, true));
        $staff_id = $obj['staff_id'];
        //  log_message('debug', 'staff_id-->' . print_r($staff_id, true));

        $fetchAssignedSubjects = $this->app_staff_login->fetchSubjectList($staff_id);
       
      //  log_message('debug', 'fetchAssignedSubjects-->' . print_r($fetchAssignedSubjects, true));

        $data = json_encode($fetchAssignedSubjects);
        echo $data;
    }


    public function deleteToken(){
        $json = file_get_contents('php://input'); 
        $obj = json_decode($json,true);
        $id = $obj['id'];
        $return = $this->app_staff_login->deleteToken($id);

        if($return>0){
            $msg='success';
        }else{
            $msg='failed';
        }

        $data = json_encode($msg);
        echo $data;
    }


    public function checkStaffValid()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
    // log_message('debug', 'obj of check valid-->' . print_r($obj, true));
        $row_id = $obj['row_id'];
        //  log_message('debug', 'mbl_number-->' . print_r($mbl_number, true));

        $fetchDetails = $this->app_staff_login->fecthStaffAllDetails($row_id);

        // log_message(
        //     'debug',
        //     'staffDetails is -->' . print_r($fetchDetails, true)
        // );

        echo json_encode($fetchDetails);
    }

    public function approveAllLeaveList()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        //log_message('debug', 'obj-->' . print_r($obj, true));
        $staff_id = $obj['staff_id'];
        //  log_message('debug', 'staff_id-->' . print_r($staff_id, true));

        $fetchLeaveHistory = $this->app_staff_login->getAllApproveLeaveList(
            $staff_id
        );
       // log_message('debug', 'all fetchLeaveHistory-->' . print_r($fetchLeaveHistory, true));

        $db_data = [];
        foreach ($fetchLeaveHistory as $info) {
            $info->date_from = date('d-m-Y', strtotime($info->date_from));
            $info->date_to = date('d-m-Y', strtotime($info->date_to));
            $info->applied_date_time = date(
                'd-m-Y',
                strtotime($info->applied_date_time)
            );

            $getStaffDetails = $this->app_staff_login->getStaffName(
                $info->staff_id
            );

            $fetchLeaveManagement = $this->app_staff_login->fetchLeaveMangementInfo(
                $info->staff_id
            );

            $leaveTypes = ['CL', 'ML', 'MARL', 'PL', 'MATL', 'LOP'];

            $leaveCounts = [];
            foreach ($leaveTypes as $type) {
                $leaveCount = $this->app_staff_login->getLeaveUsedSum(
                    $info->staff_id,
                    $type
                )->total_days_leave;
                $leaveCounts[$type] = $leaveCount;

                if ($type == 'CL') {
                    $casualLeaveEarned =
                        $fetchLeaveManagement[0]->casual_leave_earned;
                    // log_message(
                    //     'debug',
                    //     '$casualLeaveEarned' . $casualLeaveEarned
                    // );

                    $casualLeaveUsed = $leaveCount;
                    $casualRemaining =
                        $fetchLeaveManagement[0]->casual_leave_earned -
                        $leaveCount;
                } elseif ($type == 'ML') {
                    $medicalEraned =
                        $fetchLeaveManagement[0]->sick_leave_earned;
                    $medicalUsed = $leaveCount;
                    $medicalRemaining =
                        $fetchLeaveManagement[0]->sick_leave_earned -
                        $leaveCount;
                } elseif ($type == 'MARL') {
                    $marriageLeaveEarned =
                        $fetchLeaveManagement[0]->marriage_leave_earned;
                    $marriageLeaveUsed = $leaveCount;
                    $marriageLeaveRemaining =
                        $fetchLeaveManagement[0]->marriage_leave_earned -
                        $leaveCount;
                } elseif ($type == 'PL') {
                    $paternityLeaveEarned =
                        $fetchLeaveManagement[0]->paternity_leave_earned;
                    $paternityLeaveUsedd = $leaveCount;
                    $paternityLeaveRemaining =
                        $fetchLeaveManagement[0]->paternity_leave_earned -
                        $leaveCount;
                } elseif ($type == 'MATL') {
                    $maternityLeaveEarned =
                        $fetchLeaveManagement[0]->maternity_leave_earned;
                    $maternityLeaveUsed = $leaveCount;
                    $maternityLeaveRemaining =
                        $fetchLeaveManagement[0]->maternity_leave_earned -
                        $leaveCount;
                } elseif ($type == 'LOP') {
                    $lopUsed = $leaveCount;
                }

               // log_message('debug', "$type count: $leaveCount");
            }

            if ($info->approved_status == 0) {
                $info->status = 'Pending';
            } elseif ($info->approved_status == 1) {
                $info->status = 'Approved';
            } else {
                $info->status = 'Rejected';
            }

            $info->staff_name = $getStaffDetails[0]->name;

            //csual leave

            $info->casualLeaveEarned = $casualLeaveEarned ?? 0;
            $info->casualLeaveUsed = $casualLeaveUsed ?? 0;
            $info->casualLeaveRemain = $casualRemaining ?? 0;

            //medical leave

            $info->medicalLeaveEarned = $medicalEraned ?? 0;
            $info->medicalLeaveUsed = $medicalUsed ?? 0;
            $info->medicalLeaveRemain = $medicalRemaining ?? 0;

            //marriage leave

            $info->marriageLeaveEarned = $marriageLeaveEarned ?? 0;
            $info->marriageLeaveUsed = $marriageLeaveUsed ?? 0;
            $info->marriageLeaveRemain = $marriageLeaveRemaining ?? 0;

            //paternity Leave

            $info->paternityLeaveEarned = $paternityLeaveEarned ?? 0;
            $info->paternityLeaveUsed = $paternityLeaveUsedd ?? 0;
            $info->paternityLeaveRemain = $paternityLeaveRemaining ?? 0;

            //maternity leave
            $info->maternityLeaveEarned = $maternityLeaveEarned ?? 0;
            $info->maternityLeaveUsed = $maternityLeaveUsed ?? 0;
            $info->maternityLeaveRemain = $maternityLeaveRemaining ?? 0;

            //LOP
            $info->lopused = $lopUsed ?? '0';

            $db_data[] = $info;
        }
      //  log_message('debug', 'db_data-->' . print_r($db_data, true));

        $data = json_encode($db_data);
        echo $data;
    }
}
?>
