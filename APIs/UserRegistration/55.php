<?php
				
				
				foreach($TutoringDetail_Array as $entry2) 
				{
				if($entry2['TutoringLevel'] == "Secondary")
					{
						foreach($entry2 as $entry3) 
						{
							print_r($entry3);
							
							foreach($entry3 as $entry4) 
							{
								//print_r($entry4);
								
								//print_r($entry4);
								 $AdmissionLevel = $entry4['AdmissionLevel'];
								 $AdmissionStreamResultID = $entry4['AdmissionStreamResultID'];
								
								

								$AdmissionStreamResultquery2 = $conn->query("INSERT INTO complete_user_profile_tutoring_admission_level (AdmissionStreamResultID, AdmissionLevel, user_id) VALUES ('$AdmissionStreamResultID', '$AdmissionLevel', '$user_id')");
								
								foreach($entry4 as $streamData)    ///foreach($entry4['Stream'] as $streamData)
								{
									foreach($streamData as $streamDatavval)    ///foreach($entry4['Stream'] as $streamData)
									{
										//echo $streamDatavval;
										
										$AdmissionStreamquery2 = $conn->query("INSERT INTO complete_user_profile_tutoring_admission_stream (AdmissionStreamResultID, Stream, user_id) VALUES ('$AdmissionStreamResultID', '$streamDatavval', '$user_id')");
										if($AdmissionStreamquery2)
										{
											 $succ = 1;
											 
										}
										else{
											$succ = 0;
										}
									
									}
								
								}
								
								
								
							}
						}
					}
				}
				
				
				
				
				
				
					
				
				
				
				==================
				
				
				
				
					if($entry2['TutoringLevel'] == "Secondary")
					{
						foreach($entry2 as $entry3) 
						{
							
							
							foreach($entry3 as $entry4) 
							{
								//print_r($entry3);
								
								//print_r($entry4);
								 $AdmissionLevel = $entry4['AdmissionLevel'];
								 $AdmissionStreamResultID = $entry4['AdmissionStreamResultID'];
								
								

								$AdmissionStreamResultquery2 = $conn->query("INSERT INTO complete_user_profile_tutoring_admission_level (AdmissionStreamResultID, AdmissionLevel, user_id) VALUES ('$AdmissionStreamResultID', '$AdmissionLevel', '$user_id')");
								
								foreach($entry4 as $streamData)    ///foreach($entry4['Stream'] as $streamData)
								{
									foreach($streamData as $streamDatavval)    ///foreach($entry4['Stream'] as $streamData)
									{
										//echo $streamDatavval;
										
										$AdmissionStreamquery2 = $conn->query("INSERT INTO complete_user_profile_tutoring_admission_stream (AdmissionStreamResultID, Stream, user_id) VALUES ('$AdmissionStreamResultID', '$streamDatavval', '$user_id')");
										if($AdmissionStreamquery2)
										{
											 $succ = 1;
											 
										}
										else{
											$succ = 0;
										}
									
									}
								
								}
								
								
								
							}
							
							
							
							
							
							//echo $succ.'+++';
							
							if($succ==1)
							{
								
								
								
								/// Get Registration data
								$RData = mysqli_fetch_array($conn->query("SELECT user.user_type, user.user_id,user.accessToken,user.device_token, info.postal_code,info.profile_image FROM user_tutor_info as info INNER JOIN user_info as user ON info.user_id = user.user_id WHERE info.user_id = '".$user_id."' "));
								
								if($RData['user_type'] !="")
								{
									$output = array('message' => 'Tutor Profile Data Inserted Successfully.', 'user_type'=>$RData['user_type'], 'user_id'=>$RData['user_id'], 'accessToken'=>$RData['accessToken'], 'device_token'=>$RData['device_token'], 'postal_code'=>$RData['postal_code'], 'profile_image' => $RData['profile_image']);
									
									$resultData2 = array('status' => true, 'output' => $output);
									//$resultData2 = array('status' => true, 'message' => 'Tutor Profile Data Inserted Successfully.');
								
									$chk = 1;
									echo json_encode($resultData2);
								}
								else{
									
									$resultData2 = array('status' => false, 'message' => 'Error Found.');
									$chk = 0;
									echo json_encode($resultData2);
								}
								
							}
							
						}
						
						
						
					}
				
				
				
				
				
				
				
							
				
				
				/**
				/// for Subject start
					foreach($entry2['Tutoring_ALL_Subjects'] as $aa2 => $vv2) 
					{
						$arrayV4[] = "('".$vv2."')";
						
						//print_r($vv1);
						
					}	
					
					
					
				$qua4 = $conn->query("delete from complete_user_profile_tutoring_tutoring_subjects_detail where user_id = '".$user_id."' ");
				$qua5 = $conn->query("INSERT INTO `complete_user_profile_tutoring_tutoring_subjects_detail` (Tutoring_ALL_Subjects) VALUES " . implode(', ', $arrayV4));  
				$qua6 = $conn->query("UPDATE complete_user_profile_tutoring_tutoring_subjects_detail SET user_id = '".$user_id."' where user_id = 0 ");  
				/// For Subject End
				**/
				
				
				/**
				/// Get Registration data
				$RData = mysqli_fetch_array($conn->query("SELECT user.user_type, user.user_id,user.accessToken,user.device_token, info.postal_code,info.profile_image FROM user_tutor_info as info INNER JOIN user_info as user ON info.user_id = user.user_id WHERE info.user_id = '".$user_id."' "));
				
				if($RData['user_id'] !="")
				{
				
					$resultData = array('status' => true, 'message' => 'Tutor Profile Data Inserted Successfully.', 'user_type'=>$RData['user_type'], 'user_id'=>$RData['user_id'], 'accessToken'=>$RData['accessToken'], 'device_token'=>$RData['device_token'], 'postal_code'=>$RData['postal_code'], 'profile_image' => $RData['profile_image']);
				}
				else{
					$resultData = array('status' => false, 'message' => 'Error Found.');
				}
					//http_response_code(200);
					
				**/		


?>