<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");

require '../../phpmailer-master/class.phpmailer.php';

//require_once("dbcontroller.php");
header('content-type:application/json');



$student_post_requirement_id  = $_POST['student_post_requirement_id'];
$add_negotiate_tag  = date('Y-m-d H:i:s'); //$_POST['add_negotiate_tag'];
$student_login_id  = $_POST['student_login_id'];
$tutor_login_id  = $_POST['tutor_login_id'];
$IPT = $_POST['add_negotiate_tag'];


if($student_post_requirement_id !="" && $add_negotiate_tag !="" && $student_login_id !="" && $tutor_login_id !="")
{
	
	$sql = $conn->query("SELECT * FROM student_post_requirement_amount_negotiate WHERE student_post_requirement_id = '".$student_post_requirement_id."' and student_login_id = '".$student_login_id."' and tutor_login_id = '".$tutor_login_id."' ");
	
	if(mysqli_num_rows($sql)>0)
	{
		$update = $conn->query("UPDATE student_post_requirement_amount_negotiate SET add_negotiate_tag = '".$add_negotiate_tag."', IPT = '".$IPT."'  WHERE student_post_requirement_id = '".$student_post_requirement_id."' and student_login_id = '".$student_login_id."' and tutor_login_id = '".$tutor_login_id."' ");
		if($update)
		{
			$resultData = array('status' => true, 'message' => 'Tag updated successfully.');
		}
		else
		{
			 $resultData = array('status' => false, 'message' => 'Error.');
		}
	
	}
	else{
		 $resultData = array('status' => false, 'message' => 'No record found.');
	}
	
}
else
{
	 $resultData = array('status' => false, 'message' => 'Please check passive values.');
							
}


 echo json_encode($resultData);

?>