<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');




// Calculate the distance between two lat-long points in kilometers (K)
function tutor_distance($lat1, $lon1, $lat2, $lon2, $unit = "K") {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;

    return $unit == "K" ? $miles * 1.609344 : $miles;
}

// Read the JSON payload
$data = file_get_contents("php://input");
$array = json_decode($data, true);

// Initialize arrays for filters
$qualifications = [];
$levels = [];
$subjects = [];

// Extract tutor location and distance
$tutor_lat = $array['tutor_lat'];
$tutor_long = $array['tutor_long'];
$tutor_distance = $array['tutor_distance'];

// Process each filter category
foreach ($array as $key => $value) {
    if ($key === 'student_qualification' && is_array($value)) {
        foreach ($value as $qual) {
            $qualifications[] = "'" . $qual . "'";
        }
    } elseif ($key === 'student_level' && is_array($value)) {
        foreach ($value as $level) {
            $levels[] = "'" . $level . "'";
        }
    } elseif ($key === 'student_subjects' && is_array($value)) {   
        foreach ($value as $subject) {
            $subjects[] = "'" . $subject . "'";
        }
    }
}

// Check if all filters are empty
$filtersEmpty = empty($qualifications) && empty($levels) && empty($subjects);

// Construct WHERE conditions based on filters
$conds = [];

if (!empty($qualifications)) {
    // Check if qualifications is a single value
    if (count($qualifications) == 1) {
		//echo $qualifications[0];
        $conds[] = "post_requirements_TutorQualification.Tutor_Qualification = " . $qualifications[0] . " "; // Single value
    } else {
        $conds[] = "post_requirements_TutorQualification.Tutor_Qualification IN (" . implode(", ", $qualifications) . ")"; // Multiple values
    }
}

// Handle levels
if (!empty($levels)) {
    // Check if levels is a single value
    if (count($levels) == 1) {
		
        $conds[] = "tbl_Student_Level_Grade_Subjects_Post_Requirement.Level = " . $levels[0] . " "; // Single value
    } else {
        $conds[] = "tbl_Student_Level_Grade_Subjects_Post_Requirement.Level IN (" . implode(", ", $levels) . ")"; // Multiple values
    }
}

