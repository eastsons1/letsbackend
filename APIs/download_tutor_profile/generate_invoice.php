<?php
error_reporting(0);
session_start(); 
// Include autoloader 
require_once 'dompdf/autoload.inc.php'; 
//require_once 'dompdf/autoload.inc.php'; 


 
// Reference the Dompdf namespace 
use Dompdf\Dompdf; 
 use Dompdf\Options;
// Instantiate and use the dompdf class 

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

//$dompdf = new Dompdf();



//ob_start();	
//session_start(); 
//include('config.php');

$servername = "localhost";
$username = "mytutors_tutorapp_ver3";
$password = "^%&^*&TYY6567*(&uyur$7";
$dbname = "mytutors_tutorapp_ver3";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 



///Quatation Generate start


	
	 
	
	
	
	/// Display image in pdf function start
	function encode_img_base64($img_path = false): string
	{
		if($img_path){
			$path = $img_path;
			$type = pathinfo($path, PATHINFO_EXTENSION);
			$data = file_get_contents($path);
			return 'data:image/' . $type . ';base64,' . base64_encode($data);
		}
		return '';
	}
	
	 
	
	/// Display Logo
	
	$logo_pdf = encode_img_base64('1_10.png');
	
	
	
	// Fetch user data
	
	$tutor_booking_process_id  = $_GET['tutor_booking_process_id'];
	
	$user_id = $_GET['user_id'];
	
	
	$user_type = mysqli_fetch_array($conn->query("SELECT user_type FROM user_info  WHERE user_id = '".$user_id."' ")
);
	
	
	$tutor_info = mysqli_fetch_array(
    $conn->query("SELECT info.first_name,info.last_name,info.mobile, info.created_date, tinfo.profile_image,tinfo.tutor_code,tinfo.qualification FROM user_tutor_info as tinfo INNER JOIN user_info as info ON tinfo.user_id = info.user_id WHERE info.user_id = '".$user_id."' ")
);


