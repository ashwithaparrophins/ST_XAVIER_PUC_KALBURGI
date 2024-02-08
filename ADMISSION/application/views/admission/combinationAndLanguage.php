<style>
    <?php if($_SESSION['application_number_status'] == false){ ?> 
        .main-sidebar .nav #documentDetail, .main-sidebar .nav #paymentDetail, .main-sidebar .nav #dashboard {
            display: none !important;
        }
    <?php } ?>

    <?php if($_SESSION['application_number_status'] == true){ ?> 
        #icons, #icon, #combination, #document, #payment{
            color: #008000 !important;
        }
    <?php } ?>
</style>
<?php
$first_language=""; 
$second_language=""; 
$program_name=""; 
$stream_name=""; 
$second_stream_name ="";
$national_level_sports_status="";
$ncc_certificate_status="";
$second_program_name = "";
if(!empty($studentAdmissionInfo)){
    $first_language = $studentAdmissionInfo->first_language; 
    $second_language= $studentAdmissionInfo->second_language; 
    $program_name= $studentAdmissionInfo->program_name; 
    $second_stream_name= $studentAdmissionInfo->second_stream_name; 
    $stream_name= $studentAdmissionInfo->stream_name; 
    $integrated_batch = $studentAdmissionInfo->integrated_batch;
    $second_program_name = $studentAdmissionInfo->second_program_name; 
    $national_level_sports_status= $studentAdmissionInfo->national_level_sports_status; 
    $ncc_certificate_status= $studentAdmissionInfo->ncc_certificate_status;   
}


$sports_certificate = "";
$ncc_certificate = "";
if(!empty($documentInfo)){ 
    foreach($documentInfo as $doc){
        if($doc->doc_name == 'national_level_sports_certificate'){
            $sports_certificate = $doc->doc_path;
            $sports_label = $doc->doc_name;
        }
        if($doc->doc_name == 'ncc_certificate'){
            $ncc_certificate = $doc->doc_path;
            $ncc_label = $doc->doc_name;
        }
    }
}

?>

<?php
    $this->load->helper('form');
?>

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

<div class="row ">
    <div class="col-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>    

