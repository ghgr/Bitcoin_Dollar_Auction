<?php

		require_once "../globalVariables.php";
		require_once "./mailFunctions.php";
		
		
		global $HOST, $USERNAME, $PASSWORD, $DB_NAME;
		

		if (isset($_GET["code"]))
		{
			$code = mysql_escape_string($_GET["code"]);
		
		
			// Open DB
			$idconnection=mysql_connect($HOST, $USERNAME, $PASSWORD)
			or die("Connection BDD Impossible");	
			mysql_select_db($DB_NAME, $idconnection);
		
			
				
			unsubscribe($code);
		
		
		
			// Close DB
			mysql_close($idconnection);
			
		}
?>