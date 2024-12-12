<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


		$emailId = $_POST['emailId'];
		$userpassword = $_POST['userpass'];
		
		
		
		if($_POST['login_option']=="Mobile Number")
		{
			$mobile_num = $_POST['mobile'];
			$query = "SELECT * FROM user_info WHERE mobile	='".$mobile_num."' and password ='".md5($userpassword)."' ";
		
		}
		if($_POST['login_option']=="Email")
		{
			$emailId = $_POST['emailId'];
			 $query = "SELECT * FROM user_info WHERE email	='".$emailId."' and password ='".md5($userpassword)."' ";
		
		}
		
		
		$result = $conn->query($query) or die ("table not found");
		$numrows = mysqli_num_rows($result);
		
		
		if($numrows > 0)
		{
		  $results = mysqli_fetch_array($result);
		  $results['email'];
			$results['password'];
			
			if( ($emailId==$results['email'] || $mobile_num==$results['mobile'] ) && md5($userpassword) == $results['password'] )
			{
				if($_POST['emailId'] !="")
				{
					$user_session_value = $_POST['emailId'];
				}
				if($_POST['mobile'] !="")
				{
					$user_session_value = $_POST['mobile'];
				}
				
				$_SESSION['adminusername'] = $user_session_value;
				
				$_SESSION['username'] = $user_session_value;
				
				$_SESSION['loggedIn_user_id'] = $results['user_id']; 
				
				
				
				if($_POST['remember'])
				{
					setcookie("cookusername", $_SESSION['adminusername'], time()+3600 , "/");
					setcookie("cookpass", $_SESSION['adminusername'], time()+60*60*24*30 , "/");
				}
				else
				{
					setcookie("cookusername", $_SESSION['adminusername'], time()+(-3600) , "/");
				}
				
				//header("location:admin/welcome.php");
				 $resultData = array('Status' => true, 'Message' => 'User Login Successfully.');
				 
				
			}
			else ///$message1="Password not valid !";
			$resultData = array('status' => false, 'message' => 'Password not valid !');
		}
		else 
		{
			//$message1="Email Id Or Mobile Number not valid !";
			$resultData = array('status' => false, 'message' => 'Email Id Or Mobile Number not valid !');
		}
				
							
							echo json_encode($resultData);
					
			
?>