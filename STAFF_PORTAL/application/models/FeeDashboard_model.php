<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class FeeDashboard_model extends CI_Model {

    public function getFeePaidInfoOverall($from_date,$to_date){
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
        $this->db->where('fee.payment_date >=', date('Y-m-d',strtotime($from_date)));
        $this->db->where('fee.payment_date <=', date('Y-m-d',strtotime($to_date)));
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getDeptFeePaidInfoOverall($from_date,$to_date){
        $this->db->from('tbl_department_fee_paid_info as fee');
        $this->db->where('fee.payment_date >=', date('Y-m-d',strtotime($from_date)));
        $this->db->where('fee.payment_date <=', date('Y-m-d',strtotime($to_date)));
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getMiscFeePaidInfoOverall($from_date,$to_date){
        log_message('debug','to_date'.date('Y-m-d',strtotime($to_date)));

        $this->db->from('tbl_miscellaneous_fee as fee');
        $this->db->where('fee.date >=', date('Y-m-d',strtotime($from_date)));
        $this->db->where('fee.date <=', date('Y-m-d',strtotime($to_date)));
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getSumOfFeesPaidClassWise($class,$year){
        $this->db->select('SUM(paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
        $this->db->join('tbl_students_info as std', 'std.row_id = fee.rel_stud_row_id','left');
      //  $this->db->join('tbl_student_class_year_wise as year', 'year.stud_row_id = std.row_id');
        $this->db->where('fee.term_name', $class);
       // $this->db->where('year.intake_year', $year);
        $this->db->where('fee.payment_year', $year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->paid_amount;
    }

    public function getSumOfFeeconcession($class,$year){
        $this->db->select('SUM(fee_amt) as fee_amt');
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->join('tbl_students_info as std','std.row_id = fee.student_id','left');
        $this->db->where('academic.term_name', $class);
        $this->db->where('fee.year', $year);
        $this->db->where('fee.approved_status', 1);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->fee_amt;
    }

    

    public function getCountOfTotalStudentsForFee($class,$year){
        $this->db->from('tbl_students_info as student'); 
       // $this->db->join('tbl_student_class_year_wise as year', 'year.stud_row_id = student.row_id');
        $this->db->where('year.class', $class);
        $this->db->where('year.intake_year', $year);
        $query = $this->db->get();
        return $query->num_rows();
    }

   
   

    public function getNewAdmissionFee(){
        $this->db->select('SUM(fee.fee_amount) as fee_amount');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where_in('fee.fee_type', ['NEW','ALL']);
        $this->db->where('fee.fee_year',FEE_YEAR);
        $query = $this->db->get();
        return $query->row();
    }

    public function getRegAdmissionFee(){
        $this->db->select('SUM(fee.fee_amount) as fee_amount');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where_in('fee.fee_type', ['REGULAR','ALL']);
        $this->db->where('fee.fee_year',FEE_YEAR);
        $query = $this->db->get();
        return $query->row();
    }

    public function getCancelledReceiptInfo($year) {
        $this->db->select('fee.row_id,fee.receipt_number,fee.application_no,fee.fee_account_row_id,fee.payment_date,fee.payment_type,
        fee.total_amount,fee.paid_amount,fee.excess_amount,fee.fee_concession,fee.fee_pending_status,fee.pending_balance,
        fee.bank_settlement_status,student.sat_number,fee.payment_year,fee.remarks');
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
        $this->db->join('tbl_students_info as student', 'student.row_id = fee.application_no','left'); 
        $this->db->where('fee.payment_year', $year);

        if(!empty($filter['date_from']) && !empty($filter['date_to'])){
            $this->db->where('DATE(fee.payment_date) >=', $filter['date_from']);
            $this->db->where('DATE(fee.payment_date) <=', $filter['date_to']);
        }
        if(!empty($filter['date_from']) ){
            $this->db->where('DATE(fee.payment_date) >=', $filter['date_from']);
        }
        if(!empty($filter['date_to'])){
            $this->db->where('DATE(fee.payment_date) <=', $filter['date_to']);
        }

        $this->db->where('fee.is_deleted', 1);
        $this->db->group_by('fee.row_id');
        // $this->db->where('student.is_deleted', 0);
        $this->db->order_by('fee.payment_date', 'DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getTotalPUStudentsCount($class,$stream)
    {
        $this->db->from('tbl_students_info as student');
        $this->db->where('student.stream_name',$stream);
        $this->db->where('student.term_name',$class);
        $this->db->where('student.is_active', 1);
        $this->db->where('student.is_deleted', 0);
        // $this->db->where('student.is_active', 1);
        $query = $this->db->get();
        return $query->num_rows();
    }

   

    public function getSumOfPUCFeesPaidClassWise($class,$stream){
        $this->db->select('SUM(paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
        $this->db->join('tbl_students_info as std', 'std.row_id = fee.application_no','left'); 
        $this->db->where('fee.term_name', $class);
        $this->db->where('std.stream_name', $stream);
        $this->db->where('fee.payment_year', CURRENT_YEAR);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->paid_amount;
    }

    // public function getSumOfIPUCFeesPaidClassWise($class,$stream){
    //     $this->db->select('SUM(paid_amount) as paid_amount');
    //     $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
    //     $this->db->join('tbl_admission_student_personal_details_temp as personal', 'personal.application_number = fee.application_no','left');
    //     $this->db->join('tbl_admission_combination_language_opted_temp as language', 'language.registred_row_id = personal.resgisted_tbl_row_id','left');
    //     $this->db->where('fee.term_name', $class);
    //     $this->db->where('language.stream_name', $stream);
    //     $this->db->where('fee.payment_year', CURRENT_YEAR);
    //     $this->db->where('fee.is_deleted', 0);
    //     $query = $this->db->get();
    //     return $query->row()->paid_amount;
    // }

  
    public function getSumOfPUCFeesConcession($class,$stream){
        $this->db->select('SUM(fee_amt) as fee_amt');
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->join('tbl_students_info as std', 'std.row_id = fee.application_no','left'); 
        $this->db->where('std.term_name', $class);
        $this->db->where('std.stream_name', $stream);
        $this->db->where('fee.year', CURRENT_YEAR);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->fee_amt;
    }

    public function getSumOfPUCFeesScholarship($class,$stream){
        $this->db->select('SUM(fee_amt) as fee_amt');
        $this->db->from('tbl_student_fee_scholarship as fee');
        $this->db->join('tbl_students_info as std', 'std.row_id = fee.application_no','left'); 
        $this->db->where('std.term_name', $class);
        $this->db->where('std.stream_name', $stream);
        $this->db->where('fee.year', CURRENT_YEAR);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->fee_amt;
    }

    public function getSumOfIPUCFeesConcession($class,$stream){
        $this->db->select('SUM(fee_amt) as fee_amt');
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'personal.application_number = fee.application_no','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as language', 'language.registred_row_id = personal.resgisted_tbl_row_id','left'); 
        $this->db->where('language.term_name', $class);
        $this->db->where('language.stream_name', $stream);
        $this->db->where('fee.year', CURRENT_YEAR);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row()->fee_amt;
    }


    public function getTotalFeeAmount($filter){
 
        $this->db->select('SUM(fee.fee_amount_state_board) as total_fee');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
        $this->db->where('fee.fee_year', CURRENT_YEAR);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getDepartmentFeeAmount($filter){
        $this->db->select('SUM(fee.fee_amount_state_board) as total_fee');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where_in('fee.stream_name', [$filter['stream_name'],'ALL']);
        $this->db->where_in('fee.term_name', [$filter['term_name'],'ALL']);
        $this->db->where('fee.fee_year', CURRENT_YEAR);
        $this->db->where('fee.is_deleted', 0);
        if($filter['term_name'] == 'I PUC'){
            $fee_type = array('College Dept Fee');
            $this->db->where_in('fee.fees_type', $fee_type);
        }else{
            $this->db->where('fee.fees_type', 'College Dept Fee');
        }
     
        $query = $this->db->get();
        return $query->row()->total_fee;
    }

}?>