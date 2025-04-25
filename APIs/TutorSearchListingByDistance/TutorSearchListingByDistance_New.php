<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

// Include your database configuration
require_once("config.php");

header('content-type:application/json');



$data = file_get_contents("php://input");
$array = json_decode($data, true);





// Function to calculate distance
function distance($lat1, $lon1, $lat2, $lon2, $unit) 
{
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}


// Initialize conditions
$conditions = [];
$conditions1 = [];
$conditions2 = [];
$conditions3 = [];
$conditions4 = [];
$conditions5 = [];
$conditions6 = [];

$conditions7 = [];
$conditions8 = [];
$conditions9 = [];
$conditions10 = [];
$conditions11 = [];


$student_lat = $array['student_lat'];
$student_long = $array['student_long'];
$gender = $array['gender'];
$nationality = $array['nationality'];
$qualification = $array['qualification'];
$tutor_status = $array['tutor_status'];
$logged_in_student_id = $array['logged_in_student_id'];



if(!empty($array['student_lat']) && !empty($array['student_long']) && !empty($array['postal_code']) ) 
{


// Loop through the student details
foreach ($array['StudentDetail'] as $student) {

    // Condition-1
	/**
    if (!empty($student['TutoringLevel']) && empty($student['AdmissionLevel']) && !empty($student['grade']) && !empty($student['subjects']) && empty($student['stream'])) 
	{

        // Prepare the values for TutoringLevel, Grade, and Subjects
        $tutoringLevels = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['TutoringLevel'])) . "'";
        
		
		
		
        // Dynamically create conditions for grades
        $gradeConditions = [];
        foreach ($student['grade'] as $grade) {
            $safeGrade = $conn->real_escape_string($grade);
            $gradeConditions[] = "FIND_IN_SET('$safeGrade', complete_user_profile_tutoring_detail.Tutoring_Grade) > 0";
        }
        // Combine all grade conditions with OR logic
        $gradeCondition = implode(" AND ", $gradeConditions);

        // Dynamically create conditions for subjects
        $subjectConditions = [];
        foreach ($student['subjects'] as $subject) {
            $safeSubject = $conn->real_escape_string($subject);
            $subjectConditions[] = "FIND_IN_SET('$safeSubject', complete_user_profile_tutoring_detail.Tutoring_ALL_Subjects) > 0";
        }
        // Combine all subject conditions with AND logic (because all subjects must match)
        $subjectCondition = implode(" AND ", $subjectConditions);

        // Create the conditions for the query
        $conditions1[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels) 
                          AND ($gradeCondition) 
                          AND ($subjectCondition))";
    }
	**/
	
	// Condition-2
    if (!empty($student['TutoringLevel']) && !empty($student['AdmissionLevel']) && empty($student['grade']) && !empty($student['subjects']) && !empty($student['stream'])) 
	{

        // Prepare the values for TutoringLevel, Grade, and Subjects
        $tutoringLevels = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['TutoringLevel'])) . "'";
        
		
		
		// Dynamically create conditions for AdmissionLevel
        $admissionLevelConditions = [];
        foreach ($student['AdmissionLevel'] as $admissionLevel) {
            $safeAdmissionLevel = $conn->real_escape_string($admissionLevel);
            $admissionLevelConditions[] = "FIND_IN_SET('$safeAdmissionLevel', complete_user_profile_tutoring_detail.AdmissionLevel) > 0";
        }
        // Combine all AdmissionLevel conditions with OR logic
        $admissionLevelCondition = implode(" AND ", $admissionLevelConditions);
		
        // Dynamically create conditions for grades
        $streamConditions = [];
        foreach ($student['stream'] as $stream) {
            $safeStream = $conn->real_escape_string($stream);
            $streamConditions[] = "FIND_IN_SET('$safeStream', complete_user_profile_tutoring_detail.Stream) > 0";
        }
        // Combine all stream conditions with OR logic
        $streamConditions = implode(" AND ", $streamConditions);

        // Dynamically create conditions for subjects
        $subjectConditions = [];
        foreach ($student['subjects'] as $subject) {
            $safeSubject = $conn->real_escape_string($subject);
            $subjectConditions[] = "FIND_IN_SET('$safeSubject', complete_user_profile_tutoring_detail.Tutoring_ALL_Subjects) > 0";
        }
        // Combine all subject conditions with AND logic (because all subjects must match)
        $subjectCondition = implode(" AND ", $subjectConditions);

        // Create the conditions for the query
        $conditions2[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels) 
						  AND ($admissionLevelCondition) 	
                          AND ($streamConditions) 
                          AND ($subjectCondition))";
    }
	
	
	// Condition-3
    if (!empty($student['TutoringLevel']) && !empty($student['AdmissionLevel']) && !empty($student['grade']) && !empty($student['subjects']) && empty($student['stream'])) 
	{

        // Prepare the values for TutoringLevel, Grade, and Subjects
        $tutoringLevels = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['TutoringLevel'])) . "'";
        
		// Dynamically create conditions for AdmissionLevel
        $admissionLevelConditions = [];
        foreach ($student['AdmissionLevel'] as $admissionLevel) {
            $safeAdmissionLevel = $conn->real_escape_string($admissionLevel);
            $admissionLevelConditions[] = "FIND_IN_SET('$safeAdmissionLevel', complete_user_profile_tutoring_detail.AdmissionLevel) > 0";
        }
        // Combine all AdmissionLevel conditions with OR logic
        $admissionLevelCondition = implode(" AND ", $admissionLevelConditions);
		
		
        // Dynamically create conditions for grades
        $gradeConditions = [];
        foreach ($student['grade'] as $grade) {
            $safeGrade = $conn->real_escape_string($grade);
            $gradeConditions[] = "FIND_IN_SET('$safeGrade', complete_user_profile_tutoring_detail.Tutoring_Grade) > 0";
        }
        // Combine all grade conditions with OR logic
        $gradeCondition = implode(" AND ", $gradeConditions);

        // Dynamically create conditions for subjects
        $subjectConditions = [];
        foreach ($student['subjects'] as $subject) {
            $safeSubject = $conn->real_escape_string($subject);
            $subjectConditions[] = "FIND_IN_SET('$safeSubject', complete_user_profile_tutoring_detail.Tutoring_ALL_Subjects) > 0";
        }
        // Combine all subject conditions with AND logic (because all subjects must match)
        $subjectCondition = implode(" AND ", $subjectConditions);

        // Create the conditions for the query
        $conditions3[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels)
						  AND ($admissionLevelCondition) 		
                          AND ($gradeCondition) 
                          AND ($subjectCondition))";
    }
	
	
	
	// Condition-4
    if (!empty($student['TutoringLevel']) && empty($student['AdmissionLevel']) && empty($student['grade']) && !empty($student['subjects']) && empty($student['stream'])) 
	{

        // Prepare the values for TutoringLevel, Grade, and Subjects
        $tutoringLevels = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['TutoringLevel'])) . "'";
        
		
        // Dynamically create conditions for subjects
        $subjectConditions = [];
        foreach ($student['subjects'] as $subject) {
            $safeSubject = $conn->real_escape_string($subject);
            $subjectConditions[] = "FIND_IN_SET('$safeSubject', complete_user_profile_tutoring_detail.Tutoring_ALL_Subjects) > 0";
        }
        // Combine all subject conditions with AND logic (because all subjects must match)
        $subjectCondition = implode(" AND ", $subjectConditions);

        // Create the conditions for the query
        $conditions4[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels)
                          AND ($subjectCondition))";
						  
    }
	
	/**
	// Condition-5
    if (!empty($student['TutoringLevel']) && empty($student['AdmissionLevel']) && empty($student['grade']) && !empty($student['subjects']) && empty($student['stream'])) 
	{

        // Prepare the values for TutoringLevel, Grade, and Subjects
        $tutoringLevels = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['TutoringLevel'])) . "'";
        
		
        // Dynamically create conditions for subjects
        $subjectConditions = [];
        foreach ($student['subjects'] as $subject) {
            $safeSubject = $conn->real_escape_string($subject);
            $subjectConditions[] = "FIND_IN_SET('$safeSubject', complete_user_profile_tutoring_detail.Tutoring_ALL_Subjects) > 0";
        }
        // Combine all subject conditions with AND logic (because all subjects must match)
        $subjectCondition = implode(" AND ", $subjectConditions);

        // Create the conditions for the query
        $conditions5[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels)
                          AND ($subjectCondition))";
						  
    }
	**/
	
	
	// Condition-6
    if (!empty($student['TutoringLevel']) && empty($student['AdmissionLevel']) && !empty($student['grade']) && !empty($student['subjects']) && empty($student['stream'])) 
	{
		
		// Prepare the values for TutoringLevel, Grade, and Subjects
        $tutoringLevels = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['TutoringLevel'])) . "'";
        
		
		 
		
		
		// Dynamically create conditions for grades
		$gradeConditions = [];
		foreach ($student['grade'] as $grade) {
			$safeGrade = $conn->real_escape_string($grade);
			$gradeConditions[] = "FIND_IN_SET('$safeGrade', TRIM(complete_user_profile_tutoring_detail.Tutoring_Grade)) > 0";
		}
		// Combine all grade conditions with AND logic
		$gradeCondition = implode(" AND ", $gradeConditions);
		
		// Dynamically create conditions for subjects
        $subjectConditions = [];
        foreach ($student['subjects'] as $subject) {
            $safeSubject = $conn->real_escape_string($subject);
            $subjectConditions[] = "FIND_IN_SET('$safeSubject', complete_user_profile_tutoring_detail.Tutoring_ALL_Subjects) > 0";
        }
        // Combine all subject conditions with AND logic (because all subjects must match)
        $subjectCondition = implode(" AND ", $subjectConditions);

		// Create the conditions for the query
		$conditions6[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels)
						  AND ($gradeCondition) 
						  AND ($subjectCondition))";
	}
	
	
}




