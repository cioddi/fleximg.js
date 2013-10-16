<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Fleximg.js open source responsive image loader</title>
	<style>
		body{
			font-family: sans-serif;
		}
		.block_center{
			margin: 0 auto;
			display: block;
			margin-top: 30px;
		}
		.text_center{
			text-align: center;
		}
		.img_1{
			width: 20%;
		}
		#slider,#slider_display{
			width: 20%;
			max-width: 300px;
			min-width: 200px;
			text-align: center;
		}
	</style>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
</head>
<body>
	<div id="slider" class="block_center"></div>
	<div id="slider_display" class="block_center"><span class="value">20</span> %</div>
	<div class="text_center"><p>Image requests: <span class="request_counter">0</span></p></div>
	<img id="img_1" data-src="/img/test.jpg" class="img_1 block_center" >

	<script src="/bower_components/jquery/jquery.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script src="/bower_components/hammerjs/dist/jquery.hammer.js"></script>
	<script src="/scale.js"></script>
	<script>
		scale.init();

	  $(function() {
	    $( "#slider" ).slider({
	    	max:100,
	    	min:1,
	    	value:20,
	    	slide:function(event,ui){
	    		$('#slider_display > .value').html(ui.value);
	    		$('.img_1').css('width',ui.value+'%');

	    		scale.latestResizeRefresh();

	    		refreshCounter();
	    	}
	    });
	  });

	  refreshCounter = function(){
	  	setTimeout(function(){
	  		if(lastSrc !== $('.img_1').attr('src'))request_counter = request_counter + 1;
	  		$('.request_counter').html(request_counter);
	  		lastSrc = $('.img_1').attr('src');
  		},2000);
	  }

	  lastSrc = '';
	  request_counter = 0;

	  refreshCounter();

	  setWidth = function(value){
	  	$('.img_1').css('width',value+'px');
	    scale.latestResizeRefresh();
	  }

	</script>
</body>
</html>