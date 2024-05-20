<style>
@media print {
    .page-break {
        display: block;
        page-break-before: always;
    }

    .main-footer {
        display: none !important;
    }
}

@media print {
    .noprint {
        display: none;
    }

    ::-webkit-scrollbar {
        display: none;
    }

    .enable-print {
        display: block !important;

    }
}

.A4 {
    /* overflow-x: scroll; */
    background: white;
    width: 26cm;
    height: 34.7cm;
    display: block;
    margin: 0 auto;
    padding: 25px;
    margin-bottom: 0.5cm;
    box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
}

#border {
    border-radius: 1px;
    border: 2px solid black;
    width: 18.5cm;
    height: 26.7cm;

}

.stm_work {
    font-size: 25px;
    font-weight: bold;
}

.title {
    font-size: 30px;
    margin-left: -25px;
}

table,
th,
td {
    /* border: 1px solid black;
    border-collapse: collapse;
    padding: 3px; */
}

/* ------------------ */
/* new added changes */
/* ----------------- */

.photo1 {
    margin-top: 0px !important;
}

.picture-box {
    margin-top: 15px;
}

.footer-sign {
    margin-top: 60px;
    text-transform: uppercase;
    font-size: 14px;
}

.boredr-only-top {
    border-top: solid;
    border-color: black;
    border-width: 1px;
    margin-top: 15px;
}

.box-address {
    margin-top: 40px;
}

.table>tbody>tr>td,
.table>tbody>tr>th,
.table>tfoot>tr>td,
.table>tfoot>tr>th,
.table>thead>tr>td,
.table>thead>tr>th {
    /* line-height: 0.5 !important; */
    vertical-align: inherit !important;
    border: 1px solid #ddd;
    padding:5px;
    font-size: 14px;
    color: black !important;
}

