
<?php require APPPATH . 'views/includes/db.php'; ?>
<style>
     .pag-title {
        font-size: 20.5px !important;
        color: black;
    }

    #myChart {
        height:300px; /* Adjust the height as needed */
        width: 100%; /* Optionally adjust the width */
        margin: 0 auto;
        align-items: center;
    }
</style>

<div class="main-content-container px-3">

    <!-- Page Header -->

    <div class="row mt-1 mb-1 ">

        <div class="col padding_left_right_null">

            <div class="card fee_heading_title card-small p-0">

                <div class="card-body p-2 ml-2">
                   <div class="row c-m-b">
                       <div class="col-lg-4 col-md-12 col-sm-6 box-tools p-1">
                           <span class="pag-title">
                               <i class="fas fa-money-bill"></i> Fee Dashboard / Overview
                           </span>
                       </div>
                       <!-- <div class="col-lg-8 col-md-12 col-sm-6">
                           <form action="<?php echo base_url() ?>viewFeeDashboard" method="POST" id="byFilterMethod" class="float-right">
                               <div class="input-group mobile-btn student_search">
                                   <select class="form-control selectpicker "  name="fee_year" id="fee_year">
                                       <?php if(!empty($fee_year)){ ?>
                                           <option value="<?php echo $fee_year; ?>" selected><b> <?php echo $fee_year; ?></b></option>
                                       <?php } ?>
                                       <option value="2024">2024</option>
                                       <option value="2023">2023</option>
                                       <option value="2022">2022</option>
                                   </select>                                  
                               </div>
                           </form>
                       </div> -->
                   </div>
                   
                </div>

            </div>

        </div>

    </div>

    <!-- End Page Header -->

    <!-- Small Stats Blocks -->


    <div class="row">

      

       
        <?php //if ($role == ROLE_SUPER_ADMIN) { ?>
        <!-- <div class="row">  -->
        <div class="col-md-6 col-12 mb-2">
            <div class="card">
                <div class="card-body p-1">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tr class="table-primary">
                                <th colspan="4" class="text-center text-dark" style="background-color:rgba(63, 167, 218, 0.91)">TOTAL COLLECTION
                                    <form role="form" action="<?php echo base_url() ?>viewFeeDashboard" method="post"
                                        role="form" class="form-inline">

                                        <div class="form-group text-dark">
                                            <label for="usr">From:</label>
                                            <input type="text" name="from_date"
                                                value="<?php echo date('d-m-Y',strtotime($from_date)); ?>"
                                                class="datepicker form-control" Placeholder="From Date"
                                                autocomplete="off" required>
                                        </div>
                                        <div class="form-group ml-2 text-dark">
                                            <label for="usr">To:</label><input type="text" name="to_date"
                                                value="<?php echo date('d-m-Y',strtotime($to_date)); ?>"
                                                class="datepicker form-control" Placeholder="To Date"
                                                autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-dark btn-sm"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                    </form>
                                </th>
                            </tr>
                            <tr class="table-success">
                                <th>Pay Type</th>
                                <th>Transaction Count</th>
                                <th>Amount</th>
                            </tr>
                            <?php 
                               $feeDDAmt = $feeDDCount = $feeCASHAmt = $deptFeeCARDCount = $feeONLINEAmt = $feeCASHCount = $feeONLINECount =$feeBANKCount = $deptFeeCASHCount = $deptFeeONLINECount= 0;
                               $feeCARDCount = $feeCARDAmt = $deptFeeDDAmt = $deptFeeUPICount = $deptFeeUPIAmt = $deptFeeBANKAmt = $deptFeeBANKCount= $deptFeeCASHCount = $deptFeeCASHAmt = $deptFeeONLINEAmt = $deptFeeCARDAmt = $deptFeeDDCount= $feeUPICount= $feeUPIAmt =$feeBANKAmt = 0;
                               $feeCashAmt += $fee->paid_amount;
                               $toatlFee = 0;
                               $toatlFeeCount = 0;
                               if(!empty($getFeePaidInfo)){
                                   foreach($getFeePaidInfo as $fee){
                                       $toatlFee += $fee->paid_amount;
                                       $toatlFeeCount++;
                                       if($fee->payment_type == 'CARD'){
                                           $feeCARDCount++;
                                           $feeCARDAmt += $fee->paid_amount;
                                       }else if($fee->payment_type == 'DD'){
                                           $feeDDCount++;
                                           $feeDDAmt += $fee->paid_amount;
                                       }else if($fee->payment_type == 'CASH'){
                                            $feeCASHCount++;
                                            $feeCASHAmt += $fee->paid_amount;
                                        }else if($fee->payment_type == 'UPI'){
                                           $feeUPICount++;
                                           $feeUPIAmt += $fee->paid_amount;
                                       }
                                       
                                   }
                               }
                              
                               ?>
                           
                            <tr>
                                <th class="text-bold">CASH</th>
                                <td class="text-bold"><?php echo number_format($feeCASHCount); ?></td>
                                <td class="text-bold"><?php echo number_format($feeCASHAmt,2); ?></td>
                            </tr>
                            <tr>
                                <th class="text-bold">UPI</th>
                                <td class="text-bold"><?php echo number_format($feeUPICount); ?></td>
                                <td class="text-bold"><?php echo number_format($feeUPIAmt,2); ?></td>
                            </tr>
                            <tr>
                               <th class="text-bold">DD</th>
                               <td class="text-bold"><?php echo number_format($feeDDCount); ?></td>
                               <td class="text-bold"><?php echo number_format($feeDDAmt,2); ?></td>
                           </tr> 
                           <tr>
                               <th class="text-bold">CARD</th>
                               <td class="text-bold"><?php echo number_format($feeCARDCount,); ?></td>
                               <td class="text-bold"><?php echo number_format($feeCARDAmt,2); ?></td>
                           </tr> 
                       
                            <tr class="table-success">
                               <th class="text-bold">TOTAL</th>
                               <td class="text-bold"><?=number_format($feeBANKCount + $feeONLINECount + $feeCASHCount + $feeUPICount + $feeDDCount + $feeCARDCount) ?></td>
                               <td class="text-bold"><?=number_format($feeONLINEAmt + $feeUPIAmt + $feeCASHAmt + $feeDDAmt +$feeBANKAmt + $feeCARDAmt,2) ?></td>
                           </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12 mb-2">
            <div class="card">
                <div class="card-body p-1">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tr class="table-primary">
                                <th colspan="4" class="text-center text-dark" style="background-color:rgba(63, 167, 218, 0.91)">TOTAL MISCELLANEOUS FEE COLLECTION
                                    <form role="form" action="<?php echo base_url() ?>viewFeeDashboard" method="post"
                                        role="form" class="form-inline">

                                        <div class="form-group text-dark">
                                            <label for="usr">From:</label>
                                            <input type="text" name="mis_from_date"
                                                value="<?php echo date('d-m-Y',strtotime($mis_from_date)); ?>"
                                                class="datepicker form-control" Placeholder="From Date"
                                                autocomplete="off" required>
                                        </div>
                                        <div class="form-group ml-2 text-dark">
                                            <label for="usr">To:</label><input type="text" name="mis_to_date"
                                                value="<?php echo date('d-m-Y',strtotime($mis_to_date)); ?>"
                                                class="datepicker form-control" Placeholder="To Date"
                                                autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-dark btn-sm"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                    </form>
                                </th>
                            </tr>
                            <tr class="table-success">
                                <th>Pay Type</th>
                                <th>Transaction Count</th>
                                <th>Amount</th>
                            </tr>
                            <?php 
                               $feeDDAmt = $feeDDCount = $feeCASHAmt = $feeONLINEAmt = $feeCASHCount = $feeONLINECount = 0;
                               $feeCARDCount = $feeCARDAmt = $feeUPICount= $feeUPIAmt = 0;
                               $feeCashAmt += $fee->amount;
                               $toatlFee = 0;
                               $toatlFeeCount = 0;
                               if(!empty($getMiscFeePaidInfo)){
                                   foreach($getMiscFeePaidInfo as $fee){
                                       $toatlFee += $fee->amount;
                                       $toatlFeeCount++;
                                     if($fee->payment_type == 'NEFT'){
                                           $feeNEFTCount++;
                                           if(empty($fee->qnty)){
                                                $totalNEFTamount =  $fee->amount;   
                                            }else {
                                                $totalNEFTamount = $fee->qnty * $fee->amount;
                                            }
                                           $feeNEFTAmt += $totalNEFTamount;
                                       }else if($fee->payment_type == 'CASH'){
                                           $feeCASHCount++;
                                           if(empty($fee->qnty)){
                                                $totalCASHamount =  $fee->amount;   
                                            }else {
                                                $totalCASHamount = $fee->qnty * $fee->amount;
                                            }
                                           $feeCASHAmt += $totalCASHamount;
                                       }else if($fee->payment_type == 'UPI'){
                                           $feeUPICount++;
                                           if(empty($fee->qnty)){
                                                $totalUPIamount =  $fee->amount;   
                                            }else {
                                                $totalUPIamount = $fee->qnty * $fee->amount;
                                            }
                                           $feeUPIAmt += $totalUPIamount;
                                       }
                                       
                                   }
                                   
                               }
                               ?>
                            <tr>
                                <th class="text-bold">UPI</th>
                                <td class="text-bold"><?php echo number_format($feeUPICount); ?></td>
                                <td class="text-bold"><?php echo number_format($feeUPIAmt,2); ?></td>
                            </tr>
                            <tr>
                               <th class="text-bold">CASH</th>
                               <td class="text-bold"><?php echo number_format($feeCASHCount); ?></td>
                               <td class="text-bold"><?php echo number_format($feeCASHAmt,2); ?></td>
                           </tr> 
                           <tr>
                               <th class="text-bold">NEFT</th>
                               <td class="text-bold"><?php echo number_format($feeNEFTCount); ?></td>
                               <td class="text-bold"><?php echo number_format($feeNEFTAmt,2); ?></td>
                           </tr> 
                            <tr class="table-success">
                               <th class="text-bold">TOTAL</th>
                               <td class="text-bold"><?=number_format($feeUPICount + $feeCASHCount + $feeNEFTCount) ?></td>
                               <td class="text-bold"><?=number_format($feeUPIAmt + $feeCASHAmt + $feeNEFTAmt,2) ?></td>
                           </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-12 mb-2 padding_left_right_null">
               <div class="card card-small">
                   <div class="card-header border-bottom fee_head_dashboard">
                       <h6 class="m-0 text-dark">Overall Fee Budget</h6>
                   </div>
                   <div class="card-body p-1">
                       
                       <div class="card card-small h-100">
                           <div class="card-body d-flex flex-column p-1">
                               <div class="row mx-0">
                                   <div class="col-lg-7 col-12 p-0 mt-0 table-responsive">
                                       <table class="table table-bordered text-dark mb-0">
                                       <tr class="table-success text-center">
                                           <th >Class</th>
                                           <th >Stream</th>
                                           <th>Total Fee</th>
                                           <th>Total Fee Collected</th>
                                           <th>Total Concession</th>
                                           <th>Total Scholarship</th>
                                           <th>Total Fee Pending</th>
                                       </tr>
                                       <?php 
                                           $totalStudentCount = 0;
                                           $totalStdFeeAmt = 0;
                                           $totalFeePaidCount = 0;
                                           $totalFeeConcessionCount= 0;
                                           $totalFeeScholarshipCount= 0;
                                           $totalFeePendingCount =0;
                                           for($i=0;$i<count($className);$i++){
                                                $class = $className[$i];
                                               for($j=0;$j<count($streamName);$j++){ 
                                                $stream = $streamName[$j];?>
                                           <tr>
                                                <th class="text-center" width="60"><?php echo $className[$i]; ?></th> 
                                               <th class="text-center"><?php echo $streamName[$j]; ?></th> 
                                               <?php //$totalStudentCount += $studentCount[$i];
                                                   $totalStdFeeAmt += $totalStdFee[$stream][$class]; 
                                                   $totalFeePaidCount += $feePaidCount[$stream][$class];
                                                   $totalFeeConcessionCount += $feeConcessionCount[$stream][$class];
                                                   $feeScholarshipCount += $feeScholarshipCount[$stream][$class];
                                                   $totalFeePendingCount += ($totalStdFee[$stream][$class] - ($feePaidCount[$stream][$class] + $feeConcessionCount[$stream][$class]));?>
                                               <!-- <th class="text-center"><?php //echo number_format($studentCount[$i]); ?> -->
                                               <th class="text-center"><?php  echo number_format($totalStdFee[$stream][$class]); ?></th>
                                               <th class="text-center"><?php echo number_format($feePaidCount[$stream][$class]); ?>
                                               <th class="text-center"><?php echo number_format($feeConcessionCount[$stream][$class]); ?>
                                               <th class="text-center"><?php echo number_format($feeScholarshipCount[$stream][$class]); ?>
                                               
                                               <th class="text-center"><?php echo number_format($totalStdFee[$stream][$class] - ($feePaidCount[$stream][$class] + $feeConcessionCount[$stream][$class]+ $feeScholarshipCount[$stream][$class])); ?></th>
                               
                                           
                                           </tr>
                                           <?php } }?>
                                           <tr class="table-success">
                                               <th colspan="2" class="text-center">Total</th>
                                               <th class="text-center"><?php echo number_format($totalStdFeeAmt); ?></th>
                                               <th class="text-center"><?php echo number_format($totalFeePaidCount); ?></th>
                                               <th class="text-center"><?php echo number_format($totalFeeConcessionCount); ?></th>
                                               <th class="text-center"><?php echo number_format($feeScholarshipCount); ?></th>
                                               <th class="text-center"><?php echo number_format($totalFeePendingCount); ?></th>
                                           </tr>
                                       </table>
                                   </div>
                                  
                                   <div class="col-lg-5">
                                    <!-- pie chart -->
                                    <canvas id="myChart"></canvas>
                                   </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>

               <div class="col-lg-12 col-md-12 col-12 mb-2 padding_left_right_null">
               <div class="card card-small">
                   <div class="card-header border-bottom fee_head_dashboard">
                       <h6 class="m-0 text-dark">Fee Cancel Receipt Log</h6>
                   </div>
                   <div class="card-body p-1">
                       
                       <div class="card card-small h-100">
                           <div class="card-body d-flex flex-column p-1">
                               <div class="row mx-0">
                                   <div class="col-lg-12 col-12 p-0 mt-0 table-responsive">
                                       <table class="table table-bordered text-dark mb-0">
                                       <tr class="table-success text-center">
                                           <th >Date</th>
                                           <th>Receipt No.</th>
                                           <th>Amount</th>
                                           <th>Payment Type</th>
                                           <th width="400">Reason</th>
                                       </tr>
                                       <?php 
                                          
                                          if(!empty($feePaidInfo)){
                                           foreach($feePaidInfo as $online){  ?>
                                           <tr>
                                               <th class="text-center"><?php echo date('d-m-Y',strtotime($online->payment_date)); ?></th> 
                                               <th class="text-center"><?php  echo $online->receipt_number; ?></th>
                                               <th class="text-center"><?php echo $online->paid_amount; ?>
                                               <th class="text-center"><?php echo $online->payment_type; ?>
                                               <th class="text-center" width="400"><?php echo $online->remarks; ?></th>
                                           </tr>
                                           <?php }} ?>
                                          
                                       </table>
                                   </div>
                                  
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           
        <!-- </div> -->
        <?php //} ?>

      







        <?php if ($role == ROLE_SUPER_ADMIN) { ?>


    </div>
    <?php } ?>






