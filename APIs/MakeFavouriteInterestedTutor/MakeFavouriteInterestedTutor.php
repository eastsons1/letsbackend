<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


$student_post_requirements_id = $_POST['student_post_requirements_id'];
$tutor_login_id = $_POST['tutor_login_id'];
$student_login_id = $_POST['student_login_id'];
$favourite = $_POST['favourite'];

if($student_post_requirements_id != "" && $tutor_login_id != "" && $student_login_id !="")
{
	$sql = $conn->query("select * from student_post_requirements_Favourite_Assigned where student_post_requirements_id = '".$student_post_requirements_id."' and tutor_login_id = '".$tutor_login_id."' and student_login_id = '".$student_login_id."' ");

	if(mysqli_num_rows($sql)>0)
	{
		$sql_run = $conn->query("update student_post_requirements_Favourite_Assigned SET favourite = '".$favourite."' where student_post_requirements_id = '".$student_post_requirements_id."' and tutor_login_id = '".$tutor_login_id."' and student_login_id = '".$student_login_id."' ");
	}
	else
	{
		$sql_run = $conn->query("insert into student_post_requirements_Favourite_Assigned SET favourite = '".$favourite."', student_post_requirements_id = '".$student_post_requirements_id."', tutor_login_id = '".$tutor_login_id."' , student_login_id = '".$student_login_id."' ");
	}
	
	if($sql_run)
	{
		$resultData = array('status' => true, 'message' => 'Post id '.$student_post_requirements_id.' has been given favourite tag.');
	}
	
}
else
{
	$resultData = array('status' => false, 'message' => 'Student post requirements id, tutor id and student login id can not blank.');
}

 echo json_encode($resultData);

?>