<style>
    body{
    color: #484b51;
}
.text-secondary-d1 {
    color: #728299!important;
}
.page-header {
    margin: 0 0 1rem;
    padding-bottom: 1rem;
    padding-top: .5rem;
    border-bottom: 1px dotted #e2e2e2;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-pack: justify;
    justify-content: space-between;
    -ms-flex-align: center;
    align-items: center;
}
.page-title {
    padding: 0;
    margin: 0;
    font-size: 1.75rem;
    font-weight: 300;
}
.brc-default-l1 {
    border-color: #dce9f0!important;
}

.ml-n1, .mx-n1 {
    margin-left: -.25rem!important;
}
.mr-n1, .mx-n1 {
    margin-right: -.25rem!important;
}
.mb-4, .my-4 {
    margin-bottom: 1.5rem!important;
}

hr {
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0,0,0,.1);
}

.text-grey-m2 {
    color: #888a8d!important;
}

.text-success-m2 {
    color: #86bd68!important;
}

.font-bolder, .text-600 {
    font-weight: 600!important;
}

.text-110 {
    font-size: 110%!important;
}
.text-blue {
    color: #478fcc!important;
}
.pb-25, .py-25 {
    padding-bottom: .75rem!important;
}

.pt-25, .py-25 {
    padding-top: .75rem!important;
}
.bgc-default-tp1 {
    background-color: rgba(121,169,197,.92)!important;
}
.bgc-default-l4, .bgc-h-default-l4:hover {
    background-color: #f3f8fa!important;
}
.page-header .page-tools {
    -ms-flex-item-align: end;
    align-self: flex-end;
}

.btn-light {
    color: #757984;
    background-color: #f5f6f9;
    border-color: #dddfe4;
}
.w-2 {
    width: 1rem;
}

.text-120 {
    font-size: 120%!important;
}
.text-primary-m1 {
    color: #4087d4!important;
}

.text-danger-m1 {
    color: #dd4949!important;
}
.text-blue-m2 {
    color: #68a3d5!important;
}
.text-150 {
    font-size: 150%!important;
}
.text-60 {
    font-size: 60%!important;
}
.text-grey-m1 {
    color: #7b7d81!important;
}
.align-bottom {
    vertical-align: bottom!important;
}
</style>
<style>
  .custom-button {
    font-size: 20px;
  }
