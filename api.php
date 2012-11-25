<?php 
/********************************
* Cron Email Report Client File
* @Author: Jermaine Byfield
* @email: mrbyfield@gmail.com
*******************/
$link = mysql_connect('localhost', 'root', 'root');
mysql_select_db('cronlog',$link);

class api {

	function api($website,$cronname,$cronmessage,$cronpathfull,$status=0){
//	if(!$website && !$cronname && !$cronmessage && !$cronpathfull)
//	die("problem here you need to enter values for the api");
		$time = date("Y-m-d H:i a");
		$sql="insert into cronlog 
				set cronname='".mysql_real_escape_string($cronname)."',
					website ='".mysql_real_escape_string($website)."',
					message = '".mysql_real_escape_string($cronmessage)."',
					cronfullpath='".mysql_real_escape_string($cronpathfull)."',
					status = '".$status."',
					timeran = '".$time ."'
				";
		mysql_query($sql) ;
		if(!mysql_error()){
			
			
			
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$subject = "$cronname from $website @".$time." and it was ".($status? "SUCCESSFULL":"UN-SUCCESSFULL") ;
			// Additional headers
			$to = 'To: sheldon@example.net' . "\r\n";
			$headers .= 'From: Cron Log Api <fromname@example.net>' . "\r\n";
			$headers .= 'Bcc: YourName@example.net' . "\r\n";
			$message = "Below is the Response we've recieved from $cronname: <br><br>".$cronmessage;
			// Mail it
			mail($to, $subject, $message, $headers);
		}else{
		
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$subject = "$cronname from $website @".$time; 
			// Additional headers
			$to = 'To: YourName@example.net' . "\r\n";
			$headers .= 'From: Cron Log Api <support@example.net>' . "\r\n";
			//$headers .= 'Bcc: YourName@example.net' . "\r\n";
			$message = "Mysql failed because ".mysql_error();
						// Mail it
			mail($to, $subject, $message, $headers);
		
		}		
	}
	
	
}


function requestMETHOD(){
        $request_method = strtolower($_SERVER['REQUEST_METHOD']);
        $data = array();
        switch ($request_method)
                {
                        // gets are easy...
                        case 'get':
                                $data = $_GET;
                                break;
                        // so are posts
                        case 'post':
                                $data = $_POST;
                                break;
                        // here's the tricky bit...
                        case 'put':
                                // basically, we read a string from PHP's special input location,
                                // and then parse it out into an array via parse_str... per the PHP docs:
                                // Parses str  as if it were the query string passed via a URL and sets
                                // variables in the current scope.
                                parse_str(file_get_contents('php://input'), $put_vars);
                                $data = $put_vars;
                                break;
                }

                return $data;
}
$data = requestMETHOD();

new api($data['website'],$data['cronname'],$data['cronmessage'],$data['cronpathfull'],$data['status']);
?>