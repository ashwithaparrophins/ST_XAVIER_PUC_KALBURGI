<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Support extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct(){
        parent::__construct();
        $this->load->model('support_model');
        $this->isLoggedIn();   
    }

    public function contactUs(){
        $data['grievanceInfo'] = $this->support_model->getGrievanceInfo($this->student_row_id);
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Support';
        $this->loadViews("support/contactUs", $this->global , $data ,NULL);
    }
    
    public function helpGuide(){
        $this->global['pageTitle'] = ''.TAB_TITLE.' : Help Guide';
        $this->loadViews("support/helpGuide", $this->global , NULL ,NULL);
    }

    public function saveContactInfo(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('subject','Subject','trim|required|max_length[120]');
        $this->form_validation->set_rules('message','Message','trim|required|max_length[200]');
        if($this->form_validation->run() == FALSE) {
            redirect('contactUs');
        } else {
            $name = $this->security->xss_clean($this->input->post('name'));
            $subject = $this->security->xss_clean($this->input->post('subject'));
            $message = $this->security->xss_clean($this->input->post('message'));
            
    
                $messageInfo = array(
                    'registered_row_id' => $this->student_row_id,
                    'subject' => $subject,
                    'message' => $message,
                    'year'    => '2024',
                    'created_by' => $this->student_row_id,
                    'created_date_time' => date('Y-m-d H:i:s'));
                $retun_id = $this->support_model->addStudentContactInfo($messageInfo);

            if($retun_id > 0) {
                $this->session->set_flashdata('success', 'Message Sent Successfully');
            } else {
                $this->session->set_flashdata('error', 'Failed to Send Message');
            }
            redirect('contactUs');
        }
    }
}
?>