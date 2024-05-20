<?php

class Dashboard_model extends CI_Model{
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    function isValidApplicant($email,$mobile){
        $this->db->select('application.row_id');
        $this->db->from('tbl_job_application_manager as application');
        $this->db->where('application.email_id',$email);
        $this->db->or_where('application.mobile_number',$mobile);
        $this->db->where('application.is_deleted',0);
        if($this->db->get()->num_rows() > 0){
            return false;
        }else{
            return true;
        }
    }
    function addApplicant($details){
        print_r($details);
        $this->db->trans_start();
        $this->db->insert('tbl_job_application_manager', $details);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function getPostName(){
        $this->db->from('tbl_job_post_info as job');
        $this->db->where('job.is_deleted',0);
        $this->db->where('job.is_active',0);
        $query = $this->db->get();
        return $query->result();
   }

}