<?php ini_set('max_execution_time', 0); ?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .border_full{
            border: 1px solid #000;
            width: 100%;
            height: 100%;
        }

        h1,h2,h3,h4,h5,h6{
            margin: 5px !important;
        }
        .hr_tag{
            margin: 2px 0px !important;
            border: 2px solid #000 !important;
        }
        
        .border_left{
            width: 100px;
            border-left: 1px solid #000;
        }
        .border_right{
            width: 100px;
            border-right: 1px solid #000;
        }
        .box{
            border: 1px solid #000;
            padding: 6px 3px;
        }

        .table_form{
            margin-bottom: 0px !important;
        }
        .table_form td{
            padding: 3px;
            font-size: 13px !important;
        }
        .table_form th{
            padding: 3px;
            font-size: 13px !important;
            font-weight: 100;
        }
        .text_center{
            text-align: center;
        }
    

        .container{
            color: black !important;
        }

    </style>
    <style>
        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<?php 


    
    require APPPATH . 'views/includes/db.php'; 
    
    ini_set("pcre.backtrack_limit", "100000000");
    ini_set('memory_limit', '750M')
?>

<body>

<div>

</div>
<div class="container">
 
    
    <?php
    setcookie('isDownloading', 0);
    $totalStaffCount = count($department_list);
    $totalStaffCount1 = count($department_list);
    $page = 0;
    foreach($department_list as $dept){
    ?>
        <table class="border_full w-100 px-0 mx-0 text-center">
            <tr>
                <th class="text-center" style="font-size: 24px;" colspan="2"><?php echo TITLE; ?></th>
            </tr>
            <tr>
                <th class="text-center" style="font-size: 20px;" colspan="2"><?php echo $dept->name; ?> MONTHLY ATTENDANCE INFORMATION 2024-25</th>
            </tr>
            <tr style="font-size: 10px;">
                <td class="text-left">Date From: <?php echo $date_from; ?>  Date To: <?php echo $date_to ?></td>
                <td class="text-right">Report Type: <?php echo $report_type ?></td>
            </tr>
        </table>
        <table class="border_right border_left w-100 px-0 mx-0" style="font-size: 24px;">
            <tr>
                <th width="200" style="text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b>NOP</b></th>
                <th width="200" style="text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b>NO OUT PUNCH</b></th>
                <th width="200" style="text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b>HH</b></th>
                <th width="200" style="text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b>HOLIDAY</b></th>
                <th width="200" style="text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b>WD</b></th>
                <th width="200" style="text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b>WORKING DAYS</b></th>
               <!-- <th width="200" style="text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b>LOP</b></th>
                <th width="200" style="text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b>LOSS OF PAY</b></th>
                <th width="200" style="text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b>CL</b></th>
                <th width="200" style="text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b>CASUAL LEAVE</b></th> -->
                <th width="200" style="text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b></b></th>
                <th width="200" style="text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b></b></th>
                <th width="200" style="text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b></b></th>
                <th width="200" style="text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"><b></b></th>

                
            </tr>
        <!-- </table> -->
    <!-- <table class="w-100"> -->
    <?php
      $start_date = strtotime(date('Y-m-d',strtotime($date_from))); 
      $end_date = strtotime(date('Y-m-d',strtotime($date_to))); 
    foreach($staffInfo[$dept->dept_id] as $staff){
        $col_count = 1;
        $totalLateMinutes = 0;
        
        $totalStaffCount--;

        $lateCount = 0;

        $date_format_db = "Y-m-d";
        $holiday_dates = array();
        $holiday_reason = array();
        $holiday = $holiday_model->getHolidayInfoByRole($staff->roleId);
        if(!empty($holiday)){
        
            foreach($holiday as $h){
                if($h->holiday_date_to == $h->holiday_date){
                    $holiday_dates[$h->holiday_date_to] = $h->holiday_date;
                    $holiday_reason[$h->holiday_date_to] = $h->reason;
                } else {
                    $h_date_from = new DateTime($h->holiday_date);
                    $h_date_to = new DateTime($h->holiday_date_to);
                    $dateRangeHoliday = new DatePeriod($h_date_from, $interval, $h_date_to);
                    foreach ($dateRangeHoliday as $hDate) {
                        $h_date = $hDate->format($date_format_db);
                        $holiday_dates[$h_date] = $h_date;
                        $holiday_reason[$h_date] = $h->reason;
                    }
                    $holiday_dates[$h->holiday_date_to] = $h->holiday_date_to;
                    $holiday_reason[$h->holiday_date_to] = $h->reason;
                }
            }
        }
        // $leave_type = array();
        // $leave_dates = array();
        
        // $start_date_leave = date('Y-m-d',strtotime($date_from));
        // $end_date_leave = date('Y-m-d',strtotime($date_to));
        // $leaveInfo = getAllLeaveTakenInfoByStaff($con,$staff->staff_id,$start_date_leave,$end_date_leave);
        // if(!empty($leaveInfo)){
        //     foreach($leaveInfo as $l){
        //         if($l['date_from'] == $l['date_to']){
        //             $leave_dates[$l['date_from']] = $l['date_from'];
        //             $leave_type[$l['date_from']] = $l['leave_type'];
        //         }else{
        //             $l_date_from = new DateTime($l['date_from']);
        //             $l_date_to = new DateTime($l['date_to']);
        //             $dateRangeLeave = new DatePeriod($l_date_from, $interval, $l_date_to);
        //             foreach($dateRangeLeave as $lDate) {
        //                 $l_date = $lDate->format($date_format_db);
        //                 $leave_dates[$l_date] = $l_date;
        //                 $leave_type[$lDate->format($l_date)] = $l['leave_type'];
        //             }
        //             $leave_type[$l['date_to']] = $l['leave_type'];
        //             $leave_dates[$l['date_to']] = $l['date_to'];
        //         }
        //     }
        // }

    ?>
        <tr style="font-size: 24px;">

            <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;">Staff ID</th>
            <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;"><?php echo $staff->staff_id; ?></th>
            <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;">Name</th>
            <th style="border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;"><?php echo $staff->name; ?></th>
            <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;">Department</th>
            <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;"><?php echo $staff->department; ?></th>
            <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;">Role</th>
            <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;"><?php echo $staff->role; ?></th>
            <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;"></th>
            <th style="border-bottom: 1px solid black;border-top: 1px solid black;border-top: 1px solid black;"></th>
        
        </tr>
        <tr>
            <td style="border-bottom: 1px solid black;border-right: 1px solid black;"></td>
        <?php 

            $days_v = 1;
            $nop = 0;
            $holiday_count = 0; 
            $absent_count = 0; 
            $casual_leave = 0;
            $pay_leave = 0;
            $week_off = 0;
            $working_day = 0;
            // $col_count = 1; 

          
        ?>
        
        
        <?php 
            for ($currentDate = $start_date; $currentDate <= $end_date; $currentDate += (86400)) {
             
                $date_attendance = date('Y-m-d', $currentDate);
                $weekName = date('l', strtotime($date_attendance));
              
              
                $attInfo = getSingleStaffAttendanceInfo($con,$staff->staff_id,$date_attendance);
                // if(!empty($attInfo)){    
                    // $in_time_punch = date("H:i",strtotime($attInfo['in_time'].'+7 hour'));
                    // $out_time_punch = date("H:i",strtotime($attInfo['out_time'].'+7 hour'));
                    $in_time_punch = $attInfo['in_time'];
                    $out_time_punch = $attInfo['out_time'];
                    $print_v = $in_time_punch.'-'.$out_time_punch;
                    
                    $check_in_rule = new DateTime(date("H:i",strtotime($attInfo['punch_time'])));
                    // $in_time_rule = new DateTime($attInfo['start_time']);

                    $staff_data = $staff_model->getAllStaffAttendanceFromModel($staff->staff_id,$date_attendance);
                    $check_in_compare = new DateTime(date("h:i:s",strtotime($staff_data->in_time)));
                    $check_in_compare_test = new DateTime(date("H:i:s",strtotime($staff_data->in_time)));

                    if($staff->department == 'ADMIN STAFF' || $staff->department == 'TEACHING STAFF' || $staff->department == 'Physical Trainer' || $staff->department == 'LIBRARY' || $staff->department == 'HEALTH' || $staff->department == 'MANAGEMENT' || $staff->role == 'Office' || $staff->department == 'OFFICE STAFF'){
                        $desired_in_time = "8:30:00"; 
                    }else if($staff->department == 'SUPPORT STAFF'){
                        $desired_in_time = "8:15:00";  
                    }

                    $in_time_rule = new DateTime(date("h:i:s",strtotime($desired_in_time)));

                    $time_diff = $check_in_compare_test->diff($in_time_rule);
                    if($time_diff->format('%R%i') < 0){
                        $lateCount++;
                        $lateMinutes = abs($time_diff->format('%h') * 60 + $time_diff->format('%i'));
                        $totalLateMinutes += $lateMinutes;
                        // log_message('debug','timee = '.$time_diff->format('%R%h:%i'));
                    }

                    if($weekName == 'Sunday'){
                        $print_v = 'SUNDAY';
                    }else if(!empty($holiday_dates[$date_attendance])){
                        $print_v = 'HH';
                    }else if(empty($attInfo['punch_date'])){
                        $print_v = 'AB';
                    }else if(!empty($in_time_punch)){ //&& !empty($out_time_punch)
                        $working_day++;
                        if($out_time_punch == "00:00:00"){
                            $print_v = $in_time_punch.'- NOP';
                            $nop++;
                        }
                    }
                 
                    if($col_count == 10){
                        $col_count = 1;
                    }else{
                        $col_count = $col_count;
                    }
                    
                    if($col_count == 9){
                ?>
                  
                    <td style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;margin: 0rem"><?php echo $days_v.': '.$print_v; ?></td>
                    </tr>
                    <tr style="font-size: 24px;">
                    <td style="border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;"></td>
                 <?php
                    }else{
                        echo '<td style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;margin: 0rem">'.$days_v.': '.$print_v.'</td>';
                    }
               // }
                
                $col_count++;
                $days_v++;
                if($print_v == 'AB'){
                    $absent_count++;
                // }else if($print_v == 'CL'){
                //     $casual_leave++;
                // }else if($print_v == 'LOP'){
                //     $pay_leave++;
                }else if($print_v == 'WO'){
                    $week_off++;
                }else if($print_v == 'HH'){ 
                    $holiday_count++;
                // }else if($print_v == 'WD'){
                }
                
            }

            ?>
                <!-- <td style="border-bottom: 1px solid black;border-right: 1px solid black;"></td> -->
            <tr>

                <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;font-size: 22px;">WD : <?php echo $working_day; ?></th>
                <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;font-size: 22px;">AB : <?php echo $absent_count; ?></th>
                <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;font-size: 22px;">No Punching Out</th>
                <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;font-size: 22px;"><?php echo $nop; ?></th>
                <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;font-size: 22px;">HOLIDAY : <?php echo $holiday_count; ?> </th>
                <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;font-size: 22px;">LC : <?php echo $lateCount ?></th>
                <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;font-size: 22px;">Total Late</th>
                <!-- <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;font-size: 22px;">LOP : <?php echo $pay_leave; ?></th> -->
                <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;font-size: 22px;"><?php echo  $totalLateMinutes ?> Minutes</th>
                <!-- <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;font-size: 22px;">CL : <?php echo $casual_leave; ?></th> -->
                <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;font-size: 22px;"></th>
                <th style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;font-size: 22px;"></th>

            </tr>
          
            <tr>

                <th colspan="10" style="text-align: center;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;font-size: 22px;border-left: 1px solid black;"><br/></th>


            </tr>
        <?php } ?>
    </table>
    <?php
    $totalStaffCount1--;
    ?>
    <?php if($totalStaffCount1 != 0){ ?>
    <div class="page-break"></div>
    <?php } ?>
    <?php 
}?>
    
