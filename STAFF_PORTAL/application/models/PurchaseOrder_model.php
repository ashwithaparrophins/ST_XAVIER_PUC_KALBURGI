<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
class PurchaseOrder_model extends CI_Model
{

    public function getAllPartyDetailsInfo($filter, $page, $segment){
        $this->db->from('tbl_party_info as party'); 
        if(!empty($filter['party_name'])){
            $likeCriteria = "(party.party_name  LIKE '%" . $filter['party_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['email'])){
            $likeCriteria = "(party.email  LIKE '%" . $filter['email'] . "%')";
            $this->db->where($likeCriteria);
        }
         
        if(!empty($filter['contact_number_one'])){
            $this->db->where('party.contact_number_one', $filter['contact_number_one']);
        }
        if(!empty($filter['contact_number_two'])){
            $this->db->where('party.contact_number_two', $filter['contact_number_two']);
        }
        if(!empty($filter['party_address'])){
            $likeCriteria = "(party.party_address  LIKE '%" . $filter['party_address'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['party_gst'])){
            $this->db->where('party.party_gst', $filter['party_gst']);
        }
        if(!empty($filter['state_code'])){
            $this->db->where('party.party_state_code', $filter['state_code']);
        }
        $this->db->where('party.is_deleted', 0);
        $this->db->limit($filter['page'], $filter['segment']);
        $this->db->order_by('party.row_id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllPartyDetailsCount($filter=''){
        $this->db->from('tbl_party_info as party'); 
        if(!empty($filter['party_name'])){
            $likeCriteria = "(party.party_name  LIKE '%" . $filter['party_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['email'])){
            $likeCriteria = "(party.email  LIKE '%" . $filter['email'] . "%')";
            $this->db->where($likeCriteria);
        }
         
        if(!empty($filter['contact_number_one'])){
            $this->db->where('party.contact_number_one', $filter['contact_number_one']);
        }
        if(!empty($filter['contact_number_two'])){
            $this->db->where('party.contact_number_two', $filter['contact_number_two']);
        }
        if(!empty($filter['party_address'])){
            $likeCriteria = "(party.party_address  LIKE '%" . $filter['party_address'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['party_gst'])){
            $this->db->where('party.party_gst', $filter['party_gst']);
        }
        if(!empty($filter['state_code'])){
            $this->db->where('party.party_state_code', $filter['state_code']);
        }
        $this->db->where('party.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function updatePartyInfo($info,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_party_info', $info);
        return TRUE;
    }
        /**
     * This function is used to add new party to system
     */
    function addParty($partyInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_party_info', $partyInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    function updatePurchaseOrderInfo($info,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_purchase_info', $info);
        return TRUE;
    }
    function updatePurchaseOrderInfoDetails($info,$row_id){
        $this->db->where('bill_row_id', $row_id);
        $this->db->update('tbl_purchase_order_details', $info);
        return TRUE;
    }
    /**
     * This function is used to get  party information by row_id
     */
    function getPartyInfoById($row_id){
        $this->db->select('party.row_id,party.party_name,party.party_address,party.email,party.contact_number_one, party.contact_number_two,party.party_gst,party.party_state_code');
        $this->db->from('tbl_party_info as party');
        $this->db->where('party.row_id', $row_id);
        $this->db->where('party.is_deleted', 0);
        $query = $this->db->get();
        return $query->row();
    }

        /**
     * This function is used to get  all partys
     */
    function getAllParty(){
        $this->db->from('tbl_party_info as party');
        $this->db->where('party.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    function addPurchaseDetailToDB($billDetailInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_purchase_order_details', $billDetailInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    function addPurchaseOrderToDB($billInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_purchase_info', $billInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }
    function updateLock($info,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_purchase_info', $info);
        return TRUE;
    }
    function updateUnlock($info,$row_id){
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_purchase_info', $info);
        return TRUE;
    }
    public function getAllPurchaseOrderInfo($filter, $page, $segment){
        $this->db->select('purchase.row_id,purchase.date,party.party_name,purchase.bill_no,purchase.product,purchase.total_amount,purchase.due_date,purchase.status,purchase.created_by');
        $this->db->from('tbl_purchase_info as purchase'); 
        $this->db->join('tbl_party_info as party', 'party.row_id = purchase.party_row_id','left');
        if(!empty($filter['party_name'])){
            $likeCriteria = "(party.party_name  LIKE '%" . $filter['party_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['date'])){
            $this->db->where('purchase.date', $filter['date']);
        }
        if(!empty($filter['due_date'])){
            $this->db->where('purchase.due_date', $filter['due_date']);
        }
        if(!empty($filter['total_amount'])){
            $this->db->where('purchase.total_amount', $filter['total_amount']);
        }
        if(!empty($filter['PO_NO'])){
            $this->db->where('purchase.row_id', $filter['PO_NO']);
        }
        if(!empty($filter['created_by'])){
            $this->db->where('purchase.created_by', $filter['created_by']);
        }
        if(!empty($filter['staff_id'])){
            $this->db->where('purchase.created_by', $filter['staff_id']);
        } 
        $this->db->where('purchase.is_deleted', 0);
        $this->db->where('party.is_deleted', 0);
        $this->db->limit($filter['page'], $filter['segment']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllPurchaseOrderCount($filter=''){
        $this->db->select('purchase.row_id,purchase.date,party.party_name,purchase.bill_no,purchase.product,purchase.total_amount,purchase.due_date,purchase.created_by');
        $this->db->from('tbl_purchase_info as purchase'); 
        $this->db->join('tbl_party_info as party', 'party.row_id = purchase.party_row_id','left');
        if(!empty($filter['party_name'])){
            $likeCriteria = "(party.party_name  LIKE '%" . $filter['party_name'] . "%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($filter['date'])){
            $this->db->where('purchase.date', $filter['date']);
        }
        if(!empty($filter['due_date'])){
            $this->db->where('purchase.due_date', $filter['due_date']);
        }
        if(!empty($filter['total_amount'])){
            $this->db->where('purchase.total_amount', $filter['total_amount']);
        }
        if(!empty($filter['PO_NO'])){
            $this->db->where('purchase.row_id', $filter['PO_NO']);
        }
        if(!empty($filter['created_by'])){
            $this->db->where('purchase.created_by', $filter['created_by']);
        }
        if(!empty($filter['staff_id'])){
            $this->db->where('purchase.created_by', $filter['staff_id']);
        } 
        $this->db->where('purchase.is_deleted', 0);
        $this->db->where('party.is_deleted', 0);
        $query = $this->db->get();
        return $query->num_rows();
    }




    function updateBill($row_id,$billInfo)
    {
        $this->db->where('row_id', $row_id);
        $this->db->update('tbl_billing_info', $billInfo);
        return TRUE;
    }

    function getBillInfoById($row_id){
        $this->db->select('bill.row_id,bill.date,bill.party_row_id,party.party_name,party.party_address,party.party_gst,party.contact_number_one,
        party.party_state_code,bill.bill_no,bill.ref_no,bill.product,bill.total_amount,bill.due_date,bill.terms_conditions');
        $this->db->from('tbl_purchase_info as bill');
        $this->db->join('tbl_party_info as party','party.row_id = bill.party_row_id','left');
        $this->db->where('bill.row_id',$row_id);
        $this->db->where('bill.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();        
        return $result;
    }
    

    function getBillDetailsById($row_id){
        //$this->db->select('bill.row_id,bill.date,party.party_name,bill.bill_no,bill.ref_no,bill.product');
        $this->db->from('tbl_purchase_order_details as bill');
        $this->db->join('tbl_gst_info as gst','gst.id = bill.gst','left');
        $this->db->join('tbl_unit_info as unit','unit.row_id  = bill.unit','left');
        $this->db->where('bill.bill_row_id',$row_id);
        $this->db->where('bill.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    function deletePurchaseDetails($row_id){
        $this->db->where('bill_row_id',$row_id);
        $this->db->delete('tbl_purchase_order_details');
        return true;
    }

    function addBillPayment($payInfo){
        $this->db->trans_start();
        $this->db->insert('tbl_bill_amount_paid_info', $payInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function getBillInfoByPartyId($row_id){
        $this->db->select('bill.row_id,bill.date,bill.bill_no,bill.ref_no,bill.product,bill.total_amount');
        $this->db->from('tbl_billing_info as bill');
        //$this->db->join('tbl_party_info as party','party.row_id = bill.party_row_id','left');
        $this->db->where('bill.party_row_id',$row_id);
        $this->db->where('bill.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    function getBillPaidInfoByPartyId($row_id){
        $this->db->select('paid.trans_date,paid.paid_amount,paid.payment_type,bill.bill_no');
        $this->db->from('tbl_bill_amount_paid_info as paid');
        $this->db->join('tbl_billing_info as bill','bill.row_id = paid.bill_row_id','left');
        $this->db->where('bill.party_row_id',$row_id);
        $this->db->where('bill.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    function getBillTotalByPartyId($row_id){
        $this->db->select_sum('total_amount');
        $this->db->from('tbl_billing_info as bill');
        $this->db->where('bill.party_row_id',$row_id);
        $this->db->where('bill.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();        
        return $result->total_amount;
    }

    function getBillPaidTotalByPartyId($row_id){
        $this->db->select_sum('paid_amount');
        $this->db->from('tbl_bill_amount_paid_info as paid');
        $this->db->join('tbl_billing_info as bill','bill.row_id = paid.bill_row_id','left');
        $this->db->where('bill.party_row_id',$row_id);
        $this->db->where('bill.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->row();        
        return $result->paid_amount;
    }

    function getAllUnitInfo(){
        $this->db->from('tbl_unit_info as unit');
        $this->db->where('unit.is_deleted', 0);
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }

    function addUnitInfo($UnitInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_unit_info', $UnitInfo);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function getAllGSTInfo(){
        $this->db->from('tbl_gst_info as unit');
        $query = $this->db->get();
        $result = $query->result();        
        return $result;
    }
}