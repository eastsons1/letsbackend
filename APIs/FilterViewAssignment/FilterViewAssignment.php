<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
header('content-type:application/json');


// Read the JSON payload
$data = file_get_contents("php://input");
$array = json_decode($data, true);

// Function to calculate distance between two lat-long points
function tutor_distance($lat1, $lon1, $lat2, $lon2, $unit = "K") {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;

    return $unit == "K" ? $miles * 1.609344 : $miles;
}

// Initialize arrays
$student_qualification = [];
$student_level = [];
$student_subjects = [];

// Process each filter category
foreach ($array as $key => $value) {
    if ($key === 'student_qualification' && is_array($value)) {
        foreach ($value as $qual) {
            $student_qualification[] = "'" . addslashes($qual) . "'";
        }
    } elseif ($key === 'student_level' && is_array($value)) {
        foreach ($value as $level) {
            $student_level[] = "'" . addslashes($level) . "'";
        }
    } elseif ($key === 'student_subjects' && is_array($value)) {   
        foreach ($value as $subject) {
            $student_subjects[] = "'" . addslashes($subject) . "'";
        }
    }
}

// Extract tutor location and distance
$tutor_lat = isset($array['tutor_lat']) ? floatval($array['tutor_lat']) : null;
$tutor_long = isset($array['tutor_long']) ? floatval($array['tutor_long']) : null;
$tutor_distance = isset($array['tutor_distance']) ? floatval($array['tutor_distance']) : null;

// If tutor location and distance are set, fetch student location from database
if ($tutor_distance && $tutor_lat && $tutor_long) {
    $query = "SELECT student_lat, student_long, student_post_requirements_id FROM student_post_requirements ORDER By update_date_time DESC"; // Adjust query as needed
    $result = mysqli_query($conn, $query);
    
	$student_post_requirements_id_arr = array();
	
    while($row = mysqli_fetch_assoc($result)) 
	{
        $student_lat = floatval($row['student_lat']);
        $student_long = floatval($row['student_long']);
		$student_post_requirements_id  = $row['student_post_requirements_id'];

        // Calculate distance
         $distance = tutor_distance($tutor_lat, $tutor_long, $student_lat, $student_long, "K");


			//echo $tutor_distance;
		// echo $student_lat.'==';
		 //echo $distance.'==';
		 if (round($distance) > $tutor_distance) {
            continue; // Skip students outside the distance
			
			
        }
		
		
		//echo $student_post_requirements_id.'==';
		$student_post_requirements_id_arr[] = $student_post_requirements_id;
		
		
    }
}




// Initialize WHERE conditions
$whereConditions = [];



if (!empty($tutor_distance) && !empty($tutor_lat) && !empty($tutor_long)) {
	
	$ids = implode(',', $student_post_requirements_id_arr); // Convert array to comma-separated values
	
	$whereConditions[] = "student_post_requirements.student_post_requirements_id IN ($ids)";
}

// Check if student_level is provided
if (!empty($student_level)) {
    $whereConditions[] = "tbl_Student_Level_Grade_Subjects_Post_Requirement.Level IN (" . implode(", ", $student_level) . ")";
}

// Check if student_qualification is provided
if (!empty($student_qualification)) {
    $whereConditions[] = "post_requirements_TutorQualification.Tutor_Qualification IN (" . implode(", ", $student_qualification) . ")";
}

/**
// Check if student_subjects is provided
if (!empty($student_subjects)) {
    $whereConditions[] = "tbl_Student_Level_Grade_Subjects_Post_Requirement.ALL_Subjects IN (" . implode(", ", $student_subjects) . ")";
}

**/



// Check if student_subjects is provided
if (!empty($student_subjects)) {
    $subjectConditions = [];
    foreach ($student_subjects as $subject) {
        // Trim and remove extra quotes manually
        $cleanedSubject = trim($subject, "'");  // Removes surrounding single quotes if any
        $cleanedSubject = mysqli_real_escape_string($conn, $cleanedSubject); // Escape for SQL safety
        $subjectConditions[] = "tbl_Student_Level_Grade_Subjects_Post_Requirement.ALL_Subjects LIKE '%" . $cleanedSubject . "%'";
    }
    $whereConditions[] = "(" . implode(" OR ", $subjectConditions) . ")";
}




