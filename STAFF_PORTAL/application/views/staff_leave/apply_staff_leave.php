<style>
.table td {
    text-align: center;
    padding: 1px !important;
    color: black;
    font-weight: 500;
}
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0;
}
</style>
<?php
    $this->load->helper('form');
    $error = $this->session->flashdata('error');
    if($error)
    {
?>
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $this->session->flashdata('error'); ?>
</div>
<?php } ?>
<?php  
    $success = $this->session->flashdata('success');
    if($success)
    {
?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $this->session->flashdata('success'); ?>
</div>
<?php } ?>

<?php  
    $noMatch = $this->session->flashdata('nomatch');
    if($noMatch)
    {
?>
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <?php echo $this->session->flashdata('nomatch'); ?>
</div>
<?php } ?>
<div class="row">
    <div class="col-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container px-3 pt-1">
    <!-- Content Header (Page header) -->
    <div class="content-wrapper">
        <div class="row mt-1">
            <div class="col column_padding_card">
                <div class="card card_heading_title card-small p-0">
                    <div class="card-body p-2">
                        <div class="row c-m-b">
                            <div class="col-lg-10 col-sm-10 col-10">
                                <span class="page-title">
                                    <i class="fa fa-clock"></i> Leave Management
                                </span>
                            </div>

                            <div class="col-lg-2 col-sm-2 col-2 box-tools">
                            <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn float-right text-white "
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row form-employee ">
            <div class="col-lg-12 col-sm-12 col-12 column_padding_card">
                <div class="card card-small c-border mb-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-3">
                            <div class="row">
                                <div class="col profile-head column_padding_card">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="profile-tab" data-toggle="tab"
                                                href="#profile" role="tab" aria-controls="profile"
                                                aria-selected="false">Apply Leave </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="family-tab" data-toggle="tab" href="#family"
                                                role="tab" aria-controls="family" aria-selected="true">Leave Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                                aria-controls="home" aria-selected="true">Leave History</a>
                                        </li>

                                    </ul>
                                    <div class="tab-content profile-tab" id="myTabContent">
                                        <div class="tab-pane fade show active" id="profile" role="tabpanel"
                                            aria-labelledby="profile-tab">
                                            <form method="POST" action="<?php echo base_url().'applyLeaveByStaff'?>" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-3 col-12">
                                                        <div class="form-group">
                                                            <label for="leave_type">Leave Type</label>
                                                            <select name="leave_type" class="form-control" id="leaveType" required>
                                                            <option value="">Select Leave Type</option>
                                                                <?php if(($leaveInfo->casual_leave_earned - $used_leave_cl->total_days_leave) != 0 ){ ?>
                                                                <option value="CL">Casual Leave(CL) (rem: <?php echo $leaveInfo->casual_leave_earned - $used_leave_cl->total_days_leave; ?>)</option>
                                                                <?php } ?>
                                                                <?php if(($leaveInfo->sick_leave_earned - $used_leave_ml->total_days_leave) != 0 ){ ?>
                                                                <option value="ML">Medical Leave(ML)(rem: <?php echo $leaveInfo->sick_leave_earned - $used_leave_ml->total_days_leave; ?>)</option>
                                                                <?php } ?>
                                                                <?php if(($leaveInfo->marriage_leave_earned - $used_leave_marl->total_days_leave) != 0 ){ ?>
                                                                <option value="MARL">Marriage Leave(ML)(rem: <?php echo $leaveInfo->marriage_leave_earned - $used_leave_marl->total_days_leave; ?>)</option>
                                                                <?php } ?>
                                                                <?php if(($leaveInfo->paternity_leave_earned - $used_leave_pl->total_days_leave) != 0 ){ ?>

                                                                <option value="PL">Paternity Leave(PL)(rem: <?php echo $leaveInfo->paternity_leave_earned - $used_leave_pl->total_days_leave;?>)</option>
                                                                <?php } ?>
                                                                <?php if(($leaveInfo->maternity_leave_earned - $used_leave_matl->total_days_leave) != 0 ){ ?>

                                                                <option value="MATL">Maternity Leave(ML)(rem: <?php echo $leaveInfo->maternity_leave_earned - $used_leave_matl->total_days_leave;?>)</option>
                                                                <?php } ?>
                                                                <?php if(($leaveInfo->earned_leave - $used_leave_el->total_days_leave) != 0 ){ ?>

                                                                <option value="EL">Earned Leave(EL)(rem: <?php echo $leaveInfo->earned_leave - $used_leave_el->total_days_leave;?>)</option>
                                                                <?php } ?>
                                                                <?php if(($leaveInfo->official_duty_earned - $used_leave_od->total_days_leave) != 0 ){ ?>

                                                                <option value="OD">Offical Duty(OD)(rem: <?php echo $leaveInfo->official_duty_earned - $used_leave_od->total_days_leave;?>)</option>
                                                                <?php } ?>
                                                                <option value='LOP'>Loss Of Pay(LOP)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Total Number of
                                                                Leave</label>
                                                            <input min="0" max="31" step=".10"  placeholder="Total Number of Leave"
                                                                class=" form-control" name="total_leave_days" id="days_no"
                                                                type="number" list="leaves" required />
                                                            <datalist id="leaves">
                                                                <option value="0.5">Half Day</option>
                                                                <option value="1">One Day</option>
                                                                <option value="1.5">One & Half Day</option>
                                                                <option value="2">Two Day</option>
                                                                <option value="2.5">Two & Half Day</option>
                                                                <option value="3">Three Day</option>
                                                                <option value="3.5">Three & Half Day</option>
                                                                <option value="4">Four Day</option>
                                                                <option value="4.5">Four & Half Day</option>
                                                                <option value="5">Five Day</option>
                                                                <option value="5.5">Five & Half Day</option>
                                                                <option value="6">Six Day</option>
                                                                <option value="6.5">Six & Half Day</option>
                                                                <option value="7">Seven Day</option>
                                                                <option value="7.5">Seven & Half Day</option>
                                                                <option value="8">Eight Day</option>
                                                                <option value="8.5">Eight & Half Day</option>
                                                                <option value="9">Nine Day</option>
                                                                <option value="9.5">Nine & Half Day</option>
                                                                <option value="10">Ten Day</option>
                                                                <option value="10.5">Ten & Half Day</option>
                                                            </datalist>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Leave Date From</label>
                                                            <input type="text" class="ldatefrom form-control"
                                                            autocomplete="off" name="fromDate" id="fromDate" placeholder="Date From"
                                                                required autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3 col-md-3 col-12 dateTo">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Leave Date To</label>
                                                            <input type="text" class="ldateto form-control"
                                                            autocomplete="off" name="toDate" id="toDate" placeholder="Date To"
                                                                required autocomplete="off">
                                                        </div>
                                                    </div>

                                                    

                                                    
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-12">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1">Reason for
                                                                leave</label>
                                                            <textarea placeholder="Write your reason here.."
                                                                name="leave_reason" class="form-control"
                                                                id="exampleFormControlTextarea1" rows="3"
                                                                required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row" id="medical_certificate_upload">
                                                    <div class="col-4 text-center">
                                                        <img src="<?php echo base_url(); ?>assets/dist/img/file_upload.png" class="img-thumbnail"
                                                            width="130" height="130" id="uploadedImage" alt="Medical Certificate">
                                                        <div class="profileImg">
                                                            <div class="file btn btn-sm btn-primary">
                                                                UPLOAD
                                                                <input type="file" class="form-control-sm" id="vImg" name="userfile" accept=".jpg,.png,.jpeg">
                                                            </div>
                                                        </div>
                                                        <!-- <span class="text-danger font-weight-bold">(The Image maximum size is 300KB)</span> -->
                                                        <span id="certificate_msg" class="text-danger font-weight-bold"></span>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6 class="mb-1 pull-left">Work Assign during my absence.</h6>
                                                        <button type="button" class="btn btn-danger pull-right"
                                                            data-toggle="modal" data-target="#assignClassModel">Assign
                                                            Work</button>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-sm-12">
                                                                <table id="staffAssignTableNew"
                                                                    class="table mb-0 table-bordered">
                                                                    <thead>
                                                                        <tr class="text-white bg-primary text-center">
                                                                            <th>Date</th>
                                                                            <th>Period</th>
                                                                            <th>Class</th>
                                                                             <th>Stream</th>
                                                                            <th>Section</th>
                                                                            <th>Staff</th>
                                                                            <th class="text-center">Actions</th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
