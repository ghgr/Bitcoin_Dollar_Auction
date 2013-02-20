<?php

	require_once ("./globalVariables.php");
	require_once ("./database/DBFunctions.php");
	require_once ("./sendMail/mailFunctions.php");


		
	function calculateGoalBlock($current_block)
	{
		global $INCREASE_BLOCK,$MIN_BET,$ADDRESS,$HOST, $USERNAME, $PASSWORD, $DB_NAME;


		
		$idconnection=mysql_connect($HOST, $USERNAME,$PASSWORD)
		or die("Connection BDD Impossible");
		mysql_select_db($DB_NAME, $idconnection);


		addElementsToDB($idconnection,$INCREASE_BLOCK,$ADDRESS,$MIN_BET);
		$winners=updateWinners($idconnection,$current_block);


		if ($winners or file_exists("winner"))
		{
			touch("winner");			
		}

	
		

		// Get max BLOCK_OBJ
		$Query="Select max(block_obj) From bote";
		$Res = mysql_query($Query, $idconnection);
		$elem = mysql_fetch_array($Res);
		if ($elem[0]==NULL) { $max_block_obj=0;}
		else {$max_block_obj=$elem[0];}
		
		//CLOSE DB
		mysql_close($idconnection);
		
		return $max_block_obj;

	}
		
	$current_time = microtime(true);
	/* CHECK TIME, */
	if (($current_time-intval(file_get_contents("time")))>$UPDATE_AFTER_THESE_SECONDS)
	{
	
		//echo "UPDATING...<br/>";
		// UPDATE ALL
		$average_sec_block = floatval(file_get_contents('http://blockchain.info/q/interval'));	
		$current_block = intval(file_get_contents('http://blockchain.info/q/getblockcount'));
		$timestamp_current_block = intval(microtime(true));

		$goal_block = calculateGoalBlock($current_block);
		// Bote is automatically calculated in calculateGoalBlock(...)
		
		$myFile = "average_sec_block";
		$fh = fopen($myFile, 'w') or die("can't open file");
		fwrite($fh, $average_sec_block);
		fclose($fh);

		$myFile = "current_block";
		$fh = fopen($myFile, 'w') or die("can't open file");
		fwrite($fh, $current_block);
		fclose($fh);

		$myFile = "time";
		$fh = fopen($myFile, 'w') or die("can't open file");
		fwrite($fh, $timestamp_current_block);
		fclose($fh);	

		$myFile = "goal_block";
		$fh = fopen($myFile, 'w') or die("can't open file");
		fwrite($fh, $goal_block);
		fclose($fh);			
		
		if (($goal_block-$current_block)<=$BLOCKS_TO_NOTIFY)
		{
			$idconnection=mysql_connect($HOST, $USERNAME, $PASSWORD)
			or die("Connection BDD Impossible");	
			mysql_select_db($DB_NAME, $idconnection);
			
			notifyAll($idconnection);
					
			// Close DB
			mysql_close($idconnection);
		}
		else
		{
			$idconnection=mysql_connect($HOST, $USERNAME, $PASSWORD)
			or die("Connection BDD Impossible");	
			mysql_select_db($DB_NAME, $idconnection);
			
			clearNotifications($idconnection);
					
			// Close DB
			mysql_close($idconnection);
		}


	}
	

		// READ FILES
	$timestamp_current_block = intval(file_get_contents("time"));
	$average_sec_block = intval(file_get_contents("average_sec_block"));
	$current_block = intval(file_get_contents("current_block"));	
	$goal_block = intval(file_get_contents("goal_block"));	
	$bote = intval(file_get_contents("bote"));	

	echo intval((($goal_block - $current_block-1)*$average_sec_block + ($average_sec_block-$current_time+$timestamp_current_block))*10);
	
	
?>