/**
// Build the final query
$sql = "SELECT *
        FROM student_post_requirements
        INNER JOIN tbl_Student_Level_Grade_Subjects_Post_Requirement 
            ON student_post_requirements.student_post_requirements_id = tbl_Student_Level_Grade_Subjects_Post_Requirement.student_post_requirements_id
        INNER JOIN post_requirements_TutorQualification 
            ON student_post_requirements.student_post_requirements_id = post_requirements_TutorQualification.student_post_requirements_id
        INNER JOIN tbl_Tutor_Schedules_Slot_Time_post_requirement 
            ON student_post_requirements.student_post_requirements_id = tbl_Tutor_Schedules_Slot_Time_post_requirement.student_post_requirements_id";

**/




////////////
$Query = "";
if (!empty($student_level)) {
    //$Level_filter = implode("','", $student_level);
    $Query .= " AND tbl_Student_Level_Grade_Subjects_Post_Requirement.Level IN (" . implode(", ", $student_level) . ")";
}

if (!empty($student_qualification)) {
    //$Level_filter = implode("','", $student_level);
    $Query .= " AND post_requirements_TutorQualification.Tutor_Qualification IN (" . implode(", ", $student_qualification) . ")";
}
if (!empty($student_subjects)) {
    //$Level_filter = implode("','", $student_level);
    $Query .= " AND ".$whereConditions;
}


/**
$sql = "SELECT student_post_requirements.*, 
               tbl_Student_Level_Grade_Subjects_Post_Requirement.Level, 
               tbl_Student_Level_Grade_Subjects_Post_Requirement.Grade, 
               GROUP_CONCAT(tbl_Student_Level_Grade_Subjects_Post_Requirement.ALL_Subjects SEPARATOR ', ') AS subjects_list 
        FROM student_post_requirements 
        LEFT JOIN tbl_Student_Level_Grade_Subjects_Post_Requirement 
            ON student_post_requirements.student_post_requirements_id = tbl_Student_Level_Grade_Subjects_Post_Requirement.student_post_requirements_id 
        LEFT JOIN post_requirements_TutorQualification 
            ON student_post_requirements.student_post_requirements_id = post_requirements_TutorQualification.student_post_requirements_id 
        LEFT JOIN tbl_Tutor_Schedules_Slot_Time_post_requirement 
            ON student_post_requirements.student_post_requirements_id = tbl_Tutor_Schedules_Slot_Time_post_requirement.student_post_requirements_id 
        WHERE student_post_requirements.student_post_requirements_id IN ($ids) 
        GROUP BY student_post_requirements.student_post_requirements_id"; // Ensure GROUP BY for GROUP_CONCAT

**///


if(empty($student_level) && empty($student_subjects) && !empty($student_qualification) && empty($tutor_lat) && empty($tutor_lat) && empty($tutor_long) && empty($tutor_distance) ) {

$sql = "SELECT student_post_requirements.*
        FROM student_post_requirements 
        LEFT JOIN tbl_Student_Level_Grade_Subjects_Post_Requirement 
            ON student_post_requirements.student_post_requirements_id = tbl_Student_Level_Grade_Subjects_Post_Requirement.student_post_requirements_id 
        LEFT JOIN post_requirements_TutorQualification 
            ON student_post_requirements.student_post_requirements_id = post_requirements_TutorQualification.student_post_requirements_id 
        LEFT JOIN tbl_Tutor_Schedules_Slot_Time_post_requirement 
            ON student_post_requirements.student_post_requirements_id = tbl_Tutor_Schedules_Slot_Time_post_requirement.student_post_requirements_id 
			 ";
}
else{
	
	/**
	$sql = "SELECT student_post_requirements.*, 
               tbl_Student_Level_Grade_Subjects_Post_Requirement.Level, 
               tbl_Student_Level_Grade_Subjects_Post_Requirement.Grade, 
               GROUP_CONCAT(tbl_Student_Level_Grade_Subjects_Post_Requirement.ALL_Subjects SEPARATOR ', ') AS subjects_list 
        FROM student_post_requirements 
        LEFT JOIN tbl_Student_Level_Grade_Subjects_Post_Requirement 
            ON student_post_requirements.student_post_requirements_id = tbl_Student_Level_Grade_Subjects_Post_Requirement.student_post_requirements_id 
        LEFT JOIN post_requirements_TutorQualification 
            ON student_post_requirements.student_post_requirements_id = post_requirements_TutorQualification.student_post_requirements_id 
        LEFT JOIN tbl_Tutor_Schedules_Slot_Time_post_requirement 
            ON student_post_requirements.student_post_requirements_id = tbl_Tutor_Schedules_Slot_Time_post_requirement.student_post_requirements_id 
       
        ";
		
	**/

$sql = "SELECT student_post_requirements.*
        FROM student_post_requirements 
        LEFT JOIN tbl_Student_Level_Grade_Subjects_Post_Requirement 
            ON student_post_requirements.student_post_requirements_id = tbl_Student_Level_Grade_Subjects_Post_Requirement.student_post_requirements_id 
        LEFT JOIN post_requirements_TutorQualification 
            ON student_post_requirements.student_post_requirements_id = post_requirements_TutorQualification.student_post_requirements_id 
        LEFT JOIN tbl_Tutor_Schedules_Slot_Time_post_requirement 
            ON student_post_requirements.student_post_requirements_id = tbl_Tutor_Schedules_Slot_Time_post_requirement.student_post_requirements_id 
       
        ";
		
}	
		