<div class="main-content-container container-fluid px-2 mb-5">
    <div class="card card-small p-0  col-12  ">
        <div class="card-header card_head_dashboard p-2 ">
            <span class="page-title">
                <div class="row font_color ">
                    <div class="col-sm-6">
                        Step : III <i class="fa fa-book"></i> Combination and Language Opted
                    </div>
                    <div class="col-sm-6 text-right">
                        <i class=""></i> Admission Form : <?=ADMISSION_YEAR?>
                    </div>
                </div>
            </span>
        </div>
                     
        <form method="POST" id="sjpucInfoForm" action="<?php echo base_url(); ?>saveAdmissionInfo" role="form" enctype="multipart/form-data">     
            <div class="card-body">
                <div class="row">
                    <div class="col-12 column_padding_card">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-4 mb-1">
                                <div class="form-group">
                                    <label class="language_first mdc-text-field mdc-text-field--filled ">
                                        <span class="mdc-text-field__ripple"></span>
                                        <input type="text"  name="language_first" id="language_first" value="English" class="mdc-text-field__input" aria-labelledby="my-label-id"  autocomplete="off" readonly>
                                        <span class="mdc-floating-label" id="my-label-id">Language I</span>
                                        <span class="mdc-line-ripple"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-4 mb-2">
                                <div class="form-group">
                                    <div class="mdc-select mdc-select-program_name mdc-select--required">
                                        <div class="mdc-select__anchor demo-width-class">
                                            <span class="mdc-select__ripple"></span>
                                            <input type="text" class="mdc-select__selected-text" name="program_name" value="" id="program_name"  onkeydown="return false;" onfocus="this.blur();" required>
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <span class="mdc-floating-label">Select Course for First Preference</span>
                                            <span class="mdc-line-ripple"></span>
                                        </div>
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                            <ul class="mdc-list">
                                                <li class="mdc-list-item" data-value="" disabled selected hidden>
                                                    <span class="mdc-list-item__text">Select Course for First Preference</span>
                                                </li>
                                                <?php if(!empty($program_name)){ ?>
                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $program_name; ?>" aria-selected="true"><?php echo $program_name; ?></li>
                                                <?php } ?>
                                                <li class="mdc-list-item" data-value="SCIENCE">
                                                <span class="mdc-list-item__text">
                                                    SCIENCE
                                                </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="COMMERCE">
                                                <span class="mdc-list-item__text">
                                                    COMMERCE
                                                </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="ARTS">
                                                <span class="mdc-list-item__text">
                                                    ARTS
                                                </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-4 mb-2">
                                <div class="form-group">
                                    <div class="mdc-select mdc-select-stream_name mdc-select--required">
                                        <div class="mdc-select__anchor" aria-required="true">
                                            <span class="mdc-select__ripple"></span>
                                            <input type="text" class="mdc-select__selected-text" name="stream_name" id="stream_name" value="" onkeydown="return false;" onfocus="this.blur();" required>
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <span class="mdc-floating-label">Select Stream for First Preference</span>
                                            <span class="mdc-line-ripple"></span>
                                        </div>
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                            <ul class="mdc-list">
                                                <?php if(!empty($stream_name)){ ?>
                                                    <li class="mdc-list-item mdc-list-item--selected" id="selectedFirstStream" data-value="<?php echo $stream_name; ?>" aria-selected="true"><?php echo $stream_name; ?></li>
                                                <?php } ?>
                                                <div id="streamName">
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-4 mb-2 ">
                                <div class="form-group">
                                    <div class="mdc-select mdc-select-language_second mdc-select--required">
                                        <div class="mdc-select__anchor demo-width-class" aria-required="true">
                                            <span class="mdc-select__ripple"></span>
                                            <input type="text" class="mdc-select__selected-text" name="language_second" value="" onkeydown="return false;" onfocus="this.blur();" data-live-search="true" id="language_second" required>
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <span class="mdc-floating-label">Language II</span>
                                            <span class="mdc-line-ripple"></span>
                                        </div>
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                            <ul class="mdc-list">
                                                <li class="mdc-list-item" data-value="" selected hidden>
                                                    <span class="mdc-list-item__text"> Select Second Language </span>
                                                </li>
                                                <?php if(!empty($second_language)){ ?>
                                                    <li class="mdc-list-item mdc-list-item--selected" data-value="<?php echo $second_language; ?>" aria-selected="true"><?php echo $second_language; ?></li>
                                                <?php } ?>
                                                
                                                <li class="mdc-list-item" data-value="KANNADA">
                                                <span class="mdc-list-item__text">
                                                    KANNADA
                                                </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="HINDI">
                                                <span class="mdc-list-item__text">
                                                    HINDI
                                                </span>
                                                </li>
                                                <!-- <li class="mdc-list-item" data-value="FRENCH">
                                                <span class="mdc-list-item__text">
                                                    FRENCH
                                                </span>
                                                </li> -->
                                            </ul>
                                        </div>
                                     </div>
                                </div>  
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-4 mb-2 ">
                                <div class="form-group">
                                    <div class="mdc-select mdc-select-second_program_name">
                                        <div class="mdc-select__anchor demo-width-class">
                                            <span class="mdc-select__ripple"></span>
                                            <input type="text" class="mdc-select__selected-text" name="second_program_name" value="" data-live-search="true" id="second_program_name" >
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <span class="mdc-floating-label">Select Course for Second Preference(Optional)</span>
                                            <span class="mdc-line-ripple"></span>
                                        </div>
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                            <ul class="mdc-list">
                                                <li class="mdc-list-item" data-value="" disabled selected hidden>
                                                    <span class="mdc-list-item__text">
                                                    Select Course for Second Preference(Optional)
                                                </span>
                                                </li>
                                                <?php if(!empty($second_program_name)){ ?>
                                                    <li class="mdc-list-item mdc-list-item--selected" id="SecondProgramName" data-value="<?php echo $second_program_name; ?>" aria-selected="true"><?php echo $second_program_name; ?></li>
                                                <?php } ?>
                                                <li class="mdc-list-item" data-value="SCIENCE">
                                                <span class="mdc-list-item__text">
                                                    SCIENCE
                                                </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="COMMERCE">
                                                <span class="mdc-list-item__text">
                                                    COMMERCE
                                                </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="ARTS">
                                                <span class="mdc-list-item__text">
                                                    ARTS
                                                </span>
                                                </li>
                                            </ul>
                                        </div>
                                     </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-4   mb-2">
                                <div class="form-group">
                                    <div class="mdc-select mdc-select-second_stream_name">
                                        <div class="mdc-select__anchor demo-width-class">
                                            <span class="mdc-select__ripple"></span>
                                            <input type="text"  class="mdc-select__selected-text" name="second_stream_name" id="second_stream_name" value="">
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <span class="mdc-floating-label">Select Stream For Second Preference(Optional)</span>
                                            <span class="mdc-line-ripple"></span>
                                        </div>
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                            <ul class="mdc-list" id="second_stream_name">
                                                <?php if(!empty($second_stream_name)){ ?>
                                                    <li class="mdc-list-item mdc-list-item--selected" id="selectedSecondStream" data-value="<?php echo $second_stream_name; ?>" aria-selected="true"><?php echo $second_stream_name; ?></li>
                                                <?php } ?>
                                                <div id="secondStreamPreference">
                                                </div>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="col-lg-4 col-md-6 col-sm-4 mb-2">
                                <div class="form-group">
                                    <div class="mdc-select mdc-select-integrated_batch">
                                        <div class="mdc-select__anchor demo-width-class">
                                            <span class="mdc-select__ripple"></span>
                                            <input type="text" class="mdc-select__selected-text" name="integrated_batch" value="" data-live-search="true" id="integrated_batch" required>
                                            <i class="mdc-select__dropdown-icon"></i>
                                            <span class="mdc-floating-label">Select Preference*</span>
                                            <span class="mdc-line-ripple"></span>
                                        </div>
                                        <div class="mdc-select__menu mdc-menu mdc-menu-surface demo-width-class">
                                            <ul class="mdc-list">
                                                <li class="mdc-list-item" data-value="" disabled selected hidden>
                                                    <span class="mdc-list-item__text">
                                                    Select Integrated Batch(Optional)
                                                </span>
                                                </li>
                                                <?php if(!empty($integrated_batch)){ ?>
                                                    <li class="mdc-list-item mdc-list-item--selected" id="" data-value="<?php echo $integrated_batch; ?>" aria-selected="true"><?php echo $integrated_batch; ?></li>
                                                <?php } ?>
                                                <li class="mdc-list-item" data-value="JEE">
                                                <span class="mdc-list-item__text">
                                                    JEE
                                                </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="NEET">
                                                <span class="mdc-list-item__text">
                                                    NEET
                                                </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="CET">
                                                <span class="mdc-list-item__text">
                                                    CET
                                                </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="CLAT">
                                                <span class="mdc-list-item__text">
                                                    CLAT
                                                </span>
                                                </li>
                                                <li class="mdc-list-item" data-value="NONE">
                                                <span class="mdc-list-item__text">
                                                    NONE
                                                </span>
                                                </li>
                                            </ul>
                                        </div>
                                     </div>
                                </div>
                            </div> -->
                        </div>


                        <!-- <div class="card col-12 field_color shadow-none  pl-0 pr-0 mt-3 mb-2">
                            <div class="card-header text-left inside_color pt-3 pb-3 ml-0">Other Details</div>    
                        </div>  -->

                        <!-- <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group sports_label">
                                    <label for="sports">Participated in State/ National Level Sports &nbsp; 
                                        <div class="form-check mt-1">
                                            <input type="radio" id="sports" name="sports" value="YES" required <?php if($national_level_sports_status == "YES"){  echo "checked";  } ?>> <span class="pl-1 pr-2">Yes</span> &nbsp; 
                                            <span></span><input type="radio" id="sports" name="sports" value="NO" required <?php if($national_level_sports_status == "NO"){  echo "checked";  } ?>><span class="pl-1 pr-2">No</span><br></span>
                                        </div>
                                    </label>
                                </div>
                            </div>  
                                
                            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group ncc_label">
                                    <label for="ncc">Participated in the Republic Day Parade/ NCC Certificate &nbsp; 
                                        <div class="form-check mt-1 ncc_value">
                                            <input type="radio" id="ncc" name="ncc" value="YES" required <?php if($ncc_certificate_status == "YES"){  echo "checked";  } ?>> <span class="pl-0 pr-2">Yes</span>&nbsp; 
                                            <span></span><input type="radio" id="ncc" name="ncc" required value="NO" <?php if($ncc_certificate_status == "NO"){  echo "checked";  } ?>> <span class="pl-1 pr-2">No</span><br></span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2 sportsCertificate">
                                <div class="card col-12 field_color shadow-none  pl-0 pr-0 mt-3 mb-1 ">
                                    <div class="card-header text-left inside_color pt-3 pb-3 ml-0">Upload National / State Level ( whichever is the highest) Sports Certificate<span class="text-danger required_star">*</span> <span class="text-danger font_14">(Note: Maximum File Size 200KB, File format: JPG, JPEG, PNG, PDF)</span>
                                    </div>    
                                </div> 
                                <div class="text-center mb-2">
                                    <?php if(!empty($sports_certificate)){ ?>
                                        <img src="<?php echo base_url(); ?><?php echo $sports_certificate; ?>" id="uploadedImage" class="avatar img-thumbnail school_documents"
                                        alt="<?php echo $sports_label; ?>">
                                    <?php }else{ ?>
                                        <img src="<?php echo base_url(); ?>assets/dist/img/file_upload.png" id="uploadedImage" class="avatar img-thumbnail school_documents"
                                        alt="Certificate">
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="doc_name[]" id="doc_name" value="national_level_sports_certificate"/>
                                    <div class="profileImg text-center">
                                        <div class="file btn btn-sm btn-primary">
                                            <div id="sports_label"></div>
                                            <input type="file" class="form-control-sm" id="sports_input" name="userfile[]" accept=".pdf, image/png, image/jpeg, image/jpg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2 nccCertificate">
                                <div class="card col-12 field_color shadow-none  pl-0 pr-0 mt-3 mb-1 ">
                                    <div class="card-header text-left inside_color pt-3 pb-3 ml-0">Upload NCC Certificate<span class="text-danger required_star">*</span> <span class="text-danger font_14">(Note: Maximum File Size 200KB, File format: JPG, JPEG, PNG, PDF)</span>
                                    </div>    
                                </div> 
                                <div class="text-center mb-2">
                                    <?php if(!empty($ncc_certificate)){ ?>
                                        <img src="<?php echo base_url(); ?><?php echo $ncc_certificate; ?>" id="uploadedImage1" class="avatar img-thumbnail school_documents"
                                        alt="<?php echo $ncc_label; ?>">
                                    <?php }else{ ?>
                                        <img src="<?php echo base_url(); ?>assets/dist/img/file_upload.png" id="uploadedImage1" class="avatar img-thumbnail school_documents"
                                        alt="Certificate">
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="doc_name[]" id="doc_name" value="ncc_certificate"/>
                                    <div class="profileImg text-center">
                                        <div class="file btn btn-sm btn-primary">
                                            <div id="ncc_label"></div>
                                            <input type="file" class="form-control-sm" id="ncc_input" name="userfile[]" accept=".pdf, image/png, image/jpeg, image/jpg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  -->
                        
                    </div>
                </div>
            </div>
                    
            <div class="card-footer card_head_dashboard p-2">
                <div class="row">
                    <div class="col-6 text-left">
                        <a href="<?php echo base_url(); ?>viewSchoolDetail" id="previousloader" class="mdc-button mdc-button--raised btn_primary"><i class="fas fa-angle-double-left"></i> Previous</a>           
                    </div>
                    <div class="col-6 text-right">
                        <button class="mdc-button mdc-button--raised text-right btn_success" type="submit" id="NextBtn">
                            <span class="mdc-button__label"> Next </span>
                            <i class="fas fa-angle-double-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <div class="clearfix"></div>   
    </div> 

</div> 
                             
            
<script type="text/javascript">
     document.getElementById('program_name').addEventListener('input', function () {
        this.value = ''; // Clear any input
    });
    document.getElementById('stream_name').addEventListener('input', function () {
        this.value = ''; // Clear any input
    });
    document.getElementById('language_second').addEventListener('input', function () {
        this.value = ''; // Clear any input
    });
    mdc.textField.MDCTextField.attachTo(document.querySelector('.language_first'));
    const stream_name_selected = mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-stream_name'));
    const second_stream_name_selected = mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-second_stream_name'));
    mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-language_second'));
    // mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-integrated_batch'));
    const program_name = mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-program_name'));
    const second_program_name = mdc.select.MDCSelect.attachTo(document.querySelector('.mdc-select-second_program_name'));

    program_name.listen('MDCSelect:change', () => {
        var programName = program_name.value;
        
        stream_name_selected.value = "";
        if(programName == ""){
            $('#second_stream_name').attr('readonly',true);
        }
        $('#stream_name option:not(:first)').remove();
        $.ajax({
            url: '<?php echo base_url(); ?>/getStreamNamesByProgram',
            type: 'POST',
            data: { program_name : programName},
            success: function(data) { 
                var newHtml = "";
                $('#stream_name').attr('disabled',false);
                $('#selectedFirstStream').remove();
                $("#coverScreen").hide();  
                var count = data.stream_name.length;
                for(var i=0; i<count; i++){
                    newHtml += '<li class="mdc-list-item" data-value="'+data.stream_name[i].stream_name+'><span class="mdc-list-item__text">'+data.stream_name[i].stream_name+'</span></li>'
                }
                $("#streamName").html(newHtml);
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
    });

    second_program_name.listen('MDCSelect:change', () => {
        var second_programName = second_program_name.value;
       
        second_stream_name_selected.value = "";
        if(second_programName == ""){
            $('#second_stream_name').attr('readonly',true);
        } 
        $('#second_stream_name option:not(:first)').remove();
        $.ajax({
            url: '<?php echo base_url(); ?>/getStreamNamesByProgram',
            type: 'POST',
            data: { program_name : second_programName},
            success: function(data) {
                var newHtml = "";
                $('#second_stream_name').attr('readonly',false);
                $('#selectedSecondStream').remove();
                $("#coverScreen").hide();
                var count = data.stream_name.length;
                for(var i=0; i<count; i++){
                    newHtml += '<li class="mdc-list-item" data-value="'+data.stream_name[i].stream_name+'><span class="mdc-list-item__text">'+data.stream_name[i].stream_name+'</span></li>'
                }
                $("#secondStreamPreference").html(newHtml);
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
    });

    $(function () {
        $("#icons").css('color', '#008000');
        $("#icon").css('color', '#008000');
        $("#NextBtn").click(function () {
            $("#combination").css('color', '#008000');
        });
    });

jQuery(document).ready(function(){
    if($("#stream_name").val() != ""){
        $('#stream_name').attr('disabled',false);
        }else{
        $('#stream_name').attr('disabled',true);
    }
    if($("#second_stream_name").val() != ""){
        $('#second_stream_name').attr('readonly',false);
        }else{
        $('#second_stream_name').attr('readonly',true);
    }

    

    var sports = $('input[name="sports"]:checked').val();
    if(sports == "YES"){
        $('.sportsCertificate').show();
        $('#sports_label').html("Change");
    }else{
        $('.sportsCertificate').hide();
    } 


    var ncc = $('input[name="ncc"]:checked').val();
    if(ncc == "YES"){
        $('.nccCertificate').show();
        $('#ncc_label').html("Change");
    }else{
        $('.nccCertificate').hide();
    }

    $('input[name=ncc]').change(function(){
        var value = $('input[name=ncc]:checked').val();
        if(value == "YES"){
            $('.nccCertificate').show();
            $('#ncc_input').prop('required',true);
            $('#ncc_label').html("Upload");
        }else{
            $('.nccCertificate').hide();  
            $('#ncc_input').prop('required',false);
        }
    });
    
    $('input[name=sports]').change(function(){
        var value = $('input[name=sports]:checked').val();
        if(value == "YES"){
            $('.sportsCertificate').show();
            $('#sports_input').prop('required',true);
            $('#sports_label').html("Upload");
        }else{
            $('.sportsCertificate').hide();  
            $('#sports_input').prop('required',false);
        }
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

    const MAX_FILE_SIZE = 200; //in KB

    const readFileURL = (input, maxSize)=>{
        return new Promise((resolve, reject)=>{
            try{
                if(input.files && input.files[0]) {
                    if(bytesToKB(input.files[0].size) > maxSize){
                        reject('SIZE_ERROR');
                    }else{
                        var reader = new FileReader();
                        reader.onload = function(evt) {
                            resolve(evt.target.result);
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }else throw '404_ERROR';
            }catch(err){
                reject(err);
            }
        });
    }
    $("#sports_input").change(async function() {
        const { name, type }  = this.files[0];
        try{
            const result = await readFileURL(this, MAX_FILE_SIZE);
            if(type.startsWith('image/')){
                $('#uploadedImage').attr('src', result);
            }else{
                $('#uploadedImage').attr('src', result);
                $('#uploadedImage').attr('alt', name);
            }
        }catch(err){
            console.log('Error:', err);
            if(err === 'SIZE_ERROR'){
                showErrorAlert(
                    'The file you are attempting to upload is larger than the permitted size ('+ MAX_FILE_SIZE +' KB)',
                    'Please upload again..!'
                );
            }else showErrorAlert();
            $(this).val("");
            $('#uploadedImage').attr('src', '');
            $('#uploadedImage').attr('alt', 'Upload Sports Certificate');
        }
    });
    $("#ncc_input").change(async function() {
        const { name, type }  = this.files[0];
        try{
            const result = await readFileURL(this, MAX_FILE_SIZE);
            if(type.startsWith('image/')){
                $('#uploadedImage1').attr('src', result);
            }else{
                $('#uploadedImage1').attr('src', result);
                $('#uploadedImage1').attr('alt', name);
            }
        }catch(err){
            console.log('Error:', err);
            if(err === 'SIZE_ERROR'){
                showErrorAlert(
                    'The file you are attempting to upload is larger than the permitted size ('+ MAX_FILE_SIZE +' KB)',
                    'Please upload again..!'
                );
            }else showErrorAlert();
            $(this).val("");
            $('#uploadedImage1').attr('src', '');
            $('#uploadedImage1').attr('alt', 'Upload NCC Certificate');
        }
    });
</script>
<script>
    $(document).ready(()=>{
        checkForReply("<?=$this->session->flashdata('success')?>","<?=$this->session->flashdata('error')?>");        
    });
</script>