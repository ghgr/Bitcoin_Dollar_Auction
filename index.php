<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<script language="Javascript" type="text/javascript" src="js/jquery-1.4.1.js"></script>
	<script language="Javascript" type="text/javascript" src="js/jquery.lwtCountdown-1.0.js"></script>
	<script language="Javascript" type="text/javascript" src="js/misc.js"></script>
	<link rel="Stylesheet" type="text/css" href="style/main.css"></link>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<title>Bitcoin Dollar Bet</title>
	
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33443087-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head> 

<!--
/*
     This script downloaded from www.JavaScriptBank.com
     Come to view and download over 2000+ free javascript at www.JavaScriptBank.com
*/
-->
<body>
	<?php 
		require_once("./globalVariables.php"); 
		require_once("./infoFunctions.php"); 
	?>
	
	<div id="container">

		<h1>Bitcoin Dollar Bet</h1>
		<h2>
		CURRENT POT
		<font color=red size=6>
		<?php echo getBote(); ?> BTC		
		</font>
		<h2>
		<h3 class="subtitle">Approximate* time left
		(exactly
		<?php
			echo intval(getGoalBlock()-getCurrentBlock());
		?>
		 blocks)
		</h3>

		<!-- Countdown dashboard start -->
		
		<div id="countdown_dashboard">
			
			<div class="dash hours_dash">
				<span class="dash_title">hours</span>
				<div class="digit">-</div>
				<div class="digit">-</div>
			</div>

			<div class="dash minutes_dash">
				<span class="dash_title">minutes</span>
				<div class="digit">-</div>
				<div class="digit">-</div>
			</div>

			<div class="dash seconds_dash">
				<span class="dash_title">seconds</span>
				<div class="digit">-</div>
				<div class="digit">-</div>
			</div>			
			
			<div class="dash dseconds_dash">
				<span class="dash_title">cent</span>				
				<div class="digit">-</div>
				<div class="digit">-</div>				
			</div>
			
			<img src='./QRcode.png'/>

		</div>

		<!-- Countdown dashboard end -->

		<div class="dev_comment">

			In order to participate, send 1 BTC to 
			<?php echo $ADDRESS; ?>.												
		</div>

		*If the address stays <?php echo $INCREASE_BLOCK; ?> blocks (approximately <?php echo intval($INCREASE_BLOCK*10); ?> minutes) with no transactions, the prize is shared among the participants in the last block. Hence the time is *approximate*. Please understand <a href='http://www.bitcoin.org'><i>how Bitcoin works</i></a>.		
		<br/>
		<br/>

		
			<br/>
		In order to be notified when the timer is about to expire, write your email here.
		<div class="subscribe">
			<form action="/subscribe.php" method="GET" id="subscribe_form">
				<input type="text" name="email" id="email_field" class="faded" value="your@email.com" /> <input type="submit" id="subscribe_button" value="Stay updated" />
			</form>
		</div>

		<script language="javascript" type="text/javascript">

		
setInterval("$('#countdown_dashboard').sync();", 5000);
$.get("http://www.bitcoindollarbet.com/getTime.php", function(response) { 
		// In decims of second!
		jQuery(document).ready(function() {
				$('#countdown_dashboard').countDown(response);});
	});
	
	
				$('#email_field').focus(email_focus).blur(email_blur);
				$('#subscribe_form').bind('submit', function() { 
						var mail = $('#email_field').val(); 
						$.get("./sendMail/subscribe.php?email="+mail, function(response) {
							if (response==1)
							{
								alert("Thanks. You will be notified.");
							}else
							{
								alert("Your email is already in the database.");							
							}
						});
						return false; 
					
					});
			
		</script>
Your email will be used to inform you some minutes before the end of the timer. It will NEVER be used for any other purpose. In every email there will be an <i>Unsubscribe</i> link.
<br/><br/>
		The counter is just a display and its information is orientative. The actual data is directly extracted from the blockchain. Thus, if for some reason the counter is not working properly (i.e. stopped) it <b>will not</b> affect the bets nor the pot. Happy betting and <b> good luck! </b>.
	</div>
		
	<h2>Last participants (complete list <a href='http://blockexplorer.com/address/<?php echo $ADDRESS; ?>'> here</a>) </h2>
	
<?php
	listPayments(10);
?>


</body>

</html>