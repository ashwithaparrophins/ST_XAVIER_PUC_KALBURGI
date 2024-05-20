<style>
.break {
    page-break-before: always;
}

.break_after {
    page-break-before: none;
}



table {

    width: 100% !important;

}



/*.border{

    border: 2px solid black;

}*/

.border_full {

    border: 1px solid black;

    /* height: 90% !important; */

}

.border_bottom {

    border-bottom: 1px solid black;

}

.hr_line {

    margin: 0px;

    color: black;

}

.table_bordered3{
    border-collapse: collapse;
}
.table_bordered3 th,.table_bordered3 td{
    border-top: 1px solid black;
    border-right: 1px solid black;
    border-left: 1px solid black;
    border-bottom: 1px solid black;
    padding: 10px;
}

.table_bordered3 th .border_right_none,.table_bordered td .border_right_none{
    border-right: 1px solid transparent !important;
}

.table_bordered {

    border-collapse: collapse;

}

.table_bordered th,
.table_bordered td {

    border-top: 1px solid black;
    border-bottom: 1px solid black;
    /* border-right: 1px solid black; */

    padding: 3px;

}
.table_bordered th .border_right_none,
.table_bordered td .border_right_none {

    border-right: 1px solid transparent !important;

}
.table_bordered1 th,
.table_bordered1 td {

    /* border-top: 1px solid black; */

    /* border-right: 1px solid black; */

    padding: 3px;

}


.table_bordered1 th .border_right_none,
.table_bordered1 td .border_right_none {

    border-right: 1px solid transparent !important;

}
.page-break {
            page-break-before: always;
        }
</style>

<?php 
    // // require APPPATH . 'views/includes/db.php';
    // $totalStaffCount = count($staffData);
    // foreach($staffData as $std){

    //     $totalStaffCount--;

?>

