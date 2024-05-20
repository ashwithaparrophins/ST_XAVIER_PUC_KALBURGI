<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Jobportal_model extends CI_Model{
    function applicantListing($filters=array()){
        $this->db->select('applicant.row_id, applicant.subject, applicant.fullname, applicant.mobile_number,job.job_post, applicant.resume');
        $this->db->select('applicant.qualification, applicant.work_experience, applicant.bed_percent,applicant.created_date_time');
        $this->db->from('tbl_job_application_manager as applicant');
        $this->db->join('tbl_job_post_info as job','job.row_id = applicant.job_post_id','left');
        $this->db->where('applicant.is_deleted',0);
        $this->db->where('applicant.approved_status',0);

        if(!empty($filters['subject'])){
            $this->db->like('applicant.subject', $filters['subject']);
        }
        if(!empty($filters['applicant_name'])){
            $this->db->like('applicant.fullname', $filters['applicant_name']);
        }
        if(!empty($filters['mobile_number'])){
            $this->db->like('applicant.mobile_number', $filters['mobile_number'], 'after');
        }
        if(!empty($filters['qualification'])){
            $this->db->like('applicant.qualification', $filters['qualification']);
        }
        if(!empty($filters['work_experience'])){
            $this->db->like('applicant.work_experience', $filters['work_experience']);
        }
        if(!empty($filters['bed_percent'])){
            $this->db->like('applicant.bed_percent', $filters['bed_percent'], 'after'); 
        }
        if(!empty($filters['job_post'])){
            $this->db->like('job.job_post', $filters['job_post'], 'after'); 
        }
        if (!empty($filters['applied_date'])) {
            $appliedDate = date('d-m-Y', strtotime($filters['applied_date']));
            $this->db->like('DATE_FORMAT(applicant.created_date_time, "%d-%m-%Y")', $appliedDate);
        }  
        if (!empty($filters['date_from_filter']) && !empty($filters['date_to_filter'])) {
            $dateFrom = date('Y-m-d', strtotime($filters['date_from_filter']));
            $dateTo = date('Y-m-d', strtotime($filters['date_to_filter']));
            
            // Filter between one month
            $this->db->where("DATE_FORMAT(applicant.created_date_time, '%Y-%m-%d') BETWEEN '$dateFrom' AND '$dateTo'");
        }
        
        $this->db->order_by('row_id',"DESC");
        return $this->db->get()->result_object();
    }
    function applicantListingCount(){
        $this->db->select('applicant.row_id, applicant.subject, applicant.fullname, applicant.mobile_number, applicant.resume');
        $this->db->select('applicant.qualification, applicant.work_experience, applicant.bed_percent,applicant.created_date_time');
        $this->db->from('tbl_job_application_manager as applicant');
        $this->db->where('applicant.is_deleted',0);
        $this->db->where('applicant.approved_status',0);
        return $this->db->get()->num_rows();
    }

    function getPostName(){
        $this->db->from('tbl_job_post_info as job');
        $this->db->where('job.is_deleted',0);
        $this->db->where('job.is_active',0);
        $query = $this->db->get();
        return $query->result();
   }
    function getApplicantInfoByID($apcnt_id){
        $this->db->select('applicant.row_id,applicant.subject,applicant.fullname,applicant.qualification,applicant.sslc_percent,applicant.puc_percent,
        applicant.ug_percent,applicant.pg_percent,applicant.bed_percent,applicant.mobile_number,applicant.email_id,applicant.religion,applicant.cast,
        applicant.dob,applicant.marital_status,applicant.work_experience,applicant.expected_salary,applicant.blood_group,applicant.mother_tongue,applicant.languages_known,
        applicant.additional_qualification,applicant.hobbies_interests,applicant.address,applicant.profile_picture,applicant.resume,applicant.status,
        applicant.role,applicant.temp_address,applicant.passout_year,applicant.approved_status,applicant.comments,applicant.shortlisted_status,job.job_post');
        $this->db->from('tbl_job_application_manager as applicant');
        $this->db->join('tbl_job_post_info as job','job.row_id = applicant.job_post_id','left');
        $this->db->where('applicant.row_id',$apcnt_id);
        $this->db->where('applicant.is_deleted',0);
        return $this->db->get()->row();
    }
    function deleteApplicant($rowID,$details){
        $this->db->where('applicant.row_id', $rowID);
        $this->db->update("tbl_job_application_manager as applicant", $details);
        return $this->db->affected_rows();
    }

    public function updateApprovedStatus($applicationInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_job_application_manager', $applicationInfo);
        return TRUE;
    }

    function approvedapplicantionListing($filters=array()){
        $this->db->select('applicant.row_id, applicant.subject, applicant.fullname, applicant.mobile_number,job.job_post, applicant.resume');
        $this->db->select('applicant.qualification, applicant.work_experience, applicant.bed_percent,applicant.created_date_time');
        $this->db->from('tbl_job_application_manager as applicant');
        $this->db->join('tbl_job_post_info as job','job.row_id = applicant.job_post_id','left');
        $this->db->where('applicant.is_deleted',0);
        $this->db->where('applicant.approved_status',1);
        $this->db->where('applicant.shortlisted_status',0);

        if(!empty($filters['subject'])){
            $this->db->like('applicant.subject', $filters['subject']);
        }
        if(!empty($filters['applicant_name'])){
            $this->db->like('applicant.fullname', $filters['applicant_name']);
        }
        if(!empty($filters['mobile_number'])){
            $this->db->like('applicant.mobile_number', $filters['mobile_number'], 'after');
        }
        if(!empty($filters['qualification'])){
            $this->db->like('applicant.qualification', $filters['qualification']);
        }
        if(!empty($filters['work_experience'])){
            $this->db->like('applicant.work_experience', $filters['work_experience']);
        }
        if(!empty($filters['bed_percent'])){
            $this->db->like('applicant.bed_percent', $filters['bed_percent'], 'after'); 
        }
        if(!empty($filters['job_post'])){
            $this->db->like('job.job_post', $filters['job_post'], 'after'); 
        }
        if (!empty($filters['applied_date'])) {
            $appliedDate = date('d-m-Y', strtotime($filters['applied_date']));
            $this->db->like('DATE_FORMAT(applicant.created_date_time, "%d-%m-%Y")', $appliedDate);
        }  
        if (!empty($filters['date_from_filter']) && !empty($filters['date_to_filter'])) {
            $dateFrom = date('Y-m-d', strtotime($filters['date_from_filter']));
            $dateTo = date('Y-m-d', strtotime($filters['date_to_filter']));
            
            // Filter between one month
            $this->db->where("DATE_FORMAT(applicant.created_date_time, '%Y-%m-%d') BETWEEN '$dateFrom' AND '$dateTo'");
        }
        
        $this->db->order_by('row_id',"DESC");
        return $this->db->get()->result_object();
    }

    function approvedapplicantionListingCount(){
        $this->db->select('applicant.row_id, applicant.subject, applicant.fullname, applicant.mobile_number, applicant.resume');
        $this->db->select('applicant.qualification, applicant.work_experience, applicant.bed_percent,applicant.created_date_time');
        $this->db->from('tbl_job_application_manager as applicant');
        $this->db->where('applicant.is_deleted',0);
        $this->db->where('applicant.approved_status',1);
        $this->db->where('applicant.shortlisted_status',0);
        return $this->db->get()->num_rows();
    }

    function shortlistedapplicantionListing($filters=array()){
        $this->db->select('applicant.row_id, applicant.subject, applicant.fullname, applicant.mobile_number,job.job_post, applicant.resume');
        $this->db->select('applicant.qualification, applicant.work_experience, applicant.bed_percent,applicant.created_date_time');
        $this->db->from('tbl_job_application_manager as applicant');
        $this->db->join('tbl_job_post_info as job','job.row_id = applicant.job_post_id','left');
        $this->db->where('applicant.is_deleted',0);
        $this->db->where('applicant.shortlisted_status',1);

        if(!empty($filters['subject'])){
            $this->db->like('applicant.subject', $filters['subject']);
        }
        if(!empty($filters['applicant_name'])){
            $this->db->like('applicant.fullname', $filters['applicant_name']);
        }
        if(!empty($filters['mobile_number'])){
            $this->db->like('applicant.mobile_number', $filters['mobile_number'], 'after');
        }
        if(!empty($filters['qualification'])){
            $this->db->like('applicant.qualification', $filters['qualification']);
        }
        if(!empty($filters['work_experience'])){
            $this->db->like('applicant.work_experience', $filters['work_experience']);
        }
        if(!empty($filters['bed_percent'])){
            $this->db->like('applicant.bed_percent', $filters['bed_percent'], 'after'); 
        }
        if(!empty($filters['job_post'])){
            $this->db->like('job.job_post', $filters['job_post'], 'after'); 
        }
        if (!empty($filters['applied_date'])) {
            $appliedDate = date('d-m-Y', strtotime($filters['applied_date']));
            $this->db->like('DATE_FORMAT(applicant.created_date_time, "%d-%m-%Y")', $appliedDate);
        }  
        if (!empty($filters['date_from_filter']) && !empty($filters['date_to_filter'])) {
            $dateFrom = date('Y-m-d', strtotime($filters['date_from_filter']));
            $dateTo = date('Y-m-d', strtotime($filters['date_to_filter']));
            
            // Filter between one month
            $this->db->where("DATE_FORMAT(applicant.created_date_time, '%Y-%m-%d') BETWEEN '$dateFrom' AND '$dateTo'");
        }
        
        $this->db->order_by('row_id',"DESC");
        return $this->db->get()->result_object();
    }

    function shortlistedapplicantionListingCount(){
        $this->db->select('applicant.row_id, applicant.subject, applicant.fullname, applicant.mobile_number, applicant.resume');
        $this->db->select('applicant.qualification, applicant.work_experience, applicant.bed_percent,applicant.created_date_time');
        $this->db->from('tbl_job_application_manager as applicant');
        $this->db->where('applicant.is_deleted',0);
        $this->db->where('applicant.shortlisted_status',1);
        return $this->db->get()->num_rows();
    }

    function rejectApplicantionListing($filters=array()){
        $this->db->select('applicant.row_id, applicant.subject, applicant.fullname, applicant.mobile_number,job.job_post, applicant.resume');
        $this->db->select('applicant.qualification, applicant.work_experience, applicant.bed_percent,applicant.created_date_time');
        $this->db->from('tbl_job_application_manager as applicant');
        $this->db->join('tbl_job_post_info as job','job.row_id = applicant.job_post_id','left');
        $this->db->where('applicant.is_deleted',0);
        $this->db->where('applicant.approved_status',2);

        if(!empty($filters['subject'])){
            $this->db->like('applicant.subject', $filters['subject']);
        }
        if(!empty($filters['applicant_name'])){
            $this->db->like('applicant.fullname', $filters['applicant_name']);
        }
        if(!empty($filters['mobile_number'])){
            $this->db->like('applicant.mobile_number', $filters['mobile_number'], 'after');
        }
        if(!empty($filters['qualification'])){
            $this->db->like('applicant.qualification', $filters['qualification']);
        }
        if(!empty($filters['work_experience'])){
            $this->db->like('applicant.work_experience', $filters['work_experience']);
        }
        if(!empty($filters['bed_percent'])){
            $this->db->like('applicant.bed_percent', $filters['bed_percent'], 'after'); 
        }
        if(!empty($filters['job_post'])){
            $this->db->like('job.job_post', $filters['job_post'], 'after'); 
        }
        if (!empty($filters['applied_date'])) {
            $appliedDate = date('d-m-Y', strtotime($filters['applied_date']));
            $this->db->like('DATE_FORMAT(applicant.created_date_time, "%d-%m-%Y")', $appliedDate);
        }  
        if (!empty($filters['date_from_filter']) && !empty($filters['date_to_filter'])) {
            $dateFrom = date('Y-m-d', strtotime($filters['date_from_filter']));
            $dateTo = date('Y-m-d', strtotime($filters['date_to_filter']));
            
            // Filter between one month
            $this->db->where("DATE_FORMAT(applicant.created_date_time, '%Y-%m-%d') BETWEEN '$dateFrom' AND '$dateTo'");
        }
        
        $this->db->order_by('row_id',"DESC");
        return $this->db->get()->result_object();
    }

    function rejectApplicantionListingCount(){
        $this->db->select('applicant.row_id, applicant.subject, applicant.fullname, applicant.mobile_number, applicant.resume');
        $this->db->select('applicant.qualification, applicant.work_experience, applicant.bed_percent,applicant.created_date_time');
        $this->db->from('tbl_job_application_manager as applicant');
        $this->db->where('applicant.is_deleted',0);
        $this->db->where('applicant.approved_status',2);
        return $this->db->get()->num_rows();
    }
    public function getAllJobPostInfo() {

        $this->db->from('tbl_job_post_info as post');

        $this->db->where('post.is_deleted', 0);

        $query = $this->db->get();

        return $query->result();

    }

    public function addJobPost($jobPostInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_job_post_info', $jobPostInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function updateJobPostInfo($jobPostInfo, $row_id) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_job_post_info', $jobPostInfo);
        return TRUE;
    }

    function checkJobPostExists($job_post) {
        $this->db->from('tbl_job_post_info as job');
        $this->db->where('job.job_post', $job_post);
        $this->db->where('job.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
}