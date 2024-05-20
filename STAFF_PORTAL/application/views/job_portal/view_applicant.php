<style>
    .table-applicant{
        width: 12%;
        background-color: #3c8dbc !important;
        color:white;
    }
    /* .table-application{
        background-color: #a6d786 !important;
    } */
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        padding: 7px !important;
        line-height: 1.0 !important;
        vertical-align: top !important;
        border-top: 1px solid #ddd;
        border: 1px solid black !important;
    
    }
    .head-title{
        font-size:20px;
        color:white;
        background-color:#3c8dbc;
    }
</style>
<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-1 card-content-title">
                        <div class="row ">
                            <div class="col-lg-8 col-md-8 col-8 text-black" style="font-size:22px;">
                                <i class="fa fa-users"></i>&nbsp;Job Applicant Info  <?=$info->fullname;?>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4"> 
                            <a href="<?php echo base_url().'jobPortal'?>" type="button"
                                        class="btn btn-secondary text-white float-right">Back</a>
                                        <!-- <a onclick="showLoader();window.history.back();" type="button"
                                        class="btn btn-primary text-white">Back</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- form start -->
        <!-- Default Light Table -->
        <?php if(empty($info)){ ?>
        <div class="row form-employee">
            <div class="col-lg-12 col-md-12 col-12 pr-0 text-center">
            <img height="270" src="<?php echo base_url(); ?>assets/images/404.png"/>
            </div>
        </div>
        <?php } else {  ?>
        <div class="row form-employee">
            <div class="col-12">
                <div class="card card-small c-border p-0 mb-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item p-1">
                            <div class="row">
                                <div class="col profile-head">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="personal-tab" data-toggle="tab"
                                                href="#personal" role="tab" aria-controls="personal"
                                                aria-selected="false">Personal Info</a>
                                        </li>
                                       
                                        <?php if($info->shortlisted_status != 1 ){ ?>

                                        <li class="nav-item">
                                            <a class="nav-link" id="approve-tab" data-toggle="tab" href="#approve"
                                                role="tab" aria-controls="approve" aria-selected="true">Approve/Reject</a>
                                        </li>
                                        <?php }?>

                                      
                                    </ul>
                                    <div class="tab-content personal-tab" id="myTabContent">
                                        <div class="tab-pane fade show active" id="personal" role="tabpanel"
                                            aria-labelledby="personal-tab">
                                            <div class="table-responsive-sm table-responsive-md table-responsive-xs">
                                                <table class="table table-bordered">
                                                    <input type="hidden"  value="<?=$info->row_id;?>" id="applicant_id" name="applicant_id"/>
                                                    <tr>
                                                        <td colspan="1" rowspan="6" width="80">
                                                            <img src="<?=JOB_PORTAL_PATH.$info->profile_picture;?>" alt="Applicant Profile Photo" class="mt-1" width="140" height="140">
                                                        </td>
                                                        <td class="table-applicant">Full Name</td>
                                                        <th><?=$info->fullname;?></th>
                                                        <td class="table-applicant">Subject</td>
                                                        <th><?=$info->subject;?></th>
                                                        <td class="table-applicant">Mobile No.</td>
                                                        <th><?=$info->mobile_number;?></th>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-applicant">Date of Birth</td>
                                                        <th><?=date('d-m-Y',strtotime($info->dob));?></th>
                                                        <td class="table-applicant">Email ID</td>
                                                        <th><?=$info->email_id;?></th>
                                                        <td class="table-applicant">Mother Tongue</td>
                                                        <th><?=$info->mother_tongue;?></th>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-applicant">Religion</td>
                                                        <th><?=$info->religion;?></th>
                                                        <td class="table-applicant">Caste</td>
                                                        <th><?=$info->cast;?></th>
                                                        <td class="table-applicant">Languages Known</td>
                                                        <th><?php
                                                                $lkArr = json_decode($info->languages_known);
                                                                $lkStr = "";
                                                                if(!empty($lkArr)){
                                                                    foreach($lkArr as $ind=>$lang){
                                                                        (count($lkArr)-1 == $ind )
                                                                        ? $lkStr = $lkStr.$lang
                                                                        : $lkStr = $lkStr.$lang.",";
                                                                    }
                                                                }
                                                                echo($lkStr);
                                                            ?>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-applicant">Blood Group</td>
                                                        <th><?=$info->blood_group;?></th>
                                                        <td class="table-applicant">Marital Status</td>
                                                        <th><?=$info->marital_status;?></th>
                                                        <td class="table-applicant">Hobbies/Interests</td>
                                                        <th><?=$info->hobbies_interests;?></th>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-applicant">Address</td>
                                                        <th><?=$info->address;?></th>
                                                        <td class="table-applicant">Work Experience</td>
                                                        <th><?=$info->work_experience;?></th>
                                                        <td class="table-applicant">Expected Salary</td>
                                                        <th><?=$info->expected_salary;?></th>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-applicant">Jop post</td>
                                                        <th><?=$info->job_post;?></th>
                                                        
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="table-responsive-sm table-responsive-md table-responsive-xs">
                                                <table class="table table-bordered table-application" style="margin-top:3%;">
                                                    <thead>
                                                        <tr class="head-title text-center">
                                                            <th colspan="4">Academic Qualification</th>
                                                        </tr>
                                                        <tr>
                                                            <td class="table-applicant" style="width:25%">SSLC / 10<sup>th</sup> marks (in %)</td>
                                                            <th style="width:25%"><?=$info->sslc_percent;?></th>
                                                            <td class="table-applicant" style="width:25%">PUC marks (in %)</td>
                                                            <th style="width:25%"><?=$info->puc_percent;?></th>
                                                        </tr>
                                                        <tr>
                                                            <td class="table-applicant">Under Graduation marks (in %)</td>
                                                            <th><?=$info->ug_percent;?></th>
                                                            <td class="table-applicant">Post Graduation Marks (in %)</td>
                                                            <th><?=$info->pg_percent;?></th>
                                                        </tr>
                                                        <tr>
                                                            <td class="table-applicant">B.Ed Marks (in %)</td>
                                                            <th><?=$info->bed_percent;?></th>
                                                            <td class="table-applicant">Qualification</td>
                                                            <th><?=$info->qualification;?></th>
                                                        </tr>
                                                        <tr>
                                                            <td class="table-applicant">Additional Qualification</td>
                                                            <th><?=$info->additional_qualification;?></th>
                                                            <td class="table-applicant">Resume</td>
                                                            <th>
                                                                <a class="btn btn-sm btn-block btn-secondary" target="_blank" href="<?=JOB_PORTAL_PATH.$info->resume;?>" title="View Resume">
                                                                    <i class="fa fa-file"></i> View Resume
                                                                </a>
                                                            </th>
                                                        </tr>
                                                    <thead>
                                                </table> 
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="approve" role="tabpanel" aria-labelledby="approve-tab">
                                            <input type="hidden" value="<?php echo $info->row_id; ?>" id="application_number" name="application_number">
                                            <div class="row">
                                                      
                                                <div class="col-12">
                                                <form role="form" action="<?php echo base_url() ?>updateStudentJobStatus" method="post">
                                                        <input type="hidden" name="application_number" value="<?php echo $info->row_id; ?>"/>
                                                        <!-- <input type="hidden" name="register_row_id" value="<?php //echo $info->resgisted_tbl_row_id; ?>"/> -->
                                                        <div class="form-group">
                                                            <textarea id="comments" class="form-control application_comments" rows="3" name="comments" id="comments" placeholder="Any Comment" autocomplete="off"><?php echo $info->comments; ?></textarea>
                                                        </div> 

                                                        <?php  
                                                        if($info->approved_status != 2){ ?>
                                                            <button type="submit" class="float-left btn btn-danger text-white" title="Reject" name="add"  id="rejectJobApplication"
                                                            data-application_number="<?php echo $info->row_id; ?>">Reject</button>
                                                        <?php }else{?>
                                                            <b class="float-left text-danger">Rejected</b>
                                                        <?php } ?>
                                                    </form>
                                                    <?php if($info->approved_status	!= 1){ ?>
                                                        <button type="button" class="btn float-right btn-success text-white ml-2" title="Approve" id="approveJobApplication" name="add" data-dismiss="modal"
                                                        data-application_number="<?php echo $info->row_id; ?>">Approve</button>
                                                    <?php }else{?>
                                                        <b class="float-right text-success">Approved</b>
                                                    <?php } ?>
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
        <!-- End Default Light Table -->
        
        <?php } ?>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/jobportal.js" type="text/javascript"></script>      