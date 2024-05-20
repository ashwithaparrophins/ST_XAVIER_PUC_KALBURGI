
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
<div class="row">
    <div class="col-md-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container container-fluid px-4">
    <div class="content-wrapper">
        <div class="row mt-1 mb-2">
            <div class="col padding_left_right_null">
                <div class="card card-small p-0 card_heading_title">
                    <div class="card-body p-2 ml-2 card-content-title">
                        <div class="row">
                            <div class="col-lg-7 col-md-8 col-9">
                                <span class="page-title">
                                    <i class="fas fa-tachometer-alt header_icons"></i> Job Portal Dashboard
                                </span>
                            </div>
                            
                       
                            <div class="col-lg-5 col-md-4 col-3 box-tools">  
                                <a href="#" onclick="window.history.back();"
                                class="btn btn-success float-right text-white pt-2" value="Back">Back </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


                            <div class="col-md-6 col-12 mb-2">
                                <div class="card mb-2">
                                    <div class="card-body p-1">
                                        <div class="table-responsive">
                                            <table class="table table-bordered mb-0">
                                                <tr class="table-success">
                                                    <th colspan="2">Quick Info of Job Portal</th>
                                                </tr>
                                                <tr class="text-center table-secondary">
                                                    <th>TYPE</th>
                                                    <th>TOTAL</th>
                                                </tr>
                                                <tr>
                                                    <th>Application Stack</th>
                                                    <th class="text-center"><?php echo $AppliedCount; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Approved </th>
                                                    <th class="text-center"><?php echo $ApprovedCount; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Shortlisted</th>
                                                    <th class="text-center"><?php echo $shortlistedCount; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Rejected</th>
                                                    <th class="text-center"><?php echo $rejectedCount; ?></th>
                                                </tr>
                                               
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
        
    </div>

