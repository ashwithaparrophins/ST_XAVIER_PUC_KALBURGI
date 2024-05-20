<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseControllerFaculty.php';
require_once 'vendor/autoload.php';

class PurchaseOrder  extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PurchaseOrder_model','PurchaseOrder');
        // $this->load->model('party_model','party');
        // $this->load->model('bank_model');
        $this->isLoggedIn();   
    }
    function PartyDetails()
    {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $filter = array();
            $party_name = $this->security->xss_clean($this->input->post('party_name'));
            $email = $this->security->xss_clean($this->input->post('email'));
            $contact_number_one = $this->security->xss_clean($this->input->post('contact_number_one'));
            $contact_number_two = $this->security->xss_clean($this->input->post('contact_number_two'));
            $party_address = $this->security->xss_clean($this->input->post('party_address'));
            $party_gst = $this->security->xss_clean($this->input->post('party_gst'));
            $state_code = $this->security->xss_clean($this->input->post('state_code'));

            $data['party_name'] = $party_name;
            $data['email'] = $email;
            $data['contact_number_one'] = $contact_number_one;
            $data['contact_number_two'] = $contact_number_two;
            $data['party_address'] = $party_address;
            $data['party_gst'] = $party_gst;
            $data['state_code'] = $state_code;
            
            $filter['state_code'] = $state_code;
            $filter['party_gst'] = $party_gst;
            $filter['party_name'] = $party_name;
            $filter['email'] = $email;
            $filter['contact_number_one'] = $contact_number_one;
            $filter['contact_number_two'] = $contact_number_two;
            $filter['party_address'] = $party_address;

            $this->load->library('pagination');
            $count = $this->PurchaseOrder->getAllPartyDetailsCount($filter);
            $returns = $this->paginationCompress("PurchaseOrderListing/", $count, 100);
            $data['totalSalaryCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            // $data['staffInfo'] = $this->staff->getStaffDetails($filter);
            $data['PartyInfo'] = $this->PurchaseOrder->getAllPartyDetailsInfo($filter, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Purchase Order Details';
            $this->loadViews("PurchaseOrder/partyDetails", $this->global, $data, NULL);

        }
    }
    /**
     * This function is used to add new party to the system
     */
    function addParty()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
                $party_name = ucwords(strtolower($this->security->xss_clean($this->input->post('party_name'))));
                $party_address =  $this->security->xss_clean($this->input->post('party_address'));
                $email = strtolower($this->security->xss_clean( $this->security->xss_clean($this->input->post('email'))));
                $contact_number_one = $this->security->xss_clean($this->input->post('contact_number_one'));
                $contact_number_two = $this->security->xss_clean($this->input->post('contact_number_two'));
                $gst =$this->security->xss_clean($this->input->post('gst'));
                $state_code =$this->security->xss_clean($this->input->post('state_code'));
                $partyInfo = array(
                    'party_name'=>$party_name,
                    'party_address'=>$party_address,
                    'email'=>$email,
                    'contact_number_one'=>$contact_number_one,
                    'contact_number_two'=>$contact_number_two,
                    'party_state_code'=>$state_code,
                    'party_gst'=>$gst,           
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                $result = $this->PurchaseOrder->addParty($partyInfo);
                if($result > 0){
                    $this->session->set_flashdata('success', 'New party created successfully');
                } else{
                    $this->session->set_flashdata('error', 'party creation failed');
                }
                
                redirect('PartyDetails');
            }
        
    }
    public function deleteParty(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $info = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id,
            );
            $result = $this->PurchaseOrder->updatePartyInfo($info, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function deleteGatePass(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $info = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id,
            );
            $result = $this->PurchaseOrder->updatePurchaseOrderInfo($info, $row_id);
            $result = $this->PurchaseOrder->updatePurchaseOrderInfoDetails($info, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }

    public function deletePurchaseOrder(){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        } else {   
            $row_id = $this->input->post('row_id');
            $info = array('is_deleted' => 1,
            'updated_date_time' => date('Y-m-d H:i:s'),
            'updated_by' => $this->staff_id,
            );
            $result = $this->PurchaseOrder->updatePurchaseOrderInfo($info, $row_id);
            $result = $this->PurchaseOrder->updatePurchaseOrderInfoDetails($info, $row_id);
            if ($result == true) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        } 
    }
        /**
     * This function is used load party edit information
     */
    function editParty($row_id = NULL)
    {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            if($row_id == null){
                redirect('PartyDetails');
            }
            $data['partyInfo'] = $this->PurchaseOrder->getPartyInfoById($row_id);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Party Details';
            $this->loadViews("PurchaseOrder/editParty", $this->global, $data, NULL);
        }
    }

        /**
     * This function is used to edit the party information
     */
    function updateParty()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else { 
            $row_id = $this->input->post('row_id');
            $this->load->library('form_validation');
            $this->form_validation->set_rules('party_name','party Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('party_address','party Address','required');
            $this->form_validation->set_rules('contact_number_one','Contact Number','required|max_length[10]');
            if($this->form_validation->run() == FALSE)
            {
                $this->editParty($row_id);
            }else {
                $party_name = ucwords(strtolower($this->security->xss_clean($this->input->post('party_name'))));
                $party_address = $this->input->post('party_address');
                $email = strtolower($this->security->xss_clean($this->input->post('email')));
                $contact_number_one =$this->input->post('contact_number_one');
                $contact_number_two =$this->input->post('contact_number_two');
                $gst =$this->input->post('gst');
                $state_code =$this->input->post('state_code');
                $partyInfo = array('party_name'=>$party_name,
                'party_address'=>$party_address,
                'email'=>$email,
                'contact_number_one'=>$contact_number_one,
                'contact_number_two'=>$contact_number_two, 
                'party_gst'=>$gst,
                'party_state_code'=>$state_code,           
                'updated_date_time'=>date('Y-m-d H:i:s'));
                $result = $this->PurchaseOrder->updatePartyInfo($partyInfo,$row_id);
                if($result > 0){
                    $this->session->set_flashdata('success', 'Party updated successfully');
                }
                else{
                    $this->session->set_flashdata('error', 'Party update failed');
                }
                redirect('editParty/'.$row_id);
            }
        }
    }
    public function addNewPurchaseOrder(){
        $data['partyInfo'] = $this->PurchaseOrder->getAllParty();
        $data['UnitInfo'] = $this->PurchaseOrder->getAllUnitInfo();
        $data['GSTInfo'] = $this->PurchaseOrder->getAllGSTInfo();
        $this->global['pageTitle'] = ''.TAB_TITLE.' :Add New Purchase Order Details ';
        $this->loadViews("PurchaseOrder/newPurchaseOrder", $this->global, $data, NULL);
    }

    
    public function addPurchaseOrderToDB(){
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
                $party_row_id = $this->security->xss_clean($this->input->post('party_row_id'));
                $party_gst = $this->security->xss_clean($this->input->post('party_gst'));
                $party_state_code = $this->security->xss_clean($this->input->post('party_state_code'));
                $date = $this->security->xss_clean($this->input->post('date'));
                $due_date = $this->security->xss_clean($this->input->post('due_date'));
                $bill_no = $this->security->xss_clean($this->input->post('bill_no'));
                $ref_no = $this->security->xss_clean($this->input->post('ref_no'));
                $product = $this->security->xss_clean($this->input->post('product'));
                $totalAmount = $this->security->xss_clean($this->input->post('totalAmount'));
                $terms_conditions = $this->security->xss_clean($this->input->post('terms_conditions'));
                $trans_date = $this->security->xss_clean($this->input->post('trans_date'));
                $item = $this->security->xss_clean($this->input->post('item'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $invoice = $this->security->xss_clean($this->input->post('invoice'));
                $destination = $this->security->xss_clean($this->input->post('destination'));
                $rate = $this->security->xss_clean($this->input->post('rate'));
                $qty = $this->security->xss_clean($this->input->post('qty'));
                $amount = $this->security->xss_clean($this->input->post('amount'));
                $gstamount = $this->security->xss_clean($this->input->post('gstamount'));
                $gst = $this->security->xss_clean($this->input->post('gst'));
                $unit = $this->security->xss_clean($this->input->post('unit'));


                $billInfo = array(
                    'date'=>date('Y-m-d',strtotime($date)),
                    'due_date'=>date('Y-m-d',strtotime($due_date)),
                    'party_row_id'=>$party_row_id,
                    'party_gst'=>$party_gst,
                    'party_state_code'=>$party_state_code,
                    'bill_no'=>$bill_no,
                    'ref_no' => $ref_no,
                    'product' => $product,
                    'terms_conditions'=>$terms_conditions,
                    'total_amount' => $totalAmount,
                    'created_by'=>$this->staff_id,
                    'created_date_time'=>date('Y-m-d H:i:s'));
                $return_id = $this->PurchaseOrder->addPurchaseOrderToDB($billInfo);
                if($return_id > 0){
                    for ($i = 0; $i < count($item); $i++) {
                        $value = $gst[$i]; // Access the corresponding value from the $gst array
                        
                        $gstData = explode('|', $value);
                        $id = $gstData[0];
                    
                        $billDetailInfo = array(
                            'bill_row_id' => $return_id,
                            'item' => $item[$i],
                            'gstamount' => $gstamount[$i],
                            'gst' => $id,
                            'rate' => $rate[$i],
                            'qty' => $qty[$i],
                            'unit' => $unit[$i],
                            'amount' => $amount[$i],
                            'created_by' => $this->staff_id,
                            'created_date_time' => date('Y-m-d H:i:s')
                        );
                    
                        $result = $this->PurchaseOrder->addPurchaseDetailToDB($billDetailInfo);
                    }
                    
                } else{
                    $this->session->set_flashdata('error', 'Purchase Order adding failed');
                }
                if($result > 0){
                    $this->session->set_flashdata('success', 'Purchase Order added successfully');
                } else{
                    $this->session->set_flashdata('error', 'Purchase Order adding failed');
                }   
                redirect('PurchaseOrderListing');
            }
    }
    function PurchaseOrderListing()
    {
        if($this->isAdmin() == TRUE ){
            $this->loadThis();
        } else {
            $filter = array();
            $date = $this->security->xss_clean($this->input->post('date'));
            $due_date = $this->security->xss_clean($this->input->post('due_date'));
            $total_amount = $this->security->xss_clean($this->input->post('total_amount'));
            $party_name = ucwords(strtolower($this->security->xss_clean($this->input->post('party_name'))));
            $PO_NO = $this->security->xss_clean($this->input->post('PO_NO'));
            $created_by = $this->security->xss_clean($this->input->post('created_by'));

            $data['party_name'] = $party_name;
            $data['total_amount'] = $total_amount;
            $data['PO_NO'] = $PO_NO;
            $data['created_by'] = $created_by;
            
            $filter['PO_NO'] = $PO_NO;
            $filter['party_name'] = $party_name;
            $filter['total_amount'] = $total_amount;
            $filter['created_by'] = $created_by;
            

            if(!empty($date)){
                $filter['date'] = date('Y-m-d',strtotime($date));
                $data['date'] = date('d-m-Y',strtotime($date));
            }else{
                $data['date'] = '';
                $filter['date'] = '';
            }
            if(!empty($due_date)){
                $filter['due_date'] = date('Y-m-d',strtotime($due_date));
                $data['due_date'] = date('d-m-Y',strtotime($due_date));
            }else{
                $data['due_date'] = '';
                $filter['due_date'] = '';
            }
            //listing their cretaed purchase order
            if($this->staff_id == "208"  || $this->staff_id == "207" ){
                $filter['staff_id'] = $this->staff_id;
            }
            
            $this->load->library('pagination');
            $count = $this->PurchaseOrder->getAllPurchaseOrderCount($filter);
            $returns = $this->paginationCompress("PurchaseOrderListing/", $count, 100);
            $data['totalSalaryCount'] = $count;
            $filter['page'] = $returns["page"];
            $filter['segment'] = $returns["segment"];
            $data['OrderInfo'] = $this->PurchaseOrder->getAllPurchaseOrderInfo($filter, $returns["page"], $returns["segment"]);
            $this->global['pageTitle'] = ''.TAB_TITLE.' : Purchase Order Details';
            $this->loadViews("PurchaseOrder/PurchaseOrderListing", $this->global, $data, NULL);

        }
    }

    public function viewPrintPurchaseOrder($row_id = null){
        if($this->isAdmin() == TRUE){
            $this->loadThis();
        }else{
            error_reporting(0);
            $filter = array();
            $row_id = $row_id;

            $this->global['pageTitle'] = ''.TAB_TITLE.' : Purchase Order';
            $data['PurchaseOrderInfo'] = $this->PurchaseOrder->getBillInfoById($row_id);
            $data['PurchaseOrderDetailInfo'] = $this->PurchaseOrder->getBillDetailsById($row_id);
            define('_MPDF_TTFONTPATH', __DIR__ . '/fonts');
            $mpdf = new \Mpdf\Mpdf(['tempDir' => sys_get_temp_dir().DIRECTORY_SEPARATOR.'mpdf','format' => 'A4-L']);
            $mpdf->AddPage('P','','','','',13,13,8,8,8,8);
            $mpdf->SetTitle('Purchase Order');
            $html = $this->load->view('PurchaseOrder/printPurchaseOrder',$data,true);
            $mpdf->WriteHTML($html);
            $mpdf->Output('Purchase_Order.pdf', 'I');
        }
    }
    //edit bill page
    function editPurchaseOrder($row_id = NULL)
    {
        if($this->isAdmin() == TRUE) {
            $this->loadThis();
        } else {
            if($row_id == null){
                redirect('PurchaseOrderListing');
            }
            $data['partyInfo'] = $this->PurchaseOrder->getAllParty();
            $data['billInfo'] = $this->PurchaseOrder->getBillInfoById($row_id);
            $data['UnitInfo'] = $this->PurchaseOrder->getAllUnitInfo();
            $data['GSTInfo'] = $this->PurchaseOrder->getAllGSTInfo();

            $data['billDetailInfo'] = $this->PurchaseOrder->getBillDetailsById($row_id);
            $this->global['pageTitle'] = ''.TAB_TITLE.'  : Edit Purchase Order ';
            $this->loadViews("PurchaseOrder/editPurchaseOrder", $this->global, $data, NULL);
        }
    }
    // public function viewPrintPurchaseOrder($row_id){
    //     if ($this->isAdmin() == true) {
    //         $this->loadThis();
    //     } else {
    //         if ($row_id == null) {
    //             redirect('PurchaseOrderListing');
    //         }
    //         $data['billInfo'] = $this->PurchaseOrder->getBillInfoById($row_id);
    //         $data['billDetailInfo'] = $this->PurchaseOrder->getBillDetailsById($row_id);
    //         $this->global['pageTitle'] = $this->company_name.' :View Bill';
    //         $this->loadViews("PurchaseOrder/printBill", $this->global, $data, NULL);
    //     }
    // }

    public function deleteBill()
    {
        if ($this->isAdmin() == true) {
            echo (json_encode(array('status' => 'access')));
        } else {
            $row_id = $this->input->post('row_id');
            $billInfo = array('is_deleted' => 1, 'updated_by' => $this->employee_id, 'updated_date_time' => date('Y-m-d H:i:s'));
            $result = $this->bill->updateBill($row_id,$billInfo);
            if ($result > 0) {echo (json_encode(array('status' => true)));} else {echo (json_encode(array('status' => false)));}
        }
    }


    
    /**
     * This function is used to change the bill information
     */
    function updatePurchaseOrder()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else { 
            $this->load->library('form_validation');
            $this->form_validation->set_rules('party_row_id','Party','trim|required|max_length[128]');
            $this->form_validation->set_rules('date','Date','trim|required');
            if($this->form_validation->run() == FALSE)
            {
                $this->editPurchaseOrder($row_id);
            }else {
                $row_id = $this->input->post('row_id');
                $party_row_id = $this->security->xss_clean($this->input->post('party_row_id'));
                $party_gst = $this->security->xss_clean($this->input->post('party_gst'));
                $party_state_code = $this->security->xss_clean($this->input->post('party_state_code'));
                $date = $this->security->xss_clean($this->input->post('date'));
                $due_date = $this->security->xss_clean($this->input->post('due_date'));
                $bill_no = $this->security->xss_clean($this->input->post('bill_no'));
                $ref_no = $this->security->xss_clean($this->input->post('ref_no'));
                $product = $this->security->xss_clean($this->input->post('product'));
                $totalAmount = $this->security->xss_clean($this->input->post('totalAmount'));
                $terms_conditions = $this->security->xss_clean($this->input->post('terms_conditions'));
                $trans_date = $this->security->xss_clean($this->input->post('trans_date'));
                $item = $this->security->xss_clean($this->input->post('item'));
                $description = $this->security->xss_clean($this->input->post('description'));
                $rate = $this->security->xss_clean($this->input->post('rate'));
                $qty = $this->security->xss_clean($this->input->post('qty'));
                $amount = $this->security->xss_clean($this->input->post('amount'));
                $gstamount = $this->security->xss_clean($this->input->post('gstamount'));
                $gst = $this->security->xss_clean($this->input->post('gst'));
                $unit = $this->security->xss_clean($this->input->post('unit'));

                $PurchaseInfo = array(
                    'date'=>date('Y-m-d',strtotime($date)),
                    'due_date'=>date('Y-m-d',strtotime($due_date)),
                    'party_row_id'=>$party_row_id,
                    'party_gst'=>$party_gst,
                    'party_state_code'=>$party_state_code,
                    'product' => $product,
                    'terms_conditions'=>$terms_conditions,
                    'total_amount' => $totalAmount,
                    'updated_by'=>$this->staff_id, 
                    'updated_date_time'=>date('Y-m-d H:i:s'));
                $return = $this->PurchaseOrder->updatePurchaseOrderInfo($PurchaseInfo,$row_id);
                if($return > 0){
                    $deleted = $this->PurchaseOrder->deletePurchaseDetails($row_id);
                    if($deleted){
                        for($i=0;$i<count($item);$i++){
                            $value = $gst[$i]; // Access the corresponding value from the $gst array
                        
                            $gstData = explode('|', $value);
                            $id = $gstData[0];

                            $PurchaseDetailInfo = array(
                                'bill_row_id' => $row_id,
                                'item' => $item[$i],
                                'rate' => $rate[$i],
                                'qty' => $qty[$i],
                                'gstamount' => $gstamount[$i], 
                                'gst' => $id,
                                'unit'=>$unit[$i],
                                'amount' => $amount[$i],
                                'updated_by'=>$this->staff_id, 
                                'updated_date_time'=>date('Y-m-d H:i:s')
                            );
                            $result = $this->PurchaseOrder->addPurchaseDetailToDB($PurchaseDetailInfo);
                        }
                        $this->session->set_flashdata('success', 'Purchase Order updated successfully');

                    }else{
                        $this->session->set_flashdata('error', 'Purchase Order updation failed');
                    }
                }
                else{
                    $this->session->set_flashdata('error', 'Purchase Order update failed');
                }
                redirect('editPurchaseOrder/'.$row_id);
            }
        }
    }
    function addUnitInfo()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
                $unit_name =$this->security->xss_clean($this->input->post('unit_name'));
                $short_name = $this->security->xss_clean($this->input->post('short_name'));
              
                $UnitInfo = array(
                    'unit_name'=>$unit_name,
                    'short_name'=>$short_name,
                    'created_by'=>$this->staff_id,
                );
                $result = $this->PurchaseOrder->addUnitInfo($UnitInfo);
                if($result > 0){
                    $this->session->set_flashdata('success', 'Unit Added successfully');
                } else{
                    $this->session->set_flashdata('error', 'Unit failed');
                }
                
                redirect('addNewPurchaseOrder');
            }
        
    }
    function EditUnitInfo()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }  else {
                $unit_name = $this->security->xss_clean($this->input->post('unit_name'));
                $short_name = $this->security->xss_clean($this->input->post('short_name'));
              
                $UnitInfo = array(
                    'unit_name'=>$unit_name,
                    'short_name'=>$short_name,
                    'created_by'=>$this->staff_id,
                );
                $result = $this->PurchaseOrder->addUnitInfo($UnitInfo);
                if($result > 0){
                    $this->session->set_flashdata('success', 'Unit Added successfully');
                } else{
                    $this->session->set_flashdata('error', 'Unit failed');
                }
                
                redirect('addNewPurchaseOrder');
            }
        
    }
    function lock()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else { 
                $order_row_id = $this->input->post('order_row_id');
                $status = 'LOCKED';
             

            
                $partyInfo = array(
                    
                'status'=> $status,
                'updated_date_time'=>date('Y-m-d H:i:s'));
                $result = $this->PurchaseOrder->updateLock($partyInfo,$order_row_id);
              




                if($result > 0){
                    $this->session->set_flashdata('success', 'Locked successfully');
                }
                else{
                    $this->session->set_flashdata('error', 'Locking failed');
                }
                redirect('PurchaseOrderListing');
        }
    }
    function unlock()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }else { 
                $order_row_id2 = $this->input->post('order_row_id2');
                $status2 = '';
                log_message('debug','orderid'.$order_row_id2);

            
                $partyInfo = array(
                    
                'status'=> $status2,
                'updated_date_time'=>date('Y-m-d H:i:s'));
               
                $result = $this->PurchaseOrder->updateUnlock($partyInfo,$order_row_id2);
              
              




                if($result > 0){
                    $this->session->set_flashdata('success', 'UnLocked successfully');
                }
                else{
                    $this->session->set_flashdata('error', 'UnLocking failed');
                }
                redirect('PurchaseOrderListing');
        }
    }



}