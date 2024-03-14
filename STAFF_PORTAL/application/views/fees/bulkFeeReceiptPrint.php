
<style>
table{
    width: 100% !important;
}

.break { page-break-before: always; } 
.break_after { page-break-before: none; } 


/*.border{
    border: 2px solid black;
}*/
.border_full{
    border: 1px solid black;
    /* height: 100% !important; */
    padding-top: 2px;
    padding-bottom: 5px;
    /* height: 90% !important; */
    
}
.fill_content{
    height: 90% !important;
}
.border_bottom{
    border-bottom: 1px solid black;
}
.hr_line{
    margin: 1px 0px;
    color: black;
}

.table_bordered{
    border-collapse: collapse;
}
.table_bordered th,{
    border-top: 1px solid black;
    border-right: 1px solid black;
    padding: 3px;
}
.table_bordered td{
    border-top: 1px solid black;
   
}

.table_bordered th .border_right_none,.table_bordered td .border_right_none{
    border-right: 1px solid transparent !important;
}

.centered-td {
        text-align: center !important;
}

</style>



<?php 
// if (!empty($paidInfo)) {
//     foreach ($paidInfo as $studentInfo) {

        $filter['fee_year'] = CURRENT_YEAR;
        $filter['stream_name'] = $studentInfo->stream_name;
        $filter['term_name'] = $studentInfo->term_name;
       
        $feeStructureInfo = $feeModel->getFeeStructureInfo($filter);
        $concession = $feeModel->getSumFeeConcessionInfoForReport($feeInfo->application_no,$feeInfo->payment_year,$feeInfo->created_date_time);
        $concessionFee = $concession->fee_amt;
        $scholarship = $feeModel->getSumFeeScholarshipInfoForReport($feeInfo->application_no,$feeInfo->payment_year,$feeInfo->created_date_time);
        $scholarshipFee = $scholarship->fee_amt;
        $paidFeeSum = $feeModel->getSumOfFeesPaidForReceipt($feeInfo->application_no,$feeInfo->payment_year,$feeInfo->created_date_time);

        $copy_name = ['STUDENT COPY','OFFICE COPY'] ?>
        <?php //for($r=0;$r<2;$r++){ ?>
