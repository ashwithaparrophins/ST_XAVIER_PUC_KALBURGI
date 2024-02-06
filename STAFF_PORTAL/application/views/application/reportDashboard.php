<?php
$this->load->helper('form');
?>

<style>
    .dash-icons {
        margin-right: 0px!important;
    }
    .admission_card{
        background-color: #05598a !important;
    }
    .academic_card{
        background-color: #217f7f !important;
    }
    .fee_card{
        background-color: #952b70 !important
    }
    .main_card{
        background-color: #fff !important;
        border: 2px solid #065989 !important;
    }
    .main_card h6{
        color: #000 !important;
    }
    .card_icon{
        font-size: 16px !important;
    }
</style>

<div class="main-content-container px-3">
    <!-- Page Header -->
    <div class="row mt-1 mb-1 ">
        <div class="col padding_left_right_null">
            <div class="card card_heading_title card-small p-0">
                <div class="card-body p-2 ml-2">
                    <span class="page-title">
                        <i class="fa fa-file"></i> Report
                    </span>
                    <!-- <img class="float-right" height="35" src="<?php echo base_url(); ?>assets/images/.jpg" /> -->
                </div>
            </div>
        </div>
    </div>
   
          
   

    <div class="col-12 mb-1 column_padding_card">
        <div class="card p-2 main_card">
            <h6 class="font-weight-bold mb-2">Admission Report</h6>
            <div class="row">
                    <div class="col-lg-3 col-6 mb-2 column_padding_card">
                        <a data-toggle="modal"   data-target="#admissionRegisteredStudent" class="more-info text-white" href="#">
                            <div class="card card-small dash-card admission_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white">
                                        <i class="fa fa-book card_icon"></i> <span class="cardFont" >Admission Registered</span>
                                    </h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-0">
                                    <span class="text-center">Download</span>
                                </div>
                            </div>
                        </a>
                    </div>
 
                    <div class="col-lg-3 col-6 mb-2 ">
                        <a data-toggle="modal" data-target="#applicationStackReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card admission_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white">
                                        <i class="fa fa-book card_icon"></i> <span class="cardFont">Application Stack</span>
                                    </h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-0">
                                    <span class="text-center">Download</span>
                                </div>
                            </div>
                        </a>
                    </div>
                   
                    
                    <div class="col-lg-3 col-6 mb-2 column_padding_card">
                        <a data-toggle="modal" data-target="#applicationApprovedReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card admission_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white">
                                        <i class="fa fa-book card_icon"></i> <span class="cardFont" >Approved Application</span>
                                    </h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-0">
                                    <span class="text-center">Download</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- <div class="col-lg-3 col-6 mb-2 column_padding_card">
                        <a data-toggle="modal" data-target="#applicationShorlistedReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card admission_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white">
                                        <i class="fa fa-book card_icon"></i> <span class="cardFont" >Shorlisted Application</span>
                                    </h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-0">
                                    <span class="text-center">Download</span>
                                </div>
                            </div>
                        </a>
                    </div> -->
                    <div class="col-lg-3 col-6 mb-2 column_padding_card">
                        <a data-toggle="modal" data-target="#applicationRejectedReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card admission_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white">
                                        <i class="fa fa-book card_icon"></i> <span class="cardFont" >Rejected Application</span>
                                    </h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-0">
                                    <span class="text-center">Download</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- <div class="col-lg-3 col-6 mb-2 ">
                        <a data-toggle="modal" data-target="#applicationFeePendingReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card admission_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white">
                                        <i class="fa fa-book card_icon"></i> <span class="cardFont">Application Fee Pending</span>
                                    </h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-0">
                                    <span class="text-center">Download</span>
                                </div>
                            </div>
                        </a>
                    </div> -->
                    <div class="col-lg-3 col-6 mb-2 ">
                        <a data-toggle="modal" data-target="#applicationFeePaidReport" class="more-info text-white" href="#">
                            <div class="card card-small dash-card admission_card">
                                <div class="card-body pt-2 pb-2">
                                    <h6 class="stats-small__value count text-white">
                                        <i class="fa fa-book card_icon"></i> <span class="cardFont">Application Fee Paid</span>
                                    </h6>
                                </div>
                                <div class="card-footer text-center dash-footer p-0">
                                    <span class="text-center">Download</span>
                                </div>
                            </div>
                        </a>
                    </div>
            </div>
        </div>
    </div>
    </div>
    </div> 

