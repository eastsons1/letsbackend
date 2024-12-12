<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


 $logged_in_user_id = $_POST['logged_in_user_id'];
 $student_post_requirements_id = $_POST['student_post_requirements_id'];

if($logged_in_user_id !="" && $student_post_requirements_id !="")
{

	$sql = $conn->query("SELECT * FROM student_post_requirements WHERE logged_in_user_id = '".$logged_in_user_id."' and student_post_requirements_id = '".$student_post_requirements_id."' ");

	//echo mysqli_num_rows($sql);
 
 

	if(mysqli_num_rows($sql)>0)
	{
		$Change_Delist = $conn->query("UPDATE student_post_requirements SET post_delist_status = '' WHERE logged_in_user_id = '".$logged_in_user_id."' and student_post_requirements_id = '".$student_post_requirements_id."' ");
		
		
		
		if($Change_Delist)
		{
			$resultData = array('status' => true, 'message' => 'Post Delist Removed Successfully.');
		}
	}
	else
	{
		$resultData = array('status' => false, 'message' => 'No record found.');
	}

}
else{
	$resultData = array('status' => false, 'message' => 'Logged in user id and Student post requirements id can not blank.');
}


	echo json_encode($resultData);

?>