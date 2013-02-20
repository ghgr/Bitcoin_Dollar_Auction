<?php
	
	$ADDRESS = "address_to_receive_payments";
	$INCREASE_BLOCK = 101;	
	$UPDATE_AFTER_THESE_SECONDS = 300 ;			
	$MIN_BET = 1;

	$HOST = "localhost";
	$USERNAME = "bitcoind_user";
	$PASSWORD = "bitcoind_pass";
	$DB_NAME = "bitcoind_database_name";
	//$HOST = "localhost";
	//$USERNAME = "root";
	//$PASSWORD = "root";
	
	$BLOCKS_TO_NOTIFY = 3; // Notify when 3 blocks from give pot
	
	$BLOCKCHAIN_JSON="http://blockchain.info/address/$ADDRESS?format=json";

	$MESSAGE_EMAIL = "The bote is about to expire. JUST 10 minutes!! "; 
	$PORCENTAJE_QUEDA_BOTE = 0.8;
	
	/* EMAIL PARAMS*/
	$EMAIL_HOST = '';
	$EMAIL_FROM = '';
	$EMAIL_SUBJECT = "The pot is about to expire!\n";
	$EMAIL_USERNAME = '';
	$EMAIL_PASSWORD = '';
	$EMAIL_PORT = 465;
		
	
?>
