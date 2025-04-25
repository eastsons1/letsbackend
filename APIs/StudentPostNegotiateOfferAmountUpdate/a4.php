<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	
		$student_post_requirement_id = $_POST['student_post_requirement_id'];
		$amount_type = $_POST['amount_type'];
		$student_login_id = $_POST['student_login_id'];
		$tutor_login_id = $_POST['tutor_login_id'];
		$student_negotiate_amount = $_POST['student_negotiate_amount'];
		$tutor_negotiate_amount = $_POST['tutor_negotiate_amount'];
		$final_accepted_amount = $_POST['final_accepted_amount'];
		$status = $_POST['status'];
		
		
		//$d=mktime(11, 14, 54, 8, 12, 2014);

		
		
		$date_time = date("Y-m-d h:i:sa");
		
	
		
		if($student_post_requirement_id !="" && $amount_type == "Negotiable" )
		{
			
			/// For Student update amount
			if($student_login_id !="" && $tutor_login_id !="" && $student_negotiate_amount !="" )
			{
			
				$chk = $conn->query("SELECT * FROM student_post_requirement_amount_negotiate WHERE student_login_id = '".$student_login_id."' and tutor_login_id = '".$tutor_login_id."' and student_post_requirement_id = '".$student_post_requirement_id."' ");
			
				if(mysqli_num_rows($chk)>0)
				{
					
					if($final_accepted_amount=='')
					{
						$final_accepted_amount = 0.00;
					}
					
					
				//////////////	
					if($final_accepted_amount != 0 && $final_accepted_amount != "")
					{
						$nVal = mysqli_fetch_array($chk);
						$arrV = array($nVal['student_negotiate_amount'],$nVal['tutor_negotiate_amount']);

						//print_r($arrV);

						$final_accepted_amount_val = number_format((float)$final_accepted_amount, 2, '.', '');  
						//echo $final_accepted_amount_val;
						
						if(in_array($final_accepted_amount_val,$arrV, TRUE))
						{
							$mValS = 'Yes';
							
							
						}
						else{
							$mValS = 'No';
							
							
						}
						
						
					}
					else{
						$mValS = 1;
					}
					
				//////////////
				
				
				if($mValS==1 || $mValS == 'Yes')
				{
					$sql = $conn->query("UPDATE student_post_requirement_amount_negotiate SET student_negotiate_amount = '".$student_negotiate_amount."', final_accepted_amount = '".$final_accepted_amount."', status = '".$status."', date_time = '".$date_time."' WHERE student_login_id = '".$student_login_id."' and tutor_login_id = '".$tutor_login_id."' and student_post_requirement_id = '".$student_post_requirement_id."' ");
					
					if($sql)
					{
						$resultData = array('status' => true, 'message' => 'Negotiate Amount Updated Successfully.', 'status' => $status, 'final_accepted_amount' => $final_accepted_amount );
					}
					else			
					{
						$resultData = array('status' => false, 'message' => 'Not updated.');
					}	

				}
				
				if($mValS=='No')
				{
					$resultData = array('status' => false, 'message' => 'Not match Final value.');
				}

					
					
				}
									
					
							
					
				
				
					
				$state = 1;	

			}
			else{
				
				if($state !=2)
				{
				
					$resultData = array('status' => false, 'message' => 'Student id and Amount negotiate by student can\'t be blank.');
				}
			}
			
			
			
			
			/// For tutor update amount
			if($tutor_login_id !="" && $student_login_id !="" && $tutor_negotiate_amount !="" )
			{
		
		
				$query = "SELECT * FROM student_post_requirement_amount_negotiate where tutor_login_id = '".$tutor_login_id."' and student_login_id = '".$student_login_id."' and student_post_requirement_id = '".$student_post_requirement_id."' ";
						
					
				$result = $conn->query($query) or die ("table not found");
				$numrows = mysqli_num_rows($result);
				
				
				if($numrows > 0)
				{
				
					if($final_accepted_amount=='')
					{
						$final_accepted_amount = 0.00;
					}
					
					
					
					//////////////	
					if($final_accepted_amount != 0 && $final_accepted_amount != "")
					{
						$nVal = mysqli_fetch_array($result);
						$arrV = array($nVal['student_negotiate_amount'],$nVal['tutor_negotiate_amount']);

						//print_r($arrV);

						$final_accepted_amount_val = number_format((float)$final_accepted_amount, 2, '.', '');  
						//echo $final_accepted_amount_val;
						
						if(in_array($final_accepted_amount_val,$arrV, TRUE))
						{
							$mValS = 'Yes';
							
							
						}
						else{
							$mValS = 'No';
							
							
						}
						
						
					}
					else{
						$mValS = 1;
					}
					
				//////////////
					
					
					
					if($mValS==1 || $mValS == 'Yes')
					{
					/// Record updated
					
						$sql = $conn->query("UPDATE student_post_requirement_amount_negotiate SET tutor_negotiate_amount = '".$tutor_negotiate_amount."',final_accepted_amount = '".$final_accepted_amount."', status = '".$status."', date_time = '".$date_time."' WHERE tutor_login_id = '".$tutor_login_id."' and student_login_id = '".$student_login_id."' and student_post_requirement_id = '".$student_post_requirement_id."'  ");
						if($sql)
						{
							$resultData = array('status' => true, 'message' => 'Negotiate Amount Updated Successfully.', 'status' => $status, 'final_accepted_amount' => $final_accepted_amount );
						}
						else			
						{
							$resultData = array('status' => false, 'message' => 'Not updated.');
						}				
						
					
					}
					
					if($mValS=='No')
					{
						$resultData = array('status' => false, 'message' => 'Not match Final value.');
					}
					
					
				}
				else 
				{
					$sql = $conn->query("INSERT INTO student_post_requirement_amount_negotiate SET tutor_negotiate_amount = '".$tutor_negotiate_amount."', date_time = '".$date_time."', tutor_login_id = '".$tutor_login_id."',student_login_id = '".$student_login_id."', student_post_requirement_id = '".$student_post_requirement_id."', amount_type='Negotiable', student_negotiate_amount=0.00, final_accepted_amount=0.00, status='' ");
					
					if($sql)
					{
						$resultData = array('status' => true, 'message' => 'Negotiate Amount Updated Successfully.', 'status' => $status, 'final_accepted_amount' => $final_accepted_amount );
					}
					else			
					{
						$resultData = array('status' => false, 'message' => 'Not updated.');
					}				
					
				}	
					
					
					
				
					
					
					$state = 2;	

			}
			else{
				
				if($state !=1)
				{
				
					$resultData = array('status' => false, 'message' => 'Tutor id and Amount negotiate by tutor can\'t be blank.');
				}
			}


			
		
		
		}
		else{
			
			$resultData = array('status' => false, 'message' => 'Please check the passive values.');
		}
		
			
							
				echo json_encode($resultData);
				
					
			
?>