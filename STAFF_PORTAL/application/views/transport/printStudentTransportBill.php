
<style>
table{
    width: 100% !important;
}

.border_full{
    border: 1px solid black;
    padding-top: 10px;
    padding-bottom: 10px; 
    margin-bottom: 5px; 
}


.border_bottom{
    border-bottom: 1px solid black;
}
.hr_line{
    margin: 5px 0px;
    color: black;
}

.table_bordered{
    border-collapse: collapse;
}
.table_bordered th,.table_bordered td{
    border-top: 1px solid black;
    border-right: 1px solid black;
    padding: 4px;
}

.table_bordered th .border_right_none,.table_bordered td .border_right_none{
    border-right: 1px solid transparent !important;
}

.centered-td {
        text-align: center !important;
}


</style>
  
<?php 
    if(!empty($feeConcession)){
        $concessionAmt = $feeConcession->fee_amt;
    }else{
        $concessionAmt = 0;
    }
    $transaction_id = '';

    if(!empty($studentTransportInfo->order_id)) {
    $transaction_id =  $studentTransportInfo->order_id;
    }
    if(!empty($studentTransportInfo->dd_number)) {
        $transaction_id =  $studentTransportInfo->dd_number;
    }
    if(!empty($studentTransportInfo->transaction_number)) {
        $transaction_id =  $studentTransportInfo->transaction_number;
     }
     if(!empty($studentTransportInfo->upi_ref_no)) {
        $transaction_id =  $studentTransportInfo->upi_ref_no;
     }
    
     
?>
<?php $copy_name = ['STUDENT COPY','OFFICE COPY','BUS COPY'] ?>

<div class="container-fluid border_full">
    <div class="row">
        <div class="">
            <table class="table text_highlight">
                <tr>
                    <td style="text-align:center;" width="80">
                        <img height="100" class="mt-2" width="70" height="70" src="<?php echo INSTITUTION_LOGO; ?>" alt="logo">
                    </td>
                    <td width="300" style="text-align:center;">
                        <b style="font-size: 15px;margin-bottom: 2px;"><?php echo  "ST XAVIER'S PRE–UNIVERSITY COLLEGE, KALABURAGI"; ?></b>
                       
                      
                    </td>
                </tr>
            </table>
            <hr class="border_bottom hr_line">
            <table class="table" style="font-size: 12px;">
            <?php// if($studentTransportInfo->intake_year == CURRENT_YEAR) { ?>
                <tr>
                    <td class="centered-td">Fee Receipt (<?php echo $copy_name[$name_count]; ?>)</td>
                </tr>
                <?php //}else{ ?>
                <!-- <tr>
                    <td class="centered-td">Arrear Fee Receipt (<?php echo $copy_name[$name_count]; ?>)</td>
                </tr> -->
            <?php //} ?>
                </table>
            <table class="table" style="font-size: 12px;">
                <tr>
                    <td>Receipt No.: <span style="color: red;"><?php echo $studentTransportInfo->ref_receipt_no; ?></span></td>
                </tr>
               
                <tr>
                    <td>Name of the student : <?php echo strtoupper($studentTransportInfo->student_name); ?></td>
                </tr>
              
                <?php if(!empty($studentTransportInfo->father_name)){ ?>
                <tr>
                    <td>Name of the father : <?php echo strtoupper($studentTransportInfo->father_name); ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td>Student ID : <?php echo $studentTransportInfo->student_id;?></td>
                </tr>
                <tr>
                    <td>Class  : <?php echo strtoupper($studentTransportInfo->term_name); ?></td> 
                </tr>
                    <tr>
                        <td>Month From: <?php echo date('M-Y',strtotime($studentTransportInfo->from_date));?></td>
                    </tr>
                    <tr>
                        <td>Month To: <?php echo date('M-Y',strtotime($studentTransportInfo->to_date));?></td>
                    </tr>
               
                    <tr>
                        <td>Bus No. : <?php echo $studentTransportInfo->bus_no;?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Bus Pick Point : <?php echo $studentTransportInfo->route_name;?></td>
                    </tr>
                <tr>
                    <td colspan="2">Date : <?php echo date('d-m-Y',strtotime($studentTransportInfo->created_date_time)); ?></td>
                </tr>   
                <tr>
                    <td colspan="2">Payment Type : <?php echo $studentTransportInfo->payment_type; ?></td>
                </tr>
                
                <tr>
                    <?php if($studentTransportInfo->payment_type != "CASH"){ ?>
                    <td>Transaction Id : <?php echo $transaction_id; ?></td>
                    <?php } ?>
                </tr>
                   <!-- </tr> -->
                  <?php if(!empty($neftInfo)) { ?> 
                <tr>
                    <td colspan="2">Neft No.: <?php echo  $neftInfo->neft_number; ?></td>
                </tr>
               <?php } ?>

                 <?php if(!empty($chequeInfo)) { ?> 
                <tr>
                    <td colspan="2">Check No.: <?php echo  $chequeInfo->check_number; ?></td>
                </tr>
               <?php } ?>

                <?php if(!empty($cardInfo)) { ?> 
                <tr>
                    <td colspan="2">Transaction No.: <?php echo  $cardInfo->transaction_number; ?></td>
                </tr>
               <?php } ?>
               <?php if(!empty($challanInfo)) { ?> 
                <tr>
                    <td colspan="2">challan No.: <?php echo  $challanInfo->challan_number; ?></td>
                </tr>
               <?php } ?>
            </table>
            <table class="table table_bordered" style="font-size: 13px;">
                <tr>
                    <th>Particulars</th>
                    <th width="120">Amount</th>
                </tr> 
                <tr>
                    <td style="text-align: center;">TRANSPORT FEE&nbsp;
                    <!-- From: <?php //echo date('d-m-Y',strtotime($studentTransportInfo->from_date)); ?>&nbsp;
                    To: <?php //echo date('d-m-Y',strtotime($studentTransportInfo->to_date)); ?> -->
                    </td>
                     <?php  $transport_rate = $studentTransportInfo->bus_fees; ?>
                    <td style="text-align: center;"><?php echo sprintf('%0.2f', $transport_rate); ?></td>
                </tr>
                <tr>
                    <th>Grand Total</th>
                    <th style="text-align: center;"><?php echo sprintf('%0.2f', $transport_rate); ?></th>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 13px;"><b>Amount in words: <span style="text-transform: capitalize;"><?php echo $transport_rate_words.' only'; ?></span></b></td>
                </tr>
            </table>
            

        </div>
    </div>
    
</div>

</div>
<b style="font-size: 10px;">All fees paid are not transferable or refundable.</b><br/>
<b style="font-size: 10px;">This is an online generated fee Receipt no seal and signature is required.</b>

<?php 
//  if($totalStudentCount != 0){
//     echo '<div class="break"></div>';
// }else{
//     echo '<div class="break_after"></div>';
// }

// } 





?>