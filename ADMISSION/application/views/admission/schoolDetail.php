<style>
    <?php if ($_SESSION['application_number_status'] == false) { ?>.main-sidebar .nav #combinationDetailLink,
    .main-sidebar .nav #documentDetail,
    .main-sidebar .nav #paymentDetail,
    .main-sidebar .nav #dashboard {
        display: none !important;
    }

    <?php }
    if ($_SESSION['application_number_status'] == true) { ?>#icons,
    #icon,
    #combination,
    #document,
    #payment {
        color: #008000 !important;
    }

    <?php } ?>.table-bordered>tbody>tr>td {
        border: 1px solid #d5d5d5 !important;
    }
</style>

<?php
$name_of_the_school = "";
$school_address = "";
$medium_instruction = "";
$board_name = "";
$year_of_passed = "";
$other_board_name = "";
$no_of_attempt = "";
$month_of_passed = "";
$register_number  = "";
// $register_number = $sslcRegisterNumber;
// $other_board_name = $boardData->other_board_name;


// if (!empty($boardInfo)) {
//     $board_name = $boardInfo->board_name;
// }

if (!empty($studentSchoolInfo)) {
    $name_of_the_school = $studentSchoolInfo->name_of_the_school;
    $school_address = $studentSchoolInfo->school_address;
    $medium_instruction = $studentSchoolInfo->medium_instruction;
    $no_of_attempt = $studentSchoolInfo->no_of_attempt;
    $board_name = $studentSchoolInfo->board_name;
    $year_of_passed = $studentSchoolInfo->year_of_passed;
    $month_of_passed = $studentSchoolInfo->month_of_passed;
    $other_board_name = $studentSchoolInfo->other_state_board_name;
    $register_number  = $studentSchoolInfo->register_number;
}

$course_row_id = "";


$sslc_mark_card = "";
$ninth_mark_card = "";
if (!empty($documentInfo)) {
    foreach ($documentInfo as $doc) {
        if($doc->doc_name == 'sslc_mark_card'){
            $myFile = pathinfo($doc->doc_path); 
            $extension = $myFile['extension']; 
            if($extension == 'pdf'){
                $sslc_mark_card = 'assets/dist/img/pdf.png';
            }else{
                $sslc_mark_card = $doc->doc_path;
            }
            $sslc_label = $doc->doc_name;
        }
        // if ($doc->doc_name == 'sslc_mark_card') {
        //     $sslc_mark_card = $doc->doc_path;
        //     $sslc_label = $doc->doc_name;
        // } else if ($doc->doc_name == 'ninth_mark_card') {
        //     $ninth_mark_card = $doc->doc_path;
        //     $ninth_label = $doc->doc_name;
        // }
    }
}

?>

<?php
$this->load->helper('form');
?>

<div class="row ">
    <div class="col-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>