<!-- The Modal for application stack-->
<div class="modal" id="applicationStackReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Application Stack Report Filter</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form data-download_form="true" method="POST" action="<?php echo base_url(); ?>downloadApplicationStack">
                    <input type="hidden" value="APPLICATION_STACK" name="report_type" />
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Course</label>
                            <select class="form-control input-md required" id="" name="by_class">
                            <option value="ALL">ALL</option>
                                                <option value="SCIENCE">SCIENCE</option>
                                                <option value="COMMERCE">COMMERCE</option>
                                                <option value="ARTS">ARTS</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Stream</label>
                            <select class="form-control input-md required" id="" name="by_stream">
                            <option value="ALL">ALL</option>
                            <?php if(!empty($streamInfo)){
                                foreach($streamInfo as $record){ ?>
                                <option value="<?php echo $record->stream_name; ?>"><?php echo $record->stream_name; ?></option>
                            <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Gender</label>
                            <select class="form-control input-md required" id="" name="by_gedner">
                                <option value="">ALL</option>
                                <option value="MALE">MALE</option>
                                <option value="FEMALE">FEMALE</option>
                            </select>
                        </div>
                    </div>
                        <div class="row">
                        <div class="col-lg-12">
                            <label>By Year</label>
                            <select class="form-control input-md required" id="" name="by_year">
                                <option value="2024">2024</option>
                               
                                <option value="2023">2023</option>
                                <!-- <option value="2022">2022</option>
                                <option value="2021">2021</option> -->
                            </select>
                        </div>
                    </div>
                   
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="addBankSettlementSubmit"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<!-- The Modal for application stack-->
<div class="modal" id="applicationFeePendingReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Application Fee Pending Report Filter</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form data-download_form="true" method="POST" action="<?php echo base_url(); ?>downloadApplicationFeePending">
                    <input type="hidden" value="APPLICATION_FEE_PENDING" name="report_type" />
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Class</label>
                            <select class="form-control input-md required" id="" name="by_class">
                            <?php if(!empty($CourseInfo)){
                              foreach($CourseInfo as $course){ ?>
                              <option value="<?php echo $course->name; ?>"><?php echo $course->name; ?></option>
                               <?php } } ?>
                            </select>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-lg-12">
                            <label>By Year</label>
                            <select class="form-control input-md required" id="" name="by_year">
                               
                                <option value="2023">2023</option>
                                <option value="2022">2022</option>
                                <option value="2021">2021</option>
                            </select>
                        </div>
                    </div>
                   
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="addBankSettlementSubmit"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



<!-- The Modal for application Fee Paid Report-->
<div class="modal" id="applicationFeePaidReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Application Fee Paid Report Filter</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form data-download_form="true" method="POST" action="<?php echo base_url(); ?>downloadApplicationFeepaidReport">
                    <input type="hidden" value="APPLICATION_FEE_PAID" name="report_type" />
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Course</label>
                            <select class="form-control input-md required" id="" name="by_class">
                            <option value="ALL">ALL</option>
                                                <option value="SCIENCE">SCIENCE</option>
                                                <option value="COMMERCE">COMMERCE</option>
                                                <option value="ARTS">ARTS</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Stream</label>
                            <select class="form-control input-md required" id="" name="by_stream">
                            <option value="ALL">ALL</option>
                            <?php if(!empty($streamInfo)){
                                foreach($streamInfo as $record){ ?>
                                <option value="<?php echo $record->stream_name; ?>"><?php echo $record->stream_name; ?></option>
                            <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Year</label>
                            <select class="form-control input-md required" id="" name="year">
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                                <!-- <option value="2022">2022</option>
                                 -->
                            </select>
                        </div>
                    </div>
                    <!-- <div class="row">
                       <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Date From</label>
                                <input type="text" class="form-control from_date" name="date_from" id="date_from"
                                    value="" placeholder="Date From" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Date To</label>
                                <input type="text" class="form-control to_date" name="date_to" id="date_to"
                                    value="" placeholder="Date To" autocomplete="off">
                            </div>
                        </div>

                    </div> -->
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="download"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal" id="applicationApprovedReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Application Approved Report Filter</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form data-download_form="true" method="POST" id="applicationApprovedReport" action="<?php echo base_url(); ?>downloadApplicationStack">
                    <input type="hidden" value="APPLICATION_APPROVED" name="report_type" />
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Course</label>
                            <select class="form-control input-md required" id="" name="by_class">
                            <option value="ALL">ALL</option>
                                                <option value="SCIENCE">SCIENCE</option>
                                                <option value="COMMERCE">COMMERCE</option>
                                                <option value="ARTS">ARTS</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Stream</label>
                            <select class="form-control input-md required" id="" name="by_stream">
                            <option value="ALL">ALL</option>
                            <?php if(!empty($streamInfo)){
                                foreach($streamInfo as $record){ ?>
                                <option value="<?php echo $record->stream_name; ?>"><?php echo $record->stream_name; ?></option>
                            <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Year</label>
                            <select class="form-control input-md required" id="" name="by_year">
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                                <!-- <option value="2022">2022</option>
                                <option value="2021">2021</option> -->
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="applicationApprovedReport"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div class="modal" id="applicationShorlistedReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Application Shortlisted Report Filter</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form data-download_form="true" method="POST" id="applicationShorlistedReport" action="<?php echo base_url(); ?>downloadApplicationStack">
                    <input type="hidden" value="APPLICATION_SHORTLISTED" name="report_type" />
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Course</label>
                            <select class="form-control input-md required" id="" name="by_class">
                            <option value="ALL">ALL</option>
                                                <option value="SCIENCE">SCIENCE</option>
                                                <option value="COMMERCE">COMMERCE</option>
                                                <option value="ARTS">ARTS</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Stream</label>
                            <select class="form-control input-md required" id="" name="by_stream">
                            <option value="ALL">ALL</option>
                            <?php if(!empty($streamInfo)){
                                foreach($streamInfo as $record){ ?>
                                <option value="<?php echo $record->stream_name; ?>"><?php echo $record->stream_name; ?></option>
                            <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Year</label>
                            <select class="form-control input-md required" id="" name="by_year">
                               
                                <option value="2023">2023</option>
                                <!-- <option value="2022">2022</option>
                                <option value="2021">2021</option> -->
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="applicationApprovedReport"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<div class="modal" id="applicationRejectedReport">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Application Rejected Report Filter</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form data-download_form="true" method="POST" id="applicationRejectedReport" action="<?php echo base_url(); ?>downloadApplicationStack">
                    <input type="hidden" value="APPLICATION_REJECTED" name="report_type" />
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Course</label>
                            <select class="form-control input-md required" id="" name="by_class">
                            <option value="ALL">ALL</option>
                                                <option value="SCIENCE">SCIENCE</option>
                                                <option value="COMMERCE">COMMERCE</option>
                                                <option value="ARTS">ARTS</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Stream</label>
                            <select class="form-control input-md required" id="" name="by_stream">
                            <option value="ALL">ALL</option>
                            <?php if(!empty($streamInfo)){
                                foreach($streamInfo as $record){ ?>
                                <option value="<?php echo $record->stream_name; ?>"><?php echo $record->stream_name; ?></option>
                            <?php } } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Year</label>
                            <select class="form-control input-md required" id="" name="by_year">
                                <option value="2024">2024</option>
                               
                                <option value="2023">2023</option>
                                <!-- <option value="2022">2022</option>
                                <option value="2021">2021</option> -->
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="applicationRejectedReport"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- The Modal for application stack-->
<div class="modal" id="applicationStackReportTwo">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Application Stack Report Filter</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form data-download_form="true" method="POST" action="<?php echo base_url(); ?>downloadApplicationStackForHigherClass">
                    <input type="hidden" value="APPLICATION_STACK" name="report_type" />
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Class</label>
                            <select class="form-control input-md required" id="" name="by_class">
                                <!-- <option value="">ALL</option> -->
                                <?php if(!empty($termInfo)){
                                    foreach($termInfo as $term){ ?>
                                <option value="<?php echo $term->term_name ?>">
                                    <?php echo $term->term_name ?>
                                </option>
                                <?php }  } ?>
                            </select>
                        </div>
                    </div>
                   
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="addBankSettlementSubmit"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



<div class="modal" id="applicationApprovedReportTwo">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Application Approved Report Filter</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form data-download_form="true" method="POST" id="applicationApprovedReportTwo" action="<?php echo base_url(); ?>downloadApplicationStackForHigherClass">
                    <input type="hidden" value="APPLICATION_APPROVED" name="report_type" />
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Course</label>
                            <select class="form-control input-md required" id="" name="by_class">
                                <!-- <option value="">ALL</option> -->
                                <?php if(!empty($termInfo)){
                                    foreach($termInfo as $term){ ?>
                                <option value="<?php echo $term->term_name ?>">
                                    <?php echo $term->term_name ?>
                                </option>
                                <?php }  } ?>
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="applicationApprovedReportTwo"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



<div class="modal" id="applicationRejectedReportTwo">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Application Rejected Report Filter</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form data-download_form="true" method="POST" id="applicationRejectedReportTwo" action="<?php echo base_url(); ?>downloadApplicationStackForHigherClass">
                    <input type="hidden" value="APPLICATION_REJECTED" name="report_type" />
                    <div class="row">
                        <div class="col-lg-12">
                            <label>By Course</label>
                            <select class="form-control input-md required" id="" name="by_class">
                                <!-- <option value="">ALL</option> -->
                                <?php if(!empty($termInfo)){
                                    foreach($termInfo as $term){ ?>
                                <option value="<?php echo $term->term_name ?>">
                                    <?php echo $term->term_name ?>
                                </option>
                                <?php }  } ?>
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" id="applicationRejectedReportTwo"
                                    class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>




<div class="modal" id="admissionRegisteredStudent">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header" style="padding: 10px;">
                <h6 class="modal-title">Registered Student Report</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding: 10px;">
                <form method="POST" id="admissionRegisteredStudent" data-download_form="true" action="<?php echo base_url(); ?>downloadAdmissionRegisteredStudent">
                    
                    <input type="hidden" value="ADMISSION_REGISTERED" name="report_type" />
                    <!-- <div class="row">
                    <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date From</label>
                                <input type="text" class="form-control" id="date_from" name="date_from"
                                    placeholder="Select Date From" autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="account_type">Date To</label>
                                <input type="text" class="form-control" id="date_to" name="date_to"
                                    placeholder="Select Date To" autocomplete="off" >
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-lg-12">
                            <label>Year</label>
                            <select class="form-control input-md required" id="" name="year">
                             <option value="2024">2024</option>

                                <option value="2023">2023</option>
                                
                                <!-- <option value="2022">2022</option>
                                <option value="2021">2021</option> -->
                            </select>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer" style="padding:5px;">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" 
                                id="admissionRegisteredStudent" class="btn btn-success">Download</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

jQuery(document).ready(function() {
    // $("form").on('submit',()=>{
    //     $.cookie('isDownLoaded',0);
    //     checkDownloadStatus();
    // });
//     const checkDownloadStatus = ()=>{
//     const downloadIntervalID = setInterval(() => {
//         alert('aaaaa');
//         if( $.cookie('isDownLoaded')==1 ){
            
//             hideLoader();
//             clearInterval(downloadIntervalID);
//         }
//     }, 0);
// }
    // var loader = '<img height="30" src="<?php echo base_url(); ?>/assets/images/loader.gif"/>';
    // $('#downloadGovtReportForm').submit(function() {
    //     $('#downloadGovtReportbtn').prop('disabled', true);
    //     $("#loader").html(loader);
    // });


    jQuery('.from_date,.to_date').datepicker({
        autoclose: true,
        format : "dd-mm-yyyy",
        endDate: "today",
        startDate: "01-03-2020",
        maxDate: 2
    });

     jQuery('#toDate_report,#date_from, #date_to, #fromDate_report, #toDate_permReport, #fromDate_permReport,#toDate_FeeReport,#fromDate_FeeReport').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });


});

function downloadLeaveReport() {
    var from_date = $('#fromDate_report').val();
    var to_date = $('#toDate_report').val();
    var leave_type = $('#leave_type_report').val();
    var applied_staff_id = $('#applied_staff_id_report').val();
    var leave_status = $('#leave_status_report').val();
    if (from_date == "") {
        alert("Please enter From Date!");
    } else if (to_date == "") {
        alert("Please enter To Date!");
    } else {
        $.ajax({
            url: '<?php echo base_url(); ?>/downloadStaffLeaveReport',
            type: 'POST',
            dataType: 'json',
            data: {
                from_date: from_date,
                to_date: to_date,
                leave_type: leave_type,
                applied_staff_id: applied_staff_id,
                leave_status: leave_status
            },

            success: function(data) {
                hideLoader();
                var $a = $("<a>");
                $a.attr("href", data.file);
                $("body").append($a);
                $a.attr("download", leave_type+"_Leave_Report_" + from_date + "_to_" + to_date +
                "_Report_file.xls");
                $a[0].click();
                $a.remove();
            },
            error: function(result) {
                hideLoader();
                alert("Search Error!!  Failed");
            },
            fail: (function(status) {
                hideLoader();
                alert("Server Error!!  Failed");
            }),
            beforeSend: function(d) {
                showLoader();
                // $("#loader").html(loader);
            }
        });
    }
}

$('#downloadAttendanceReport').click(function() {
        var term_name = $('.termValue').val();
        var section_name = $('#section_name').val();
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        // var gender = $('#gender').val();
        var percentage_sort = $('#percentage_sort').val();
        if (term_name == 'ALL') {
            var termName = 'I-X';
        } else {
            var termName = term_name;
        }

         if (section_name == '') {
            var section = 'ALL';
        } else {
            var section = section_name;
        }

        if (term_name == "") {
            alert("Class is Empty!!");
        } else {

            $.ajax({
                url: '<?php echo base_url(); ?>/downloadAbsentedStudentInfo',
                type: 'POST',
                dataType: 'json',
                data: {
                    date_from: date_from,
                    date_to: date_to,
                    term_name: term_name,
                    section_name: section_name
                    // gender: gender
                },
                success: function(data) {
                    $('#loader').html('');
                    $("#downloadAttendanceReport").prop('disabled', false);
                    // $("#downloadAttReport").hide();
                    var $a = $("<a>");
                    $a.attr("href", data.file);
                    $("body").append($a);
                    $a.attr("download", termName + "_" + section +
                        "_ATTENDANCE_REPORT.xls");
                    $a[0].click();
                    $a.remove();
                },
                error: function(result) {
                    $('#loader').html('');
                    $("#downloadAttendanceReport").prop('disabled', false);
                    alert("Network Server Error!!  Failed");
                },
                fail: (function(status) {
                    $('#loader').html('');
                    $("#downloadAttendanceReport").prop('disabled', false);
                    alert("Server Error!!  Failed");
                }),
                beforeSend: function(d) {
                    $('#loader').html(loader);
                    $("#downloadAttendanceReport").prop('disabled', true);
                }
            });
        }
    });

// function downloadFeeConcessionReport() {

//     var from_date = $('#fromDate_FeeReport').val();

//     var to_date = $('#toDate_FeeReport').val();



//     if (from_date == "") {

//         alert("Please enter From Date!");

//     } else if (to_date == "") {

//         alert("Please enter To Date!");

//     } else {

//         $.ajax({

//             url: '<?php echo base_url(); ?>/downloadFeeConcessionReport',

//             type: 'POST',

//             dataType: 'json',

//             data: {

//                 from_date: from_date,

//                 to_date: to_date,


//             },



//             success: function(data) {

//                 hideLoader();

//                 var $a = $("<a>");

//                 $a.attr("href", data.file);

//                 $("body").append($a);

//                 $a.attr("download", "Fee_Concession_Report_" + from_date + "_TO_" + to_date +

//                     "_Report_file.xls");

//                 $a[0].click();

//                 $a.remove();

//             },

//             error: function(result) {

//                 hideLoader();

//                 alert("Search Error!!  Failed");

//             },

//             fail: (function(status) {

//                 hideLoader();

//                 alert("Server Error!!  Failed");

//             }),

//             beforeSend: function(d) {

//                 showLoader();

//                 // $("#loader").html(loader);

//             }

//         });

//     }

// }

function downloadPermissionReport() {
    var from_date = $('#fromDate_permReport').val();
    var to_date = $('#toDate_permReport').val();
    var permission_type = $('#permission_type_report').val();
    var applied_staff_id = $('#applied_staff_id_report').val();

    if (from_date == "") {
        alert("Please enter From Date!");
    } else if (to_date == "") {
        alert("Please enter To Date!");
    } else {
        $.ajax({
            url: '<?php echo base_url(); ?>/downloadStaffPermissionReport',
            type: 'POST',
            dataType: 'json',
            data: {
                from_date: from_date,
                to_date: to_date,
                permission_type: permission_type,
                applied_staff_id: applied_staff_id
            },

            success: function(data) {
                hideLoader();
                var $a = $("<a>");
                $a.attr("href", data.file);
                $("body").append($a);
                $a.attr("download", permission_type + "_Staff_Permission_Report_" + from_date + "_TO_" + to_date +
                    "_Report_file.xls");
                $a[0].click();
                $a.remove();
            },
            error: function(result) {
                hideLoader();
                alert("Search Error!!  Failed");
            },
            fail: (function(status) {
                hideLoader();
                alert("Server Error!!  Failed");
            }),
            beforeSend: function(d) {
                showLoader();
                // $("#loader").html(loader);
            }
        });
    }
}



/*An array containing all the country names in the world:*/

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
// autocomplete(document.getElementById("sat_number_academic"), student_names, sat_number);
// autocomplete(document.getElementById("student_id"), student_names, student_id);

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
        (charCode < 48 || charCode > 57))
        return false;

    return true;
}

function allowNumbersOnly(e) {
    if (window.event) // IE
    {
        if ((e.keyCode < 48 || e.keyCode > 57) & e.keyCode != 8 && e.keyCode != 44) {
            event.returnValue = false;
            return false;
        }
    } else { // Fire Fox
        if ((e.which < 48 || e.which > 57) & e.which != 8 && e.which != 44) {
            e.preventDefault();
            return false;
        }
    }
}
</script>