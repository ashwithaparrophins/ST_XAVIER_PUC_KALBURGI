
<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-1 card-content-title">
                        <div class="row ">
                            <div class="col-lg-8 col-md-8 col-8 text-black" style="font-size:22px;">
                                <i class="fa fa-users"></i>&nbsp;Detailed View of <?php echo $studentInfo->student_name; ?>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4"> 
                                <a href="#" onclick="GoBackWithRefresh();return false;" class="btn text-white primary_color btn-bck float-right mobile-bck ">
                                <i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- form start -->
        <!-- Default Light Table -->
        <?php if(empty($studentInfo)){ ?>
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
                                        <li class="nav-item">
                                            <a class="nav-link" id="academic-tab" data-toggle="tab" href="#academic"
                                                role="tab" aria-controls="academic" aria-selected="true">Academic
                                                Info</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="attendance-tab" data-toggle="tab"
                                                href="#attendanceqw" role="tab" aria-controls="attendance"
                                                aria-selected="true">Attendance
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="first_unit_test-tab" data-toggle="tab" href="#first_unit_test"
                                                role="tab" aria-controls="first_unit_test" aria-selected="true">I Unit Test
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" id="mid_term-tab" data-toggle="tab" href="#mid_term"
                                                role="tab" aria-controls="mid_term" aria-selected="true">MID TERM
                                            </a>
                                        </li> 
                                        <li class="nav-item">
                                            <a class="nav-link" id="second_unit_test-tab" data-toggle="tab" href="#second_unit_test"
                                                role="tab" aria-controls="second_unit_test" aria-selected="true">II Unit Test
                                            </a>
                                        </li>
                                    <?php if ($role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_ACCOUNTS || $role == ROLE_PRINCIPAL ) { ?>

                                        <li class="nav-item">
                                            <a class="nav-link" id="paidInfo-tab" data-toggle="tab" href="#paidInfo"
                                                role="tab" aria-controls="paidInfo" aria-selected="true">Fee Paid Info</a>
                                        </li>
                                    <?php } ?>
                                        <!-- <li class="nav-item">
                                            <a class="nav-link" id="first_term-tab" data-toggle="tab" href="#first_term"
                                                role="tab" aria-controls="first_term" aria-selected="true">I Term
                                            </a>
                                        </li> -->
                                        <!-- 
                                        
                                        <li class="nav-item">
                                            <a class="nav-link" id="preparatory-tab" data-toggle="tab" href="#preparatory"
                                                role="tab" aria-controls="preparatory" aria-selected="true">Preparatory
                                            </a>
                                        </li> -->

                                        <li class="nav-item">
                                            <a class="nav-link" id="remarks-tab" data-toggle="tab" href="#remarksqw"
                                                role="tab" aria-controls="remarks" aria-selected="true">  Remarks
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="notification-tab" data-toggle="tab" href="#notification"
                                                role="tab" aria-controls="notification" aria-selected="true">Notification</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content personal-tab" id="myTabContent">
                                        <div class="tab-pane fade show active" id="personal" role="tabpanel"
                                            aria-labelledby="personal-tab">
                                            <div class="table-responsive-sm table-responsive-md table-responsive-xs">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td style="background:white" width="160" rowspan="8" class="p-0">
                                                            <div class="profile-img">
                                                        
                                                            <?php  ;
                                                               $profileImg = $studentInfo->photo_url;
                                                                if(!empty($profileImg)){ ?>
                                                                  <img src="<?php echo $profileImg; ?>" class="avatar img-thumbnail"
                                                                 alt="Profile Image" id="uploadedImage"/>
                                                               <?php } else { ?>
                                                                <img src="<?php echo base_url(); ?>assets/dist/img/user.png" class="avatar img-thumbnail"
                                                               id="uploadedImage" alt="Profile default">
                                                              <?php } ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <th class="tbl-head" width="80">Application No.</th>
                                                        <th class="tbl-head-content" width="120">
                                                            <?php echo $studentInfo->application_no; ?>
                                                        </th>
                                                        <th class="tbl-head text-uppercase" width="140">Full Name</th>
                                                        <th class="tbl-head-content text-uppercase" width="240">
                                                            <?php echo $studentInfo->student_name; ?>
                                                        </th>
                                                        <th class="tbl-head" width="140">Date of Birth</th>
                                                        <th class="tbl-head-content" width="120">
                                                            <?php if(empty($studentInfo->dob) || $studentInfo->dob == '0000-00-00'){
                                                                echo "";
                                                            } else{
                                                                echo date('d-m-Y',strtotime($studentInfo->dob));
                                                            } ?>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="tbl-head" width="140">Gender</th>
                                                        <th class="tbl-head-content" width="180">
                                                            <?php echo $studentInfo->gender; ?>
                                                        </th>
                                                        <th class="tbl-head">Blood Group</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->blood_group; ?>
                                                        </th>
                                                        <th class="tbl-head">Nationality</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->nationality; ?>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="tbl-head">Religion</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->religion; ?>
                                                        </th>
                                                        <th class="tbl-head">Caste</th>
                                                        <th class="tbl-head-content"><?php echo $studentInfo->caste; ?></th>
                                                        <th class="tbl-head">Category</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->category; ?>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                    <th class="tbl-head">Sub Caste</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->sub_caste; ?>
                                                        </th>
                                                        <th class="tbl-head">Mother Tongue</th>
                                                        <th class="tbl-head-content text-uppercase">
                                                            <?php echo $studentInfo->mother_tongue; ?>
                                                        </th>
                                                      
                                                        <th class="tbl-head">Mobile</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->mobile; ?>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                    <th class="tbl-head">State</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->state; ?>
                                                        </th>
                                                        <th class="tbl-head">Pincode</th>
                                                        <th class="tbl-head-content text-uppercase">
                                                            <?php echo $studentInfo->pincode; ?>
                                                        </th>
                                                        <th class="tbl-head">Aadhar No</th>
                                                        <th class="tbl-head-content text-uppercase">
                                                            <?php echo $studentInfo->aadhar_no; ?>
                                                        </th>
                                                    
                                                    </tr>
                                                    <tr>
                                                    <th class="tbl-head">Place of Birth</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->place_of_birth; ?>
                                                        </th>
                                                        <th class="tbl-head">Taluk</th>
                                                        <th class="tbl-head-content text-uppercase">
                                                            <?php echo $studentInfo->taluk; ?>
                                                        </th>
                                                        <th class="tbl-head">District</th>
                                                        <th class="tbl-head-content text-uppercase">
                                                            <?php echo $studentInfo->district; ?>
                                                        </th>
                                                    
                                                    </tr>

                                                    <tr>
                                                        <th class="tbl-head">Primary Mobile</th>
                                                        <th class="tbl-head-content">
                                                            <?php echo $studentInfo->primary_mobile; ?>
                                                        </th> 
                                                    </tr>
                                                  
                                                </table>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="head-title">
                                                            <th colspan="7" class="text-center tbl-head">Family Info</th>
                                                        </tr>
                                                        <tr class="head-title tbl-head">
                                                            <th>Member Name</th>
                                                            <th>Relationship</th>
                                                            <th>Qualification</th>
                                                            <th>Profession</th>
                                                            <th>Annual Income</th>
                                                            <th>Mobile Number</th>
                                                            <th>Email Id</th>
                                                        </tr>
                                                    </thead>
                                                    <tr class="tbl-head-content">
                                                        <th class="text-uppercase"><?php echo $studentInfo->father_name; ?></th>
                                                        <th>Father</th>
                                                        <th><?php echo $studentInfo->father_educational_qualification; ?></th>
                                                        <th><?php echo $studentInfo->father_profession; ?></th>
                                                        <th><?php echo $studentInfo->father_annual_income; ?></th>
                                                        <th><?php echo $studentInfo->father_mobile; ?></th>
                                                        <th><?php echo $studentInfo->father_email; ?></th>
                                                    </tr>
                                                    <tr class="tbl-head-content">
                                                        <th class="text-uppercase"><?php echo $studentInfo->mother_name; ?></th>
                                                        <th>Mother</th>
                                                        <th><?php echo $studentInfo->mother_educational_qualification; ?></th>
                                                        <th><?php echo $studentInfo->mother_profession; ?></th>
                                                        <th><?php echo $studentInfo->mother_annual_income; ?></th>
                                                        <th><?php echo $studentInfo->mother_mobile; ?></th>
                                                        <th><?php echo $studentInfo->mother_email; ?></th>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-12 mb-1">
                                                    <div class="card" style="font-size:16px; font-weight:900">
                                                        <div class="card-header head-title text-center p-1 tbl-head">
                                                            <span style="font-size:16px; font-weight:900">Present Address
                                                            </span></div>
                                                        <div class="card-body p-1 tbl-head-content font-weight-bold">
                                                            <?php echo $studentInfo->present_address; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-12 mb-1">
                                                    <div class="card " style="font-size:16px; font-weight:900">
                                                        <div class="card-header head-title text-center p-1 tbl-head">
                                                            <span style="font-size:16px; font-weight:900">Permanent Address</span></div>
                                                        <div class="card-body p-1 tbl-head-content font-weight-bold">
                                                            <?php echo $studentInfo->permanent_address; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive mt-1">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th class="tbl-head" width="250">Physically Challenged</th>
                                                        <th class="tbl-head-content">
                                                            <?php //if($studentInfo->Is_physically_challenged == 0){ echo "No"; } else { echo "Yes"; } ?> 
                                                        <?php echo $studentInfo->Is_physically_challenged; ?> 

                                                        </th>
                                                        <th class="tbl-head" width="250">Dyslexia</th>
                                                        <th class="tbl-head-content">
                                                        <?php echo $studentInfo->is_dyslexic; ?> 

                                                        </th>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="academic" role="tabpanel" aria-labelledby="academic-tab">
                                            <table class="table table-bordered">
                                                <tr>
                                                <th class="tbl-head" width="160">Application Number</th>
                                                    <th class="tbl-head-content" width="140"><?php echo $studentInfo->application_no; ?></th>
                                                    <th class="tbl-head" width="160">PU Board No.</th>
                                                    <th class="tbl-head-content" width="140"><?php echo $studentInfo->pu_board_number; ?></th>
                                                    <th class="tbl-head" width="160">Student ID</th>
                                                    <th class="tbl-head-content" width="140"><?php echo $studentInfo->student_id; ?></th>
                                                </tr>
                                                <tr>
                                                    <th class="tbl-head">Elective</th>
                                                    <th class="tbl-head-content"><?php echo $studentInfo->elective_sub; ?></th>
                                                    <th class="tbl-head">Term</th>
                                                    <th class="tbl-head-content"><?php echo strtoupper($studentInfo->term_name); ?></th>
                                                    <th class="tbl-head">Stream</th>
                                                    <th class="tbl-head-content"><?php echo strtoupper($studentInfo->stream_name); ?></th>
                                                   
                                                <tr>
                                                <th class="tbl-head">Section</th>
                                                    <th class="tbl-head-content"><?php echo strtoupper($studentInfo->section_name); ?></th>
                                                    <th class="tbl-head">Hall Ticket No.</th>
                                                    <th class="tbl-head-content"><?php echo strtoupper($studentInfo->hall_ticket_no); ?></th>
                                                    <th class="tbl-head">Date of Admmission</th>
                                                    <th class="tbl-head-content"><?php echo date('d-m-Y',strtotime($studentInfo->date_of_admission)); ?></th>
                                                </tr>
                                                <tr>
                                                <th class="tbl-head">SAT Number</th>
                                                    <th class="tbl-head-content"><?php echo $studentInfo->sat_number; ?></th>
                                                    <th class="tbl-head">Date of Join</th>
                                                    <th class="tbl-head-content"><?php if($studentInfo->doj == '0000-00-00' || $studentInfo->doj == '1970-01-01' || is_null($studentInfo->doj)){   
                                                      echo '';}else{ echo date('d-m-Y',strtotime($studentInfo->doj));} ?></th>
                                                      <th class="tbl-head">Admission No</th>
                                                      <th class="tbl-head-content"><?php echo strtoupper($studentInfo->admission_no); ?></th>

                                                    </tr>
                                                    
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="first_unit_test" role="tabpanel" aria-labelledby="first_unit_test-tab">
                                            <div class=" table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="table-success">
                                                            <th class="text-center">SUBJECTS</th>
                                                            <th class="text-center">Max. Marks</th>
                                                            <th class="text-center">Min. Marks</th>
                                                            <th class="text-center">Marks Scored</th>
                                                        </tr>
                                                    </thead>
                                                    <?php 
                                               
                                                    $result_subject_fail_status = false;
                                                    $result_fail_status = false;
                                                    $max_mark = 0;
                                                    $min_mark_pass = 0;
                                                    $total_mark_obtained = 0;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                 
                                                    for($i=0;$i<count($subject_code);$i++){
                                                        if(strtoupper($firstUnitTestMarkInfo[$i]->sub_name) != ''){ 
                                                        $result_display = "";
                                                        $result_subject_fail_status = false;
                                                        if($firstUnitTestMarkInfo[$i]->lab_status == 'true'){
                                                            $max_mark = 35;
                                                            $min_mark_pass = 12;
                                                        }else{
                                                            $max_mark = 40;
                                                            $min_mark_pass = 14;
                                                        }
                                                        $total_max_mark += $max_mark;
                                                        $total_min_mark += $min_mark_pass;
                                                        $obtainedMark = $firstUnitTestMarkInfo[$i]->obt_theory_mark;
                                                        $obatained_mark = (float)$obtainedMark;
                                                        if($obtainedMark == 'AB' || $obtainedMark == 'EXEM' || $obtainedMark == 'MP' || $obtainedMark == 'SAT'){
                                                            $result_subject_fail_status = true;
                                                            $result_display = $obtainedMark;
                                                            $result_fail_status = true;
                                                        }else if($min_mark_pass > $obatained_mark){
                                                            $result_subject_fail_status = true;
                                                            $result_fail_status = true;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark .'F';
                                                        }else{
                                                            $result_subject_fail_status = false;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark;
                                                        }
                                                    ?>
                                                <tr>
                                                    <th>
                                                        <?php echo strtoupper($firstUnitTestMarkInfo[$i]->sub_name); ?></th>
                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>
                                                    </th>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $min_mark_pass; ?></th>
                                                    <?php if($result_subject_fail_status == true){ ?>
                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php }else{ ?>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php } ?>
                                                </tr>
                                                <?php  } }
                                                       if($total_mark_obtained != 0){
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; 
                                                        $exam_result = calculateResult($total_mark_obtained);
                                                        ?>
                                                    <tr class="text-center table_row_backgrond">
                                                        <th class="total_row">Total</th>
                                                        <th><?php echo $total_max_mark; ?></th>
                                                        <th><?php echo $total_min_mark; ?></th>
                                                        <th><?php echo $total_mark_obtained; ?></th>
                                                    </tr>
    
                                                    <tr>
                                                        <th colspan="2" class="total_row">Percentage:
                                                            <?php echo round($total_percentage,2).'%'; ?></th>
                                                        <th colspan="2">Result:
                                                            <?php if($result_fail_status == true){ ?>
                                                            <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                                            <?php } else { ?>
                                                            <span class="text_pass"><?php echo 'PASS'; ?></span>
                                                            <?php } ?></th>
                                                    </tr>
                                                  <?php } ?>
                                                </table>  
                                            </div>
                                        </div>
                                        <div class="tab-pane fade p-1" id="paidInfo" role="tabpanel" aria-labelledby="paidInfo-tab">
                                            <div class="row">
                                                <div class="col-12 table-responsive">
                                                    <table class="table table-bordered">
                                                        <tr class="text-center table-primary">
                                                            <th>Date</th>
                                                            <th>Student ID</th>
                                                            <th>Class</th>
                                                            <th>Stream</th>
                                                            <th>Receipt No.</th>
                                                            <th>Amount</th>
                                                            <th>Attempt</th>
                                                            <th>Payment Type</th>
                                                            <th>Bank</th>
                                                            <th>Bank Date</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        <?php if(!empty($stdFeePaymentInfo)){
                                                        foreach($stdFeePaymentInfo as $fee){ ?>
                                                            <tr>
                                                                <th class="text-center"><?php echo date('d-m-Y',strtotime($fee->payment_date)); ?></th>
                                                                <th class="text-center"><?php echo $fee->student_id; ?></th>
                                                                <th class="text-center"><?php echo $fee->term_name; ?></th>
                                                                <th class="text-center"><?php echo $fee->stream_name; ?></th>
                                                                <th class="text-center"><?php echo $fee->ref_receipt_no; ?></th>
                                                                
                                                                <th class="text-center"><?php echo $fee->paid_amount; ?></th>
                                                                <th class="text-center"><?php if($fee->attempt == "1"){echo "First Attempt";}else{echo "Second Attempt";} ?></th>
                                                                <!-- <th class="text-center"><?php if($fee->pending_balance == 0){ ?>
                                                                    <b style="color:green"><?php echo $fee->pending_balance; ?></b>
                                                                    <?php }else{
                                                                        $feeConcession = $bill_model->getStudentFeeConcessionForview($studentInfo->row_id,'2024');
                                                                        ?>
                                                                    <b style="color:red"><?php echo $fee->pending_balance-$feeConcession->fee_amt; ?></b>
                                                                    <?php
                                                                    } ?></th> -->

                                                                <th class="text-center"><?php echo $fee->payment_type; ?></th>
                                                                <th class="text-center"><?php if($fee->bank_settlement_status == 1){
                                                                    echo "<b class='color-green'>Settled</b>";
                                                                }else{
                                                                    echo "<b class='color-red'>Pending</b>";
                                                                }  ?></th>
                                                                <th class="text-center"><?php if(!empty($fee->date)){
                                                                        echo date('d-m-Y',strtotime($fee->date)); 
                                                                    } ?>
                                                                </th>
                                                                <th>
                                                                    <a href="<?php echo base_url(); ?>feePaymentReceiptPrint/<?php echo $fee->row_id; ?>"
                                                                        target="_blank">Receipt</a>
                                                                </th>
                                                            </tr>
                                                        <?php } }else{ ?>
                                                            <tr>
                                                                <th class="text-center" colspan="12">No record found</th>
                                                            </tr>
                                                        <?php } ?>
                                                    </table>
                                                    
                                                </div>
                                            </div>
                                            <?php if(!empty($stdFeePaymentInfo)){ $paid_amt =0 ; ?>
                                                        <div class="card-body" style="padding:5px;">
                                                            <div class="row">
                                                                <div style="font-size: 18px;" class="col-12 col-lg-3">
                                                                    <b>Total Fee: Rs. <?php echo $total_fee; ?></b>
                                                                </div>
                                                                <?php $concession=0; foreach($stdFeePaymentInfo as $fee){ 
                                                                    $paid_amt += $fee->paid_amount;
                                                                } ?>
                                                                <?php  
                                                                $feeConcession = $bill_model->getStudentFeeConcessionForview($studentInfo->row_id,'2024');
                                                                $feeScholarship = $bill_model->getStudentFeeScholarshipForview($studentInfo->row_id,'2024');

                                                                ?>
                                                                <div style="font-size: 18px;" class="col-12 col-lg-3">
                                                                    <b>Concession: Rs. <?php $concession += $feeConcession->fee_amt; if($concession>0){ echo $concession; } else { echo 0; } ?></b>
                                                                </div>
                                                                <div style="font-size: 18px;" class="col-12 col-lg-3">
                                                                    <b>Paid Fee Amount: Rs. <?php echo $paid_amt; ?></b>
                                                                </div>
                                                                <div style="font-size: 18px;" class="col-12 col-lg-3"> 
                                                                    <b>Pending Fee: Rs. <?php if(($total_fee - $paid_amt - $concession)>0){ 
                                                                        if ($fee->attempt == 1) {
                                                                            echo $total_fee - $paid_amt - $concession - 2000; 
                                                                            }else{
                                                                                echo  $total_fee - $paid_amt - $concession;
                                                                            }
                                                                        }else{ echo 0; } ?></b>
                                                                </div>
                                                            </div>
                                                        </div>
                                            <?php }  ?>  
                                        </div>

                                      
                                        <!-- II UNIT TEST -->
                                      <div class="tab-pane fade" id="second_unit_test" role="tabpanel" aria-labelledby="second_unit_test-tab">
                                         <div class=" table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="table-success">
                                                            <th class="text-center">SUBJECTS</th>
                                                            <th class="text-center">Max. Marks</th>
                                                            <th class="text-center">Min. Marks</th>
                                                            <th class="text-center">Marks Scored</th>
                                                        </tr>
                                                    </thead>
                                                    <?php 
                                               
                                                    $result_subject_fail_status = false;
                                                    $result_fail_status = false;
                                                    $max_mark = 0;
                                                    $min_mark_pass = 0;
                                                    $total_mark_obtained = 0;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                 
                                                    for($i=0;$i<count($subject_code);$i++){
                                                        if(strtoupper($secondUnitTestMarkInfo[$i]->name) != ''){ 
                                                        $result_display = "";
                                                        $result_subject_fail_status = false;
                                                        if($secondUnitTestMarkInfo[$i]->lab_status == 'true'){
                                                            $max_mark = 35;
                                                            $min_mark_pass = 12;
                                                        }else{
                                                            $max_mark = 40;
                                                            $min_mark_pass = 14;
                                                        }
                                                        $total_max_mark += $max_mark;
                                                        $total_min_mark += $min_mark_pass;
                                                        $obtainedMark = $secondUnitTestMarkInfo[$i]->obt_theory_mark;
                                                        // if($studentInfo->term_name == 'II PUC'){
                                                        //     $obatained_mark = (float)$obtainedMark * 2;
                                                        // }else{
                                                            $obatained_mark = $obtainedMark;
                                                        // }
                                                        if($obtainedMark == 'AB' || $obtainedMark == 'EXEM' || $obtainedMark == 'MP' || $obtainedMark == 'SAT'){
                                                            $result_subject_fail_status = true;
                                                            $result_display = $obtainedMark;
                                                            $result_fail_status = true;
                                                        }else if($min_mark_pass > $obatained_mark){
                                                            $result_subject_fail_status = true;
                                                            $result_fail_status = true;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark .'F';
                                                        }else{
                                                            $result_subject_fail_status = false;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark;
                                                        }
                                                    ?>
                                                <tr>
                                                    <th>
                                                        <?php echo strtoupper($secondUnitTestMarkInfo[$i]->name); ?></th>
                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>
                                                    </th>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $min_mark_pass; ?></th>
                                                    <?php if($result_subject_fail_status == true){ ?>
                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php }else{ ?>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php } ?>
                                                </tr>
                                                <?php  } }
                                                       if($total_mark_obtained != 0){
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; 
                                                        $exam_result = calculateResult($total_mark_obtained);
                                                        ?>
                                                    <tr class="text-center table_row_backgrond">
                                                        <th class="total_row">Total</th>
                                                        <th><?php echo $total_max_mark; ?></th>
                                                        <th><?php echo $total_min_mark; ?></th>
                                                        <th><?php echo $total_mark_obtained; ?></th>
                                                    </tr>
    
                                                    <tr>
                                                        <th colspan="2" class="total_row">Percentage:
                                                            <?php echo round($total_percentage,2).'%'; ?></th>
                                                        <th colspan="2">Result:
                                                            <?php if($result_fail_status == true){ ?>
                                                            <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                                            <?php } else { ?>
                                                            <span class="text_pass"><?php echo 'PASS'; ?></span>
                                                            <?php } ?></th>
                                                    </tr>
                                                  <?php } ?>
                                                </table>  
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="first_term" role="tabpanel" aria-labelledby="first_term-tab">
                                            <div class=" table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="table-success">
                                                            <th class="text-center">SUBJECTS</th>
                                                            <th class="text-center">Max. Marks</th>
                                                            <th class="text-center">Min. Marks</th>
                                                            <th class="text-center">Marks Scored</th>
                                                        </tr>
                                                    </thead>
                                                    <?php 
                                               
                                                    $result_subject_fail_status = false;
                                                    $result_fail_status = false;
                                                    $max_mark = 0;
                                                    $min_mark_pass = 0;
                                                    $total_mark_obtained = 0;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                 
                                                    for($i=0;$i<count($subject_code);$i++){
                                                        if(strtoupper($firstTermMarkInfo[$i]->sub_name) != ''){ 
                                                        $result_display = "";
                                                        $result_subject_fail_status = false;
                                                        if($firstTermMarkInfo[$i]->lab_status == 'true'){
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }else{
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }
                                                        $total_max_mark += $max_mark;
                                                        $total_min_mark += $min_mark_pass;
                                                        $obtainedMark = $firstTermMarkInfo[$i]->obt_theory_mark;
                                                        if($studentInfo->term_name == 'II PUC'){
                                                            $obatained_mark = (float)$obtainedMark * 2;
                                                        }else{
                                                            $obatained_mark = $obtainedMark;
                                                        }
                                                        if($obtainedMark == 'AB' || $obtainedMark == 'EXEM' || $obtainedMark == 'MP' || $obtainedMark == 'SAT'){
                                                            $result_subject_fail_status = true;
                                                            $result_display = $obtainedMark;
                                                            $result_fail_status = true;
                                                        }else if($min_mark_pass > $obatained_mark){
                                                            $result_subject_fail_status = true;
                                                            $result_fail_status = true;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark .'F';
                                                        }else{
                                                            $result_subject_fail_status = false;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark;
                                                        }
                                                    ?>
                                                <tr>
                                                    <th>
                                                        <?php echo strtoupper($firstTermMarkInfo[$i]->sub_name); ?></th>
                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>
                                                    </th>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $min_mark_pass; ?></th>
                                                    <?php if($result_subject_fail_status == true){ ?>
                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php }else{ ?>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php } ?>
                                                </tr>
                                                <?php  } }
                                                       if($total_mark_obtained != 0){
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; 
                                                        $exam_result = calculateResult($total_mark_obtained);
                                                        ?>
                                                    <tr class="text-center table_row_backgrond">
                                                        <th class="total_row">Total</th>
                                                        <th><?php echo $total_max_mark; ?></th>
                                                        <th><?php echo $total_min_mark; ?></th>
                                                        <th><?php echo $total_mark_obtained; ?></th>
                                                    </tr>
    
                                                    <tr>
                                                        <th colspan="2" class="total_row">Percentage:
                                                            <?php echo round($total_percentage,2).'%'; ?></th>
                                                        <th colspan="2">Result:
                                                            <?php if($result_fail_status == true){ ?>
                                                            <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                                            <?php } else { ?>
                                                            <span class="text_pass"><?php echo $exam_result; ?></span>
                                                            <?php } ?></th>
                                                    </tr>
                                                  <?php } ?>
                                                </table>  
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="mid_term" role="tabpanel" aria-labelledby="mid_term-tab">
                                            <div class=" table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="table-success">
                                                            <th class="text-center">SUBJECTS</th>
                                                            <th class="text-center">Max. Marks</th>
                                                            <th class="text-center">Min. Marks</th>
                                                            <th class="text-center">Marks Scored</th>
                                                        </tr>
                                                    </thead>
                                                    <?php 
                                               
                                                    $result_subject_fail_status = false;
                                                    $result_fail_status = false;
                                                    $max_mark = 0;
                                                    $min_mark_pass = 0;
                                                    $total_mark_obtained = 0;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                 
                                                    for($i=0;$i<count($subject_code);$i++){
                                                        if(strtoupper($midTermMarkInfo[$i]->name) != ''){ 
                                                        $result_display = "";
                                                        $result_subject_fail_status = false;
                                                        if($midTermMarkInfo[$i]->lab_status == 'true'){
                                                            $max_mark = 70;
                                                            $min_mark_pass = 21;
                                                        }else{
                                                            $max_mark = 80;
                                                            $min_mark_pass = 28;
                                                        }
                                                        $total_max_mark += $max_mark;
                                                        $total_min_mark += $min_mark_pass;
                                                        $obtainedMark = $midTermMarkInfo[$i]->obt_theory_mark;
                                                        // if($studentInfo->term_name == 'II PUC'){
                                                        //     $obatained_mark = (float)$obtainedMark * 2;
                                                        // }else{
                                                            $obatained_mark = $obtainedMark;
                                                        // }
                                                        if($obtainedMark == 'AB' || $obtainedMark == 'EXEM' || $obtainedMark == 'MP' || $obtainedMark == 'SAT'){
                                                            $result_subject_fail_status = true;
                                                            $result_display = $obtainedMark;
                                                            $result_fail_status = true;
                                                        }else if($min_mark_pass > $obatained_mark){
                                                            $result_subject_fail_status = true;
                                                            $result_fail_status = true;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark .'F';
                                                        }else{
                                                            $result_subject_fail_status = false;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark;
                                                        }
                                                    ?>
                                                <tr>
                                                    <th>
                                                        <?php echo strtoupper($midTermMarkInfo[$i]->name); ?></th>
                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>
                                                    </th>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $min_mark_pass; ?></th>
                                                    <?php if($result_subject_fail_status == true){ ?>
                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php }else{ ?>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php } ?>
                                                </tr>
                                                <?php  } }
                                                       if($total_mark_obtained != 0){
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; 
                                                        $exam_result = calculateResult($total_mark_obtained);
                                                        ?>
                                                    <tr class="text-center table_row_backgrond">
                                                        <th class="total_row">Total</th>
                                                        <th><?php echo $total_max_mark; ?></th>
                                                        <th><?php echo $total_min_mark; ?></th>
                                                        <th><?php echo $total_mark_obtained; ?></th>
                                                    </tr>
    
                                                    <tr>
                                                        <th colspan="2" class="total_row">Percentage:
                                                            <?php echo round($total_percentage,2).'%'; ?></th>
                                                        <th colspan="2">Result:
                                                            <?php if($result_fail_status == true){ ?>
                                                            <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                                            <?php } else { ?>
                                                            <span class="text_pass"><?php echo 'PASS'; ?></span>
                                                            <?php } ?></th>
                                                    </tr>
                                                  <?php } ?>
                                                </table>  
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="preparatory" role="tabpanel" aria-labelledby="preparatory-tab">
                                            <div class=" table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="table-success">
                                                            <th class="text-center">SUBJECTS</th>
                                                            <th class="text-center">Max. Marks</th>
                                                            <th class="text-center">Min. Marks</th>
                                                            <th class="text-center">Marks Scored</th>
                                                        </tr>
                                                    </thead>
                                                    <?php 
                                               
                                                    $result_subject_fail_status = false;
                                                    $result_fail_status = false;
                                                    $max_mark = 0;
                                                    $min_mark_pass = 0;
                                                    $total_mark_obtained = 0;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                 
                                                    for($i=0;$i<count($subject_code);$i++){
                                                        if(strtoupper($firstPreparatoryMarkInfo[$i]->name) != ''){ 
                                                        $result_display = "";
                                                        $result_subject_fail_status = false;
                                                        if($firstPreparatoryMarkInfo[$i]->lab_status == 'true'){
                                                            $max_mark = 70;
                                                            $min_mark_pass = 24;
                                                        }else{
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }
                                                        $total_max_mark += $max_mark;
                                                        $total_min_mark += $min_mark_pass;
                                                        $obtainedMark = $firstPreparatoryMarkInfo[$i]->obt_theory_mark;
                                                        // if($studentInfo->term_name == 'II PUC'){
                                                        //     $obatained_mark = (float)$obtainedMark * 2;
                                                        // }else{
                                                            $obatained_mark = $obtainedMark;
                                                        // }
                                                        if($obtainedMark == 'AB' || $obtainedMark == 'EXEM' || $obtainedMark == 'MP' || $obtainedMark == 'SAT'){
                                                            $result_subject_fail_status = true;
                                                            $result_display = $obtainedMark;
                                                            $result_fail_status = true;
                                                        }else if($min_mark_pass > $obatained_mark){
                                                            $result_subject_fail_status = true;
                                                            $result_fail_status = true;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark .'F';
                                                        }else{
                                                            $result_subject_fail_status = false;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark;
                                                        }
                                                    ?>
                                                <tr>
                                                    <th>
                                                        <?php echo strtoupper($firstPreparatoryMarkInfo[$i]->name); ?></th>
                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>
                                                    </th>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $min_mark_pass; ?></th>
                                                    <?php if($result_subject_fail_status == true){ ?>
                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php }else{ ?>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php } ?>
                                                </tr>
                                                <?php  } }
                                                       if($total_mark_obtained != 0){
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; 
                                                        $exam_result = calculateResult($total_mark_obtained);
                                                        ?>
                                                    <tr class="text-center table_row_backgrond">
                                                        <th class="total_row">Total</th>
                                                        <th><?php echo $total_max_mark; ?></th>
                                                        <th><?php echo $total_min_mark; ?></th>
                                                        <th><?php echo $total_mark_obtained; ?></th>
                                                    </tr>
    
                                                    <tr>
                                                        <th colspan="2" class="total_row">Percentage:
                                                            <?php echo round($total_percentage,2).'%'; ?></th>
                                                        <th colspan="2">Result:
                                                            <?php if($result_fail_status == true){ ?>
                                                            <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                                            <?php } else { ?>
                                                            <span class="text_pass"><?php echo 'PASS'; ?></span>
                                                            <?php } ?></th>
                                                    </tr>
                                                  <?php } ?>
                                                </table>  
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="remarksqw" role="tabpanel"
                                            aria-labelledby="remarks-tab">

                                            <button class="btn btn-primary float-right mobile-btn border_right_radius mr-1"
                                                data-toggle="modal" data-target="#addNewDocModel"><i
                                                    class="fa fa-plus"></i>
                                                Add Remark</button>

                                            <div class="table-responsive pt-1">
                                                <table class="table table-bordered table_edit_student ">
                                                    <tr>
                                                        <th class="tbl-head" width="100">Date</th>
                                                        <!-- <th class="tbl-head" width="100">Semester</th> -->
                                                        <th class="tbl-head" width="100">Type</th>
                                                        <th class="tbl-head" width="100">Description</th>
                                                        <th class="tbl-head" width="100">Action</th>
                                                    </tr>
                                                   
                                                    <?php foreach($remarkInfo as $record){ ?>
                                                    <tr>
                                                        <td style="color:black">
                                                            <b><?php echo date('d-m-Y', strtotime($record->date)); ?></b>
                                                        </td>
                                                        <!-- <td style="color:black">
                                                            <b><?php echo $record->semester; ?></b></td> -->
                                                        <td style="color:black">
                                                            <b><?php echo $record->remarks; ?></b>
                                                        </td>
                                                        <td style="color:black">
                                                            <b><?php echo $record->description; ?></b>
                                                        </td>
                                                        
                                                        <td><?php if (!empty($record->file_path)) { ?>
                                                            <a href="<?php echo base_url(); ?><?php echo $record->file_path; ?>"
                                                                download target="_blank" class="btn btn_download p-2"><i
                                                                    class="fa fa-download"></i></a>
                                                            <a href="<?php echo base_url(); ?><?php echo $record->file_path; ?>"
                                                                target="_blank" class="btn btn-primary p-2"><i
                                                                    class="fa fa-eye"></i> View</a>

                                                            <?php } ?>
                                                            <?php if ($this->staff_id == $record->created_by || $role == ROLE_PRIMARY_ADMINISTRATOR) { ?>
                                                                <a class="btn  btn-sm btn-info" href="#"
                                                                onclick="openRemarksModel('<?php echo date('d-m-Y',strtotime($record->date)) ?>','<?php echo $record->description ?>','<?php echo  base_url().$record->file_path ?>','<?php echo $record->student_row_id ?>','<?php echo $record->row_id ?>','<?php echo $record->remarks ?>')"
                                                                title="Edit"><i class="fas fa-edit"></i></i></a>
                                                             
                                                                <a class="btn btn-xs btn-danger deleteStudentRemarkDetails" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                                                                <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>

                                                </table>
                                            </div>

                                        </div>

                                        <div class="tab-pane fade p-1" id="notification" role="tabpanel" aria-labelledby="notification-tab">
                                            
                                            <div class="row p-0 column_padding_card">
                                                <div class="col column_padding_card">
                                                    <div class="card card-small mb-4">
                                                        <style>
                                                            .load_more_less:hover{
                                                                color : #33cc33 !important;
                                                            }
                                                            .card-flex-container{
                                                                display: flex;
                                                                justify-content: flex-end;
                                                            }
                                                            form{
                                                                display: flex;               
                                                            }
                                                        </style>
                                                        <div class="card-header card-flex-container p-1">                    
                                                            <form action="<?php echo base_url(); ?>viewStudentInfoById/<?php echo $studentInfo->row_id; ?>" method="POST"
                                                                id="byFilterMethod">
                                                                
                                                                <input class="form-control datepicker" type="text" name="date_from" 
                                                                value="<?php  if(!empty($date_from)) echo date('d-m-Y', strtotime($date_from)); ?>"
                                                                style="text-transform: uppercase" placeholder="Date From" autocomplete="off">
                                                                    &emsp;
                                                                <input class="form-control datepicker" type="text" name="date_to" 
                                                                value="<?php  if(!empty($date_to)) echo date('d-m-Y', strtotime($date_to)); ?>"
                                                                style="text-transform: uppercase" placeholder="Date To" autocomplete="off">

                                                                <button type="submit" class="btn btn-success ml-1">Search</button>
                                                            </form>
                                                        </div>
                                                        <style>
                                                            .flex-containers{
                                                            }
                                                            .flex-containers{
                                                                
                                                            }
                                                            .main-flex-container{  
                                                                display: flex;
                                                                flex-direction: column;
                                                                background: #d7e0e2;
                                                                padding: 5px 10px;
                                                                border-radius: 5px;
                                                                font-weight: bold;
                                                                margin-bottom: 3px;
                                                            }
                                                            .head-container{
                                                                display: flex;
                                                                width: 100%;
                                                            }
                                                            .head-container > .title{
                                                                color: #2011ef;
                                                                margin-left: 10px;
                                                            }
                                                            .body-container{
                                                                margin: 5px 0px;
                                                            }
                                                            .body-container > .body{
                                                                color: #383535;
                                                                margin-left: 23px;
                                                            }
                                                            .footer-container{
                                                                display: flex;
                                                                justify-content: space-between;
                                                            }
                                                            .action-buttons{
                                                                align-self: flex-end;
                                                            }
                                                        </style>
                                                        <div class="card-body p-2">
                                                            <div class="flex-containers">
                                                                <?php 
                                                                    if(!empty($notifications)){
                                                                        $segmentID = 0;
                                                                        foreach($notifications as $count=>$notification){
                                                                            if(fmod($count,7) == 0){ 
                                                                                $segmentID++;
                                                                            }?>
                                                                                <div class="main-flex-container notificationSegment_<?=$segmentID;?>">
                                                                                
                                                                                    <div class="head-container">
                                                                                        <span>
                                                                                            <i class="fas fa-bell"></i>
                                                                                        </span>
                                                                                        <span class="title"><?=$notification->student_name;?></span>                   
                                                                                    </div>
                                                                                    <div class="body-container">
                                                                                        <span class="body"><?=$notification->message;?></span>
                                                                                    </div>
                                                                                    <div class="footer-container">
                                                                                        <span class="date">Sent By - <?php 
                                                                                            if(!empty($notification->sent_by)) echo $notification->sent_by;
                                                                                        ?></span>
                                                                                    </div>
                                                                                    <div class="footer-container">
                                                                                        <span class="date"><?php 
                                                                                            if(!empty($notification->active_date)) echo date('d-m-Y', strtotime($notification->active_date));
                                                                                        ?></span>
                                                                                        <?php 
                                                                                            if(!empty($notification->filepath)){?>
                                                                                                <span class="attachment">
                                                                                                    <a class="badge badge-success" target="_blank" href="<?= base_url().$notification->filepath ?>" onclick="">View Attachment</a>
                                                                                                </span>
                                                                                            <?php }
                                                                                        ?>
                                                                                    </div>
                                                                                    <div class="action-buttons mt-1">
                                                                                    <?php 
                                                                                            if(!empty($notification->filepath_two)){?>
                                                                                                <span class="attachment">
                                                                                                    <a class="badge badge-success" target="_blank" href="<?= base_url().$notification->filepath_two ?>" onclick="">View Attachment 2</a>
                                                                                                </span>
                                                                                            <?php } ?>
                                                                                    </div>
                                                                                </div>
                                                                        <?php }
                                                                    }else{ ?>
                                                                            <p class="text-center m-0" style="font-weight: bold;">No Notifications Found..!</p>
                                                                    <?php }
                                                                    ?>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer p-1">          
                                                            <span onclick="loadMoreNotification();" style="user-select:none;font-size:17px;font-weight:bold;cursor:pointer;color:#007bff" class="float-left pt-2 pb-2 pl-2 load_more_less">load more<i class="fas fa-arrow-circle-down pl-1"></i></span>
                                                            <span onclick="showLessNotification();" style="user-select:none;font-size:17px;font-weight:bold;cursor:pointer;color:#007bff" class="float-right pt-2 pb-2 pr-2 load_more_less">show less<i class="fas fa-arrow-circle-up pl-1"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="firstPreparartory" role="tabpanel" aria-labelledby="firstPreparartory-tab">
                                            <div class=" table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="table-success">
                                                            <th class="text-center">SUBJECTS</th>
                                                            <th class="text-center">Max. Marks</th>
                                                            <th class="text-center">Min. Marks</th>
                                                            <th class="text-center">Marks Scored</th>
                                                        </tr>
                                                    </thead>
                                                    <?php 
                                               
                                                    $result_subject_fail_status = false;
                                                    $result_fail_status = false;
                                                    $max_mark = 0;
                                                    $min_mark_pass = 0;
                                                    $total_mark_obtained = 0;
                                                    $total_max_mark = 0;
                                                    $total_min_mark = 0;
                                                 
                                                    for($i=0;$i<count($subject_code);$i++){
                                                        if(strtoupper($firstPreparatoryMarkInfo[$i]->sub_name) != ''){ 
                                                        $result_display = "";
                                                        $result_subject_fail_status = false;
                                                        if($firstPreparatoryMarkInfo[$i]->lab_status == 'true'){
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }else{
                                                            $max_mark = 100;
                                                            $min_mark_pass = 35;
                                                        }
                                                        $total_max_mark += $max_mark;
                                                        $total_min_mark += $min_mark_pass;
                                                        $obtainedMark = $firstPreparatoryMarkInfo[$i]->obt_theory_mark;
                                                        // if($studentInfo->term_name == 'II PUC'){
                                                        //     $obatained_mark = (float)$obtainedMark * 2;
                                                        // }else{
                                                            $obatained_mark = $obtainedMark;
                                                        // }
                                                        if($obtainedMark == 'AB' || $obtainedMark == 'EXEM' || $obtainedMark == 'MP' || $obtainedMark == 'SAT'){
                                                            $result_subject_fail_status = true;
                                                            $result_display = $obtainedMark;
                                                            $result_fail_status = true;
                                                        }else if($min_mark_pass > $obatained_mark){
                                                            $result_subject_fail_status = true;
                                                            $result_fail_status = true;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark .'F';
                                                        }else{
                                                            $result_subject_fail_status = false;
                                                            $total_mark_obtained += $obatained_mark;
                                                            $result_display = $obatained_mark;
                                                        }
                                                    ?>
                                                <tr>
                                                    <th>
                                                        <?php echo strtoupper($firstPreparatoryMarkInfo[$i]->sub_name); ?></th>
                                                    <th class="text-center table_marks_data"><?php echo $max_mark; ?>
                                                    </th>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $min_mark_pass; ?></th>
                                                    <?php if($result_subject_fail_status == true){ ?>
                                                    <th style="background: #f76a7ebf"
                                                        class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php }else{ ?>
                                                    <th class="text-center table_marks_data">
                                                        <?php echo $result_display; ?></th>
                                                    <?php } ?>
                                                </tr>
                                                <?php  } }
                                                       if($total_mark_obtained != 0){
                                                        $total_percentage = ($total_mark_obtained/$total_max_mark)*100; 
                                                        $exam_result = calculateResult($total_mark_obtained);
                                                        ?>
                                                    <tr class="text-center table_row_backgrond">
                                                        <th class="total_row">Total</th>
                                                        <th><?php echo $total_max_mark; ?></th>
                                                        <th><?php echo $total_min_mark; ?></th>
                                                        <th><?php echo $total_mark_obtained; ?></th>
                                                    </tr>
    
                                                    <tr>
                                                        <th colspan="2" class="total_row">Percentage:
                                                            <?php echo round($total_percentage,2).'%'; ?></th>
                                                        <th colspan="2">Result:
                                                            <?php if($result_fail_status == true){ ?>
                                                            <span class="text_fail"><?php echo 'FAIL'; ?></span>
                                                            <?php } else { ?>
                                                            <span class="text_pass"><?php echo $exam_result; ?></span>
                                                            <?php } ?></th>
                                                    </tr>
                                                  <?php } ?>
                                                </table>  
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="attendance_info" role="tabpanel" aria-labelledby="attendance_info-tab">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table_info">
                                                    <thead>
                                                        <tr class="table_row_backgrond">
                                                            <th class="text-center">SUBJECTS</th>
                                                            <th class="text-center">Classes Held</th>
                                                            <th class="text-center">Classes Present</th>
                                                            <th class="text-center">Percentage</th>
                                                        </tr>
                                                    </thead>
                                                    <?php for($i=0;$i<count($subject_code);$i++){  ?>
                                                        <tr>
                                                            <th><?php echo $subject_attendance[$subject_code[$i]]['sub_name']->sub_name; ?></th>
                                                            <th class="text-center"><?php echo $subject_attendance[$subject_code[$i]]['class_held']; ?></th>
                                                            <th class="text-center"><?php echo $subject_attendance[$subject_code[$i]]['class_attended']; ?></th>
                                                            <?php if(round($subject_attendance[$subject_code[$i]]['percentage'],2) < 85.00){ ?>
                                                                <th width="300" style="background:#f76a7ebf" class="text-center"><?php echo round($subject_attendance[$subject_code[$i]]['percentage'],2);?></th>
                                                            <?php }else{ ?>
                                                                <th width="300" class="text-center"><?php echo round($subject_attendance[$subject_code[$i]]['percentage'],2);?></th>
                                                            <?php  } ?>
                                                        </tr>
                                                    <?php }  ?>

                                                    <tr>
                                                        <th colspan="4" class="total_row">Total Percentage: 
                                                        <?php if(round($total_attendance_percentage,2) < 85.00){ ?>
                                                            <span colspan="3" class="total_row text_fail"><?php echo round($total_attendance_percentage,2).'%'; ?></span>
                                                        <?php }else{ ?>
                                                            <span colspan="3" class="total_row"><?php echo round($total_attendance_percentage,2).'%'; ?></span>
                                                        <?php  } ?>
                                                        </th>
                                                    </tr>
                                                </table>  
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="attendanceqw" role="tabpanel"
                                            aria-labelledby="attendance-tab">
                                            <div class="table-responsive mt-1">
                                                <table class="table table-bordered table_edit_student ">
                                                    <tr>
                                                        <th class="tbl-head" width="100">Subject</th>
                                                        <th class="tbl-head" width="100">Class Held</th>
                                                        <th class="tbl-head" width="100">Class Attended</th>
                                                    </tr>
                                                    <?php foreach($subjects as $subject){ 
                                                        //  if(strtoupper($subject->sub_name) == 'HINDI'){
                                                        //     if(strtoupper($studentInfo->elective_language) == 'HINDI'){
                                                        //         $subject_name = $subject->sub_name;
                                                        //     } else{
                                                        //         continue;
                                                        //     }
                                                        // } else if(strtoupper($subject->sub_name) == 'KANNADA'){
                                                        //     if(strtoupper($studentInfo->elective_language) == 'KANNADA'){
                                                        //         $subject_name = $subject->sub_name;
                                                        //      } else{
                                                        //         continue;
                                                        //      }
                                                        // } else{
                                                            $subject_name = $subject->sub_name;
                                                        // }
                                                        ?>

                                                    <tr>
                                                        <td style="color:black"><b><?php echo $subject_name; ?></b>
                                                        </td>
                                                        <td style="color:black">
                                                            <b><?php echo $class_held[$subject->subject_code]; ?></b>
                                                        </td>
                                                        <td style="color:black">
                                                            <b><?php echo $class_attended[$subject->subject_code]; ?></b>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>

                                                </table>
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

<div class="modal" id="addNewDocModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Remarks Details</h4>
                <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="modal-body p-2 m-1">
            <div class="row">
                <form action="<?php echo base_url() ?>addRemarks" method="POST" role="form"
                    enctype="multipart/form-data">
                    <input type="hidden" name="row_id" value="<?php echo $studentInfo->row_id ?>">
                    <!-- <div class="text-center" id="alertMsg"></div> -->

                    
                        <div class="col-12">
                            <label>Date</label>
                            <div class="form-group">
                                <input type="text" value="<?php echo date('d-m-Y') ?>" name="date"
                                class="form-control datepicker input-sm remarks_date" placeholder="Date"
                                    autocomplete="off" required>
                            </div>
                        </div>

                        <!-- <div class="col-12">
                            <div class="form-group">
                                <label>Remarks Type</label>
                                <select class="form-control input-sm selectpicker" id="remarks_type_id"
                                    name="remarks_type_id" data-live-search="true" required>
                                    <option value="">Select Remarks</option>
                                    <?php if (!empty($remarkNameInfo)) {
                                        foreach ($remarkNameInfo as $obsinfo) { ?>
                                    <option value="<?php echo $obsinfo->row_id; ?>">
                                        <?php echo $obsinfo->remark_name; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div> -->

                        <div class="col-10">
                            <div class="form-group">
                                <label>Remark</label>
                                <input type="text" value="" name="remark" id = "remark"
                                class="form-control" placeholder="Enter Remark"
                                    autocomplete="off" required>
                            </div>
                        </div>

                                </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">

                                <img src="<?php echo base_url(); ?>assets/dist/img/file_upload.png"
                                    class="avatar rounded-circle img-thumbnail" width="130" height="130" src="#"
                                    id="uploadedImage3" name="userfile" width="130" height="130" alt="File">
                                <div class="observeFile">
                                    <div class="file btn btn-sm">
                                        <input type="file" class="form-control-sm" id="oFile" name="userfile"
                                        accept="*.jpg,*.png,*.jpeg,,*.pdf">
                                    </div>
                                </div>
                            </div>
                        </div>
                   
                   
                        <div class="col-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" id="description" class="form-control"
                                    placeholder="Enter Description" autocomplete="off" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-2 pb-0">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button id="staffInfoDownload" type="submit" class="btn btn-md btn-success"> SAVE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="remarksModel" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header modal-call-report p-2">
                <div class=" col-md-10 col-10">
                    <span class="mobile-title" style="font-size : 20px;color:white">Edit Remarks
                        </span>
                </div>
                <div class=" col-md-2 col-2">
                    <button type="button" class="text-white close" data-dismiss="modal">&times;</button>
                </div>
            </div>
            <!-- Modal body -->
            <div class="modal-body m-0">
                <?php $this->load->helper("form"); ?>
                <div class="row">
                <form role="form" id="" action="<?php echo base_url() ?>updateRemarksInfo" method="post" role="form" enctype="multipart/form-data">
                <input type="hidden" name="remark_id" id="remark_id" value="" />
                    <input type="hidden" name="row_id" id="student_row_id" value="" />
                    <input type="hidden" name="rowid" id="row_id" value="" />

                  
                        <div class="col-12">
                            <label>Date</label>
                            <div class="form-group">
                                <input type="text" value="" name="date" id="editDate"
                                    class="form-control datepicker_edit input-sm remarks_date" placeholder="Date" autocomplete="off"
                                    required>
                            </div>
                        </div>

                        <!-- <div class="col-9">
                            <div class="form-group">
                                <label>Remarks Type</label>
                                <select class="form-control input-sm" id="edit_remarks_type_id"
                                    name="remarks_type_id" required> -->
                                    <!-- <option value="">Select Remarks</option> -->
                                    <!-- <?php if (!empty($remarkNameInfo)) {
                                        foreach ($remarkNameInfo as $obsinfo) { ?>
                                    <option value="<?php echo $obsinfo->row_id; ?>">
                                        <?php echo $obsinfo->remark_name; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div> -->

                        <div class="col-9">
                            <div class="form-group">
                                <label>Remark</label>
                                <input type="text" value="" name="remark" id = "editremark"
                                class="form-control" placeholder="Enter Remark"
                                    autocomplete="off" required>
                            </div>
                        </div>
                        
                                </div> 
                                <div class="row">
                                   
                        <div class="col-lg-6">
                            <div class="form-group">

                                <img class="avatar rounded-circle img-thumbnail" width="130" height="130" src="#"
                                    id="uploadedImage1" name="userfile" width="130" height="130" alt="File">
                                <div class="observeFile">
                                    <div class="file btn btn-sm">
                                        <input type="file" class="form-control-sm" id="editFile" name="userfile"
                                        accept="*.jpg,*.png,*.jpeg,,*.pdf">
                                    </div>
                                </div>
                            </div>
                        </div>

                    

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" id="editdescription" class="form-control"
                                    placeholder="Enter Description" autocomplete="off" required></textarea>
                            </div>
                        </div>
                                </div>

                    </div>
                    <div class="form-group">
                        <input style="float:right;" type="submit" class="btn btn-primary" value="Update" />
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/common.js" type="text/javascript"></script>
<script type="text/javascript">
function GoBackWithRefresh(event) {
    showLoader();
    if ('referrer' in document) {
        window.location = document.referrer;
        /* OR */
        //location.replace(document.referrer);
    } else {
        window.history.back();
    }
}
jQuery(document).ready(function() {

    jQuery('.datepicker, .datepicker_edit').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        endDate: "today"
    });

    jQuery('.resetFilters').click(function() {
        $(this).closest('form').find("input[type=text]").val("");
    })

                  // Get the ID of the active tab from local storage
                  var activeTabId = localStorage.getItem('vincentpuTabIdStudview');

                    // If the ID is not null or undefined, activate the corresponding tab
                    if (activeTabId) {
                    $('#myTab a[href="#' + activeTabId + '"]').tab('show');
                    }

                    // Store the ID of the clicked tab in local storage
                    $('#myTab a').on('click', function() {
                        var tabId = $(this).attr('href').substring(1);
                        localStorage.setItem('vincentpuTabIdStudview', tabId);
                    });
});


function openRemarksModel(date, description, file_path,studentId,remarkId,editRemark) {
    // $('#subject_name_u option').remove();

      $('#editDate').val(date);
    //   $('#edit_remarks_type_id').val(row_id);
      $("#uploadedImage1").attr("src",file_path);
      $('.selectpicker').selectpicker('refresh');
      $('#editdescription').val(description);
      $('#student_row_id').val(studentId);
      $('#remark_id').val(remarkId);
      $('#editremark').val(editRemark);
    // $('#time_row_id_u').val(start_time);
    // $('#staff_id_u').val(staff_id);
    // // $('#subject_name_u').val(subject_code);

    // $("#edit_remarks_type_id").append(new Option(remark_name , staff_sub_row_id));
    $('#remarksModel').modal('show');

}


function showLessNotification(){
        if(localStorage.getItem("NSEGID") !=null){
        let curSegmentID = parseInt(localStorage.getItem("NSEGID"));
            if(curSegmentID != 1){
                $(".notificationSegment_"+curSegmentID).hide();
                localStorage.setItem("NSEGID",curSegmentID-1);
            }
        }
    }
    function loadMoreNotification(){
        let nextSegmentID = 1;
        if(localStorage.getItem("NSEGID") !=null){
            nextSegmentID = parseInt(localStorage.getItem("NSEGID")) + 1;
        }
        if($(".notificationSegment_"+nextSegmentID).length == 0){
            alert("There is no more notifications to load..");
        }else{
            localStorage.setItem("NSEGID",nextSegmentID);
            $(".notificationSegment_"+nextSegmentID).show();
        }
    }

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#uploadedImage3').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#oFile").change(function() {
    readURL(this);
});

function readURL1(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#uploadedImage1').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#editFile").change(function() {
    readURL1(this);
});

</script>

<?php


function calculateResult($total_marks){
    $percentage = floor(($total_marks / 600) * 100);
    if($percentage >= 85){
        return "Distinction";
    } else if($percentage >= 60 && $percentage <= 84){
        return "I Class";
    } else if($percentage >= 50 && $percentage <= 59){
        return "II Class";
    } else if($percentage >= 35 && $percentage <= 49){
        return "III Class";
    }
}


?>