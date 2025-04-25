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
			$arrayV3 = array();  
			
		//	print_r($array);
			
			// Extracting row by row
			foreach($array as $row => $value) 
			{
				
				//print_r($row);
			 if($row == 'Levels_search')
			 {
				foreach($value as $row2 => $value2) 
				{
					
					if($value2 != "" )
					{	
						$arrayV2[] = "('".$value2."')";				
					}	
				}
				
			 }
			 
				 
				 
				
			}
			
			
			
					
					if(empty($arrayV2) && empty($array['student_sujects']))
					{
						
						$resultData = array('Status' => false, 'Message' => 'Please Select Levels Or Subjects.');
						
					}
					else
					{	
				
				
	
				
				
				
						if(!empty($arrayV2))
						{
							$Levels_search_array = implode(', ', $arrayV2);
						}
						else{
							//$Levels_search_array = "''";
						}
						
						
						
						
						
						
					
						
											
						$cond = '';
						$cond2 = '';
						
						// Extract Levels and create conditions
						if (!empty($array['Levels_search'])) {
							$levelsArray = [];
							foreach ($array['Levels_search'] as $value) {
								if (!empty($value)) {
									// Sanitize each level value
									$levelsArray[] = "'" . mysqli_real_escape_string($conn, $value) . "'";
								}
							}
						
							if (!empty($levelsArray)) {
								$Levels_search_array = implode(', ', $levelsArray);
								$cond = " AND tbl_Student_Level_Grade_Subjects_Post_Requirement.Level IN($Levels_search_array)";
							}
						}
						
						
						
						
						
					// Map for specific subjects (like "Science") to related terms
					$subjectMappings = [
						'Science' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Computer' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Physics' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Chemistry' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Physics H1' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Physics H2' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Physics H3' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Physics Engineering' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Physics SL' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Physics HL' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Pure Physics' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Science Chemistry' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Pure Chemistry' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Chemistry H1' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Chemistry H2' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Chemistry H3' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Chemistry Engineering' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Chemistry SL' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Chemistry HL' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Biology' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Biology H1' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Biology H2' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Biology H3' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Biology SL' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Biology HL' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Science Biology' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Pure Biology' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Mechanics' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Science Foundation' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Java' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'JavaScript' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Python' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						 'C' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						 'C++' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						 'C#' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						 'HTML' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						 'CSS' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'SQL' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'PERL' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'PHP' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'App Development' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Website Development' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Computer Science SL' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Computer Engineering' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Computer Science H1' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Computer Science H2' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						'Electronics' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
						
						'English' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
						'IELTS' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
						'Theory of Knowledge TOK' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
						'TOEFL' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
						'Project Work PW' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
						'General Paper GP' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
						'Literature' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
						
						'Math' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
						'Mathematics' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
						'Mathematics H1' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
						'Mathematics H2' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
						'Mathematics HL' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
						'Mathematics SL' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
						'Statistics' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
						'Mathematics H3' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
						'Further Mathematics' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
						'Additional Math' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
						'Math Foundation' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
						
						
						'Chinese' => ['Chinese', 'Chinese H1', 'Chinese H2', 'Mandarin', 'Higher Chinese'],
						'Chinese H1' => ['Chinese', 'Chinese H1', 'Chinese H2', 'Mandarin', 'Higher Chinese'],
						'Chinese H2' => ['Chinese', 'Chinese H1', 'Chinese H2', 'Mandarin', 'Higher Chinese'],
						'Mandarin' => ['Chinese', 'Chinese H1', 'Chinese H2', 'Mandarin', 'Higher Chinese'],
						'Higher Chinese' => ['Chinese', 'Chinese H1', 'Chinese H2', 'Mandarin', 'Higher Chinese'],
						
						'Economics' => ['Economics', 'Economics H1', 'Economics H2', 'Mandarin'],
						'Economics H1' => ['Economics', 'Economics H1', 'Economics H2', 'Mandarin'],
						'Economics H2' => ['Economics', 'Economics H1', 'Economics H2', 'Mandarin'],
						'Mandarin' => ['Economics', 'Economics H1', 'Economics H2', 'Mandarin']
					];
						
										
										
						
						// Create conditions for subjects
						if (!empty($array['student_sujects'])) {
							$subjectConditions = [];
						
							foreach ($array['student_sujects'] as $subject) {
								if (array_key_exists($subject, $subjectMappings)) {
									// Create condition for mapped subjects
									foreach ($subjectMappings[$subject] as $mappedSubject) {
										$subjectConditions[] = "tbl_Student_Subjects_Post_Requirement.ALL_Subjects = '" . mysqli_real_escape_string($conn, $mappedSubject) . "'";
									}
								} else {
									// If no mapping, use the subject directly
									$subjectConditions[] = "tbl_Student_Subjects_Post_Requirement.ALL_Subjects = '" . mysqli_real_escape_string($conn, $subject) . "'";
								}
							}
						
							if (!empty($subjectConditions)) {
								$cond2 = " AND (" . implode(" OR ", $subjectConditions) . ")";
							}
						}
						



						



						// Construct the query
						 $sqlQ2 = "SELECT DISTINCT 
										tbl_Student_Subjects_Post_Requirement.ALL_Subjects, 
										student_post_requirements.student_post_requirements_id, 
										student_post_requirements.logged_in_user_id,
										student_post_requirements.student_tution_type,
										student_post_requirements.student_postal_code,
										student_post_requirements.student_lat,
										student_post_requirements.student_long,
										student_post_requirements.student_postal_address,
										student_post_requirements.tutor_duration_weeks,
										student_post_requirements.tutor_duration_hours,
										student_post_requirements.tutor_tution_fees,
										student_post_requirements.tutor_tution_schedule_time,
										student_post_requirements.tutor_tution_offer_amount_type,
										student_post_requirements.tutor_tution_offer_amount,
										student_post_requirements.amount_negotiate_by_tutor,
										student_post_requirements.negotiate_by_tutor_amount_type,
										student_post_requirements.amount_negotiate_by_student,
										student_post_requirements.negotiate_by_student_amount_type,
										student_post_requirements.booked_date,
										student_post_requirements.post_updated_date,
										student_post_requirements.total_days_for_expire_post,
										student_post_requirements.post_expire_status,
										student_post_requirements.post_delist_status,
										student_post_requirements.tutor_booking_status,
										student_post_requirements.offer_status,
										student_post_requirements.student_offer_date,
										student_post_requirements.student_offer_time,
										student_post_requirements.student_date_time_offer_confirmation,
										student_post_requirements.tutor_accept_date_time_status,
										student_post_requirements.No_of_Students,
										student_post_requirements.update_date_time,
										tbl_Student_Level_Grade_Subjects_Post_Requirement.Level, 
										tbl_Student_Level_Grade_Subjects_Post_Requirement.Grade
										
									FROM student_post_requirements 
									INNER JOIN tbl_Student_Level_Grade_Subjects_Post_Requirement 
										ON student_post_requirements.student_post_requirements_id = tbl_Student_Level_Grade_Subjects_Post_Requirement.student_post_requirements_id 
									INNER JOIN tbl_Student_Subjects_Post_Requirement 
										ON tbl_Student_Level_Grade_Subjects_Post_Requirement.student_post_requirements_id = tbl_Student_Subjects_Post_Requirement.student_post_requirements_id 
									WHERE 1=1 $cond $cond2 group by student_post_requirements.student_post_requirements_id
									ORDER BY student_post_requirements.student_post_requirements_id DESC";


////group by student_post_requirements_id
						
						// Execute the query
						$sql2 = $conn->query($sqlQ2);
						
						// Handle results here



				//echo $aa;							
						
					
								
							//echo mysqli_num_rows($sql2);
											
								if(mysqli_num_rows($sql2)>0)
								{

									$requirement_sql = $sql2;
									
									
								
								
										$Output = array();
										$Response = array();
									
										while($tutor_result = mysqli_fetch_assoc($requirement_sql))
										{
											$post_requirements_student_subjects = array();
											$Tutor_Qualification  = array();
											$Tutor_Schedule   = array();
											$Tutor_slot_time = array();
											
											
											
											
											
											//$ss_query = $conn->query("SELECT * FROM tbl_Student_Subjects_Post_Requirement WHERE student_post_requirements_id = '" . $tutor_result['student_post_requirements_id'] . "'");


											$ss_query = $conn->query("SELECT * FROM tbl_Student_Level_Grade_Subjects_Post_Requirement WHERE student_post_requirements_id = '" . $tutor_result['student_post_requirements_id'] . "'");


											while ($student_subject_res = mysqli_fetch_array($ss_query)) 
											{

													//// If stream available
													if($student_subject_res['Level']=="Secondary")
													{
													
														$Streams_array = array();

														// Fetch streams for the student post requirements
														$get_stream_sql = $conn->query("SELECT * FROM student_post_requirements_streams WHERE student_post_requirements_id = '" . $tutor_result['student_post_requirements_id'] . "'");

														while ($get_streams = mysqli_fetch_array($get_stream_sql)) {
															$Streams_array[] = $get_streams['student_post_requirements_streams'];
														}

													}
													else{
														$Streams_array = "";
													}	
														
														
														
														
													if(empty($array['student_sujects']) && !empty($array['Levels_search']))
													{

														///Level search
															
														$wordsArray2 = $array['Levels_search'];
														$word2 = $student_subject_res['Level'];

														if (in_array(strtolower($word2), array_map('strtolower', $wordsArray2))) {
															 $Find_Level = $word2;
														}

														
														
														$Level_show = mysqli_fetch_array($conn->query("SELECT Level FROM tbl_Student_Level_Grade_Subjects_Post_Requirement WHERE student_post_requirements_id = '".$student_subject_res['student_post_requirements_id']."' "));
															
															//if($word2 == $Find_Level)
															//{
																
																
																
														
															$post_requirements_student_subjects[] = array(
																		'Level_Grade_Subjects_Post_Requirement_id' => $student_subject_res['Level_Grade_Subjects_Post_Requirement_id'],
																		'ID' => $student_subject_res['ID'],
																		'Level' => $Level_show['Level'],
																		'Grade' => $student_subject_res['Grade'],
																		'ALL_Subjects' => $student_subject_res['ALL_Subjects'],
																		'student_post_requirements_id' => $student_subject_res['student_post_requirements_id'],
																		'Streams' => $Streams_array
																	);

															//}

														

													}
														
												
												

														if($student_subject_res['ALL_Subjects'] !="" && empty($array['Levels_search']))
														{

														
														 $string = $student_subject_res['ALL_Subjects'];
														 $wordsArray = $array['student_sujects'];
														 
														 

														$found = false;
														//foreach($wordsArray as $word) {
															
														//	if(str_contains($string, $word)) {
																$found = true;
																//echo "The word '$word' was found in the string.<br>";
															$subject_show = mysqli_fetch_array($conn->query("SELECT ALL_Subjects FROM tbl_Student_Level_Grade_Subjects_Post_Requirement WHERE student_post_requirements_id = '".$student_subject_res['student_post_requirements_id']."' "));
															

															$post_requirements_student_subjects[] = array(
																		'Level_Grade_Subjects_Post_Requirement_id' => $student_subject_res['Level_Grade_Subjects_Post_Requirement_id'],
																		'ID' => $student_subject_res['ID'],
																		'Level' => $student_subject_res['Level'],
																		'Grade' => $student_subject_res['Grade'],
																		'ALL_Subjects' => $subject_show['ALL_Subjects'],
																		'student_post_requirements_id' => $student_subject_res['student_post_requirements_id'],
																		'Streams' => $Streams_array
																	);

														//}	


													//}

														
														

													}





													if($student_subject_res['ALL_Subjects'] !="" && !empty($array['Levels_search']))
													{
														

														///Level search
															
														$wordsArray2 = $array['Levels_search'];
														$word2 = $student_subject_res['Level'];

														if (in_array(strtolower($word2), array_map('strtolower', $wordsArray2))) {
															 $Find_Level = $word2;
														} 

														
														//echo $Find_Level;

														
														$string = $student_subject_res['ALL_Subjects'];
														$wordsArray = $array['student_sujects'];

														$found = false;
														//foreach ($wordsArray as $word) {
															//if (str_contains($string, $word)) {
																$found = true;
																//echo "The word '$word' was found in the string.<br>";
															
															$subject_show = mysqli_fetch_array($conn->query("SELECT ALL_Subjects FROM tbl_Student_Level_Grade_Subjects_Post_Requirement WHERE student_post_requirements_id = '".$student_subject_res['student_post_requirements_id']."' "));
																
															
															if($word2 == $Find_Level)
															{	

															$post_requirements_student_subjects[] = array(
																		'Level_Grade_Subjects_Post_Requirement_id' => $student_subject_res['Level_Grade_Subjects_Post_Requirement_id'],
																		'ID' => $student_subject_res['ID'],
																		'Level' => $word2,
																		'Grade' => $student_subject_res['Grade'],
																		'ALL_Subjects' => $subject_show['ALL_Subjects'],
																		'student_post_requirements_id' => $student_subject_res['student_post_requirements_id'],
																		'Streams' => $Streams_array
																	);
															}		

														//}	




													//}

													


													}

													




												
											
												/**	
													
													// Non-secondary level handling
													if ($student_subject_res['Level'] != "Secondary" && !empty($student_subject_res['ALL_Subjects'])) 
													{
														$post_requirements_student_subjects[] = array(
															'Level_Grade_Subjects_Post_Requirement_id' => $student_subject_res['Level_Grade_Subjects_Post_Requirement_id'],
															'ID' => $student_subject_res['ID'],
															'Level' => $student_subject_res['Level'],
															'Grade' => $student_subject_res['Grade'],
															'ALL_Subjects' => $student_subject_res['ALL_Subjects'],
															'student_post_requirements_id' => $student_subject_res['student_post_requirements_id']
														);
													}

													// Secondary level handling
													if ($student_subject_res['Level'] == "Secondary" && !empty($student_subject_res['ALL_Subjects'])) 
													{

														$Streams_array = array();

														// Fetch streams for the student post requirements
														$get_stream_sql = $conn->query("SELECT * FROM student_post_requirements_streams WHERE student_post_requirements_id = '" . $tutor_result['student_post_requirements_id'] . "'");

														while ($get_streams = mysqli_fetch_array($get_stream_sql)) {
															$Streams_array[] = $get_streams['student_post_requirements_streams'];
														}

														$post_requirements_student_subjects[] = array(
															'Level_Grade_Subjects_Post_Requirement_id' => $student_subject_res['Level_Grade_Subjects_Post_Requirement_id'],
															'ID' => $student_subject_res['ID'],
															'Level' => $student_subject_res['Level'],
															'Grade' => $student_subject_res['Grade'],
															'ALL_Subjects' => $student_subject_res['ALL_Subjects'],
															'student_post_requirements_id' => $student_subject_res['student_post_requirements_id'],
															'Streams' => $Streams_array
														);
													}
													
													
													
												**/	
													
												
											}
											
											
											
											
											
											
											/// for Tutor_Qualification
											$TQ_query = $conn->query("select * from post_requirements_TutorQualification where student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
											
											while($Tutor_Qualification_res = mysqli_fetch_array($TQ_query))
											{
												if($Tutor_Qualification_res['Tutor_Qualification'] != "")
												{
													$Tutor_Qualification[] = array(
																				 'Tutor_Qualification_id' => $Tutor_Qualification_res['Tutor_Qualification_id'],
																				 'Tutor_Qualification' => $Tutor_Qualification_res['Tutor_Qualification']
																				 );
												}
											}
											
											/// For Tutor Schedule and Slot Times
											$TS_query = $conn->query("select * from tbl_Tutor_Schedules_Slot_Time_post_requirement where student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
											
											while($Tutor_Schedule_res = mysqli_fetch_array($TS_query))
											{
												if($Tutor_Schedule_res['tutor_schedule'] != "")
												{
													$Tutor_Schedule[] = array(
																				 'post_requirement_Tutor_Schedules_Slot_Time_id' => $Tutor_Schedule_res['post_requirement_Tutor_Schedules_Slot_Time_id'],
																				 'tutor_schedule' => $Tutor_Schedule_res['tutor_schedule'],
																				  'slot_times' => $Tutor_Schedule_res['slot_times'],
																				   'student_post_requirements_id' => $Tutor_Schedule_res['student_post_requirements_id']
																				 );
												}
											}
											
											
											$student_name_sql = mysqli_fetch_array($conn->query("SELECT first_name,last_name FROM user_info WHERE user_id = '".$tutor_result['logged_in_user_id']."' "));
											
											
											
											//////
					
											$expired_post_sql = $conn->query("SELECT * FROM student_post_requirements WHERE student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
											
											$total_days_for_expire_post_val = mysqli_fetch_array($expired_post_sql);
											
											 $total_days_for_expire_post = $total_days_for_expire_post_val['total_days_for_expire_post'];
											
											if($total_days_for_expire_post<=1)
											{
												$total_days_expired_post = $total_days_for_expire_post.' day left';
											}
											if($total_days_for_expire_post > 1)
											{
												$total_days_expired_post = $total_days_for_expire_post.' days left';
											}
											/////
											
											
											
											
											if($tutor_result['logged_in_user_id'] !="")
											{
												$favS = $conn->query("SELECT * from student_post_requirements_Favourite_Assigned WHERE student_login_id = '".$tutor_result['logged_in_user_id']."' and student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' ");
												
												if(mysqli_num_rows($favS)>0)
												{
												
												$check = mysqli_fetch_array($favS);
												
													if($check['favourite']=="" )
													{
														$Favourite = 'false';
														$tutor_id = "";
													}
													else
													{
														if($check['favourite']=="false")
														{
															$Favourite = 'false';
															$tutor_id = $check['tutor_login_id'];
														}
														else
														{
															$Favourite = 'true';
															$tutor_id = $check['tutor_login_id'];
														}
													}	
												
											}
											else
											{
												$Favourite = 'false';
											}						
												
											}
											else{
													$Favourite = 'false';
													$tutor_id = "";
											}
											
											
											
											
											$No_of_applicant_sql = $conn->query("SELECT student_post_requirements_id FROM student_post_requirements_Applied_by_tutor WHERE student_post_requirements_id = '".$tutor_result['student_post_requirements_id']."' and apply_tag = 'true' ");
					
											$No_of_applicants = mysqli_num_rows($No_of_applicant_sql);
											

											//if(!empty($post_requirements_student_subjects))
											//{
												
												
												
												
												
											// Initialize an empty array to keep track of encountered IDs
											$seen_ids = [];
											$post_requirements_student_subjects_arr = [];

											if (!empty($post_requirements_student_subjects)) {
												foreach ($post_requirements_student_subjects as $item) {
													$id = $item['Level_Grade_Subjects_Post_Requirement_id'];

													// Check if this ID has already been encountered
													if (!in_array($id, $seen_ids)) {
														// Add the ID to the list to prevent future duplicates
														$seen_ids[] = $id;

														// Add the current item to the new array
														$post_requirements_student_subjects_arr[] = $item;
													}
												}
											}	
												
												
												
												
												
												
												
                                          
											$Response[] = array(
																'student_post_requirements_id' => $tutor_result['student_post_requirements_id'],
																'student_id' => $tutor_result['logged_in_user_id'],
                                              					'student_first_name' => $student_name_sql['first_name'],
																'student_last_name' => $student_name_sql['last_name'],
																'student_lat' => $tutor_result['student_lat'],
																'student_long' => $tutor_result['student_long'],
																'student_level' => $tutor_result['student_level'],
																'student_grade' => $tutor_result['student_grade'],
																'student_tution_type' => $tutor_result['student_tution_type'],
																'student_postal_code' => $tutor_result['student_postal_code'],
																'student_postal_address' => $tutor_result['student_postal_address'],
																'applicant' => $No_of_applicants,
																'total_days_left_for_expired_post' => $total_days_expired_post,
																'No_of_Students' => $tutor_result['No_of_Students'],
																
																'tutor_booking_status' => $tutor_result['tutor_booking_status'],
																'offer_status' => $tutor_result['offer_status'],
																'student_offer_date' => $tutor_result['student_offer_date'],
																'student_offer_time' => $tutor_result['student_offer_time'],
																'tutor_offer_date' => $tutor_result['tutor_offer_date'],
																'tutor_offer_time' => $tutor_result['tutor_offer_time'],
																'tutor_accept_date_time_status' => $tutor_result['tutor_accept_date_time_status'],
																'student_date_time_offer_confirmation' => $tutor_result['student_date_time_offer_confirmation'],
																'tutor_duration_weeks' => $tutor_result['tutor_duration_weeks'],
																'tutor_duration_hours' => $tutor_result['tutor_duration_hours'],
																'tutor_tution_fees' => $tutor_result['tutor_tution_fees'],
																'tutor_tution_schedule_time' => $tutor_result['tutor_tution_schedule_time'],
																'tutor_tution_offer_amount_type' => $tutor_result['tutor_tution_offer_amount_type'],
																'tutor_tution_offer_amount' => $tutor_result['tutor_tution_offer_amount'],
																'amount_negotiate_by_tutor' => $tutor_result['amount_negotiate_by_tutor'],
																'negotiate_by_tutor_amount_type' => $tutor_result['negotiate_by_tutor_amount_type'],
																'amount_negotiate_by_student' => $tutor_result['amount_negotiate_by_student'],
																'negotiate_by_student_amount_type' => $tutor_result['negotiate_by_student_amount_type'],
																'booked_date' => $tutor_result['booked_date'],
																'tutor_booking_status' => $tutor_result['tutor_booking_status'],
																'offer_status' => $tutor_result['offer_status'],
																'tutor_id' => $tutor_id,
																'Favourite' => $Favourite,
																'student_level_grade_subjects' => $post_requirements_student_subjects_arr,
																'tutor_qualification' => $Tutor_Qualification,
																'tutor_schedule_and_slot_times' => $Tutor_Schedule
																
															 );


											//}
											//else{

											//	$resultData = array('Status' => false, 'message' => 'No Result found.');
											//}



											
											
										}	


										

								
								
									if(!empty($Response))
									{
									
										$resultData = array('Status' => true, 'Filter_Data' => $Response);
									}	
									else
									{
										$resultData = array('Status' => false, 'message' => 'No Result found. Insert right search keyword.');
									}
								
						
						
							}
						else{
							
							$resultData = array('Status' => false, 'message' => 'No Result found.', 'Filter_Data' => []);
							
						}
						
						
				
					}
					
					
					echo json_encode($resultData);
					
					
					
					
					
				
					
?>