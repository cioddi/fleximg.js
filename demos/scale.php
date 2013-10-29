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
	<link rel="stylesheet" href="assets/main.css" />
</head>
<body>
	<section id="demo">
			<p class="center">Drag the slider to scale the image. This will simulate a request.</p>

			<table>
				<tbody>
					<tr>
				    <th>Requests</th>
				    <th>Dimension</th>
				    <th>Size</th>
				  </tr>
				  <tr>
				    <td id="display_request_counter">0</td>
				    <td id="display_resolution"></td>
				    <td id="display_filesize"></td>
				  </tr>
				</tbody>
			</table>

			<input id="slider" type="range" name="points" min="1" max="100" value="20">

			<img id="img_1" data-src="/img/test.jpg" class="block_center" style="width:20%;">
		</section>

	<script src="../bower_components/json3/lib/json3.min.js"></script>
	<script src="assets/jquery.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
	<script src="../bower_components/hammerjs/dist/jquery.hammer.js"></script>
	<script src="../fleximg.js"></script>
	<script>
		fleximg_js.init();

	  $(function() {
	    $( "#slider" ).on('change',function(){
	    		$('#img_1').css('width',$( "#slider" ).val()+'%');

	    		fleximg_js.refresh();

	    	});
	  });

	  // refreshCounter = function(){
	  // 	setTimeout(function(){
	  // 		if(lastSrc !== $('#img_1').attr('src'))request_counter = request_counter + 1;
	  // 		$('#display_request_counter').html(request_counter);
	  // 		lastSrc = $('#img_1').attr('src');
  	// 	},2000);
	  // }

	  lastSrc = '';
	  request_counter = 0;

	  // refreshCounter();

	  function displayImageResolution(el) {
			var t = new Image();
			t.src = $(el).attr('src');
			setTimeout(function(){
	  		$('#display_resolution').html(t.width + 'px x ' + t.height + 'px');
			},100)
		}

		function displayImageFilesize(src){
			var xhr = new XMLHttpRequest();
			xhr.open('HEAD', src, true);
			xhr.onreadystatechange = function(){
			  if ( xhr.readyState == 4 ) {
			    if ( xhr.status == 200 ) {
			      $('#display_filesize').html((xhr.getResponseHeader('Content-Length')/1000 + ' kb'));
			    }
			  }
			};
			xhr.send(null);
		}

	  $('#img_1').on('load',function(ev){
	  	console.log(ev);
			request_counter = request_counter + 1;
  		$('#display_request_counter').html(request_counter);

  		displayImageResolution($('#img_1')[0]);

  		displayImageFilesize($('#img_1').attr('src'));
	  });

	</script>
</body>
</html>