<div class="main-content-container container-fluid px-2 mb-5">
    <div class="card card-small p-0 col-12">
        <div class="card-header p-2 card_head_dashboard">
            <span class="page-title">
                <div class="row font_color ">
                    <div class="col-sm-6" style="font-size:18px;">
                        Step : II <i class="material-icons">school</i> School and Examination Details (Last Studied)
                    </div>

                </div>
                <!-- <div class="row">
                    <div class="col-12">
                       
                    </div>
                </div> -->
            </span>
        </div>
        <form method="POST" id="previousSchoolInfo" action="<?php echo base_url(); ?>saveStudentSchoolInfo" role="form" enctype="multipart/form-data">
       
            <input type="hidden" name="board_name" id="boardName" value="<?php if(!empty($boardInfo)){ echo $boardInfo->board_name; } ?>" /> 
            <input type="hidden" name="board_name" id="board_name_id" value="<?php if(!empty($boardInfo)){ echo $boardInfo->row_id; } ?>" />
       
            <div class="card-body m-1">
                <div class="row">
                    <div class="col-12 column_padding_card">
                        <div id="coverScreen" class="LockOn"></div>
                        <div class="row">

                            <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                                <div class="form-group">
                                    <label class="name_of_the_school mdc-text-field mdc-text-field--filled ">
                                        <span class="mdc-text-field__ripple"></span>
                                        <input type="text" onkeydown="return alphaOnly(event)" placeholder="Name of the School" name="name_of_the_school" id="name_of_the_school" value="<?php echo $name_of_the_school; ?>" class="mdc-text-field__input" style="text-transform: uppercase;" maxlength="128" aria-labelledby="my-label-id" autocomplete="off" required>
                                        <span class="mdc-floating-label" id="my-label-id">Name of the School</span>
                                        <span class="mdc-line-ripple"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                                <div class="form-group">
                                    <div class="mdc-select mdc-select-medium mdc-select--required">
                                        <div class="mdc-select__anchor demo-width-class" aria-required="true">
                                            <span class="mdc-select__ripple"></span>
                                            <input type="text" class="mdc-select__selected-text" name="medium" value="" onkeydown="return false;" onfocus="this.blur();" data-live-search="true" id="medium" required>
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <span class="mdc-floating-label">Medium of Instruction</span>
                                            <span class="mdc-line-ripple"></span>
                                        </div>
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                            <ul class="mdc-list">
                                                <?php if (!empty($medium_instruction)) { ?>
                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $medium_instruction; ?>" aria-selected="true"><?php echo $medium_instruction; ?></li>
                                                <?php } ?>
                                                <li class="mdc-list-item" data-value="ENGLISH">
                                                    <span class="mdc-list-item__text">ENGLISH</span>
                                                </li>
                                                <li class="mdc-list-item" data-value="KANNADA">
                                                    <span class="mdc-list-item__text">KANNADA</span>
                                                </li>
                                                <li class="mdc-list-item" data-value="MARATHI">
                                                    <span class="mdc-list-item__text">MARATHI</span>
                                                </li>
                                                <li class="mdc-list-item" data-value="OTHER">
                                                    <span class="mdc-list-item__text">OTHER</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                                <div class="form-group">
                                    <div class="mdc-select mdc-select-month mdc-select--required">
                                        <div class="mdc-select__anchor demo-width-class" aria-required="true">
                                            <span class="mdc-select__ripple"></span>
                                            <input type="text" class="mdc-select__selected-text" name="month_of_passed" value="" data-live-search="true" id="month_of_passed" required>
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <span class="mdc-floating-label">Month of Passing</span>
                                            <span class="mdc-line-ripple"></span>
                                        </div>
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                            <ul class="mdc-list">
                                                <?php if (!empty($month_of_passed)) { ?>
                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $month_of_passed; ?>" aria-selected="true"><?php echo $month_of_passed; ?></li>
                                                <?php } ?>
                                                <li class="mdc-list-item" data-value="" selected hidden>
                                                    <span class="mdc-list-item__text">
                                                        Select Month
                                                    </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="MARCH">
                                                    <span class="mdc-list-item__text">
                                                    MARCH
                                                    </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="APRIL">
                                                    <span class="mdc-list-item__text">
                                                    APRIL
                                                    </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="MAY">
                                                    <span class="mdc-list-item__text">
                                                        MAY
                                                    </span>
                                                </li>
                                                <!-- <li class="mdc-list-item" data-value="2019">
                                                <span class="mdc-list-item__text">
                                                2019
                                                </span>
                                            </li> -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                        <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                                <div class="form-group">
                                    <div class="mdc-select mdc-select-year mdc-select--required">
                                        <div class="mdc-select__anchor demo-width-class" aria-required="true">
                                            <span class="mdc-select__ripple"></span>
                                            <input type="text" class="mdc-select__selected-text" name="year_of_passed" value="" data-live-search="true" id="year_of_passed" required>
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <span class="mdc-floating-label">Year of Passing</span>
                                            <span class="mdc-line-ripple"></span>
                                        </div>
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                            <ul class="mdc-list">
                                                <?php if (!empty($year_of_passed)) { ?>
                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $year_of_passed; ?>" aria-selected="true"><?php echo $year_of_passed; ?></li>
                                                <?php } ?>
                                                <li class="mdc-list-item" data-value="" selected hidden>
                                                    <span class="mdc-list-item__text">
                                                        Select Year
                                                    </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="2023">
                                                    <span class="mdc-list-item__text">
                                                        2024
                                                    </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="2023">
                                                    <span class="mdc-list-item__text">
                                                        2023
                                                    </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="2022">
                                                    <span class="mdc-list-item__text">
                                                        2022
                                                    </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="2021">
                                                    <span class="mdc-list-item__text">
                                                        2021
                                                    </span>
                                                </li>
                                                <!-- <li class="mdc-list-item" data-value="2020">
                                                    <span class="mdc-list-item__text">
                                                        2020
                                                    </span>
                                                </li> -->
                                                <!-- <li class="mdc-list-item" data-value="2019">
                                                <span class="mdc-list-item__text">
                                                2019
                                                </span>
                                            </li> -->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 mb-1 other_medium_instruction_text">
                                <div class="form-group">
                                    <label class="other_medium_instruction mdc-text-field mdc-text-field--filled ">
                                        <span class="mdc-text-field__ripple"></span>
                                        <input type="text" placeholder="Other Medium of Instruction" name="other_medium_instruction" id="other_medium_instruction" value="" class="mdc-text-field__input" style="text-transform: uppercase;" maxlength="128" aria-labelledby="my-label-id" autocomplete="off">
                                        <span class="mdc-floating-label" id="my-label-id">Other Medium of Instruction</span>
                                        <span class="mdc-line-ripple"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 mb-2">
                                <div class="form-group">
                                    <label class="school_address mdc-text-field mdc-text-field--filled mdc-textfield--multiline">
                                        <span class="mdc-text-field__ripple"></span>
                                        <textarea id="school_address" placeholder="Address of the School" name="school_address" type="text" style="text-transform: uppercase" class="mdc-text-field__input" rows="6" cols="10" maxlength="550" autocomplete="off" required><?php echo $school_address; ?></textarea>
                                        <span class="mdc-floating-label" id="my-label-id">Address of the School</span>
                                        <span class="mdc-line-ripple"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                            <div class="form-group">
                                <div class="mdc-select mdc-select-board mdc-select--required">
                                    <div class="mdc-select__anchor demo-width-class" aria-required="true">
                                        <span class="mdc-select__ripple"></span>
                                        <input type="text" class="mdc-select__selected-text" name="sslc_board_name" id="sslc_board_name"  onkeydown="return false;" onfocus="this.blur();" value="" required>
                                        <i class="mdc-select__dropdown-icon"></i>
                                        <span class="mdc-floating-label">10th Board Name</span>
                                        <span class="mdc-line-ripple"></span>
                                    </div>
                                    <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                        <ul class="mdc-list">
                                            <!-- <li class="mdc-list-item" data-value="">
                                                <span class="mdc-list-item__text">
                                                    Select Board Name
                                                </span>
                                            </li> -->
                                            <?php if(!empty($boardInfo)) { ?>
                                            <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $boardInfo->row_id ?>">
                                                <span class="mdc-list-item__text">
                                                    <?= $boardInfo->board_name ?>
                                                </span>
                                            </li>
                                            <?php } ?>
                                            <?php if (!empty($allBoardsInfo)) {
                                                foreach ($allBoardsInfo as $board) {  ?>
                                                    <li class="mdc-list-item" data-value="<?php echo $board->row_id; ?>">
                                                        <span class="mdc-list-item__text">
                                                            <?php echo $board->board_name; ?>
                                                        </span>
                                                    </li>
                                            <?php }
                                            } ?>
                                           
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                            <div class="form-group register_number">
                                <label class="register_number mdc-text-field mdc-text-field--filled ">
                                    <span class="mdc-text-field__ripple"></span>
                                    <input type="text" placeholder="Register Number" name="register_number" id="register_number" value="<?php echo $register_number?>" class="mdc-text-field__input" style="text-transform: uppercase;" aria-labelledby="my-label-id" autocomplete="off" required>
                                    <span class="mdc-floating-label" id="my-label-id">Register Number</span>
                                    <span class="mdc-line-ripple"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                                <div class="form-group">
                                    <div class="mdc-select mdc-select-attempts mdc-select--required">
                                        <div class="mdc-select__anchor demo-width-class" aria-required="true">
                                            <span class="mdc-select__ripple"></span>
                                            <input type="text" class="mdc-select__selected-text" name="no_of_attempt" value="" data-live-search="true" id="no_of_attempt" required>
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <span class="mdc-floating-label">No of Attempts</span>
                                            <span class="mdc-line-ripple"></span>
                                        </div>
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                            <ul class="mdc-list">
                                                <?php if (!empty($no_of_attempt)) { ?>
                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $no_of_attempt; ?>" aria-selected="true"><?php echo $no_of_attempt; ?></li>
                                                <?php } ?>
                                                <li class="mdc-list-item" data-value="" selected hidden>
                                                    <span class="mdc-list-item__text">
                                                        Select
                                                    </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="FIRST">
                                                    <span class="mdc-list-item__text">
                                                        FIRST
                                                    </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="REPEATER">
                                                    <span class="mdc-list-item__text">
                                                        REPEATER
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                        <div id="secondLanguage" class="">
                                    <span class="text-danger" style= "font-size : 13px;">Note :(CBSE candidates who have not received the provisional copy of the first term marks, are requested to upload the first term mark list ( announced in school)  duly signed by the Principal of the institution.)</span>
                                </div> 
                        </div> -->
                        <div class="col-lg-4 col-md-4 col-sm-4 mb-1">
                            <div class="form-group other_board_name_text">
                                <label class="other_board_name mdc-text-field mdc-text-field--filled ">
                                    <span class="mdc-text-field__ripple"></span>
                                    <input type="text" placeholder="Other Board Name" name="other_board_name" id="other_board_name" value="<?php echo $other_board_name?>" class="mdc-text-field__input" maxlength="10" style="text-transform: uppercase;" aria-labelledby="my-label-id" autocomplete="off">
                                    <span class="mdc-floating-label" id="my-label-id">Other Board Name</span>
                                    <span class="mdc-line-ripple"></span>
                                </label>
                            </div>
                        </div>
                         
                            <div class="col-12">
                                <div id="SSLCmarkInfo"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-2 column_padding_card">
                    <?php if(!empty($studentMarkInfo)) { ?>
                            <div class="table-responsive">
                                <table class="table table-bordered col-12 text-center mt-2">
                                    <thead>
                                        <tr style="background: #337ab7; color:white;">
                                            <th colspan="4">
                                                <div class="row">
                                                    <div class="col-5">
                                                        <?php if ($boardInfo->board_name == "KARNATAKA STATE BOARD" || $boardInfo->board_name == "OTHER") { ?>
                                                            <span class="float-left">10th STANDARD MARK INFO</span>
                                                        <?php } else { ?><span class="float-left">10th/FIRST TERM MARK INFO<?php } ?>
                                                    </div>
                                                    <div class="col-5 text-center">
                                                    </div>
                                                    <div class="col-2">
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>

                                    </thead>
                                    <?php
                                    if ($boardInfo->board_name == "CBSE") { ?>
                                        <tr style="background: #337ab7; color:white;">
                                            <th>SUBJECT NAME</th>
                                            <th width="120">MAX MARKS</th>
                                            <th>10TH/FIRST TERM MARKS SCORED</th>
                                            <!-- <th>9TH STD MARKS SCORED</th> -->
                                        </tr>
                                        <?php $subject_group = array('GROUP L', '', 'GROUP A1', '', '');
                                        for ($i = 0; $i < 5; $i++) {
                                            $course_row_id = $studentMarkInfo[$i]->row_id; ?>
                                            <tr class="table-primary">
                                                <th class="text-center"><?php echo $subject_group[$i]; ?></th>
                                                <th></th>
                                                <th></th>
                                                <!-- <th></th> -->
                                            </tr>
                                            <tr>
                                                <input type="hidden" name="course_row_id[]" id="course_row_id" value="<?php echo $course_row_id; ?>">
                                                <?php if ($i == 0 || $i == 1) { ?>
                                                    <th>
                                                        <select class="form-control required" id="subject_name" name="subject_name[]" autocomplete="off" >
                                                            <?php if (!empty($studentMarkInfo[$i]->subject_name)) { ?>
                                                                <option value="<?php echo $studentMarkInfo[$i]->subject_name; ?>">Selected <?php echo $studentMarkInfo[$i]->subject_name; ?></option>
                                                            <?php } ?>
                                                            <option value="">SELECT SUBJECT</option>
                                                            <option value="HINDI COURSE A">HINDI COURSE A</option>
                                                            <option value="HINDI COURSE B">HINDI COURSE B</option>
                                                            <option value="KANNADA LANGUAGE">KANNADA LANGUAGE</option>
                                                            <option value="SANSKRIT LANGUAGE">SANSKRIT LANGUAGE</option>
                                                            <option value="ENGLISH LANGUAGE & LITERATURE">ENGLISH LANGUAGE & LITERATURE</option>
                                                            <option value="FRENCH LANGUAGE">FRENCH LANGUAGE</option>
                                                        </select>
                                                    </th>
                                                <?php } else if ($i == 2) {  ?>
                                                    <th>
                                                        <select class="form-control required" id="subject_name" name="subject_name[]" autocomplete="off" >
                                                            <?php if (!empty($studentMarkInfo[$i]->subject_name)) { ?>
                                                                <option value="<?php echo $studentMarkInfo[$i]->subject_name; ?>">Selected <?php echo $studentMarkInfo[$i]->subject_name; ?></option>
                                                            <?php } ?>
                                                            <option value="">SELECT SUBJECT</option>
                                                            <option value="MATHEMATICS STANDARD">MATHEMATICS STANDARD</option>
                                                            <option value="BASIC MATHEMATICS">BASIC MATHEMATICS</option>
                                                        </select>
                                                    </th>
                                                <?php } else { ?>
                                                    <th><input id="<?php echo $i + 1; ?>_subject_name" type="text" name="subject_name[]" class="form-control required input-sm" value="<?php echo $studentMarkInfo[$i]->subject_name; ?>" autocomplete="off" /></th>
                                                <?php } ?>
                                                <?php $obtained_mark = ($studentMarkInfo[$i]->obtnd_mark);?>

                                                <th><input id="<?php echo $i + 1; ?>_subject_max_mark" type="text" name="subject_max_mark[]" class="form-control required input-sm" value="100" readonly /></th>
                                                <td><input type="number" min="0" onkeypress="return isNumber(event)" id="<?php echo $i + 1; ?>_subject_obtained" type="text" name="subject_obtained[]" required class="form-control required input-sm" value="<?php echo round($obtained_mark); ?>" placeholder="Enter 10th Standard Mark" autocomplete="off"  /></td>
                                            </tr>

                                        <?php }
                                    } else if ($boardInfo->board_name == "ICSE") { ?>
                                        <tr style="background: #337ab7; color:white;">
                                            <th>SUBJECT NAME</th>
                                            <th width="120">MAX MARKS</th>
                                            <th>10TH/FIRST TERM MARKS SCORED</th>
                                            <!-- <th>9TH STD MARKS SCORED</th> -->
                                        </tr>
                                        <?php $subject_group = array('GROUP I', '', '', 'GROUP II', '');
                                        for ($i = 0; $i < 5; $i++) {
                                            $course_row_id = $studentMarkInfo[$i]->row_id; ?>
                                            <tr class="table-primary">
                                                <th class="text-center"><?php echo $subject_group[$i]; ?></th>
                                                <th></th>
                                                <th></th>
                                                <!-- <th></th> -->
                                            </tr>
                                            <tr>
                                                <input type="hidden" name="course_row_id[]" id="course_row_id" value="<?php echo $course_row_id; ?>">
                                                <?php if ($i == 0 || $i == 2) { ?>
                                                    <th><input id="<?php echo $i + 1; ?>_subject_name" type="text" name="subject_name[]" class="form-control required input-sm" value="<?php echo $studentMarkInfo[$i]->subject_name; ?>" autocomplete="off"  /></th>
                                                <?php } else if ($i == 1) { ?>
                                                    <th><input id="<?php echo $i + 1; ?>_subject_name" type="text" placeholder="Language II" name="subject_name[]" class="form-control required input-sm text-uppercase"  value="<?php echo $studentMarkInfo[$i]->subject_name; ?>" autocomplete="off"  /></th>
                                                <?php } else { ?>
                                                    <th>
                                                        <select class="form-control required" id="subject_name" name="subject_name[]" autocomplete="off" >
                                                            <?php if (!empty($studentMarkInfo[$i]->subject_name)) { ?>
                                                                <option value="<?php echo $studentMarkInfo[$i]->subject_name; ?>">Selected <?php echo $studentMarkInfo[$i]->subject_name; ?></option>
                                                            <?php } ?>
                                                            <option value="">SELECT SUBJECT</option>
                                                            <option value="MATHEMATICS">MATHEMATICS</option>
                                                            <option value="SCIENCE">SCIENCE</option>
                                                            <option value="ECONOMICS">ECONOMICS</option>
                                                            <option value="COMMERCIAL STUDIES">COMMERCIAL STUDIES</option>
                                                            <option value="A MODERN FOREIGN LANGUAGE">A MODERN FOREIGN LANGUAGE</option>
                                                            <option value="A CLASSICAL LANGUAGE">A CLASSICAL LANGUAGE</option>
                                                            <option value="ENVIRONMENTAL SCIENCE">ENVIRONMENTAL SCIENCE</option>
                                                        </select>
                                                    </th>
                                                <?php } ?>
                                                <?php $obtained_mark = ($studentMarkInfo[$i]->obtnd_mark);?>
                                                <th><input id="<?php echo $i + 1; ?>_subject_max_mark" type="text" name="subject_max_mark[]" class="form-control required input-sm" value="100" readonly /></th>
                                                <td><input type="number" min="0" onkeypress="return isNumber(event)" id="<?php echo $i + 1; ?>_subject_obtained" type="text" name="subject_obtained[]"  class="form-control required input-sm" value="<?php echo round($obtained_mark); ?>" placeholder="Enter 10th Standard Mark" autocomplete="off" /></td>
                                            </tr>
                                        <?php }
                                    } else if ($boardInfo->board_name == "KARNATAKA STATE BOARD") { ?>
                                        <tr style="background: #337ab7; color:white;">
                                            <th>SUBJECT NAME 111</th>
                                            <th width="120">MAX MARKS</th>
                                            <th>10TH STD MARKS SCORED</th>
                                            <!-- <th>9TH STD MARKS SCORED</th> -->
                                        </tr>
                                        <?php for ($i = 0; $i < 6; $i++) {
                                            $course_row_id = $studentMarkInfo[$i]->row_id;
                                            if ($studentMarkInfo[$i]->subject_name == 'EXEMPTED') {
                                                $max_mark = 'EX';
                                                $obtained_mark = 'EX';
                                            } else {
                                                $max_mark = $studentMarkInfo[$i]->max_mark;
                                                $obtained_mark = $studentMarkInfo[$i]->obtnd_mark;
                                            } ?>
                                            <tr>
                                                <input type="hidden" name="course_row_id[]" id="course_row_id" value="<?php echo $course_row_id; ?>">
                                                <?php if ($i == 0) {  ?>
                                                    <th>
                                                        <select class="form-control required" id="<?php echo $i + 1; ?>_subject_name" name="subject_name[]" autocomplete="off" >
                                                            <?php if (!empty($studentMarkInfo[$i]->subject_name)) { ?>
                                                                <option value="<?php echo $studentMarkInfo[$i]->subject_name; ?>">Selected <?php echo $studentMarkInfo[$i]->subject_name; ?></option>
                                                            <?php } ?>
                                                            <option value="">SELECT FIRST LANGAUGE</option>
                                                            <option value="KANNADA">KANNADA</option>
                                                            <option value="ENGLISH">ENGLISH</option>
                                                            <option value="SANSKRIT">SANSKRIT</option>
                                                            <option value="URDU">URDU</option>
                                                            <option value="HINDI">HINDI</option>
                                                            <option value="TAMIL">TAMIL</option>
                                                            <option value="TELUGU">TELUGU</option>
                                                            <option value="MALAYALAM">MALAYALAM</option>
                                                            <option value="MARATHI">MARATHI</option>
                                                            <option value="EXEMPTED">EXEMPTED</option>
                                                        </select>
                                                    </th>
                                                <?php } else if ($i == 1 || $i == 2) { ?>
                                                    <th>
                                                        <select class="form-control required" id="<?php echo $i + 1; ?>_subject_name" name="subject_name[]" autocomplete="off" >
                                                            <?php if (!empty($studentMarkInfo[$i]->subject_name)) { ?>
                                                                <option value="<?php echo $studentMarkInfo[$i]->subject_name; ?>">Selected <?php echo $studentMarkInfo[$i]->subject_name; ?></option>
                                                            <?php } ?>
                                                            <option value="">SELECT FIRST LANGAUGE</option>
                                                            <option value="KANNADA">KANNADA</option>
                                                            <option value="ENGLISH">ENGLISH</option>
                                                            <option value="SANSKRIT">SANSKRIT</option>
                                                            <option value="URDU">URDU</option>
                                                            <option value="HINDI">HINDI</option>
                                                            <option value="TAMIL">TAMIL</option>
                                                            <option value="TELUGU">TELUGU</option>
                                                            <option value="MALAYALAM">MALAYALAM</option>
                                                            <option value="MARATHI">MARATHI</option>
                                                        </select>
                                                    </th>
                                                <?php } else { ?>
                                                    <th>
                                                        <input id="<?php echo $i + 1; ?>_subject_name" type="text" name="subject_name[]" class="form-control required input-sm"   value="<?php echo $studentMarkInfo[$i]->subject_name; ?>" autocomplete="off" readonly />
                                                    </th>
                                                <?php } ?>
                                                <th><input id="<?php echo $i + 1; ?>_subject_max_mark" type="text" name="subject_max_mark[]" class="form-control required input-sm" value="<?php echo $max_mark; ?>" readonly /></th>
                                                <td><input maxlength="3" onkeypress="return isNumber(event)" id="<?php echo $i + 1; ?>_subject_obtained" type="text" name="subject_obtained[]"  class="form-control required input-sm" value="<?php echo $obtained_mark ?>" placeholder="Enter 10th Standard Mark" autocomplete="off"  /></td>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr style="background: #337ab7; color:white;">
                                            <th>SUBJECT NAME</th>
                                            <th width="120">MAX MARKS</th>
                                            <th>10th STD MARKS SCORED</th>
                                            <!-- <th>9TH STD MARKS SCORED</th> -->
                                        </tr>
                                        <?php for ($i = 0; $i < 6; $i++) {
                                            $course_row_id = $studentMarkInfo[$i]->row_id; ?>
                                            <tr>
                                                <input type="hidden" name="course_row_id[]" id="course_row_id" value="<?php echo $course_row_id; ?>">
                                                <th><input id="<?php echo $i + 1; ?>_subject_name" type="text" name="subject_name[]" class="form-control required input-sm" value="<?php echo $studentMarkInfo[$i]->subject_name; ?>" autocomplete="off"  /></th>
                                                <th><input id="<?php echo $i + 1; ?>_subject_max_mark" type="text" name="subject_max_mark[]" class="form-control required input-sm" value="<?php echo $studentMarkInfo[$i]->max_mark; ?>"  /></th>
                                                <td><input maxlength="3" onkeypress="return isNumber(event)" id="<?php echo $i + 1; ?>_subject_obtained" type="text" name="subject_obtained[]" class="form-control required input-sm" value="<?php echo $studentMarkInfo[$i]->obtnd_mark; ?>" placeholder="Enter 10th standard Mark" autocomplete="off"  /></td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="studentMarkInfo">
                            </div>
                        <?php } ?>

                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card col-12 field_color shadow-none  pl-0 pr-0 mt-3 mb-1 ">
                            <div class="card-header text-left inside_color pt-3 pb-3 ml-0">Upload 10th Standard Mark Card <span class="text-danger required_star"></span><span class="text-danger mb-0 font_14">(Note: Maximum File Size 200KB, File format: JPG, JPEG, PNG, PDF)</span>
                            </div>
                        </div>
                        <div class="mx-auto">
                            <div class="text-center mb-2">
                                <?php if (!empty($sslc_mark_card)) { ?>
                                    <img src="<?php echo base_url(); ?><?php echo $sslc_mark_card; ?>" id="uploadedImage2" class="avatar img-thumbnail upload_doc_images" alt="<?php echo $sslc_label; ?>">
                                <?php } else { ?>
                                    <img src="<?php echo base_url(); ?>assets/dist/img/file_upload.png" id="uploadedImage2" class="avatar img-thumbnail upload_doc_images" alt="Certificate">
                                <?php } ?>
                                <div id="sslc_msg"></div>
                            </div>
                            <div class="form-group text-center">
                                <input type="hidden" id="sslcMarkCard" value="<?php echo $sslc_mark_card; ?>" />
                                <input type="hidden" name="doc_name[]" id="doc_name" value="sslc_mark_card" />
                                <div class="profileImg">
                                    <div class="file btn btn-sm btn-primary">
                                        <div id="sslc_label"></div>
                                        <input type="file" class="form-control-sm" id="sslc_card" name="userfile[]" accept=".pdf, image/png, image/jpeg, image/jpg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="card col-12 field_color shadow-none  pl-0 pr-0 mt-3 mb-1 ">
                            <div class="card-header text-left inside_color pt-3 pb-3 ml-0">Upload 9th Standard Mark Card<span class="text-danger required_star">*</span> <span class="text-danger mb-0 font_14">(Note: Maximum File Size 200KB, File format: JPG, JPEG, PNG, PDF)</span>                 
                            </div>    
                        </div> 
                        <div class="mx-auto">
                            <div class="text-center mb-2">
                                <?php if (!empty($ninth_mark_card)) { ?>
                                    <img src="<?php echo base_url(); ?><?php echo $ninth_mark_card; ?>" id="uploadedImage3" class="avatar img-thumbnail upload_doc_images"
                                    alt="<?php echo $ninth_label; ?>">
                                <?php } else { ?>
                                    <img src="<?php echo base_url(); ?>assets/dist/img/file_upload.png" id="uploadedImage3" class="avatar img-thumbnail upload_doc_images"
                                    alt="Certificate">
                                <?php } ?>
                                <div id="ninth_msg"></div>
                            </div>
                            <div class="form-group text-center">
                                <input type="hidden" id="ninthMarkCard" value="<?php echo $ninth_mark_card; ?>"/>
                                <input type="hidden" name="doc_name[]" id="doc_name" value="ninth_mark_card"/>
                                <div class="profileImg">
                                    <div class="file btn btn-sm btn-primary">
                                        <div id="ninth_label"></div>
                                        <input type="file" class="form-control-sm" id="ninth_card" name="userfile[]" accept=".pdf, image/png, image/jpeg, image/jpg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
        </form>
    </div>
    <div class="card-footer card_head_dashboard p-2">
        <div class="row">
            <div class="col-6 text-left">
                <a href="<?php echo base_url(); ?>viewPersonalDetail" id="previousloader" class="mdc-button mdc-button--raised btn_primary"><i class="fas fa-angle-double-left"> </i> Previous </a>
            </div>
            <div class="col-6 text-right">
                <button class="mdc-button mdc-button--raised text-right next-step-examination btn_success" form="previousSchoolInfo" type="submit" id="nxtBtn">
                    <span class="mdc-button__label">Next </span>
                    <i class="fas fa-angle-double-right"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<!-- Modal -->
<!-- <div class="modal fade" id="changeBoardModal" tabindex="-1" role="dialog" aria-labelledby="changeBoardModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <form method="POST" data-no_loader="true" id="" action="<?= base_url() ?>updateStudentBoardInfo" role="form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" style="width: 100%;" id="changeBoardModalLabel">Change Board</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                       
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div> -->


<script type="text/javascript">

    document.getElementById('medium').addEventListener('input', function () {
        this.value = ''; // Clear any input
    });
    document.getElementById('sslc_board_name').addEventListener('input', function () {
        this.value = ''; // Clear any input
    });

    mdc.textField.MDCTextField.attachTo(document.querySelector('.name_of_the_school'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.other_medium_instruction'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.register_number'));
    // mdc.textField.MDCTextField.attachTo(document.querySelector('.board_name'));
    mdc.textField.MDCTextField.attachTo(document.querySelector('.school_address'))
    const medium = mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-medium'));
    mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-year'));
    mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-month'));
    mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-attempts'));
    const role = new mdc.select.MDCSelect(document.querySelector('.mdc-select'));

    medium.listen('MDCSelect:change', () => {
        if (medium.value == "OTHER") {
            $('.other_medium_instruction_text').show();
            $('#other_medium_instruction').prop('required', true);
        } else {
            $('.other_medium_instruction_text').hide();
            $('#other_medium_instruction').prop('required', false);
        }
    });

    const board_name = mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-board'));
    const other_board_name = mdc.textField.MDCTextField.attachTo(document.querySelector('.other_board_name'));

    // const changeMDCLabel = ({
    //     focus
    // }) => {
    //     if (focus) {
    //         board_name.label.root_.className += ' mdc-floating-label--float-above';
    //         other_board_name.label_.root_.className += ' mdc-floating-label--float-above';
    //     }
    // }
    // const showChangeBoardModal = () => {
    //     changeMDCLabel({
    //         focus: true
    //     });
    //     $("#changeBoardModal").modal('show');
    // }
    // $("#updateStudentBoardInfoForm").submit(evt => {
    //     if (board_name.value == "") {
    //         evt.preventDefault();
    //         alert('Please select Board');
    //     } else if (board_name.value == 4) {
    //         if (other_board_name.value == "") {
    //             evt.preventDefault();
    //             alert('Please enter other board name');
    //             other_board_name.focus();
    //         }
    //     } else showLoader();
    // });


    let  board_name_id = $('#board_name_id').val();
   if(board_name_id != ''){

        $.ajax({
            url: baseURL+'/getStudentMarkSheet_two',
            type: 'POST',
            data: {board_name : board_name_id },
            success: function(data) {
                $(".studentMarkInfo").html(data);
                $("#coverScreen").hide();
                
                // if(board_name_id!= ''){
                //     location.reload();
                // }
            },
            error: function(result){
                    alert("Retry Again! Something Went Wrong");
                },
                fail:(function(status) {
                    alert("Retry Again! Something Went Wrong");
                }),
                beforeSend:function(d){
                    $("#coverScreen").show();
                }
        });
   }









    if (board_name.value == 4) $('.other_board_name_text').show();
    else $('.other_board_name_text').hide();

    board_name.listen('MDCSelect:change', () => {
        // const boarddName = $('#boardName').val();
        // if (boarddName == 'CBSE') {
        //     $('#secondLanguage').show();
        // }else{
        //     $('#secondLanguage').hide();
        // }
        showLoader();

        var boardName = board_name.value;
        other_board_name.value = "";
        if (board_name.value == 4) {
            $('.other_board_name_text').show();
            $('#other_board_name').prop('required', true);

        } else {
            $('.other_board_name_text').hide();
            $('#other_board_name').prop('required', false);
        }
        $.ajax({
            url: baseURL + '/getStudentMarkSheet',
            type: 'POST',
            data: {board_name : boardName},
            success: function(data) {
                $(".studentMarkInfo").html(data);
           
                $("#coverScreen").hide();
                hideLoader();
                if(board_name_id!= ''){
                    location.reload();
                    showLoader();
                }
            },
            error: function(result) {
                alert("Retry Again! Something Went Wrong");
            },
            fail: (function(status) {
                alert("Retry Again! Something Went Wrong");
            }),
            beforeSend: function(d) {
                $("#coverScreen").show();
            }
        });

        





    });
    jQuery(document).ready(function() {
        $("#icons").css('color', '#008000');
        $("#nxtBtn").click(function() {
            $("#icon").css('color', '#008000');
        });

        $('#secondLanguage').hide();

        $("#schoolDetail .nav-link").addClass('disabled');
        $('.other_medium_instruction_text').hide();

        const boardName = $('#boardName').val();
        if (boardName == 'KARNATAKA STATE BOARD') {
            $('#ninth_card').prop('required', false);
        }

        var sslcMarkCard = $('#sslcMarkCard').val();
        if (sslcMarkCard == "") {
            $('#sslc_label').html("Upload");
            if (boardName == 'KARNATAKA STATE BOARD' || boardName == 'OTHER') {
            $('#sslc_card').prop('required', false);
            }
        } else {
            $('#sslc_label').html("Change");
            $('#sslc_card').prop('required', false);
        }

        var ninthMarkCard = $('#ninthMarkCard').val();
        if (ninthMarkCard == "") {
            $('#ninth_label').html("Upload");
            $('#ninth_card').prop('required', true);
            if (boardName == 'KARNATAKA STATE BOARD') {
                $('#ninth_card').prop('required', false);
            }
        } else {
            $('#ninth_label').html("Change");
            $('#ninth_card').prop('required', false);
        }


        let  sslc_board_name = $('#sslc_board_name').val();

    if(sslc_board_name == 'OTHER'){
    $('.other_board_name_text').show();
    $('#other_board_name').prop('required',true);

  }else{
    $('.other_board_name_text').hide();  
    $('#other_board_name').prop('required',false);

  }

  const boarddName = $('#boardName').val();
        if (boarddName == 'CBSE') {
            $('#secondLanguage').show();
        }else{
            $('#secondLanguage').hide();
        }



        // $.ajax({
        //     url: baseURL + '/getStudentMarkSheet',
        //     type: 'POST',
        //     data: {},
        //     success: function(data) {
        //         $(".studentMarkInfo").html(data);
        //         $("#coverScreen").hide();
        //     },
        //     error: function(result) {
        //         alert("Retry Again! Something Went Wrong");
        //     },
        //     fail: (function(status) {
        //         alert("Retry Again! Something Went Wrong");
        //     }),
        //     beforeSend: function(d) {
        //         $("#coverScreen").show();
        //     }
        // });



    });

    $(document).ready(function() {
        $('[data-toggle="popover"]').popover({
            "container": "body",
            "trigger": "focus",
            "html": true
        });
        $('[data-toggle="popover"]').mouseenter(function() {
            $(this).trigger('focus');
        });
    });

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function alphaOnly(event) {
        var key = event.keyCode;
        return ((key >= 65 && key <= 90) || key == 8 || key == 32);
    };

    const MAX_FILE_SIZE = 200; //in KB
    const readFileURL = (input, maxSize) => {
        return new Promise((resolve, reject) => {
            try {
                if (input.files && input.files[0]) {
                    if (bytesToKB(input.files[0].size) > maxSize) {
                        reject('SIZE_ERROR');
                    } else {
                        var reader = new FileReader();
                        reader.onload = function(evt) {
                            resolve(evt.target.result);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                } else throw '404_ERROR';
            } catch (err) {
                reject(err);
            }
        });
    }
    $("#sslc_card").change(async function() {
        const {
            name,
            type
        } = this.files[0];
        try {
            const result = await readFileURL(this, MAX_FILE_SIZE);
            if (type.startsWith('image/')) {
                $('#uploadedImage2').attr('src', result);
            } else {
                $('#uploadedImage2').attr('src', result);
                $('#uploadedImage2').attr('alt', name);
            }
        } catch (err) {
            console.log('Error:', err);
            if (err === 'SIZE_ERROR') {
                showErrorAlert(
                    'The file you are attempting to upload is larger than the permitted size (' + MAX_FILE_SIZE + ' KB)',
                    'Please upload again..!'
                );
            } else showErrorAlert();
            $(this).val("");
            $('#uploadedImage2').attr('src', '');
            $('#uploadedImage2').attr('alt', 'Upload 10th Standard Mark Card');
        }
    });


    $("#ninth_card").change(async function() {
        const {
            name,
            type
        } = this.files[0];
        try {
            const result = await readFileURL(this, MAX_FILE_SIZE);
            if (type.startsWith('image/')) {
                $('#uploadedImage3').attr('src', result);
            } else {
                $('#uploadedImage3').attr('src', result);
                $('#uploadedImage3').attr('alt', name);
            }
        } catch (err) {
            console.log('Error:', err);
            if (err === 'SIZE_ERROR') {
                showErrorAlert(
                    'The file you are attempting to upload is larger than the permitted size (' + MAX_FILE_SIZE + ' KB)',
                    'Please upload again..!'
                );
            } else showErrorAlert();
            $(this).val("");
            $('#uploadedImage3').attr('src', '');
            $('#uploadedImage3').attr('alt', 'Upload 9th Standard Mark Card');
        }
    });
</script>
<script>
    $(document).ready(() => {
        checkForReply("<?= $this->session->flashdata('success') ?>", "<?= $this->session->flashdata('error') ?>");
    });
</script>