<div class="container ">

    <div class="row">

        <table class="table text_highlight" style="background-color:#495057;">
            <tr>
                <td style="text-align:center;" width="20%">
                        <img  class="mt-1" width="90" height="80" src="<?php echo INSTITUTION_LOGO; ?>" alt="logo">
                </td>
                    
                <td width="80%" style="text-align:right;">
                  
                    <b style="font-size: 18px;margin-bottom: 2px;text-align:right;color: white;"><?php echo TITLE; ?></b><br />
                    <!-- <p style="font-size: 15px;margin-bottom: 2px;text-align:right;color: white;">Pandithahalli, Dasanadoddi Post,</p>
                    <p style="font-size: 15px;margin-bottom: 2px;text-align:right;color: white;">B.G. Pura Hobli, Malavalli, Mandya District – 571430</p> -->
                    <!-- <br /><span style="font-size: 18px;margin-bottom: 2px;text-align:center;"><b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;PURCHASE ORDER</b></b> -->
                    </span>

                </td>
            </tr>
        </table><br />
        <table class="table text_highlight" >
            <tr>
                <td width="100%" style="font-size: 15px;margin-bottom: 2px;text-align:center; color: #495057;"><b>PURCHASE ORDER</b></td>
                </td>
            </tr>
        </table>
        <!-- <table class="table table_bordered" style="font-size: 13px;">
            <tr>
                <td style="border: none"></td>
            </tr>
            <tr>
                <th style="text-align: left;background-color:#bebebe; height: 50px;" width="34%">PO NO. : <?php echo strtoupper($PurchaseOrderInfo->row_id); ?></th>
                <th style="text-align: left;background-color:#bebebe; height: 50px;" width="34%">PO DATE :  <?php echo date('d-m-Y',strtotime($PurchaseOrderInfo->date)); ?></th>
                <th style="text-align: left;background-color:#bebebe; height: 50px;" width="32%">DUE DATE : <?php echo date('d-m-Y',strtotime($PurchaseOrderInfo->due_date)); ?></th>
            </tr>
        </table> -->
        <table class="table table_bordered1" style="font-size: 13px;">
        
            <tr>
               
                <td style="font-size: 15px;margin-bottom: 2px;text-align:left;" width="50%"></td>
                    <table class="table table_bordered1" style="font-size: 12px;">
                        <tr>
                            <td style="font-size: 15px;margin-bottom: 2px;text-align:left;background-color:#495057;color: white;"><b>Order To</b></td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;margin-bottom: 2px;text-align:left;"><b><?php echo strtoupper($PurchaseOrderInfo->party_name); ?></b></td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;margin-bottom: 2px;text-align:left;"><b><?php echo strtoupper($PurchaseOrderInfo->party_address); ?></b></td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;margin-bottom: 2px;text-align:left;"><b>Contact No. : <?php echo strtoupper($PurchaseOrderInfo->contact_number_one); ?></b></td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;margin-bottom: 2px;text-align:left;"><b>GSTIN : <?php echo strtoupper($PurchaseOrderInfo->party_gst); ?></b></td>
                        </tr>
                    </table>
                </td>
                <td style="font-size: 15px;margin-bottom: 2px;text-align:left;" width="50%"></td>
                    <table class="table table_bordered1" style="font-size: 12px;">
                        <tr>
                            <td style="font-size: 12px;margin-bottom: 2px;text-align:right;color: #495057;"><b>Order No. : <?php echo strtoupper($PurchaseOrderInfo->row_id); ?></b></td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;margin-bottom: 2px;text-align:right;color: #495057;"><b>Date : <?php echo date('d-m-Y',strtotime($PurchaseOrderInfo->date)); ?></b></td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;margin-bottom: 2px;text-align:right;color: #495057;"><b>Due Date : <?php echo date('d-m-Y',strtotime($PurchaseOrderInfo->due_date)); ?></b></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="table table_bordered3" style="font-size: 12px;">
            <tr>
                <th style="text-align: center;background-color:#495057;  height: 38px;color: white;" width="5%">#</th>
                <th style="text-align: left;background-color:#495057;  height: 38px;color: white;" width="30%">ITEM NAME</th>
                <th style="text-align: center;background-color:#495057;  height: 38px;color: white;" width="10%">QUANTITY  </th>
                <th style="text-align: left;background-color:#495057;  height: 38px;color: white;" width="10%">UNIT</th>
                <th style="text-align: left;background-color:#495057;  height: 38px;color: white;" width="15%">PRICE/UNIT	</th>
                <th style="text-align: left;background-color:#495057;  height: 38px;color: white;" width="15%">GST</th>
                <th style="text-align: right;background-color:#495057;  height: 38px;color: white;" width="15%">AMOUNT</th>
            </tr>
       
            <tr>
            <?php $i=1; 
            $quantity =0;
                foreach($PurchaseOrderDetailInfo as $info){
                    $amount = $info->qty * $info->rate; 
                    $gstamount = ($amount*$info->percentage)/100;
                    $total = $amount + $gstamount?>
                 <tr>
                    <td style="text-align: center;" width="5%"><?php echo $i++; ?></td>
                    <td style="text-align: left;" width="30%"><?php echo strtoupper($info->item);?></td>
                    <td style="text-align: center;" width="10%"><?php echo $info->qty;?></td>
                    <td style="text-align: left;" width="10%"><?php echo $info->short_name;?></td>
                    <td style="text-align: left;" width="15%">&#8377; <?php echo custom_format_number($info->rate);?></td>
                    <td style="text-align: left;" width="15%">&#8377; <?php echo custom_format_number($gstamount);?> (<?php echo $info->percentage;?>%)</td>
                    <td style="text-align: right;" width="15%">&#8377; <?php echo custom_format_number($total) ;?></td>
                    <?php  $quantity += $info->qty;
                    $gst_total += ($amount*$info->percentage)/100;
                    $grand_total += $total;
                    $total_amount += $amount ;
                    ?>
                </tr>
            <?php } ?> 
       
            <tr>
                <th style="text-align: left; height: 38px;" width="5%"></th>
                <td style="text-align: left;" width="30%"><b>TOTAL</td>
                <th style="text-align: center; height: 38px;" width="10%"><b><?php echo $quantity?></b></th>
                <td style="text-align: left;" width="15%"></td>
                <th style="text-align: center; height: 38px;" width="10%"></th>
                <th style="text-align: left; height: 38px;font-size: 11px;" width="15%"><b>&#8377; <?php echo custom_round_format_number($gst_total)?></b></th>
                <th style="text-align: right; height: 38px;font-size: 11px;" width="15%"><b> &#8377; <?php echo custom_round_format_number($grand_total);?></b></th>
            </tr>
        </table><br>

        <div class="page-break"></div>
        <table class="table text_highlight" style="background-color:#495057;">
            <tr>
                <td style="text-align:center;" width="20%">
                        <img  class="mt-1" width="90" height="80" src="<?php echo INSTITUTION_LOGO; ?>" alt="logo">
                </td>
                    
                <td width="80%" style="text-align:right;">
                    
                    <b style="font-size: 18px;margin-bottom: 2px;text-align:right;color: white;"><?php echo TITLE; ?></b><br />
                    <!-- <p style="font-size: 15px;margin-bottom: 2px;text-align:right;color: white;">Pandithahalli, Dasanadoddi Post,</p>
                    <p style="font-size: 15px;margin-bottom: 2px;text-align:right;color: white;">B.G. Pura Hobli, Malavalli, Mandya District – 571430</p> -->
                    <!-- <p style="font-size: 15px;text-align:right;color: white;">Phone no.: 08022214416 Email: principal@sjbhs.edu.in</p> -->
                    <!-- <br /><span style="font-size: 18px;margin-bottom: 2px;text-align:center;"><b>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;PURCHASE ORDER</b></b> -->
                    </span>
                    <br />

                </td>
            </tr>
        </table><br />
        <table class="table table_bordered1" style="font-size: 13px;" >

        <tr>

            <td style="font-size: 15px;margin-bottom: 2px;text-align:left;vertical-align: top;" width="60%"></td>
                <table class="table table_bordered1" style="font-size: 13px;background-color:#495057;color: white;">
                    <tr>
                        <td style="font-size: 15px;margin-bottom: 2px;text-align:left;" width="20"><b>Tax Type</b></td>
                        <td style="font-size: 15px;margin-bottom: 2px;text-align:left;" width="20"><b>Taxable Amount</b></td>
                        <td style="font-size: 15px;margin-bottom: 2px;text-align:left;" width="10"><b>Rate</b></td>
                        <td style="font-size: 15px;margin-bottom: 2px;text-align:right;" width="10"><b>Tax amount</b></td>
                    </tr>
                    </table>
                    <table class="table table_bordered1" style="font-size: 13px;">
                    <?php
                        foreach($PurchaseOrderDetailInfo as $info){?>
                    <?php  
                    $sub_amount = $info->qty * $info->rate;
                    $firstThreeDigits = substr($info->name, 0, 3);
                    if($firstThreeDigits=='IGS'){?>  
                    <tr>
                       
                        <td style="font-size: 13px;margin-bottom: 2px;text-align:left;" width="20">IGST</td>
                        <td style="font-size: 13px;margin-bottom: 2px;text-align:left;" width="20">&#8377; <?php echo custom_format_number($sub_amount); ?></td>
                        <td style="font-size: 13px;margin-bottom: 2px;text-align:left;" width="10"><?php echo $info->percentage; ?>%</td>
                        <td style="font-size: 13px;margin-bottom: 2px;text-align:right;" width="10">&#8377; <?php echo custom_format_number(round((($sub_amount)*$info->percentage)/100,2)); ?></td>
                    </tr>
                    <?php } 
                    if($firstThreeDigits=='GST'){
                        $GST= ($info->percentage)/2?>  
                    <tr>
                        <td style="font-size: 13px;margin-bottom: 2px;text-align:left;" width="20">SGST</td>
                        <td style="font-size: 13px;margin-bottom: 2px;text-align:left;" width="20">&#8377; <?php echo custom_format_number($sub_amount); ?></td>
                        <td style="font-size: 13px;margin-bottom: 2px;text-align:left;" width="10"><?php echo $GST; ?>%</td>
                        <td style="font-size: 13px;margin-bottom: 2px;text-align:right;" width="10">&#8377; <?php echo custom_format_number(round((($sub_amount)*$GST)/100,2)); ?></td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px;margin-bottom: 2px;text-align:left;" width="20">CGST</td>
                        <td style="font-size: 13px;margin-bottom: 2px;text-align:left;" width="20">&#8377; <?php echo custom_format_number(($sub_amount),2); ?></td>
                        <td style="font-size: 13px;margin-bottom: 2px;text-align:left;" width="10"><?php echo $GST; ?>%</td>
                        <td style="font-size: 13px;margin-bottom: 2px;text-align:right;" width="10">&#8377; <?php echo custom_format_number(round((($sub_amount)*$GST)/100,2)); ?></td>
                    </tr>
                    <?php } ?>
                    <?php } ?> 
                </table>
                <table class="table table_bordered1" style="font-size: 13px;">
                    <tr>
                        <td style="font-size: 15px;margin-bottom: 2px;text-align:left;background-color:#495057;color: white;" ><b>Order Amount In Words</b></td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px;margin-bottom: 2px;text-align:left;" ><?php echo getIndianCurrency(floatval($PurchaseOrderInfo->total_amount)).' only'; ?></td>
                    </tr><br>
                    
                </table>
                
            </td>
          
            <td style="font-size: 15px; margin-bottom: 2px; text-align: left; vertical-align: top;" width="40%"></td>
                <table class="table table_bordered1" style="font-size: 13px;">
                    <tr>
                        <td style="font-size: 15px;margin-bottom: 2px;text-align:left;background-color:#495057;color: white;" width="100%"><b>Amounts:</b></td>
                    
                    </tr>
                </table>
                <table class="table table_bordered1" style="font-size: 13px;">
                <tr>
                    <td style="font-size: 15px;margin-bottom: 2px;text-align:left;height: 45px;" width="40">Sub Total</td>
                    <td style="text-align: right;height: 38px;" width="10"><b>&#8377; <?php echo custom_format_number($grand_total);?></b></td>
                    <!-- <td style="font-size: 15px;margin-bottom: 2px;text-align:right;" width="10"><?php echo custom_format_number($total_amount); ?></td> -->
                </tr>
                </table>
                <table class="table table_bordered" style="font-size: 13px;">
                    <tr>
                <td style="text-align: left;height: 38px;" ><b>TOTAL</b></td>
                <td style="text-align: right;height: 38px;" ><b>&#8377; <?php echo custom_round_format_number($grand_total);?></b></td>
                </tr>
                </table>

            </td>

            </tr>

        </table>
        <table class="table table_bordered1" style="font-size: 13px; width: 100%; margin-top: 0px;">
    <tr>
        <td style="font-size: 15px; margin-bottom: 2px; text-align: left; background-color: #495057; color: white;"><b>Terms and Conditions</b></td>
    </tr>
    <tr>
        <td style="font-size: 12px; margin-bottom: 2px; text-align: left; overflow: auto;">
            <?php 
            $dataFromTable = $PurchaseOrderInfo->terms_conditions;
            // Convert newline characters to HTML line breaks
            $formattedText = nl2br($dataFromTable);
            echo $formattedText; 
            ?>
        </td> 
    </tr>
