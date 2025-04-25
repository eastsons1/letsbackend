<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
//header('content-type:application/json');


  $user_id = $_POST['user_id'];
  $message = $_POST['message'];
  $app_rating = $_POST['app_rating'];
  $created_date = date('d-m-Y');
  
  if($user_id !="" && $message != "" && $app_rating)
  {
	$check = $conn->query("SELECT * FROM tbl_appRating WHERE user_id = '".$user_id."' ");
  
	if(mysqli_num_rows($check)>0)
	{
		$update = $conn->query("UPDATE tbl_appRating SET message = '".$message."' , app_rating = '".$app_rating."' WHERE user_id = '".$user_id."' ");
	
		if($update)
		{
			$resultData = array('status' => true, 'message' => 'Rating updated successfully.', 'app_rating' => $app_rating);
		}
		else
		{
			$resultData = array('status' => false, 'message' => 'Rating not updated.');
		}
	
	}
	else{
		
		$add_rating = $conn->query("INSERT INTO tbl_appRating SET message = '".$message."', app_rating = '".$app_rating."', user_id = '".$user_id."', created_date = '".$created_date."' ");
	
		if($add_rating)
		{
			$resultData = array('status' => true, 'message' => 'Rating added successfully.', 'app_rating' => $app_rating);
		}
		else
		{
			$resultData = array('status' => false, 'message' => 'Rating not added.');
		}
	
	}
	
	
  }
  else
  {
	 $resultData = array('status' => 'Please check passive values.');
  }
   
   
   echo json_encode($resultData);

?>