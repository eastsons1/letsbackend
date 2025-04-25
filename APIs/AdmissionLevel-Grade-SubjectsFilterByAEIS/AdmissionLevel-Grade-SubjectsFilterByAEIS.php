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
				$Primary_array_Main = array();
				$Secondary_array_Main = array();
				$grade_array = array();
				$grade_array2 = array();
				$admission_level_array = array();
				$Subjects_array = array();
				$Primary_array = array();
				$Secondary_array = array();
				
				
					/// if Foreign AEIS
					if($_POST['Level']=="AEIS")
					{
						$grade_sql = $conn->query("SELECT * FROM school_levels WHERE school_level_name = 'AEIS' or school_level_name = 'Primary' or school_level_name = 'Secondary' ");
							
							while($admission_level = mysqli_fetch_assoc($grade_sql))
							{
								
								if($admission_level['school_level_name']=='Primary')
								{
									$level = 'Primary';
									$grade_array = array('P1','P2','P3','P4','P5');
									$Subjects_array = array('English','Math');
								
									$Primary_array[] = array(
																'Admission_Level' => $level,
																'Admission_Grade' => $grade_array,
																'Subjects' => $Subjects_array
								
															);
																	
																	
																	
																	
								
								}
								
								
								if($admission_level['school_level_name']=='Secondary')
								{
									$level = 'Secondary';
									$grade_array2 = array('Sec 1','Sec 2','Sec 3');
									$Subjects_array2 = array();
								
									$Secondary_array[] = array(
																'Admission_Level' => $level,
																'Admission_Grade' => $grade_array2,
																'Subjects' => $Subjects_array2
								
															   );
								
								}
								
								
								//$grade_array[] = $grade;
							}
							
							
							
							$Primary_array_Main[] = array('Primary' => $Primary_array);
							$Secondary_array_Main[] = array('Secondary' => $Secondary_array);
							
							$AEIS = array();
							$AEIS = array_merge($Primary_array_Main,$Secondary_array_Main);
							
					}		
				
				
			
			
			if(!empty($AEIS))
			{
				$resultData = array('status' => true, 'Filter_level_of_AEIS' => $AEIS);
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