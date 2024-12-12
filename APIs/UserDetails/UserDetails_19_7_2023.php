<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');



		
		
		if($_POST['user_id']!="")
		{
			$check = "SELECT * FROM user_info WHERE user_id = '".$_POST['user_id']."' ";
			$check_res = $conn->query($check);
			$check_res_num = mysqli_num_rows($check_res);
			
		  if($check_res_num == 1)	
		  {
				 
				 $user_list_arr = array();
				$user = $conn->query("SELECT * FROM user_info WHERE user_id = '".$_POST['user_id']."' ");
				while($user_list = mysqli_fetch_assoc($user))
				{
					if($user_list['user_type']=="I am looking for a Tutor")
					{
						$sql = "SELECT * FROM user_student_info  WHERE user_id = '".$_POST['user_id']."' " ;
						
					}
					if($user_list['user_type']=="I am an Educator")
					{
						$sql = "SELECT * FROM  user_tutor_info WHERE user_id = '".$_POST['user_id']."' " ;
						
					}
					
					$user_extra_info = mysqli_fetch_assoc($conn->query($sql));
					
					if(!empty($user_extra_info))
					{
						$user_list_arr[] = array_merge($user_list,$user_extra_info);
					}
					else{
						$user_list_arr[] = $user_list;
					}
					
					
					
				}
				
				if(!empty($user_list_arr))
				{
					$resultData = array('status' => true, 'Single_User_details' => $user_list_arr );
				}
				else{
					$resultData = array('status' => false, 'message' => 'No Records Found.');
				}
				
			
		  }
		  else{
			
			 $resultData = array('status' => false, 'message' => 'User id not exists.');
							
		  }
		}
		else
		{
			  $resultData = array('status' => false, 'message' => 'User id can not blank.');		
		}			
		

					
			echo json_encode($resultData);
			
?>