</div>

       

        
<script src="<?php echo base_url(); ?>assets/js/admission.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery(document).ready(function() {

    $('#item-list thead tr').clone(true).appendTo('#item-list thead');
    $('#item-list thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        if (title == 'Date') {
            var newClassupdate = 'disabled';
        } else {
            var newClassupdate = '';
        }
        $(this).html(
            '<div class="form-group position-relative mb-0 mt-0" style="margin-top: -5px !important; margin-bottom: -5px !important;" ><input style="border: 1px solid #75787b !important;" type="text" class="form-control input-sm" placeholder="Search ' +
            title + '" ' +
            newClassupdate + ' /> </div>');

            if (title == 'College Name') {
                $(this).html(`<div class="form-group position-relative mb-0 mt-0" style="margin-top: -5px !important; margin-bottom: -5px !important;" >
            <select class="form-control" placeholder="Search College" style="border: 1px solid #75787b !important;">
                 <option value="">Select College</option>
                 <option value="SJCL">SJCL</option>
                 <option value="SJCC">SJCC</option>
                 <option value="SJIM">SJIM</option> 
            </select>
            </div>`);
        }

        $('input', this).on('keyup change', function() {
            if (table.column(i).search() !== this.value) {
                table
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });

        $('select', this).on('keyup change', function() {
            if (table.column(i).search() !== this.value) {
                table
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });


    var table = $('#item-list').DataTable({
        columnDefs: [
            // { className: "my_class", targets: "_all" },
            {
                className: "text-center",
                targets: [0,4],
            },{
                className: "text-left",
                targets: 1,
            },{
                className: "text-left",
                targets: 4,
            }
        ],
        "ordering": false,
        lengthMenu: [[200, 150, 100, 50, 20, 10], [200, 150, 100, 50, 20, 10]],
        processing: true,
        orderCellsTop: true,
        fixedHeader: true,
        language: {
            "info": "Showing _START_ to _END_ of _TOTAL_ Students",
            "infoFiltered": "(filtered from _MAX_ total Students)",
            "search": "",
            searchPlaceholder: "Search Student",
            "lengthMenu": "Show _MENU_ Students",
            "infoEmpty": "Showing 0 to 0 of 0 Students",
            //processing: '<img src="'+baseURL+'assets/images/loader.gif" width="150"  alt="loader">'
        },

        "ajax": {
            url: '<?php echo base_url(); ?>/get_appliedStudents ',
            type: 'POST',
           
            // dataType: 'json',
            type: 'POST',
            data: {
                admission_year: $('#admission_year').val(),
            }
        },

    });

    jQuery(document).on("click", ".approveAdmission", function(){
		var row_id = $(this).data("row_id");
		// 	hitURL = baseURL + "approveStudentAdmission",
		// 	currentRow = $(this);
		
        $('#student_row_id').val(row_id);
        var confirmation = confirm("Are you sure to Approve this Application ?");
		if(confirmation)
		{
        $('#assignRoom').modal('show');
        }

		// var confirmation = confirm("Are you sure to Approve this Student ?");
		// if(confirmation)
		// {
		// 	jQuery.ajax({
		// 	type : "POST",
		// 	dataType : "json",
		// 	url : hitURL,
		// 	data : { row_id : row_id } 
		// 	}).done(function(data){
		// 		if(data.status = true) { alert("Student successfully approved"); 
		// 		window.location.reload();}
		// 		else if(data.status = false) { alert("Student approve failed"); }
		// 		else { alert("Access denied..!"); }
		// 	});
		// }
	});

    jQuery(document).on("click", "#assignButton", function() {

        var room_row_id = $(this).data("room_row_id");
        var student_row_id = $("#student_row_id").val();

        hitURL = baseURL + "addStudentRoomInfo2024",
            currentRow = $(this);

        $('#confirmationRoomModal').modal('show');

        // if(AssignRoomUpdate)
        // {
        $('#AssignRoomUpdate').click(function() {
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: hitURL,
                data: {
                    room_row_id: room_row_id,
                    student_row_id : student_row_id
                }
            }).done(function(data) {
                if (data.status == true) {
                    showSuccessModal("Room Assigned Successfully.");
                } else if (data.status == false) {
                    showErrorModal("Room Already Exist");
                } else {
                    showErrorModal("Access denied..!");
                }
            });
        });
    // }

    });


    jQuery('.datepicker, .dateSearch').datepicker({
        autoclose: true,
        orientation: "bottom",
        format: "dd-mm-yyyy"

    });
    
    jQuery(document).on("click", ".btnAssign", function(){
		var row_id = $(this).data("row_id");
        // var row_id = $(this).attr('data-row_id');
        $(".modal-body #student_row_id").val( row_id );
    });

    

function showSuccessModal(message, delay) {
    $('#confirmationRoomModal').modal('hide');
    // $('#confirmationModal').modal('hide');
    // $('#confirmationModalDelete').modal('hide');

  var modalContent = `
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="successModalLabel">Success</h5>
          </div>
          <div class="modal-body">
            ${message}
          </div>
        
        </div>
      </div>
    </div>
  `;

  // Append the modal HTML to the body
  $('body').append(modalContent);

  // Show the modal
  $('#successModal').modal('show');

  // Automatically close the modal after 3 seconds
//   setTimeout(function() {
//     $('#successModal').modal('hide');
//   }, 1000);
//   location.reload();
    setTimeout(function() {
        $('#successModal').modal('hide');

        // Reload the page after hiding the modal
        setTimeout(function() {
        location.reload();
        }, 2000); // Reload after 1 second
    }, delay);
}


function showErrorModal(message) {
  var modalContent = `
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="errorModalLabel">Error</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            ${message}
          </div>
        </div>
      </div>
    </div>
  `;

  // Append the modal HTML to the body
  $('body').append(modalContent);

  // Show the modal
  $('#errorModal').modal('show');

  // Automatically close the modal after 3 seconds
  setTimeout(function() {
    $('#errorModal').modal('hide');
  }, 3000);
}

});

</script>