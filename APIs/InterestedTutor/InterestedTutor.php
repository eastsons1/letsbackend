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
			
			$arrayV = array();  
			$arrayV2 = array();  
			$arrayV3 = array();
			$arrayV4 = array();
			$arrayV5 = array();
			
			
			//print_r($array);
			
			// Extracting row by row
			foreach($array as $row => $value) 
			{ 
				
				//echo $row;
				
				if($row == 'student_post_requirements_id')
				{
					$student_post_requirements_id = $value;
				}
				
				if($row=='gender')
				{
					
					foreach($value as $row4 => $value4) 
					{
						$arrayV3[] = "('".$value4."')";	
						
					}
					
				}
				if($row=='tuton_status')
				{
					
					foreach($value as $row5 => $value5) 
					{
						$arrayV4[] = "('".$value5."')";	
						
					}
					
				}
				
				if($row=='nationality')
				{
					
					foreach($value as $row3 => $value3) 
					{
						//echo $tutor_qualification = $value2;
						
						$arrayV2[] = "('".$value3."')";	
						
						
					}
					//$nationality = $value;
				}
				
				if($row=='tutor_qualification')
				{
					foreach($value as $row2 => $value2) 
					{
						//echo $tutor_qualification = $value2;
						
						$arrayV[] = "('".$value2."')";	
						
						
					}
				}
				
			}	
					
					
					
					
					
				
			
			
			//$sql2 = $conn->query('SELECT * FROM user_tutor_info as info INNER JOIN student_post_requirements_Applied_by_tutor as apply ON info.user_id = apply.tutor_login_id WHERE info.qualification IN('.$qualification_array.') and info.gender = "'.$gender.'" and info.nationality IN('.$nationality_array.') and info.tutor_status = "'.$tuton_status.'" ');											
				



			$cond = [];
				
				if($student_post_requirements_id !="")
				{
					$cond[] = 'apply.student_post_requirements_id = "'.$student_post_requirements_id.'" ';
				}
				
				if (!empty($arrayV)) {
					$qualification_array = implode(', ', $arrayV);
					$cond[] = 'info.qualification IN('.$qualification_array.')';
				}

				if (!empty($arrayV2)) {
					$nationality_array = implode(', ', $arrayV2);
					$cond[] = 'info.nationality IN('.$nationality_array.')';
				}
				if (!empty($arrayV3)) {
					$gender_array = implode(', ', $arrayV3);
					$cond[] = 'info.gender IN('.$gender_array.')';
				}
				if (!empty($arrayV4)) {
					$tuton_status_array = implode(', ', $arrayV4);
					$cond[] = 'info.tutor_status IN('.$tuton_status_array.')';
				}
				
				


				if (!empty($cond)) {
					$sql2 = $conn->query('SELECT * FROM user_tutor_info as info INNER JOIN student_post_requirements_Applied_by_tutor as apply ON info.user_id = apply.tutor_login_id WHERE apply.apply_tag = "true" and ' . implode(' AND ', $cond). 'ORDER BY user_id DESC');
					
					
					$status_Q = 1;	
				
				}



						
						$tutor_List_array = array();
					
						while($tutor_Search_Data = mysqli_fetch_assoc($sql2))	
						{
							if($tutor_Search_Data['apply_tag']=='true')
							{
							
							
							$tutor_tution_offer_amount_type = mysqli_fetch_array($conn->query("select tutor_tution_offer_amount_type from student_post_requirements where student_post_requirements_id = '".$tutor_Search_Data['student_post_requirements_id']."' "));
							
							if($tutor_tution_offer_amount_type['tutor_tution_offer_amount'] == NULL || $tutor_tution_offer_amount_type['tutor_tution_offer_amount'] == "")
							{
								$tutor_tution_offer_amount = "0.00";
							}
							else{
								$tutor_tution_offer_amount = $tutor_tution_offer_amount_type['tutor_tution_offer_amount'];
							}
							
							
							
							$spramNeo = mysqli_fetch_array($conn->query("select final_accepted_amount,tutor_negotiate_amount from student_post_requirement_amount_negotiate where student_post_requirement_id = '".$tutor_Search_Data['student_post_requirements_id']."' and tutor_login_id = '".$tutor_Search_Data['tutor_login_id']."' "));
							
							
							
					 $Negotiate_amount = mysqli_fetch_array($conn->query("SELECT * FROM student_post_requirement_amount_negotiate as nego INNER JOIN student_post_requirements_Applied_by_tutor as apply ON nego.tutor_login_id = apply.tutor_login_id WHERE nego.student_post_requirement_id = '".$tutor_result['student_post_requirements_id']."' and nego.tutor_login_id = '".$tutor_Search_Data['tutor_login_id']."'  "));
					
					if($Negotiate_amount['student_negotiate_amount'] == NULL || $Negotiate_amount['student_negotiate_amount'] == "")
					{
						$student_negotiate_amount = "0.00";
					}
					else{
						$student_negotiate_amount = $Negotiate_amount['student_negotiate_amount'];
					}
						
							
							
							
							///////////////////////
							
							
							
							
							
							
							
							
							//////////////////////
							
							if($tutor_Search_Data['tutor_login_id'] !="")
							{
								$check = mysqli_fetch_array($conn->query("SELECT * from student_post_requirements_Favourite_Assigned  WHERE tutor_login_id = '".$tutor_Search_Data['tutor_login_id']."' and student_post_requirements_id = '".$tutor_Search_Data['student_post_requirements_id']."' "));
								
									if($check['favourite']=="" )
									{
										$Favourite = 'false';
										$tutor_id = "";
									}
									else
									{
										if($check['favourite']=="false")
										{
											$Favourite = 'false';
											$tutor_id = $check['tutor_login_id'];
										}
										else
										{
											$Favourite = 'true';
											$tutor_id = $check['tutor_login_id'];
										}
									}	
								
								
								
							}
							else{
									$Favourite = 'false';
									$tutor_id = "";
							}
							
							
							$student_idvvs = mysqli_fetch_array($conn->query("SELECT logged_in_user_id FROM student_post_requirements WHERE student_post_requirements_id = '".$tutor_Search_Data['student_post_requirements_id']."' "));
							
							
							//$tutor_List_array[] = $tutor_Search_Data;
							
							$tutor_List_array[] = array(
														'id' => $tutor_Search_Data['id'],
														'user_id' => $tutor_Search_Data['user_id'],
														'profile_image' => $tutor_Search_Data['profile_image'],
														'age' => $tutor_Search_Data['age'],
														'date_of_year' => $tutor_Search_Data['date_of_year'],
														'gender' => $tutor_Search_Data['gender'],
														'nationality' => $tutor_Search_Data['nationality'],
														'flag' => $tutor_Search_Data['flag'],
														'qualification' => $tutor_Search_Data['qualification'],
														'name_of_school' => $tutor_Search_Data['name_of_school'],
														'Course_Exam' => $tutor_Search_Data['Course_Exam'],
														'OtherCourse_Exam' => $tutor_Search_Data['OtherCourse_Exam'],
														'gra_year' => $tutor_Search_Data['gra_year'],
														'tutor_status' => $tutor_Search_Data['tutor_status'],
														'tuition_type' => $tutor_Search_Data['tuition_type'],
														'location' => $tutor_Search_Data['location'],
														'postal_code' => $tutor_Search_Data['postal_code'],
														'travel_distance' => $tutor_Search_Data['travel_distance'],
														'tutor_tutoring_experience_years' => $tutor_Search_Data['tutor_tutoring_experience_years'],
														'tutor_tutoring_experience_months' => $tutor_Search_Data['tutor_tutoring_experience_months'],
														'personal_statement' => $tutor_Search_Data['personal_statement'],
														'lettitude' => $tutor_Search_Data['lettitude'],
														'longitude' => $tutor_Search_Data['longitude'],
														'stream' => $tutor_Search_Data['stream'],
														'tutor_code' => $tutor_Search_Data['tutor_code'],
														'post_apply_id' => $tutor_Search_Data['post_apply_id'],
														'student_post_requirements_id' => $tutor_Search_Data['student_post_requirements_id'],
														'apply_tag' => $tutor_Search_Data['apply_tag'],
														'tutor_login_id' => $tutor_Search_Data['tutor_login_id'],
														'applied_date' => $tutor_Search_Data['applied_date'],
														'applied_time' => $tutor_Search_Data['applied_time'],
														'student_response' => $tutor_Search_Data['student_response'],
														'student_loggedIn_id' => $student_idvvs['logged_in_user_id'],
														'tutor_tution_offer_amount_type' => $tutor_tution_offer_amount_type['tutor_tution_offer_amount_type'],
														'tutor_tution_offer_amount' => $tutor_tution_offer_amount,
														'final_accepted_amount' => $spramNeo['final_accepted_amount'],
														'tutor_negotiate_amount' => $spramNeo['tutor_negotiate_amount'],
														'tutor_id' => $tutor_id,
														'favourite' => $Favourite,
														'negotiate_by' => $Negotiate_amount['negotiate_by'],
														'student_negotiate_amount' => $student_negotiate_amount
														
														);
														
														
							}
							
						}
						
						
						
						if(!empty($tutor_List_array))
						{
						
							$resultData = array('Status' => true, 'Tutor_Search_Data' => $tutor_List_array);
						}	
						else
						{
							$resultData = array('Status' => false, 'message' => 'No Result found. Insert right search keyword.');
						}
						
						
						
					
					
					echo json_encode($resultData);
					
					
?>