/* tr {
    height: 5px !important;
} */






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
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header noprint">
            <div class="row">
                <div class="col-8 h5">
                    <i class="fa fa-print"></i> Bill View Karavali Transport
                    <small>Print/Save </small>
                </div>
                <div class="col-4">

                    <button style="float:right;" class="btn btn-primary" type="button"
                        title="Print or Save the Mark Card" onClick="window.print()"><i class="fa fa-download"></i>
                        Print/Save</button>
                </div>
            </div>

        </section>
        <section class="content">
            <div class="box-header noprint">
                <!-- <h3 class="box-title">Students Details <span style="margin-left:50px">Total Students: </span></h3> -->
            </div><!-- /.box-header -->
            <div class="row p-0 m-0">
                <div class="col-xs-12">

                    <div class="A4 enable-print">

                        <?php if(!empty($billInfo)) {   ?>
                        <div class="page-content container p-0 m-0">
                            <div class="page-header text-center m-0 p-0">
                                <span class="h3 p-0 m-0 text-danger">
                                    <b>KARAVALI TRANSPORT</b>
                                </span>
                                <span class="p-0 m-0">
                                    <b>FLEET OWNER & BULK MOVER</b><br/>
                                </span>
                                <p class="p-0 m-0" style="font-size:11px">"Aishwarya" 1st Floor, Opp. Mandovi Motors, MRPL Road,
                                      Katla, Surathkal- 575014<br/>
                                      e-mail.:karavalitransport@gmail.com<br/>
                                      Ph.No:- 7090034300, 0824-4254300, 7259360555        
                                </p>
                                <hr/>
                            </div>
                            <div class="page-header text-blue-d2">
                                <span class="page-title text-secondary-d1 justify-content-center">
                                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;INVOICE
                                </span>
                                <span class="align-top font-italic font-weight-light">
                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Original for Receipent)
                                </span>
                            </div>

                            <div class="container px-0">
                                <div class="row">
                                    <div class="col-12 col-lg-10 offset-lg-1">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div>
                                                    <span class="text-sm text-grey-m2 align-middle">To,</span><br/>
                                                    <span class="align-middle font-weight-bold"><?php echo $billInfo->party_name;?></span>
                                                </div>
                                                <div class="text-grey-m2">
                                                    <div class="my-1">
                                                        <?php if($billInfo->party_address!= 'Nill'){ echo $billInfo->party_address; }?>
                                                    </div>
                                                    <div class="my-1">
                                                        Party GST: <?php echo strtoupper($billInfo->party_gst); ?>
                                                    </div>
                                                    <div class="my-1">
                                                        State Code: <?php echo $billInfo->party_state_code; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.col -->

                                            <div
                                                class="col-sm-6 align-self-start d-sm-flex justify-content-end">
                                                <hr class="d-sm-none" />
                                                <div class="">
                                                    <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">
                                                        <span class="text-600 text-90">Date &emsp;&emsp;&emsp; :</span><span class="font-weight-bold"> <?php echo date('d-m-Y',strtotime($billInfo->date)); ?></span>
                                                    </div>
                                                    <div class="my-2">
                                                        <span class="text-600 text-90">Bill No&emsp;&emsp;&nbsp;&nbsp;:</span><span class="font-weight-bold"> <?php echo $billInfo->bill_no; ?></span>
                                                    </div>
                                                    <div class="my-2"> 
                                                        <span class="text-600 text-90">Ref. No&emsp;&emsp;&nbsp;:</span><span class="font-weight-bold"> <?php echo $billInfo->ref_no; ?></span>
                                                    </div>
                                                    <div class="my-2"> 
                                                        <span class="text-600 text-90">Product&emsp;&emsp;:</span><span class="font-weight-bold"> <?php echo strtoupper($billInfo->product); ?></span>
                                                    </div>
                                                    <div class="my-2"> 
                                                        <span class="text-600 text-90">Our PAN No.&emsp;&emsp;&emsp;&emsp;:&nbsp;</span><span class="font-weight-bold">ABYPD4537C</span>
                                                    </div>
                                                    <div class="my-2"> 
                                                        <span class="text-600 text-90">Our GST No.&emsp;&emsp;&emsp;&emsp;:&nbsp;</span><span class="font-weight-bold">29ABYPD4537C2ZF</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <h6 class="text-center"><b><u>TRANSPORTATION CHARGES</u></b></h6>
                                        <p class="text-center">The above mentioned truck loaded from MRPL <?php echo strtoupper($billInfo->product); ?> to your destination</p>
                                        <div class="m-0">
                                            <div class="row brc-default-l2"></div>                                        
                                            <div class="table-responsive">
                                                <table class="table table-borderless border-0 brc-default-l1">
                                                    <thead class="bg-none bgc-default-tp1">
                                                        <tr class="text-white">
                                                            <th>Sl.<br/>No.</th>
                                                            <th>Date</th>
                                                            <th>Vehicle</th>
                                                            <th>LR</th>
                                                            <th>Invoice</th>
                                                            <th>Destination</th>
                                                            <th>Rate<br/>(M/Tons)</th>
                                                            <th>Qty<br/>(M/Tons)</th>
                                                            <th>Amount<br/>Rs.</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody class="text-95 text-secondary-d3">
                                                        <?php $i=1; 
                                                        foreach($billDetailInfo as $info){
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $i++; ?></td>
                                                            <td><?php echo date('d-m-Y',strtotime($info->trans_date));?></td>
                                                            <td><?php echo strtoupper($info->vehicle);?></td>
                                                            <td><?php echo $info->lr;?></td>
                                                            <td><?php echo $info->invoice;?></td>
                                                            <td><?php echo strtoupper($info->destination);?></td>
                                                            <td><?php echo $info->rate;?></td>
                                                            <td><?php echo $info->qty;?></td>
                                                            <td><?php echo $info->amount;?></td>
                                                        </tr>
                                                        <?php
                                                        } ?> 
                                                        <tr>
                                                            <td colspan="8" class="text-center">Subtotal</td>
                                                            <td><?php echo $billInfo->total_amount;?></td>
                                                        </tr>
                                                        </tbody>
                                                </table>
                                            </div>
                                                <div class="d-flex align-items-end flex-column" style="height: 120px;">
                                                                
                                                </div>
                                            <footer class="font-small blue mt-5 pt-5">
    
                                                <table class="table">
                                                    <!-- <tbody>    -->
                                                        <!-- <tr style="line-height:5px;">
                                                            <th colspan="9">    </td>
                                                        </tr> -->
                                                        <tr class="border-0">
                                                            <th>(<?php echo getIndianCurrency($billInfo->total_amount) ?>)</th>
                                                            <th>Grand Total</th>
                                                            <th><?php echo $billInfo->total_amount;?></th>
                                                        </tr>
                                                </table>
                                                <table class="table">
                                                        <tr class="border-0"><td class="border-0"><br/></td><td class="border-0"></td></tr>
                                                        <tr class="border-0 font-weight-bold">
                                                            <td class="border-0">Account Name: Karavali Transport</td>
                                                            <td class="border-0" colspan="">A/c No. : 513700060002201</td>
                                                        </tr>
                                                        <tr class="border-0 font-weight-bold">
                                                            <td class="border-0">Bank: Karnataka Bank Ltd
                                                            &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Branch: H.O.Complex Branch, Mangalore-575002</td>
                                                            <td class="border-0">IFSC: KARB0000513</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="border-0" colspan="">Reverse Charges&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;: YES</td>
                                                            <td class="border-0" >STC&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;: 996789</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="border-0">Description of Services: TRANSPORT SERVICE&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
                                                            <td class="border-0" >Place of Service: MANGALORE</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="border-0" colspan="">State&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;: Karnataka</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="border-0" colspan="">Declaration: Non-availment of Input Tax Credit under GST Law.</td>
                                                        </tr>
                                                    <!-- </tbody> -->
                                                </table>
                                            
                                                <div class="row mt-3">
                                                    <div class="col-12 text-grey-d2 text-95 mt-2 mt-lg-0">
                                                        I/We here by declare that I have not taken any credit of Input Tax charged on goods & services or both used in supplying services 
                                                        in relation to the transportation of goods. This declaration would be valid for the financial Year 2021-2022.
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-12 text-left">
                                                        NOTE: GST payable by the recipient under Reverse Charge
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 text-right font-weight-bold">
                                                        For Karavali Transport 2021-22
                                                    </div>
                                                </div>
                                            </footer>
                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php  } ?>
                    </div>


                </div>
            </div>

            <div class="box-footer clearfix noprint">
                <button style="float:right;" class="btn btn-primary" type="button" title="Print or Save the Mark Card"
                    onClick="window.print()"><i class="fa fa-download"></i> Print/Save</button>
            </div>
        </section>
    </div>
</div>

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
    return ($Rupees ? $Rupees : '') . $paise;
}
?>