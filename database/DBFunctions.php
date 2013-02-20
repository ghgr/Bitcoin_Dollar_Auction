<?php

	require_once ('./globalVariables.php');

	

function getNewElementsFromBlockChain($my_address,$minimum_bet)
{

	global $BLOCKCHAIN_JSON, $PORCENTAJE_QUEDA_BOTE;

	$data_raw = file_get_contents($BLOCKCHAIN_JSON);

	$info_address = json_decode($data_raw,true);

	$new_elements = array();

	
	// Iff new bote is bigger (or equal)
	$bote = intval(floatval($info_address["final_balance"])*0.00000001 * $PORCENTAJE_QUEDA_BOTE);

	if ($bote>=intval(file_get_contents("../bote")))
	{
		$myFile = "bote";
		$fh = fopen($myFile, 'w') or die("can't open file");
		fwrite($fh, $bote);
		fclose($fh);			
	}

	foreach( $info_address["txs"] as $transaction )
	{

		// FROM
		$from = $transaction["inputs"][0]["prev_out"]["addr"];

		// VALUE
		$total_qty=0;
		foreach( $transaction["out"] as $out)
		{
			if ($out["addr"]==$my_address)
			{
				$total_qty += $out["value"];
			}
		}
	
		//BLOCK NUM
		$block = $transaction["block_height"];

		if (($total_qty/100000000)>=$minimum_bet)
		{
			$new_elements[]=array("address" => $from,"block" =>$block);			
		}

	}

	return $new_elements;


}

function addElementsToDB($idconnection,$increment_to_block_obj, $my_address,$minimum_bet)
{

	
	// Get max block_found
	$Query="Select max(block_found) From bote WHERE lost<>1";
	$Res = mysql_query($Query, $idconnection);
	$elem = mysql_fetch_array($Res);
	
	if ($elem[0]==NULL) { $max_block_found=0;}
	else {$max_block_found=$elem[0];}	

	// Get new elements from blockexplorer
	$new_elements = getNewElementsFromBlockChain($my_address,$minimum_bet);	

	// Insert elements bigger than current max
	// $new_elements[i]= array( ["address"]["block"])
	foreach ($new_elements as $element)
	{
		if ($element["block"]>$max_block_found)
		{
		
			// Add this block
			mysql_query("INSERT INTO bote (address,block_found,block_obj) VALUES('".$element["address"]."',".$element["block"].",".strval($element["block"]+$increment_to_block_obj).") ") 
			or die(mysql_error()); 
		}
	}
	
}



function updateWinners($idconnection,$current_block)
{

	$winner = false;
	
	// Save all ["id","block_found","block_obj"] of all elements where lost = -1
	$Query="Select * From bote WHERE lost=-1";
	$Res = mysql_query($Query, $idconnection);

	
	$candidates = array();
	while ($elem = mysql_fetch_array($Res))
	{
		$candidates[]=array("id"=> $elem["id"],"block_found"=> intval($elem["block_found"]),"block_obj"=> intval($elem["block_obj"]) );
	}



	foreach ($candidates as $elem)
	{
		// Default win, ($lost = 0)
		$temp_lost=0;
		foreach($candidates as $elem2)
		{
			if ($elem<>$elem2) // Not the same
			{
				if ($elem2["block_found"]<$elem["block_obj"] and $elem2["block_found"]>$elem["block_found"])
				{
					// ** losing condition **
					$temp_lost=1;	
				}
			}
		}
		
		// If we "won", it might be because current block is < block_obj
		// In that case, leave lost=-1
	
		if (!($temp_lost==0 and $elem["block_obj"]>$current_block))
		{
			// Update views 
			mysql_query("UPDATE bote SET lost = ".$temp_lost." WHERE id=".$elem["id"])
			or die(mysql_error());  

			if ($temp_lost==0) { $winner = true; }
		}
	}

	return $winner; 

}



?>

