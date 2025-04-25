<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
	if($_POST['Level'] !="")
	{
				
				$Secondary_array = array();
				
				
				
					/// if Foreign AEIS
					if($_POST['Level']=="Secondary")
					{
						$grade_sql = $conn->query("SELECT * FROM school_levels WHERE school_level_name = 'Secondary' ");
							
							while($admission_level = mysqli_fetch_assoc($grade_sql))
							{
								
								
								if($admission_level['school_level_name']=='Secondary')
								{
									$level = 'Secondary';
									$grade_array = array('Sec 1','Sec 2','Sec 3','Sec 4','Sec 5');
									$Subjects_array = array('English','Math','Additional Math','Science','Science Physics','Pure Physics','Science Chemistry','Pure Chemistry','Science Biology','Pure Biology','Chinese','Higher Chinese','Principles of Accounts (POA)','Literature','History','Combined History','Geography','Combined Geography','Social Studies','Design & Technology (D & T)','Malay','Higher Malay','Tamil','Higher Tamil','Business Studies','Economics');
									
									$Stream_array = array('IP','Express','NA','NT');
								
									$Secondary_array[] = array(
																'Admission_Level' => $level,
																'Admission_Grade' => $grade_array,
																'Stream' => $Stream_array,
																'Subjects' => $Subjects_array
								
															   );
								
								}
								
								
								//$grade_array[] = $grade;
							}
							
							
							
							
							
							
							
					}		
				
				
			
			
			if(!empty($Secondary_array))
			{
				$resultData = array('status' => true, 'Filter_level_of_Secondary' => $Secondary_array);
			}
			else			
			{
				$resultData = array('status' => false, 'Message' => 'No Record Found.');
			}				
			
			
		}
		else 
		{
			$resultData = array('status' => false, 'Message' => 'Level can not be blank.');
		}
		
		
							
			echo json_encode($resultData);
					
			
?>