</table>










        <table class="table " style="font-size: 13px;">
            <tr>
                <td style="text-align: left;height: 38px;" width="60%" ></td>
                <td style="text-align: left;height: 38px;" width="40%" >For, : ST. JOSEPH SCHOOL</td>
            </tr>
        </table><br><br>
        <table class="table " style="font-size: 14px;">
            <tr>
                <td style="text-align: left;height: 38px;" width="60%" >Received And Accepted By</td>
                <td style="text-align: left;height: 38px;text-align:center;" width="40%" >Authorized Signatory</td>
            </tr>
        </table>
        <!-- <table class="table_bordered1">
            <tr>
            <td style="font-size: 15px;margin-bottom: 2px;text-align:left;" width="60%"></td>
                <table class="table table_bordered" style="font-size: 13px;">
                    <tr>
                </tr>
                </table>
                </td>
                <td style="font-size: 15px;margin-bottom: 2px;text-align:left;" width="40%"></td>
                <table class="table table_bordered" style="font-size: 13px;">
                    <tr>
                <td style="text-align: left;background-color:#bebebe;  height: 38px;" ><b>TOTAL</b></td>
                <td style="text-align: right;background-color:#bebebe;  height: 38px;" ><b><?php echo number_format($grand_total,2);?></b></td>
                </tr>
                </table>
                </td>
                </tr>
        </table> -->
        <!-- <?php if(!empty($PurchaseOrderInfo->terms_conditions)){ ?>
        <table class="table_bordered1">
            <tr>
                <td width="100%">TERMS AND CONDITIONS</td>
            </tr>
            <tr>
                <td width="100%"><?php 
                $dataFromTable =$PurchaseOrderInfo->terms_conditions;
                $dataWithLineBreaks = nl2br($dataFromTable); ?>
                 <?php echo $dataWithLineBreaks; ?></td>
            </tr>
        </table>
        <?php } ?> -->
       
       
 
       

    </div>


