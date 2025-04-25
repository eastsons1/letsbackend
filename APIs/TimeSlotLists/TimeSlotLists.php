<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");
//require_once("dbcontroller.php");
header('content-type:application/json');

	
		$query = "SELECT * FROM tbl_time_slots_type ORDER BY time_slots_type_id ASC ";
				
			
		$result = $conn->query($query) or die ("table not found");
		$numrows = mysqli_num_rows($result);
		
		
		if($numrows > 0)
		{
		  
		  $Time_Slots_Type_Array = array();
		  
		  $Response = array();
		  
			while($Time_Slots_Type = mysqli_fetch_assoc($result))
			{
				$Time_Slots_Type_Array[] = $Time_Slots_Type;
				
				$Slots_Timing_Array = array();
				
				$query_timings = $conn->query("SELECT * FROM tbl_time_slots_type_timings WHERE slots_type_id = '".$Time_Slots_Type['time_slots_type_id']."' ");
				
				while($Slots_Time_Data = mysqli_fetch_assoc($query_timings))
				{
					if($Slots_Time_Data['slot_book_or_available']==0)
					{
						$Slots_Timing_Array[] = $Slots_Time_Data;
					}	
				}
				
				
					$Response[] = array('time_slots_type_id' => $Time_Slots_Type['time_slots_type_id'],
										'time_slots_type' => $Time_Slots_Type['time_slots_type'],
										'Slot_Times' => $Slots_Timing_Array
										);
				
				
			}	
			
			
			
			
			if(!empty($Response))
			{
				$resultData = array('Status' => true, 'Available_Slots_Time_Details' => $Response);
			}
			else			
			{
				$resultData = array('Status' => false, 'Message' => 'No Record Found.');
			}				
			
			
		}
		else 
		{
			
			$resultData = array('Status' => false, 'Message' => 'No Record Found.');
		}
				
							
			echo json_encode($resultData);
					
			
?>