// Get tutor information and filter by distance
$sql_Q = $conn->query("SELECT tuition_type, user_id, lettitude, longitude, travel_distance FROM user_tutor_info");
$tutor_ids = [];

while ($get_Data = mysqli_fetch_assoc($sql_Q)) {
    if (!empty($get_Data['lettitude']) && !empty($get_Data['longitude'])) {
        // Calculate the distance between student and tutor
        $distance_value = distance($student_lat, $student_long, $get_Data['lettitude'], $get_Data['longitude'], "K");

		//echo round((int)$distance_value).'==';
		
		//echo (int)$get_Data['travel_distance'].'==';


        // Check if the tutor's distance is within the acceptable range
        $rounded_value = round((int)$distance_value);
		
		//echo  $rounded_value.'==';
		
			
			if ( $rounded_value <= (int)$get_Data['travel_distance']) {
                $tutor_ids[] = $get_Data['user_id'];
            }
    }
}



// If any tutors are found within the range, add the condition to SQL query
if (!empty($tutor_ids)) {
    $conditions7[] = "user_tutor_info.user_id IN ('" . implode("','", $tutor_ids) . "')";
}






if(!empty($gender)) 
{
	$conditions8[] = "user_tutor_info.gender IN ('" . implode("','", $gender) . "')";
}