$User_name = mysqli_fetch_array(
    $conn->query("SELECT first_name,last_name FROM user_info WHERE user_id = '".$user_id."' ")
);


		$booking_data = mysqli_fetch_array($conn->query("SELECT * FROM tutor_booking_process as bookp INNER JOIN tutor_booking_process_discount as bpdiscount ON bookp.tutor_booking_process_id = bpdiscount.tutor_booking_process_id WHERE bookp.tutor_booking_process_id = '".$tutor_booking_process_id."' AND  bookp.student_date_time_offer_confirmation = 'Confirmed' AND bookp.api_hit_date_by_confirmed_user <> '' AND bookp.acceptby <> '' 
											AND bookp.booked_date <> '' 
											AND bookp.tutor_booking_status = 'Completed' 
											AND bookp.offer_status = 'Accept' "));
											
											
		$booking_data_amount = mysqli_fetch_array($conn->query("SELECT * FROM tutor_booking_process as bookp WHERE tutor_booking_process_id = '".$tutor_booking_process_id."'  "));									
		
		
		if($booking_data_amount['amount_negotiate_by_tutor'] == 0.00 && $booking_data_amount['negotiate_by_tutor_amount_type'] == "" && $booking_data_amount['amount_negotiate_by_student'] == 0.00 && $booking_data_amount['negotiate_by_student_amount_type'] == "" )
		{
			$final_accepted_amount = $booking_data_amount['tutor_tution_offer_amount'];
		}
		
		if($booking_data_amount['amount_negotiate_by_tutor'] != 0.00 && $booking_data_amount['negotiate_by_tutor_amount_type'] == "Negotiable" && $booking_data_amount['amount_negotiate_by_student'] != 0.00 && $booking_data_amount['negotiate_by_student_amount_type'] == "Negotiable" )
		{
			
			if($booking_data_amount['negotiateby'] == "student")
			{
				
				$final_accepted_amount = $booking_data_amount['amount_negotiate_by_student'];
			}
			
			if($booking_data_amount['negotiateby'] == "tutor")
			{
				
				$final_accepted_amount = $booking_data_amount['amount_negotiate_by_tutor'];
			}
			
			
		}
		
	$Invoice_code = $booking_data_amount['Invoice_code'];
	$tutor_duration_weeks = $booking_data_amount['tutor_duration_weeks'];
	$tutor_duration_hours = $booking_data_amount['tutor_duration_hours'];
	
	$tutor_duration_weeks_Val = explode(" lessons a week",$tutor_duration_weeks);
	$week_val = $tutor_duration_weeks_Val[0];
	
	$tutor_duration_hours_Val = explode(" hours a lesson",$tutor_duration_hours);
	$hours_val = $tutor_duration_hours_Val[0];
	
	
	$total_Hours = 4*$week_val*$hours_val;

	$total_Fee_in_1_month = $total_Hours * $final_accepted_amount;
	
	$patment_in_Terms = $total_Fee_in_1_month/2;
	
	$you_save1 = $patment_in_Terms*.1;
	
	$you_save = number_format($you_save1, 2);
	
	//echo $booking_data['count_of_discount'];
	
	if($booking_data['count_of_discount']==1)
	{
		$Due_amount1 = $patment_in_Terms - $you_save;
		$Due_amount = number_format($Due_amount1, 2); //number_format($booking_data['Amount_to_Company_with_discount'], 2);
	}
	else{
		$Due_amount = $patment_in_Terms;
	}
	
		//$Due_amount = $patment_in_Terms; //number_format($Due_amount1, 2);
	
	$half_Hours = $total_Hours/2;

//echo $tutor_info['profile_image'];

// Extract user details
	$tutor_name = $tutor_info['first_name'] . ' ' . $tutor_info['last_name'];
	$profile_image = 'https://mytutors.moe/version3/UPLOAD_file/' . $tutor_info['profile_image'];
	$tutor_code = $tutor_info['tutor_code'];
	$qualification = $tutor_info['qualification'];
	$mobile = $tutor_info['mobile'];
	$created_date = $tutor_info['created_date'];
	
	$formatted_date = date("d M Y", strtotime($booking_data_amount['api_hit_date_by_confirmed_user']));
	
	$formatted_time = $booking_data_amount['api_hit_time_by_confirmed_user'];
	
	$dd = explode("-",$created_date);  //10-11-2024
	//print_r($dd);
	//$dd2 = explode("-",$dd[1]);
	 $month = $dd[1];
	 $year = $dd[2];
	$showDate = $month.'/'.$year;
	
	
	$tutor_img2 = encode_img_base64($profile_image);
	
	
	if($user_type['user_type'] == "I am looking for a Tutor")
	{
		$invoice_code = 'Invoice No: ' . $Invoice_code;
	}
	if($user_type['user_type'] == "I am an Educator")
	{
		$invoice_code =  'Customer\'s Copy (FYI Only)';
	}
	
	
	
	$first_character = substr($User_name['first_name'], 0, 1); 
	$first_character_L = substr($User_name['last_name'], 0, 1); 
	$DPName = $first_character;
	$DPName2 = $first_character_L;
	
	
	
	if($booking_data_amount['promocode'] == 1)
	{
	
	 $PROMO_SHOW = '<div class="promo-section1">
		<div id="promo">PromoCode: Welcome Gift</div>
		
		</div>
		 <div class="promo-section2" id="save">
			<div id="save">You Save: SGD ' . $you_save . '</div>
		</div>';
				
	}			

		
	/**
	if($tutor_img2 == "")
	{
		$first_character = substr($tutor_info['first_name'], 0, 1); 
		$first_character_L = substr($tutor_info['last_name'], 0, 1); 
		$DPName = $first_character.$first_character_L;
		
	}
	else
	{
		$tutor_img = $tutor_img2;
		$DPName = '<img src="'.$tutor_img.'" style="width: 100px;max-width:135px;border-radius: 50%;margin: 0 23px 0 0px;height: 100px;box-shadow: 1px 5px 25px #ccc;">';
	}
	**/
	
	/// Display image in pdf function end
						

	

		
		$html = '<html style="background: #F3FAFA;" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Example</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            padding: 10px;
        }

        #main_box {
            width: 97%;
            background: #2e5597;
            border-radius: 10px;
            padding: 10px;
            color: #fff;
            overflow: hidden;
        }

        #header_part {
            padding: 10px 0;
            background: #fff;
            color: #000;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        #logo {
			width: 81px;
			margin: 24px;
			border: 1px solid #ccc;
			height: 81px;
			border-radius: 50%;
			text-align: center;
			vertical-align: middle;
        }
		#logo_textDiv{text-align: center;vertical-align: middle; padding:25% 0 0 3px; font-weight:bold;font-size:37px; }
		#logo_text{text-align: center;vertical-align: middle; padding:25% 0 0 3px; font-weight:bold;font-size:37px; color:#fe0100;}
		#logo_text2{text-align: center;vertical-align: middle; padding:25% 0 0 3px; font-weight:bold;font-size:37px; color:#000000;}

        #member_title {
            font-size: 16px;
            font-weight: bold;
            padding-right: 10px;
            text-align: right;
        }

        #middle_part {
            padding: 20px 10px;
            background: #eeeeee;
        }

        #middle_partTop {
            padding: 10px 0;
            text-align: center;
        }

        #Inner_middle_part {
            padding: 10px;
            margin: 10px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 1px 5px 15px #ccc;
        }

        ul {
            list-style-type: disc;
            margin: 10px 20px;
            padding: 0;
            font-size: 14px;
        }

        li {
            margin-bottom: 5px;
        }
		.promo-section {
            padding: 10px;
            background: #F6BE00;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            border-radius: 10px;
        }
        .promo-section1 {
            padding: 10px;
            background: #F6BE00;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            border-radius: 10px 10px 0 0;
        }
		.promo-section2 {
            padding: 10px;
            background: #F6BE00;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            border-radius: 0px 0px 10px 10px;
        }

        .footer-section {
            text-align: center;
            color: #999;
            margin-top: 10px;
        }

        .footer-section div {
            margin-bottom: 5px;
            font-size: 14px;
        }
		#cal{
    font-size: 12px;
    color: #000;
    font-weight: bold;
    text-decoration: underline;
		}
		#cal_cont{
    font-size: 12px;
    color: #000;
    
		}
		#cal_cont_h{
    font-size: 14px;
    color: #000;
    text-align:center;
	color:#2e5597;
	 font-weight: bold;
		}
		
		#payterms{
    font-size: 12px;
    color: #000000;
    font-weight: bold;
    text-decoration: underline;
		}
	#payterms_u{
    font-size: 12px;
    color: #000;
		}
		
	#amount_due{	
    background: #2e5597;
    padding: 8px 0 8px 0;

		}
		#footer_c{color:#000;}
		#promo{color:#000000;}
		#save{background:#ffffff; color:#000000;}
    </style>