<!-- 
                                                <hr class="mt-0 mb-1"> -->
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-12">
                                                        <button type="submit"
                                                            class="btn btn-success btn-md float-right">Apply
                                                            Leave</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="family" role="tabpanel"
                                            aria-labelledby="family-tab">

                                            <table class="table profile_table table-bordered">
                                                <?php if(!empty($leaveInfo)){ ?>
                                                <tbody>
                                                    <tr>
                                                        <th width="200" class="text-center">Casual Leave </th>
                                                        <td width="80" class="text-center">
                                                            <?php echo $leaveInfo->casual_leave_earned;  ?></td>
                                                        <th width="150" class="text-center">Remaining </th>
                                                        <td width="80">
                                                            <?php echo $leaveInfo->casual_leave_earned - $used_leave_cl->total_days_leave; ?>
                                                        </td>
                                                        <th width="130" class="text-center">Used </th>
                                                        <td width="80">
                                                            <?php echo $used_leave_cl->total_days_leave; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center">Medical Leave </th>
                                                        <td class="text-center">
                                                            <?php echo $leaveInfo->sick_leave_earned;  ?></td>
                                                        <th class="text-center">Remaining </th>
                                                        <td><?php echo $leaveInfo->sick_leave_earned - $used_leave_ml->total_days_leave; ?>
                                                        </td>
                                                        <th width="130" class="text-center">Used </th>
                                                        <td width="80">
                                                            <?php echo $used_leave_ml->total_days_leave; ?>
                                                        </td>
                                                    </tr>
                                                    <?php if (!empty($leaveInfo->marriage_leave_earned)) { ?>
                                                        <tr>
                                                            <th class="text-center">Marriage Leave </th>
                                                            <td class="text-center">
                                                                <?php echo $leaveInfo->marriage_leave_earned;  ?></td>
                                                            <th class="text-center">Remaining </th>
                                                            <td><?php echo $leaveInfo->marriage_leave_earned - $used_leave_marl->total_days_leave; ?>
                                                            </td>
                                                            <th width="130" class="text-center">Used </th>
                                                            <td width="80">
                                                                <?php echo $used_leave_marl->total_days_leave; ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>

                                                    <?php if (!empty($leaveInfo->paternity_leave_earned)) { ?>
                                                        <tr>
                                                            <th class="text-center">Paternity Leave </th>
                                                            <td class="text-center">
                                                                <?php echo $leaveInfo->paternity_leave_earned;  ?></td>
                                                            <th class="text-center">Remaining </th>
                                                            <td><?php echo $leaveInfo->paternity_leave_earned - $used_leave_pl->total_days_leave; ?>
                                                            </td>
                                                            <th width="130" class="text-center">Used </th>
                                                            <td width="80">
                                                                <?php echo $used_leave_pl->total_days_leave; ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>

                                                    <?php if (!empty($leaveInfo->maternity_leave_earned)) { ?>
                                                        <tr>
                                                            <th class="text-center">Maternity Leave </th>
                                                            <td class="text-center">
                                                                <?php echo $leaveInfo->maternity_leave_earned;  ?></td>
                                                            <th class="text-center">Remaining </th>
                                                            <td><?php echo $leaveInfo->maternity_leave_earned - $used_leave_matl->total_days_leave; ?>
                                                            </td>
                                                            <th width="130" class="text-center">Used </th>
                                                            <td width="80">
                                                                <?php echo $used_leave_matl->total_days_leave; ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php if (!empty($leaveInfo->earned_leave)) { ?>
                                                        <tr>
                                                            <th class="text-center">Earned Leave </th>
                                                            <td class="text-center">
                                                                <?php echo $leaveInfo->earned_leave;  ?></td>
                                                            <th class="text-center">Remaining </th>
                                                            <td><?php echo $leaveInfo->earned_leave - $used_leave_el->total_days_leave; ?>
                                                            </td>
                                                            <th width="130" class="text-center">Used </th>
                                                            <td width="80">
                                                                <?php echo $used_leave_el->total_days_leave; ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php if(!empty($leaveInfo->official_duty_earned)){ ?>
                                                    <tr>
                                                        <th class="text-center">Official Duty </th>
                                                        <td class="text-center">
                                                            <?php echo $leaveInfo->official_duty_earned;  ?></td>
                                                        <th class="text-center">Remaining </th>
                                                        <td><?php echo $leaveInfo->official_duty_earned - $used_leave_od->total_days_leave; ?>
                                                        </td>
                                                        <th width="130" class="text-center">Used </th>
                                                        <td width="80">
                                                            <?php echo $used_leave_od->total_days_leave; ?>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                    <tr class="color-red">
                                                        <th colspan="2" class="text-center">Total Loss of Pay </th>
                                                        <td colspan="2" class="text-center color-red">
                                                            <?php echo $used_leave_lop->total_days_leave;  ?></td>
                                                    </tr>
                                                </tbody>
                                                <?php } ?>
                                            </table>

                                        </div>
                                        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">

                                            <div class="card card-small mb-4">
                                                <div class="card-body p-1 pb-2 text-center table-responsive">
                                                    <table id="leave-list" style="width:100%"
                                                        class="display nowrap table  table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Date From</th>
                                                                <th>Date To</th>
                                                                <th>Total Leaves</th>
                                                                <th>Type</th>
                                                                <th>Status</th>
                                                                <th width="100">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>


                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Date From</th>
                                                                <th>Date To</th>
                                                                <th>Total Leaves</th>
                                                                <th>Type</th>
                                                                <th>Status</th>
                                                                <th width="100">Action</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>


                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- The Modal -->
 <div class="modal" id="assignClassModel">
    <div class="modal-dialog">
        <div class="modal-content"> 

            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">Work Assign during my absence.</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
             <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="form-group">
                                <label for="role">Select Date</label>
                                <input type="text" class="assignDate form-control" id="assignedDate" placeholder="Date"
                                    required autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <label for="role">Select Period</label>
                            <select class="form-control" id="assignedPeriod">
                                <option value="">Select Period</option>
                                <option value="1">1 Period</option>
                                <option value="2">2 Period</option>
                                <option value="3">3 Period</option>
                                <option value="4">4 Period</option>
                                <option value="5">5 Period</option>
                                <option value="6">6 Period</option>
                                <option value="7">7 Period</option>
                                <option value="8">8 Period</option>
                                <option value="9">9 Period</option>
                            </select>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12">
                            <label for="role">Select Class</label>
                            <select class="form-control" id="assignedClass">
                                <option value="">Select Class</option>
                                <option value="I PUC">I PUC</option>
                                <option value="II PUC">II PUC</option>
                            </select>
                        </div>
                         <div class="col-lg-6 col-md-6 col-12">
                            <label for="role">Select Stream</label>
                            <select class="form-control" id="assignedStream">
                                <option value="">Select Stream</option>
                               <?php if(!empty($streamInfo)){
                                  foreach($streamInfo as $stream){ ?>
                                    <option value="<?php echo $stream->stream_name ?>">
                                      <?php echo $stream->stream_name ?>
                                    </option>
                                <?php }  } ?>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <label for="role">Select Section</label>
                            <select class="form-control" id="assignedSection">
                                <option value="">Select Class/Section</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="ALL">ALL (No Section)</option>
                            </select>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <label for="role">Assigned staff</label>
                            <select class="form-control input-sm" id="assigned_staff_id" name="staff_id">
                                <option value="">Select Staff </option>
                                <?php
                            if(!empty($staffInfo))
                            {
                                foreach ($staffInfo as $rl)
                                {
                                    ?>
                                <option value="<?php echo $rl->staff_id ?>">
                                    <?php echo $rl->name ?></option>
                                <?php
                                }
                            }
                        ?>
                            </select>
                        </div>
                    </div>


                    <hr class="mt-1 mb-1"> 
                    <!-- Modal footer -->

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <button type="button" class="btn pull-right btn-primary text-white" id="add" name="add"
                                onClick="productAddToTable();">ADD</button>
                            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- The leave view Modal -->
<div class="modal" id="leaveInfoModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header ">
                <h4 class="modal-title">View Leave Info of <span id="staff_name_view"></span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding:0px;">
                <div class="card-body contents-body">
                    <div class="row">
                        <div class="col-lg-8 col-8">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr class="table-danger">
                                        <td>Date From</td>
                                        <td id="date_from_view"></td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td>Date To</td>
                                        <td id="date_to_view"></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td>Total Days</td>
                                        <td id="total_day_view"></td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td>Leave Type</td>
                                        <td id="leave_type_view"></td>
                                    </tr>
                                    <tr class="table-info">
                                        <td>Reason</td>
                                        <td id="reason_view"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-4 col-4">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr class="table-danger">
                                        <td class="text-center" colspan="2">Quick Info Remaining</td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td>Casual Leave </td>
                                        <td id="casual_pending"></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td>Medical Leave</td>
                                        <td id="medical_pending"></td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td>Marriage Leave</td>
                                        <td id="marriage_pending"></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td>Paternity Leave</td>
                                        <td id="paternity_pending"></td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td>Maternity Leave</td>
                                        <td id="maternity_pending"></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td>Earned Leave</td>
                                        <td id="earned_pending"></td>
                                    </tr>
                                    <tr class="table-primary">
                                        <td>Official Duty</td>
                                        <td id="official_duty_pending"></td>
                                    </tr>
                                    <tr class="table-success">
                                        <td>Loss Of Pay Used</td>
                                        <td id="loss_of_pay_used"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <hr class="mt-1 mb-1">

                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <h6 class="mb-1 text-center">Work Assign during absence time.</h6>
                            <hr class="mt-0 mb-0" />
                            <table id="staffAssignTable" class="table table-bordered">
                                <thead>
                                    <tr class="text-center text-white bg-primary ">
                                        <th>Date</th>
                                        <th>Period</th>
                                        <th>Class</th>
                                        <th>Stream</th>
                                        <th>Section</th>
                                        <th>Staff ID</th>
                                    </tr>

                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
<!-- 
                    <hr class="mt-1 mb-1"> -->
                    <!-- Modal footer -->
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <span id="approveButton"></span>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>
<script>
    $(document).ready(function() {
        
        $('#leaveType').change(function() {
            var leaveType = $(this).val();
            if (leaveType === '') {
                $('#days_no, #fromDate').prop('disabled', true);
            } else {
                $('#days_no, #fromDate').prop('disabled', false);
            }
           
        }).change();

        $('.dateTo').hide();
        $('#days_no').on('input', function() {
            var days = this.value;
            if (days > 1) {
                $('.dateTo').show();
                $('#toDate').prop('required', true);
            } else {
                $('.dateTo').hide();
                $('#toDate').prop('required', false);
            }
        });
       
        $('#toDate').on('change', validateDates);


    });
</script>
<script>
jQuery(document).ready(function() {

    $('#leave-list thead tr').clone(true).appendTo('#leave-list thead');
    $('#leave-list thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        var newClassupdate = '';
        if (title == 'Date From') {
            var newClassupdate = 'datepicker_from';
        }
        if (title == 'Date To') {
            var newClassupdate = 'datepicker_to';
        }
        if (title == 'Status') {
            $(this).html(`<div class="form-group position-relative mb-0 mt-0" style="margin-top: -5px !important; margin-bottom: -5px !important;" >
            <input placeholder="Total Number of Leave" class=" form-control"
           type="text" list="leave_status" required />
            <datalist id="leave_status">
                <option>Approved</option>
                <option>Pending</option>
                <option>Rejected</option>
              
            </datalist>
            </div>`);
        } else {
            $(this).html(
                '<div class="form-group position-relative mb-0 mt-0" style="margin-top: -5px !important; margin-bottom: -5px !important;" ><input style="border: 1px solid #75787b !important;" type="text" class="form-control input-sm ' +
                newClassupdate + '" placeholder="Search ' +
                title + '" /> </div>');
        }
        $('input', this).on('keyup change', function() {
            if (table.column(i).search() !== this.value) {
                table
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });


    var table = $('#leave-list').DataTable({
        lengthMenu: [
            [50, 20, 10],
            [50, 20, 10]
        ],
        // pageLength: 200,
        processing: true,
        orderCellsTop: true,
        fixedHeader: true,
        language: {
            "info": "Showing _START_ to _END_ of _TOTAL_ Leave",
            "infoFiltered": "(filtered from _MAX_ total staff Leave)",
            "search": "",
            searchPlaceholder: "Search Leave",
            "lengthMenu": "Show _MENU_ Leave",
            "infoEmpty": "Showing 0 to 0 of 0 Leave",
            //processing: '<img src="'+baseURL+'assets/images/loader.gif" width="150"  alt="loader">'
        },

        "ajax": {
            url: '<?php echo base_url(); ?>/get_single_staff_applied_leave_info ',
            type: 'POST',

            // dataType: 'json',
        },

    });
    jQuery('.assignDate, .datepicker_from, .datepicker_to, #dateAssigned, #fromDate, #toDate').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy",
        // startDate: new Date('2021-06-01'),
        // endDate: new Date('2023-06-01')
    });

    $('#medical_certificate_upload').hide();
    $("#leaveType").change(function(){
        var leave_type = $("#leaveType").val();
        if(leave_type == 'ML'){
            $('#medical_certificate_upload').show();
            $('#vImg').prop('required',true);
        }else{
            $('#medical_certificate_upload').hide();
            $('#vImg').prop('required',false);
        }
    });

});
</script>
<script>
function validateDates() {
  
    var fromDate = new Date(document.getElementById('fromDate').value);
    var toDate = new Date(document.getElementById('toDate').value);
    var totalDays = parseFloat(document.getElementById('days_no').value);

    if (isNaN(fromDate.getTime()) || isNaN(toDate.getTime()) || isNaN(totalDays)) {
        return;
    }

   
    var dayCount = 0;
    var currentDate = new Date(fromDate);

    while (currentDate <= toDate) {
        var dayOfWeek = currentDate.getDay();
        if (dayOfWeek !== 0) { // Exclude Sundays (0 is Sunday)
            dayCount++;
        }
        currentDate.setDate(currentDate.getDate() + 1);
    }

    if (dayCount !== totalDays) {
        
        Swal.fire({
            icon: 'error',
            title: 'Invalid Date Range',
            text: 'Please ensure the selected dates cover exactly ' + totalDays + ' working days.',
        });
        document.getElementById('toDate').value = '';
    }
}
function productAddToTable() {
    if ($("#staffAssignTableNew tbody").length == 0) {
        $("#staffAssignTableNew").append("<tbody></tbody>");
    }
    if ($("#assignedDate").val() == 0) {
        alert('Please Select Assigned Date');
        return;
    }
    if ($("#assignedPeriod").val() == "") {
        alert('Please Select  Period to Assign');
    } else if ($("#assignedClass").val() == "") {
        alert('Please Select Class');
    } else if ($("#assignedStream").val() == "") {
        alert('Please Select Stream');
    }else if ($("#assigned_staff_id").val() == "") {
        alert('Please Select Staff');
    } else {
        // Append product to the table
        $("#staffAssignTableNew tbody").append(
            "<tr>" +
            "<td>" +
            $("#assignedDate").val() +
            "<input type='hidden' name='assignedDate[]'  id='dateAssigned' value=" + $("#assignedDate").val() +
            ">" +
            "<input type='hidden' name='assignedPeriod[]' id='assigned_period' value=" + $("#assignedPeriod")
            .val() + ">" +
            "<input type='hidden' name='assignedClass[]' id='class_assigned' value=" + $("#assignedClass").val() +
            ">" +
            "<input type='hidden' name='assignedStream[]' id='class_assigned' value=" + $("#assignedStream").val() +
            ">" +
            "<input type='hidden' name='assignedSection[]' id='section_assigned' value=" + $("#assignedSection")
            .val() + ">" +
            "<input type='hidden' name='assigned_staff_id[]' id='staff_id_assigned' value=" + $(
                "#assigned_staff_id").val() + ">" +
            "</td>" +
            "<td>" + $("#assignedPeriod").val() +
            "</td>" +
            "<td>" + $("#assignedClass").val() +
            "</td>" +
            "<td>" + $("#assignedStream").val() +
            "</td>" +
            "<td>" + $("#assignedSection").val() +
            "</td>" +
            "<td>" + $("#assigned_staff_id option:selected").text() +
            "</td>" +
            '<td class="text-center"> <a class="btn btn-sm btn-danger text-white " title="Delete"  onclick="deleteRow(this)"><i class="fa fa-trash"></i></a></td>' +
            "</tr>"
        );
    }
}


function deleteRow(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

function viewMoreInfo(row_id) {
    $("#staffAssignTable tbody").html("");
    $.ajax({
        url: '<?php echo base_url(); ?>/getStaffLeaveInfoById',
        type: 'POST',
        dataType: 'json',
        data: {
            row_id: row_id,
        },
        success: function(data) {
            //format date as per indian standard
            let current_datetime = new Date(data.leaveInfo.date_from);
            let formatted_date_from_date = appendLeadingZeroes(current_datetime.getDate()) + "-" +
                appendLeadingZeroes((current_datetime.getMonth() + 1)) +
                "-" + current_datetime.getFullYear();

            let current_datetime_to = new Date(data.leaveInfo.date_to);
            let formatted_date_to_date = appendLeadingZeroes(current_datetime_to.getDate()) + "-" +
                appendLeadingZeroes((current_datetime_to.getMonth() + 1)) +
                "-" + current_datetime_to.getFullYear();
            var leave_type = "";
            if (data.leaveInfo.leave_type == 'LOP') {
                leave_type = "LOSS OF PAY";
            } else if (data.leaveInfo.leave_type == 'CL') {
                leave_type = "CASUAL LEAVE";
            } else if (data.leaveInfo.leave_type == 'MARL') {
                leave_type = "MARRIAGE LEAVE";
            } else if (data.leaveInfo.leave_type == 'PL') {
                leave_type = "PATERNITY LEAVE";
            } else if (data.leaveInfo.leave_type == 'MATL') {
                leave_type = "MATERNITY LEAVE";
            } else if (data.leaveInfo.leave_type == 'ML') {
                leave_type = "MEDICAL LEAVE";
            }
            $("#staff_name_view").html(data.leaveInfo.name);
            $("#date_from_view").html(formatted_date_from_date);
            $("#date_to_view").html(formatted_date_to_date);
            $("#total_day_view").html(data.leaveInfo.total_days_leave);
            $("#leave_type_view").html(leave_type);
            $("#reason_view").html(data.leaveInfo.leave_reason);

            $("#casual_pending").html(data.leavePending.casual_leave_earned - data.used_leave_cl.total_days_leave);

            $("#medical_pending").html(data.leavePending.sick_leave_earned - data.used_leave_ml.total_days_leave);

            $("#marriage_pending").html(data.leavePending.marriage_leave_earned - data.used_leave_marl.total_days_leave);

            $("#paternity_pending").html(data.leavePending.paternity_leave_earned - data.used_leave_pl.total_days_leave);

            $("#maternity_pending").html(data.leavePending.maternity_leave_earned - data.used_leave_matl.total_days_leave);

            $("#earned_pending").html(data.leavePending.earned_leave - data.used_leave_el.total_days_leave);
            $("#official_duty_pending").html(data.leavePending.official_duty_earned - data.used_leave_od.total_days_leave);



            $("#loss_of_pay_used").html(data.used_leave_lop.total_days_leave);



            for (var i = 0; i < Object.keys(data.workAssign).length; i++) {
                var work_assign_date = new Date(data.workAssign[i].assigned_date);
                var work_assign_date_valid = appendLeadingZeroes(work_assign_date.getDate()) + "-" +
                    appendLeadingZeroes((work_assign_date.getMonth() + 1)) +
                    "-" + work_assign_date.getFullYear();
                $("#staffAssignTable tbody").append(
                    "<tr class='text-center'>" +
                    "<td >" +
                    work_assign_date_valid +
                    "</td>" +
                    "<td >" + data.workAssign[i].assigned_period +
                    "</td>" +
                    "<td >" + data.workAssign[i].assigned_class_name +
                    "</td>" +
                    "<td >" + data.workAssign[i].assigned_stream_name +
                    "</td>" +
                    "<td >" + data.workAssign[i].assigned_class_section +
                    "</td>" +
                    "<td >" + data.workAssign[i].assigned_staff_id +
                    "</td>" +
                    "</tr>"
                );
            }
            if (Object.keys(data.workAssign).length == 0) {
                $("#staffAssignTable tbody").append(
                    "<tr>" +
                    "<td class='text-center' colspan='6'> Work assign not found! </td>" +
                    "</tr>"
                );
            }
            var approveButton = "";

            if (data.leaveInfo.approved_status == 0) {
                approveButton = "<b class='pull-right' style='color:red;'>Pending</b>";
            } else if (data.leaveInfo.approved_status == 1) {
                approveButton = "<b class='pull-right' style='color:green;'>Approved</b>";
            } else {
                approveButton = "<b class='pull-right' style='color:red;'>Rejected</b>";
            }
            $("#approveButton").html(approveButton);
            $('#leaveInfoModel').modal('show');
        },
        error: function(result) {
            alert("Network Server Error!!  Failed");
        },
        fail: (function(status) {
            alert("Server Error!!  Failed");
        }),
        beforeSend: function(d) {}
    });
}

function appendLeadingZeroes(n) {
    if (n <= 9) {
        return "0" + n;
    }
    return n;
}


function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#uploadedImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#vImg").change(function() {
    if(this.files[0].type === 'application/pdf'){
        alert('Upload Only JPG, PNG or JPEG Files');
        $("#vImg").val('');
    }else{
        var file_size = this.files[0].size;
        if(file_size <= 305000){
            readURL(this);
            $('#certificate_msg').html("");
        }else{
            $("#vImg").val('');
            $('#certificate_msg').html("File size should be less than 300KB"); 
        }
    }
});
</script>