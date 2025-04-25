<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


  $rating_no = $_POST['rating_no'];
  $student_id = $_POST['student_id'];
  $tutor_id = $_POST['tutor_id'];
  $msg = $_POST['msg'];
   
  $created_date = date('d-m-Y');
  
  if($rating_no !="" && $student_id !="" && $tutor_id !="" && $msg !="")
  {
   
    $chk = $conn->query("select * from tbl_rating where student_id = '".$student_id."' and tutor_id = '".$tutor_id."'  ");
	
	if(mysqli_num_rows($chk)>0)
	{
		$resultData = array('Status' => false, 'message' => 'You have given rating already. ');
	}   
	else
	{
		
		$add = $conn->query("INSERT INTO tbl_rating SET student_id = '".$student_id."' , tutor_id = '".$tutor_id."' , rating_no = '".$rating_no."' , msg = '".$msg."' , created_date = '".$created_date."'  ");
	
	
	
		if($add)
		{
		    
			$resultData = array('Status' => true, 'message' => 'Rating added successfully.');
		}	
		else
		{
		    
			$resultData = array('Status' => false, 'message' => 'Error.');
		}
						
	}
	
	
  }
  else
	{
		$resultData = array('Status' => false, 'message' => 'Please check passive values.');
	}
		
		
  echo json_encode($resultData);

?>