<style>
.select2-container .select2-selection--single {
    height: 38px !important;
    width: 360px !important;
}


.form-control {
    border: 1px solid #000000 !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow b {
    margin-top: 3px !important;
    color: black !important;

}

@media screen and (max-width: 480px) {
    .select2-container--default .select2-selection--single .select2-selection__arrow {

        margin-right: 20px !important;
    }

    .select2-container .select2-selection--single {
        width: 270px !important;
    }
}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
}
</style>
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
<div class="row column_padding_card">
    <div class="col-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>
<div class="main-content-container px-3 pt-1 overall_content">
    <div class="content-wrapper">
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-lg-12 col-12 col-md-12">
                                <span class="page-title">
                                    <i class="fas fa-comments"></i> Student Notifications
                                </span>
                            </div>                                                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row p-0 column_padding_card">
        <div class="col column_padding_card">
            <div class="card card-small mb-4">
                <div class="card-body p-1 pb-2 text-center table-responsive">
                    <table id="item-list" style="width:100%"
                        class="display table  table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Student Id</th>
                                <th>Term</th>
                                <th>Stream</th>
                                <th>Section</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Attachment</th>
                                <th>Sent By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>                           
                            <?php
                                if(!empty($notifications)){
                                    foreach($notifications as $notification){
                                        echo "<tr>
                                            <td>".$notification->date_time."</td>
                                            <td>".$notification->student_id."</td>
                                            <td>".$notification->term_name."</td>
                                            <td>".$notification->stream_name."</td>
                                            <td>".$notification->section_name."</td>
                                            <td>".$notification->subject."</td>
                                            <td>".$notification->message."</td>";
                                          
                                            if($notification->filepath !=""){
                                                echo "
                                                <td><a class='btn btn-md btn-primary' href='".base_url().$notification->filepath."' download><i class='fa fa-download'></i> Download</a></td>
                                             ";
                                            }else{
                                                echo "<td></td>";
                                            }
                                            
                                            echo "
                                            <td>".$notification->sent_by."</td>
                                            <td><a class='btn btn-xs btn-danger deleteStudentNotification px-2 py-1' href='#' data-row_id='".$notification->row_id."' title='Delete'><i class='fa fa-trash'></i></a></td>
                                        </tr>";
                                    }
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>Term</th>
                                <th>Stream</th>
                                <th>Section</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Attachment</th>
                                <th>Sent By</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
jQuery(document).ready(function() {

    jQuery(document).on("click", ".deleteStudentNotification", function(){
			var row_id = $(this).data("row_id"),
				hitURL = baseURL + "deleteStudentNotification",
				currentRow = $(this);

			var confirmation = confirm("Are you sure delete this Notification ?");

			if(confirmation)
			{
				jQuery.ajax({
				type : "POST",
				dataType : "json",
				url : hitURL,
				data : { row_id : row_id } 
				}).done(function(data){

					currentRow.parents('tr').remove();
					if(data.status = true) { alert("Notification successfully Deleted"); }
					else if(data.status = false) { alert("Failed to delete Notification"); }
					else { alert("Access denied..!"); }
				});
			}

		});
    // $('.datepicker, #dateSearch').datepicker({
    //     autoclose: true,
    //     orientation: "bottom",
    //     format: "dd-mm-yyyy"

    // });
    $(function() {
        $("#dateSearch, #search_datepicker").datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            orientation: "bottom",
        });
    });

    $('#item-list thead tr').clone(true).appendTo('#item-list thead');
    $('#item-list thead tr:eq(1) th').each(function(i) {
        var title = $(this).text();
        if (title == 'Date') {
            $(this).html(
                '<div class="form-group position-relative mb-0 mt-0" style="margin-top: -5px !important; margin-bottom: -5px !important;" ><input style="border: 1px solid #75787b !important;" type="text" id="dateSearch" class="form-control input-sm" placeholder="Search ' +
                title + '" /> </div>');
        } else {
            $(this).html(
                '<div class="form-group position-relative mb-0 mt-0" style="margin-top: -5px !important; margin-bottom: -5px !important;" ><input style="border: 1px solid #75787b !important;" type="text" class="form-control input-sm" placeholder="Search ' +
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


    var table = $('#item-list').DataTable({
        columnDefs: [
            // { className: "my_class", targets: "_all" },
            {
                className: "text-left",
                targets: 4,

            },
            // {
            //     className: "text-left",
            //     targets: 1,

            // }
        ],
        lengthMenu: [
            [200, 150, 100, 50, 20, 10],
            [200, 150, 100, 50, 20, 10]
        ],
        processing: true,
        orderCellsTop: true,
        fixedHeader: true,
        responsive: true,
        language: {
            "info": "Showing _START_ to _END_ of _TOTAL_ Notifications",
            "infoFiltered": "(filtered from _MAX_ total Notifications)",
            "search": "",
            searchPlaceholder: "Search Notifications",
            "lengthMenu": "Show _MENU_ Notifications",
            "infoEmpty": "Showing 0 to 0 of 0 Notifications",
            //processing: '<img src="'+baseURL+'assets/images/loader.gif" width="150"  alt="loader">'
        },

       /* "ajax": {
            url: '<?php echo base_url(); ?>/get_sms_rep',
            type: 'POST',
            data: {
                term_name: $('#term_name').val(),
                date_search: $('#search_datepicker').val(),
                mobile: $('#mobile').val(),
            }
            // dataType: 'json',
        },*/

    });

    new $.fn.dataTable.FixedHeader(table);

});
</script>