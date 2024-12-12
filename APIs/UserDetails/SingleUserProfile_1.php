<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

		
		$Response = array();
		
		if($_GET['user_id']!="")
		{
			$check = "SELECT * FROM user_info WHERE user_id = '".$_GET['user_id']."' ";
			$check_res = $conn->query($check);
			$check_res_num = mysqli_num_rows($check_res);
			
		  if($check_res_num == 1)	
		  {
				 

				$user = $conn->query("SELECT * FROM user_info WHERE user_id = '".$_GET['user_id']."' ");
				
				
				$user_list_arr = array();
				$user = $conn->query("SELECT * FROM user_info WHERE user_id = '".$_GET['user_id']."' ");
				while($user_list = mysqli_fetch_assoc($user))
				{
					if($user_list['user_type']=="I am looking for a Tutor")
					{
						$sql = "SELECT * FROM user_student_info  WHERE user_id = '".$_GET['user_id']."' " ;
						
						$user_type = "Student";
					}
					if($user_list['user_type']=="I am an Educator")
					{
						$sql = "SELECT * FROM  user_tutor_info WHERE user_id = '".$_GET['user_id']."' " ;
						
						$user_type = "Tutor";
					}
					
						$user_extra_info = mysqli_fetch_assoc($conn->query($sql));
					
					if(!empty($user_extra_info))
					{
						$user_list_arr[] = array_merge($user_list,$user_extra_info);
					}
					else{
						$user_list_arr[] = $user_list;
					}
					
					
					////  For complete_user_profile_history_academy
				
					$HA = array();
					
					
					$userHA = $conn->query("SELECT * FROM complete_user_profile_history_academy WHERE user_id = '".$_GET['user_id']."' ");
					
					//$userHA = $conn->query("SELECT * FROM complete_user_profile_history_academy AS academy INNER JOIN complete_user_profile_history_academy_result AS result ON academy.user_id=result.user_id WHERE academy.user_id=result.user_id and academy.record_id=result.record_id and academy.user_id= '".$_GET['user_id']."' ");
					
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
					
					
				/**	
					////  For complete_user_profile_history_academy Results
				
					$HAR = array();
					
					$userHA = $conn->query("SELECT * FROM complete_user_profile_history_academy_result WHERE user_id = '".$_GET['user_id']."' ");
					while($user_list_HAR = mysqli_fetch_assoc($userHA))
					{
						$HAR[] = array(
						'history_academy_result_id' => $user_list_HAR['history_academy_result_id'],
						'record_id' => $user_list_HAR['record_id'],
						'subject' => $user_list_HAR['subject'],
						'grade' => $user_list_HAR['grade'],
						'user_id' => $user_list_HAR['user_id']
						
						);
						
					}
				**/
				
					
					////  For complete_user_profile_tutoring_detail
					
					
					/**
					$TD = array();
					
					$userTD = $conn->query("SELECT * FROM complete_user_profile_tutoring_detail WHERE user_id = '".$_GET['user_id']."' ");
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
					
					**/
					
					
					$Tutoring_all_subjects_arr = array();
					
					$userTDee = $conn->query("SELECT * FROM complete_user_profile_tutoring_tutoring_subjects_detail WHERE user_id = '".$_GET['user_id']."' ");
					while($Tutoring_all_subjects = mysqli_fetch_assoc($userTDee))
					{
						$Tutoring_all_subjects_arr[] = array(
												'tutoring_subject_detail_id' => $Tutoring_all_subjects['tutoring_subject_detail_id'],
												'Tutoring_ALL_Subjects' => $Tutoring_all_subjects['Tutoring_ALL_Subjects'],
												'user_id' => $Tutoring_all_subjects['user_id']
										
						);
						
					}
					
					
					$Grade_arr = array();
					
					$userTDegge = $conn->query("SELECT * FROM complete_user_profile_tutoring_grade_detail WHERE user_id = '".$_GET['user_id']."' ");
					while($tutoring_grade_detail = mysqli_fetch_assoc($userTDegge))
					{
						$Grade_arr[] = array(
												'tutoring_grade_detail_id' => $tutoring_grade_detail['tutoring_grade_detail_id'],
												'Tutoring_Grade' => $tutoring_grade_detail['Tutoring_Grade'],
												'user_id' => $tutoring_grade_detail['user_id']
										
						);
						
					}
					
					
					
					
					
					
					
					$AdmissionStream_and_level_Result_arr = array();
					
					$userTDalevelsregge = $conn->query("SELECT * FROM complete_user_profile_tutoring_admission_level WHERE user_id = '".$_GET['user_id']."' ");
					while($admission_level_data = mysqli_fetch_assoc($userTDalevelsregge))
					{
						
						
						$AdmissionStreamResult_arr = array();
					
						$userTDasregge = $conn->query("SELECT * FROM complete_user_profile_tutoring_admission_stream WHERE user_id = '".$_GET['user_id']."' and AdmissionStreamResultID = '".$admission_level_data['AdmissionStreamResultID']."' ");
						while($AdmissionStreamResult = mysqli_fetch_assoc($userTDasregge))
						{
							$AdmissionStreamResult_arr[] = array(
													'tutoring_admission_stream_id' => $AdmissionStreamResult['tutoring_admission_stream_id'],
													'AdmissionStreamResultID' => $AdmissionStreamResult['AdmissionStreamResultID'],
													'Stream' => $AdmissionStreamResult['Stream'],
													'user_id' => $AdmissionStreamResult['user_id']
											
													);
							
						}
						
						
						
						
						$AdmissionStream_and_level_Result_arr[] = array(
												'tutoring_admission_level_id' => $admission_level_data['tutoring_admission_level_id'],
												'AdmissionStreamResultID' => $admission_level_data['AdmissionStreamResultID'],
												'AdmissionLevel' => $admission_level_data['AdmissionLevel'],
												'user_id' => $admission_level_data['user_id'],
												'Stream' => $AdmissionStreamResult_arr
										
												);
						
					}
					
					
					
					
					
					
					$complete_user_profile_tutoring_detail_arr = array();
					
					$userTDwe = $conn->query("SELECT * FROM complete_user_profile_tutoring_detail WHERE user_id = '".$_GET['user_id']."' ");
					while($user_profile_tutoring_detail = mysqli_fetch_assoc($userTDwe))
					{
						$complete_user_profile_tutoring_detail_arr[] = array(
												'tutoring_detail_id' => $user_profile_tutoring_detail['tutoring_detail_id'],
												'TutoringLevel' => $user_profile_tutoring_detail['TutoringLevel'],
												'AdmissionLevel' => $user_profile_tutoring_detail['AdmissionLevel'],
												'Tutoring_Grade' => $Grade_arr,
												'AdmissionStreamResult' => $AdmissionStream_and_level_Result_arr,
												'Tutoring_ALL_Subjects' => $Tutoring_all_subjects_arr,
												'Tutoring_Year' => $user_profile_tutoring_detail['Tutoring_Year'],
												'Tutoring_Month' => $user_profile_tutoring_detail['Tutoring_Month'],
												'user_id' => $user_profile_tutoring_detail['user_id']
										
						);
						
					}
					
					
					
					
					
					
					
					
					$Response[] = array(
									'user_id' => $user_list['user_id'],
									'adminusername' => $user_list['adminusername'],
									'first_name' => $user_list['first_name'],
									'last_name' => $user_list['last_name'],
									'email' => $user_list['email'],
									'Extra_info' => $user_list_arr,
									'history_academy_arr' => $HA,
																				//'history_academy_result' => $HAR,
									'TutoringDetail' => $complete_user_profile_tutoring_detail_arr
									
									);
				
					
				}
				
				
				
				
				if(!empty($Response))
				{
					$resultData = array('status' => true, 'Single_User_details' => $Response);
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