<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
		 $query = "SELECT * FROM user_info as info INNER JOIN user_tutor_info as tutor_info ON info.user_id=tutor_info.user_id where info.user_type = 'I am an Educator' order by tutor_info.travel_distance DESC ";
				
			
		$result = $conn->query($query) or die ("table not found");
		$numrows = mysqli_num_rows($result);
		
		
		if($numrows > 0)
		{
		  $Tutor_list = [];
			while($tutor_result = mysqli_fetch_assoc($result))
			{
				
				//get user rating strat
							//$rating = '';
							$n=0;
							$postid = $tutor_result['user_id'];
							 
							 
							   //// Average Rating of student_date_time_offer_confirmation
					
					
					
					$avg_rating_sql = $conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$postid."' ");
					
					
					if(mysqli_num_rows($avg_rating_sql)>0)
					{
					
						$nn = 0;
						$sn = 0;
						while($avg_rating = mysqli_fetch_array($avg_rating_sql))
						{
							$sn = $sn+1;
							$nn = $nn+$avg_rating['rating_no'];
							 $rating_val_f2 = $avg_rating['rating_no'];
						}
						
						
						if($nn !=0 && $sn !=0)
						{
							
							 $avg_rating = round($nn/$sn); 
						}
						else
						{
							 $avg_rating = 'No rating.';
						}

					}
					else{
						$rating_val_f2 = 'No rating.';
						$avg_rating = 'No rating.';
					}	
							 
									
								$User_rating = array('Average_rating' => $avg_rating);	
								$rating_val_f = array('rating_val' => $rating_val_f2);
								
								
								$tutor_result2 = array_merge($tutor_result,$User_rating,$rating_val_f);
								
								//if($averageRating <= 0.0 || $averageRating <= 0){
								//	$averageRating = "No rating yet.";
								//}
				
				
				//get user rating end
				
				
				$Tutor_list[] = $tutor_result2;
				
				
				
				
				
			}	
			
			if(!empty($Tutor_list))
			{
				$resultData = array('status' => true, 'Message' => $Tutor_list);
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
				
							
			echo json_encode($resultData);
					
			
?>