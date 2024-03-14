<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class Fee_model extends CI_Model
{

    
    public function getFeeConcessionInfo($filter='') {
        $this->db->select('std.student_id,fee.row_id,fee.fee_amt,fee.approved_status,fee.date,fee.description,fee.application_no,
        fee.payment_status,std.student_name');
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->join('tbl_students_info as std','std.row_id = fee.application_no'); 
       
        
        if(!empty($filter['by_name'])) {
            $likeCriteria = "(std.student_name LIKE '%".$filter['by_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['amount'])){
            $this->db->where('fee.fee_amt', $filter['amount']);
        } 
        if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);
        } 
        if(!empty($filter['by_date'])){
            $likeCriteria = "(fee.date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        } 
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $this->db->order_by('fee.row_id','DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }
    public function getFeeConcessionCount($filter='') {
        $this->db->select('std.student_id,fee.row_id,fee.fee_amt,fee.approved_status,fee.date,
        fee.description,fee.application_no,fee.payment_status,std.student_name');
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->join('tbl_students_info as std','std.row_id = fee.application_no'); 
       
        
        if(!empty($filter['by_name'])) {
            $likeCriteria = "(std.student_name LIKE '%".$filter['by_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['amount'])){
            $this->db->where('fee.fee_amt', $filter['amount']);
        } 
         if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);
        } 
        if(!empty($filter['by_date'])){
            $likeCriteria = "(fee.date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        } 
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // admission 
    public function getFeeConcessionNewAdmCount($filter='') {
        
        $this->db->from('tbl_new_admission_fee_concession as fee');
        $this->db->join('tbl_student_personal_details as std','std.application_number = fee.application_no');
        if(!empty($filter['by_name'])) {
            $likeCriteria = "(fee.student_name LIKE '%".$filter['by_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['amount'])){
            $this->db->where('fee.fee_amt', $filter['amount']);
        } 
        if(!empty($filter['application_no'])){
            $this->db->where('std.application_number', $filter['application_no']);
        } 
        if(!empty($filter['by_date'])){
            $likeCriteria = "(fee.date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        } 
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }


    public function getFeeConcessionNewAdmInfo($filter='') {
        $this->db->select('fee.row_id,fee.fee_amt,fee.approved_status,fee.date,fee.description,fee.application_no,
        fee.payment_status,std.name as student_name');
        $this->db->from('tbl_new_admission_fee_concession as fee');
        $this->db->join('tbl_student_personal_details as std','std.application_number = fee.application_no');
        if(!empty($filter['by_name'])) {
            $likeCriteria = "(fee.student_name LIKE '%".$filter['by_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['amount'])){
            $this->db->where('fee.fee_amt', $filter['amount']);
        } 
        if(!empty($filter['application_no'])){
            $this->db->where('std.application_number', $filter['application_no']);
        } 
        if(!empty($filter['by_date'])){
            $likeCriteria = "(fee.date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        } 
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $this->db->order_by('fee.row_id','DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }




    
    public function getFeeConcessionById($row_id) {
        $this->db->select('fee.row_id,fee.fee_amt,fee.approved_status,fee.date,fee.description,fee.application_no,
        fee.payment_status,std.student_name');
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->join('tbl_students_info as std','std.row_id = fee.application_no'); 
        $this->db->where('fee.row_id', $row_id);
        $this->db->where('fee.is_deleted', 0); 
        $query = $this->db->get();
        return $query->row();
    }
    public function addConcession($feeInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_student_fee_concession', $feeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    public function addNewAdmFeeConcession($feeInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_new_admission_fee_concession', $feeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
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

    public function getStudentFeeConcessionForview($application_no,$year){
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.year', $year);
        $this->db->where('fee.payment_status', 0);
        $this->db->where('fee.approved_status', 1);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function updateConcession($feeInfo, $row_id) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_student_fee_concession', $feeInfo);
        return TRUE;
    }

    public function getFeeInfoByReceiptNum($receipt_number){
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.row_id', $receipt_number);
        $query = $this->db->get();
        return $query->row();
    }

    public function getFeeInfoByReceiptNumBulk($receipt_number){
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.application_no', $receipt_number);
        $query = $this->db->get();
        return $query->row();
    }

    public function updateReceiptNumber($feePayment,$row_id) {
        $this->db->where_in('row_id', $row_id);
        $this->db->update('tbl_students_overall_fee_payment_info_i_puc_2021', $feePayment);
        return TRUE;
    }

    public function getAllFeePaidInfo($receipt_number){
        $this->db->select('
        fee.row_id, 
        fee.fees_type,
        paid.paid_amount,
        paid.application_no,
        paid.pending_amt,
        name.fee_name,');
        $this->db->from('tbl_fees_paid_by_receipt as paid');
        $this->db->join('tbl_admission_fee_structure as fee', 'fee.row_id = paid.fee_type_id','left');
        $this->db->join('tbl_fee_required_type as type', 'type.fee_structure_row_id = fee.row_id','right');
        $this->db->join('tbl_fees_name as name', 'name.row_id = fee.fees_type','left');
        $this->db->where('paid.is_deleted', 0);
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('paid.receipt_number', $receipt_number);
        // $this->db->order_by('paid.paid_amount','ASC');
        $this->db->group_by('paid.fee_type_id');
        $query = $this->db->get();
        return $query->result();
    }


    public function addDDInfo($ddInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_fee_payment_dd_info', $ddInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function addBankInfo($bankInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_fee_payment_bank_info', $bankInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }









    

     //get students fetails lates update
     public function downloadAdmittedStudentFeePaidReport($filter){ 
        $this->db->select('std.row_id,
        std.application_no,
        std.student_name,
        ac.stream_name,
        ac.elective_sub,
        ac.student_id,
        fee.paid_amount,
        fee.pending_balance,
        ');
        $this->db->from('tbl_students_info as std');
        $this->db->join('tbl_student_academic_info as ac', 'ac.application_no = std.application_no','left');
        $this->db->join('tbl_students_overall_fee_payment_info as fee', 'fee.application_no = std.application_no','left');
        if(!empty($filter['stream_name'])){
            $this->db->where('ac.stream_name', $filter['stream_name']);
        }
        if(!empty($filter['elective_sub'])){
            $this->db->where('ac.elective_sub',strtoupper($filter['elective_sub']));
        }
        
      
        if($filter['paid_type'] == 'HALF'){
            $this->db->where('fee.fee_pending_status', 1);
        }else if($filter['paid_type'] == 'FULL'){
            $this->db->where('fee.fee_pending_status', 0);
        }

        $this->db->where('std.intake_year_id', 2019);
    
       // $this->db->where('std.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $this->db->where('ac.is_deleted', 0);
        $this->db->order_by('ac.student_id', 'DESC');
       
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    
    public function getAllFeeInstallmentInfo($filter, $page, $segment){
        $this->db->select('feeInsta.row_id, feeInsta.application_no, feeInsta.last_date,feeInsta.remarks, feeInsta.amount,
        feeInsta.payment_status,std.student_name,std.student_id');
        $this->db->from('tbl_student_fee_installment_info as feeInsta'); 
        $this->db->join('tbl_students_info as std','std.application_no = feeInsta.application_no'); 
        //$this->db->join('tbl_student_academic_info as academic', 'academic.application_no = std.application_no','left');
        if(!empty($filter['student_name'])){
            $likeCriteria = "(std.student_name  LIKE '%" . $filter['student_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);
        }
        if(!empty($filter['last_date'])){
            $this->db->where('feeInsta.last_date', $filter['last_date']);
        }
        if(!empty($filter['amount'])){
            $likeCriteria = "(feeInsta.amount  LIKE '%" . $filter['amount'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['year'])){
            $this->db->where('feeInsta.year', $filter['year']);
        }else{
            $this->db->where('feeInsta.year', CURRENT_YEAR);
        }
        $this->db->where('feeInsta.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $this->db->order_by('feeInsta.row_id','DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getFeeInstallmentCount($filter=''){
        $this->db->from('tbl_student_fee_installment_info as feeInsta'); 
        $this->db->join('tbl_students_info as std','std.application_no = feeInsta.application_no'); 
       // $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = std.application_no','left');
        if(!empty($filter['student_name'])){
            $likeCriteria = "(std.student_name  LIKE '%" . $filter['student_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);
        }
        if(!empty($filter['last_date'])){
            $this->db->where('feeInsta.last_date', $filter['last_date']);
        }
        if(!empty($filter['amount'])){
            $likeCriteria = "(feeInsta.amount  LIKE '%" . $filter['amount'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['year'])){
            $this->db->where('feeInsta.year', $filter['year']);
        }else{
            $this->db->where('feeInsta.year', CURRENT_YEAR);
        }
        $this->db->where('std.is_deleted', 0);
        $this->db->where('feeInsta.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function addFeeInstallment($installmentInfo){
            $this->db->trans_start();
            $this->db->insert('tbl_student_fee_installment_info', $installmentInfo);
            $insert_id = $this->db->insert_id();
            $this->db->trans_complete();
            return $insert_id;
        }

        public function checkInstalmentExists($student_id){
            $this->db->from('tbl_student_fee_installment_info as fee');
            $this->db->where('fee.application_no', $student_id);
            $this->db->where('fee.payment_status', 0);
            $this->db->where('fee.is_deleted', 0);
            $query = $this->db->get();
            return $query->row();
        }

   public function getFeeInstallmentById($row_id) {
        $this->db->select('feeInstall.row_id,feeInstall.amount,feeInstall.last_date,feeInstall.remarks,
        feeInstall.application_no,feeInstall.payment_status,feeInstall.year,std.student_name,std.student_id');
        $this->db->from('tbl_student_fee_installment_info as feeInstall');
        $this->db->join('tbl_students_info as std','std.application_no = feeInstall.application_no'); 
       // $this->db->join('tbl_student_academic_info as academic', 'academic.application_no = std.application_no','left');
        $this->db->where('feeInstall.row_id', $row_id);
        $this->db->where('feeInstall.is_deleted', 0); 
        $query = $this->db->get();
        return $query->row();
        }

    function updateFeeInstallment($installmentInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_student_fee_installment_info', $installmentInfo);
        return TRUE;
    }

    
    public function addStudentMngtFee($feeInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_student_management_fee_info', $feeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    
    public function getStdMngtFeeInfoInfo($filter='') {
        $this->db->select('fee.row_id,fee.application_no,fee.amount,fee.date,personal.name,log.order_id,stream.stream_name');
        $this->db->from('tbl_student_management_fee_info as fee');
        $this->db->join('tbl_paytm_fee_payment_log as log', 'log.application_no = fee.application_no','left');
        $this->db->join('tbl_admission_students_status_temp as std', 'std.application_number = fee.application_no','left');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'personal.application_number = std.application_number','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as stream', 'stream.registred_row_id = personal.resgisted_tbl_row_id','left');
        
        if(!empty($filter['by_name'])) {
            $likeCriteria = "(personal.name LIKE '%".$filter['by_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['amount'])){
            $this->db->where('fee.amount', $filter['amount']);
        } 
        if(!empty($filter['order_id'])){
            $this->db->where('log.order_id', $filter['order_id']);
        } 
         if(!empty($filter['student_id'])){
            $this->db->where('fee.application_no', $filter['student_id']);
        } 
        if(!empty($filter['by_date'])){
            $likeCriteria = "(fee.date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        } 
        if(!empty($filter['stream_name'])){
            $this->db->where('stream.stream_name', $filter['stream_name']);
        } 
        $this->db->where('log.remarks', 'Agnes Admission Mgmt Fee');
        $this->db->where('log.payment_status', 'TXN_SUCCESS');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $this->db->order_by('fee.row_id','DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }
    public function getStdMngtFeeInfoInfoCount($filter='') {
        $this->db->from('tbl_student_management_fee_info as fee');
        $this->db->join('tbl_paytm_fee_payment_log as log', 'log.application_no = fee.application_no','left');
        $this->db->join('tbl_admission_students_status_temp as std', 'std.application_number = fee.application_no','left');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'personal.application_number = std.application_number','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as stream', 'stream.registred_row_id = personal.resgisted_tbl_row_id','left');
        
        if(!empty($filter['by_name'])) {
            $likeCriteria = "(personal.name LIKE '%".$filter['by_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['amount'])){
            $this->db->where('fee.amount', $filter['amount']);
        } 
        if(!empty($filter['order_id'])){
            $this->db->where('log.order_id', $filter['order_id']);
        } 
        if(!empty($filter['student_id'])){
            $this->db->where('fee.application_no', $filter['student_id']);
        } 
        if(!empty($filter['stream_name'])){
            $this->db->where('stream.stream_name', $filter['stream_name']);
        } 
        if(!empty($filter['by_date'])){
            $likeCriteria = "(fee.date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        } 
        $this->db->where('log.remarks', 'Agnes Admission Mgmt Fee');
        $this->db->where('log.payment_status', 'TXN_SUCCESS');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getStudentManagementFeeInfoById($row_id) {
        $this->db->select('fee.row_id,fee.application_no,fee.amount,fee.date,personal.name,personal.father_name,
        personal.permanent_address,stream.stream_name,stream.second_language');
        $this->db->from('tbl_student_management_fee_info as fee');
        $this->db->join('tbl_admission_students_status_temp as std', 'std.application_number = fee.application_no','left');
        $this->db->join('tbl_admission_student_personal_details_temp as personal', 'personal.application_number = std.application_number','left');
        $this->db->join('tbl_admission_combination_language_opted_temp as stream', 'stream.registred_row_id = personal.resgisted_tbl_row_id','left');
        $this->db->where('fee.row_id', $row_id);
        $this->db->where('fee.is_deleted', 0); 
        $query = $this->db->get();
        return $query->row();
    }

    
    public function getSumOfManagementFee() {
        $this->db->select('SUM(fee.amount) as total_amount');
        $this->db->from('tbl_student_management_fee_info as fee');
        $this->db->where('fee.is_deleted', 0); 
        $query = $this->db->get();
        return $query->row();
    }

    
    public function updateManagementFee($feeInfo,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_student_management_fee_info', $feeInfo);
        return TRUE;
    }

    public function checkStudentForMngtFeeExists($application_no,$row_id='') {
        $this->db->from('tbl_student_management_fee_info as fee');
        $this->db->where('fee.application_no', $application_no);
        if(!empty($row_id)){
            $this->db->where('fee.row_id !=', $row_id);
        }
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getFeePendingAmount2021($student_id){
        $this->db->from('tbl_fee_pending_info_2021 as student'); 
        $this->db->where('student.student_id', $student_id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    //old fee info update
    public function addFeeDetails2020IPUC($feeInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_admission_students_overall_fee_payment_info', $feeInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }

    public function addReceiptFeeTypeOld($paymentInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_fees_paid_by_receipt', $paymentInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }

    public function checkFeeTypeIsAlreadyPaid2021($application_no,$fee_id){
        $this->db->from('tbl_fees_paid_by_receipt as paid');
        $this->db->where('paid.is_deleted', 0);
        $this->db->where('paid.application_no', $application_no);
        $this->db->where('paid.fee_type_id', $fee_id);
        $this->db->order_by('paid.receipt_number', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function getFeePaidInfo2019($application_no){
        $this->db->from('tbl_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function addFeePending2019($feeInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_students_overall_fee_payment_info', $feeInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }

    public function addFeePending_FeeDetailsInfo($feeInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_students_overall_fee_payment_info_2020', $feeInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }

    public function updatePendingFeeOld($paymentInfo, $application_number) {
        $this->db->where('application_no', $application_number);
        $this->db->update('tbl_fee_pending_info_2021', $paymentInfo);
        return TRUE;
    }

    
    public function getFeePaidInfo2021($application_no){
        $this->db->from('tbl_students_overall_fee_payment_info_2021 as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function getTotalFeePaidInfo2021($application_no){
        $this->db->select('SUM(paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info_2021 as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $query = $this->db->get();
        $result = $query->row();
        return $result->paid_amount;
    }
    public function getFeePaidInfo2020($application_no){
        $this->db->from('tbl_admission_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function getTotalFeePaidInfo2020($application_no){
        $this->db->select('SUM(paid_amount) as paid_amount');
        $this->db->from('tbl_admission_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $query = $this->db->get();
        $result = $query->row();
        return $result->paid_amount;
    }
    public function getFeeDDInfo($receipt_number){
        $this->db->from('tbl_fee_payment_dd_info as student'); 
        $this->db->where('student.receipt_number', $receipt_number);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    public function getFeeCardInfo($receipt_number){
        $this->db->from('tbl_fee_payment_bank_info as student'); 
        $this->db->where('student.receipt_number', $receipt_number);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function getFeeInfoByReceiptNum_2020($receipt_number){
        $this->db->from('tbl_students_overall_fee_payment_info_2020 as fee'); 
        $this->db->where('fee.receipt_number', $receipt_number);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function getFeeInfoByReceiptNum_2020old($receipt_number){
        $this->db->from('tbl_admission_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.receipt_number', $receipt_number);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function getFeeInfoByReceiptNum_2019old($receipt_number){
        $this->db->from('tbl_students_overall_fee_payment_info as fee'); 
        $this->db->where('fee.receipt_number', $receipt_number);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    

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

    public function getTotalFeeAmountForReport($term_name,$stream,$year){
 
        $this->db->select('SUM(fee.fee_amount_state_board) as total_fee');
        $this->db->from('tbl_admission_fee_structure as fee');
        $this->db->where_in('fee.stream_name', [$stream,'ALL']);
        $this->db->where_in('fee.term_name', [$term_name,'ALL']);
        $this->db->where('fee.fee_year', $year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }



    public function addFeeDetailsNewAdmission($feeInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_students_overall_fee_payment_info_2021', $feeInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }
    public function getStdPaidDetailsByApplicationNo($application_no){
        $this->db->select('fee.paid_amount,fee.payment_count');
        $this->db->from('tbl_students_overall_fee_payment_info_2021 as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.application_no', $application_no);
        $this->db->order_by('fee.receipt_number', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function getFeeInfoByReceiptNum_2021($receipt_number){
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee'); 
        $this->db->where('fee.row_id', $receipt_number);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function getFeeInfoByReceiptNumOld($receipt_number){
        $this->db->from('tbl_students_overall_fee_payment_info_2021 as fee'); 
        $this->db->where('fee.receipt_number', $receipt_number);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }


    public function getFeeStructureInfo($filter){
 
        // $this->db->select('SUM(fee.fee_amount_state_board) as total_fee');
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
        return $query->result();
    }

    public function getSUM_Paid_FeeInfoByReceiptNum_2021($application_no,$year){
        $this->db->select('SUM(fee.paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year', $year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    public function getSUM_Paid_FeeInfoIIPucLastYear($application_no){
        $this->db->select('SUM(fee.paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info_2021 as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    public function getSUM_Paid_FeeInfoByReceiptNum_2021_I_PUC($application_no,$year){
        $this->db->select('SUM(fee.paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.term_name', 'I PUC');
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    
    //get all fee payment info

    //get students fetails lates update
    public function getAllFeePaymentInfoCount($filter='')
    {
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
        $this->db->join('tbl_students_info as std', 'std.row_id = fee.application_no','left');
        //  $this->db->join('tbl_fee_payment_bank_settlement as bank', 'bank.receipt_number = fee.row_id','left');
    
        if(!empty($filter['application_no'])){
            $this->db->where('fee.application_no', $filter['application_no']);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);
        }
        if(!empty($filter['date_select'])){
         $this->db->where('fee.payment_date', $filter['date_select']);
        }
        if(!empty($filter['receipt_number'])){
         $this->db->where('fee.ref_receipt_no', $filter['receipt_number']);
        }
        if(!empty($filter['amount_paid'])){
         $this->db->where('fee.paid_amount', $filter['amount_paid']);
        }
        if(!empty($filter['amount_pending'])){
         $this->db->where('fee.pending_balance', $filter['amount_pending']);
        }
        if(!empty($filter['order_id'])){
         $this->db->where('fee.order_id', $filter['order_id']);
        }
 
        if(!empty($filter['payment_type'])){
         $this->db->where('fee.payment_type', $filter['payment_type']);
        }
 
        if($filter['bank_settlement'] == 'Settled'){
         $this->db->where('fee.bank_settlement_status', 1);
        }else if($filter['bank_settlement'] == 'Pending'){
         $this->db->where('fee.bank_settlement_status', 0);
        }
        if(!empty($filter['by_bank_date'])){
         $this->db->where('fee.bank_settlement_date', $filter['by_bank_date']);
        }
        if(!empty($filter['by_year'])){
            $this->db->where('fee.payment_year', $filter['by_year']);
           }else{
              $this->db->where('fee.payment_year', CURRENT_YEAR);
           }
        
       $this->db->where('fee.is_deleted', 0);
       $this->db->where('fee.is_deleted', 0);
       $query = $this->db->get();
       return $query->num_rows();
   }
 
       //get students fetails lates update
       public function getAllFeePaymentInfo($page, $segment, $filter='')
       {
             $this->db->select('fee.payment_date,
             fee.row_id,
             fee.ref_receipt_no,
             fee.order_id,
             fee.application_no,
             fee.paid_amount,
             fee.pending_balance,
             fee.payment_type, 
             fee.bank_settlement_status,
             fee.term_name,std.student_id,
             fee.bank_settlement_date as date');
             $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
             $this->db->join('tbl_students_info as std', 'std.row_id = fee.application_no','left');
           //  $this->db->join('tbl_fee_payment_bank_settlement as bank', 'bank.receipt_number = fee.row_id','left');
             if(!empty($filter['application_no'])){
                $this->db->where('fee.application_no', $filter['application_no']);
            }
             if(!empty($filter['student_id'])){
                 $this->db->where('std.student_id', $filter['student_id']);
             }
             if(!empty($filter['date_select'])){
              $this->db->where('fee.payment_date', $filter['date_select']);
             }
             if(!empty($filter['receipt_number'])){
              $this->db->where('fee.ref_receipt_no', $filter['receipt_number']);
             }
             if(!empty($filter['amount_paid'])){
              $this->db->where('fee.paid_amount', $filter['amount_paid']);
             }
             if(!empty($filter['amount_pending'])){
              $this->db->where('fee.pending_balance', $filter['amount_pending']);
             }
             if(!empty($filter['order_id'])){
              $this->db->where('fee.order_id', $filter['order_id']);
             }
      
             if(!empty($filter['payment_type'])){
              $this->db->where('fee.payment_type', $filter['payment_type']);
             }
      
             if($filter['bank_settlement'] == 'Settled'){
              $this->db->where('fee.bank_settlement_status', 1);
             }else if($filter['bank_settlement'] == 'Pending'){
              $this->db->where('fee.bank_settlement_status', 0);
             }
             if(!empty($filter['by_bank_date'])){
              $this->db->where('fee.bank_settlement_date', $filter['by_bank_date']);
             }
             if(!empty($filter['by_year'])){
              $this->db->where('fee.payment_year', $filter['by_year']);
            //  $this->db->where('bank.fee_year', $filter['by_year']);
             }else{
                $this->db->where('fee.payment_year', CURRENT_YEAR);
             //   $this->db->where('bank.fee_year', CURRENT_YEAR);
             }
            $this->db->where('fee.is_deleted', 0);
           $this->db->order_by('fee.row_id', 'ASC');
           $this->db->limit($page, $segment);
           $query = $this->db->get();
           return $query->result();
           
       }



       //second PUC batch 2019
       public function getFeePendingAmount2019($student_id){
        $this->db->from('tbl_fee_pending_ii_2021 as student'); 
        $this->db->where('student.student_id', $student_id);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

 

    
    public function updatePendingFee2019($paymentInfo, $student_id) {
        $this->db->where('student_id', $student_id);
        $this->db->update('tbl_fee_pending_ii_2021', $paymentInfo);
        return TRUE;
    }

    //second PUC batch 2019
    public function checkFeeAlreadyReceiptProcessed($receipt_number){
        $this->db->from('tbl_fees_paid_by_receipt_v2 as fee'); 
        $this->db->where('fee.receipt_number', $receipt_number);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

  

    public function getFeePaidInfo2021_ALL(){
        $this->db->from('tbl_students_overall_fee_payment_info_2021 as fee'); 
        $this->db->order_by('fee.payment_count', 'ASC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function addReceiptFeeType($paymentInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_fees_paid_by_receipt_v2', $paymentInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }

    public function checkFeeTypeIsAlreadyPaid($application_no,$fee_id){
        $this->db->from('tbl_fees_paid_by_receipt_v2 as paid');
        $this->db->where('paid.is_deleted', 0);
        $this->db->where('paid.application_no', $application_no);
        $this->db->where('paid.fee_type_id', $fee_id);
        $this->db->order_by('paid.receipt_number', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function getFeeReceiptPrintInfo_2021($receipt_number,$fee_type){
        $this->db->select('
        stru.fees_type,
        stru.school_account_id,
        fee.payment_date,
        fee.receipt_number,
        fee.application_no,
        fee.paid_amount');
        $this->db->from('tbl_fees_paid_by_receipt_v2 as fee'); 
        $this->db->join('tbl_admission_fee_structure as stru', 'stru.row_id = fee.fee_type_id','left');
        $this->db->where('fee.receipt_number', $receipt_number);
        $this->db->where('stru.school_account_id', $fee_type);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getFeePaidInfo_NewAdm_2021($application_no){
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }


    public function getStdPaidDetailsByApplicationNo_newADM($application_no){
        $this->db->select('fee.paid_amount,fee.payment_count');
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.application_no', $application_no);
        $this->db->order_by('fee.receipt_number', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }
      

    public function addFeeDetailsNewAdmission_2021($feeInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_students_overall_fee_payment_info_i_puc_2021', $feeInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }

    public function getAllFeePaymentInfoCountNewAdm($filter='')
    {
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
        $this->db->join('tbl_admission_students_status_temp as std', 'std.application_number  = fee.application_no','left');
        $this->db->join('tbl_fee_payment_bank_settlement_new_adm as bank', 'bank.receipt_number = fee.receipt_number','left');

        if(!empty($filter['application_no'])){
            $this->db->where('fee.application_no', $filter['application_no']);
        }
        if(!empty($filter['student_id'])){
            $this->db->where('fee.application_no', $filter['student_id']);
        }
        if(!empty($filter['date_select'])){
         $this->db->where('fee.payment_date', $filter['date_select']);
        }
        if(!empty($filter['receipt_number'])){
         $this->db->where('fee.receipt_number', $filter['receipt_number']);
        }
        if(!empty($filter['amount_paid'])){
         $this->db->where('fee.paid_amount', $filter['amount_paid']);
        }
        if(!empty($filter['amount_pending'])){
         $this->db->where('fee.pending_balance', $filter['amount_pending']);
        }
        if(!empty($filter['order_id'])){
         $this->db->where('fee.order_id', $filter['order_id']);
        }
 
        if(!empty($filter['payment_type'])){
         $this->db->where('fee.payment_type', $filter['payment_type']);
        }
 
        if($filter['bank_settlement'] == 'Settled'){
         $this->db->where('fee.bank_settlement_status', 1);
        }else if($filter['bank_settlement'] == 'Pending'){
         $this->db->where('fee.bank_settlement_status', 0);
        }
        if(!empty($filter['by_bank_date'])){
         $this->db->where('bank.date', $filter['by_bank_date']);
        }
       $this->db->where('fee.is_deleted', 0);
       $this->db->where('fee.is_deleted', 0);
       $query = $this->db->get();
       return $query->num_rows();
   }
 
       //get students fetails lates update
       public function getAllFeePaymentInfoNewAdm($page, $segment, $filter='')
       {
             $this->db->select('fee.payment_date,
             std.application_number,
             fee.receipt_number,
             fee.order_id,
             fee.application_no,
             fee.paid_amount,
             fee.pending_balance,
             fee.payment_type, 
             fee.bank_settlement_status,
             bank.date');
             $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
             $this->db->join('tbl_admission_students_status_temp as std', 'std.application_number  = fee.application_no','left');
             $this->db->join('tbl_fee_payment_bank_settlement_new_adm as bank', 'bank.receipt_number = fee.receipt_number','left');
             if(!empty($filter['application_no'])){
                $this->db->where('fee.application_no', $filter['application_no']);
            }
             if(!empty($filter['student_id'])){
                 $this->db->where('fee.application_no', $filter['student_id']);
             }
             if(!empty($filter['date_select'])){
              $this->db->where('fee.payment_date', $filter['date_select']);
             }
             if(!empty($filter['receipt_number'])){
              $this->db->where('fee.receipt_number', $filter['receipt_number']);
             }
             if(!empty($filter['amount_paid'])){
              $this->db->where('fee.paid_amount', $filter['amount_paid']);
             }
             if(!empty($filter['amount_pending'])){
              $this->db->where('fee.pending_balance', $filter['amount_pending']);
             }
             if(!empty($filter['order_id'])){
              $this->db->where('fee.order_id', $filter['order_id']);
             }
      
             if(!empty($filter['payment_type'])){
              $this->db->where('fee.payment_type', $filter['payment_type']);
             }
      
             if($filter['bank_settlement'] == 'Settled'){
              $this->db->where('fee.bank_settlement_status', 1);
             }else if($filter['bank_settlement'] == 'Pending'){
              $this->db->where('fee.bank_settlement_status', 0);
             }
             if(!empty($filter['by_bank_date'])){
              $this->db->where('bank.date', $filter['by_bank_date']);
             }
            $this->db->where('fee.is_deleted', 0);
            $this->db->where('fee.is_deleted', 0);
           $this->db->order_by('fee.receipt_number', 'ASC');
           $this->db->limit($page, $segment);
           $query = $this->db->get();
           return $query->result();
           
       }
       public function getAllFeePaymentInfoNewAdmPROCESS()
       {
             $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
            
             $this->db->where('fee.is_deleted', 0);
            // $this->db->where('fee.is_deleted', 0);
           $query = $this->db->get();
           return $query->result();
           
       }
       public function getFeeInfoByReceiptNum_2021_newAdm($receipt_number){
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee'); 
        $this->db->where('fee.row_id', $receipt_number);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    

    public function getFeeDDInfoNewAdm($receipt_number,$application_no){
        $this->db->from('tbl_fee_payment_dd_info as student'); 
        $this->db->where('student.receipt_number', $receipt_number);
        // $this->db->where('student.application_no', $application_no);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }
    public function getFeeCardInfoNewAdm($receipt_number,$application_no){
        $this->db->from('tbl_fee_payment_bank_info as student'); 
        $this->db->where('student.receipt_number', $receipt_number);
        // $this->db->where('student.application_no', $application_no);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function getFeeReceiptPrintInfo_2021_I_PUC($receipt_number,$fee_type,$application_no){
        $this->db->select('
        stru.fees_type,
        stru.school_account_id,
        fee.payment_date,
        fee.receipt_number,
        fee.application_no,
        fee.paid_amount');
        $this->db->from('tbl_fees_paid_by_receipt_v2 as fee'); 
        $this->db->join('tbl_admission_fee_structure as stru', 'stru.row_id = fee.fee_type_id','left');
        $this->db->where('fee.receipt_number', $receipt_number);
        $this->db->where('stru.school_account_id', $fee_type);
        $this->db->where('fee.application_no', $application_no);
        
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }


         //get students fetails lates update
         public function getAllFeePaymentInfoForReport_II_PUC($filter)
         {
               $this->db->select('fee.payment_date,fee.row_id,
               std.student_id,
               std.student_name,
               std.stream_name,
               fee.ref_receipt_no,
               fee.order_id,
               fee.application_no,
               fee.paid_amount,
               fee.pending_balance,
               fee.payment_type, 
               fee.bank_settlement_status,
               bank.date');
               $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
               $this->db->join('tbl_students_info as std', 'std.application_no = fee.application_no','left');
               $this->db->join('tbl_fee_payment_bank_settlement as bank', 'bank.receipt_number = fee.receipt_number','left');
          
               if(!empty($filter['date_from'])){
                $this->db->where('fee.payment_date>=', $filter['date_from']);
                $this->db->where('fee.payment_date<=', $filter['date_to']);
               }
               if(!empty($filter['preference'])){
                $this->db->where('std.stream_name', $filter['preference']);
               }
         
              $this->db->where('fee.term_name', $filter['term_name']);
              $this->db->where('fee.is_deleted', 0);
             $this->db->order_by('fee.receipt_number', 'ASC');
             $this->db->limit($page, $segment);
             $query = $this->db->get();
             return $query->result();
             
         }

         public function getAllFeePaymentInfoForReport($filter)
         {
            $this->db->select('fee.payment_date,fee.row_id,
            fee.ref_receipt_no,
            fee.order_id,
            fee.application_no,
            fee.paid_amount,
            fee.pending_balance,
            fee.payment_type, 
            fee.bank_settlement_status,
            student.student_name,student.student_id,student.stream_name,student.row_id');
            $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
            $this->db->join('tbl_students_info as student','student.row_id = fee.application_no','left');
            if(!empty($filter['date_from'])){
                $this->db->where('fee.payment_date>=', $filter['date_from']);
                $this->db->where('fee.payment_date<=', $filter['date_to']);
               }
               if(($filter['preference']!= 'ALL')){
                $this->db->where('student.stream_name', $filter['preference']);
               }
               if(!empty($filter['term_name'])){
                $this->db->where('student.term_name', $filter['term_name']);
               }
           

            $this->db->where('fee.is_deleted', 0);
             $this->db->order_by('fee.receipt_number', 'ASC');
             $this->db->limit($page, $segment);
             $query = $this->db->get();
             return $query->result();
             
         }

         public function getRejectedAppFeePaymentInfoForReport($filter)
         {
            $this->db->select('fee.payment_date,fee.row_id,
            fee.ref_receipt_no,
            fee.order_id,
            fee.application_no,
            fee.paid_amount,
            fee.pending_balance,
            fee.payment_type, 
            fee.bank_settlement_status,
            student.student_name,student.student_id,student.stream_name,student.row_id');
            $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
            $this->db->join('tbl_students_info as student','student.row_id = fee.application_no','left');
            // if(!empty($filter['date_from'])){
            //     $this->db->where('fee.payment_date>=', $filter['date_from']);
            //     $this->db->where('fee.payment_date<=', $filter['date_to']);
            //    }
            //    if(!empty($filter['preference'])){
            //     $this->db->where('student.stream_name', $filter['preference']);
            //    }
               if(!empty($filter['term_name'])){
                $this->db->where('student.term_name', $filter['term_name']);
               }
           

            $this->db->where('fee.is_deleted', 0);
            $this->db->where('student.std_status', 1);
             $this->db->order_by('fee.ref_receipt_no', 'ASC');
             $this->db->limit($page, $segment);
             $query = $this->db->get();
             return $query->result();
             
         }

         public function getAllFeePaymentInfoForDueReport($filter)
         {
            $this->db->select('fee.payment_date,fee.row_id,
            fee.ref_receipt_no,
            fee.order_id,
            fee.application_no,
            fee.paid_amount,
            fee.pending_balance,
            fee.payment_type, fee.total_amount,
            fee.bank_settlement_status,
            student.student_name,student.student_id,student.stream_name,student.row_id');
            $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
            $this->db->join('tbl_students_info as student','student.row_id = fee.application_no','left');
            if(!empty($filter['date_from'])){
                $this->db->where('fee.payment_date>=', $filter['date_from']);
                $this->db->where('fee.payment_date<=', $filter['date_to']);
               }
               if(($filter['preference']!= 'ALL')){
                $this->db->where('student.stream_name', $filter['preference']);
               }
               if(!empty($filter['term_name'])){
                $this->db->where('student.term_name', $filter['term_name']);
               }
           

            $this->db->where('fee.is_deleted', 0);
            $this->db->order_by('student.student_id ASC, fee.payment_date ASC,fee.receipt_number ASC');

            
             $this->db->limit($page, $segment);
             $query = $this->db->get();
             return $query->result();
             
         }

    // order id process - readmission -----------------------------------------------
    public function getReadmissionPayTmLogByAppNo($order_id){
        $this->db->from('tbl_readmission_paytm_fee_payment_log as fee');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function getReAdmissionTotalPaidAmount($application_no){
        $this->db->select('SUM(fee.paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year', CURRENT_YEAR);
        $query = $this->db->get();
        return $query->row();
    }

    public function getReadmission_FeePaidDetailsByApplicationNo($application_no){
        $this->db->select('fee.paid_amount,fee.payment_count');
        $this->db->from('tbl_students_overall_fee_payment_info_2021 as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year', CURRENT_YEAR);
        $this->db->order_by('fee.receipt_number', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }


    // add overall fees detail - readmission
    public function addReadmission_FeeDetailsInfo($feeInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_students_overall_fee_payment_info_i_puc_2021', $feeInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }
    
    public function checkInstallmentAlreadyExistNew($student_id){
        $this->db->from('tbl_student_fee_installment_info as payment');
        $this->db->where('payment.application_no', $student_id);
        $this->db->where('payment.payment_status', 0); 
        $this->db->where('payment.year', CURRENT_YEAR); 
        $this->db->where('payment.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
    
    public function updateInstalmentNew($paymentInfo, $application_no) {
        $this->db->where('application_no', $application_no);
        $this->db->update('tbl_student_fee_installment_info', $paymentInfo);
        return TRUE;
    }
    // add paid amoumt for print
    public function addReceiptFeeType2021($paymentInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_fees_paid_by_receipt_v2', $paymentInfo);
        $insert_id = $this->db->insert_id(); 
        $this->db->trans_complete();
        return $insert_id; 
    }
    
    public function updateReadmission_PaymentLogByOrderIdPaytm($paymentInfo,$order_id) {
        $this->db->where('order_id', $order_id);
        $this->db->update('tbl_readmission_paytm_fee_payment_log',$paymentInfo);
        return TRUE;
    }
    public function checkReAdmissionOrderIdExists($order_id){
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function getReAdmUnProcessedOrderID(){
        $this->db->from('tbl_readmission_paytm_fee_payment_log');
        $this->db->where('payment_status!=', 'SUCCESS');
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    public function getNewAdmUnProcessedOrderID(){
        $this->db->from('tbl_paytm_fee_payment_log');
        $this->db->where('payment_status!=', 'SUCCESS');
        $this->db->where('is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    
    // order id process - new admission -----------------------------------------------
    public function getAdmissionPayTmLogByOrderId($order_id){
        $this->db->from('tbl_paytm_fee_payment_log as fee');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        return $query->row();
    }
    public function updatePaymentLogByOrderId($paymentInfo,$order_id) {
       $this->db->where('order_id', $order_id);
       $this->db->update('tbl_paytm_fee_payment_log',$paymentInfo);
       return TRUE;
    }

    public function checkAdmissionOrderIdExists($order_id){
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
        $this->db->where('order_id', $order_id);
        $query = $this->db->get();
        return $query->row();
    }

    
    // get 2020 fee pending amount list
    public function getAllFeePendingAmount2020(){
        $this->db->from('tbl_fee_pending_info_2021 as fee');
        $this->db->join('tbl_students_info as std', 'std.student_id = fee.student_id','left'); 
        $this->db->order_by('fee.student_id','ASC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    
    public function getSUM_Paid_FeeInfoByReceiptNum_2020($application_no){
        $this->db->select('SUM(fee.paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info_2020 as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    
    public function getAllFeePendingAmount2019(){
        $this->db->from('tbl_fee_pending_ii_2021 as fee');
        $this->db->join('tbl_students_info as std', 'std.student_id = fee.student_id','left'); 
        $this->db->order_by('fee.student_id','ASC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
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

    public function getFeePaidInfoForStudentView($application_no,$payment_year){
        $this->db->select('fee.payment_date,
        fee.row_id,
        fee.ref_receipt_no,
        fee.order_id,
        fee.application_no,
        fee.paid_amount,
        fee.pending_balance,
        fee.payment_type, 
        fee.bank_settlement_status,fee.attempt,
        fee.term_name,std.student_id,std.stream_name,
        fee.bank_settlement_date as date');
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee'); 
        $this->db->join('tbl_students_info as std', 'std.row_id = fee.application_no','left');
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function getFeePaidInfoForReport($application_no,$payment_year){
        $this->db->select('SUM(fee.paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
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

   
    public function getFeesPaidInfo($application_no,$payment_year,$row_id){
        $this->db->select('SUM(paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.row_id <',$row_id);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result->paid_amount;
    }


    public function getStdLastPaidDetailsByApplicationNo($application_no,$year){
        $this->db->select('fee.paid_amount,fee.payment_count,fee.pending_balance');
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year', $year);
        $this->db->order_by('fee.row_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function getLastReceiptNo($year){
        $this->db->select('fee.receipt_number');
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.payment_year', $year);
        $this->db->order_by('fee.row_id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }

    public function getFrenchFeePaidByReceipt($receipt_number){
        $this->db->select('fee.paid_amount');
        $this->db->from('tbl_fees_paid_by_receipt_v2 as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.receipt_number', $receipt_number);
        $this->db->where_in('fee.fee_type_id', [83,128,129,297,298]);
        $query = $this->db->get();
        return $query->row()->paid_amount;
    }

    public function getOverallFeeInfo(){
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee'); 
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function updateOverallFee($feeInfo, $row_id) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_students_overall_fee_payment_info_i_puc_2021', $feeInfo);
        return TRUE;
    }

    public function getCheckReceiptNo($receipt_no,$year){
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee'); 
        $this->db->where('fee.ref_receipt_no', $receipt_no);
        $this->db->where('fee.payment_year', $year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    function checkReceiptNoExists($ref_receipt_no,$year){
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.ref_receipt_no', $ref_receipt_no);
        $this->db->where('fee.payment_year', $year);
        $query = $this->db->get();
        return $query->row();
    }

    public function getPreviousFeePaidInfo($row_id,$application_no,$term_name){
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.term_name',$term_name);
        $this->db->where('fee.row_id <', $row_id);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function getFeeBulkReceipt($filter='') {
        
        $this->db->select('student.row_id, student.student_name, student.dob, student.gender,student.sat_number,student.application_no,student.email, 
        student.blood_group,student.intake_year,student.father_name,student.stream_name,fee.row_id as fee_row_id,
        student.student_id,student.term_name,student.section_name,student.elective_sub,
        fee.receipt_number,fee.ref_receipt_no,fee.payment_type,fee.payment_date,fee.total_amount,fee.paid_amount,
        fee.fee_concession,fee.pending_balance,fee.payment_year,fee.order_id,fee.payment_count');
        
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
        $this->db->join('tbl_students_info as student', 'student.row_id = fee.application_no','left');
        
        if(!empty($filter['date_from'])){
            $this->db->where('fee.payment_date>=', $filter['date_from']);
        }
        if(!empty($filter['date_to'])){
            $this->db->where('fee.payment_date<=', $filter['date_to']);
        }
        // if(!empty($filter['payment_year'])){
        //     $this->db->where('fee.payment_year', $filter['payment_year']);
        // }
        
        // if($filter['payment_type']!='ALL'){
        //     $this->db->where('fee.payment_type', $filter['payment_type']);
        // }
        $this->db->where('fee.is_deleted',0);
         $this->db->order_by('fee.receipt_number', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }


    public function getMiscellaneousFeesInfo()
    {
        $this->db->select('fee.row_id,fee.qnty,std.student_id,fee.student_name,fee.term,fee.amount,fee.ref_receipt_no,
         fee.created_by,fee.date, type.miscellaneous_type,fee.miscellaneous_type as miscellaneous,fee.payment_type');
        $this->db->from('tbl_miscellaneous_fee as fee'); 
        $this->db->join('tbl_miscellaneous_type as type', 'type.row_id = fee.miscellaneous_type','left');
       // $this->db->join('tbl_student_academic_info as acd', 'acd.student_id = fee.student_id','left');
        $this->db->join('tbl_students_info as std', 'std.row_id = fee.student_row_id','left');
        $this->db->where('fee.is_deleted', 0);
        $this->db->order_by('fee.row_id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    
    public function getStaffNameById($row_id) {
        $this->db->from('tbl_staff as staff'); 
        $this->db->where('staff.staff_id', $row_id);
        $this->db->where('staff.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();  
    }

    public function addMiscellaneousPayment($miscellaneousInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_miscellaneous_fee', $miscellaneousInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id; 
    }

    
    public function updateMiscellaneousFee($miscellaneousInfo, $row_id){
        $this->db->where('row_id',$row_id);
        $this->db->update('tbl_miscellaneous_fee', $miscellaneousInfo);
        return true;
    }

    public function getMiscellaneousFeesInfoById($row_id)
    { $this->db->select('fee.row_id,fee.qnty,fee.student_row_id,fee.stream,fee.student_name,fee.term,fee.amount,fee.created_by,fee.date, type.miscellaneous_type,fee.ref_receipt_no,fee.student_id');
        $this->db->from('tbl_miscellaneous_fee as fee'); 
        $this->db->join('tbl_miscellaneous_type as type', 'type.row_id = fee.miscellaneous_type','left');
        $this->db->where('fee.row_id', $row_id);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getMiscellaneousFeesInfoReport($filter='')
    {
        $this->db->select('fee.row_id,fee.qnty,fee.student_id,fee.stream,fee.ref_receipt_no,fee.payment_type,fee.student_name ,fee.term,fee.amount, fee.date, type.miscellaneous_type,fee.year,fee.stream');
        $this->db->from('tbl_miscellaneous_fee as fee'); 
        $this->db->join('tbl_miscellaneous_type as type', 'type.row_id = fee.miscellaneous_type','left');

        if(!empty($filter['date_from']) && !empty($filter['date_to'])){
            $this->db->where('fee.date >=', $filter['date_from']);
            $this->db->where('fee.date <=', $filter['date_to']);
        }else if(!empty($filter['date_from'])){
            $this->db->where('fee.date >=', $filter['date_from']);
        }else if(!empty($filter['date_to'])){
            $this->db->where('fee.date <=', $filter['date_to']);
        }

       
        if(!empty($filter['payment_type'])){
            $this->db->where_in('fee.payment_type',$filter['payment_type']);
        }
        if(!empty($filter['miscellaneous_type'])){
            $this->db->where_in('fee.miscellaneous_type',$filter['miscellaneous_type']);
        }
       

        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    
    public function getfirstpucbal($row_id)
    {
      $this->db->select('fee.row_id,fee.term_name,fee.amount');
      $this->db->from('tbl_pending_amount as fee'); 
      $this->db->where('fee.std_row_id', $row_id);
      $this->db->where('fee.is_deleted', 0);
      $query = $this->db->get();
      return $query->row();
    }

    
    public function getStdCancelAdmissionFeeByID($row_id)
    {
      $this->db->select('fee.row_id,fee.term_name,fee.amount');
      $this->db->from('tbl_cancel_admission_pending_fee as fee'); 
      $this->db->where('fee.std_row_id', $row_id);
      $this->db->where('fee.is_deleted', 0);
      $query = $this->db->get();
      return $query->row();
    }

    public function getTransportTotalPaidAmount($stud_id,$year){
        $this->db->select('SUM(fee.bus_fees) as paid_amount');
        $this->db->from('tbl_student_bus_management_details as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.student_id', $stud_id);
        $this->db->where('fee.intake_year',$year);
        $query = $this->db->get();
        return $query->row();
    }

    public function getFeeScholarshipCount($filter='') {
        $this->db->select('std.student_id,fee.row_id,fee.fee_amt,fee.approved_status,fee.date,
        fee.description,fee.application_no,fee.payment_status,std.student_name');
        $this->db->from('tbl_student_fee_scholarship as fee');
        $this->db->join('tbl_students_info as std','std.row_id = fee.application_no'); 
       
        
        if(!empty($filter['by_name'])) {
            $likeCriteria = "(std.student_name LIKE '%".$filter['by_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['amount'])){
            $this->db->where('fee.fee_amt', $filter['amount']);
        } 
         if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);
        } 
        if(!empty($filter['by_date'])){
            $likeCriteria = "(fee.date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        } 
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function getFeeScholarshipInfo($filter='') {
        $this->db->select('std.student_id,fee.row_id,fee.fee_amt,fee.approved_status,fee.date,fee.description,fee.application_no,
        fee.payment_status,std.student_name');
        $this->db->from('tbl_student_fee_scholarship as fee');
        $this->db->join('tbl_students_info as std','std.row_id = fee.application_no'); 
       
        
        if(!empty($filter['by_name'])) {
            $likeCriteria = "(std.student_name LIKE '%".$filter['by_name']."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['amount'])){
            $this->db->where('fee.fee_amt', $filter['amount']);
        } 
        if(!empty($filter['student_id'])){
            $this->db->where('std.student_id', $filter['student_id']);
        } 
        if(!empty($filter['by_date'])){
            $likeCriteria = "(fee.date LIKE '%".$filter['by_date']."%')";
            $this->db->where($likeCriteria);
        } 
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('std.is_deleted', 0);
        $this->db->order_by('fee.row_id','DESC');
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

    public function addScholarship($feeInfo) {
        $this->db->trans_start();
        $this->db->insert('tbl_student_fee_scholarship', $feeInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    public function updateScholarship($feeInfo, $row_id) {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_student_fee_scholarship', $feeInfo);
        return TRUE;
    }

    public function getFeeScholarshipById($row_id) {
        $this->db->select('fee.row_id,fee.fee_amt,fee.approved_status,fee.date,fee.description,fee.application_no,
        fee.payment_status,std.student_name');
        $this->db->from('tbl_student_fee_scholarship as fee');
        $this->db->join('tbl_students_info as std','std.row_id = fee.application_no'); 
        $this->db->where('fee.row_id', $row_id);
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

    public function getSumOfFeesPaidForReceipt($rel_stud_row_id,$year,$date){
        $this->db->select('SUM(paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee');
        $this->db->where('fee.application_no', $rel_stud_row_id);
        $this->db->where('fee.payment_year', $year);
        $this->db->where('fee.created_date_time<=', $date);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

    public function getSumFeeConcessionInfoForReport($student_id,$year,$date){ 
        // $this->db->select('SUM(fee.fee_amt) as fee_amt');
        $this->db->from('tbl_student_fee_concession as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.application_no', $student_id);
        $this->db->where('fee.date <=', $date);
        $this->db->where('fee.year', $year);
        $this->db->where('fee.approved_status', 1);
        $query = $this->db->get();
        return $query->row();
    }

    public function getSumFeeScholarshipInfoForReport($student_id,$year,$date){ 
        // $this->db->select('SUM(fee.fee_amt) as fee_amt');
        $this->db->from('tbl_student_fee_scholarship as fee');
        $this->db->where('fee.is_deleted', 0);
        $this->db->where('fee.application_no', $student_id);
        $this->db->where('fee.date <=', $date);
        $this->db->where('fee.year', $year);
        $this->db->where('fee.approved_status', 1);
        $query = $this->db->get();
        return $query->row();
    }

    public function getTotalFeePaidReportInfo($application_no,$payment_year){
        $this->db->select('SUM(paid_amount) as paid_amount');
        $this->db->from('tbl_students_overall_fee_payment_info_i_puc_2021 as fee'); 
        $this->db->where('fee.application_no', $application_no);
        $this->db->where('fee.payment_year',$payment_year);
        $this->db->where('fee.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }
}
?>