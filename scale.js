scale = {
	readjust:function(){
		$('img').each(function(idx,item){
			if($(item).attr('data-src')){
				var width = parseInt($(item).width(),10);
				width = Math.floor(width * scale.getZoomRatio());

				$(item).attr('src','/img/scale/'+width+'/0'+$(item).attr('data-src'));
			}
		});
	},
	getZoomRatio:function(){
		var ratio = $(document).width() / window.innerWidth;

		if(isNaN(ratio))return 1;
		return ratio;
	},
	latestResizeRefresh:function(){

		if(scale.latestResize === null)setTimeout(scale.latestResizeCheck,scale.wait);

		scale.latestResize = new Date();

	},
	latestResizeCheck:function(){
		if(scale.latestResize !== null){
			if(scale.latestResize.getTime() + scale.wait < new Date().getTime()){
				scale.readjust();

				scale.latestResize = null;
			}else{
				setTimeout(scale.latestResizeCheck,scale.wait);
			}
		}
	},
	wait:1000,
	latestResize:null
};

$(window).load(scale.readjust);
$(window).resize(scale.latestResizeRefresh);

$(window).hammer().on("pinchin",scale.latestResizeRefresh);
$(window).hammer().on("pinchout",scale.latestResizeRefresh);

$(window).hammer().on("pinch",scale.latestResizeRefresh);