</style>
<?php
$this->load->helper('form');
$error = $this->session->flashdata('error');
if ($error) { 
    ?>
<div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
</div>
<?php } ?>
<?php
        $success = $this->session->flashdata('success');
        if ($success) {
        ?>
<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <i class="fa fa-check mx-2"></i>
    <strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
</div>
<?php }?>
<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
    <div class="main-content-container container-fluid px-4 pt-2">
        <div class="row p-0">
            <div class="col padding_left_right_null">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class="col-lg-6 col-sm-8 col-8">
                                <span class="page-title" style="font-size: 25px;">
                                    <i class="fa fa-file-alt"></i> <b>Create Purchase Order</b>
                                </span>
                            </div>
                            <div class="col-lg-6 col-sm-8 col-8">
                            <a class="btn btn_back btn-primary mobile-btn float-right text-white border_left_radius btn-backtrack" value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <form role="form" id="add" action="<?php echo base_url() ?>addPurchaseOrderToDB"  method="post">
            <div class="col-12">
                <div class="row">
                    <div class="col-sm-4">
                        <div>
                            <span class="text-sm text-grey-m2 align-middle">To:</span>
                            <select required name="party_row_id" id="party_row_id"
                                class="form-control required selectpicker" data-live-search="true" required>
                                    <option value="">Select Party</option>
                                    <?php if(!empty($partyInfo)){ 
                                    foreach ($partyInfo as $party){ ?>
                                    <option value="<?php echo $party->row_id ?>"><?php echo $party->party_name ?></option>
                                <?php } 
                                } ?>
                            </select>
                        </div>
                      
                    </div>
                    <!-- /.col -->
                    <div class="col-4"></div>
                    <div class=" col-sm-4 justify-content-end">
                        <hr class="d-sm-none" />
                        <div class="text-grey-m2">
                          
                            <div class="my-2">
                                <input id="date" type="text" name="date" class="form-control datepicker" value="<?php echo date('d-m-Y');?>" placeholder="Date"
                                    autocomplete="off" required>
                            </div>
                            <div class="my-2">
                                <input id="date" type="text" name="due_date" class="form-control datepicker" placeholder="Due Date"
                                    autocomplete="off" required>
                            </div>
                            <!-- <div class="my-2">
                                <input type="text" name="bill_no" class="form-control" placeholder="Bill No." onkeypress="return isNumberKey(event)"
                                    autocomplete="off" required>
                            </div> -->
                            <!-- <div class="my-2">
                                <input type="text" name="ref_no" class="form-control" placeholder="Ref No." onkeypress="return isNumberKey(event)"
                                    autocomplete="off" required>
                            </div> -->
                            <!-- <div class="my-2">
                                <input type="text" name="product" class="form-control" placeholder="Product"
                                    autocomplete="off" required>
                            </div> -->
                        </div>
                    </div>
                    <!-- /.col -->
                </div>

                    <div class="m-0">
                        <div class="table-responsive row1">
                            <table class="table table-striped table-borderless border-0 border-b-2 brc-default-l1">
                                <thead class="bg-none bgc-default-tp1">
                                    <tr class="text-white">
                                        <!-- <th width="70">Sl. No.</th> -->
                                        <!-- <th>Date</th> -->
                                        <th rowspan="2" width="600">Item</th>
                                        <!-- <th>Description</th> -->
                                        <!-- <th>Invoice</th>
                                        <th>Destination</th> -->
                                        <th rowspan="2" width="150">Quantity</th>
                                        <th rowspan="2" width="150">Rate Per Unit</th>
                                        <th rowspan="2" width="150">Unit</th>
                                        <th class="text-center" colspan= "2" width="200">TAX</th>
                                        <th rowspan="2" class="text-center" width="200">Amount</th>
                                    </tr>
                                    <tr class="text-white">
                                        <th class="text-center" width="150">GST</th>
                                        <th class="text-center" width="150">Amount</th>
                                    </tr>
                                </thead>

                                <tbody class="text-95 text-secondary-d3">
                                    
                                    <tr class="inv_row">
                                        <!-- <td><input id="slno" type="text" name="slno[]" class="form-control" placeholder="1"
                                        autocomplete="off" disabled></td> -->
                                        <!-- <td><input type="date" name="trans_date[]" class="form-control" placeholder="Date"
                                        autocomplete="off" required></td> -->
                                        <td><input type="text" name="item[]" class="form-control" placeholder="Item"
                                        autocomplete="off" required></td>
                                        <!-- <td><input type="text" name="description[]" class="form-control" placeholder="Description" 
                                        autocomplete="off" required></td> -->
                                        <!-- <td class="text-95"><input type="text" name="invoice[]" class="form-control" placeholder="Invoice" onkeypress="return isNumberKey(event)"
                                        autocomplete="off" required></td>
                                        <td><input type="text" name="destination[]" class="form-control" placeholder="Destination"
                                        autocomplete="off" required></td> -->
                                        <td class="text-secondary-d2"><input type="text" name="qty[]" id="itemquantity" class="form-control itemquantity" placeholder="Quantity" value="1" onkeypress="return isNumberKey(event)"
                                        autocomplete="off" required></td>
                                       

                                        <td class="text-secondary-d2"><input type="text" name="rate[]" id="itemrate" class="form-control itemrate" placeholder="Rate Per Unit" onkeypress="return isNumberKey(event)"
                                        autocomplete="off" required></td>
                                        <td class="text-secondary-d2">
                                            <select name="unit[]" id="unit" class="form-control unit" required>
                                                <option value="">Select Unit</option>
                                                <option href="#" data-toggle="modal" data-target="#myModal" value="ADD"><i class="fa fa-plus"></i> ADD NEW</option>
                                                    <?php if(!empty($UnitInfo)){ 
                                                    foreach ($UnitInfo as $party){ ?>
                                                    <option value="<?php echo $party->row_id  ?>"><?php echo $party->unit_name ?> (<?php echo $party->short_name ?>)</option>
                                                <?php } 
                                                } ?>
                                               
                                            </select>
                                        </td>
                                        <td class="text-secondary-d2">
                                            <select name="gst[]" id="gst" class="form-control gst" required>
                                                <?php if (!empty($GSTInfo)) {
                                                foreach ($GSTInfo as $gst) { ?>
                                                    <option value="<?php echo $gst->id . '|' . $gst->percentage ?>"><?php echo $gst->name ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </td>

                                        <!-- <td class="text-secondary-d2">
                                            <select name="gst[]" id="gst" class="form-control gst" required>
                                            <?php if(!empty($GSTInfo)){ 
                                                    foreach ($GSTInfo as $gst){ ?>
                                                    <option value="<?php echo $gst->id ?>"><?php echo $gst->name ?></option>
                                                <?php } 
                                                } ?>
                                                
                                            </select>
                                        </td> -->
                                        <td class="text-secondary-d2"><input type="text" name="gstamount[]" id="gstamount" class="form-control gstamount" placeholder="Amount"
                                        autocomplete="off" readonly required></td>
                                        <td class="text-secondary-d2"><input type="text" name="amount[]" id="amount" class="form-control amount" placeholder="Amount"
                                        autocomplete="off" readonly required></td>
                                    </tr> 
                                    <p id='newrow'></p>
                                </tbody>
                            </table>
                        </div>
                        <div class="row ">
                            <div class="col-11 text-right">
                            <input type="button" class="add align-center btn-success custom-button" id="add" value="+" style="width: 25px;" />
                            <input type='button' class = "sub align-center btn-danger custom-button" id='sub' value='-' style="width: 25px;"/>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-6">
                                <textarea id="terms_conditions" name="terms_conditions" rows="4" cols="50" placeholder="Terms And Conditions" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12 text-right">
                            Total Amount:&nbsp;<i class="fa fa-rupee-sign"></i>&nbsp;<input type="text" name="totalAmount" class="text-150 border-0 w-25 totalAmt" placeholder="0"
                                        autocomplete="off" required readonly>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <div class="col-12">
                            <input type="submit" class="btn btn-info btn-bold px-4 float-right mt-3 mt-lg-0" value="ADD">
                            </div>
                        </div>
                    </div>
            </div><br><br><br>
            </form>
        </div>
    </div>

    
  <!-- modal Bigin -->
  <div class="row">
            <div class="col">
                <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header modal-call-report p-2">
                                <div class=" col-md-10 col-10">
                                    <span class="text-black mobile-title" style="font-size : 20px">Add Unit
                                        Details</span>
                                </div>
                                <div class=" col-md-2 col-2">
                                    <button type="button" class="text-black close" data-dismiss="modal">&times;</button>
                                </div>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body">
                                <?php $this->load->helper("form"); ?>
                                <form role="form" id="addUnitInfo" action="<?php echo base_url() ?>addUnitInfo" method="post"
                                    role="form">
                                    <div class="row form-contents">
                                        <div class="col-lg-12 col-12">
                                            <div class="form-group">
                                                <label for="unit_name">Unit Name</label>
                                                <input type="text" class="form-control " id="unit_name" name="unit_name"
                                                    placeholder="Enter Unit Name" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-12">
                                            <div class="form-group">
                                                <label for="unit_name">Shortname</label>
                                                <input type="text" class="form-control " id="short_name" name="short_name"
                                                    placeholder="Enter Shortname" autocomplete="off" required>
                                            </div>
                                        </div>
                                      

                                    </div>
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" style="flaot : left" value="Submit" />
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <script>

$(document).ready(function() {
  $('form').delegate('.unit', 'change', function() {
    if ($(this).val() === "ADD") {
      $('#myModal').modal('show');
      $(this).val(""); // Resetting the select value after showing the modal
    }
  });
});

// Function to handle the submission of the "Add Party" form
$('#addParty').submit(function(event) {
  event.preventDefault(); // Prevent the form from submitting

  // Retrieve the entered party name
  var partyName = $('#party_name').val();

  // Create a new option element
  var newOption = '<option value="' + partyName + '">' + partyName + '</option>';

  // Append the new option to the select element
  $('#unit').append(newOption);

  // Close the modal
  $('#myModal').modal('show');
  
  // Reset the form inputs
  $('#party_name').val("");
});


    $(document).on("click",".add",function(){
        var n= $('.inv_row').length+1;
        var temp = $('.inv_row:first').clone()
        temp.find('input').val('');
        $('input:first',temp).attr('value',n)
        $('.inv_row:last').after(temp);
    });

    $(document).on("click",".sub",function(){
        var n= $('.inv_row').length;
        if(n>1){
            $('.inv_row:last').remove();
        }
    });


    $('form').delegate('.itemquantity, .itemrate, .gst', 'change', function() {
        calculateGST();
        calculateAmount();
        totalAmount();
    });


    // function calculateGST() {
    //     $(".gstamount").each(function() {
    //         var tr = $(this).parent().parent();

    //         var quantity = tr.find('.itemquantity').val();
    //         var rate = tr.find('.itemrate').val();
    //         var gst = tr.find('.gst').val();
    //         if (quantity !== "" && rate !== "" && gst !== "") {
    //             var totalgst = ((quantity * rate) * gst) / 100;
    //             tr.find('.gstamount').val(totalgst);
    //         }
    //     });
    // }

    function calculateGST() {
        $(".gstamount").each(function() {
            var tr = $(this).parent().parent();

            var quantity = tr.find('.itemquantity').val();
            var rate = tr.find('.itemrate').val();
            var gstValue = tr.find('.gst').val();
            
            if (quantity !== "" && rate !== "" && gstValue !== "") {
            var gstData = gstValue.split('|');
            var gstId = gstData[0];
            var gstPercentage = gstData[1];

            var totalgst = (quantity * rate * gstPercentage) / 100;
            tr.find('.gstamount').val(totalgst);
            }
        });
    }

    function calculateAmount() {
        $(".amount").each(function() {
            var tr = $(this).parent().parent();

            var quantity = tr.find('.itemquantity').val();
            var rate = tr.find('.itemrate').val();
            var gstamount = tr.find('.gstamount').val();
            if (quantity != "" && rate != "" && gstamount != "") {
                var total = parseFloat(gstamount) + (quantity * rate);
                tr.find('.amount').val(total.toFixed(2));
            }
        });
    }
    function totalAmount() {
        var total = 0;

        $(".amount").each(function() {
            var amount = parseFloat($(this).val());
            if (!isNaN(amount)) {
                total += amount;
            }
        });

        $(".totalAmt").val(total.toFixed(2));
    }

   
    function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;
    return true;
    }

    jQuery(document).ready(function() {
        jQuery('.datepicker').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        setDate: new Date()
        });
    });

    
    </script>
    <script>
        function handleKeyPress(event) {
            if (event.keyCode === 13) {
                event.preventDefault(); // Prevent the default Enter key behavior
                var textarea = document.getElementById("terms_conditions");
                textarea.value += "\n"; // Append a newline character
            }
        }


      
    </script>
    
    