<div class="fill_content">
<div class="container-fluid border_full ">
    <div class="row">
    
        <div class="">
        
            <table class="table text_highlight">
                <tr>
                    <td style="text-align:center;" width="80">
                        <img class="mt-2" width="50" height="50" src="<?php echo INSTITUTION_LOGO; ?>" alt="logo">
                    </td>
                    
                    
                    <td width="200" style="text-align:center;">
                    
                        <b style="font-size: 13px;margin-bottom: 1px;"><?php echo TITLE; ?></b><br/>
                        <!-- <b style="font-size: 13px;margin-bottom: 2px;">Unit of KJES </b><br/>
                        <b style="font-size: 12px;margin-bottom: 2px;"># 23, Vittal Mallya Road, Bengaluru - 560001</b><br/> -->
                        <!-- <b style="font-size: 12px;margin-bottom: 2px;">Bengaluru – 560 001</b><br/> -->
                    </td>
                </tr>
            </table>
            <hr class="border_bottom hr_line">
            <table class="table" style="font-size: 10px;">
                <tr>
                    <td class="centered-td">Fee Receipt (<?php echo $copy_name[$name_count]; ?>)</td>
                </tr>
                </table>
                <table class="table" style="font-size: 12px;">
                <tr>
                    <td width="50%">Name of the student : <?php echo strtoupper($studentInfo->student_name); ?></td>
                    <td>Application/Register no. : <?php if(!empty($studentInfo->register_number) && $studentInfo->term_name == 'II PUC'){ echo $studentInfo->register_number; }else{ echo $studentInfo->application_no; } ?></td>
                </tr>
                <tr>
                    <?php if(!empty($studentInfo->father_name)){ ?>
                    <td>Name of the father : <?php echo $studentInfo->father_name; ?></td>
                    <?php } ?>
                    <td>Receipt no.: <?php echo $studentInfo->ref_receipt_no; ?></td>
                    
                </tr>
                <tr>
                    <td width="300">Class & Section : <?php echo strtoupper($studentInfo->term_name.' '.$studentInfo->section_name); ?></td>
                    <td>Payment Received Date : <?php echo date('d-m-Y',strtotime($studentInfo->payment_date)); ?></td>
                </tr>
                <tr>
                    
                    <td >Payment Received Mode : <?php if(!empty($feeInfo->payment_type)){ echo $feeInfo->payment_type; }else{ echo 'Online'; } ?></td>
                </tr>
            </table>
            <table class="table table_bordered" style="font-size: 12px;">
                <tr>
                    <!-- <th width="100">Sl.No.</th> -->
                    <th>Particulars</th>
                    <th>Amount</th>
                </tr> 
                <?php if(!empty($feeStructureInfo) && (empty($previousFeePaidInfo))) {
                    $i=1; $total_fee_amt=0;
                    foreach($feeStructureInfo as $fee){ 
                        if($fee->fees_type != 'College Dept Fee' && $fee->fees_type != 'Eligibility Fee'){
                        $total_fee_amt +=  $fee->fee_amount_state_board;
                ?>
                     <tr>
                        <!-- <th style="text-align:center;"><?php echo $i; ?></th> -->
                        <th style="text-align: left;"><?php echo strtoupper($fee->fees_type); ?></th>
                        <th style="text-align: right;"><?php echo number_format($fee->fee_amount_state_board,2); ?></th>
                    </tr>
                   
                <?php $i++; }else{
                    $dept_fee = $fee->fee_amount_state_board;
                } } } ?>  
                <?php  foreach($feeStructureInfo as $fee){ 
                        if($fee->fees_type != 'College Dept Fee' && $fee->fees_type != 'Eligibility Fee'){
                        $total_fee +=  $fee->fee_amount_state_board; ?>
                <?php $i++; }}
                if($feeInfo->attempt == "1") {
                    $total_fee_amt = $total_fee_amt - 2000;
                    } else {
                    $total_fee_amt = $feeInfo->total_amount;
                }
                
               ?>
                <tr>
                    <th style="text-align: left;" colspan="1">Total Fee</th>
                    <th class="border_right_none" style="text-align: right;"><?php if($feeInfo->attempt == "1"){ echo number_format($total_fee_amt - 2000,2);} else {
                    echo number_format($studentInfo->total_amount,2);
                    }; ?></th>
                </tr>
                <?php if($fee_concession != 0){ ?>
                <tr>
                    <th style="text-align: left;" colspan="1">Fee Concession(-)</th>
                    <th class="border_right_none" style="text-align: right;"><?php echo number_format($fee_concession,2); ?></th>
                </tr>
                <?php } ?>
                <tr>
                    <th style="text-align: left;" colspan="1">Amount Paid</th>
                    <th class="border_right_none" style="text-align: right;"><?php if($feeInfo->payment_count == 1){ $paidAmt = $studentInfo->paid_amount; }else{ $paidAmt =$studentInfo->paid_amount; } echo number_format($paidAmt,2); ?></th>
                </tr>
                <?php if($feeInfo->attempt == "1") {?>
                    <tr>
                        <th style="text-align: left;" colspan="1">Amount Pending</th>
                        <th class="border_right_none" style="text-align: right;"><?php echo number_format($total_fee_amt - $paidFeeSum->paid_amount - $concessionFee - $scholarshipFee,2); ?></th>
                    </tr>
                <?php }else{ ?>
                    <tr>
                        <th style="text-align: left;" colspan="1">Amount Pending</th>
                        <th class="border_right_none" style="text-align: right;"><?php echo number_format($total_fee - $paidFeeSum->paid_amount - $concessionFee - $scholarshipFee,2); ?></th>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="2"><b>Paid total amount in word: <span style="text-transform: capitalize;"><?php echo $paid_amount_words.' ONLY'; ?></span></b></td>
                </tr>   
            </table>

        </div>
    </div>
</div>

<b style="font-size: 10px;">All fees paid are not transferable or refundable.</b><br/>
<b style="font-size: 10px;">This is an online generated fee Receipt no seal and signature is required.</b>
</div>
<br><br><br><br><br><br><br><br><br><br>


<?php //}} ?>



