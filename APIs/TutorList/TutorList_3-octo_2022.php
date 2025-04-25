<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
		$query = "SELECT * FROM user_info as info INNER JOIN user_tutor_info as tutor_info ON info.user_id=tutor_info.user_id where info.user_type = 'I am an Educator' ";
				
			
		$result = $conn->query($query) or die ("table not found");
		$numrows = mysqli_num_rows($result);
		
		
		if($numrows > 0)
		{
		  $Tutor_list = [];
			while($tutor_result = mysqli_fetch_assoc($result))
			{
				$Tutor_list[] = $tutor_result;
			}	
			
			if(!empty($Tutor_list))
			{
				$resultData = array('status' => true, 'Message' => $Tutor_list);
			}
			else			
			{
				$resultData = array('status' => false, 'Message' => 'No Record Found.');
			}				
			
			
		}
		else 
		{
			//$message1="Email Id Or Mobile Number not valid !";
			$resultData = array('status' => false, 'Message' => 'No Record Found.');
		}
				
							
			echo json_encode($resultData);
					
			
?>