</div>
<?php
//         if($totalStaffCount != 0){
//             echo '<div class="break"></div>';
//         }else{
//             echo '<div class="break_after"></div>';
//         }

//  } ?>
<?php 


/* function getFamilyInfo($con,$application_no){
    $query = "SELECT family.relation_type,family.name,family.application_no FROM tbl_student_family_info as family
    WHERE family.application_no = '$application_no' AND family.is_deleted = 0";
    $result = $con->prepare($query); 
    $result->execute(); 
    return $result->fetchAll();
} */

function custom_format_number($number) {
    $formatted_number = number_format($number, 2, '.', ''); // Remove decimal point temporarily
    $parts = explode('.', $formatted_number);

    $whole_number = $parts[0];
    $length = strlen($whole_number);

    $formatted_whole_number = '';

    $last_three_digits = substr($whole_number, -3); // Extract last three digits
    $rest_of_number = substr($whole_number, 0, -3); // Extract the rest of the number

    while (strlen($rest_of_number) > 0) {
        $group = substr($rest_of_number, -2); // Get the last two digits
        if (!empty($formatted_whole_number)) {
            $formatted_whole_number = ',' . $formatted_whole_number;
        }
        $formatted_whole_number = $group . $formatted_whole_number;
        $rest_of_number = substr($rest_of_number, 0, -2); // Remove the last two digits
    }

    if (!empty($formatted_whole_number)) {
        $formatted_whole_number = $rest_of_number . $formatted_whole_number . ',' . $last_three_digits;
    } else {
        $formatted_whole_number = $whole_number;
    }

    $formatted_number = $formatted_whole_number . '.' . $parts[1]; // Combine with decimal part

    return $formatted_number;
}

