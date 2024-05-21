<?php
	//date_default_timezone_set('Asia/Kolkata');
    include_once 'connect.php';
	$rawdata = file_get_contents("php://input");
	$stgid= $_GET["stgid"];

	// We capture all the incoming data from CAMS into file: cams-attendance-record.txt.
	// If you need to maintain it in your own database, you need to impletement the same here.
	$raw = json_decode($rawdata);

	$ret = "done";
	$data = json_decode($rawdata, true);

	if( isset( $data["RealTime"] ))
	{
		$ret = handle_attendance_log($stgid, $rawdata, $con);
	}
	else
		$ret = "Else";

	$response = new StdClass();
	$response->status="done";

	header("Content-Type: application/text;charset=utf-8");
	http_response_code(200);
	echo json_encode($response);


// You can test url of this file through postman with POST->body->x-www-form-urlencoded parameter request_data
// the results will be avilable in http://<domain:port>/cams-attendance-record.txt
// ------------------------------------------------------------------------------------------------------------


function  handle_attendance_log($stgid, $rawdata, $con)
{

	$ret = "done";
	

	$request = new StdClass();
	$request->RealTime = new StdClass();
	$request->RealTime->AuthToken="";
	$request->RealTime->Time="";
	$request->RealTime->OperationID="";
	$request->RealTime->PunchLog = new StdClass();
	$request->RealTime->PunchLog->UserId="";
	$request->RealTime->PunchLog->LogTime="";
	$request->RealTime->PunchLog->Temperature="";
	$request->RealTime->PunchLog->FaceMask="";
	$request->RealTime->PunchLog->InputType="";
	$request->RealTime->PunchLog->Type= "";

	$request = json_decode($rawdata);
    // $UserId = $request->RealTime->PunchLog->UserId;
	// $AttendanceTime = $request->RealTime->PunchLog->LogTime;
	// $AttendanceType = $request->RealTime->PunchLog->Type;
   
    // $AttendanceTime =  strtotime($request->RealTime->PunchLog->LogTime);
    
	
  
	// $content = 'ServiceTagId:' . $stgid . ",\t";
	// $content = $content . 'UserId:' . $request->RealTime->PunchLog->UserId . ",\t";
	// $content = $content . 'AttendanceTime:' . $punch_date . ",\t";
	// $content = $content . 'AttendanceType:' . $AttendanceTime . ",\t";
	// $content = $content . 'InputType:' . $request->RealTime->PunchLog->InputType . ",\t";
	// $content = $content . 'Operation: RealTime->PunchLog' . ",\t";
	// $content = $content . 'AuthToken:' . $request->RealTime->AuthToken . "\n";

	//$file = fopen("cams-attendance-record.txt","a");
	//fwrite($file, $content);
    $ServiceTagId = $stgid;
	$UserId = $request->RealTime->PunchLog->UserId;
	$AttendanceTime = $request->RealTime->PunchLog->LogTime;
	$AttendanceType = $request->RealTime->PunchLog->Type;
	
    $punch_date = date('Y-m-d',strtotime($request->RealTime->PunchLog->LogTime));
    $punch_time = date('H:i:s',strtotime($request->RealTime->PunchLog->LogTime));

	$punch_out_date = date('Y-m-d',strtotime($request->RealTime->PunchLog->LogTime));
    $punch_out_time = date('H:i:s',strtotime($request->RealTime->PunchLog->LogTime));

    
	$strTime = $request->RealTime->PunchLog->LogTime;

	$stmt = $con->prepare("SELECT * FROM tbl_staff WHERE employee_id LIKE ?");
	$searchTerm = "%$UserId%";
	$stmt->execute([$searchTerm]); 
	$staff_result = $stmt->fetch();
	$staff_id = $staff_result['staff_id'];
	$query= "SELECT * from  tbl_staff_attendance_info WHERE staff_id = '$staff_id' ORDER BY row_id  DESC LIMIT 1";
	// $CheckInInfo = mysqli_query($con, $q);
	// $result = $con->mysqli_fetch_assoc($CheckInInfo);
	//$result = $mysqli->query($query);
	$stmt = $con->prepare($query); 
	$stmt->execute([$UserId]); 
	$result = $stmt->fetch();
//$row = $result->fetch_assoc();
	// date_default_timezone_set('Asia/Kolkata');
	$todayDateTime = date('Y-m-d H:i:s');

	if(!empty($result)){
		$row_id = $result['row_id'];
		$check_in_compare = new DateTime(date('Y-m-d H:i:s',strtotime($result['punch_date'].' '.$result['punch_time'])));
		
		$check_out_compare = new DateTime(date('Y-m-d H:i:s',strtotime($request->RealTime->PunchLog->LogTime)));
		
		$interval = $check_in_compare->diff($check_out_compare);
		
		try {
			if($result['punch_out_time'] == '00:00:00'){
                if($interval->i >= 5 || $interval->d >= 1 ||  $interval->h >= 1){
					$AttendanceType = 'CheckOut';
					$sql = "UPDATE tbl_staff_attendance_info SET punch_out_time = '$punch_out_time', punch_out_date = '$punch_out_date', attendance_type = '$AttendanceType', updated_date_time = '$todayDateTime' WHERE row_id = '$row_id'";
					$con->exec($sql);
				}
				// else{
				// 	$AttendanceType = 'CheckIn';
				// 	$sql = "UPDATE tbl_staff_attendance_info SET punch_time = '$punch_time', punch_date = '$punch_date', attendance_type = '$AttendanceType' WHERE row_id = $row_id";
				// }
			}else{
				$check_in_compare = new DateTime(date('Y-m-d H:i:s',strtotime($result['punch_out_date'].' '.$result['punch_out_time'])));
				$check_out_compare = new DateTime(date('Y-m-d H:i:s',strtotime($request->RealTime->PunchLog->LogTime)));
				$interval = $check_in_compare->diff($check_out_compare);
				if($interval->i >= 2  || $interval->d >= 1 ||  $interval->h >= 1){
                    $AttendanceType = 'CheckIn';
                    $sql = "INSERT INTO tbl_staff_attendance_info (service_tag_id, staff_id,employee_id, attendance_time,punch_time,punch_date,attendance_type,created_date_time)
                    VALUES ('$ServiceTagId', '$staff_id', '$UserId', '$strTime','$punch_time','$punch_date','$AttendanceType','$todayDateTime')";
                    $con->exec($sql);
                }else{
                    $AttendanceType = 'CheckOut';
                    $sql = "UPDATE tbl_staff_attendance_info SET punch_out_time = '$punch_out_time', punch_out_date = '$punch_out_date', attendance_type = '$AttendanceType', updated_date_time = '$todayDateTime' WHERE row_id = '$row_id'";
                    $con->exec($sql);
                }
					
				}
			
			// use exec() because no results are returned
			
		}
		catch(PDOException $e)
		{
			echo "error";
		}
	
	}else{
				$AttendanceType = 'CheckIn';
				$sql = "INSERT INTO tbl_staff_attendance_info (service_tag_id, staff_id,employee_id, attendance_time,punch_time,punch_date,attendance_type,created_date_time)
				VALUES ('$ServiceTagId', '$staff_id','$UserId', '$strTime','$punch_time','$punch_date','$AttendanceType','$todayDateTime')";
				$con->exec($sql);
	}


	$AttendanceType = 'CheckIn';
	$sql = "INSERT INTO tbl_staff_attendance_info_log (service_tag_id, staff_id,employee_id, attendance_time,punch_time,punch_date,attendance_type,created_date_time)
	VALUES ('$ServiceTagId', '$staff_id','$UserId', '$strTime','$punch_time','$punch_date','$AttendanceType','$todayDateTime')";
	$con->exec($sql);
	
	
	//  fclose($file);

	return $ret;

}
?>

