<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
		$query = "SELECT * FROM school_levels ";
				
			
		$result = $conn->query($query) or die ("table not found");
		$numrows = mysqli_num_rows($result);
		
		
		if($numrows > 0)
		{
		  $Level_list = [];
			while($tutor_result = mysqli_fetch_assoc($result))
			{
				
				
				$Level_list[] = $tutor_result;
				
			}	
			
			if(!empty($Level_list))
			{
				$resultData = array('status' => true, 'Level_list' => $Level_list);
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