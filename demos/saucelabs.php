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
		.img_1{
			width: 10%;
		}
		#slider,#slider_display{
			width: 20%;
			max-width: 300px;
			min-width: 200px;
			text-align: center;
		}
		#img_2{
			width: 400px;
		}
	</style>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
</head>
<body>
	<div id="slider" class="block_center"></div>
	<div id="slider_display" class="block_center"><span class="value">10</span> %</div>
	<div id="set_width_500" onclick="setWidth(500)" class="block_center">set fixed width</div>
	<img id="img_1" data-src="/img/test.jpg" class="img_1 block_center" >

	<img id="img_2" data-src="/img/test.jpg" class="block_center" >

	<script src="assets/jquery.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script src="../bower_components/hammerjs/dist/jquery.hammer.js"></script>
	<script src="../fleximg.js"></script>
	<script>
		fleximg_js.init();

	  $(function() {
	    $( "#slider" ).slider({
	    	max:100,
	    	min:1,
	    	value:10,
	    	slide:function(event,ui){
	    		$('#slider_display > .value').html(ui.value);
	    		$('.img_1').css('width',ui.value+'%');

	    		fleximg_js.latestResizeRefresh();
	    	}
	    });
	  });

	  setWidth = function(value){
	  	$('.img_1').css('width',value+'px');
	    fleximg_js.refresh();
	  }

	</script>
</body>
</html>