function custom_round_format_number($number) {
    $rounded_number = round($number); // Round off the number
    $formatted_number = number_format($rounded_number, 2, '.', ''); // Format the rounded number
    $parts = explode('.', $formatted_number);

    $whole_number = $parts[0];
    $length = strlen($whole_number);

    $formatted_whole_number = '';

    $last_three_digits = substr($whole_number, -3); // Extract last three digits
    $rest_of_number = substr($whole_number, 0, -3); // Extract the rest of the number

    while (strlen($rest_of_number) > 0) {
        $group = substr($rest_of_number, -2); // Get the last two digits
        if (!empty($formatted_whole_number)) {
            $formatted_whole_number = ',' . $formatted_whole_number;
        }
        $formatted_whole_number = $group . $formatted_whole_number;
        $rest_of_number = substr($rest_of_number, 0, -2); // Remove the last two digits
    }

    if (!empty($formatted_whole_number)) {
        $formatted_whole_number = $rest_of_number . $formatted_whole_number . ',' . $last_three_digits;
    } else {
        $formatted_whole_number = $whole_number;
    }

    $formatted_number = $formatted_whole_number . '.' . $parts[1]; // Combine with decimal part

    return $formatted_number;
}


function getIndianCurrency(float $number) {
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? '' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? " - " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}

?>