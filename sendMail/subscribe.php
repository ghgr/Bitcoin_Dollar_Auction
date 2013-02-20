<?php


		require_once "../globalVariables.php";
		require_once "./mailFunctions.php";		
		
		global $HOST, $USERNAME, $PASSWORD, $DB_NAME;
		

		if (isset($_GET["email"]))
		{
								
			$idconnection=mysql_connect($HOST, $USERNAME, $PASSWORD)
			or die("Connection BDD Impossible");	
			mysql_select_db($DB_NAME, $idconnection);
				
			$email = mysql_escape_string($_GET["email"]);
			
			
			
			$ret_value = addEmail($idconnection, $email);
		
		
		
			// Close DB
			mysql_close($idconnection);
			
			echo $ret_value;
			
		}
?>