<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


		 
			$tuition_type = $_POST['tuition_type'];
			$postal_code = $_POST['postal_code'];
			
			if($postal_code !="" && $tuition_type !="" )
			{
				$sql_user = "select * from user_info as uinfo INNER JOIN user_tutor_info as user_tutor ON uinfo.user_id = user_tutor.user_id WHERE user_tutor.postal_code = '".$postal_code."' and user_tutor.tuition_type = '".$tuition_type."' ";
			
					$result = $conn->query($sql_user) or die ("table not found");
					$numrows = mysqli_num_rows($result);
			
		
					if($numrows > 0)
					{
					  $Tutor_search_record = array();
					 
						while($tutor_result = mysqli_fetch_assoc($result))
						{
							
							$Tutor_search_record[] = $tutor_result;
							
						}

						
						
						if(!empty($Tutor_search_record))
						{
							$resultData = array('status' => true, 'message' => 'Record fetch successfully', 'data' => $Tutor_search_record);
						}
						else			
						{
							$resultData = array('status' => false, 'message' => 'Record fetch error', 'data' => 'No Record Found.');
						}				
						
						
					}
					else 
					{
						//$message1="Email Id Or Mobile Number not valid !";
						$resultData = array('status' => false, 'message' => 'No Record Found.');
					}
				
				
			}
			else{
				$resultData = array('status' => false, 'message' => 'Tuition type and Postal Code can not be blank.');
			}
		 
		
							
			echo json_encode($resultData);
					
			
?>