if(!empty($nationality)) 
{
	$conditions9[] = "user_tutor_info.nationality IN ('" . implode("','", $nationality) . "')";
}

if(!empty($qualification)) 
{
	$conditions10[] = "user_tutor_info.qualification IN ('" . implode("','", $qualification) . "')";
}
if(!empty($tutor_status)) 
{
	$conditions11[] = "user_tutor_info.tutor_status IN ('" . implode("','", $tutor_status) . "')";
}




if (!empty($conditions1)) {
        $combinedConditions = implode(' OR ', $conditions1);
    }
if (!empty($conditions2)) {
	$combinedConditions .= (empty($combinedConditions) ? "" : " OR ") . implode(' OR ', $conditions2);
}
if (!empty($conditions3)) {
	$combinedConditions .= (empty($combinedConditions) ? "" : " OR ") . implode(' OR ', $conditions3);
}
if (!empty($conditions4)) {
	$combinedConditions .= (empty($combinedConditions) ? "" : " OR ") . implode(' OR ', $conditions4);
}
if (!empty($conditions5)) {
	$combinedConditions .= (empty($combinedConditions) ? "" : " OR ") . implode(' OR ', $conditions5);
}
if (!empty($conditions6)) {
	$combinedConditions .= (empty($combinedConditions) ? "" : " OR ") . implode(' OR ', $conditions6);
}




 $whereClause  = $combinedConditions;

