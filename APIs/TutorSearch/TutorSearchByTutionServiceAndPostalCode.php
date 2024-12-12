<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


			
			$logged_in_student_id = $_POST['logged_in_student_id'];
			
			$tuition_type = $_POST['tuition_type'];
			$postal_code = $_POST['postal_code'];
			
			if($postal_code !="" && $tuition_type !="" )
			{
				//$sql_user = "select * from user_info as uinfo INNER JOIN user_tutor_info as user_tutor ON uinfo.user_id = user_tutor.user_id WHERE user_tutor.postal_code = '".$postal_code."' and user_tutor.tuition_type = '".$tuition_type."' ";
			
				
				/**
				if($logged_in_student_id !="" )
				{
					$sql_user = "SELECT *
									FROM user_info
									INNER JOIN user_tutor_info
									ON  user_info.user_id = user_tutor_info.user_id
									INNER JOIN favourite_tutor_by_student
									ON user_tutor_info.user_id = favourite_tutor_by_student.tutor_id WHERE user_tutor_info.postal_code = '".$postal_code."' and user_tutor_info.tuition_type = '".$tuition_type."' and favourite_tutor_by_student.logged_in_student_id = '".$logged_in_student_id."' ";
					
				}
				else
				{
				
					$sql_user = "SELECT *
										FROM user_info
										INNER JOIN user_tutor_info
										ON  user_info.user_id = user_tutor_info.user_id
										INNER JOIN favourite_tutor_by_student
										ON user_tutor_info.user_id = favourite_tutor_by_student.tutor_id WHERE user_tutor_info.postal_code = '".$postal_code."' and user_tutor_info.tuition_type = '".$tuition_type."' ";
						
				}
				**/
				
				$sql_user = "SELECT *
									FROM user_info
									INNER JOIN user_tutor_info
									ON  user_info.user_id = user_tutor_info.user_id
									WHERE user_tutor_info.postal_code = '".$postal_code."' and user_tutor_info.tuition_type LIKE '%".$tuition_type."%'  ";
					
				
				
				
					$result = $conn->query($sql_user) or die ("table not found");
					$numrows = mysqli_num_rows($result);
			
		
					if($numrows > 0)
					{
					  $Tutor_search_record = array();
					 
						while($tutor_result = mysqli_fetch_assoc($result))
						{
							
							if($logged_in_student_id !="")
							{
								$check = mysqli_fetch_array($conn->query("SELECT * from favourite_tutor_by_student WHERE logged_in_student_id = '".$logged_in_student_id."' and tutor_id = '".$tutor_result['user_id']."'  "));
								
								if($check['tutor_id']==$tutor_result['user_id'] )
								{
								
									$Favourite = $check['favourite'];
									$tutor_id = $check['tutor_id'];
									
								}
								else{
									$Favourite = 'false';
									$tutor_id = "";
									}
								
							}
							else{
									$Favourite = 'false';
									$tutor_id = "";
							}
							
							
							
							//$Tutor_search_record[] = $tutor_result;
							
							$Tutor_search_record[] = array(
											'user_id' => $tutor_result['user_id'],
											'adminusername' => $tutor_result['adminusername'],
											'first_name' => $tutor_result['first_name'],
											'last_name' => $tutor_result['last_name'],
											'email' => $tutor_result['email'],
											'password' => $tutor_result['password'],
											'mobile' => $tutor_result['mobile'],
											'address1' => $tutor_result['address1'],
											'profile_image' => $tutor_result['profile_image'],
											'user_type' => $tutor_result['user_type'],
											'Term_cond' => $tutor_result['Term_cond'],
											'user_roll' => $tutor_result['user_roll'],
											'accessToken' => $tutor_result['accessToken'],
											'expiry_timestamp' => $tutor_result['expiry_timestamp'],
											'device_token' => $tutor_result['device_token'],
											'device_type' => $tutor_result['device_type'],
											'id' => $tutor_result['id'],
											'age' => $tutor_result['age'],
											'gender' => $tutor_result['gender'],
											'nationality' => $tutor_result['nationality'],
											'qualification' => $tutor_result['qualification'],
											'name_of_school' => $tutor_result['name_of_school'],
											'Course_Exam' => $tutor_result['Course_Exam'],
											'OtherCourse_Exam' => $tutor_result['OtherCourse_Exam'],
											'gra_year' => $tutor_result['gra_year'],
											'tutor_status' => $tutor_result['tutor_status'],
											'tuition_type' => $tutor_result['tuition_type'],
											'location' => $tutor_result['location'],
											'postal_code' => $tutor_result['postal_code'],
											'travel_distance' => $tutor_result['travel_distance'],
											'tutor_tutoring_experience_years' => $tutor_result['tutor_tutoring_experience_years'],
											'tutor_tutoring_experience_months' => $tutor_result['tutor_tutoring_experience_months'],
											'personal_statement' => $tutor_result['personal_statement'],
											'lettitude' => $tutor_result['lettitude'],
											'longitude' => $tutor_result['longitude'],
											'stream' => $tutor_result['stream'],
											'tutor_code' => $tutor_result['tutor_code'],
											'Favourite' => $Favourite,
											'tutor_id' => $tutor_id
							
											);
							
							
							
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