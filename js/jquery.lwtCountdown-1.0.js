/*
     This script downloaded from www.JavaScriptBank.com (the modified)
     Come to view and download over 2000+ free javascript at www.JavaScriptBank.com
*/


var global_diffDSecs;

(function($){

	$.fn.countDown = function (diffDSecs) {
		global_diffDSecs = diffDSecs;
		$('#' + $(this).attr('id') + ' .digit').html('<div class="top"></div><div class="bottom"></div>');
		$(this).doCountDown($(this).attr('id'));
		
		return this;

	};

	$.fn.sync = function () {
		
		$.get("http://www.bitcoindollarbet.com/getTime.php", function(response) { 					
				    global_diffDSecs=response; 				
				});
		
	};
	

	$.fn.doCountDown = function (id) {
		$this = $('#' + id);


		if (global_diffDSecs <= 0)
		{
			global_diffDSecs = 0;

		}
		
		dsecs = global_diffDSecs % 10;
		secs = Math.floor(global_diffDSecs/10) % 60;
		mins = Math.floor(global_diffDSecs/600)%60;
		hours = Math.floor(global_diffDSecs/600/60);
		

		$this.dashChangeTo(id, 'dseconds_dash', dsecs*10);
		$this.dashChangeTo(id, 'seconds_dash', secs);
		$this.dashChangeTo(id, 'minutes_dash', mins);
		$this.dashChangeTo(id, 'hours_dash', hours);
		

		$.data($this[0], 'global_diffDSecs', global_diffDSecs);
		
		e = $this;
		t = setTimeout(function() { global_diffDSecs = global_diffDSecs-1; e.doCountDown(id) },100 );
		$.data(e[0], 'timer', t);

	};

	$.fn.dashChangeTo = function(id, dash, n) {
		  $this = $('#' + id);
		 
		  for (var i=($this.find('.' + dash + ' .digit').length-1); i>=0; i--)
		  {
				var d = n%10;
				n = (n - d) / 10;
				$this.digitChangeTo('#' + $this.attr('id') + ' .' + dash + ' .digit:eq('+i+')', d);
		  }
	};

	$.fn.digitChangeTo = function (digit, n) {
	
		if ($(digit + ' div.top').html() != n + '')
		{

			$(digit + ' div.top').css({'display': 'none'});
			$(digit + ' div.top').html((n ? n : '0'));

			
			$(digit + ' div.bottom').html($(digit + ' div.top').html());
			$(digit + ' div.bottom').css({'display': 'block', 'height': ''});
		
		}
	};

})(jQuery);