////////////////////










// Append WHERE conditions if present
if (!empty($whereConditions)) {
    $sql .= " WHERE " . implode(' AND ', $whereConditions);
}




/**
if(empty($student_level) && empty($student_subjects) && !empty($student_qualification) && empty($tutor_lat) && empty($tutor_lat) && empty($tutor_long) && empty($tutor_distance) ) {
$sql .= " GROUP BY student_post_requirements.student_post_requirements_id
          ORDER BY student_post_requirements.student_post_requirements_id DESC";
}

if (empty($student_level) && empty($student_subjects) && empty($student_qualification) && empty($tutor_lat) && empty($tutor_lat) && empty($tutor_long) && empty($tutor_distance) ) {
// Group and order results
$sql .= " GROUP BY student_post_requirements.student_post_requirements_id
          ORDER BY student_post_requirements.student_post_requirements_id DESC";
}

if (!empty($student_level) && !empty($student_subjects) && !empty($student_qualification) && !empty($tutor_lat) && !empty($tutor_lat) && !empty($tutor_long) && !empty($tutor_distance) ) {
// Group and order results
$sql .= " GROUP BY student_post_requirements.student_post_requirements_id
          ORDER BY student_post_requirements.student_post_requirements_id DESC";
}		  
		  

if (!empty($student_subjects) && empty($student_level) && empty($student_qualification)) {
	
// **Group by Level and Grade**
//$sql .= " GROUP BY tbl_Student_Level_Grade_Subjects_Post_Requirement.Level, 
  ///                 tbl_Student_Level_Grade_Subjects_Post_Requirement.Grade
     //     ORDER BY student_post_requirements.student_post_requirements_id DESC";
	 
	 $sql .= " GROUP BY student_post_requirements.student_post_requirements_id
          ORDER BY student_post_requirements.student_post_requirements_id DESC";

}

**/


$sql .= " GROUP BY student_post_requirements.student_post_requirements_id
          ORDER BY student_post_requirements.student_post_requirements_id DESC";




//echo $sql;

// Execute the query
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo json_encode(["error" => "Database query failed.", "details" => mysqli_error($conn)]);
    exit;
}

// Fetch and return results
$records = [];
while ($student_Search_Data = mysqli_fetch_assoc($result)) {
    //$records[] = $row;
	
	
	
	
	
	
	///////////////////////
	
	
	
	
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
										'student_lat' => $student_Search_Data['student_lat'],
										'student_long' => $student_Search_Data['student_long'],
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
	
	
	
	
	////////////////
	
	
	
	
	
	
	
}






// Return JSON response
$resultData = !empty($student_List_array) ?
    ['Status' => true, 'View_Assignment_Search_Data' => $student_List_array] :
    ['Status' => false, 'message' => 'No Result found.'];

echo json_encode($resultData);


// Return JSON response
//echo json_encode(["message" => "Success", "data" => $records]);
?>
