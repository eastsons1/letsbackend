<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


	$student_post_requirements_id = $_POST['student_post_requirements_id'];

	$create_date = date("d-m-Y h:i:s");

	if($student_post_requirements_id != "")
	{

			$chk = $conn->query("SELECT New_Interested FROM student_post_requirements WHERE student_post_requirements_id = '".$student_post_requirements_id."' ");
			
			if(mysqli_num_rows($chk)>0)
			{

				$removeInterest = $conn->query("UPDATE student_post_requirements SET New_Interested = '', update_date_time = '".$create_date."' WHERE student_post_requirements_id = '".$student_post_requirements_id."' ");

				if($removeInterest)
				{
					$resultData = array('status' => true, 'message' => 'New Interested has been removed from post.');
				}
				else
				{
					$resultData = array('status' => 'flase', 'message' => 'Execution Error.');
				}

			}
			else
			{

				$resultData = array('status' => flase, 'message' => 'Record not found.');
			
			}

			

	}
	else{

		$resultData = array('status' => 'flase', 'message' => 'Student post requirements id can not blank. ');
	}


	echo json_encode($resultData);





?>

 
