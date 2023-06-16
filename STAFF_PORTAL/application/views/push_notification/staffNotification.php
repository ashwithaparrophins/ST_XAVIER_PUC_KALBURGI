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
?>
<div class="row column_padding_card">
    <div class="col-12">
        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
    </div>
</div>

<div class="main-content-container px-3 pt-1 overall_content">
    <div class="content-wrapper mb-0">
        <div class="row p-0 column_padding_card">
            <div class="col column_padding_card">
                <div class="card card-small card_heading_title p-0 m-b-1">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-7">
                                <span class="page-title">
                                    <i class="fas fa-bell"></i> Staff Notifications
                                </span>
                            </div>   
                            <div class="col-5">
                            <a onclick="showLoader();window.history.back();" class="btn primary_color mobile-btn float-right border_left_radius text-white"
                                    value="Back"><i class="fa fa-arrow-circle-left"></i> Back </a> 
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
                    <form action="<?=base_url() ?>staffNotifications" method="POST"
                        id="byFilterMethod">
                        <!-- <input class="form-control datepicker" type="text" name="date" 
                        value="<?php 
                            if(!empty($date)) echo date('d-m-Y', strtotime($date));
                        ?>"
                         style="text-transform: uppercase" placeholder="By Date" autocomplete="off"> -->
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
                                                <span class="title"><?=$notification->subject;?></span>                   
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
                                                    if(!empty($notification->date_time)) echo date('d-m-Y H:i', strtotime($notification->date_time));
                                                ?></span>
                                                <?php 
                                                    if(!empty($notification->filepath)){?>
                                                        <span class="attachment">
                                                            <a class="badge badge-success" target="_blank" href="<?= base_url().$notification->filepath ?>" onclick="">View Attachment</a>
                                                        </span>
                                                    <?php }

                                                ?>
                                            </div>
                                          
                                            <?php if($role == ROLE_ADMIN || $role == ROLE_PRINCIPAL || $role == ROLE_PRIMARY_ADMINISTRATOR ){ ?>
                                                    <div class="action-buttons mt-1">
                                                        <!-- <a href="#" class="badge badge-info editNotificationBtn" 
                                                            data-table_id="
                                                                <?php
                                                                        if( !empty($notification->tbl_staff_notifications)) echo 'tbl_staff_notifications';
                                                                        else if( !empty($notification->tbl_staff_bulk_notification)) echo 'tbl_staff_bulk_notification';
                                                                        else echo '';
                                                                    ?>
                                                            "data-row_id="<?=$notification->row_id;?>" onclick="">
                                                            <span class="pr-1"><i class="fas fa-pencil-alt"></i></span>Edit
                                                        </a>                                                 -->
                                                        <a href="#" class="badge badge-danger deleteNotificationBtn" 
                                                            data-table_id="
                                                                <?php
                                                                        if( !empty($notification->tbl_staff_notifications)) echo 'tbl_staff_notifications';
                                                                        else echo '';
                                                                    ?>
                                                            "
                                                            data-row_id="<?=$notification->row_id;?>">
                                                            <span class="pr-1"><i class="fas fa-trash-alt"></i></span>Delete
                                                        </a>
                                                    </div>
                                                <?php }
                                            ?>     
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

    <!-- Edit Notification Modal -->
    <div class="modal" id="editNotificationModal">
        <div class="modal-dialog modal-lg mx-auto">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h6 class="modal-title">Edit Notification</h6>
                    <button type="button" class="close"  data-dismiss="modal">&times;</button>
                </div>
                    <!-- Modal body -->
                <?php echo form_open_multipart('editStaffNotification',array('id' => 'editNotificationForm'));?>
                   <div class="modal-body p-2">                      
                        <div class="row">
                            <div class="form-group col-lg-6 col-12">
                                <label">Date</label>
                                <input type="text" class="form-control datepicker" 
                                    name="modal_input_date" id="modal_input_date" 
                                    placeholder="Notification Date" autocomplete="off">
                            </div>
                            <div class="form-group col-lg-6 col-12 for-bulk-notification">
                                <label">Staff ID</label>
                                <input type="text" class="form-control" 
                                    name="modal_input_staff_id" id="modal_input_staff_id" 
                                    placeholder="Staff ID" autocomplete="off" readonly>
                            </div>
                            <div class="form-group col-lg-6 col-12 for-staff-notification">
                                <label>Select Department</label>
                                <select class="form-control" 
                                    name="modal_input_department" id="modal_input_department">   
                                    <option value="ALL">ALL</option>        
                                    <?php 
                                        if(!empty($departments)){
                                            foreach($departments as $dept){
                                                echo "<option value='".$dept->dept_id."'>".$dept->name."</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-12 for-staff-notification">
                                <label>Subject</label>
                                <input class="form-control" 
                                    name="modal_input_msg_subject" id="modal_input_msg_subject" 
                                    autocomplete="off" placeholder="Write subject here"> 
                            </div>
                            <div class="form-group col-lg-6 col-12">
                                <label>Upload a File <span style="color: red;" id="modal_input_msg_file_label"></span></label>
                                <input class="form-control" type="file" 
                                    accept=".pdf,.doc,.docx,.png,.jpg,.jpeg" 
                                    name="modal_input_msg_file" id="modal_input_msg_file"> 
                            </div>
                            <div class="form-group col-12">  
                                <label>Message</label>                                                           
                                <textarea class="form-control" rows="6" 
                                    placeholder="Write messages here..." 
                                    id="modal_input_message" name="modal_input_message"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="modal_input_table_id" name="modal_input_table_id"/>
                    <input type="hidden" id="modal_input_row_id" name="modal_input_row_id" />
                </form>
                <!-- Modal footer -->
                <div class="modal-footer" style="padding:5px;">
                    <div class="row">
                        <div class="col-lg-12 col-12"> 
                            <button type="button" class="btn btn-danger"  data-dismiss="modal" >Close</button>
                            <button type="button" id="editNotificationSubmitBtn" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Edit Notification Modal -->
</div>

<script type="text/javascript">
    $(function() {
        $(".datepicker").datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            orientation: "bottom",
        });
    });
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
    $(document).ready(()=>{
        checkForReply("<?=$this->session->flashdata('success');?>","<?=$this->session->flashdata('error');?>");
        $(".main-flex-container").hide();
        localStorage.setItem("NSEGID",1);
        $(".notificationSegment_1").show();
    });
    const formatDate = date =>{
        let d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2) 
            month = '0' + month;
        if (day.length < 2) 
            day = '0' + day;

        return [day, month ,year].join('-');
    }
    $('.deleteNotificationBtn').click(function(){
        const tableID = $(this).data('table_id').trim();
        const rowID = $(this).data('row_id');
        showConfirmationAlert()
        .then(confirmed=>{
            if(confirmed){
                showLoader();
                $.post('<?=base_url()?>deleteStaffNotification', {tableID, rowID})
                .done(result=>{
                    hideLoader();
                    if(result === '1') showSuccessAlert('Notification deleted successfully');
                    else showErrorAlert();
                    location.reload();
                })
                .catch(err=>{
                    showErrorAlert();   
                    hideLoader();                 
                    console.log("Error:", err);
                });
            }
        });
    });
    $('.editNotificationBtn').on('click',function(){
        const tableID = $(this).data('table_id').trim();
        const rowID = $(this).data('row_id');
        showLoader();
        $.post('<?=base_url()?>editStaffNotificationView', {tableID, rowID})
        .done(result=>{
            hideLoader();
            if(result === '0') showErrorAlert();
            else{
                try{
                    const notifs = JSON.parse(result);
                    $("#modal_input_table_id").val(tableID);
                    $("#modal_input_row_id").val(rowID);
                    if(tableID === 'tbl_staff_notifications'){
                        let notif_date = Date.parse(notifs.date_time);
                        notif_date = formatDate(notif_date);
                        $("#modal_input_date").val(notif_date);
                        $("#modal_input_department").val(notifs.department);
                        $("#modal_input_msg_subject").val(notifs.subject);
                        $("#modal_input_message").val(notifs.message);
                        let msg_file = notifs.filepath || '';
                        $("#modal_input_msg_file_label").html('');
                        if(msg_file != ''){
                            msg_file = msg_file.split('/');
                            $("#modal_input_msg_file_label").html('('+ msg_file.slice(-1)[0] +')');
                        }
                        $(".for-staff-notification").show();
                        $(".for-bulk-notification").hide();
                        $("#editNotificationModal").modal('show');
                    }else if(tableID === 'tbl_staff_bulk_notification'){
                        let notif_date = Date.parse(notifs.active_date);
                        notif_date = formatDate(notif_date);
                        $("#modal_input_date").val(notif_date);
                        $("#modal_input_staff_id").val(notifs.staffId);
                        $("#modal_input_message").val(notifs.message);
                        let msg_file = notifs.filepath || '';
                        $("#modal_input_msg_file_label").html('');
                        if(msg_file != ''){
                            msg_file = msg_file.split('/');
                            $("#modal_input_msg_file_label").html('('+ msg_file.slice(-1)[0] +')');
                        }
                        $(".for-bulk-notification").show();
                        $(".for-staff-notification").hide();
                        $("#editNotificationModal").modal('show');
                    }else{
                        $("#modal_input_table_id").val('');
                        $("#modal_input_row_id").val('');
                        showErrorAlert();
                    }
                }catch(er){
                    showErrorAlert();
                    console.log('Error:', er);
                }
            }
        }).catch(err=>{
            hideLoader();
            showErrorAlert(); 
            console.log('Error:', err);
        });
    });
    $('#editNotificationSubmitBtn').click(()=>{
        const tableID = $("#modal_input_table_id").val().trim();
        if($("#modal_input_date").val() == ""){
            $("#editNotificationModal").modal('hide');
            showWarningAlert('Date is required.');
        }else if($("#modal_input_message").val().trim() == ""){
            $("#editNotificationModal").modal('hide');
            showWarningAlert('Message is required.');
        }else{
            if(tableID === "tbl_staff_notifications"){
                if($("#modal_input_department").val() == ""){
                    $("#editNotificationModal").modal('hide');
                    showWarningAlert('Department is required.');
                }else if($("#modal_input_msg_subject").val().trim() == ""){
                    $("#editNotificationModal").modal('hide');
                    showWarningAlert('Subject is required.');
                }else{
                    showLoader();
                    $("#editNotificationForm").submit();
                }
            }else if(tableID === "tbl_staff_bulk_notification"){
                if($("#modal_input_staff_id").val().trim() == ""){
                    $("#editNotificationModal").modal('hide');
                    showWarningAlert('Staff ID is required.');
                }else{
                    showLoader();
                    $("#editNotificationForm").submit();
                }
            }else{
                $("#editNotificationModal").modal('hide');
                showErrorAlert();
            }    
        }
    });
</script>