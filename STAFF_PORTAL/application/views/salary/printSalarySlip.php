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



.table_bordered {

    border-collapse: collapse;

}

.table_bordered th,
.table_bordered td {

    border-top: 1px solid black;

    border-right: 1px solid black;

    padding: 3px;

}



.table_bordered th .border_right_none,
.table_bordered td .border_right_none {

    border-right: 1px solid transparent !important;

}
</style>

<?php 
    // require APPPATH . 'views/includes/db.php';
    $totalStaffCount = count($staffData);
    foreach($staffData as $std){

        $totalStaffCount--;

?>

<div class="container border_full">

    <div class="row">

        <table class="table text_highlight mt-2" style="">
            <tr>
                <td style="text-align:center;" width="20%">
                        <img  class="mt-5" width="90" height="80" src="<?php echo INSTITUTION_LOGO; ?>" alt="logo">
                </td>
                    
                <td width="80%" >
                    <br />
                    <b style="font-size: 17px;margin-bottom: 2px;text-align:center;"><?php echo TITLE; ?></b><br />
                    <!-- <b style="font-size: 17px;margin-bottom: 2px;text-align:center;">&emsp;University Road, Deralakatte, Mangalore - 575018</b></p> -->
                    <br /><span style="font-size: 17px;margin-bottom: 2px;"><b>&emsp;&emsp;&emsp;&emsp;&emsp;Salary Slip for the Month
                            <?php echo $std->month ?> - <?php echo $std->year ?></b></b>
                    </span><br />
                    <br />

                </td>
            </tr>
        </table><br />

        <table class="table" style="font-size: 16px;">
            <tr>
                <td width="15%">Emp ID</td>
                <td width="1%">: </td>
                <td width="29%"><span><?php echo $std->staff_id ?></td>
                <td width="20%">Employee Name</span></td>
                <td width="1%">: </td>
                <td width="34%"><span><?php echo strtoupper($std->name) ?></td>
            </tr>
        </table>
        <table class="table" style="font-size: 16px;">
            <tr>
                <td width="15%">Paid Days</span></td>
                <td width="1%">: </td>
                <td width="29%"><?php echo strtoupper($std->working_day) ?></td>
                <td width="20%">Designation</td>
                <td width="1%">:</td>
                <td width="34%"><span><?php echo strtoupper($std->role) ?></td>
            </tr>
        </table>
        <table class="table" style="font-size: 16px;">
            <tr>
                <td width="15%">Department</td>
                <td width="1%">: </td>
                <td width="29%"><?php echo strtoupper($std->dept_name) ?></td>
                <td width="20%">Bank Acc No.</span></td>
                <td width="1%">: </td>
                <td width="34%"><?php echo strtoupper($std->account_no) ?></td>
            </tr>
        </table>
        <table class="table table_bordered" style="font-size: 13px;">
            <tr>
                <td style="border: none"></td>
            </tr>
            <tr>
                <th style="background-color:#bebebe">EARNINGS </th>
                <th width="120" style="background-color:#bebebe">RATE</th>
                <th width="120" style="background-color:#bebebe">AMOUNT</th>
                <th style="background-color:#bebebe">DEDUCTIONS</th>
                <th width="120" style="background-color:#bebebe">AMOUNT</th>
            </tr>
            <tr>
                <td style="text-align: left;">
                    BASIC<br />

                </td>
                <td style="text-align: left;">
                    <?php echo $std->basic ?><br />

                </td>
                <td style="text-align: left;">
                    <?php echo $std->basic ?><br />

                </td>
                <td style="text-align: left;">
                    PF<br />

                </td>
                <td style="text-align: left;">
                    <?php echo round($std->pf,2) ?><br />

                </td>
            </tr>
            <tr>
                <td style="text-align: left;">
                    DA<br />

                </td>
                <td style="text-align: left;">
                    <?php echo $std->da ?><br />

                </td>
                <td style="text-align: left;">
                    <?php echo $std->da ?><br />

                </td>
                <td style="text-align: left;">
                    PT<br />

                </td>
                <td style="text-align: left;">
                    <?php echo round($std->pt,2) ?><br />

                </td>
            </tr>
            <tr>
                <td style="text-align: left;">
                   HRA<br />

                </td>
                <td style="text-align: left;"><?php echo $std->hr ?><br /></td>
                <td style="text-align: left;"><?php echo $std->hr ?><br /></td>
                <td style="text-align: left;"> ESI <br /></td>
                <td style="text-align: left;"> <?php echo round($std->esi,2) ?><br /></td>
                <!-- <td style="text-align: left;"> CAUTIONAL <br /></td>
                <td style="text-align: left;"> <br /></td> -->
              
            </tr>
            <tr>
                <td style="text-align: left;">
                CONVEYANCE<br />

                </td>
                <td style="text-align: left;">
                    <?php echo $std->con ?><br />

                </td>
                <td style="text-align: left;">
                    <?php echo $std->con ?><br />

                </td>
               
                <td style="text-align: left;">
                <?php if($std->advance_salary!=0){ ?>
                    ADVANCE SALARY DEDUCTION <br />
                <?php } ?>
                </td>
                <td style="text-align: left;">
                <?php if($std->advance_salary!=0){ ?>
                    <?php echo $std->advance_salary ?><br />
                <?php } ?>
                </td>
            </tr>
            <?php if(!empty($std->ot_amount)) { ?>
            <tr>
                <td style="text-align: left;"> OT<br /></td>
                <td style="text-align: left;"><br /></td>
                <td style="text-align: left;"><?php echo $std->ot_amount ?><br /></td>
                <td style="text-align: left;"><br /></td>
                <td style="text-align: left;"> <br /></td>
            </tr>
            <?php } ?>
           
            <tr>
                <td style="text-align: left;border: 0.5px solid black;">
                </td>
                <?php $gross_salary = $std->basic + $std->con + $std->hr + $std->da + $std->ot_amount ?>
                <td style="text-align: left;border: 0.5px solid black;"></td>
                <td style="text-align: left;border: 0.5px solid black;"> <b> </b><br /> </td>
                <td style="text-align: left;border: 0.5px solid black;"> <b></b><br /></td>
                <td style="text-align: left;border: 0.5px solid black;"> <b></b><br /></td>
            </tr>

            <tr>
                
                <td style="text-align: left;border: 0.5px solid black;background-color:#bebebe">
                    <b>TOTAL</b><br />

                </td>
                <?php $gross_salary = $std->basic + $std->con + $std->hr + $std->da + $std->ot_amount ?>
                <td style="text-align: left;border: 0.5px solid black;background-color:#bebebe">
                    <b><?php echo $gross_salary ?></b> <br /></td>
                <td style="text-align: left;border: 0.5px solid black;background-color:#bebebe">
                    <b><?php echo $gross_salary ?></b> <br /></td>
                <td style="text-align: left;border: 0.5px solid black;background-color:#bebebe">
                    <b>TOTAL  </b><br />

                </td>
                <?php $deductions = $std->pf + $std->esi + $std->pt +  $std->advance_salary;  ?>
                <td style="text-align: left;border: 0.5px solid black;background-color:#bebebe">
                    <b><?php echo round($deductions,2) ?></b><br />

                </td>
            </tr>

            <tr>
                <td style="text-align: left;border: 0.5px solid black;background-color:#bebebe"></td>
                <td style="text-align: left;border: 0.5px solid black;background-color:#bebebe"></td>
                <td style="text-align: left;border: 0.5px solid black;background-color:#bebebe"></td>
                <td style="text-align: left;border: 0.5px solid black;background-color:#bebebe">
                    <b>NET PAY </b><br /></td>
                <?php $net_amount = $gross_salary - $deductions ?>
                <td style="text-align: left;border: 0.5px solid black;background-color:#bebebe">
                    <b><?php echo round($std->net_amount,2) ?></b><br />

                </td>
            </tr>
        </table>
       <br>
        <table class="table" style="font-size: 14px;">

            <tr>
                <td width="400"><b>In Words <?php echo getIndianCurrency(floatval($std->net_amount)).' only'; ?>
                </td>

            </tr>
        </table>
<br><br>
        <table class="table" style="font-size: 15px;">
            <tr>
                <td style="text-align: left;" width="85%"></td>
                <td style="text-align: left;" width="15%">Signature</td>
            </tr>
        </table>
 
        <br />

    </div>


</div>
<span  style="display: block; text-align: center;">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; This is a system generated payslip hence no  signature required</span>
<?php
        if($totalStaffCount != 0){
            echo '<div class="break"></div>';
        }else{
            echo '<div class="break_after"></div>';
        }

 } ?>
<?php 

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
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}

?>