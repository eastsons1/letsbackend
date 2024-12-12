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
			$arrayV4 = array();
			$arrayV5 = array();
			$arrayV6 = array();
			$arrayV7 = array();
			$arrayV8 = array();
			
			
			
			// Extracting row by row
			foreach($array as $row => $value) 
			{
						
			/**	if($value["product_title"] !="" && $value["product_number"] != 0 && $value["logged_in_user_id"] != 0 && $value["product_price"] != 0.00 && $value["thickness_type"] != "")
				{	
					$arrayV[] = "('".$value["sub_category"]."','".$value["other_sub_category"]."','".$value["product_brand"]."','".$value["product_title"]."','".$value["selection_choice"]."','".$value["product_number"]."','".$value["where_are_leathers_comp_address"]."','".$value["where_are_leathers_other_address"]."','".$value["inspection_possible"]."','".$value["product_price"]."','".$value["product_desc"]."','".$value["product_keywords"]."','".$value["product_language"]."','".$value["logged_in_user_id"]."','".$value["needExpert"]."','".$value["weightCatType"]."','".$value["weightSelectionSize"]."','".$value["surfaceCatType"]."','".$value["surfaceSelectionSize"]."','".$value["tableRollLeatherQty"]."','".$value["tableRollLeatherQtySelection"]."','".$value["tableRollLeatherPrice"]."','".$value["selectionPrice"]."','".$value["selectionQtyPrice"]."','".$value["Price"]."','".$value["Qty"]."','".$value["thiknessType"]."','".$value["thinkessFrom"]."','".$value["thinknessTo"]."','".$value["lastInfo"]."','".$value["goodsInspected"]."','".$value["addProductType"]."','".$value["created_date"]."')";				
				}
			**/
				
								
				if($value["Levels_search"] != "" )
				{	
					$arrayV2[] = "('".$value["Levels_search"]."')";				
				}	
				if($value["Qualification"] != "" )
				{	
					$arrayV3[] = "('".$value["Qualification"]."')";				
				}
				
				if($value["postal_code"] != "" || $value["postal_code"] != NULL )
				{	
					$postal_code = $value["postal_code"];			
					$arrayV4[] = "('".$value["postal_code"]."')";	
					
				}
				
				if($value["tuition_type"] != "" )
				{	
					$tuition_type = $value["tuition_type"];	
					$arrayV5[] = "('".$value["tuition_type"]."')";					
				}	
				
				if($value["Gender"] != "" )
				{	
					$Gender = $value["Gender"];	
					$arrayV6[] = "('".$value["Gender"]."')";					
				}
				
				if($value["Time_status"] != "" )
				{	
					$Time_status = $value["Time_status"];	
					$arrayV7[] = "('".$value["Time_status"]."')";					
				}
				if($value["Nationality"] != "" )
				{	
					$Nationality = $value["Nationality"];	
					$arrayV8[] = "('".$value["Nationality"]."')";					
				}				
				
			}
			
			
			
				if(empty($arrayV5))
				{
					$resultData = array('Status' => false, 'Message' => 'Tuition Type Can Not Empty.');
					echo json_encode($resultData);
					
				}
				else
				{
			
			
					if(empty($arrayV4))
					{
						$resultData = array('Status' => false, 'Message' => 'Postal Code Can Not Empty Or Enter Correct Postal Code.');
						echo json_encode($resultData);
						
					}
					else
					{
					
					
					
					
					if(empty($arrayV2) || empty($arrayV3) || empty($arrayV4) || empty($arrayV5))
					{
					
							$resultData = array('Status' => false, 'Message' => 'Please Select Data.');
							
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
						
						if(!empty($arrayV3))
						{
							$Qualification_search_array = implode(', ', $arrayV3);
						}
						else{
							$Qualification_search_array = "''";
						}
						
						if(!empty($arrayV4))
						{
							$postal_array = implode(', ', $arrayV4);
						}
						
						if(!empty($arrayV5))
						{						
							$tuition_type_array = implode(', ', $arrayV5);
						}
						
						if(!empty($arrayV6))
						{
							$Gender_array = implode(', ', $arrayV6);
						}
						else{
							$Gender_array = "''";
						}
						
						if(!empty($arrayV7))
						{
							$Time_status_array = implode(', ', $arrayV7);
						}
						else{
							$Time_status_array = "''";
						}
						
						if(!empty($arrayV8))
						{
							$Nationality_array = implode(', ', $arrayV8);
						}
						else{
							$Nationality_array = "''";
						}
						
						
						
						if($Levels_search_array || $postal_array || $tuition_type_array || $Qualification_search_array || $Gender_array || $Time_status_array || $Nationality_array)
						{
							
							$sql2 = $conn->query('SELECT * FROM user_info JOIN tutor_totoring_levels ON user_info.user_id = tutor_totoring_levels.user_id JOIN user_tutor_info ON user_tutor_info.user_id = tutor_totoring_levels.user_id WHERE user_tutor_info.tuition_type IN('.$tuition_type_array.') and user_tutor_info.postal_code IN('.$postal_array.') or tutor_totoring_levels.Tutoring_Level IN('.$Levels_search_array.') or user_tutor_info.qualification IN('.$Qualification_search_array.') or user_tutor_info.gender IN('.$Gender_array.') or user_tutor_info.tutor_status IN('.$Time_status_array.') or user_tutor_info.nationality IN('.$Nationality_array.') GROUP BY user_tutor_info.user_id');
							
							
							if(mysqli_num_rows($sql2)>0)
							{
								$tutor_sql = $sql2;
								
							}
							else
							{
								$resultData = array('Status' => false, 'Message' => 'No Search Result.');
								
							}
						}
						
						
						
						
								$tutor_List_array = [];
							
								while($tutor_Search_Data = mysqli_fetch_assoc($tutor_sql))	
								{
									
									
									
										$Output[] = $tutor_Search_Data;
									
									
								}	
						
						
							if(!empty($Output))
							{
							
								$resultData = array('Status' => true, 'Tutor_Search_Data' => $Output);
							}	
							else
							{
								$resultData = array('Status' => false, 'message' => 'No Result found. Insert right search keyword.');
							}
						
						
				
					}
					
					
					echo json_encode($resultData);
					
					}	
				}
					
?>