<?php


		require_once '/home/bitcoind/php/Net/SMTP.php';

		if (file_exists("../globalVariables.php")){require_once("../globalVariables.php");}
		if (file_exists("./globalVariables.php")) {require_once("./globalVariables.php");}
				 

		
		function addEmail($idconnection, $email)
		{
			$unsubscribe_value = hash('ripemd160', strval(rand(1,100000000)+intval(microtime(true))));						

			// Already in DB?
			$Query="Select * From emails WHERE email='$email'";
			$Res = mysql_query($Query, $idconnection);
			if (mysql_fetch_array($Res))
			{
				return 0;
			}else
			{
				mysql_query("INSERT INTO emails (email,unsubscribe) VALUES('$email','$unsubscribe_value') ") 
				or die(mysql_error());  
			return 1;
			}
			
		
		}
		
		
		function listAll($idconnection)
		{

			echo "<br/>**********************<br/>";
			$Query="Select * From emails";
			$Res = mysql_query($Query, $idconnection);			
			while ($elem = mysql_fetch_array($Res)){
				echo "$elem[0]: $elem[1], $elem[2], $elem[3]<br/>";				
			}						
			echo "<br/>**********************<br/>";		
			
		}
		
		
		function notifyAll($idconnection)
		{
			global $MESSAGE_EMAIL, $MAIL;
			
			$Query="Select email,unsubscribe From emails WHERE notified=0";
			$Res = mysql_query($Query, $idconnection);						
			while ($elem = mysql_fetch_array($Res)){

				$message = "$MESSAGE_EMAIL. To Unsubscribe, click http://www.bitcoindollarbet.com/sendMail/unsubscribe.php?code=$elem[1]";
			
				sendMail($elem[0],$message);
	
			}	
			
			mysql_query("UPDATE emails SET notified = 1")		
			or die(mysql_error());  											
		
		}
		
		function clearNotifications($idconnection)
		{
			mysql_query("UPDATE emails SET notified = 0")		
			or die(mysql_error());  			
		
		}
		
		function unsubscribe($value)
		{
			
			$Res = mysql_query("SELECT email from emails WHERE unsubscribe='$value'");			
			$elem = mysql_fetch_array($Res);
						
			if ($elem)
			{				
				echo "<br/>Bye $elem[0] :-( <br/>";
				mysql_query("DELETE FROM emails WHERE unsubscribe = '$value'")		
				or die(mysql_error()); 		
			}else
			{
				echo "<br/>Incorrect code $value<br/>";
			}
		
		}
				
	function sendMail($rcpt,$message)
	{

		global $EMAIL_HOST, $EMAIL_FROM, $EMAIL_SUBJECT, $EMAIL_USERNAME, $EMAIL_PASSWORD, $EMAIL_PORT;
		
		$headers = "From: Info Bitcoin Dollar Bet<$EMAIL_FROM>\r\nSubject: $EMAIL_SUBJECT";
		if (! ($smtp = new Net_SMTP($EMAIL_HOST, $EMAIL_PORT, "localhost"))) {
			die("Unable to instantiate Net_SMTP object\n");
		}
		
		if (PEAR::isError($e = $smtp->connect())) {
			die($e->getMessage() . "\n");
		}
		
		if (PEAR::isError($e = $smtp->auth($EMAIL_USERNAME, $EMAIL_PASSWORD))) {
		}
		
		if (PEAR::isError($smtp->mailFrom($EMAIL_FROM))) {
			die('Unable to set sender to <' . $EMAIL_FROM . ">\n");
		}
		
		if (PEAR::isError($res = $smtp->rcptTo($rcpt))) {
			die('Unable to add recipient <' . $rcpt . '>: ' .
				$res->getMessage() . "\n");
		}
		
		if (PEAR::isError($smtp->data($message,$headers))) {
			die("Unable to send data\n");
		}
	
	
	$smtp->disconnect();

}
?>