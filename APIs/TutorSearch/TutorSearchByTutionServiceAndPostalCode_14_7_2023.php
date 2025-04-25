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
					  $Response = array();
					  $tutor_age = array();
					  $Average_Rating = array();
					  $FlagName = array();
					  
					  
						while($tutor_result = mysqli_fetch_assoc($result))
						{
							
							//$age = $tutor_result['age'];
							$age = date_diff(date_create($tutor_result['age']), date_create('now'))->y;
							
							$tutor_age = array('Tutor_Age'=>$age);
							
							
							$query2 = "SELECT ROUND(AVG(rating),1) as averageRating FROM post_rating WHERE postid=".$tutor_result['user_id'];
							$avgresult =  $conn->query($query2) or die(mysqli_error());
							$fetchAverage = mysqli_fetch_array($avgresult);
							
							if($fetchAverage['averageRating'] !="")
							{
								$averageRating = $fetchAverage['averageRating'];
							}
							else{
								$averageRating = '';
							}
								
							$Average_Rating = array('Average_Rating'=>$averageRating);
							
							
							$tutor_extra_data = mysqli_fetch_array($conn->query("select * from user_tutor_info where user_id = '".$tutor_result['user_id']."' "));
							$getFlag = mysqli_fetch_array($conn->query("select * from country where countryname = '".$tutor_extra_data['nationality']."' "));
							
							
							if($getFlag['code'] !="")
							{
								$getFlagName = strtolower($getFlag['code']).'.png';

								$flag_path = 'https://refuel.site/projects/tutorapp/flags-medium/'.$getFlagName;
							}
							else{
								
								$getFlagName = '';
								$flag_path = '';
							}

							$FlagName = array('Country_Flag_Name'=>$getFlagName,'Country_Flag_Path'=>$flag_path);
							
							$Tutor_search_record[] = array_merge($tutor_result,$tutor_age,$Average_Rating,$FlagName);
							
							
							
						}

						
						
						
						
						if(!empty($Tutor_search_record))
						{
							$resultData = array('status' => true, 'Message' => $Tutor_search_record);
						}
						else			
						{
							$resultData = array('status' => false, 'Message' => 'No Record Found.');
						}				
						
						
					}
					else 
					{
						//$message1="Email Id Or Mobile Number not valid !";
						$resultData = array('status' => false, 'Message' => 'No Record Found.');
					}
				
				
			}
			else{
				$resultData = array('status' => false, 'Message' => 'Tuition type and Postal Code can not be blank.');
			}
		 
		
		
		
				
							
			echo json_encode($resultData);
					
			
?>