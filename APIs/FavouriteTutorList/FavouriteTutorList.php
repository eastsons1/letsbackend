<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

		
		
		$logged_in_student_id = $_GET['logged_in_student_id'];
		
		
		if($logged_in_student_id != "" )
		{
			
			//$sql = $conn->query("SELECT tutor_info.user_id,tutor_info.favourite_status_given_by_student_id,tutor_info.favourite_status FROM user_info as userinfo INNER JOIN user_tutor_info as tutor_info ON userinfo.user_id=tutor_info.user_id WHERE tutor_info.favourite_status_given_by_student_id = '".$logged_in_student_id."' ");
			
			//$sql = $conn->query("SELECT tutor_info.user_id,tutor_info.favourite_status_given_by_student_id,tutor_info.favourite_status,tutor_info.age,tutor_info.gender,tutor_info.nationality,tutor_info.qualification,tutor_info.name_of_school,tutor_info.Course_Exam,tutor_info.gra_year,tutor_info.tutor_status,tutor_info.tuition_type,tutor_info.location,tutor_info.postal_code,tutor_info.travel_distance,tutor_info.tutor_tutoring_experience_years,tutor_info.tutor_tutoring_experience_months,tutor_info.personal_statement,tutor_info.lettitude,tutor_info.longitude,tutor_info.stream,tutor_info.tutor_code,tutor_info.favourite_status_given_by_student_id FROM user_info as userinfo INNER JOIN user_tutor_info as tutor_info ON userinfo.user_id=tutor_info.user_id WHERE tutor_info.favourite_status_given_by_student_id = '".$logged_in_student_id."' ");
			
				$sql = $conn->query("SELECT *
									FROM user_info
									INNER JOIN user_tutor_info
									ON  user_info.user_id = user_tutor_info.user_id
									INNER JOIN favourite_tutor_by_student
									ON user_tutor_info.user_id = favourite_tutor_by_student.tutor_id WHERE favourite_tutor_by_student.logged_in_student_id = '".$logged_in_student_id."' ");
					
					if(mysqli_num_rows($sql)>0)
					{
					
						$Favourite_array = array();
						$Array_merge = array();
					
					while($check_tutor_data = mysqli_fetch_assoc($sql))
					{
						
						if($check_tutor_data['favourite'] == 'true' )
						{
							
							////  For complete_user_profile_history_academy
							
								$HA = array();
								
								
								$userHA = $conn->query("SELECT * FROM complete_user_profile_history_academy WHERE user_id = '".$check_tutor_data['user_id']."' ");
								
								while($user_list_HA = mysqli_fetch_assoc($userHA))
								{
									$HAR = array();
									////  For complete_user_profile_history_academy Results start
									
										$rest = $conn->query("SELECT * FROM complete_user_profile_history_academy_result WHERE user_id = '".$_GET['user_id']."' and record_id = '".$user_list_HA['record_id']."'  ");
										while($HARD = mysqli_fetch_array($rest))
										{
											if($HARD['record_id'] !="" )
											{
												$HAR[] = array(
															'HistoryID' => $HARD['record_id'],
															'subject' => $HARD['subject'],
															'grade' => $HARD['grade']
												
												);
											}	
										}
									
									
									////  For complete_user_profile_history_academy Results end
									
									
									$HA[] = array('history_academy_id' => $user_list_HA['history_academy_id'],
									'HistoryID' => $user_list_HA['record_id'],
									'school' => $user_list_HA['school'],
									'exam' => $user_list_HA['exam'],
									'user_id' => $user_list_HA['user_id'],
									'result' => $HAR
									
									
									
									);
									
								}
								
								
								
								////  For complete_user_profile_tutoring_detail
								
								$TD = array();
								
								$userTD = $conn->query("SELECT * FROM complete_user_profile_tutoring_detail WHERE user_id = '".$check_tutor_data['user_id']."' ");
								while($user_list_TD = mysqli_fetch_assoc($userTD))
								{
									$TD[] = array('tutoring_detail_id' => $user_list_TD['tutoring_detail_id'],
													'TutoringLevel' => $user_list_TD['TutoringLevel'],
													'AdmissionLevel' => $user_list_TD['AdmissionLevel'],
													'Tutoring_Grade' => $user_list_TD['Tutoring_Grade'],
													'Tutoring_ALL_Subjects' => $user_list_TD['Tutoring_ALL_Subjects'],
													'Tutoring_Year' => $user_list_TD['Tutoring_Year'],
													'Tutoring_Month' => $user_list_TD['Tutoring_Month']
									
									);
									
								}
							
							
							
							$favourite_status = $check_tutor_data['favourite'];
							
							
							
							///// Rating
					 
					  $rating_val = mysqli_fetch_array($conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$check_tutor_data['tutor_id']."' "));
						
						if($rating_val['rating_no'] == null || $rating_val['rating_no'] =="")		
						{
							$rating_val_f = 0;
						}
						else{
							$rating_val_f = $rating_val['rating_no'];
						}
							
							
							$Favourite_array[] = array('user_id'=>$check_tutor_data['user_id'], 'rating_val'=>$rating_val_f, 'age'=>$check_tutor_data['age'],'gender'=>$check_tutor_data['gender'],'nationality'=>$check_tutor_data['nationality'],'qualification'=>$check_tutor_data['qualification'],'name_of_school'=>$check_tutor_data['name_of_school'],'Course_Exam'=>$check_tutor_data['Course_Exam'],'gra_year'=>$check_tutor_data['gra_year'],'tutor_status'=>$check_tutor_data['tutor_status'],'tuition_type'=>$check_tutor_data['tuition_type'],'location'=>$check_tutor_data['location'],'postal_code'=>$check_tutor_data['postal_code'],'travel_distance'=>$check_tutor_data['travel_distance'],'tutor_tutoring_experience_years'=>$check_tutor_data['tutor_tutoring_experience_years'],'tutor_tutoring_experience_months'=>$check_tutor_data['tutor_tutoring_experience_months'],'personal_statement'=>$check_tutor_data['personal_statement'],'lettitude'=>$check_tutor_data['lettitude'],'longitude'=>$check_tutor_data['longitude'],'stream'=>$check_tutor_data['stream'],'tutor_code'=>$check_tutor_data['tutor_code'],'favourite'=>$check_tutor_data['favourite'],'tutor_id'=>$check_tutor_data['tutor_id'],'logged_in_student_id'=>$check_tutor_data['logged_in_student_id'],'profile_image'=>$check_tutor_data['profile_image'],'history_academy_arr' => $HA, 'tutoring_detail_arr' => $TD);
						
							
						}
						
						 
						
						//$Favourite_array[] = $check_tutor_data;
						
					}
					
					//$Array_merge[] = array_merge($Favourite_array,$HA,$TD);
					
					
					if(!empty($Favourite_array))  //$Favourite_array
					{
						$resultData = array('status' => true, 'Tutor_Favourite_List' => $Favourite_array);
					}
					else{
						$resultData = array('status' => false, 'message' => 'No record found.');
					}
					
					
					
					}	
					else{
						$resultData = array('status' => false, 'message' => 'No record found.');
					}
			
		}
		else{
			$resultData = array('status' => false, 'message' => 'Student login id can\'t blank.' );
		}
		
		
					
			echo json_encode($resultData);
			
?>