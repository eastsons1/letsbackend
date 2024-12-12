<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");


require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
		$query = "SELECT * FROM user_info where user_type = 'I am looking for a Tutor' ";
				
			
		$result = $conn->query($query) or die ("table not found");
		
		$numrows = mysqli_num_rows($result);
		
		
		if($numrows > 0)
		{
		    
		    $Student_list = [];
		
			while($student_result = mysqli_fetch_assoc($result))
			{
				$Student_list[] = $student_result;
			}	
			
			if(!empty($Student_list))
			{
				$resultData = array('status' => true, 'Message' => $Student_list);
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