</head>
<body>
    <div class="container">
        <div id="main_box">
            <div id="header_part">
                <div id="logo"><div id="logo_textDiv"><span id="logo_text">' . $DPName . '</span><span id="logo_text2">' . $DPName2 . '</span></div></div>
                <div id="member_title">' . $formatted_date . '<br>'.$formatted_time.'</div>
            </div>

            <div id="middle_partTop">
                <div>'.$invoice_code.'</div>
            </div>

            <div id="middle_part">
                <div id="Inner_middle_part">
                    <div id="cal">Calculation:</div>
                    <div id="cal_cont">Agreed Fee: ' . $final_accepted_amount . '</div>
                    <div id="cal_cont">Frequency: ' . $tutor_duration_weeks . '</div>
                    <div id="cal_cont">Duration: ' . $tutor_duration_hours . '</div>
                    <div id="cal_cont">Total hours in 1 month (4 weeks): ' . $total_Hours . ' hours</div>
                    <div id="cal_cont_h">Fee in 1 month (4 weeks): SGD ' . $total_Fee_in_1_month . '</div>
                </div>

                <div id="Inner_middle_part">
                    <div id="payterms">Payment terms for 1st month/4 weeks:</div>
                    <ul id="payterms_u">
                        <li>First ' . $half_Hours . ' hours of Tuition Fee (SGD ' . $patment_in_Terms . ') to be paid to My Tutors Pte. Ltd. within 24 hours.</li>
                        <li>Balance ' . $half_Hours . ' hours of Tuition Fee (SGD ' . $patment_in_Terms . ') to be paid to the tutor.</li>
                    </ul>

                    <div id="payterms">Payment terms for subsequent months:</div>
                     <ul id="payterms_u">
                        <li>Tutor will collect full payment through mutual arrangement.</li>
                    </ul>
                </div>

               '.$PROMO_SHOW.'

                <div id="middle_partTop">
                    <div id="amount_due">Amount Due Now: SGD ' . $Due_amount . '</div>
                </div>

                <div class="footer-section">
                    <div id="footer_c">My Tutors Pte. Ltd.</div>
                    <div id="footer_c">UEN: 6989888D</div>
                    <div id="footer_c">You are smarter than you think</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>';

	 
	 
	 
	//echo $html;



	$dompdf->loadHtml($html);




///Quatation Generate end



 
// (Optional) Setup the paper size and orientation 
//$dompdf->setPaper('A4', 'landscape'); 
$dompdf->setPaper('A4', 'portrait'); // Use 'portrait' for vertical layout



// Render the HTML as PDF 
$dompdf->render(); 
 


		//$output = $dompdf->output();

		//$company_details_pdf_file = "pdf_filename_".rand(10,1000).".pdf";

		//file_put_contents("pdf/".$company_details_pdf_file, $output);



// Stream PDF to browser
$dompdf->stream('Booking_invoice.pdf', ['Attachment' => true]);


// End script
exit;

?>