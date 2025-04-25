<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

		
		
	
			// Read the JSON file in PHP
			$data = file_get_contents("php://input");
			
			// Convert the JSON String into PHP Array
			$array = json_decode($data, true);
			
			
		
		//if($array['AdmissionLevel']!="" && $array['Tutoring_Grade']!="" && $array['postal_code']!="" )
		if($array['postal_code']!="" && $array['postal_code'] == "ASC" )	
		{
			
			$postal_code = " ORDER BY user_tutor_info.postal_code ASC ";
		}
			
		if($array['postal_code']!="" && $array['postal_code'] == "DESC" )	
		{
			
			$postal_code = " ORDER BY user_tutor_info.postal_code DESC ";
		}

		if($array['AdmissionLevel']!="" && $array['AdmissionLevel'] == "ASC" )	
		{
			
			$postal_code = " ORDER BY complete_user_profile_tutoring_detail.AdmissionLevel ASC ";
		}
			
		if($array['AdmissionLevel']!="" && $array['AdmissionLevel'] == "DESC" )	
		{
			
			$postal_code = " ORDER BY complete_user_profile_tutoring_detail.AdmissionLevel DESC ";
		}
		
		if($array['Tutoring_Grade']!="" && $array['Tutoring_Grade'] == "ASC" )	
		{
			
			$postal_code = " ORDER BY complete_user_profile_tutoring_detail.Tutoring_Grade ASC ";
		}
			
		if($array['Tutoring_Grade']!="" && $array['Tutoring_Grade'] == "DESC" )	
		{
			
			$postal_code = " ORDER BY complete_user_profile_tutoring_grade_detail.Tutoring_Grade DESC ";
		}

		
			
			$check = "SELECT * FROM complete_user_profile_tutoring_detail INNER JOIN user_tutor_info ON complete_user_profile_tutoring_detail.user_id = user_tutor_info.user_id INNER JOIN complete_user_profile_tutoring_grade_detail ON user_tutor_info.user_id = complete_user_profile_tutoring_grade_detail.user_id INNER JOIN complete_user_profile_tutoring_tutoring_subjects_detail ON complete_user_profile_tutoring_grade_detail.user_id = complete_user_profile_tutoring_tutoring_subjects_detail.user_id ".$postal_code;
			
			$check_res = $conn->query($check);
			
			$check_res_num = mysqli_num_rows($check_res);
			
				  if($check_res_num > 0)	
				  {
					  
					  $Response = array();
						
						while($Filter_Data = mysqli_fetch_assoc($check_res))
						{
							$Response[] = $Filter_Data;
						}
						
						
						if(!empty($Response))
						{
							$resultData = array('status' => true, 'Sorting_Data_Records' => $Response);
						}
						else{
							$resultData = array('status' => false, 'message' => 'No Records Found.');
						}
						
					
				  }
				  else{
					
					 $resultData = array('status' => false, 'message' => 'No Record Found.');
									
				  }
		
		
		

					
			echo json_encode($resultData);
			
?>