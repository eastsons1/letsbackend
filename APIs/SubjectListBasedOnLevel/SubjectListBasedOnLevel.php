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
	
				$subject_array = array();
				
				
				/// if Primary
				
				if($_POST['Level']=="Primary")
				{
					$subject_array = array();
					
					
		
				
								$English = array(
												  'id'=> '1',
												  'subjects_name' => 'English'
												);
								$EnglishF = array(
												  'id'=> '9',
												  'subjects_name' => 'English Foundation'
												);	
								$Math = array(
												  'id'=> '7',
												  'subjects_name' => 'Math'
												);
								$Math_Foundation = array(
												  'id'=> '8',
												  'subjects_name' => 'Math Foundation'
												);
								$Science = array(
												  'id'=> '10',
												  'subjects_name' => 'Science'
												);
								$Science_Foundation = array(
												  'id'=> '11',
												  'subjects_name' => 'Science Foundation'
												);
								$Chinese = array(
												  'id'=> '3',
												  'subjects_name' => 'Chinese'
												);
								$Higher_Chinese = array(
												  'id'=> '19',
												  'subjects_name' => 'Higher Chinese'
												);
								$Malay = array(
												  'id'=> '4',
												  'subjects_name' => 'Malay'
												);
								$Higher_Malay = array(
												  'id'=> '126',
												  'subjects_name' => 'Higher Malay'
												);
								$Tamil = array(
												  'id'=> '5',
												  'subjects_name' => 'Tamil'
												);	
								$Higher_Tamil = array(
												  'id'=> '127',
												  'subjects_name' => 'Higher Tamil'
												);
								$Hindi = array(
												  'id'=> '6',
												  'subjects_name' => 'Hindi'
												);					
												

						$subject_array = array($English,$EnglishF,$Math,$Math_Foundation,$Science,$Science_Foundation,$Chinese,$Higher_Chinese,$Malay,$Higher_Malay,$Tamil,$Higher_Tamil,$Hindi);
					
					
					
				}
				
				
				/// if preschool
				
				if($_POST['Level']=="AEIS")
				{
				
					$subject_sql = $conn->query("SELECT * FROM subjects WHERE subjects_name = 'English' or subjects_name = 'Math'  ");
					
					while($subject = mysqli_fetch_assoc($subject_sql))
					{
						$subject_array[] = $subject;
					}
					
				}
				
				/// if preschool
				
				if($_POST['Level']=="Pre-School")
				{
				
					$subject_sql = $conn->query("SELECT * FROM subjects WHERE subjects_name = 'English' or subjects_name = 'Math' or subjects_name = 'Chinese' or subjects_name = 'Malay'  or subjects_name = 'Tamil'  or subjects_name = 'Hindi' ");
					
					while($subject = mysqli_fetch_assoc($subject_sql))
					{
						$subject_array[] = $subject;
					}
					
				}
				
				
				
				/// if Secondary
				
				/**
				if($_POST['Level']=="Secondary")
				{
				
					$subject_sql = $conn->query("SELECT * FROM subjects WHERE subjects_name = 'English' or subjects_name = 'Math' or subjects_name = 'Additional Math' or subjects_name = 'Science' or subjects_name = 'Science Physics' or subjects_name = 'Science Chemistry' or subjects_name = 'Pure Chemistry' or subjects_name = 'Science Biology' or subjects_name = 'Pure Biology' or subjects_name = 'Chinese' or subjects_name = 'Higher Chinese' or subjects_name = 'Principles of Accounts (POA)' or subjects_name = 'Literature' or subjects_name = 'History'  or subjects_name = 'Combined History'  or subjects_name = 'Geography' or subjects_name = 'Combined Geography' or subjects_name = 'Social Studies' or subjects_name = 'Design & Technology (D & T)' or subjects_name = 'Malay' or subjects_name = 'Higher Malay' or subjects_name = 'Tamil' or subjects_name = 'Higher Tamil' or subjects_name = 'Business Studies' or subjects_name = 'Economics' ");
					
					while($subject = mysqli_fetch_assoc($subject_sql))
					{
						$subject_array[] = $subject;
					}
					
				}
				**/
				
				
				
				
				/// if Secondary
				
				if($_POST['Level']=="Secondary")
				{
					$subject_array = array();
					
					
		
				
								$English = array(
												  'id'=> '1',
												  'subjects_name' => 'English'
												);
									$Math = array(
												  'id'=> '7',
												  'subjects_name' => 'Math'
												);
												
						$Additional_Math = array(
												  'id'=> '12',
												  'subjects_name' => 'Additional Math'
												);	

								$Science = array(
												  'id'=> '10',
												  'subjects_name' => 'Science'
												);

						$Science_Physics = array(
												  'id'=> '13',
												  'subjects_name' => 'Science Physics'
												);

							$Pure_Physics = array(
												  'id'=> '14',
												  'subjects_name' => 'Pure Physics'
												);

					  $Science_Chemistry = array(
												  'id'=> '15',
												  'subjects_name' => 'Science Chemistry'
												);

						$Pure_Chemistry = array(
												  'id'=> '16',
												  'subjects_name' => 'Pure Chemistry'
												);		
						
						$Science_Biology = array(
												  'id'=> '17',
												  'subjects_name' => 'Science Biology'
												);

							$Pure_Biology = array(
												  'id'=> '18',
												  'subjects_name' => 'Pure Biology'
												);								
												
							$Chinese = array(
											  'id'=> '3',
											  'subjects_name' => 'Chinese'
											);	

					$Higher_Chinese = array(
											  'id'=> '19',
											  'subjects_name' => 'Higher Chinese'
											);	

			 $Principles_of_Accounts = array(
											  'id'=> '20',
											  'subjects_name' => 'Principles of Accounts (POA)'
											);					
												
						$Literature = array(
											  'id'=> '21',
											  'subjects_name' => 'Literature'
											);									
						
						$History = array(
											  'id'=> '119',
											  'subjects_name' => 'History'
											);

						$Combined_History = array(
											  'id'=> '142',
											  'subjects_name' => 'Combined History'
											);

						$Geography = array(
											  'id'=> '118',
											  'subjects_name' => 'Geography'
											);

						$Combined_Geography = array(
											  'id'=> '143',
											  'subjects_name' => 'Combined Geography'
											);

						$Social_Studies = array(
											  'id'=> '144',
											  'subjects_name' => 'Social Studies'
											);

						$Design_and_Technology = array(
											  'id'=> '122',
											  'subjects_name' => 'Design & Technology (D & T)'
											);

						$Malay = array(
											  'id'=> '4',
											  'subjects_name' => 'Malay'
											);

						$Higher_Malay = array(
											  'id'=> '126',
											  'subjects_name' => 'Higher Malay'
											);

							$Tamil = array(
											  'id'=> '5',
											  'subjects_name' => 'Tamil'
											);	

						$Higher_Tamil = array(
											  'id'=> '127',
											  'subjects_name' => 'Higher Tamil'
											);						

					$Business_Studies = array(
											  'id'=> '113',
											  'subjects_name' => 'Business Studies'
											);
											
					$Economics = array(
											  'id'=> '117',
											  'subjects_name' => 'Economics'
											);						

						
						
												
								

				$subject_array = array($English,$Math,$Additional_Math,$Science,$Science_Physics,$Pure_Physics,$Science_Chemistry,$Pure_Chemistry,$Science_Biology,$Pure_Biology,$Chinese,$Higher_Chinese,$Principles_of_Accounts,$Literature,$History,$Combined_History,$Geography,$Combined_Geography,$Social_Studies,$Design_and_Technology,$Malay,$Higher_Malay,$Tamil,$Higher_Tamil,$Business_Studies,$Economics);
					
					
					
				}
				
				
				
				
				
				
				
				
				
				/// if JC/Pre-U
				
				if($_POST['Level']=="JC/Pre-U")
				{
				
					$subject_sql = $conn->query("SELECT * FROM subjects WHERE subjects_name = 'General Paper GP' or subjects_name = 'Project Work PW' or subjects_name = 'Theory of Knowledge (TOK)' or subjects_name = 'Mathematics H1' or subjects_name = 'Mathematics H2' or subjects_name = 'Further Mathematics' or subjects_name = 'Physics H1' or subjects_name = 'Physics H2' or subjects_name = 'Chemistry H1' or subjects_name = 'Chemistry H2' or subjects_name = 'Biology H1' or subjects_name = 'Biology H2' or subjects_name = 'Economics H1' or subjects_name = 'Economics H2' or subjects_name = 'Chinese H1' or subjects_name = 'Chinese H2' or subjects_name = 'History H1' or subjects_name = 'History H2' or subjects_name = 'Geography H1' or subjects_name = 'Geography H2' or subjects_name = 'Literature H1' or subjects_name = 'Literature H2' or subjects_name = 'Computer Science H1' or subjects_name = 'Computer Science H2' or subjects_name = 'Malay H1' or subjects_name = 'Malay H2' or subjects_name = 'Tamil H1' or subjects_name = 'Tamil H2' or subjects_name = 'Management of Business' or subjects_name = 'Accounting Principles' or subjects_name = 'Mathematics H3' or subjects_name = 'Physics H3' or subjects_name = 'Chemistry H3' or subjects_name = 'Biology H3' or subjects_name = 'Economics H3' ");
					
					while($subject = mysqli_fetch_assoc($subject_sql))
					{
						$subject_array[] = $subject;
					}
					
				}
				
				/// if IB (Diploma)
				
				if($_POST['Level']=="IB (Diploma)")
				{
				
					$subject_sql = $conn->query("SELECT * FROM  subjects WHERE subjects_name = 'English HL' or subjects_name = 'English SL' or subjects_name = 'Theory of Knowledge (TOK)' or subjects_name = 'Mathematics HL' or subjects_name = 'Mathematics SL' or subjects_name = 'Physics HL' or subjects_name = 'Physics SL' or subjects_name = 'Biology HL' or subjects_name = 'Biology SL' or subjects_name = 'Chemistry HL' or subjects_name = 'Chemistry SL' or subjects_name = 'Economics HL' or subjects_name = 'Economics SL' or subjects_name = 'Chinese HL' or subjects_name = 'Chinese SL' or subjects_name = 'Computer Science SL' or subjects_name = 'Geography HL' or subjects_name = 'Geography SL' or subjects_name = 'History HL' or subjects_name = 'History SL' or subjects_name = 'Literature HL' or subjects_name = 'Literature SL' or subjects_name = 'Management of Business HL' or subjects_name = 'Management of Business SL' ");
					
					while($subject = mysqli_fetch_assoc($subject_sql))
					{
						$subject_array[] = $subject;
					}
					
				}
				
				
				/// if International School (Grade 1 to 6)
				
				if($_POST['Level']=="Grade 1 to 6")
				{
					$subject_sql = $conn->query("SELECT * FROM subjects WHERE subjects_name = 'English' or subjects_name = 'Mathematics'  or subjects_name = 'Science'  or subjects_name = 'Chinese' ");
					
					while($subject = mysqli_fetch_assoc($subject_sql))
					{
						$subject_array[] = $subject;
					}
					
				}
				
				
				/// if International School (Grade 7 to 10)
				
				if($_POST['Level']=="Grade 7 to 10")
				{
					$subject_sql = $conn->query("SELECT * FROM subjects WHERE subjects_name = 'English' or subjects_name = 'Mathematics' or subjects_name = 'Science' or subjects_name = 'Biology' or subjects_name = 'Chemistry' or subjects_name = 'Physics' or subjects_name = 'Economics' or subjects_name = 'Literature' or subjects_name = 'Geography' or subjects_name = 'History' or subjects_name = 'Chinese' or subjects_name = 'Computer Science' or subjects_name = 'Individuals & Societies' or subjects_name = 'Design & Technology (D & T)' or subjects_name = 'Accounting' or subjects_name = 'Business Management' or subjects_name = 'Theory of Knowledge (TOK)' or subjects_name = 'Global Perspectives' or subjects_name = 'Information & Communication Technology (ICT)' ");
					
					while($subject = mysqli_fetch_assoc($subject_sql))
					{
						$subject_array[] = $subject;
					}
					
				}
				
				
				/// if International School (Grade 11 to 13)
				
				if($_POST['Level']=="Grade 11 to 13")
				{
					$subject_sql = $conn->query("SELECT * FROM subjects WHERE subjects_name = 'English' or subjects_name = 'Mathematics' or subjects_name = 'Science' or subjects_name = 'Biology' or subjects_name = 'Chemistry' or subjects_name = 'Physics' or subjects_name = 'Economics' or subjects_name = 'Literature' or subjects_name = 'Geography' or subjects_name = 'History' or subjects_name = 'Chinese' or subjects_name = 'Computer Science' or subjects_name = 'Individuals & Societies' or subjects_name = 'Design & Technology (D & T)' or subjects_name = 'Accounting' or subjects_name = 'Business Management' or subjects_name = 'Theory of Knowledge (TOK)' or subjects_name = 'Global Perspectives' or subjects_name = 'Information & Communication Technology (ICT)' ");
					
					while($subject = mysqli_fetch_assoc($subject_sql))
					{
						$subject_array[] = $subject;
					}
					
				}
				
				/// if ITE
				
				if($_POST['Level']=="ITE")
				{
					$subject_sql = $conn->query("SELECT * FROM subjects WHERE subjects_name = 'Math' or subjects_name = 'Math Engineering' or subjects_name = 'Math Finance' or subjects_name = 'Statistics' or subjects_name = 'Physics' or subjects_name = 'Chemistry' or subjects_name = 'Biology' or subjects_name = 'Physics Engineering' or subjects_name = 'Chemistry Engineering' or subjects_name = 'Computer Engineering' or subjects_name = 'Electronics' or subjects_name = 'Mechanics' or subjects_name = 'Mechanics Fluid' or subjects_name = 'Electronics Digital' or subjects_name = 'Computing' or subjects_name = 'Thermodynamics' or subjects_name = 'Business Studies' or subjects_name = 'Accounting' or subjects_name = 'Legal Studies' or subjects_name = 'English' or subjects_name = 'English Business' ");
					
					while($subject = mysqli_fetch_assoc($subject_sql))
					{
						$subject_array[] = $subject;
					}
					
				}
				
				
				/// if Polytechnic
				
				if($_POST['Level']=="Polytechnic")
				{
					$subject_sql = $conn->query("SELECT * FROM subjects WHERE subjects_name = 'Math' or subjects_name = 'Math Engineering' or subjects_name = 'Math Finance' or subjects_name = 'Statistics' or subjects_name = 'Physics' or subjects_name = 'Chemistry' or subjects_name = 'Biology' or subjects_name = 'Physics Engineering' or subjects_name = 'Chemistry Engineering' or subjects_name = 'Computer Engineering' or subjects_name = 'Electronics' or subjects_name = 'Mechanics' or subjects_name = 'Mechanics Fluid' or subjects_name = 'Electronics Digital' or subjects_name = 'Computing' or subjects_name = 'Thermodynamics' or subjects_name = 'Business Studies' or subjects_name = 'Accounting' or subjects_name = 'Legal Studies' or subjects_name = 'English' or subjects_name = 'English Business' ");
					
					while($subject = mysqli_fetch_assoc($subject_sql))
					{
						$subject_array[] = $subject;
					}
					
				}
				
				/// if University
				
				if($_POST['Level']=="University")
				{
					$subject_sql = $conn->query("SELECT * FROM subjects WHERE subjects_name = 'Math' or subjects_name = 'Math Engineering' or subjects_name = 'Math Finance' or subjects_name = 'Statistics' or subjects_name = 'Physics' or subjects_name = 'Chemistry' or subjects_name = 'Biology' or subjects_name = 'Physics Engineering' or subjects_name = 'Chemistry Engineering' or subjects_name = 'Computer Engineering' or subjects_name = 'Electronics' or subjects_name = 'Mechanics' or subjects_name = 'Mechanics Fluid' or subjects_name = 'Electronics Digital' or subjects_name = 'Computing' or subjects_name = 'Thermodynamics' or subjects_name = 'Business Studies' or subjects_name = 'Accounting' or subjects_name = 'Legal Studies' or subjects_name = 'English' or subjects_name = 'English Business' ");
					
					while($subject = mysqli_fetch_assoc($subject_sql))
					{
						$subject_array[] = $subject;
					}
					
				}
				
				/// if Entrance Exams
				
				if($_POST['Level']=="Entrance Exams")
				{
					$subject_sql = $conn->query("SELECT * FROM subjects WHERE subjects_name = 'SAT' or subjects_name = 'MCAT' or subjects_name = 'GMAT' or subjects_name = 'IELTS' or subjects_name = 'TOEFL' ");
					
					while($subject = mysqli_fetch_assoc($subject_sql))
					{
						$subject_array[] = $subject;
					}
					
				}
				
				/// if Foreign Languages
				
				if($_POST['Level']=="Foreign Languages")
				{
					$subject_sql = $conn->query("SELECT * FROM subjects WHERE subjects_name = 'Mandarin' or subjects_name = 'English' or subjects_name = 'Japanese' or subjects_name = 'Korean' or subjects_name = 'French' or subjects_name = 'German' or subjects_name = 'Hindi' or subjects_name = 'Spanish' or subjects_name = 'Italian' or subjects_name = 'Russian' or subjects_name = 'Malay' or subjects_name = 'Tamil' or subjects_name = 'Tagalog' ");
					
					while($subject = mysqli_fetch_assoc($subject_sql))
					{
						$subject_array[] = $subject;
					}
					
				}
				
				
				
				
				
				/// if Foreign Music
				
				if($_POST['Level']=="Music")
				{
					$subject_sql = $conn->query("SELECT * FROM subjects WHERE subjects_name = 'Theory of Music' or subjects_name = 'Piano'  or subjects_name = 'Violin' or subjects_name = 'Flute' or subjects_name = 'Guitar' or subjects_name = 'Saxophone' ");
					
					while($subject = mysqli_fetch_assoc($subject_sql))
					{
						$subject_array[] = $subject;
					}
					
				}
				
				
				
				/// if Foreign AEIS
				
					if($_POST['Level']=="Computer")
					{
						$subject_sql = $conn->query("SELECT * FROM subjects WHERE subjects_name = 'Java' or subjects_name = 'Java Script' or subjects_name = 'Python'  or subjects_name = 'C/C+/C#'  or subjects_name = 'HTML'  or subjects_name = 'CSS' or subjects_name = 'SQL' or subjects_name = 'PERL' or subjects_name = 'PHP' or subjects_name = 'App Development' or subjects_name = 'Website Development' ");
						
						while($subject = mysqli_fetch_assoc($subject_sql))
						{
							$subject_array[] = $subject;
						}
						
					}
					
					
				
				
			
			
			if(!empty($subject_array))
			{
				$resultData = array('status' => true, 'Subject_List' => $subject_array);
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