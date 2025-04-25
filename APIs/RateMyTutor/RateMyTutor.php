<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	
		$userid = $_POST['loggedIn_user_id'];
		$postid = $_POST['tutor_id'];
		$rating = $_POST['rating'];
				
		//Check user is student		
		$student_query = mysqli_fetch_array($conn->query("SELECT user_type FROM user_info WHERE user_id = '".$userid."' "));
		
		//Check user is tutor		
		$tutor_query = mysqli_fetch_array($conn->query("SELECT user_type FROM user_info WHERE user_id = '".$postid."' "));
		
		if($student_query['user_type'] != "I am looking for a Tutor")
		{
			$resultData = array('status' => false, 'Message' => 'Logged in user is not a student.');
		}
		else{
	
				if($tutor_query['user_type'] != "I am an Educator")
				{
					$resultData = array('status' => false, 'Message' => 'Provided Tutor id User is not a tutor.');
				}
				else{
				
						
						if($userid != "" && $postid != "" && $rating != "")
						{
								
												
								

								// Check entry within table
								$query = "SELECT COUNT(*) AS cntpost FROM post_rating WHERE postid=".$postid." and userid=".$userid;

								$result = $conn->query($query);
								$fetchdata = mysqli_fetch_array($result);
								$count = $fetchdata['cntpost'];

								if($count == 0){
									$insertquery = "INSERT INTO post_rating(userid,postid,rating) values(".$userid.",".$postid.",".$rating.")";
									$insertquery_query = $conn->query($insertquery);
								}else{
									$updatequery = "UPDATE post_rating SET rating=" . $rating . " where userid=" . $userid . " and postid=" . $postid;
									$updatequery_query = $conn->query($updatequery);
								}


								// get average
								$query = "SELECT ROUND(AVG(rating),1) as averageRating FROM post_rating WHERE postid=".$postid;
								$result = $conn->query($query) or die(mysqli_error());
								$fetchAverage = mysqli_fetch_array($result);
								$averageRating = $fetchAverage['averageRating'];

								//$return_arr = array("averageRating"=>$averageRating);
								$resultData = array('status' => true, 'Message' => 'Rating Successfully Given to Tutor', "averageRating" => $averageRating);

								//echo json_encode($return_arr);
							
						}
					else{
							$resultData = array('status' => false, 'Message' => 'Logged In User_Id, Tutor id and Rating Can Not Be Blank.');
						}
		
					}	
		
			}
							
			echo json_encode($resultData);
					
			
?>