<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model','login');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $this->isLoggedIn();
    }
    
    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn(){
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('login');
        }
        else
        {
            redirect('dashboard');
        }
    }
    
    public function loginFaculty(){
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('login');
        }
        else
        {
            redirect('dashboard');
        }
    }
    /**
     * This function used to logged in user
     */
    // public function loginMe(){
    //     $this->load->library('form_validation');
    //     $this->form_validation->set_rules('username', 'Username', 'required|max_length[12]|trim');
    //     $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
    //     if($this->form_validation->run() == FALSE){
    //         $this->index();
    //     } else {
    //         $staff_id = strtolower($this->security->xss_clean($this->input->post('username')));
    //         $password = $this->input->post('password');
    //         $result = $this->login->loginMe($staff_id, $password);
    //         if(!empty($result))
    //         {
    //             $lastLogin = $this->login->lastLoginInfo($result->staff_id);
    //             $sessionArray = array('staff_id'=>$result->staff_id,                    
    //                                     'role'=>$result->roleId,
    //                                     'roleText'=>$result->role,
    //                                     'mobile'=>$result->mobile_one,
    //                                     'email'=>$result->email,
    //                                     'name'=>$result->name,
    //                                      'type'=>$result->type,
    //                                     'photo_url'=>$result->photo_url,
    //                                     'lastLogin'=> $lastLogin->createdDtm,
    //                                     'dept_id'=>$result->department_id,
    //                                     'isLoggedIn' => TRUE
    //                             );

    //             $this->session->set_userdata($sessionArray);
    //             unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);
    //             $loginInfo = array("userId"=>$result->staff_id, "sessionData" => json_encode($sessionArray), "machineIp"=>$_SERVER['REMOTE_ADDR'], "userAgent"=>getBrowserAgent(), "agentString"=>$this->agent->agent_string(), "platform"=>$this->agent->platform());
    //             $this->login->lastLogin($loginInfo);
    //             if($result->roleId == ROLE_SUPER_ADMIN){
    //                 redirect('adminDashboard');
    //                 }else{
    //                 redirect('dashboard');
    //                 }
    //         } else {
    //             $this->session->set_flashdata('error', 'Username or Password Mismatch');
    //             $this->index();
    //         }
    //     }
    // }

    public function loginMe(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required|max_length[10]|trim');
        if($this->form_validation->run() == FALSE){
            $this->index();
        } else {
            $this->session->unset_userdata('error');
            $username = strtolower($this->security->xss_clean($this->input->post('username')));
            $isExist = $this->login->isStaffUsernameExists($username);
            if($isExist > 0){
                // if($isExist->role == ROLE_PRIMARY_ADMINISTRATOR && $isExist->staff_id != '123456'){
                //     $principal_role = ROLE_PRINCIPAL;
                //     $staffInfo = $this->login->getStaffInfoByRoleId($principal_role);
                //     $mobile_one = $staffInfo->mobile_one;
                // }else{
                    $mobile_one = $username;
                // }
            $this->session->unset_userdata('error');
                if($username!='1234567891' && $username!='1231231231' && $username!='1212121212'  && $username!='1313131313'){

                    $otp = rand(1000, 9999); // Generate a 4-digit OTP code
                    $message = "Your OTP is: $otp . Use it to verify your identity. Do not share this code with anyone. Regards, Parrophins.";
                  
                 $result_sms = $this->sendOtpmsg($mobile_one, $message);
                    //  $result_sms ='success';
                    if($result_sms=='success'){
                        $otpUpdate = array(
                            'last_otp'=>$otp,
                        );
                        $update = $this->login->updateStaffInfo($isExist->row_id,$otpUpdate);
                        $lastLogin = $this->login->lastLoginInfo($isExist->staff_id);
                        $otp_timestamp = time();
                        $this->session->set_userdata('otp_timestamp', $otp_timestamp);
                    }else{
                        $this->session->set_flashdata('error', 'Mobile No. is Invalid');
                        $this->index();
                    }
                    $isLoggedIn = $this->session->userdata('isLoggedIn');
                    $this->session->set_userdata('mobile_number', $username);
                        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
                        {
                            $data["username"] = $mobile_one;
                            $data["username_entered"] = $username;
                            $this->load->view('users/verifyOtp',$data);
                        }
                        else
                        {
                            redirect('users/login');
                        }
                    // redirect('dashboard');
                } 
                // else {
                //     $this->session->set_flashdata('error', 'Username or Password Mismatch');
                //     $this->index();
                // }
            }else{
                $this->session->set_flashdata('error', 'Mobile No. is not Registered');
                $this->index();
            }
        }
    }

    public function getOtp(){
        $this->load->library('form_validation');
        // if($this->isAdmin() == TRUE){
        //     $this->loadThis();
        // }else{
            
        $mbl_number = strtolower($this->security->xss_clean($this->input->post('username')));
        $isExist = $this->login->isStaffUsernameExists($mbl_number);
        // if($isExist->role == ROLE_PRIMARY_ADMINISTRATOR && $isExist->staff_id != '123456'){
        //     $principal_role = ROLE_PRINCIPAL;
        //     $staffInfo = $this->login->getStaffInfoByRoleId($principal_role);
        //     $mobile_one = $staffInfo->mobile_one;
        // }else{
            $mobile_one = $mbl_number;
        // }
        $otp = rand(1000, 9999); // Generate a 4-digit OTP code

        $message = "Your OTP is: $otp . Use it to verify your identity. Do not share this code with anyone. Regards, Parrophins.";
       $result_sms = $this->sendOtpmsg($mobile_one, $message);


        //  $result_sms ='success';
           if($mbl_number!='1234567891' && $mbl_number!='1231231231' && $mbl_number!='1212121212'  && $mbl_number!='1313131313'){
                if($result_sms == 'success'){
                    $otpUpdate = array(
                        'last_otp'=>$otp,
                        "is_deleted"=>0
                    );  
                    
                    if($isExist > 0) { 
                        $update = $this->login->updateStaffInfo($isExist->row_id,$otpUpdate);

                    }                                
                }
           }
           header('Content-type: text/plain'); 
           header('Content-type: application/json'); 
           echo json_encode($return_id);
           exit(0);                
        // }          
    }

    function checkStaffOtp(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('otp_value','OTP value','required|max_length[6]');      
        if($this->form_validation->run() == FALSE) {
            $this->index();
        }
        else {
         $this->session->unset_userdata('error');
            $otp_value = $this->input->post('otp_value');
            $data["username"] = $mobile_number = $this->session->userdata('mobile_number');
            $result = $this->login->checkOtpIsExist($mobile_number, $otp_value);
            if(!empty($result))
            {
                $lastLogin = $this->login->lastLoginInfo($result->staff_id);
                $sessionArray = array('staff_id'=>$result->staff_id,                    
                                        'role'=>$result->roleId,
                                        'roleText'=>$result->role,
                                        'mobile'=>$result->mobile_one,
                                        'email'=>$result->email,
                                        'name'=>$result->name,
                                        'type'=>$result->type,
                                        'photo_url'=>$result->photo_url,
                                        'lastLogin'=> $lastLogin->createdDtm,
                                        'dept_id'=>$result->department_id,
                                        'isLoggedIn' => TRUE
                                );
                $this->session->set_userdata($sessionArray);
                unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);
                $loginInfo = array("userId"=>$result->staff_id, "sessionData" => json_encode($sessionArray), "machineIp"=>$_SERVER['REMOTE_ADDR'], "userAgent"=>getBrowserAgent(), "agentString"=>$this->agent->agent_string(), "platform"=>$this->agent->platform());
                $this->login->lastLogin($loginInfo);
                if($result->roleId == ROLE_SUPER_ADMIN){
                    redirect('adminDashboard');
                    }else{
                    redirect('dashboard');
                    }
            }else {
               $this->session->set_flashdata('error', 'Invalid OTP - Please try again');
                $this->load->view('users/verifyOtp',$data);
                
            }
           
        }
    }
   

    public function sendOtpmsg($mobile, $msg){
        $message = rawurlencode($msg);
        $data = "username=" . USERNAME . "&hash=" . HASH . "&message=" . $message . "&sender=" . SENDERID . "&numbers=" . $mobile;
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


    public function directLogin($staff_id,$type){
        $result = $this->login->loginMe($staff_id, PASSWORD);
        if(!empty($result)){
            $lastLogin = $this->login->lastLoginInfo($result->staff_id);
            $sessionArray = array('staff_id'=>$result->staff_id,                    
            'role'=>$result->roleId,
            'roleText'=>$result->role,
            'mobile'=>$result->mobile_one,
            'email'=>$result->email,
            'name'=>$result->name,
             'type'=>$result->type,
            'photo_url'=>$result->photo_url,
            'lastLogin'=> $lastLogin->createdDtm,
            'dept_id'=>$result->department_id,
            'isLoggedIn' => TRUE
            );
            $this->session->set_userdata($sessionArray);
            unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);
            $loginInfo = array("userId"=>$result->staff_id, "sessionData" => json_encode($sessionArray), "machineIp"=>$_SERVER['REMOTE_ADDR'], "userAgent"=>getBrowserAgent(), "agentString"=>$this->agent->agent_string(), "platform"=>$this->agent->platform());
            $this->login->lastLogin($loginInfo); 
            // if($type== "staffListing"){  
            //   redirect('schoolStaffDetails');
            // }else if($type== "admissionDashboard"){
            //   redirect('viewAdmissionDashboard');
            // }else{
              redirect('adminDashboard');
            // }
        } else {
            $this->session->set_flashdata('error', 'Username or Password Mismatch');
            $this->index();
        }
    }



    /**
     * This function used to load forgot password view
     */
    public function forgotPassword(){
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('users/forgotPassword');
        }
        else
        {
            redirect('users/login');
        }
    }
    
    /**
     * This function used to generate reset password request link
     */
    function resetPasswordUser(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('student_id','Student ID','required|max_length[30]');
        $this->form_validation->set_rules('dob','Date of Birth','trim|required');
        if($this->form_validation->run() == FALSE)
        {
            $this->forgotPassword();
        }
        else 
        {
            $student_id = $this->input->post('student_id');
            $dob = $this->input->post('dob');
            $isExist = $this->login_model->isStudentAlreadyRegisterd($student_id);
            if($isExist > 0){
                $dob_from_db = str_replace('/', '-', $dob);
                if((date('Y-m-d',strtotime($dob_from_db))) == (date('Y-m-d',strtotime($dob)))){
                    $result = $this->login_model->resetPasswordUser($student_id,date('Y-m-d',strtotime($dob)));
                    if(!empty($result)){
                        $data["student_id"] = $student_id;
                        $this->load->view('users/changePassword',$data);
                    }else{
                        $this->session->set_flashdata('error','Date of Birth or Student Id is Invalid');
                        $this->load->view('users/forgotPassword');
                        //$this->load->view('users/forgotPassword');
                    }
                }else{
                    $this->session->set_flashdata('error','Date of Birth is Invalid');
                    $this->load->view('users/forgotPassword');
                }
            }else{
                $this->session->set_flashdata('error', $student_id .' is Not Registered.');
                $this->load->view('users/forgotPassword');
            }
        }
    }

    /**
     * This function used to reset the password 
     */
    function resetPasswordConfirmUser(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password','Password','required|min_length[6]');
        $this->form_validation->set_rules('cpassword','Confirm Password','required|matches[password]|min_length[6]');
        
        if($this->form_validation->run() == FALSE) {
            $this->forgotPassword();
        }
        else {
            $student_id = $this->input->post('student_id');
            $password = $this->input->post('password');
            $studentInfo = array('password'=>getHashedPassword($password),
            'updated_by'=>$student_id,'updatedDtm'=>date('Y-m-d H:i:s'));
           
            $result = $this->login_model->resetPasswordConfirmUser($studentInfo,$student_id);
            if($result > 0)
            {
                $this->session->set_flashdata('success', 'Password updated successfully');
                $this->load->view('users/login');
            }
            else
            {
                $this->session->set_flashdata('error', 'Password Mismatch');
            }
        }
    }
}
    
?>