/**
$whereClause = '';

// Check if $combinedConditions is not empty
if (!empty($combinedConditions)) {
    // If $combinedConditions is not empty, append it to the whereClause
    $whereClause .= implode(' AND ', $combinedConditions);
}
**/


if (!empty($conditions7)) {
    $whereClause .= (empty($whereClause) ? "" : " AND ") . implode(' AND ', $conditions7);
}
if (!empty($conditions8)) {
    $whereClause .= (empty($whereClause) ? "" : " AND ") . implode(' AND ', $conditions8);
}
if (!empty($conditions9)) {
    $whereClause .= (empty($whereClause) ? "" : " AND ") . implode(' AND ', $conditions9);
}
if (!empty($conditions10)) {
    $whereClause .= (empty($whereClause) ? "" : " AND ") . implode(' AND ', $conditions10);
}
if (!empty($conditions11)) {
    $whereClause .= (empty($whereClause) ? "" : " AND ") . implode(' AND ', $conditions11);
}




			// Handle sorting
			$sorting = "";
			if (!empty($array['sorting'])) {
				foreach ($array['sorting'] as $sort) {
					switch ($sort) {
						case "Newest":
							$sorting = " ORDER BY user_tutor_info.create_date DESC";
							break;
						case "Oldest":
							$sorting = " ORDER BY user_tutor_info.create_date ASC";
							break;
						case "HigherR":
							$sorting = " ORDER BY tbl_rating.rating_no DESC";
							break;
						case "LowestR":
							$sorting = " ORDER BY tbl_rating.rating_no ASC";
							break;
					}
				}
			}


if(!empty($combinedConditions))
{

// Build the SQL query
 $sql = "
    SELECT *
    FROM user_tutor_info
    LEFT JOIN complete_user_profile_tutoring_detail 
        ON user_tutor_info.user_id = complete_user_profile_tutoring_detail.user_id
	LEFT JOIN tbl_rating 
		ON user_tutor_info.user_id = tbl_rating.tutor_id	
    WHERE $whereClause $sorting
";


}
else{
	
	 $sql = "
    SELECT DISTINCT user_tutor_info.user_id
    FROM user_tutor_info
    LEFT JOIN complete_user_profile_tutoring_detail 
        ON user_tutor_info.user_id = complete_user_profile_tutoring_detail.user_id
	LEFT JOIN tbl_rating 
		ON user_tutor_info.user_id = tbl_rating.tutor_id	
    WHERE $whereClause $sorting
";
	
}


// Debugging the query
//echo $sql;

// Execute the query
$result = $conn->query($sql);

