<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

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
<?php
  $warning = $this->session->flashdata('warning');
  if ($warning) { 
  ?>
<div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
  <i class="fa fa-check mx-2"></i>
  <strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
</div>
<?php }?>
<div class="row column_padding_card">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container  px-3">

    <div class="row mt-1 mb-2">
      <div class="col column_padding_card">
        <div class="card card_heading_title card-small p-0">
          <div class="card-body p-2 ml-2">
            <div class="row c-m-b">
              <div class="col-lg-9 col-sm-9 col-9">
                <span class="page-title absent_table_title_mobile">
                  <i class="material-icons">settings</i>Admin Settings
                </span>
              </div>
              <div class="col-lg-3 col-sm-3 col-3 box-tools">
                <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn float-right text-white pt-2"
                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



    <div class="row ">
      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#caste">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Caste Info</h6>
        </div>
        <div id="caste" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="addCast" action="<?php echo base_url() ?>addCaste" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-8">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control" id="caste" name="caste" placeholder="Enter Caste" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                      <tr class="table_row_background">
                        <th>Caste</th>
                        <th>Action</th>
                      </tr>
                      <?php if(!empty($casteInfo)){
                        foreach($casteInfo as $caste){ ?>
                      <tr class="text-dark">
                        <td><?php echo $caste->name; ?></td>
                        <td>
                          <a class="btn btn-xs btn-danger deleteCaste" href="#" data-row_id="<?php echo $caste->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                      <?php } }else{ ?>
                        <td colspan="2" style="background-color: #e3cfff;">Caste Not Found</td>
                      <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div> <!-- Card End -->
        </div> <!--collapse End -->
      </div>
      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#religion">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Religion Info</h6>
        </div>
        <div id="religion" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="addReligion" action="<?php echo base_url() ?>addReligion" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-8">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control" id="religion" name="religion" placeholder="Enter Religion" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                      <tr class="table_row_background">
                        <th>Religion</th>
                        <th>Action</th>
                      </tr>
                      <?php if(!empty($religionInfo)){
                        foreach($religionInfo as $record){ ?>
                      <tr class="text-dark">
                        <td><?php echo $record->name; ?></td>
                        <td>
                          <a class="btn btn-xs btn-danger deleteReligion" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                      <?php } }else{ ?>
                        <td colspan="2" style="background-color: #e3cfff;">Religion Not Found</td>
                      <?php } ?>
                    </thead>
                  </table>
                </div>   
              </div>
            </div>
          </div>
        </div>
        <!-- End Quick Post -->
      </div>
      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#nationality">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Nationality Info</h6>
        </div>
        <div id="nationality" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
                <?php $this->load->helper("form"); ?>
                <form role="form" id="addNationality" action="<?php echo base_url() ?>addNationality" method="post" role="form">
                    <div class="row form-contents">
                        <div class="col-8">
                            <div class="form-group mb-0">
                                <input type="text" class="form-control" id="nationality" name="nationality" placeholder="Enter Nationality" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-4 mb-1">
                            <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                        </div>
                    </div>
                </form>
                <div class="row mx-0">
                  <div class="col-lg-12 col-12 p-0 mt-0 ">
                    <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Nationality</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($nationalityInfo)){
                            foreach($nationalityInfo as $record){ ?>
                        <tr class="text-dark">
                            <td><?php echo $record->name; ?></td>
                            <td>
                                <a class="btn btn-xs btn-danger deleteNationality" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php } }else{ ?>
                          <td colspan="2" style="background-color: #e3cfff;">Nationality Not Found</td>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#department">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Department Info</h6>
        </div>
        <div id="department" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" action="<?php echo base_url() ?>addDepartment" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-4 col-lg-3 pr-1">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control" id="dept_id" name="dept_id"
                      placeholder="Dept. ID" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 col-lg-5 pl-1 pr-1">
                    <div class="form-group mb-0">
                        <input type="text" class="form-control" id="dept_name" name="dept_name" placeholder="Department Name" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 mb-1 col-lg-4 pl-1">
                      <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                      <tr class="table_row_background">
                        <th>Dept. ID</th>
                        <th>Dept. Name</th>
                        <th>Action</th>
                      </tr>
                      <?php if(!empty($departmentInfo)){
                          foreach($departmentInfo as $dept){ ?>
                      <tr class="text-dark">
                        <td><?php echo $dept->dept_id; ?></td>
                        <td><?php echo $dept->name; ?></td>
                        <td>
                          <a class="btn btn-xs btn-danger deleteDepartment" href="#" data-row_id="<?php echo $dept->id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                      <?php } }else{ ?>
                        <td colspan="3" style="background-color: #e3cfff;">Department Not Found</td>
                      <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Top Notification Section -->
      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#category">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Category Info</h6>
        </div>
        <div id="category" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="addCategory" action="<?php echo base_url() ?>addCategory" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-8">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control" id="category" name="category" placeholder="Enter Category" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($categoryInfo)){
                            foreach($categoryInfo as $record){ ?>
                        <tr class="text-dark">
                          <td><?php echo $record->category_name; ?></td>
                          <td>
                            <a class="btn btn-xs btn-danger deleteCategory" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        <?php } }else{ ?>
                          <tr class="text-dark">
                            <td colspan="2" style="background-color: #e3cfff;">Category Not Found</td>
                          </tr>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#classTimings">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Class Timings Info</h6>
        </div>
        <div id="classTimings" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="addClassTimings" action="<?php echo base_url() ?>addClassTimings" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-6 pr-1">
                    <div class="form-group mb-2">
                      <select name="week_id" id="week_id" class="form-control" data-live-search="true" autocomplete="off" required>
                        <option value="">Select Week Name</option>
                        <?php if(!empty($weekName)){
                          foreach($weekName as $record){ ?>
                            <option value="<?php echo $record->row_id ?>">
                              <?php echo $record->week_name ?> 
                            </option>
                        <?php }  } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-6 pr-1 mb-2">
                    <div class="input-group mb-0">
                      <select required id="start_time_hh" name="start_time_hh" class="form-control" >
                        <?php if(!empty($leaveInfo->departureTime)){ ?>
                            <option value="<?php echo date('h',strtotime($leaveInfo->departureTime)); ?>"><?php echo date('h',strtotime($leaveInfo->departureTime)); ?></option>
                        <?php } ?>
                        <option value="">Select Hour</option>
                        <?php for($i=1; $i<13; $i++){ ?>
                          <option value="<?php echo sprintf('%02d',$i); ?>"><?php echo sprintf('%02d',$i); ?></option>
                        <?php } ?>
                      </select>
                      <select required id="start_time_mm" name="start_time_mm" class="form-control" >
                        <?php if(!empty($leaveInfo->departureTime)){ ?>
                            <option value="<?php echo date('i',strtotime($leaveInfo->departureTime)); ?>"><?php echo date('i',strtotime($leaveInfo->departureTime)); ?></option>
                        <?php } ?>
                        <option value="">Select Minute</option>
                        <?php for($i=0; $i<60; $i++){ ?>
                        <option value="<?php echo sprintf('%02d',$i); ?>"><?php echo sprintf('%02d',$i); ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-6 pr-2">
                    <div class="input-group">
                      <select required id="end_time_hh" name="end_time_hh" class="form-control">
                        <?php if(!empty($leaveInfo->arrivalTime)){ ?>
                            <option value="<?php echo date('h',strtotime($leaveInfo->arrivalTime)); ?>"><?php echo date('h',strtotime($leaveInfo->arrivalTime)); ?></option>
                        <?php } ?>
                        <option value="">Select Hour</option>
                        <?php for($i=1; $i<13; $i++){ ?>
                        <option value="<?php echo sprintf('%02d',$i); ?>"><?php echo sprintf('%02d',$i); ?></option>
                        <?php } ?>
                      </select>
                      <select required id="end_time_mm" name="end_time_mm" class="form-control" >
                        <?php if(!empty($leaveInfo->arrivalTime)){ ?>
                            <option value="<?php echo date('i',strtotime($leaveInfo->arrivalTime)); ?>"><?php echo date('i',strtotime($leaveInfo->arrivalTime)); ?></option>
                        <?php } ?>
                        <option value="">Select Minute</option>
                        <?php for($i=0; $i<60; $i++){ ?>
                        <option value="<?php echo sprintf('%02d',$i); ?>"><?php echo sprintf('%02d',$i); ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-6 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Week Name</th>
                            <th>Class Start</th>
                            <th>Class End</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($classTimingsInfo)){
                            foreach($classTimingsInfo as $record){ ?>
                        <tr class="text-dark">
                          <td><?php echo $record->week_name; ?></td>
                          <td><?php echo $record->start_time; ?></td>
                          <td><?php echo $record->end_time; ?></td>
                          <td>
                            <a class="btn btn-xs btn-danger deleteClassTimings" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        <?php } }else{ ?>
                          <tr class="text-dark">
                            <td colspan="4" style="background-color: #e3cfff;">Class Timings Not Found</td>
                          </tr>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#timetableDayShifting">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Time table day shifting</h6>
        </div>
        <div id="timetableDayShifting" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="addClassTimings" action="<?php echo base_url() ?>addTimetableDayShifting" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-4 pr-1">
                    <div class="form-group mb-2">
                      <select name="week_id" id="week_id" class="form-control" data-live-search="true" autocomplete="off" required>
                        <option value="">Select Week Name</option>
                        <?php if(!empty($weekName)){
                          foreach($weekName as $record){ ?>
                            <option value="<?php echo $record->row_id ?>">
                              <?php echo $record->week_name ?> 
                            </option>
                        <?php }  } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-4 pr-1 mb-2">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control" id="datepicker" name="date" placeholder="Date" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Week Name</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($timetableShiftInfo)){
                            foreach($timetableShiftInfo as $record){ ?>
                        <tr class="text-dark">
                          <td><?php echo $record->week_name; ?></td>
                          <td><?php echo date('d-m-Y',strtotime($record->date)); ?></td>
                          <td>
                            <a class="btn btn-xs btn-danger deleteDayShifting" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        <?php } }else{ ?>
                          <tr class="text-dark">
                            <td colspan="4" style="background-color: #e3cfff;">Record Not Found</td>
                          </tr>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
    
      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#feeName">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Fee Name</h6>
        </div>
        <div id="feeName" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="addCategory" action="<?php echo base_url() ?>addFeesName" method="post">
                <div class="row form-contents">
                  <div class="col-8">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control text-capitalize" id="fee_name" name="fee_name" 
                      placeholder="Enter Fee Name" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($feeNameInfo)){
                            foreach($feeNameInfo as $record){ ?>
                        <tr class="text-dark">
                          <td><?php echo $record->fee_name; ?></td>
                          <td>
                            <a class="btn btn-xs btn-danger deleteFeeName" href="#" data-row_id="<?php echo $record->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        <?php } }else{ ?>
                          <tr class="text-dark">
                            <td colspan="2" style="background-color: #e3cfff;">Fee Name Not Found</td>
                          </tr>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      

      <!-- <div class="col-lg-6 col-md-6 col-12 mb-2 padding_left_right_null">
            <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse"
                data-target="#addRemarkName">
                <a class="float-right mb-0 setting_pointer">Click here </a>
                <h6 class="m-0 text-dark">Remarks Type Info</h6>
            </div>
            <div id="addRemarkName" class="collapse">
                <div class="card card-small h-100">
                    <div class="card-body d-flex flex-column p-1">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addRemarkName" action="<?php echo base_url() ?>addRemarkName"
                            method="post">
                            <div class="row form-contents">
                                <div class="col-8">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" id="remark_name" name="remark_name"
                                            placeholder="Enter Remark Name" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-4 mb-1">
                                    <input type="submit" class="btn btn-block btn-success float-right" value="Save" />
                                </div>
                            </div>
                        </form>
                        <div class="col-lg-12 col-12 p-0 mt-0 ">
                            <table class="table table-bordered text-dark mb-0">
                                <thead class="text-center">
                                    <tr class="table_row_background">
                                        <th>Remarks Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php if(!empty($remarkNameInfo)){
                                        foreach($remarkNameInfo as $remark){ ?>
                                    <tr class="text-dark">
                                        <td><?php echo $remark->remark_name; ?></td>
                                        <td>
                                            <a class="btn btn-xs btn-danger deleteRemarkName" href="#"
                                                data-row_id="<?php echo $remark->row_id; ?>" title="Delete"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    <?php } }else{ ?>
                                    <tr class="text-dark card_head_dashboard">
                                        <td colspan="2">Remarks Info Not Found!</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div> -->
                <!-- End Quick Post -->
        <!-- </div> -->

      

      <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#feeType">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Fee Type Info</h6>
        </div>
        <div id="feeType" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="addPost" action="<?php echo base_url() ?>addFeeType" method="post" role="form">
                <div class="row form-contents">
                  <div class="col-8">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control text-capitalize" id="feeType" name="feeType" placeholder="Enter Fee Type" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="col-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($feeTypeInfo)){
                            foreach($feeTypeInfo as $fee){ ?>
                        <tr class="text-dark">
                          <td><?php echo $fee->feeType; ?></td>
                          <td>
                            <a class="btn btn-xs btn-danger deleteFeeType" href="#" data-row_id="<?php echo $fee->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        <?php } }else{ ?>
                          <tr class="text-dark">
                            <td colspan="2" style="background-color: #e3cfff;">Fee Info Not Found</td>
                          </tr>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-12 mb-2 padding_left_right_null">
            <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse"
                data-target="#addTransportName">
                <a class="float-right mb-0 setting_pointer">Click here </a>
                <h6 class="m-0 text-dark">Transport Info</h6>
            </div>
            <div id="addTransportName" class="collapse">
                <div class="card card-small h-100">
                    <div class="card-body d-flex flex-column p-1">
                        <?php $this->load->helper("form"); ?>
                        <form role="form" id="addTransportName" action="<?php echo base_url() ?>addTransportName"
                            method="post">
                            <div class="row form-contents">
                                <div class="col-4 pr-1">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" id="addTransportName" name="name"
                                            placeholder="Enter Name" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-2 pr-1 pl-1">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" id="rate" name="rate"
                                            placeholder="Enter rate"  onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-2 pr-1 pl-1">
                                    <div class="form-group mb-0">
                                        <input type="text" class="form-control" id="bus_number" name="bus_no"
                                            placeholder="Enter No."  onkeypress="return isNumberKey(event)" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="col-4 mb-1">
                                    <input type="submit" class="btn btn-block btn-success float-right" value="Save" />
                                </div>
                            </div>
                        </form>
                        <div class="col-lg-12 col-12 p-0 mt-0 ">
                            <table class="table table-bordered text-dark mb-0">
                                <thead class="text-center">
                                    <tr class="table_row_background">
                                        <th>Name</th>
                                        <th>Rate</th>
                                        <th>Bus No.</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php if(!empty($settingInfo)){
                                        foreach($settingInfo as $record){ ?>
                                    <tr class="text-dark">
                                        <td><?php echo $record->name; ?></td>
                                        <td><?php echo $record->rate; ?></td>
                                        <td><?php echo $record->bus_no; ?></td>
                                        <td>
                                          <a class="btn btn-xs btn-secondary" onclick="openModel(<?php echo $record->row_id; ?>,/<?php echo $record->name; ?>/,<?php echo $record->rate; ?>,<?php echo $record->bus_no; ?>)" title="Edit" href='#'><i class="fas fa-edit"></i></a> 
                                        </td>
                                    </tr>
                                    <?php } }else{ ?>
                                    <tr class="text-dark card_head_dashboard">
                                        <td colspan="3">Transport Record Not Found!</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
                <!-- End Quick Post -->
        </div>


        <div class="col-lg-6 col-md-6 col-12 mb-2 column_padding_card">
        <div class="card-header border-bottom card_head_dashboard settings_card" data-toggle="collapse" data-target="#miscellaneousType">
          <a class="float-right mb-0 setting_pointer">Click here </a>
          <h6 class="m-0 text-dark">Miscellaneous Fee Info</h6>
        </div>
        <div id="miscellaneousType" class="collapse">
          <div class="card card-small h-100">
            <div class="card-body d-flex flex-column p-1">
              <?php $this->load->helper("form"); ?>
              <form role="form" id="addPost" action="<?php echo base_url() ?>addMiscellaneousType" method="post" role="form">
                <div class="row form-contents">
                <div class="col-8 col-lg-8 pr-1">
                    <div class="form-group mb-0">
                      <input type="text" class="form-control text-capitalize" id="miscellaneousType" name="miscellaneousType" placeholder=" Miscellaneous Type" autocomplete="off" required>
                    </div>
                </div>
                
                  <div class="col-4 mb-1">
                    <input style="float:right;" type="submit" class="btn btn-block btn-success" value="Add" />
                  </div>
                </div>
              </form>
              <div class="row mx-0">
                <div class="col-lg-12 col-12 p-0 mt-0 ">
                  <table class="table table-bordered text-dark mb-0">
                    <thead class="text-center">
                        <tr class="table_row_background">
                            <th>Type</th>
                           
                            <th>Action</th>
                        </tr>
                        <?php if(!empty($miscellaneousTypeInfo)){
                            foreach($miscellaneousTypeInfo as $fee){ ?>
                        <tr class="text-dark">
                          <td><?php echo $fee->miscellaneous_type; ?></td>
                        

                          <td>
                            <a class="btn btn-xs btn-danger deleteMiscellaneousType" href="#" data-row_id="<?php echo $fee->row_id; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                        <?php } }else{ ?>
                          <tr class="text-dark">
                            <td colspan="2" style="background-color: #83c8ea7d;">Miscellaneous Info Not Found</td>
                          </tr>
                        <?php } ?>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <?php if($role == ROLE_PRIMARY_ADMINISTRATOR || $role == ROLE_ADMIN){ ?>
      <div class="col-lg-6 col-md-6 col-12 mb-2">
        <div class="card card-small">
          <div class="card-header border-bottom card_head_dashboard">
            <h6 class="m-0 text-dark">Excels</h6>
          </div>
          <div class="card-body d-flex flex-column p-1">
          <?php $this->load->helper("form"); ?>
            <form role="form" action="<?php echo base_url() ?>addStudentMissingFields2" method="POST" role="form" enctype="multipart/form-data" >
              <div class="row">
                <div class="col-6">
                  <input type="file" class="form-control" id="excelFile" name="excelFile" >
                  <label for="fname">Select a Excel File</label>
                  <img src="<?php echo base_url(); ?>assets/dist/img/excel.png"  class="avatar  img-thumbnail" width="50"  height="10" src="#" id="uploadedImage" name="userfile" width="130" height="130" alt="avatar" >     
                </div>
                <div class="col-6">
                  <input  type="submit" class="btn btn-success btn-block" value="Submit" />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-12 mb-2">
        <div class="card card-small">
          <div class="card-header border-bottom card_head_dashboard">
            <h6 class="m-0 text-dark">Student info Update Excels</h6>
          </div>
          <div class="card-body d-flex flex-column p-1">
          <?php $this->load->helper("form"); ?>
            <form role="form" action="<?php echo base_url() ?>updateStdInfo" method="POST" role="form" enctype="multipart/form-data" >
              <div class="row">
                <div class="col-6">
                  <input type="file" class="form-control" id="excelFile" name="excelFile" >
                  <label for="fname">Select a Excel File</label>
                  <img src="<?php echo base_url(); ?>assets/dist/img/excel.png"  class="avatar  img-thumbnail" width="50"  height="10" src="#" id="uploadedImage" name="userfile" width="130" height="130" alt="avatar" >     
                </div>
                <div class="col-6">
                  <input  type="submit" class="btn btn-success btn-block" value="Submit" />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
       <div class="col-lg-6 col-md-6 col-12 mb-2">
        <div class="card card-small">
          <div class="card-header border-bottom card_head_dashboard">
            <h6 class="m-0 text-dark">Miss Excel</h6>
          </div>
          <div class="card-body d-flex flex-column p-1">
          <?php $this->load->helper("form"); ?>
            <form role="form" action="<?php echo base_url() ?>addLibData" method="POST" role="form" enctype="multipart/form-data" >
              <div class="row">
                <div class="col-6">
                  <input type="file" class="form-control" id="excelFile" name="excelFile" >
                  <label for="fname">Select a Excel File</label>
                  <img src="<?php echo base_url(); ?>assets/dist/img/excel.png"  class="avatar  img-thumbnail" width="50"  height="10" src="#" id="uploadedImage" name="userfile" width="130" height="130" alt="avatar" >     
                </div>
                <div class="col-6">
                  <input  type="submit" class="btn btn-success btn-block" value="Submit" />
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>


      <div class="col-lg-6 col-md-6 col-12 mb-2">
            <div class="card card-small h-100">
                <div class="card-header border-bottom card_head_dashboard">
                    <h6 class="m-0 text-dark">Update All Admitted Students</h6>
                </div>
                <div class="card-body d-flex flex-column p-1">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" action="<?php echo base_url() ?>addAllApprovedStudent" method="POST" role="form"
                        enctype="multipart/form-data">
                        <!-- <div class="row">
                            <div class="col-6">
                                 <select class="form-control" id="year" name="year" data-live-search="true"
                                    autocomplete="off" required>
                                    <option value="">Year</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                </select>
                               
                            </div> -->
                            <div class="col-6">
                                <input type="submit" class="btn btn-success btn-block" value="Submit" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> 

        <div class="col-lg-6 col-md-6 col-12 mb-2">
            <div class="card card-small">
                <div class="card-header border-bottom card_head_dashboard">
                    <h6 class="m-0 text-dark">Exam Marks Import</h6>
                </div>
                <div class="card-body d-flex flex-column p-1">
                    <?php $this->load->helper("form"); ?>
                        <form role="form" action="<?php echo base_url() ?>importExamInfo" method="POST" role="form" enctype="multipart/form-data" >
                        <div class="row">
                            <div class="col-6">
                                <input type="file" class="form-control" id="excelFile" name="excelFile" >
                                <label for="fname">Select a Excel File</label>
                                <img src="<?php echo base_url(); ?>assets/dist/img/excel.png"  class="avatar  img-thumbnail" width="50"  height="10" src="#" id="uploadedImage" name="userfile" width="130" height="130" alt="avatar" >     
                            </div>
                            <div class="col-6">
                                <input  type="submit" class="btn btn-success btn-block" value="Submit" />
                            </div>
                        </div>
                        </form>
                </div>
            </div>
        </div>
      <?php } ?>
          
    </div>
  </div>

  
</div>


<div class="modal" id="transportFeeEdit">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Transport Info</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body p-2">
                    <?php $this->load->helper("form"); ?>
                    <form role="form" id="editTransportFee" action="<?php echo base_url() ?>editTransportInfo" method="post" role="form">
                    <input type="hidden" name="row_id" id="row_id" value="" />
                      <div class="row form-contents">
                        <div class="col-lg-12 col-12">
                            <div class="form-group">
                            <label>Place</label>
                              <input type="text" class="form-control text-capitalize" id="place_name" name="transport_name" placeholder="Enter Name" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                          <div class="form-group">
                          <label>Rate</label>
                            <input type="text" class="form-control" id="fee_rate" name="fee_rate" placeholder="Enter Rate" autocomplete="off" required>
                          </div>
                        </div>
                        <div class="col-lg-6 col-12">
                          <div class="form-group">
                          <label>Bus No.</label>
                            <input type="text" class="form-control" id="bus_no" name="bus_number" placeholder="Enter Bus No." autocomplete="off" required>
                          </div>
                        </div>
                      </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <input type="submit" form="editTransportFee" class="btn btn-success float-right" value="Save" />
                </div>

            </div>
        </div>
    </div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>

<script>

function openModel(row_id, name, rate, bus_no) {
  
        $('#row_id').val(row_id);
        $('#fee_rate').val(rate);
        $('#bus_no').val(bus_no);
        var yourString = String(name);
        var result = yourString.substring(1, yourString.length-1);
        $('#place_name').val(result);
        $('#transportFeeEdit').modal('show');
}

jQuery(document).ready(function() {
    jQuery('#datepicker').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy",
    });
});

jQuery(document).on("click", ".deleteMiscellaneousType", function(){
		var row_id = $(this).data("row_id"),
			hitURL = baseURL + "deleteMiscellaneousType",
			currentRow = $(this);
		
		var confirmation = confirm("Are you sure to delete this Miscellaneous Type Info ?");
		
		if(confirmation)
		{
			jQuery.ajax({
			type : "POST",
			dataType : "json",
			url : hitURL,
			data : { row_id : row_id } 
			}).done(function(data){
					
				currentRow.parents('tr').remove();
				if(data.status = true) { alert("Miscellaneous Type Info successfully deleted"); 
				window.location.reload() }
				else if(data.status = false) { alert("Miscellaneous Type Info deletion failed"); }
				else { alert("Access denied..!"); }
			});
		}
	});
</script>