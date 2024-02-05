<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('registration_model');
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
            $this->load->view('users/login');
        }
        else
        {
            redirect('/dashboard');
        }
    }
    
    
    /**
     * This function used to logged in user
     */
    // public function loginMe(){
    //     $this->load->library('form_validation');
        
        
    //     $this->form_validation->set_rules('username', 'Email', 'required|max_length[128]|trim');
    //     $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        
    //     if($this->form_validation->run() == FALSE)
    //     {
    //         $this->index();
    //     }
    //     else
    //     {
    //         $username = strtolower($this->security->xss_clean($this->input->post('username')));
    //         $password = $this->input->post('password');
    //         $result = $this->login_model->loginMe($username, $password);
    //         if(!empty($result))
    //         {
    //             $lastLogin = $this->login_model->lastLoginInfo($result->row_id);
    //             $sessionArray = array('userId'=>$result->row_id, 
    //                                   'name'=>$result->name,
    //                                   'date_of_birth'=>$result->dob,
    //                                   'email'=>$result->email,
    //                                   'registration_number'=>$result->registration_number,
    //                                   'sslc_board_name_id'=>$result->sslc_board_name_id,
    //                                   'lastLogin'=> $lastLogin->createdDtm,
    //                                   'isLoggedIn' => TRUE
    //                             );
    //             $this->session->set_userdata($sessionArray);
    //             unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);

    //             $loginInfo = array("userId"=>$result->row_id, "sessionData" => json_encode($sessionArray), "machineIp"=>$_SERVER['REMOTE_ADDR'], "userAgent"=>getBrowserAgent(), "agentString"=>$this->agent->agent_string(), "platform"=>$this->agent->platform());
    //             $this->login_model->lastLogin($loginInfo);
    //             redirect('/dashboard');
    //         }
    //         else
    //         {
    //             $this->session->set_flashdata('error', 'Sorry! Invalid Login Credentials!');
    //             $this->index();
    //         }
    //     }
    // }


    public function loginMe(){
        $this->load->library('form_validation');
        
        
        $this->form_validation->set_rules('username', 'Mobile', 'required|numeric|min_length[10]');
        // $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
        }
        else
        {
            $username = strtolower($this->security->xss_clean($this->input->post('username')));

            $isExistsMobile =  $this->registration_model->checkMobileNumberExists($username);

            if($isExistsMobile > 0){
                      $result = $this->login_model->loginMe($username);
                            if(!empty($result))
                            {

                                $lastLogin = $this->login_model->lastLoginInfo($result->row_id);
                                $sessionArray = array('userId'=>$result->row_id, 
                                                      'name'=>$isExistsMobile->name,
                                                      'date_of_birth'=>$result->dob,
                                                      'email'=>$result->email,
                                                      'mobile' =>$username,
                                                      'lastLogin'=> $lastLogin->createdDtm,
                                                      'isLoggedIn' => TRUE
                                                );
                                $this->session->set_userdata($sessionArray);
                                unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);
                                $loginInfo = array("userId"=>$result->row_id, "sessionData" => json_encode($sessionArray), "machineIp"=>$_SERVER['REMOTE_ADDR'], "userAgent"=>getBrowserAgent(), "agentString"=>$this->agent->agent_string(), "platform"=>$this->agent->platform());
                                $this->login_model->lastLogin($loginInfo);
                                redirect('/dashboard');
                            }
                            else
                            {
                                $this->session->set_flashdata('error', 'Sorry! Invalid Login Credentials!');
                                $this->index();
                            }
                }else{
                    $studentInfo = array(
                        'mobile' => $username, 
                        'reg_year'=>'2024', 
                        'created_date'=>date('Y-m-d H:i:s'));
                    
                    $results = $this->registration_model->studentRegistrationToDB($studentInfo);
                    if($results > 0){
                         
                                $lastLogin = $this->login_model->lastLoginInfo($results);

                                $sessionArray = array('userId'=>$results, 
                                                      'name'=>$results->name,
                                                      'date_of_birth'=>$results->dob,
                                                      'email'=>$results->email,
                                                      'mobile' =>$username,
                                                      'lastLogin'=> $lastLogin->createdDtm,
                                                      'isLoggedIn' => TRUE
                                                );
                                $this->session->set_userdata($sessionArray);
                                unset($sessionArray['userId'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);
                                $loginInfo = array("userId"=>$results, "sessionData" => json_encode($sessionArray), "machineIp"=>$_SERVER['REMOTE_ADDR'], "userAgent"=>getBrowserAgent(), "agentString"=>$this->agent->agent_string(), "platform"=>$this->agent->platform());
                                $this->login_model->lastLogin($loginInfo);
                                redirect('/dashboard');
                            
                           
                    }else{
                        $this->session->set_flashdata('error', 'Sorry! Invalid Login Credentials!');
                     $this->index();
                    }

                }


        }
    }

    /**
     * This function used to load forgot password view
     */
    public function forgotPassword(){
        $this->session->set_flashdata('error','');
        $this->session->set_flashdata('success','');
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
        $this->session->set_flashdata('error','');
        $this->session->set_flashdata('success','');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('student_id','Email Or Mobile Number','required');
        if($this->form_validation->run() == FALSE)
        {
            $this->forgotPassword();
        }
        else 
        {
            $student_id = $this->input->post('student_id');
            // $dob = $this->input->post('dob');
            $isExist = $this->login_model->isStudentAlreadyRegisterd($student_id);
            if($isExist > 0){
                    $result = $this->login_model->resetPasswordUser($student_id);
                    if(!empty($result)){
                        $data["student_id"] = $student_id;
                        $this->load->view('users/changePassword',$data);
                    }else{
                        $this->session->set_flashdata('error','Email or Mobile Number is Invalid');
                        $this->load->view('users/forgotPassword');
                        //$this->load->view('users/forgotPassword');
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
            $studentInfo = array(
                'password'=>getHashedPassword($password),
                'password_text'=>base64_encode($password), 
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