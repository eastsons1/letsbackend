<?php

/**
$to='eastsons@gmail.com';
$subject='Application Form ';
$message='testing';

$from = "support@yahoo.com";

 	$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .=  'X-Mailer: PHP/'. phpversion();
				//$headers .= 'Bcc: test@yahoo.com' . "\r\n";
				$headers .= 'From: $from' . "\r\n";		
				$headers .= 'Reply-To: support@gmail.com' . "\r\n";	
				//$headers .= "BCC: support@yahoo.com";
				//$headers .= "CC: support@yahoo.com";				
				
				
			
				
				
 if(mail($to,$subject,$message,$headers))
 {
  echo "Mail Successfully Sent..";
  exit;
 }
 

 **/
 

 
 ?>
 
 
<?php 
 $to2 = "eastsons@gmail.com, pushpendra@eastsons.com";
            $subject = "Hello";
            $headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .=  'X-Mailer: PHP/'. phpversion();
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= 'From: successive.testing@gmail.com' . "\r\n";
            $message = "<html><head>" .
                   "<meta http-equiv='Content-Language' content='en-us'>" .
                   "<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>" .
                   "</head><body>".     
                   "<br><br></body></html>";
          if(@mail($to2, $subject, $message, $headers))
		  {
  echo "1";
  exit;
 }
?>