</div>


<?php 





function getTerm($term_name)
{
   $LKG = 'LKG';
   $UKG = 'UKG';
   $I = 1;
   $II = 2;
   $III = 3;
   $IV = 4;
   $V = 5;
   $VI = 6;
   $VII = 7;
   $VIII = 8;
   $IX = 9;
   $X = 10;
   switch ($term_name) {
       case "LKG":
           return $UKG;
           break;
       case "UKG":
           return $I;
           break;
       case "I":
           return  $II;
           break;
       case "II":
           return $III;
           break;
       case "III":
           return $IV;
           break;
       case "IV":
           return $V;
           break;
       case "V":
           return $VI;
           break;
       case "VI":
           return $VII;
           break;
       case "VII":
           return $VIII;
           break;
       case "VIII":
           return $IX;
           break;
       case "IX":
           return $X;
           break;
   }
}

function getTermValue($current_class)
{
   $LKG = 'LKG';
   $UKG = 'UKG';
   $I = 1;
   $II = 2;
   $III = 3;
   $IV = 4;
   $V = 5;
   $VI = 6;
   $VII = 7;

   switch ($current_class) {
       case "LKG":
           return $LKG;
           break;
       case "UKG":
           return $UKG;
           break;
       case "I":
           return  $I;
           break;
       case "II":
           return $II;
           break;
       case "III":
           return $III;
           break;
       case "IV":
           return $IV;
           break;
       case "V":
           return $V;
           break;
       case "VI":
           return $VI;
           break;
       case "VII":
           return $VII;
           break;
   }
}



