scale = {
	readjust:function(){
		$('img').each(function(idx,item){
			if($(item).attr('data-src')){
				$(item).attr('src','/img/scale/'+$(item).width()+'/0'+$(item).attr('data-src'));
			}
		});
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
