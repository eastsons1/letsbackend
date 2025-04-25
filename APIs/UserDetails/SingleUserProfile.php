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
						
						
						//// Average Rating of student_date_time_offer_confirmation
					
					
					$avg_rating_sql = $conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$user_list['user_id']."' ");
					
					
					
					$nn = 0;
					$sn = 0;
					while($avg_rating = mysqli_fetch_array($avg_rating_sql))
					{
						$sn = $sn+1;
						$nn = $nn+$avg_rating['rating_no'];
					}
					
					
					if($nn !=0 && $sn !=0)
					{
						
						 $avg_rating = round($nn/$sn); 
					}
					else
					{
						 $avg_rating = 'No rating.';
					}
						
						
					$Average_rating = array('Average_rating' => $avg_rating);	
					
					
					
					
					
					
					
					
					////  For QualificationAcademy
				
					
						$QualificationAcademy_Result_Arr = array();
						////  For complete_user_profile_qualification_academy Results start
						
							$rest = $conn->query("SELECT * FROM complete_user_profile_qualification_academy_result WHERE user_id = '".$_GET['user_id']."'  ");
							while($QARD = mysqli_fetch_array($rest))
							{
								if($QARD['subject'] !="" )
								{
									$QualificationAcademy_Result_Arr[] = array(
												'qualification_academy_result_id' => $QARD['qualification_academy_result_id'],
												'subject' => $QARD['subject'],
												'grade' => $QARD['grade']
									
									);
								}	
							}
						
						
						
					
					
					
					
					
					
					$QualificationAcademy_Result_Output = array('qualification_academy_arr' => $QualificationAcademy_Result_Arr);
						
						//print_r($QualificationAcademy_Result_Output);
					
					if(!empty($user_extra_info))
					{
						$user_list_arr[] = array_merge($user_list,$user_extra_info,$Average_rating,$QualificationAcademy_Result_Output);
					}
					else{
						$user_list_arr[] = array_merge($user_list,$Average_rating,$QualificationAcademy_Result_Output);
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
						'examName' => $user_list_HA['examName'],
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
					
					$TD = array();
					
					
					//// Record sort by given TutoringLevel List
					
					$userTD = $conn->query("SELECT * FROM complete_user_profile_tutoring_detail WHERE user_id = '".$_GET['user_id']."' AND TutoringLevel IN ('Pre-School','Primary','AEIS','Secondary','JC/Pre-U','IB (Diploma)','Grade 1 to 6','Grade 7 to 10','Grade 11 to 13','ITE','Polytechnic','University','Entrance Exams','Foreign Languages','Music','Computer') ORDER BY CASE WHEN TutoringLevel = 'Pre-School' THEN 1 WHEN TutoringLevel = 'Primary' THEN 2 WHEN TutoringLevel = 'AEIS' THEN 3 WHEN TutoringLevel = 'Secondary' THEN 4 WHEN TutoringLevel = 'JC/Pre-U' THEN 5 WHEN TutoringLevel = 'IB (Diploma)' THEN 6 WHEN TutoringLevel = 'Grade 1 to 6' THEN 7 WHEN TutoringLevel = 'Grade 7 to 10' THEN 8 WHEN TutoringLevel = 'Grade 11 to 13' THEN 9 WHEN TutoringLevel = 'ITE' THEN 10 WHEN TutoringLevel = 'Polytechnic' THEN 11 WHEN TutoringLevel = 'University' THEN 12 WHEN TutoringLevel = 'Entrance Exams' THEN 13 WHEN TutoringLevel = 'Foreign Languages' THEN 14 WHEN TutoringLevel = 'Music' THEN 15 WHEN TutoringLevel = 'Computer' THEN 16 ELSE 17 END, TutoringLevel;");
						
					
					//$userTD = $conn->query("SELECT * FROM complete_user_profile_tutoring_detail WHERE user_id = '".$_GET['user_id']."'  ");
					
					
					while($user_list_TD = mysqli_fetch_assoc($userTD))
					{
						
						if($user_list_TD['TutoringLevel'] != 'Secondary')
						{	
						
							//if($user_list_TD['TutoringLevel']=='Pre-School' )
							//{
						
						
							$TD[] = array('tutoring_detail_id' => $user_list_TD['tutoring_detail_id'],
											'TutoringLevel' => $user_list_TD['TutoringLevel'],
											'AdmissionLevel' => $user_list_TD['AdmissionLevel'],
											'Tutoring_Grade' => $user_list_TD['Tutoring_Grade'],
											'Tutoring_ALL_Subjects' => $user_list_TD['Tutoring_ALL_Subjects'],
											'Tutoring_Year' => $user_list_TD['Tutoring_Year'],
											'Tutoring_Month' => $user_list_TD['Tutoring_Month']
							
										);
										
										
							// }			
							
						}
						else
						{
							
							$AdmissionStreamResult_arr = array();
							
								
								$AdmissionLevelSql = $conn->query("SELECT * FROM complete_user_profile_tutoring_admission_level WHERE user_id = '".$_GET['user_id']."'  ");
									
									
								
									
								
								while($AdmissionStreamResult = mysqli_fetch_assoc($AdmissionLevelSql))
								{
									$streamdataArr = array();
									
									$streamsql = $conn->query("SELECT * FROM complete_user_profile_tutoring_admission_stream WHERE user_id = '".$_GET['user_id']."' and AdmissionStreamResultID = '".$AdmissionStreamResult['AdmissionStreamResultID']."'  ");
									
									
									
									
									while($streamdata = mysqli_fetch_array($streamsql))
									{
										//if($AdmissionStreamResult['AdmissionStreamResultID'] == $streamdata['AdmissionStreamResultID'])
										//{
											
											
											
											$streamdataArr[] = $streamdata['Stream'];
											
											
										//}
										
										
									}
									
										$AdmissionStreamResult_arr[] = array(
																'tutoring_admission_stream_id' => $AdmissionStreamResult['tutoring_admission_stream_id'],
																'AdmissionStreamResultID' => $AdmissionStreamResult['AdmissionStreamResultID'],
																'AdmissionLevel' => $AdmissionStreamResult['AdmissionLevel'],
																'Stream' => $streamdataArr,
																'user_id' => $AdmissionStreamResult['user_id']
														
																);
									
								}
							
							
							
							
							
							
							
							
							
							
							$TD[] = array('tutoring_detail_id' => $user_list_TD['tutoring_detail_id'],
											'TutoringLevel' => $user_list_TD['TutoringLevel'],
											'AdmissionLevel' => $user_list_TD['AdmissionLevel'],
											'AdmissionStreamResult' => $AdmissionStreamResult_arr,
											'Tutoring_ALL_Subjects' => $user_list_TD['Tutoring_ALL_Subjects'],
											'Tutoring_Year' => $user_list_TD['Tutoring_Year'],
											'Tutoring_Month' => $user_list_TD['Tutoring_Month']
							
							);
							
						}		
								
						
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
									'tutoring_detail_arr' => $TD
									
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