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
			
			
			
			// Extracting row by row
			foreach($array as $row => $value) 
			{
						
			/**	if($value["product_title"] !="" && $value["product_number"] != 0 && $value["logged_in_user_id"] != 0 && $value["product_price"] != 0.00 && $value["thickness_type"] != "")
				{	
					$arrayV[] = "('".$value["sub_category"]."','".$value["other_sub_category"]."','".$value["product_brand"]."','".$value["product_title"]."','".$value["selection_choice"]."','".$value["product_number"]."','".$value["where_are_leathers_comp_address"]."','".$value["where_are_leathers_other_address"]."','".$value["inspection_possible"]."','".$value["product_price"]."','".$value["product_desc"]."','".$value["product_keywords"]."','".$value["product_language"]."','".$value["logged_in_user_id"]."','".$value["needExpert"]."','".$value["weightCatType"]."','".$value["weightSelectionSize"]."','".$value["surfaceCatType"]."','".$value["surfaceSelectionSize"]."','".$value["tableRollLeatherQty"]."','".$value["tableRollLeatherQtySelection"]."','".$value["tableRollLeatherPrice"]."','".$value["selectionPrice"]."','".$value["selectionQtyPrice"]."','".$value["Price"]."','".$value["Qty"]."','".$value["thiknessType"]."','".$value["thinkessFrom"]."','".$value["thinknessTo"]."','".$value["lastInfo"]."','".$value["goodsInspected"]."','".$value["addProductType"]."','".$value["created_date"]."')";				
				}
			**/
				
								
				
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
				
			}
			
			
			foreach($value as $row2 => $value2) 
			{
					
					if($value2["Levels_search"] != "" )
					{	
						$arrayV2[] = "('".$value2["Levels_search"]."')";				
					}	
					if($value2["subject_search"] != "" )
					{	
						$arrayV3[] = "('".$value2["subject_search"]."')";				
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
						if(empty($arrayV2))
						{
							$resultData = array('Status' => false, 'Message' => 'Please Select Levels.');
						}
						if(empty($arrayV3))
						{
							$resultData = array('Status' => false, 'Message' => 'Please Select Subjects.');
						}
					
							//$resultData = array('Status' => false, 'Message' => 'Please Select Data.');
							
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
							$Subject_search_array = implode(', ', $arrayV3);
						}
						else{
							$Subject_search_array = "''";
						}
						
						if(!empty($arrayV4))
						{
							$postal_array = implode(', ', $arrayV4);
						}
						
						if(!empty($arrayV5))
						{						
							$tuition_type_array = implode(', ', $arrayV5);
						}
						
						
						
						if($Levels_search_array || $postal_array || $tuition_type_array || $Subject_search_array)
						{
							
							
							
							//$sql2 = $conn->query('SELECT * FROM user_info JOIN tutor_totoring_levels ON user_info.user_id = tutor_totoring_levels.user_id JOIN tutor_tutorial_subjects ON tutor_tutorial_subjects.user_id = user_info.user_id JOIN user_tutor_info ON user_tutor_info.user_id = tutor_totoring_levels.user_id WHERE user_tutor_info.tuition_type IN('.$tuition_type_array.') and user_tutor_info.postal_code IN('.$postal_array.') or tutor_totoring_levels.Tutoring_Level IN('.$Levels_search_array.') or tutor_tutorial_subjects.Tutoring_Subjects IN('.$Subject_search_array.') GROUP BY user_tutor_info.user_id');
							
							$sql2 = $conn->query('SELECT * FROM user_info JOIN tutor_totoring_levels ON user_info.user_id = tutor_totoring_levels.user_id JOIN tutor_tutorial_subjects ON tutor_tutorial_subjects.user_id = user_info.user_id JOIN user_tutor_info ON user_tutor_info.user_id = tutor_totoring_levels.user_id WHERE user_tutor_info.tuition_type IN('.$tuition_type_array.') and user_tutor_info.postal_code IN('.$postal_array.') and tutor_totoring_levels.Tutoring_Level IN('.$Levels_search_array.') and tutor_tutorial_subjects.Tutoring_Subjects IN('.$Subject_search_array.') GROUP BY user_tutor_info.user_id');				
							
							
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
									
									
									$tutor_extra_data = mysqli_fetch_array($conn->query("select * from user_tutor_info where user_id = '".$tutor_Search_Data['user_id']."' "));
									$getFlag = mysqli_fetch_array($conn->query("select * from country where countryname = '".$tutor_extra_data['nationality']."' "));
										
										
										if($getFlag['code'] !="")
										{
											$getFlagName = strtolower($getFlag['code']).'.png';

											$flag_path = 'https://refuel.site/projects/tutorapp/flags-medium/'.$getFlagName;
										}
										else{
											
											$getFlagName = '';
											$flag_path = '';
										}
										
										$FlagName = array('Country_Flag_Name'=>$getFlagName,'Country_Flag_Path'=>$flag_path);
										$Output[] = array_merge($tutor_Search_Data,$FlagName);
									
									
									
									///$Output[] = $tutor_Search_Data;
									
									/**
									
										if($tutor_Search_Data['email'] != "")
										{
											
												$response[] = array(
																	"user_id" => $tutor_Search_Data['user_id'],
																	"adminusername" => $tutor_Search_Data['adminusername'],
																	"first_name" => $tutor_Search_Data['first_name'],
																	"last_name" => $tutor_Search_Data['last_name']
																	
																	
																	
																);
																
										}
									**/	
									
									
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