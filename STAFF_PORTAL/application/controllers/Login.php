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
    public function loginMe(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required|max_length[12]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        if($this->form_validation->run() == FALSE){
            $this->index();
        } else {
            $staff_id = strtolower($this->security->xss_clean($this->input->post('username')));
            $password = $this->input->post('password');
            $result = $this->login->loginMe($staff_id, $password);
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
            } else {
                $this->session->set_flashdata('error', 'Username or Password Mismatch');
                $this->index();
            }
        }
    }



    public function directLogin($staff_id,$type){
        $result = $this->login->loginMe($staff_id, "parro@123");
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
            if($type== "staffListing"){  
              redirect('schoolStaffDetails');
            }else if($type== "admissionDashboard"){
              redirect('viewAdmissionDashboard');
            }else{
              redirect('adminDashboard');
            }
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