?>


<script type="text/javascript">
var loader = '<img height="70" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';

document.addEventListener('DOMContentLoaded', function() {
var totalStdFeeAmt = <?php echo json_encode($totalStdFeeAmt); ?>;
var totalFeePaidCount = <?php echo json_encode($totalFeePaidCount); ?>;
var totalFeeConcessionCount = <?php echo json_encode($totalFeeConcessionCount); ?>;
var totalFeePendingCount = <?php echo json_encode($totalFeePendingCount); ?>;

var totalFeeCollected = totalFeePaidCount + totalFeeConcessionCount;
var percentageTotalFeeCollected = (totalFeeCollected / totalStdFeeAmt) * 100;
percentageTotalFeeCollected = parseFloat(percentageTotalFeeCollected).toFixed(2);

   Chart.types.Doughnut.extend({
       name: "DoughnutTextInside",
       showTooltip: function() {
           this.chart.ctx.save();
           Chart.types.Doughnut.prototype.showTooltip.apply(this, arguments);
           this.chart.ctx.restore();
       },
       draw: function() {
           Chart.types.Doughnut.prototype.draw.apply(this, arguments);

           var width = this.chart.width,
               height = this.chart.height;

           var fontSize = (height / 114).toFixed(2);
           this.chart.ctx.font = fontSize + "em Verdana";
           this.chart.ctx.textBaseline = "middle";

           var text = percentageTotalFeeCollected + "%",
               textX = Math.round((width - this.chart.ctx.measureText(text).width) / 2),
               textY = height / 2;

           this.chart.ctx.fillText(text, textX, textY);
       }
   });

   var data = [ {
       value: totalFeePaidCount,
       color: "#4caf50", // Green
       label: "Total Fee Paid"
   }, {
       value: totalFeeConcessionCount,
       color: "#ffeb3b", // Yellow
       label: "Total Fee Concession"
   }, {
       value: totalFeePendingCount,
       color: "#f44336", // Red
       label: "Total Fee Pending"
   }];


   var DoughnutTextInsideChart = new Chart($('#myChart')[0].getContext('2d')).DoughnutTextInside(data, {
       responsive: true
   });
   

});
jQuery(document).ready(function() {
   jQuery('.datepicker').datepicker({
           autoclose: true,
           orientation: "bottom",
           format: "dd-mm-yyyy"
       });
});
function autocomplete(inp, student_names, student_id) {

   /*the autocomplete function takes two arguments,

   the text field element and an array of possible autocompleted values:*/

   var currentFocus;

   /*execute a function when someone writes in the text field:*/

   inp.addEventListener("input", function(e) {

       var a, b, i, val = this.value;

       /*close any already open lists of autocompleted values*/

       closeAllLists();

       if (!val) {
           return false;
       }

       currentFocus = -1;

       /*create a DIV element that will contain the items (values):*/

       a = document.createElement("DIV");

       a.setAttribute("id", this.id + "autocomplete-list");

       a.setAttribute("class", "autocomplete-items");

       /*append the DIV element as a child of the autocomplete container:*/

       this.parentNode.appendChild(a);

       for (i = 0; i < student_names.length; i++) {

           /*check if the item starts with the same letters as the text field value:*/

           if (student_names[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {

               /*create a DIV element for each matching element:*/

               b = document.createElement("DIV");

               /*make the matching letters bold:*/

               b.innerHTML = "<strong>" + student_names[i].substr(0, val.length) + "</strong>";

               b.innerHTML += student_names[i].substr(val.length);

               /*insert a input field that will hold the current array item's value:*/

               b.innerHTML += "<input type='hidden' value='" + student_id[i] + "'>";

               /*execute a function when someone clicks on the item value (DIV element):*/

               b.addEventListener("click", function(e) {

                   /*insert the value for the autocomplete text field:*/

                   inp.value = this.getElementsByTagName("input")[0].value;

                   /*close the list of autocompleted values,

                   (or any other open lists of autocompleted values:*/

                   closeAllLists();

               });

               a.appendChild(b);

           }

       }

       /*for each item in the array...*/



   });

   /*execute a function presses a key on the keyboard:*/

   inp.addEventListener("keydown", function(e) {

       var x = document.getElementById(this.id + "autocomplete-list");

       if (x) x = x.getElementsByTagName("div");

       if (e.keyCode == 40) {

           /*If the arrow DOWN key is pressed,

           increase the currentFocus variable:*/

           currentFocus++;

           /*and and make the current item more visible:*/

           addActive(x);

       } else if (e.keyCode == 38) { //up

           /*If the arrow UP key is pressed,

           decrease the currentFocus variable:*/

           currentFocus--;

           /*and and make the current item more visible:*/

           addActive(x);

       } else if (e.keyCode == 13) {

           /*If the ENTER key is pressed, prevent the form from being submitted,*/

           e.preventDefault();

           if (currentFocus > -1) {

               /*and simulate a click on the "active" item:*/

               if (x) x[currentFocus].click();

           }

       }

   });

   function addActive(x) {

       /*a function to classify an item as "active":*/

       if (!x) return false;

       /*start by removing the "active" class on all items:*/

       removeActive(x);

       if (currentFocus >= x.length) currentFocus = 0;

       if (currentFocus < 0) currentFocus = (x.length - 1);

       /*add class "autocomplete-active":*/

       x[currentFocus].classList.add("autocomplete-active");

   }

   function removeActive(x) {

       /*a function to remove the "active" class from all autocomplete items:*/

       for (var i = 0; i < x.length; i++) {

           x[i].classList.remove("autocomplete-active");

       }

   }

   function closeAllLists(elmnt) {

       /*close all autocomplete lists in the document,

       except the one passed as an argument:*/

       var x = document.getElementsByClassName("autocomplete-items");

       for (var i = 0; i < x.length; i++) {

           if (elmnt != x[i] && elmnt != inp) {

               x[i].parentNode.removeChild(x[i]);

           }

       }

   }

   /*execute a function when someone clicks in the document:*/

   document.addEventListener("click", function(e) {

       closeAllLists(e.target);

   });

}

</script>

<script>
document.addEventListener('DOMContentLoaded', function() {

   document.getElementById('myform').addEventListener('submit', function(event) {
       // Show the loader when the form is submitted
       hideLoader();
   });
});
</script>
<script>
// Wait for the DOM to be fully loaded
document.addEventListener("DOMContentLoaded", function() {
   // Get the select element
   var selectElement = document.getElementById("fee_year");

   // Add an event listener for change event
   selectElement.addEventListener("change", function() {
       // Submit the form when the select value changes
       document.getElementById("byFilterMethod").submit();
       showLoader();
   });
});
</script>
