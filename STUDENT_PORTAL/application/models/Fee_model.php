<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Fee_model extends CI_Model
{
      //total fee for readmission
      public function getTotalFeeAmount($filter){
 
        $this->db->select('SUM(fee.fee_amount_state_board) as total_fee');
        $this->db->from('tbl_admission_fee_structure as fee');
        //$this->db->join('tbl_school_account_type as type', 'type.row_id = fee.school_account_id','left');
       // $this->db->join('tbl_fee_receipt_config_info as acct', 'acct.row_id = fee.school_account_id','left');
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
       // $this->db->where('fee.fee_division_row_id', $type_id);
        $this->db->where('fee.fee_year', $filter['fee_year']);
        $this->db->where('fee.is_deleted', 0);
        //$this->db->where('type.is_deleted', 0); 
        // if($filter['lang_fee_status'] == false){
        //     $this->db->where('fee.lang_fee_status!=', 1); 
        // }
        // if($filter['category'] == 'SC' || $filter['category'] == 'ST' || $filter['category'] == 'CAT-I'){
        //     $this->db->where('fee.fee_con_sc_st_cat_first_status',1);
        // }else{
        //     $this->db->where('fee.fee_con_sc_st_cat_first_status',0);
        // }
        // if($filter['board_name'] == "SSLC"){
        //     $this->db->where('fee.fees_type!=', 'ELIGIBILITY FEES'); 
        // }
       // $this->db->where('acct.is_deleted', 0); 
        // $this->db->order_by('fee.fee_amount_state_board','asc');
        $query = $this->db->get();
        return $query->row();
    }

    public function getTotalFeePaidInfo($application_no,$payment_year){
        $this->db->select('SUM(paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result->paid_amount;
    }

    public function getFeePaidInfo($application_no,$payment_year){
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function getFeePaidInfoAttempt($application_no,$payment_year){
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function checkInstalmentExists($student_id){
        $this->db->from('tbl_student_fee_installment_info as fee');
        $this->db->where('fee.application_no', $student_id);
        $this->db->where('fee.payment_status', 0);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getStudentFeeConcession($application_no){
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_status', 0);
        $this->db->where('fee.approved_status', 1);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getStudentFeeScholarship($application_no){
        $this->db->from('tbl_student_fee_scholarship as fee');
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_status', 0);
        $this->db->where('fee.approved_status', 1);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }




}