// Check for results and fetch data
if(mysqli_num_rows($result)>0) 
{
	
	
    $tutors = [];
    while ($row = $result->fetch_assoc()) {
		
		//echo $row['user_id'];
        $tutors[] = $row['user_id'];
    }
	
	
	////////////
	
	// Count the occurrences of each user_id
		$userIdCounts = array_count_values($tutors);

		// Find repeated user_ids (if any)
		$duplicateIds = array_filter($userIdCounts, function($count) {
			return $count > 1; // We are interested in IDs that appear more than once
		});

		// Display the duplicate user IDs, if any
		if (!empty($duplicateIds)) 
		{
			//echo "Duplicate user IDs: ";
			foreach ($duplicateIds as $id => $count) 
			{
				//echo "ID: $id, Count: $count; ";
				
			}
		}
	/////////////
	
	
	 $tutorIDCount = count($tutors);
	
	// Count the number of students in the StudentDetail array
	 $studentArrayCount = count($array['StudentDetail']);
	
	if($studentArrayCount==1 && $studentArrayCount != $tutorIDCount )
	{
		
		
		
		//echo "ID: $tutorIDCount, Count: $tutorIDCount; ";

		foreach ($tutors as $user_id) {
				//echo "USERID: $user_id ";
				
				
				$Filter_Data = mysqli_fetch_array($conn->query("SELECT * FROM user_tutor_info WHERE user_id = '".$user_id."' "));
				
				
				$user_main_data = mysqli_fetch_array($conn->query("select * from user_info where user_id = '".$Filter_Data['user_id']."' "));
				if($logged_in_student_id !="")
					  {
						  $tutor_favrourite_val = mysqli_fetch_array($conn->query("SELECT * FROM favourite_tutor_by_student WHERE tutor_id = '".$Filter_Data['user_id']."' and logged_in_student_id = '".$logged_in_student_id."' "));
						  
						  $favourite_val = $tutor_favrourite_val['favourite'];
					  }
					  else{
						  $favourite_val = 'false';
					  }
                      
					  if($favourite_val==null || $favourite_val=="")
					  {
						  $favourite_val = 'false';
					  }
                      
					 
					 
					 ///// Rating
					 
					  $rating_val = mysqli_fetch_array($conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$Filter_Data['user_id']."' "));
						
						if($rating_val['rating_no'] == null || $rating_val['rating_no'] =="")		
						{
							$rating_val_f = 0;
						}
						else{
							$rating_val_f = $rating_val['rating_no'];
						}
                      
					  
					  
					  
					   //// Average Rating of student_date_time_offer_confirmation
					
					
					$avg_rating_sql = $conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$Filter_Data['user_id']."' ");
					
					
					
					$nn = 0;
					$sn = 0;
					while($avg_rating = mysqli_fetch_array($avg_rating_sql))
					{
						$sn = $sn+1;
						$nn = $nn+$avg_rating['rating_no'];
					}
					
					
					if($nn !=0 && $sn !=0)
					{
						
						 $avg_rating = round($nn/$sn); 
					}
					else
					{
						 $avg_rating = 'No rating.';
					}


					
					
					$Response[] = array(
										'user_id' => $Filter_Data['user_id'],
										'first_name' => $user_main_data['first_name'],
										'last_name' => $user_main_data['last_name'],
										'favourite' => $favourite_val,
										'rating_val' => $rating_val_f,
										'Average_rating' => $avg_rating,
										'email' => $user_main_data['email'],
										'mobile' => $user_main_data['mobile'],
										'address1' => $user_main_data['address1'],
										'age' => $Filter_Data['age'],
										'profile_image' => $Filter_Data['profile_image'],
										'flag' => $Filter_Data['flag'],
										'personal_statement' => $Filter_Data['personal_statement'],
										'tutor_code' => $Filter_Data['tutor_code'],
										'gender' => $Filter_Data['gender'],
										'nationality' => $Filter_Data['nationality'],
										'qualification' => $Filter_Data['qualification'],
										'tutor_status' => $Filter_Data['tutor_status'],
										'tuition_type' => $Filter_Data['tuition_type'],
										'postal_code' => $Filter_Data['postal_code'],
										'travel_distance' => $Filter_Data['travel_distance'],
										'lettitude' => $Filter_Data['lettitude'],
										'longitude' => $Filter_Data['longitude'],
										'stream' => $Filter_Data['stream'],
										'between_distance' => $distance_value.' KM',
										'profile_history_academy_data_array' => $profile_history_academy_data_array,
										'profile_history_academy_result_data_array' => $profile_history_academy_result_data_array,
										'profile_tutoring_detail_result_data_array' => $profile_tutoring_detail_result_data_array,
										'complete_user_profile_tutoring_grade_detail_array' => $complete_user_profile_tutoring_grade_detail_array,
										'tutoring_subjects_detail_result_data_array' => $tutoring_subjects_detail_result_data_array
										
										
										);
					
					
					
				
				
			}
			
			
			
			 if(!empty($Response)) 
			 {
				$resultData = array('status' => true, 'Search_Data_Records' => $Response);
			} else {
				$resultData = array('status' => false, 'message' => 'No Records Found.');
			}	
			
			
			
			$RecordExists = 1;
		
	}
	else if($studentArrayCount==1 && $studentArrayCount == $tutorIDCount )
	{
		
		//echo "ID: $tutorIDCount, Count: $tutorIDCount; ";

		foreach ($tutors as $user_id) {
				//echo "USERID: $user_id ";
				
				
				$Filter_Data = mysqli_fetch_array($conn->query("SELECT * FROM user_tutor_info WHERE user_id = '".$user_id."' "));
				
				
				$user_main_data = mysqli_fetch_array($conn->query("select * from user_info where user_id = '".$Filter_Data['user_id']."' "));
				if($logged_in_student_id !="")
					  {
						  $tutor_favrourite_val = mysqli_fetch_array($conn->query("SELECT * FROM favourite_tutor_by_student WHERE tutor_id = '".$Filter_Data['user_id']."' and logged_in_student_id = '".$logged_in_student_id."' "));
						  
						  $favourite_val = $tutor_favrourite_val['favourite'];
					  }
					  else{
						  $favourite_val = 'false';
					  }
                      
					  if($favourite_val==null || $favourite_val=="")
					  {
						  $favourite_val = 'false';
					  }
                      
					 
					 
					 ///// Rating
					 
					  $rating_val = mysqli_fetch_array($conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$Filter_Data['user_id']."' "));
						
						if($rating_val['rating_no'] == null || $rating_val['rating_no'] =="")		
						{
							$rating_val_f = 0;
						}
						else{
							$rating_val_f = $rating_val['rating_no'];
						}
                      
					  
					  
					  
					   //// Average Rating of student_date_time_offer_confirmation
					
					
					$avg_rating_sql = $conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$Filter_Data['user_id']."' ");
					
					
					
					$nn = 0;
					$sn = 0;
					while($avg_rating = mysqli_fetch_array($avg_rating_sql))
					{
						$sn = $sn+1;
						$nn = $nn+$avg_rating['rating_no'];
					}
					
					
					if($nn !=0 && $sn !=0)
					{
						
						 $avg_rating = round($nn/$sn); 
					}
					else
					{
						 $avg_rating = 'No rating.';
					}


					
					
					$Response[] = array(
										'user_id' => $Filter_Data['user_id'],
										'first_name' => $user_main_data['first_name'],
										'last_name' => $user_main_data['last_name'],
										'favourite' => $favourite_val,
										'rating_val' => $rating_val_f,
										'Average_rating' => $avg_rating,
										'email' => $user_main_data['email'],
										'mobile' => $user_main_data['mobile'],
										'address1' => $user_main_data['address1'],
										'age' => $Filter_Data['age'],
										'profile_image' => $Filter_Data['profile_image'],
										'flag' => $Filter_Data['flag'],
										'personal_statement' => $Filter_Data['personal_statement'],
										'tutor_code' => $Filter_Data['tutor_code'],
										'gender' => $Filter_Data['gender'],
										'nationality' => $Filter_Data['nationality'],
										'qualification' => $Filter_Data['qualification'],
										'tutor_status' => $Filter_Data['tutor_status'],
										'tuition_type' => $Filter_Data['tuition_type'],
										'postal_code' => $Filter_Data['postal_code'],
										'travel_distance' => $Filter_Data['travel_distance'],
										'lettitude' => $Filter_Data['lettitude'],
										'longitude' => $Filter_Data['longitude'],
										'stream' => $Filter_Data['stream'],
										'between_distance' => $distance_value.' KM',
										'profile_history_academy_data_array' => $profile_history_academy_data_array,
										'profile_history_academy_result_data_array' => $profile_history_academy_result_data_array,
										'profile_tutoring_detail_result_data_array' => $profile_tutoring_detail_result_data_array,
										'complete_user_profile_tutoring_grade_detail_array' => $complete_user_profile_tutoring_grade_detail_array,
										'tutoring_subjects_detail_result_data_array' => $tutoring_subjects_detail_result_data_array
										
										
										);
					
					
					
				
				
			}
			
			
			
			 if(!empty($Response)) 
			 {
				$resultData = array('status' => true, 'Search_Data_Records' => $Response);
			} else {
				$resultData = array('status' => false, 'message' => 'No Records Found.');
			}	
			
			
			
			$RecordExists = 1;
		
		
	}
	else if($studentArrayCount > 1 && $studentArrayCount == $tutorIDCount && $tutorIDCount == $count)
	{
		
				
		// Count the occurrences of each user_id
		$userIdCounts = array_count_values($tutors);

		// Find repeated user_ids (if any)
		$duplicateIds = array_filter($userIdCounts, function($count) {
			return $count > 1; // We are interested in IDs that appear more than once
		});

		// Display the duplicate user IDs, if any
		if (!empty($duplicateIds)) {
			//echo "Duplicate user IDs: ";
			foreach ($duplicateIds as $id => $count) {
				//echo "ID: $id, Count: $count; ";
				
				
				
				
				$Filter_Data = mysqli_fetch_array($conn->query("SELECT * FROM user_tutor_info WHERE user_id = '".$id."' "));
				
				
				$user_main_data = mysqli_fetch_array($conn->query("select * from user_info where user_id = '".$Filter_Data['user_id']."' "));
				if($logged_in_student_id !="")
					  {
						  $tutor_favrourite_val = mysqli_fetch_array($conn->query("SELECT * FROM favourite_tutor_by_student WHERE tutor_id = '".$Filter_Data['user_id']."' and logged_in_student_id = '".$logged_in_student_id."' "));
						  
						  $favourite_val = $tutor_favrourite_val['favourite'];
					  }
					  else{
						  $favourite_val = 'false';
					  }
                      
					  if($favourite_val==null || $favourite_val=="")
					  {
						  $favourite_val = 'false';
					  }
                      
					 
					 
					 ///// Rating
					 
					  $rating_val = mysqli_fetch_array($conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$Filter_Data['user_id']."' "));
						
						if($rating_val['rating_no'] == null || $rating_val['rating_no'] =="")		
						{
							$rating_val_f = 0;
						}
						else{
							$rating_val_f = $rating_val['rating_no'];
						}
                      
					  
					  
					  
					   //// Average Rating of student_date_time_offer_confirmation
					
					
					$avg_rating_sql = $conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$Filter_Data['user_id']."' ");
					
					
					
					$nn = 0;
					$sn = 0;
					while($avg_rating = mysqli_fetch_array($avg_rating_sql))
					{
						$sn = $sn+1;
						$nn = $nn+$avg_rating['rating_no'];
					}
					
					
					if($nn !=0 && $sn !=0)
					{
						
						 $avg_rating = round($nn/$sn); 
					}
					else
					{
						 $avg_rating = 'No rating.';
					}


					
					
					$Response[] = array(
										'user_id' => $Filter_Data['user_id'],
										'first_name' => $user_main_data['first_name'],
										'last_name' => $user_main_data['last_name'],
										'favourite' => $favourite_val,
										'rating_val' => $rating_val_f,
										'Average_rating' => $avg_rating,
										'email' => $user_main_data['email'],
										'mobile' => $user_main_data['mobile'],
										'address1' => $user_main_data['address1'],
										'age' => $Filter_Data['age'],
										'profile_image' => $Filter_Data['profile_image'],
										'flag' => $Filter_Data['flag'],
										'personal_statement' => $Filter_Data['personal_statement'],
										'tutor_code' => $Filter_Data['tutor_code'],
										'gender' => $Filter_Data['gender'],
										'nationality' => $Filter_Data['nationality'],
										'qualification' => $Filter_Data['qualification'],
										'tutor_status' => $Filter_Data['tutor_status'],
										'tuition_type' => $Filter_Data['tuition_type'],
										'postal_code' => $Filter_Data['postal_code'],
										'travel_distance' => $Filter_Data['travel_distance'],
										'lettitude' => $Filter_Data['lettitude'],
										'longitude' => $Filter_Data['longitude'],
										'stream' => $Filter_Data['stream'],
										'between_distance' => $distance_value.' KM',
										'profile_history_academy_data_array' => $profile_history_academy_data_array,
										'profile_history_academy_result_data_array' => $profile_history_academy_result_data_array,
										'profile_tutoring_detail_result_data_array' => $profile_tutoring_detail_result_data_array,
										'complete_user_profile_tutoring_grade_detail_array' => $complete_user_profile_tutoring_grade_detail_array,
										'tutoring_subjects_detail_result_data_array' => $tutoring_subjects_detail_result_data_array
										
										
										);
				
				
				
				
				
				
				
				
				
				
			}
			
			
			
			 if(!empty($Response)) 
			 {
				$resultData = array('status' => true, 'Search_Data_Records' => $Response);
			} else {
				$resultData = array('status' => false, 'message' => 'No Records Found.');
			}	
			
			
			
			
		}
		
		
		$RecordExists = 1;
		
		
	}
	else{
		
		$RecordExists = 0;
		
	}
	
	
	if($RecordExists==0)
	{
		 $resultData = array('status' => false, 'message' => 'Record not Found.');
	}
   
   
   
    
} else {
   $resultData = array('status' => false, 'message' => 'Record not Found.');
}






}
else{ 

		$resultData = array('status' => false, 'message' => 'Please Check The Passive Value.');
	}		
			
			
		echo json_encode($resultData);
		
		
?>
