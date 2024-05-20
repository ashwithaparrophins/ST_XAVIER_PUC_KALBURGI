<?php
class Dashboard extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->library('session');  
        $this->load->helper('url');   
        $this->load->model('dashboard_model');
    }
    public function index(){
        $data['getPostName'] = $this->dashboard_model->getPostName(); 
        $this->load->view('dashboard', $data);        
    }
    public function applyNow(){
        $email_id = $this->input->post('email_id');
        $mobile_no = $this->input->post('mobile_number');
        if($this->dashboard_model->isValidApplicant($email_id,$mobile_no)){
            $uploadedProfilePath = "";
            $uploadedResumePath = "";
            if($_FILES['profilePic']['name'] != ""){
                $destinationPath = 'upload/profile/';            
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }            
                $config1['upload_path'] = $destinationPath;
                $config1['allowed_types'] = 'png|jpg|jpeg';
                $config1['max_size'] = 1024;
                $uniquFileName = uniqid("SJPUC-").$_FILES['profilePic']['name'];
                $config1['file_name'] = $uniquFileName;
                $this->load->library('upload',$config1,'profile_upload');  
                if($this->profile_upload->do_upload('profilePic')){
                    $data = array('upload_data' => $this->profile_upload->data());
                    $uploadedProfilePath = $destinationPath.$data['upload_data']['orig_name'];
                }else{
                    $this->session->set_flashdata('error',$this->profile_upload->display_errors());
                    redirect('dashboard');
                }
            }else{
                $this->session->set_flashdata('error','Profile Pic Required');
                redirect('dashboard');
            }
            if($_FILES['resumeFile']['name'] != ""){
                $destinationPath = 'upload/resume/';            
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }            
                $config2['upload_path'] = $destinationPath;
                $config2['allowed_types'] = 'pdf|doc|docx';
                $config2['max_size'] = 2048;
                $uniquFileName = uniqid("SJPUC-Resume").$_FILES['resumeFile']['name'];
                $config2['file_name'] = $uniquFileName; 
                $this->load->library('upload',$config2,'resume_upload'); 
                if($this->resume_upload->do_upload('resumeFile')){
                    $data = array('upload_data' => $this->resume_upload->data());
                    $uploadedResumePath = $destinationPath.$data['upload_data']['orig_name'];
                }else{
                    $this->session->set_flashdata('error',$this->resume_upload->display_errors());
                    redirect('dashboard');
                }
            }else{
                $this->session->set_flashdata('error','Resume Required');
                redirect('dashboard');
            }
            if($uploadedProfilePath != "" && $uploadedResumePath != ""){
                $applicantDetails = array(
                    'subject' => $this->input->post('subject'),
                    'fullname' => $this->input->post('fullname'),
                    'qualification' => $this->input->post('qualification'),
                    'sslc_percent' => $this->input->post('sslc_percent'),
                    'puc_percent' => $this->input->post('puc_percent'),
                    'ug_percent' => $this->input->post('ug_percent'),
                    'pg_percent' => $this->input->post('pg_percent'),
                    'bed_percent' => $this->input->post('bed_percent'),
                    'job_post_id' => $this->input->post('job_post'),
                    'mobile_number' => $mobile_no,
                    'email_id' => $email_id,
                    'religion' => $this->input->post('religion'),
                    'cast' => $this->input->post('cast'),
                    'dob' => date('Y-m-d',strtotime($this->input->post('dob'))),
                    'marital_status' => $this->input->post('marital_status'),
                    'work_experience' => $this->input->post('work_experience'),
                    'expected_salary' => $this->input->post('expected_salary'),
                    'blood_group' => $this->input->post('blood_group'),
                    'mother_tongue' => $this->input->post('mother_tongue'),
                    'languages_known' => $this->input->post('hidden_languages_known'),
                    'additional_qualification' => $this->input->post('additional_qualification'),
                    'hobbies_interests' => $this->input->post('hobbies_interests'),
                    'address' => $this->input->post('address'),
                    'profile_picture' => $uploadedProfilePath,
                    'resume' => $uploadedResumePath,
                    'created_date_time' => mdate("%Y-%m-%d %h:%i:%s"),
                );
                if($this->dashboard_model->addApplicant($applicantDetails) > 0){
                    $this->session->set_flashdata('success',"Success");
                    redirect('dashboard');
                }else{
                    $this->session->set_flashdata('error',"Something went wrong..!");
                    redirect('dashboard');
                }
            }else{
                $this->session->set_flashdata('error',"Something went wrong..!");
                redirect('dashboard');
            }
        }else{
            $this->session->set_flashdata('error','Your Email/Mobile Already Registered');
            redirect('dashboard');
        }
    }
}