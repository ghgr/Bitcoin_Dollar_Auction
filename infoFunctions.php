<?php

	require_once ("./globalVariables.php");

	
	
	function getCurrentBlock()
	{

		return intval(file_get_contents("current_block"));	
	}
	
	function getGoalBlock()
	{					
		return intval(file_get_contents("goal_block"));	
	}
	
	
	function getBote()
	{
	
		return intval(file_get_contents("bote"));	
	
	}
	
	
	
	function listPayments($lim)
	{
		global $HOST, $USERNAME, $PASSWORD, $ADDRESS, $DB_NAME;
		
		$idconnection=mysql_connect($HOST, $USERNAME,$PASSWORD)
		or die("Connection BDD Impossible");
		mysql_select_db($DB_NAME, $idconnection);	
		
		$Query="Select * From bote ORDER BY block_found DESC LIMIT 0,$lim";
		
		$Res = mysql_query($Query, $idconnection);
		
		
		echo "<table align='center' border=0 cellspacing=0 cellpadding=10>\n";
		echo "<tr>\n<td><b>Block</b></td>\n<td><b>Address</b></td>\n</tr>";
		while ($elem = mysql_fetch_array($Res))
		{
			echo "<tr>\n<td>$elem[2]</td>\n<td>$elem[1]";
			echo "<br/><a href='http://blockexplorer.com/address/$ADDRESS'>...</a>";
			echo "</td>\n</tr>";
		}
		echo "</table>";
		
		//CLOSE DB
		mysql_close($idconnection);
	}
		
	
?>