</div>

<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->
    
</body>

</html>

<?php 


function getAllLeaveTakenInfoByStaff($con,$staff_id,$date_from, $date_to){
    
    if(!empty($date_to)){
        $query = "SELECT * FROM tbl_staff_applied_leave
        WHERE staff_id = '$staff_id'
        AND date_from between '$date_from' AND '$date_to' AND approved_status = 1 AND is_deleted = 0";
    }else{
        $query = "SELECT * FROM tbl_staff_applied_leave
        WHERE staff_id = '$staff_id'
        AND date_from >= '$date_from'
        AND approved_status = 1 AND is_deleted = 0";
    }
    $result = $con->prepare($query); 
    $result->execute(); 
    return $result->fetchAll();
}



function getSingleStaffAttendanceInfo($con,$staff_id,$date_today){

    $query = "SELECT sa.punch_time as in_time, sa.punch_out_time as out_time, staff.staff_id,
        sa.punch_date, sa.punch_time, staff.type, staff.row_id, staff.name,dept.name as department, staff.mobile_one, role_.role, role_.roleId
         FROM 
        tbl_staff_attendance_info as sa, tbl_staff as staff, tbl_roles as role_,
        tbl_department as dept
        WHERE
        
        staff.staff_id = sa.staff_id AND
        role_.roleId = staff.role AND
        dept.dept_id = staff.department_id AND staff.is_deleted = 0 AND
        sa.staff_id = '$staff_id' AND
        sa.punch_date = '$date_today'";
        // return $query->row();
    $result = $con->prepare($query); 
    $result->execute(); 
    return $result->fetch();
}

?>