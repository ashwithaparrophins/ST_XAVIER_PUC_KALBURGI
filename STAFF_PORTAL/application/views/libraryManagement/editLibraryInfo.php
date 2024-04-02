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
                            <div class="col-md-6 col-8 text-black m-auto " style="font-size:22px;"><i class="material-icons">book</i> Edit Library management
                            </div>
                            <div class="col-md-6 col-4 m-auto">
                                <a href="#" onclick="GoBackWithRefresh();return false;" class="btn text-white btn-primary btn-bck float-right mobile-btn "><i class="fa fa-arrow-circle-left"></i>&nbsp;&nbsp;Back </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body contents-body">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addAdmission" action="<?php echo base_url() ?>updateLibrary" method="post" role="form" enctype="multipart/form-data">
                            <input type="hidden" value="<?php echo $libraryInfo->row_id; ?>" id="row_id" name="row_id">
                            <div class="row form-contents">
                                <div class="col-lg-12 px-4">
                                    <div class="row">
                                    <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="access_code">Accession No.<span class="text-danger required_star">*</span><i class='fas fa-info-circle ml-2' data-toggle='tooltip' data-placement='top'  title='Its a unique no.'></i></span></label>
                                                <input type="text" class="form-control required" id="access_code" name="access_code" value="<?php echo $libraryInfo->access_code; ?>" placeholder="Enter accession No." autocomplete="off" required autofocus/>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="isbn">ISBN<i class='fas fa-info-circle ml-2' data-toggle='tooltip' data-placement='top'  title='Its 10/13 digit nos which you can find behind a book.'></i></span></label>
                                                <input type="text" class="form-control required" id="isbn" name="isbn" value="<?php echo $libraryInfo->isbn; ?>" placeholder="Enter ISBN Number" autocomplete="off"  autofocus/>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="book_title">Book Title<span class="text-danger required_star">*</span></label>
                                                <input type="text" class="form-control required" id="book_title" name="book_title" value="<?php echo $libraryInfo->book_title; ?>" placeholder="Enter Book title" autocomplete="off" required />
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="category">Subject<span class="text-danger required_star">*</span></label>
                                                <select name="category" id="category" class="form-control input-sm selectpicker" data-live-search="true" required>
                                                    <option value="<?php echo $libraryInfo->category; ?>">Selected: <?php echo strtoupper($libraryInfo->category); ?></option>
                                                    <option value="">Select Subject</option>
                                                    <?php if (!empty($categoryInfo)) {
                                                        foreach ($categoryInfo as $category) { ?>
                                                            <option value="<?php echo $category->category_name; ?>"><?php echo $category->category_name; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="author_name">Author Name<span class="text-danger required_star">*</span></label>
                                                <select name="author_name" id="author_name" class="form-control input-sm selectpicker" data-live-search="true" required>
                                                    <option value="<?php echo $libraryInfo->author_name; ?>">Selected: <?php echo strtoupper($libraryInfo->author_name); ?></option>
                                                    <option value="">Select Author Name</option>
                                                    <?php if (!empty($authorInfo)) {
                                                        foreach ($authorInfo as $author) { ?>
                                                            <option value="<?php echo $author->author_name; ?>"><?php echo $author->author_name; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="publisher_name">Publisher Name<span class="text-danger required_star">*</span></label>
                                                <select name="publisher_name" id="publisher_name" class="form-control input-sm selectpicker" data-live-search="true" required>
                                                    <option value="<?php echo $libraryInfo->publisher_name; ?>">Selected: <?php echo strtoupper($libraryInfo->publisher_name); ?></option>
                                                    <option value="">Select Publisher Name</option>
                                                    <?php if (!empty($publisherInfo)) {
                                                        foreach ($publisherInfo as $publisher) { ?>
                                                            <option value="<?php echo $publisher->publisher_name; ?>"><?php echo $publisher->publisher_name; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="shelf_no">Shelf No.<span class="text-danger required_star"></span></label>
                                                <select name="shelf_no" id="shelf_no" class="form-control input-sm selectpicker" data-live-search="true">
                                                    <option value="<?php echo $libraryInfo->shelf_no; ?>">Selected: <?php echo strtoupper($libraryInfo->shelf_no); ?></option>
                                                    <option value="">Select Shelf No.</option>
                                                    <?php if (!empty($shelfInfo)) {
                                                        foreach ($shelfInfo as $shelf) { ?>
                                                            <option value="<?php echo $shelf->shelf_no; ?>"><?php echo $shelf->shelf_no; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="book_title">Bill No.</label>
                                                <input type="text" class="form-control required" id="bill_no" name="bill_no" value="<?php echo $libraryInfo->bill_no; ?>" placeholder="Enter Bill No." autocomplete="off"  />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="book_title">Bill Date</label>
                                                <input type="text" class="form-control required datepicker" id="bill_date" name="bill_date" value= "<?php  if(empty($libraryInfo->bill_date)|| $libraryInfo->bill_date == '1970-01-01' || $libraryInfo->bill_date == '0000-00-00'){
                                                       echo "";
                                                    } else{
                                                        echo date('d-m-Y',strtotime($libraryInfo->bill_date));
                                                    } ?>" placeholder="Enter Bill Date" autocomplete="off"  />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="book_title">Price<span class="text-danger required_star">*</span></label>
                                                <input type="text" class="form-control required" id="price" name="price" value="<?php echo $libraryInfo->price; ?>" placeholder="Enter Price" autocomplete="off" required />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="book_title">No. of copies</label>
                                                <input type="text" class="form-control required" id="no_of_copies" name="no_of_copies" value="<?php echo $libraryInfo->no_of_copies; ?>" placeholder="Enter No. of copies" autocomplete="off"  readonly/>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="book_title">Year of Edition</label>
                                                <input type="text" class="form-control required" id="year" name="year" value="<?php echo $libraryInfo->year; ?>" placeholder="Enter Year of Edition" autocomplete="off"  />
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="book_title">No. of Pages<span class="text-danger required_star">*</span></label>
                                                <input type="text" class="form-control required" id="pages" name="pages" value="<?php echo $libraryInfo->no_of_page; ?>" placeholder="Enter No.of pages" autocomplete="off" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="uploadedImage">Upload Cover Image</label>
                                            <div class="form-group text-center">
                                                <?php if(!empty($libraryInfo->upload_pdf)){ 
                                                    $ext = pathinfo($libraryInfo->upload_pdf, PATHINFO_EXTENSION); 
                                                        if($ext == 'jpeg' || $ext == 'jpg' || $ext == 'png'){ 
                                                    ?>
                                                    <img src="<?php echo base_url(); ?><?php echo $libraryInfo->upload_pdf; ?>"
                                                        class="avatar rounded-square img-thumbnail" width="130" height="130" src="#"
                                                        id="uploadedImage" name="userfile" width="130" height="130" alt="avatar">
                                                <?php }else{ ?>
                                                    <img src="<?php echo base_url(); ?>assets/dist/img/file_upload.png"
                                                        class="avatar rounded-circle img-thumbnail" width="130" height="130" src="#"
                                                        id="uploadedImage" width="130" height="130" alt="avatar">
                                                <?php } } ?>
                                                   <div class="profileImg">
                                                        <div class="file btn btn-sm btn-primary">
                                                            Change
                                                            <input type="file" class="form-control-sm" id="vImg" name="userfile">
                                                        </div>
                                                    </div>
                                            </div> 
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-success m-2 float-right" value="Update" />
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
    $("#vImg").change(function() {
        readURL(this);
    });

    jQuery(document).ready(function() {

        jQuery('.datepicker').datepicker({
            autoclose: true,
            orientation: "bottom",
            // format: "dd-mm-yyyy"
            dateFormat: "dd-mm-yy" 

        });

    });
</script>