<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content=""/>
        <meta name="author" content="Parrophins" />
        <title>ST XAVIER PUC - Job Portal</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="<?=base_url()?>assets/img/logo_stxpuc.jpg" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
        <!-- Third party plugin CSS-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="<?=base_url()?>assets/css/styles.css" rel="stylesheet" />
        <link href="<?=base_url()?>assets/css/custom.css" rel="stylesheet" />
        <link href="<?=base_url()?>assets/css/bootstrap-multiselect.css" rel="stylesheet" />
        <link href="<?=base_url()?>assets/css/bootstrap-datepicker3.min.css" rel="stylesheet" />

         <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>-->
        <!--<script type="text/javascript" src="<?=base_url()?>assets/js/jquery.slim.min.js"></script>-->  

        <script src="<?=base_url()?>assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap-multiselect.js"></script>
        <script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="<?=base_url()?>assets/js/sweetalert2.js"></script>
        <!--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>  -->
        
        <script type="text/javascript">
            const showCustomAlert = (error="",success="") =>{
                if(error != ""){
                    Swal.fire({
                        title: error,
                        text: 'Please try again..!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                }else if(success != ""){
                    Swal.fire(
                        success,
                        'We will look into it and get back to you',
                        'success'
                    );
                }
            }
            const showLoader = ()=>{
                $(".custom_loader").addClass('active');
                $("#custom_loader_text").css('display','block');
            }
            const hideLoader = ()=>{
                $(".custom_loader").removeClass('active');
                $("#custom_loader_text").css('display','none');
            }
            const openFileExplorer = () =>{
                $("#profilePic").trigger('click');
            }
            const isValidKey = (event)=>{
                //8 - backspace
                //46 - delete
                //37 - left-arrow
                //39 - right-arrow
                //9 - tab
                const allowedKeys = [8,9,37,39,46];
                return (allowedKeys.includes(event.which))?  true : false;
            }
            const bytesToKB = (bytes=0)=>{
                return (bytes==0)? 0 : (bytes/1000);
            }
            
            const readProfileURL = (input)=>{
                if (input.files && input.files[0]) {
                    if(bytesToKB(input.files[0].size) > 1024){
                        showCustomAlert("The profile picture you are attempting to upload is larger than the permitted size(1 MB)");
                        $(input).val("");
                    }else{
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            }
            const readResumeURL = (input)=>{
                if (input.files && input.files[0]) {
                    if(bytesToKB(input.files[0].size) > 2048){
                        showCustomAlert("The resume you are attempting to upload is larger than the permitted size(2 MB)");
                        $(input).val("");
                        $("#custom-resume-file-label").html("Choose a file (File size should be less than 2MB)");
                    }else{
                        $("#custom-resume-file-label").html(input.files[0].name);
                    }
                }
            }

            $(document).ready(function() {
                hideLoader();
                showCustomAlert("<?=$this->session->flashdata('error')?>","<?=$this->session->flashdata('success')?>");
                $('#languages_known').multiselect();
                $("form").on('submit',(evt)=>{
                    $("#hidden_languages_known").val(JSON.stringify($("#languages_known").val()));
                    let $errorMsg = "";
                    if($("#profilePic").val() == ""){
                        $errorMsg = "Please select your profile picture";
                    }
                    else if($("#resumeFile").val() == ""){
                        $errorMsg = "Please upload your resume";
                    }else if($("#mobile_number").val().length < 10){
                        $errorMsg = "Please enter valid mobile number";
                    }

                    if($errorMsg != ""){
                        evt.preventDefault();
                        showCustomAlert($errorMsg);
                    }else{
                        showLoader();
                    }
                });

                $('input[type="number"').on('keydown',(evt)=>{
                    if(evt.which != 69){
                        if(evt.target.id=="mobile_number"){
                            if($(evt.target).val().length >= 10){
                                if(!isValidKey(evt)){
                                    evt.preventDefault();
                                }
                            }
                        }
                    }else{
                        evt.preventDefault();
                    }
                });

                $('input[type="number"').on('keyup',(evt)=>{
                   $(evt.target).val(+$(evt.target).val());
                });

                $("#profilePic").change(function() {
                    readProfileURL(this);
                });

                $("#resumeFile").change(function() {
                    readResumeURL(this);
                });
            });
        </script>
        <style>
        </style>
    </head>
    <body id="page-top">
    <div class="custom_loader"><span id="custom_loader_text" style="color:blue;font-weight:bold;margin-left: -100%;font-size: 17px;display:none;">Loading...</span></div>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="#page-top">ST XAVIER PUC - Job Portal</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#apply_now_form">Apply Now</a></li>
                        <!--<li class="nav-item"><a class="nav-link js-scroll-trigger" href="#services">Services</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#portfolio">Portfolio</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href`="#contact">Contact</a></li>-->
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-end">
                        <img src="<?php echo base_url(); ?>assets/img/logo_stxpuc.jpg" alt="St. Joseph School Logo" style="max-height: 100px; margin-bottom: 20px;">
                        <h2 class="text-uppercase text-white font-weight-bold">ST XAVIER'S PRE–UNIVERSITY COLLEGE, KALABURAGI</h2>
                        <hr class="divider my-4" />
                    </div>
                    <div class="col-lg-8 align-self-baseline">
                        <h4 style="color:white"><b>Job Vacancy</b></h4><br>
                        <a class="btn btn-primary btn-xl js-scroll-trigger" href="#apply_now_form">Apply Now</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- About-->
        <section class="page-section bg-primary" id="apply_now_form">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">                        
                        <div class="card card-outline-secondary">
                            <div class="card-header">
                                <h3 class="mb-0 text-center">Application Form</h3>
                            </div>
                            <div class="card-body">

                                <form method="POST" action="<?=base_url()?>apply_now" enctype="multipart/form-data" class="form" id="formApplyNow" name="formApplyNow" role="form">
                                    <div class="container mb-5">
                                        <div class="row">
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type='file' id="profilePic" name="profilePic" accept=".png, .jpg, .jpeg"/>
                                                </div>
                                                <div class="avatar-preview text-center">
                                                    <div id="imagePreview" style="background-image: url(<?=base_url()?>assets/img/profile-bg.jpg);">
                                                    </div>
                                                    <button style="font-size:15px;" type="button" onclick="openFileExplorer()" class="btn btn-primary btn-block mt-3">Upload Profile Photo</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="subject">Subject *</label> 
                                                <input class="form-control" id="subject" name="subject" type="text" 
                                                placeholder="Ex: Physics, History, etc." autocomplete="off" required/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="fullname">Full Name *</label> 
                                                <input class="form-control" id="fullname" name="fullname" type="text"
                                                autocomplete="off" required/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="qualification">Qualification *</label> 
                                                <input class="form-control" id="qualification" name="qualification" type="text" 
                                                placeholder="Ex: B.Ed, Ph.D etc." autocomplete="off" required/>
                                            </div>                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="sslc_percent">SSLC/10<sup>th</sup> Marks (in %) *</label> 
                                                <input class="form-control" id="sslc_percent" name="sslc_percent" type="number" 
                                                min="0" max="100" autocomplete="off" required/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="puc_percent">PUC Marks (in %) *</label> 
                                                <input class="form-control" id="puc_percent" name="puc_percent" type="number" 
                                                min="0" max="100"autocomplete="off" required/>
                                            </div>                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="ug_percent">Under Graduation Marks (in %) *</label> 
                                                <input class="form-control" id="ug_percent" name="ug_percent" type="number" 
                                                min="0" max="100" autocomplete="off" required/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="pg_percent">Post Graduation Marks (in %)</label> 
                                                <input class="form-control" id="pg_percent" name="pg_percent" type="number" 
                                                min="0" max="100" autocomplete="off"/>
                                            </div>                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="bed_percent">B.Ed Marks (in %) *</label> 
                                                <input class="form-control" id="bed_percent" name="bed_percent" type="number" 
                                                min="0" max="100" autocomplete="off" required/>
                                            </div>                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="mobile_number">Mobile Number *</label> 
                                                <input class="form-control" id="mobile_number" name="mobile_number" type="number" 
                                                autocomplete="off" required/>
                                            </div>                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="email_id">Email ID *</label> 
                                                <input class="form-control" id="email_id" name="email_id" type="email" 
                                                autocomplete="off" required/>
                                            </div>                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="religion">Religion</label> 
                                                <input class="form-control" id="religion" name="religion" type="text"
                                                placeholder="Ex: Hindu, Christian, Muslim, etc." autocomplete="off"/>
                                            </div>                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="cast">Cast / SubCast</label> 
                                                <input class="form-control" id="cast" name="cast" type="text"
                                                placeholder="Ex: Brahmins, Buddhists, etc." autocomplete="off"/>
                                            </div>                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group dob">
                                                <label for="dob">Date of Birth *</label> 
                                                <input class="form-control datepicker" id="dob" name="dob" type="text" 
                                                placeholder="dd-mm-yyyy" autocomplete="off" required/>
                                            </div>                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="marital_status">Marital Status</label> 
                                                <select class="form-control" id="marital_status" name="marital_status">
                                                    <option value="">Select Marital Status</option>
                                                    <option value="Unmarried">Un Married</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Divorced">Divorced</option>
                                                </select>
                                            </div>                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="work_experience">Work Experience (in Years) *</label> 
                                                <input class="form-control" id="work_experience" name="work_experience" type="text" autocomplete="off" required/>
                                            </div>                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="expected_salary">Expected Salary</label> 
                                                <input class="form-control" id="expected_salary" name="expected_salary" type="number" autocomplete="off"/>
                                            </div>                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="blood_group">Blood Group</label> 
                                                <select class="form-control" id="blood_group" name="blood_group" >
                                                    <option value="">Select Blood Group</option>
                                                    <option value="A+">A+</option>
                                                    <option value="A-">A-</option>
                                                    <option value="B+">B+</option>
                                                    <option value="B-">B-</option>
                                                    <option value="AB+">AB+</option>
                                                    <option value="AB-">AB-</option>
                                                    <option value="O+">O+</option>
                                                    <option value="O-">O-</option>
                                                </select>
                                            </div>                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="mother_tongue">Mother Tongue</label> 
                                                <input class="form-control" id="mother_tongue" name="mother_tongue" type="text" autocomplete="off"/>
                                            </div>                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="row multiselect-row">
                                                <div class="col-12">
                                                    <label for="languages_known">Languages Known</label>                                                     
                                                </div>
                                                <div class="col-12">
                                                    <select id="languages_known" multiple="multiple" >
                                                        <option value="English">English</option>
                                                        <option value="Kannada">Kannada</option>
                                                        <option value="Hindi">Hindi</option>
                                                        <option value="Tamil">Tamil</option>
                                                        <option value="Telugu">Telugu</option>
                                                        <option value="Malayalam">Malayalam</option>
                                                        <option value="French">French</option>
                                                        <option value="Japanese">Japanese</option>
                                                        <option value="Chinese">Chinese</option>
                                                        <option value="Spanish">Spanish</option>
                                                        <option value="Greek">Greek</option>
                                                        <option value="Tulu">Tulu</option>
                                                        <option value="Konkani">Konkani</option>
                                                        <option value="Urdu">Urdu</option>
                                                    </select>  
                                                </div>
                                            </div>                                 
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                    <label for="job_post">Job Post</label>                                                     
                                                
                                                <select class="form-control" data-live-search="true" id="job_post" name="job_post" required>

                                                    <option value="">Select Job Post</option>

                                                    <?php foreach($getPostName as $job){ ?>
                                                    <option value="<?php echo $job->row_id ?>"><?php echo $job->job_post ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="additional_qualification">Additional Qualification</label> 
                                                <input class="form-control" id="additional_qualification" name="additional_qualification" type="text"
                                                autocomplete="off"/>
                                            </div>                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="hobbies_interests">Hobbies / Interests</label> 
                                                <textarea class="form-control" id="hobbies_interests" name="hobbies_interests" maxlength="1024" rows="3"> </textarea>
                                            </div>                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="address">Permanent Address *</label> 
                                                <textarea class="form-control" id="address" name="address" maxlength="2048" rows="3" 
                                                autocomplete="off" required></textarea>
                                            </div>                                            
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label for="resumeFile">Upload Resume (.doc, .docx, .pdf) *</label> 
                                                <div class="custom-file">
                                                    <input type="file" id="resumeFile" name="resumeFile" class="custom-file-input form-control" accept=".pdf,.doc,.docx"/>
                                                    <label class="custom-file-label" id="custom-resume-file-label" for="resumeFile">Choose a file (File size should be less than 2MB)</label>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div> 
                                    <input type="hidden" id="hidden_languages_known" name="hidden_languages_known"/>
                                    <button type="submit" id="submit_btn" form="formApplyNow" class="btn btn-success pl-3 pr-3 pt-2 pb-2 btn-md float-right">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Services-->
        <!--<section class="page-section" id="services">
            <div class="container">
                <h2 class="text-center mt-0">At Your Service</h2>
                <hr class="divider my-4" />
                <div class="row">
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <i class="fas fa-4x fa-gem text-primary mb-4"></i>
                            <h3 class="h4 mb-2">Sturdy Themes</h3>
                            <p class="text-muted mb-0">Our themes are updated regularly to keep them bug free!</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <i class="fas fa-4x fa-laptop-code text-primary mb-4"></i>
                            <h3 class="h4 mb-2">Up to Date</h3>
                            <p class="text-muted mb-0">All dependencies are kept current to keep things fresh.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <i class="fas fa-4x fa-globe text-primary mb-4"></i>
                            <h3 class="h4 mb-2">Ready to Publish</h3>
                            <p class="text-muted mb-0">You can use this design as is, or you can make changes!</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <i class="fas fa-4x fa-heart text-primary mb-4"></i>
                            <h3 class="h4 mb-2">Made with Love</h3>
                            <p class="text-muted mb-0">Is it really open source if it's not made with love?</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>-->
        <!-- Portfolio-->
        <!--<div id="portfolio">
            <div class="container-fluid p-0">
                <div class="row no-gutters">
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="<?=base_url()?>assets/img/portfolio/fullsize/1.jpg">
                            <img class="img-fluid" src="<?=base_url()?>assets/img/portfolio/thumbnails/1.jpg" alt="" />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Category</div>
                                <div class="project-name">Project Name</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="<?=base_url()?>assets/img/portfolio/fullsize/2.jpg">
                            <img class="img-fluid" src="<?=base_url()?>assets/img/portfolio/thumbnails/2.jpg" alt="" />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Category</div>
                                <div class="project-name">Project Name</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="<?=base_url()?>assets/img/portfolio/fullsize/3.jpg">
                            <img class="img-fluid" src="<?=base_url()?>assets/img/portfolio/thumbnails/3.jpg" alt="" />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Category</div>
                                <div class="project-name">Project Name</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="<?=base_url()?>assets/img/portfolio/fullsize/4.jpg">
                            <img class="img-fluid" src="<?=base_url()?>assets/img/portfolio/thumbnails/4.jpg" alt="" />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Category</div>
                                <div class="project-name">Project Name</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="<?=base_url()?>assets/img/portfolio/fullsize/5.jpg">
                            <img class="img-fluid" src="<?=base_url()?>assets/img/portfolio/thumbnails/5.jpg" alt="" />
                            <div class="portfolio-box-caption">
                                <div class="project-category text-white-50">Category</div>
                                <div class="project-name">Project Name</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="<?=base_url()?>assets/img/portfolio/fullsize/6.jpg">
                            <img class="img-fluid" src="<?=base_url()?>assets/img/portfolio/thumbnails/6.jpg" alt="" />
                            <div class="portfolio-box-caption p-3">
                                <div class="project-category text-white-50">Category</div>
                                <div class="project-name">Project Name</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>-->
        <!-- Call to action-->
        <!--<section class="page-section bg-dark text-white">
            <div class="container text-center">
                <h2 class="mb-4">Free Download at Start Bootstrap!</h2>
                <a class="btn btn-light btn-xl" href="https://startbootstrap.com/theme/creative/">Download Now!</a>
            </div>
        </section>-->
        <!-- Contact-->
        <!--<section class="page-section" id="contact">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2 class="mt-0">Let's Get In Touch!</h2>
                        <hr class="divider my-4" />
                        <p class="text-muted mb-5">Ready to start your next project with us? Give us a call or send us an email and we will get back to you as soon as possible!</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 ml-auto text-center mb-5 mb-lg-0">
                        <i class="fas fa-phone fa-3x mb-3 text-muted"></i>
                        <div>+1 (555) 123-4567</div>
                    </div>
                    <div class="col-lg-4 mr-auto text-center">
                        <i class="fas fa-envelope fa-3x mb-3 text-muted"></i>
                        <!-- Make sure to change the email address in BOTH the anchor text and the link target below!
                        <a class="d-block" href="mailto:contact@yourwebsite.com">contact@yourwebsite.com</a>
                    </div>
                </div>
            </div>
        </section>-->
        <!-- Footer-->
        <footer class="bg-light py-5">
            <div class="container">
                <div class="small text-center text-muted" style="font-weight:bold">Copyright © 
                    <script>
                        document.write(new Date().getFullYear());
                    </script> 
                    - <a target="_blank" rel="nofollow" href="https://www.parrophins.com/"><span class="parro-text">Parro</span><span class="phins-text">Phins</span></a>
                    &nbsp;&nbsp; All rights reserved
                </div>
            </div>
        </footer>
        <script>
            $(document).ready(()=>{
                $('.datepicker').datepicker({
                    autoclose: true,
                    format : "dd-mm-yyyy",
                    orientation: "bottom"
                });
            });
        </script>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
        <!-- Core theme JS-->
        <script src="<?=base_url()?>assets/js/scripts.js"></script>
    </body>
</html>
