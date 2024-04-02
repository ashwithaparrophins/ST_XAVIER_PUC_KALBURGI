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
<?php } ?>
<?php
$warning = $this->session->flashdata('warning');
if ($warning) {
?>
    <div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <i class="fa fa-check mx-2"></i>
        <strong>warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
    </div>
<?php } ?>
<style>
      input[type="date"]::-webkit-calendar-picker-indicator {
        background: transparent;
        bottom: 0;
        color: transparent;
        cursor: pointer;
        height: auto;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        width: auto;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container container-fluid px-4 pt-2">
    <div class="content-wrapper">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12 col-lg-12 padding_left_right_null">
                <div class="card ">
                    <div class="card-header text-white card-content-title p-1 card_head_dashboard">
                        <div class="row ">
                            <div class="col-md-6 col-8 text-black m-auto " style="font-size:22px;"><i class="material-icons">book</i> Issue Book
                            </div>
                            <div class="col-md-2 col-4 text-black m-auto " style="font-size:22px;">
                    
                                <select class="form-control p-1 search_select" name="user_type" id="user_type">
                                        <option value="staff">STAFF</option>
                                        <option value="student" selected>STUDENT</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-4 m-auto"> <a href="#" onclick="GoBackWithRefresh();return false;" class="btn text-white btn-primary btn-bck float-right mobile-btn "><i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back </a></div>
                        </div>
                    </div>
                    <div class="alertMessage">

                    </div>
                    <div class="card-body contents-body">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addIssueInfo" action="<?php echo base_url() ?>addLibraryIssueInfo" method="post" role="form" enctype="multipart/form-data">
                        <input type="hidden" value="" id="user_type_name" name="users_type">
                            <div class="row form-contents">
                                <div class="col-lg-3 px-4">
                                    <div class="row">
                                        <div class="col-lg-12">
                                        <label for="uploadedImage">Upload Cover Image</label>
                                            <div class="form-group">
                                                <img src="<?php echo base_url(); ?>assets/dist/img/file_upload.png"
                                                    class="avatar rounded-square img-thumbnail" width="130" height="130" src="#"
                                                    id="uploadedImage" name="userfile" width="130" height="130" alt="File">
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-lg-9 px-4 pb-2">
                                    <div class="row">
                                        <div class="col-md-6 col-9">
                                                <div class="form-group">
                                                    <label for="access_code">Accession No.<span class="text-danger required_star">*</span></label>
                                                    <select name="access_code" id="access_code" class="form-control input-sm selectpicker" data-live-search="true" required>
                                                        <option value="">Select Accession No.</option>
                                                        <?php if (!empty($accessInfo)) {
                                                            foreach ($accessInfo as $access) { ?>
                                                                <option value="<?php echo $access->access_code; ?>"><?php echo $access->access_code; ?></option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-8">
                                            <div class="form-group">
                                                <label for="isbn">ISBN<i class='fas fa-info-circle ml-2' data-toggle='tooltip' data-placement='top'  title='Its 10/13 digit nos which you can find behind a book.'></i></span></label>
                                              <input type="text" class="form-control required" id="isbn" name="isbn" placeholder="ISBN No." autocomplete="off" readonly />
                                            </div>
                                            
                                        </div>
                                        <!-- <div class="input-group-append py-3 px-1">
                                            <button class="btn btn-dark" id="getIsbnDetails" 
                                                    type="button"
                                                    title="Search Book Details"><i
                                                    class="fab fa-searchengin"></i>
                                            </button>
                                        </div> -->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-9">
                                                <div class="form-group studentInfo">
                                                    <label for="student_id">Student Info<span class="text-danger required_star">*</span></label>
                                                    <select name="student_id" id="student_id" class="form-control input-sm selectpicker" data-live-search="true" >
                                                        <option value="">Select Student</option>
                                                        <?php if (!empty($studentInfo)) {
                                                            foreach ($studentInfo as $student) { ?>
                                                                <option value="<?php echo $student->student_id; ?>"><?php echo $student->student_id ; ?> - <?php echo $student->student_name; ?> - <?php echo $student->term_name; ?> - <?php echo $student->stream_name; ?> - <?php echo $student->section_name; ?></option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                        
                                            <div class="form-group staffInfo">
                                                <label for="staff_id">Staff Info</label>
                                                <select name="staff_id" id="staff_id" class="form-control input-sm selectpicker" data-live-search="true" >
                                                    <option value="">Select Staff</option>
                                                    <?php if (!empty($staffInfo)) {
                                                        foreach ($staffInfo as $staff) { ?>
                                                            <option value="<?php echo $staff->staff_id; ?>"><?php echo $staff->staff_id; ?> - <?php echo $staff->name; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="book_title">Book Title<span class="text-danger required_star">*</span></label>
                                                <input type="text" class="form-control required" id="book_title" name="book_title" placeholder="Book title" autocomplete="off" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="category">Subject<span class="text-danger required_star">*</span></label>
                                                <input type="text" class="form-control required" id="category" name="category" placeholder="Book subject" autocomplete="off" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="author_name">Author Name<span class="text-danger required_star">*</span></label>
                                                <input type="text" class="form-control required" id="author_name" name="author_name" placeholder="Book author name" autocomplete="off" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="publisher_name">Publisher Name<span class="text-danger required_star">*</span></label>
                                                <input type="text" class="form-control required" id="publisher_name" name="publisher_name" placeholder="Book publisher name" autocomplete="off" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="shelf_no">Shelf No.<span class="text-danger required_star">*</span></label>
                                                <input type="text" class="form-control required" id="shelf_no" name="shelf_no" placeholder="Book shelf No." autocomplete="off" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="date">Issue Date<span class="text-danger required_star">*</span></label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text material-icons date-icon">date_range</span>
                                                    </div>
                                                    <input id="issue_date" type="text" name="issue_date" value="<?php echo date('d-m-Y');?>" class="form-control required datepicker" placeholder="Issue Date" autocomplete="off" required />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="date">Return Date<span class="text-danger required_star">*</span></label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text material-icons date-icon">date_range</span>
                                                    </div>
                                                    <input id="return_date" type="date" name="return_date" class="form-control required " placeholder="Return Date" autocomplete="off" required />
                                                </div>
                                            </div>
                                        </div>
                                       
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="remarks">Remarks</label>
                                                <textarea class="form-control required"  name="remarks" id="remarks" rows="4" maxlength="300" placeholder="Remarks" autocomplete="off"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <input style="float:right;" type="submit" class="btn btn-primary" value="Submit" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/staff/student.js" type="text/javascript"></script>
<script type="text/javascript">
    function GoBackWithRefresh(event) {
        if ('referrer' in document) {
            window.location = '<?php echo base_url(); ?>/libraryManagementSystem';
            /* OR */
            //location.replace(document.referrer);
        } else {
            window.history.back();
        }
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 &&
            (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function isNumber(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 48 &&
            (charCode < 48 || charCode > 57))
            return false;
        return true;
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
    $("#oFile").change(function() {
        readURL(this);
    });

    jQuery(document).ready(function() {

        jQuery('.datepicker').datepicker({
            autoclose: true,
            orientation: "bottom",
            // format: "dd-mm-yyyy"
            dateFormat: "dd-mm-yy" 

        });

        $('.studentInfo').show();
        $('#user_type_name').val('student');
        $('#student_id').prop('required',true);
        $('.staffInfo').hide();
        

        $('#user_type').on('change', function() {
            $('#user_type_name').val(this.value);
           
            if (this.value == 'staff') {
                $('.staffInfo').show();
                $('#staff_id').prop('required',true);
                $('.studentInfo').hide();
                $('#student_id').prop('required',false);
           
            } else if (this.value == 'student') {
                $('.studentInfo').show();   
                $('#student_id').prop('required',true);
                $('.staffInfo').hide();
                $('#staff_id').prop('required',false);
      
            } else {
               
                $('.studentInfo').hide();
                $('.staffInfo').hide();
                $('#staff_id').prop('required',false);
                $('#student_id').prop('required',false);
               
            }
        });

        $("#getIsbnDetails").click(function() {
            var isbn = $('#isbn :selected').val();
            if(isbn == ""){ 
                $(".alertMessage").html('<div class="alert alert-warning alert-dismissable">Sorry! isbn is empty! <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>');
                $(".alertMessage").show();
            } else {
                $.ajax({
                    url: '<?php echo base_url(); ?>/getIsbnData',
                    type: 'POST',
                    data: {
                        isbn: isbn,
                    },
                    success: function(data) {
                        var info = JSON.parse(data);

                        if (info != null) {
                            
                            $('#book_title').val(info.book_title);
                            $('#category').val(info.category);
                            $('#author_name').val(info.author_name);
                            $('#publisher_name').val(info.publisher_name);
                            $('#shelf_no').val(info.shelf_no);
                            $('#uploadedImage').attr("src",info.upload_pdf);
                        }
                    },
                    error: function(result) {
                        $(".modal-title").html("Error");
                    },
                    fail: (function(status) {
                        $(".modal-title").html("Fail");
                    }),
                    beforeSend: function(d) {
                        // $('.modal-title').html('<center> Loading..</center>');
                    }
                });
            }
        });   

        $("#access_code").change(function(){
            var access_code = $(this).val();
            
                $.ajax({
                    url: '<?php echo base_url(); ?>/getAccessData',
                    type: 'POST',
                    data: {
                        access_code: access_code,
                    },
                    success: function(data) {
                        var info = JSON.parse(data);

                        if (info != null) {
                            $('#isbn').val(info.isbn);
                            $('#book_title').val(info.book_title);
                            $('#book_type').val(info.school_type);
                            $('#category').val(info.category);
                            $('#author_name').val(info.author_name);
                            $('#publisher_name').val(info.publisher_name);
                            $('#shelf_no').val(info.shelf_no);
                            $('#book_ammount').val(info.book_ammount);
                            $('#uploadedImage').attr("src",info.upload_pdf);
                        }
                    },
                    error: function(result) {
                        $(".modal-title").html("Error");
                    },
                    fail: (function(status) {
                        $(".modal-title").html("Fail");
                    }),
                    beforeSend: function(d) {
                        // $('.modal-title').html('<center> Loading..</center>');
                    }
                });
            
        });   
    });
    
</script>