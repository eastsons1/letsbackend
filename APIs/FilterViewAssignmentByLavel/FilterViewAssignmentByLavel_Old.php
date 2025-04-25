<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');


		 
		 // Read the JSON file in PHP
			$data = file_get_contents("php://input");
			
			// Convert the JSON String into PHP Array
			$array = json_decode($data, true);
			
			$arrayV = array();  
			$arrayV2 = array();  
			
			
			
			// Extracting row by row
			foreach($array as $row => $value) 
			{
			
				foreach($value as $row2 => $value2) 
				{
					
					//print_r($value2);
					
					if($value2 != "" )
					{	
						$arrayV2[] = "('".$value2."')";				
					}	
				}
				
			}
			
			
			
					
					if(empty($arrayV2))
					{
						if(empty($arrayV2))
						{
							$resultData = array('Status' => false, 'Message' => 'Please Select Levels.');
						}
						
						
					}
					else
					{	
				
						if(!empty($arrayV2))
						{
							$Levels_search_array = implode(', ', $arrayV2);
						}
						else{
							$Levels_search_array = "''";
						}
						
						
						
						
						
						
					////check postal code and tution type
					 $sql = $conn->query("select * from student_post_requirements as spor INNER JOIN  tbl_Student_Level_Grade_Subjects_Post_Requirement as gsl ON spor.student_post_requirements_id = gsl.student_post_requirements_id ");
					  
					 
					  
						if(mysqli_num_rows($sql)>0)
						{
						
						
						
						if($Levels_search_array )
						{
							
								if( $Levels_search_array )
								{
									$where = ' where gsl.Level IN('.$Levels_search_array.') ';
								}
								
							
							
						$sql2 = $conn->query("select * from student_post_requirements as spor INNER JOIN  tbl_Student_Level_Grade_Subjects_Post_Requirement as gsl ON spor.student_post_requirements_id = gsl.student_post_requirements_id ".$where." ");
											
					
							
									if(mysqli_num_rows($sql2)>0)
									{
										$requirement_sql = $sql2;
										
									}
									else
									{
										$resultData = array('Status' => false, 'Message' => 'No Search Result.');
										
									}
						}
						
						
						
						
								$Output = array();
							
								while($requirement_sql_Data = mysqli_fetch_assoc($requirement_sql))	
								{
									
									
										$Output[] = $requirement_sql_Data;
									
									
								}	
						
						
							if(!empty($Output))
							{
							
								$resultData = array('Status' => true, 'Filter_Data' => $Output);
							}	
							else
							{
								$resultData = array('Status' => false, 'message' => 'No Result found. Insert right search keyword.');
							}
						
						
						
							}
						else{
							
							$resultData = array('Status' => false, 'message' => 'No Result found.');
							
						}
						
						
				
					}
					
					
					echo json_encode($resultData);
					
					
					
					
					
				
					
?>