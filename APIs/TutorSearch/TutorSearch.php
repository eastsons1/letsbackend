<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


		 
			 $search=$_POST['search_keywords'];
			 
			   if($search !='')
				{ 
				
					$query = "SELECT * FROM user_info as uinf INNER JOIN user_tutor_info as utinf ON uinf.user_id = utinf.user_id WHERE uinf.first_name like '".$search."%' or uinf.email like '".$search."%' or uinf.mobile like '".$search."%' or utinf.qualification like '".$search."%' or utinf.tutor_status like '".$search."%' or utinf.tuition_type like '".$search."%' or utinf.location like '".$search."%' or utinf.postal_code like '".$search."%' or utinf.travel_distance like '".$search."%' ";
				
				}
		 
		
		
		$result = $conn->query($query) or die ("table not found");
		$numrows = mysqli_num_rows($result);
		
		
		if($numrows > 0)
		{
		  $Tutor_search_record = [];
			while($tutor_result = mysqli_fetch_assoc($result))
			{
				$Tutor_search_record[] = $tutor_result;
			}	
			
			if(!empty($Tutor_search_record))
			{
				$resultData = array('status' => true, 'Message' => $Tutor_search_record);
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