// Define mappings for subjects to related terms
$subjectMappings = [
    'Science' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Computer' => ['Computer', 'Science', 'Computer Science SL', 'Computer Engineering', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Physics' => ['Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics'],
    'Chemistry' => ['Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Science Chemistry', 'Pure Chemistry'],
    'Math' => ['Math', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics'],
];

$subjectConditions = [];
if (!empty($subjects)) { 
    foreach ($subjects as $subject) {
        $subject = trim($subject, "'");
        if (isset($subjectMappings[$subject])) {
            foreach ($subjectMappings[$subject] as $mappedSubject) {
                $subjectConditions[] = "tbl_Student_Level_Grade_Subjects_Post_Requirement.ALL_Subjects LIKE '%" . $mappedSubject . "%'";
            }
        } else {
            $subjectConditions[] = "tbl_Student_Level_Grade_Subjects_Post_Requirement.ALL_Subjects LIKE '%" . $subject . "%'";
        }
    }
}

$subjectsClause = !empty($subjectConditions) ? " AND (" . implode(" OR ", $subjectConditions) . ")" : "";


$sql = "SELECT *
        FROM student_post_requirements";

// Check if filters exist to determine joins
$joinTables = (!empty($qualifications) || !empty($levels) || !empty($subjects));

if ($joinTables) {
    $sql .= " 
        INNER JOIN tbl_Student_Level_Grade_Subjects_Post_Requirement 
            ON student_post_requirements.student_post_requirements_id = tbl_Student_Level_Grade_Subjects_Post_Requirement.student_post_requirements_id
        INNER JOIN post_requirements_TutorQualification 
            ON student_post_requirements.student_post_requirements_id = post_requirements_TutorQualification.student_post_requirements_id
        INNER JOIN tbl_Tutor_Schedules_Slot_Time_post_requirement 
            ON student_post_requirements.student_post_requirements_id = tbl_Tutor_Schedules_Slot_Time_post_requirement.student_post_requirements_id";
}

// Construct WHERE conditions
$whereConditions = [];

// Check for existing conditions and add them to the WHERE clause
if (!empty($conds)) {
    $whereConditions[] = implode(' AND ', $conds);
}

// Append subject condition if available
if (!empty($subjectsClause)) {
    $whereConditions[] = ltrim($subjectsClause, " AND "); // Remove leading AND if it exists
}

// Add WHERE clause only if conditions exist
if (!empty($whereConditions)) {
    $sql .= " WHERE " . implode(' AND ', $whereConditions);
}

// Add GROUP BY and ORDER BY clauses
$sql .= " 
    GROUP BY student_post_requirements.student_post_requirements_id
    ORDER BY student_post_requirements.student_post_requirements_id DESC";

//echo $sql;





$sql2 = $conn->query($sql);

// Fetch results and filter by distance
$student_List_array = [];
while ($student_Search_Data = mysqli_fetch_assoc($sql2)) {
    // Check tutor distance
    $student_lat = $student_Search_Data['student_lat'];
    $student_long = $student_Search_Data['student_long'];
    if ($student_lat && $student_long) {
        $distance = tutor_distance($tutor_lat, $tutor_long, $student_lat, $student_long, "K");
       
 
 
	   if (intval($distance) > $tutor_distance) {
            continue; // Skip students outside the distance
        }
    }




    
    // Example: Student Levels, Grades, Subjects, Tutor Qualifications, etc.
    $post_requirements_student_subjects = [];
    $ss_query = $conn->query("SELECT * FROM tbl_Student_Level_Grade_Subjects_Post_Requirement WHERE student_post_requirements_id = '" . $student_Search_Data['student_post_requirements_id'] . "'");
    while ($student_subject_res = mysqli_fetch_assoc($ss_query)) 
	{
		
		
		if($student_subject_res['Level'] != "Secondary" && $student_subject_res['ALL_Subjects'] != "")
		{
		
		
			$post_requirements_student_subjects[] = [
				'Level_Grade_Subjects_Post_Requirement_id' => $student_subject_res['Level_Grade_Subjects_Post_Requirement_id'],
				'Level' => $student_subject_res['Level'],
				'Grade' => $student_subject_res['Grade'],
				'ALL_Subjects' => $student_subject_res['ALL_Subjects'],
			];
		
		}
		
		
		if($student_subject_res['Level'] == "Secondary" && $student_subject_res['ALL_Subjects'] != "")
		{
		
			$Streams_array = array();
							
				$get_stream_sql = $conn->query("SELECT * FROM student_post_requirements_streams WHERE student_post_requirements_id = '".$student_Search_Data['student_post_requirements_id']."' ");
				
				while($get_streams = mysqli_fetch_array($get_stream_sql))
				{
					$Streams_array[] = $get_streams['student_post_requirements_streams'];
				}
		
			$post_requirements_student_subjects[] = [
				'Level_Grade_Subjects_Post_Requirement_id' => $student_subject_res['Level_Grade_Subjects_Post_Requirement_id'],
				'Level' => $student_subject_res['Level'],
				'Grade' => $student_subject_res['Grade'],
				'ALL_Subjects' => $student_subject_res['ALL_Subjects'],
				 'Streams' =>  $Streams_array,
			];
		
		}
		
		
		
		
    }


	//print_r($student_Search_Data);

	$Tutor_Qualification  = array();
	
	/// for Tutor_Qualification
					$TQ_query = $conn->query("select * from post_requirements_TutorQualification where student_post_requirements_id = '".$student_Search_Data['student_post_requirements_id']."' ");
					
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
					
					
		

		//////////////////////
							
			
				$check = mysqli_fetch_array($conn->query("SELECT * from student_post_requirements_Favourite_Assigned  WHERE student_post_requirements_id = '".$student_Search_Data['student_post_requirements_id']."' "));
				
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
				
				
				
			
				
		
		
		
			$student_name_sql = mysqli_fetch_array($conn->query("SELECT first_name,last_name FROM user_info WHERE user_id = '".$student_Search_Data['logged_in_user_id']."' "));
					
			$student_first_name = $student_name_sql['first_name'];
			$student_last_name = $student_name_sql['last_name'];
		

			//////
					
				$expired_post_sql = $conn->query("SELECT * FROM student_post_requirements WHERE student_post_requirements_id = '".$student_Search_Data['student_post_requirements_id']."' ");
				
				
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
			
			
			/////
					
				$sql_minbid = mysqli_fetch_array($conn->query("SELECT min(tutor_negotiate_amount) FROM student_post_requirement_amount_negotiate as nego INNER JOIN student_post_requirements_Applied_by_tutor as apply ON nego.student_post_requirement_id = apply.student_post_requirements_id WHERE nego.tutor_negotiate_amount <> 0.00 and apply.student_post_requirements_id = '".$student_Search_Data['logged_in_user_id']."'  "));
				$min_bid_on_post = $sql_minbid['min(tutor_negotiate_amount)'];
				
				
			//////
			
			
			$No_of_applicant_sql = $conn->query("SELECT student_post_requirements_id FROM student_post_requirements_Applied_by_tutor WHERE student_post_requirements_id = '".$student_Search_Data['logged_in_user_id']."' and apply_tag = 'true' ");
					
			$No_of_applicants = mysqli_num_rows($No_of_applicant_sql);
			
			
			
			/// For Tutor Schedule and Slot Times
			$TS_query = $conn->query("select * from tbl_Tutor_Schedules_Slot_Time_post_requirement where student_post_requirements_id = '".$student_Search_Data['student_post_requirements_id']."' ");
			
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






    // Assemble the final list of students within the range
    $student_List_array[] = [
        'student_post_requirements_id' => $student_Search_Data['student_post_requirements_id'],
										'student_id' => $student_Search_Data['logged_in_user_id'],
										'No_of_Students' => $student_Search_Data['No_of_Students'],
										'tutor_login_id' => $tutor_id,
                          				'student_first_name' => $student_name_sql['first_name'],
										'student_last_name' => $student_name_sql['last_name'],
										'student_level' => $student_Search_Data['Level'],
										'student_grade' => $student_Search_Data['Grade'],
										'student_tution_type' => $student_Search_Data['student_tution_type'],
										'student_postal_code' => $student_Search_Data['student_postal_code'],
										'student_postal_address' => $student_Search_Data['student_postal_address'],
										'applicant' => $No_of_applicants,
										'min_bid_on_post' => $min_bid_on_post,
										'total_days_left_for_expired_post' => $total_days_expired_post,
										'tutor_booking_status' => $student_Search_Data['tutor_booking_status'],
										'offer_status' => $student_Search_Data['offer_status'],
										'student_offer_date' => $student_Search_Data['student_offer_date'],
										'student_offer_time' => $student_Search_Data['student_offer_time'],
										'tutor_offer_date' => $student_Search_Data['tutor_offer_date'],
										'tutor_offer_time' => $student_Search_Data['tutor_offer_time'],
										'tutor_accept_date_time_status' => $student_Search_Data['tutor_accept_date_time_status'],
										'student_date_time_offer_confirmation' => $student_Search_Data['student_date_time_offer_confirmation'],
										'tutor_duration_weeks' => $student_Search_Data['tutor_duration_weeks'],
										'tutor_duration_hours' => $student_Search_Data['tutor_duration_hours'],
										'tutor_tution_fees' => $student_Search_Data['tutor_tution_fees'],
										'tutor_tution_schedule_time' => $student_Search_Data['tutor_tution_schedule_time'],
										'tutor_tution_offer_amount_type' => $student_Search_Data['tutor_tution_offer_amount_type'],
										'tutor_tution_offer_amount' => $student_Search_Data['tutor_tution_offer_amount'],
										'amount_negotiate_by_tutor' => $student_Search_Data['amount_negotiate_by_tutor'],
										'negotiate_by_tutor_amount_type' => $student_Search_Data['negotiate_by_tutor_amount_type'],
										'amount_negotiate_by_student' => $student_Search_Data['amount_negotiate_by_student'],
										'negotiate_by_student_amount_type' => $student_Search_Data['negotiate_by_student_amount_type'],
										'booked_date' => $student_Search_Data['booked_date'],
										'tutor_booking_status' => $student_Search_Data['tutor_booking_status'],
										'offer_status' => $student_Search_Data['offer_status'],
										'tutor_id' => $tutor_id,
										'Favourite' => $Favourite,
										'student_level_grade_subjects' => $post_requirements_student_subjects,
										'tutor_qualification' => $Tutor_Qualification,
										'tutor_schedule_and_slot_times' => $Tutor_Schedule
    ];
}





// Return JSON response
$resultData = !empty($student_List_array) ?
    ['Status' => true, 'View_Assignment_Search_Data' => $student_List_array] :
    ['Status' => false, 'message' => 'No Result found.'];

echo json_encode($resultData);
?>
