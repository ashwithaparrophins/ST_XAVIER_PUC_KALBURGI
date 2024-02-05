<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Registration extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
       $this->load->model('registration_model');
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $this->isLoggedIn();
    }
    
    /**
     * This function is used to load the add new form
     */
    public function studentRegister()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $data['boardInfo'] = $this->registration_model->getBoardName();
            $this->load->view("register/userRegistration", $data);
        }else{
            redirect('login');
        }
    }

     /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $email = $this->input->post("email");
        $result = $this->registration_model->checkEmailExists($email);
        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
    
    /**
     * This function is used to check whether mobile nummber already exist or not
     */
    function checkMobileNumberExists()
    {
        $mobile = $this->input->post("mobile");
        $result = $this->registration_model->checkMobileNumberExists($mobile);
        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }

    function checkRegisterNumberExists()
    {
        $registration_number = $this->input->post("registration_number");
        $result = $this->registration_model->checkRegisterNumberExists($registration_number);
        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function studentRegistrationToDB()
    {
            // $this->load->library('form_validation');
            
            // $this->form_validation->set_rules('name','Full Name','trim|required|max_length[128]|min_length[3]');
            // $this->form_validation->set_rules('email','Email','trim|required|valid_email');
            // $this->form_validation->set_rules('password','Password','required|max_length[30]');
            // $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[30]');
            // $this->form_validation->set_rules('mobile','Mobile Number','required|numeric|min_length[10]');
            // $this->form_validation->set_rules('registration_number','SSLC Registration(Hall Ticket) Number','required|min_length[3]');
            // $this->form_validation->set_rules('sslc_board_name','SSLC Board Name','required');
            // $this->form_validation->set_rules('dob','Date of Birth','required');
           
            // if($this->form_validation->run() == FALSE) {
            //     $this->studentRegister();
            // } else {
                $row_id = $this->input->post('row_id');
                $name = ucwords(strtoupper($this->security->xss_clean($this->input->post('name'))));
                $email = strtolower($this->security->xss_clean($this->input->post('email')));
                $password = $this->input->post('password');
                // $password = "parrosj@123";
                $registration_number = $this->input->post('registration_number');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                $dob = $this->security->xss_clean($this->input->post('dob'));
                $sslc_board_name = $this->security->xss_clean($this->input->post('sslc_board_name'));
                $other_board_name = $this->security->xss_clean($this->input->post('other_board_name'));
                $date_of_birth = date('Y-m-d',strtotime($dob));
                $isExists = $this->registration_model->checkEmailOrMobileExists($email,$mobile);
                $isPresent = $this->registration_model->checkRegisterNumberExists($registration_number);
                
                $board_name = $this->registration_model->getBoardNameByName($sslc_board_name);
                $boardName = $board_name->row_id;
                if($isPresent > 0){
                    $registerNumber = $isPresent->registration_number;
                }else{
                    $registerNumber = "";
                }
                if($isExists > 0){
                    $this->session->set_flashdata('warning', 'Email or Mobile number already registred');
                    redirect('studentRegister');
                } else if($registerNumber == $registration_number){ 
                    $this->session->set_flashdata('warning', 'Entred 10th/SSLC Register number already registred');
                    redirect('studentRegister');
                }else{
                    $studentInfo = array(
                        'email'=>$email, 
                        'password' => getHashedPassword($password), 
                        'password_text'=> base64_encode($password), 
                        'name' => $name,
                        'registration_number' => $registration_number, 
                        'sslc_board_name_id' => $boardName, 
                        'other_board_name' => $other_board_name,
                        'mobile' => $mobile,
                        'reg_year' => 2024,
                        'dob' => $date_of_birth, 
                        'created_by' => $registration_number,
                        'created_date'=>date('Y-m-d H:i:s'));
                    
                    $result = $this->registration_model->studentRegistrationToDB($studentInfo);
                    
                    if($result > 0)
                    {
                        $this->load->view('register/registrationMessage2');
                    }
                    else
                    {
                        $this->session->set_flashdata('error', 'Failed to register');
                    }

                }
                
            // }
    }
  
   
}

?>