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
	
		
		  
				
				$grade_array = array();
				
				/// if preschool
				
				if($_POST['Level']=="Pre-School")
				{
					
					
					$grade_sql = $conn->query("SELECT * FROM grade WHERE grade_name = 'N1' or grade_name = 'N2' or grade_name = 'K1' or grade_name = 'K2' ");
					
					while($grade = mysqli_fetch_assoc($grade_sql))
					{
						$grade_array[] = $grade;
					}
					
				}
				
				/// if Primary
				
				if($_POST['Level']=="Primary")
				{
				
					$grade_sql = $conn->query("SELECT * FROM grade WHERE grade_name = 'P1' or grade_name = 'P2' or grade_name = 'P3' or grade_name = 'P4' or grade_name = 'P5' or grade_name = 'P6' ");
					
					while($grade = mysqli_fetch_assoc($grade_sql))
					{
						$grade_array[] = $grade;
					}
					
				}
				
				/// if JC/Pre-U
				
				if($_POST['Level']=="JC/Pre-U")
				{
				
					$grade_sql = $conn->query("SELECT * FROM grade WHERE grade_name = 'JC 1' or grade_name = 'JC 2' or grade_name = 'Pre-U 1' or grade_name = 'Pre-U 2' or grade_name = 'Pre-U 3' ");
					
					while($grade = mysqli_fetch_assoc($grade_sql))
					{
						$grade_array[] = $grade;
					}
					
				}
				
				/// if IB (Diploma)
				
				if($_POST['Level']=="IB (Diploma)")
				{
				
					$grade_sql = $conn->query("SELECT * FROM  grade WHERE grade_name = 'Year 5' or grade_name = 'Year 6' ");
					
					while($grade = mysqli_fetch_assoc($grade_sql))
					{
						$grade_array[] = $grade;
					}
					
				}
				
				
				/// if International School (Grade 1 to 6)
				
				if($_POST['Level']=="Grade 1 to 6")
				{
					$grade_sql = $conn->query("SELECT * FROM grade WHERE grade_name = 'Grade 1' or grade_name = 'Grade 2'  or grade_name = 'Grade 3'  or grade_name = 'Grade 4'  or grade_name = 'Grade 5'  or grade_name = 'Grade 6' ");
					
					while($grade = mysqli_fetch_assoc($grade_sql))
					{
						$grade_array[] = $grade;
					}
					
				}
				
				
				/// if International School (Grade 7 to 10)
				
				if($_POST['Level']=="Grade 7 to 10")
				{
					$grade_sql = $conn->query("SELECT * FROM grade WHERE grade_name = 'Grade 7' or grade_name = 'Grade 8'  or grade_name = 'Grade 9' or grade_name = 'Grade 10' ");
					
					while($grade = mysqli_fetch_assoc($grade_sql))
					{
						$grade_array[] = $grade;
					}
					
				}
				
				
				/// if International School (Grade 11 to 13)
				
				if($_POST['Level']=="Grade 11 to 13")
				{
					$grade_sql = $conn->query("SELECT * FROM grade WHERE grade_name = 'Grade 11' or grade_name = 'Grade 12'  or grade_name = 'Grade 13' ");
					
					while($grade = mysqli_fetch_assoc($grade_sql))
					{
						$grade_array[] = $grade;
					}
					
				}
				
				/// if ITE
				
				if($_POST['Level']=="ITE")
				{
					$grade_sql = $conn->query("SELECT * FROM grade WHERE grade_name = 'Year 1' or grade_name = 'Year 2'  or grade_name = 'Higher NITEC' ");
					
					while($grade = mysqli_fetch_assoc($grade_sql))
					{
						$grade_array[] = $grade;
					}
					
				}
				
				
				/// if Polytechnic
				
				if($_POST['Level']=="Polytechnic")
				{
					$grade_sql = $conn->query("SELECT * FROM grade WHERE grade_name = 'Year 1' or grade_name = 'Year 2'  or grade_name = 'Year 3' ");
					
					while($grade = mysqli_fetch_assoc($grade_sql))
					{
						$grade_array[] = $grade;
					}
					
				}
				
				/// if Polytechnic
				
				if($_POST['Level']=="University")
				{
					$grade_sql = $conn->query("SELECT * FROM grade WHERE grade_name = 'Year 1' or grade_name = 'Year 2'  or grade_name = 'Year 3' or grade_name = 'Year 4' ");
					
					while($grade = mysqli_fetch_assoc($grade_sql))
					{
						$grade_array[] = $grade;
					}
					
				}
				
				/// if Foreign Languages
				
				if($_POST['Level']=="Foreign Languages")
				{
					$grade_sql = $conn->query("SELECT * FROM grade WHERE grade_name = 'Basic' or grade_name = 'Intermediate'  or grade_name = 'Advanced' ");
					
					while($grade = mysqli_fetch_assoc($grade_sql))
					{
						$grade_array[] = $grade;
					}
					
				}
				
				/// if Foreign Music
				
				if($_POST['Level']=="Music")
				{
					$grade_sql = $conn->query("SELECT * FROM grade WHERE grade_name = 'Basic' or grade_name = 'Intermediate'  or grade_name = 'Advanced' ");
					
					while($grade = mysqli_fetch_assoc($grade_sql))
					{
						$grade_array[] = $grade;
					}
					
				}
				
				
				
					/// if Foreign AEIS
					if($_POST['Level']=="AEIS" && $_POST['Admission_level'] == "")
					{
						$grade_sql = $conn->query("SELECT * FROM school_levels WHERE school_level_name = 'Primary' or school_level_name = 'Secondary' ");
							
							while($grade = mysqli_fetch_assoc($grade_sql))
							{
								$grade_array[] = $grade;
							}
					}		
				
					if($_POST['Level']=="AEIS" && $_POST['Admission_level'] == "Primary")
					{
						$grade_sql = $conn->query("SELECT * FROM grade WHERE grade_name = 'P1' or grade_name = 'P2' or grade_name = 'P3'  or grade_name = 'P4'  or grade_name = 'P5' ");
						
						while($grade = mysqli_fetch_assoc($grade_sql))
						{
							$grade_array[] = $grade;
						}
						
					}
					
					
					if($_POST['Level']=="AEIS" && $_POST['Admission_level'] == "Secondary")
					{
						$grade_sql = $conn->query("SELECT * FROM grade WHERE grade_name = 'Sec 1' or grade_name = 'Sec 2' or grade_name = 'Sec 3' ");
						
						while($grade = mysqli_fetch_assoc($grade_sql))
						{
							$grade_array[] = $grade;
						}
						
					}
				
				/// if Secondary
				
				if($_POST['Level']=="Secondary")
				{
					$stream_array = array();
					$merge_array = array();
					
					$grade_sql = $conn->query("SELECT * FROM grade WHERE grade_name = 'Sec 1' or grade_name = 'Sec 2'  or grade_name = 'Sec 3'  or grade_name = 'Sec 4'  or grade_name = 'Sec 5' ");
					
					while($grade = mysqli_fetch_assoc($grade_sql))
					{
						$grade_array2[] = $grade;
					}
					
					$stream_sql = $conn->query("SELECT * FROM stream WHERE stream_name = 'Express' or stream_name = 'NA'  or stream_name = 'IP'  or stream_name = 'NT' ");
					
					while($stream = mysqli_fetch_assoc($stream_sql))
					{
						$stream_array[] = $stream;
					}
					
					$A1 =  array('Grades' => $grade_array2);
					$A2 =  array('Streams' => $stream_array);
					
					$grade_array = array_merge($A1,$A2);
					
				}
				
				
				
				
			
			
			if(!empty($grade_array))
			{
				$resultData = array('status' => true, 'Grade_List' => $grade_array);
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